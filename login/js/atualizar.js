document.getElementById("update-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Impede o envio padrão do formulário

    // Coletar os valores dos campos
    const name = document.getElementById("new-name").value;
    const email = document.getElementById("new-email").value;
    const phone = document.getElementById("new-phone").value;

    // Enviar os dados via POST para o PHP
    fetch("atualizar_usuario.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ name, email, phone }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Informações atualizadas com sucesso!");
            // Atualizar os elementos na página
            document.getElementById("name").textContent = name;
            document.getElementById("email").textContent = email;
            document.getElementById("phone").textContent = phone;
            document.getElementById("full-name").textContent = name;

            // Limpar os campos do formulário
            document.getElementById("update-form").reset();
        } else {
            alert("Erro ao atualizar: " + data.message);
        }
    })
    .catch(error => console.error("Erro:", error));
});