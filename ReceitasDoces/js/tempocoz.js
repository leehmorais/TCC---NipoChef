 // Função para carregar os comentários
 function loadComments() {
      $.get("/carregar-comentarios", function(data) {
          $("#comments").empty(); // Limpa os comentários antigos
          $.each(data.comentarios, function(index, comment) {
             $("#comments").append("<p>" + comment.texto + "</p>");
        });
    });
}

$(document).ready(function() {
 // Carrega os comentários ao iniciar a página
  loadComments();

// Envio do comentário
$("#submit-comment").click(function() {
    var comment = $("#comment-text").val();
    if (comment.trim() === "") {
        alert("O comentário não pode estar vazio!");
        return;
    }

    $.post("/enviar-comentario", { comentario: comment }, function(response) {
        $("#comments").append("<p>" + response.comentario + "</p>");
        $("#comment-text").val(""); // Limpa o campo de texto
    }).fail(function() {
        alert("Erro ao enviar o comentário. Tente novamente.");
    });
});
});