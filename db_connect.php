<?php
// Relatar erros de conexão
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cadastro_db";

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}
?>