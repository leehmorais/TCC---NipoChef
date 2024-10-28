$(document).ready(function() {
    // Carrega os favoritos do localStorage ao iniciar
    loadFavorites();

    // Ao clicar no botão de favorito
    $('.favorite-button').on('click', function() {
        var recipeName = $(this).closest('.card').find('.card-title').text();
        var favorites = JSON.parse(localStorage.getItem('favorites')) || [];

        // Verifica se a receita já está marcada como favorita
        if ($(this).hasClass('favorited')) {
            $(this).removeClass('favorited').text('⭐ Marcar como favorito');
            // Remove da lista de favoritos
            favorites = favorites.filter(item => item !== recipeName);
        } else {
            $(this).addClass('favorited').text('✅ Favoritado');
            // Adiciona à lista de favoritos
            favorites.push(recipeName);
        }

        // Salva os favoritos no localStorage
        localStorage.setItem('favorites', JSON.stringify(favorites));
        // Atualiza a lista de favoritos
        updateFavoritesList(favorites);
    });

    // Carrega os favoritos da localStorage e marca os itens já favoritados
    function loadFavorites() {
        var favorites = JSON.parse(localStorage.getItem('favorites')) || [];
        $('.favorite-button').each(function() {
            var recipeName = $(this).closest('.card').find('.card-title').text();
            if (favorites.includes(recipeName)) {
                $(this).addClass('favorited').text('✅ Favoritado');
            }
        });
        updateFavoritesList(favorites);
    }

    // Atualiza a lista de favoritos na seção de favoritos
    function updateFavoritesList(favorites) {
        var favoritesList = $('#favorites-list');
        favoritesList.empty();
        if (favorites.length === 0) {
            favoritesList.append('<li>Você ainda não tem favoritos.</li>');
        } else {
            favorites.forEach(function(recipe) {
                favoritesList.append('<li>' + recipe + '</li>');
            });
        }
    }
});
