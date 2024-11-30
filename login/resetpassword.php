<?php
require '../db_connect.php'; // Certifique-se de que o caminho está correto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Verificar se as senhas coincidem
    if ($password !== $confirm_password) {
        echo "<script>alert('As senhas não coincidem.'); window.location.href='resetpass.html';</script>";
        exit();
    }

    // Validação da senha
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        echo "<script>alert('A senha não atende aos requisitos mínimos.'); window.location.href='resetpass.html';</script>";
        exit();
    }

    // Verificar se o email existe no banco de dados
    $stmt = $conn->prepare("SELECT email FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('Email não encontrado.'); window.location.href='resetpass.html';</script>";
        exit();
    }

    // Se o email existe, atualizar a senha
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("UPDATE usuarios SET senha = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashedPassword, $email);

    if ($stmt->execute()) {
        echo "<script>alert('Senha alterada com sucesso!'); window.location.href='login.php';</script>";
        exit();
    } else {
        echo "<script>alert('Erro ao alterar a senha. Tente novamente mais tarde.'); window.location.href='resetpass.html';</script>";
        exit();
    }
}
?>