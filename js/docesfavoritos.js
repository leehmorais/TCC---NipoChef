$(document).ready(function() {
    const localStorageKey = 'docesFavoritos';
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
        var currentRecipeTitles = $('.card-title').map(function() {
            return $(this).text();
        }).get(); // Obtém os títulos das receitas atualmente na página

        // Filtra os favoritos para remover aqueles que não existem mais
        favorites = favorites.filter(function(recipe) {
            return currentRecipeTitles.includes(recipe);
        });

        // Atualiza o localStorage com a lista filtrada
        localStorage.setItem('favorites', JSON.stringify(favorites));

        // Marca os itens já favoritados
        $('.favorite-button').each(function() {
            var recipeName = $(this).closest('.card').find('.card-title').text();
            if (favorites.includes(recipeName)) {
                $(this).addClass('favorited').text('✅ Favoritado');
            }
        });

        // Atualiza a lista de favoritos exibida
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

    $(document).ready(function() {
        $('#clear-favorites').on('click', function() {
            localStorage.removeItem('favorites'); // Remove apenas os favoritos
            // ou localStorage.clear(); // Remove tudo do localStorage
            alert('Favoritos limpos!');
            loadFavorites(); // Atualiza a lista de favoritos na interface
        });
    });
});