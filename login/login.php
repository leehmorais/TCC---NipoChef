<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cadastro_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo "<script>alert('Conexão falhou: " . addslashes($conn->connect_error) . "'); 
    window.history.back();</script>";
    exit;
}
$email = $_POST['email'];
$senha = $_POST['senha'];
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "<script>alert('Erro na preparação da consulta SQL: " . addslashes($conn->error) . "'); 
    window.history.back();</script>";
    exit;
}
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($senha, $row['senha'])) {
        $_SESSION['user'] = [
            'name' => $row['nome_completo'],
            'email' => $row['email'],
            'phone' => $row['telefone']
        ];
        $_SESSION['usuario_logado'] = true;
        // Criar e configurar o cookie de token de sessão (expira em 30 dias)
        $token = bin2hex(random_bytes(64));
        setcookie('user_token', $token, time() + (86400 * 30), "/"); // Expira em 30 dias
        // Redireciona para suaconta.php
        header("Location: suaconta.php");
        exit();
    } else {
        echo "<script>alert('Senha incorreta.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Email não encontrado.'); window.history.back();</script>";
}
$stmt->close();
$conn->close();
?>