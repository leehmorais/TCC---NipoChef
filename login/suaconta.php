<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sua Conta - Site de Receitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/suaconta.css">
</head>
<body>
    <!--Logo abaixo temos o código do NavBar(Menu) onde tem todas as páginas do nosso site-->
    <nav class="navbar navbar-expand-lg bg-dark border-bottom border-body" data-bs-theme="dark">
     <div class="logotipo-navbar">
       <a href="../nipochef.html" class="logo">
         <img src="../images/logo/logoNipo.png" alt="Logotipo">
       </a>
     </div>

   <div class="container-fluid">
     <a class="navbar-brand" href="../home.html">NipoChef</a>
     <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
       <span class="navbar-toggler-icon"></span>
     </button>
     
     <div class="collapse navbar-collapse" id="navbarSupportedContent">
       <ul class="navbar-nav me-auto mb-2 mb-lg-0">
         <li class="nav-item">
           <a class="nav-link active" aria-current="page" href="../home.html">Home</a>
         </li>

         <li class="nav-item dropdown">
           <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
             Receitas
           </a>
           <ul class="dropdown-menu">
             <li><a class="dropdown-item" href="../receitasalg.html">Receitas Salgadas</a></li>
             <li><a class="dropdown-item" href="../receitadoce.html">Receitas Doces</a></li>
             <li><hr class="dropdown-divider"></li>
             <li><a class="dropdown-item" href="../ingredientes.html">Ingredientes</a></li>
           </ul>
         </li>

         <li class="nav-item">
           <a class="nav-link" href="../nipochef.html">Conheça nossa marca</a>
         </li>
       </ul>

       <ul class="navbar-nav ml-auto">
            <a class="nav-link" href="../login/suaconta.php">
                <i class="fas fa-user"></i> <!-- Ícone de conta -->
            </a>
    </ul>
     </div>
   </div>
</nav> <!--Final do Menu-->

<!-- sua_conta.php -->
<?php
session_start();

if (!isset($_SESSION['user'])) {
    if (isset($_COOKIE['user_token'])) {
        // Decodificar ou processar o token do cookie
        $token = $_COOKIE['user_token'];

        // Simulação: Decodificando um JSON armazenado no token (se o cookie contém dados JSON)
        $userData = json_decode($token, true);

        if ($userData && isset($userData['name'], $userData['email'], $userData['phone'])) {
            // Restaurar a sessão a partir dos dados do cookie
            $_SESSION['user'] = [
                'name' => $userData['name'],
                'email' => $userData['email'],
                'phone' => $userData['phone']
            ];
            $_SESSION['usuario_logado'] = true;
        } else {
            // Caso o token não contenha informações válidas, redirecionar para o login
            header('Location: login.html');
            exit();
        }
    } else {
        // Se o cookie não existir, redirecionar para o login
        header('Location: login.html');
        exit();
    }
}
?>

    <div class="container mt-5">
        <h1 class="text-center">Bem-vindo, <span id="full-name"><?php echo $_SESSION['user']['name']; ?></span>!</h1>

        <section class="mt-4">
            <h2>Informações Pessoais</h2>
            <p><strong>Nome Completo:</strong> <span id="name"><?php echo $_SESSION['user']['name']; ?></span></p>
            <p><strong>E-mail:</strong> <span id="email"><?php echo $_SESSION['user']['email']; ?></span></p>
            <p><strong>Telefone:</strong> <span id="phone"><?php echo $_SESSION['user']['phone']; ?></span></p>
        </section>

        <section class="mt-4">
            <h2>Atualizar Informações</h2>
            <form id="update-form">
        <div class="form-group">
            <label for="new-name">Nome Completo:</label>
            <input type="text" class="form-control" id="new-name" placeholder="Seu Nome Completo" required>
        </div>
        <div class="form-group">
            <label for="new-email">E-mail:</label>
            <input type="email" class="form-control" id="new-email" placeholder="Seu E-mail" required>
        </div>
        <div class="form-group">
            <label for="new-phone">Telefone:</label>
            <input type="tel" class="form-control" id="new-phone" placeholder="Seu Telefone" required>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
        </section>

        <section class="mt-4">
            <h2>Modificar Senha</h2>
            <form id="password-form">
    <div class="form-group">
        <label for="current-password">Senha Atual:</label>
        <input type="password" class="form-control" id="current-password" name="current_password" required>
    </div>
    <div class="form-group">
        <label for="new-password">Nova Senha:</label>
        <input type="password" class="form-control" id="new-password" name="new_password" required>
    </div>
    <div class="form-group">
        <label for="confirm-password">Confirmar Nova Senha:</label>
        <input type="password" class="form-control" id="confirm-password" name="confirm_password" required>
    </div>
    <button type="submit" class="btn btn-success">Atualizar Senha</button>
    <p class="mt-2">Um e-mail de confirmação será enviado após a atualização da senha.</p>
         </form>
        </section>

        <button id="logout-button" class="btn btn-danger mt-4">Sair da Conta</button>
    </div>
    <br><br>

