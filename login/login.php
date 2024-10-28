<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cadastro_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Conexão falhou: " . $conn->connect_error]);
    exit;
}

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
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

        // Criar um token aleatório e salvar no banco de dados
        $token = bin2hex(random_bytes(64));
        setcookie('user_token', $token, time() + (86400 * 30), "/"); // O cookie expira em 30 dias

        // Atualizar o banco de dados com o token
        $update_token_sql = "UPDATE usuarios SET token = ? WHERE email = ?";
        $update_stmt = $conn->prepare($update_token_sql);
        $update_stmt->bind_param("ss", $token, $email);
        $update_stmt->execute();

        echo json_encode(["success" => true, "message" => "Login bem-sucedido!", "redirect" => "suaconta.php"]);
    } else {
        echo json_encode(["success" => false, "message" => "Senha incorreta."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Email não encontrado."]);
}

$stmt->close();
$conn->close();
?>
