<?php
require '../db_connect.php'; // Certifique-se de que o caminho está correto

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Verificar se o email existe no banco de dados
    $stmt = $conn->prepare("SELECT email FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('Email não encontrado.'); window.location.href='forgotpass.html';</script>";
        exit();
    }

    // Redirecionar para a página de redefinir senha, passando o email via GET
    header("Location: resetpass.html?email=" . urlencode($email));
    exit();
}
?>