document.getElementById('logout-button').addEventListener('click', function() {
    fetch('logout.php')
        .then(() => {
            window.location.href = 'login.html'; // Redirecionar para a página de login
        });
});
