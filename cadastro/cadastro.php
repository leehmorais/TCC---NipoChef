<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cadastro_db";
// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);
// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $number = trim($_POST['number']);
    $password = trim($_POST['password']);
    $confirmpassword = trim($_POST['Confirmpassword']);
    // Verifica se as senhas coincidem
    if ($password !== $confirmpassword) {
        echo "<script>alert('As senhas não coincidem.'); window.history.back();</script>";
        exit();
    }
    // Verifica se o email já está cadastrado
    $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    if ($count > 0) {
        echo "<script>alert('Este e-mail já está cadastrado.'); window.history.back();</script>";
        exit();
    }
    $stmt->close();
    // Hash da senha
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // Usando prepared statement para inserir
    $stmt = $conn->prepare("INSERT INTO usuarios (nome_completo, telefone, email, senha) VALUES (?, ?, ?, ?)");
    $nome_completo = "$firstname $lastname";
    $stmt->bind_param("ssss", $nome_completo, $number, $email, $hashed_password);

    if ($stmt->execute()) {
        header("Location: ../cadastro/sucessocadastro.html");
        exit();
    } else {
        echo "<script>alert('Erro ao cadastrar.'); window.history.back();</script>";
    }

    $stmt->close();
}
$conn->close();
?>     