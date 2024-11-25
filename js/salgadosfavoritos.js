$(document).ready(function() {
  const localStorageKey = 'salgadosFavoritos';

  // Carrega os favoritos ao iniciar
  loadFavorites();

  // Ao clicar no botão de favorito
  $('.favorite-button').on('click', function() {
      const recipeName = $(this).closest('.card').find('.card-title').text();
      let favorites = JSON.parse(localStorage.getItem(localStorageKey)) || [];

      // Verifica se a receita já está marcada como favorita
      if ($(this).hasClass('favorited')) {
          $(this).removeClass('favorited').text('⭐ Marcar como favorito');
          favorites = favorites.filter(item => item !== recipeName); // Remove da lista
      } else {
          $(this).addClass('favorited').text('✅ Favoritado');
          favorites.push(recipeName); // Adiciona à lista
      }

      // Salva os favoritos no localStorage
      localStorage.setItem(localStorageKey, JSON.stringify(favorites));
      updateFavoritesList(favorites);
  });

  // Carrega os favoritos e atualiza a interface
  function loadFavorites() {
      let favorites = JSON.parse(localStorage.getItem(localStorageKey)) || [];
      const currentRecipeTitles = $('.card-title').map(function() {
          return $(this).text();
      }).get();

      // Filtra os favoritos para remover itens que não estão mais disponíveis
      favorites = favorites.filter(recipe => currentRecipeTitles.includes(recipe));
      localStorage.setItem(localStorageKey, JSON.stringify(favorites));

      // Atualiza os botões de favorito
      $('.favorite-button').each(function() {
          const recipeName = $(this).closest('.card').find('.card-title').text();
          if (favorites.includes(recipeName)) {
              $(this).addClass('favorited').text('✅ Favoritado');
          }
      });

      updateFavoritesList(favorites);
  }

  // Atualiza a lista de favoritos na interface
  function updateFavoritesList(favorites) {
      const favoritesList = $('#favorites-list');
      favoritesList.empty();
      if (favorites.length === 0) {
          favoritesList.append('<li>Você ainda não tem favoritos.</li>');
      } else {
          favorites.forEach(recipe => {
              favoritesList.append('<li>' + recipe + '</li>');
          });
      }
  }

  // Limpa os favoritos
  $('#clear-favorites').on('click', function() {
      localStorage.removeItem(localStorageKey);
      alert('Favoritos limpos!');
      loadFavorites();
  });
});