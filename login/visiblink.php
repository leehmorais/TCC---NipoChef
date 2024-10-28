<script>
document.addEventListener('DOMContentLoaded', function() {
    const usuarioLogado = <?php echo json_encode(isset($_SESSION['usuario_logado'])); ?>;
    const accountLink = document.getElementById('accountLink');

    if (accountLink) { // Verifica se o elemento existe
        if (usuarioLogado) {
            accountLink.setAttribute('href', '../suaconta.php'); // Altera para o link da página de conta
            accountLink.textContent = 'Sua conta'; // Altera o texto
        } else {
            accountLink.textContent = 'Faça login para acessar sua conta';
            accountLink.style.cursor = 'not-allowed';
            accountLink.addEventListener('click', function(event) {
                event.preventDefault(); // Previne o clique se não estiver logado
            });
        }
    }
});
</script>