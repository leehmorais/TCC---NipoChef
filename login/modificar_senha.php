<?php
session_start();
require '../db_connect.php';

header('Content-Type: application/json');

// Verifica se o cookie de autenticação existe
if (!isset($_COOKIE['user_token'])) {
    echo json_encode(["status" => "error", "message" => "Token de autenticação não encontrado."]);
    exit();
}

// Valida a presença da sessão e do cookie
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    echo json_encode(["status" => "error", "message" => "Usuário não autenticado."]);
    exit();
}

// Dados do usuário armazenados na sessão
$userName = $_SESSION['user']['name'];
$userEmail = $_SESSION['user']['email'];
$userPhone = $_SESSION['user']['phone'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = trim($_POST['current_password'] ?? '');
    $newPassword = trim($_POST['new_password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');

    try {
        // Validações
        if ($newPassword !== $confirmPassword) {
            throw new Exception("A nova senha e a confirmação não coincidem.");
        }

        if (strlen($newPassword) < 6) {
            throw new Exception("A nova senha deve ter pelo menos 6 caracteres.");
        }

        // Consulta a senha atual no banco
        $stmt = $conn->prepare("SELECT senha FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $userEmail); // Usar email como identificador
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            throw new Exception("Usuário não encontrado.");
        }

        $stmt->bind_result($dbPassword);
        $stmt->fetch();

        if (!password_verify($currentPassword, $dbPassword)) {
            throw new Exception("A senha atual está incorreta.");
        }

        // Atualiza a senha
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE usuarios SET senha = ? WHERE email = ?");
        $stmt->bind_param("ss", $newPasswordHash, $userEmail);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Senha atualizada com sucesso."]);
        } else {
            throw new Exception("Erro ao atualizar a senha.");
        }

        $stmt->close();

    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    } finally {
        $conn->close();
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método de requisição inválido."]);
}
?>