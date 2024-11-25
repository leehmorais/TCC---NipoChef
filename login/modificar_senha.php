<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

ini_set('display_errors', 0); // Não exibir erros
ini_set('log_errors', 1); // Logar erros no arquivo do servidor
error_reporting(E_ALL); // Continuar reportando todos os erros

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    echo json_encode([
        'status' => 'error',
        'message' => "Erro interno: $errstr em $errfile na linha $errline."
    ]);
    exit;
});

require_once '../db_connect.php'; // Conexão com o banco de dados

if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não autenticado.']);
    exit;
}

// Obtendo o email do usuário autenticado
$user_email = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : null;
if (!$user_email) {
    echo json_encode(['status' => 'error', 'message' => 'Não foi possível obter o email do usuário.']);
    exit;
}

// Obtendo os dados do formulário
$current_password = isset($_POST['current_password']) ? trim($_POST['current_password']) : null;
$new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : null;
$confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : null;

// Validação básica
if (!$current_password || !$new_password || !$confirm_password) {
    echo json_encode(['status' => 'error', 'message' => 'Todos os campos são obrigatórios.']);
    exit;
}

// Verificar se as novas senhas coincidem
if ($new_password !== $confirm_password) {
    echo json_encode(['status' => 'error', 'message' => 'A nova senha e a confirmação não correspondem.']);
    exit;
}

// Verificar a senha atual no banco de dados
$stmt = $conn->prepare("SELECT senha FROM usuarios WHERE email = ?");
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao preparar a consulta SQL.']);
    exit;
}

$stmt->bind_param("s", $user_email);
$stmt->execute();
$stmt->bind_result($hashed_password);
$stmt->fetch();
$stmt->close();

if (!$hashed_password) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não encontrado ou senha não definida no banco de dados.']);
    exit;
}

// Validar a senha atual
if (!password_verify($current_password, $hashed_password)) {
    echo json_encode(['status' => 'error', 'message' => 'A senha atual está incorreta.']);
    exit;
}

// Hash da nova senha
$new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Atualizar a senha no banco de dados
$stmt = $conn->prepare("UPDATE usuarios SET senha = ? WHERE email = ?");
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao preparar a consulta de atualização.']);
    exit;
}

$stmt->bind_param("ss", $new_hashed_password, $user_email);

if ($stmt->execute()) {
    // Enviar e-mail de confirmação
    $to = $user_email;
    $subject = "Confirmação de Alteração de Senha";
    $message = "Olá,\n\nSua senha foi alterada com sucesso.\n\nSe você não solicitou esta alteração, entre em contato conosco imediatamente.";
    $headers = "From: no-reply@nipochef.com\r\n";
    $headers .= "Reply-To: suporte@nipochef.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['status' => 'success', 'message' => 'Senha atualizada com sucesso. Um e-mail de confirmação foi enviado.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Senha atualizada, mas houve um problema ao enviar o e-mail de confirmação.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar a senha no banco de dados.']);
}

echo json_encode(['status' => 'success', 'message' => 'Testando saída JSON']);
exit;

$stmt->close();
$conn->close();
?>