<!--Rodapé-->
<footer class="bg-dark text-white pt-5 pb-4">
    <div class="container text-center text-md-left">
      <div class="row text-center text-md-left">
  
        <!-- NipoChef Section -->
        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
          <h5 class="text-uppercase mb-4 font-weight-bold text-danger">NipoChef</h5>
          <p>Bem-vindo ao NipoChef, seu guia online para explorar e dominar a culinária japonesa na sua própria cozinha. 
            Aqui, mergulhamos no mundo fascinante da gastronomia do Japão, oferecendo desde receitas tradicionais como sushi e 
            tempura até pratos contemporâneos.
          </p>
        </div>
  
        <!-- Descubra Section -->
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
          <h5 class="text-uppercase mb-4 font-weight-bold text-danger">Descubra</h5>
          <p><a href="./receitasalg.html" class="text-white" style="text-decoration: none;">Receitas Salgadas</a></p>
          <p><a href="./receitadoce.html" class="text-white" style="text-decoration: none;">Receitas Doces</a></p>
          <p><a href="./ingredientes.html" class="text-white" style="text-decoration: none;">Ingredientes</a></p>
        </div>
  
        <!-- Cliente Section -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
          <h5 class="text-uppercase mb-4 font-weight-bold text-danger">Cliente</h5>
          <p><a href="#" class="text-white" style="text-decoration: none;">Sua conta</a></p>
          <p><a href="./politica.html" class="text-white" style="text-decoration: none;">Políticas de Privacidade</a></p>
          <p><a href="./termos.html" class="text-white" style="text-decoration: none;">Termos de Uso</a></p>
        </div>
  
        <!-- Contatos Section -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
          <h5 class="text-uppercase mb-4 font-weight-bold text-danger">Contatos</h5>
          <p><i class="fas fa-home mr-3"></i>  R. Ipiau, 162 - Jardim Satélite, São José dos Campos - SP, 12230-750</p>
          <p><i class="fas fa-envelope mr-3"></i>  nipochef2024@gmail.com</p>
          <p><i class="fas fa-phone mr-3"></i>  +55 12 988566079</p>
          <p><i class="fas fa-print mr-3"></i>  +01 335 778 88</p>
        </div>
      </div>
  
      <hr class="mb-4">
      <div class="row align-items-center">
        <div class="col-md-7 col-lg-8">
          <p>Copyright ©2024 Todos os direitos reservados por:
            <a href="./politica.html" style="text-decoration: none;">
              <strong class="text-danger">NipoChef</strong>
            </a>
          </p>
        </div>
      </div>
    </div>
  </footer>
   <!--final do rodapé-->
    
    <script src="../login/js/logout.js"></script>
    <script src="../login/js/changepass.js"></script>
    <script src="../login/js/atualizar.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> 
</body>
</html>
