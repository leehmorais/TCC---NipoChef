document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('resetPasswordForm');

    form.addEventListener('submit', async function (e) {
        e.preventDefault(); // Previne o envio tradicional

        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.textContent = "Alterando...";

        const emailConfirm = document.getElementById('email_confirm').value.trim();
        const newPassword = document.getElementById('password').value.trim();
        const confirmPassword = document.getElementById('confirm_password').value.trim();

        try {
            const response = await fetch('./resetpassword.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    email_confirm: emailConfirm,
                    password: newPassword,
                    confirm_password: confirmPassword,
                }),
            });

            if (!response.ok) {
                throw new Error(`Erro no servidor: ${response.status}`);
            }

            const contentType = response.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                throw new Error("Resposta do servidor não está em JSON.");
            }

            const result = await response.json();

            if (result.status === 'success') {
                alert(result.message);
                window.location.href = result.redirect; // Redireciona após sucesso
                return; // Impede qualquer execução posterior
            }

            alert(result.message); // Exibe mensagem de erro do servidor
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro inesperado. Por favor, tente novamente.');
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = "Alterar Senha";
        }
    });
});
