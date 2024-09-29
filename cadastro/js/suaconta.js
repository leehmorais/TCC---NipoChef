document.getElementById('update-form').addEventListener('submit', function(event) {
    event.preventDefault();
    alert('Informações atualizadas com sucesso!');
});

document.getElementById('password-form').addEventListener('submit', function(event) {
    event.preventDefault();
    alert('Senha atualizada! Um e-mail de confirmação foi enviado.');
});

document.getElementById('logout-button').addEventListener('click', function() {
    alert('Você saiu da conta.');
});
