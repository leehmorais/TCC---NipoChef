document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Previne o envio padrão do formulário
        
        const formData = new FormData(this);

        fetch('login.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na resposta do servidor');
            }
            console.log(response.json());
            return response.json();
        })
        .then(data => {
            Swal.fire({
                title: data.success ? "Sucesso!" : "Erro!",
                text: data.message,
                icon: data.success ? "success" : "error",
                confirmButtonText: "OK"
            }).then(() => {
                if (data.success) {
                    window.location.href = data.redirect; // Redireciona para a página de conta
                }
            });
        })
        .catch(error => {
            console.error('Erro ao processar o login:', Error);
            //Swal.fire("Erro!", "Ocorreu um erro ao processar o login. Verifique o console para mais detalhes.", "error");
        });
    });
});
