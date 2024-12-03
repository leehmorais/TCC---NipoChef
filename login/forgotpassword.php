<?php
require '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT email FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('Email não encontrado.'); window.location.href='forgotpass.html';</script>";
        exit();
    }

    // Redireciona sem parâmetros sensíveis na URL
    echo "<script>window.location.href='resetpass.html';</script>";
    exit();
}
?>
