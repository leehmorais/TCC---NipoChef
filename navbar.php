<?php session_start(); ?>
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
           <?php if (isset($_SESSION['user'])): ?>
               <li class="nav-item">
                   <a class="nav-link" href="suaconta.php">Minha Conta</a>
               </li>
               <li class="nav-item">
                   <a class="nav-link" href="logout.php">Sair</a>
               </li>
           <?php else: ?>
               <li class="nav-item">
                   <a class="nav-link" href="login.html">Login</a>
               </li>
           <?php endif; ?>
       </ul>
     </div>
     
   </div>
</nav>