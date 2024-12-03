<?php
session_start();
require '../db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Método não permitido
    echo json_encode(["status" => "error", "message" => "Método de requisição inválido."]);
    exit();
}

$emailConfirm = trim($_POST['email_confirm'] ?? '');
$newPassword = trim($_POST['password'] ?? '');
$confirmPassword = trim($_POST['confirm_password'] ?? '');

try {
    // Validações
    if (empty($emailConfirm) || empty($newPassword) || empty($confirmPassword)) {
        throw new Exception("Todos os campos são obrigatórios.");
    }

    if ($newPassword !== $confirmPassword) {
        throw new Exception("A nova senha e a confirmação não coincidem.");
    }

    if (!filter_var($emailConfirm, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("E-mail inválido.");
    }

    if (strlen($newPassword) < 8) {
        throw new Exception("A senha deve ter no mínimo 8 caracteres.");
    }

    // Verifica se o e-mail existe no banco de dados
    $stmt = $conn->prepare("SELECT idusuarios FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $emailConfirm);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        throw new Exception("E-mail não encontrado.");
    }

    // Atualiza a senha no banco de dados
    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmtUpdate = $conn->prepare("UPDATE usuarios SET senha = ? WHERE email = ?");
    $stmtUpdate->bind_param("ss", $newPasswordHash, $emailConfirm);

    if ($stmtUpdate->execute()) {
        // Sucesso: Finalize o script imediatamente
        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "message" => "Senha atualizada com sucesso.",
            "redirect" => "../login/login.php"
        ]);
        exit();
    } else {
        throw new Exception("Erro ao atualizar a senha.");
    }
} catch (Exception $e) {
    http_response_code(400); // Bad Request
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    exit();
} finally {
    // Libera recursos do banco
    if (isset($stmt)) $stmt->close();
    if (isset($stmtUpdate)) $stmtUpdate->close();
    $conn->close();
}
?>
