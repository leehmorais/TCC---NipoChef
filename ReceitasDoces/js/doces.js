/* função para aumento da imagem ao passar o mouse por cima */
$(document).ready(function() {
    $(".doce-image").hover(
        function() {
            // Efeito ao passar o mouse (hover in)
            $(this).css("transform", "scale(1.1)");
            $(this).css("opacity", "1"); // Opcional: ajusta a opacidade
        },
        function() {
            // Efeito ao retirar o mouse (hover out)
            $(this).css("transform", "scale(1)");
            $(this).css("opacity", "1"); // Opcional: restaura a opacidade
        }
    );
});
