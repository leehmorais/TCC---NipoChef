document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Previne o envio padrão do formulário
    
    const formData = new FormData(this);

    fetch('login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        Swal.fire({
            title: data.success ? "Sucesso!" : "Erro!",
            text: data.message,
            icon: data.success ? "success" : "error",
            confirmButtonText: "OK"
        }).then(() => {
            if (data.success) {
                // Redirecionar para "Sua Conta"
                window.location.href = '../login/suaconta.php'; // Altere para o caminho correto
            }
        });
    })
    .catch(error => {
        console.error('Erro:', error);
        Swal.fire("Erro!", "Ocorreu um erro ao processar o login.", "error");
    });
});
