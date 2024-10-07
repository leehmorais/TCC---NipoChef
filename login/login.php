<?php
session_start(); // Inicia a sessão

$servername = "localhost";
$username = "root"; // Usuário padrão do XAMPP
$password = ""; // Senha padrão do XAMPP
$dbname = "cadastro_db"; // Nome do seu banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Conexão falhou: " . $conn->connect_error]));
}

// Obter dados do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Prepara a consulta SQL
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Verificar se o usuário existe e validar a senha
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Verificar a senha
    if (password_verify($senha, $row['senha'])) {
        // Salvar dados do usuário na sessão
        $_SESSION['user'] = [
            'name' => $row['nome_completo'], // Nome completo do usuário
            'email' => $row['email'],
            'phone' => $row['telefone'] // Presumindo que exista uma coluna 'telefone'
        ];
        echo json_encode(["success" => true, "message" => "Login bem-sucedido!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Senha incorreta."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Email não encontrado."]);
}

$stmt->close();
$conn->close();
?>
