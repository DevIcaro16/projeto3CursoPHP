<?php

//Para fazer a inclusão dos códigos de conexao com o BD e da URL : 
require_once("url.php");
require_once("conexao.php");
require_once("../models/mensagem.php");
require_once("../models/usuario.php");
require_once("../DAO/usuarioDAO.php");

$mensagem = new Mensagem($BASE_URL);

$flassMessage = $mensagem -> getMensagem();



//Para limpar a mensagem: 

if(!empty($flassMessage["msg"])){

    $mensagem->limparMensagem();

    
    

}

$usuarioDAO = new UsuarioDAO($pdo,$BASE_URL);


$usuarioDATA = $usuarioDAO->verificarToken(false);    




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinetec</title>

    <!-- Linkamentos De Arquivos Locais Projeto: -->

    <link rel="short icon" href="<?= $BASE_URL ?>../IMG/cinetec.ico">
    <link rel="stylesheet" href="<?= $BASE_URL ?>../CSS/style.css">

    <!-- Linkamentos De CSS Do Bootstrap: -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap.css" integrity="sha512-vxhcSRMDjtLpgTL/8uRKEjhCh8YyDER14SFb9cuceRmefufcZBweOJuQJ70JYRZiq+QhpaTM3zDw9YSOPbqtFQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
   
    <header>

        <nav id="main-navbar" class="navbar navbar-expand-lg">

            <a href="<?= $BASE_URL ?>" class="navbar-brand">
        
                    <img src="<?= $BASE_URL ?>../IMG/logo.svg" alt="Cinetec" id="logo">
                    <span id="cinetec-title">Cinetec</span>

            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar"
            aria-expanded="false" aria-label="Toggle navigation">
        
                    <i class="fas fa-bars"></i>

            </button>

            <!-- Formulário De Buscar Filmes: -->

            <form action="" method="GET" id="search-form" class="d-flex">

                <input type="text" name="q" id="search" class="form-control me-2" type="search" 
                placeholder="Buscar Filmes" aria-label="Search">

                <button class="btn my-2 my-sm-0" type="submit">
                    <i class="fas fa-search"></i>
                </button>

            </form>

    

            <div class="collapse navbar-collapse" id="navbar">

                <ul class="navbar-nav">

                <?php if($usuarioDATA): ?>

                    <li class="nav-item">

                        <a href="<?= $BASE_URL ?>comprarFilme.php" class="nav-link">

                            <i class="far fa-plus-square"></i> Comprar Filme

                        </a>

                    </li>
                    <li class="nav-item">

                        <a href="<?= $BASE_URL ?>filmesDoUsuario.php" class="nav-link">Meus Filmes</a>

                    </li>
                    <li class="nav-item">

                        <a href="<?= $BASE_URL ?>editarPerfil.php" class="nav-link bold">
                    
                            <?= $usuarioDATA->nome_usuario ?>
                            <?= $usuarioDATA->sobrenome_usuario ?>

                        </a>

                    </li>
                    <li class="nav-item">

                        <a href="<?= $BASE_URL ?>logout.php" class="nav-link">Sair </a>

                    </li>


                <?php else: ?>

                    <li class="nav-item">

                        <a href="<?= $BASE_URL ?>login.php" class="nav-link">Entrar </a>

                    </li>


                    <li class="nav-item">

                        <a href="<?= $BASE_URL ?>cadastrar.php" class="nav-link">Cadastrar </a>

                    </li>


                    <li class="nav-item">

                        <a href="<?= $BASE_URL ?>sobre.php" class="nav-link">Sobre </a>

                    </li>
               

                <?php endif; ?>

                </ul>

            </div>

        </nav>

    </header>

<?php if(!empty($flassMessage["msg"])): ?>
    
    <?php 
        
    
        
    ?>

    <div class="msg-container">

        <p class="msg <?= $flassMessage['tipo'] ?>"><?= $flassMessage['msg'] ?></p>

    </div>

<?php endif; ?>

