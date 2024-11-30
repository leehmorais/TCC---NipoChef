document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('password-form');
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.textContent = "Atualizando...";

        const currentPassword = document.getElementById('current-password').value;
        const newPassword = document.getElementById('new-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        try {
            const response = await fetch('../login/modificar_senha.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    current_password: currentPassword,
                    new_password: newPassword,
                    confirm_password: confirmPassword
                })
            });            
        
            const textResult = await response.text();
            console.log('Resposta bruta recebida do servidor:', textResult);
        
            let result;
            try {
                result = JSON.parse(textResult);
            } catch (parseError) {
                throw new Error('Resposta inválida do servidor. Não é JSON.');
            }
        
            console.log('Resposta processada:', result);
        
            alert(result.message);
        
            if (result.status === 'success') {
                form.reset();
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Ocorreu um erro ao atualizar a senha. Verifique o console para mais detalhes.');
        }
         finally {
            submitButton.disabled = false;
            submitButton.textContent = "Atualizar Senha";
        }
    });
});
