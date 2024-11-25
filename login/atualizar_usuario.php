<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user'])) {
    echo json_encode(["success" => false, "message" => "Usuário não autenticado."]);
    exit();
}

// Coletar os dados enviados pelo JavaScript
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['name'], $data['email'], $data['phone'])) {
    $newName = $data['name'];
    $newEmail = $data['email'];
    $newPhone = $data['phone'];

    // Conexão ao banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cadastro_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        echo json_encode(["success" => false, "message" => "Erro na conexão ao banco de dados."]);
        exit();
    }

    // Atualizar informações no banco de dados
    $sql = "UPDATE usuarios SET nome_completo = ?, email = ?, telefone = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $currentEmail = $_SESSION['user']['email'];
    $stmt->bind_param("ssss", $newName, $newEmail, $newPhone, $currentEmail);

    if ($stmt->execute()) {
        // Atualizar informações na sessão
        $_SESSION['user'] = [
            "name" => $newName,
            "email" => $newEmail,
            "phone" => $newPhone
        ];
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao atualizar no banco de dados."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Dados incompletos."]);
}
?>