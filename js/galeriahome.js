// script.js
$(document).ready(function() {
    $('.gallery-item').on('click', function() {
        var src = $(this).attr('src');
        $('#img01').attr('src', src);
        $('#caption').text($(this).attr('alt'));
        $('#modal').fadeIn();
    });

    $('.close').on('click', function() {
        $('#modal').fadeOut();
    });

    // Fecha o modal quando o usuário clica fora da imagem
    $(window).on('click', function(event) {
        if ($(event.target).is('#modal')) {
            $('#modal').fadeOut();
        }
    });
});
