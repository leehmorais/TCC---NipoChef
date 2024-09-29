
$(document).ready(function() {
    // Carrega os favoritos do localStorage ao iniciar
    loadFavorites();

    $('.favorite-button').on('click', function() {
        var recipeName = $(this).closest('.card').find('.card-title').text();
        var favoritesList = $('#favorites-list');
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

    function loadFavorites() {
        var favorites = JSON.parse(localStorage.getItem('favorites')) || [];
        $('.favorite-button').each(function() {
            var recipeName = $(this).closest('.card').find('.card-title').text();
            if (favorites.includes(recipeName)) {
                $(this).addClass('favorited').text('✅ Favorito');
            }
        });
        updateFavoritesList(favorites);
    }

    function updateFavoritesList(favorites) {
        var favoritesList = $('#favorites-list');
        favoritesList.empty();
        favorites.forEach(function(recipe) {
            favoritesList.append('<li>' + recipe + '</li>');
        });
    }
});
