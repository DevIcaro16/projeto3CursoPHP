<?php

//Aproveitamento de Templates -> Cabeçalho / Header: 

require_once("../templates/header.php");

require_once("../models/usuario.php");

require_once("../DAO/usuarioDAO.php");

$usuario = new Usuario();

$usuarioDAO = new UsuarioDAO($pdo,$BASE_URL);

$usuarioDATA = $usuarioDAO->verificarToken(true);

$nomeCompleto = $usuario->coletarNomeCompleto($usuarioDATA);

//Para verificar se o usuário tem uma img : 

if($usuarioDATA->img_usuario == ""){

    $usuarioDATA->img_usuario = "usuarioPadrao.png";

}

?>

    <!-- Corpo Do site:  -->

    <div id="main-container" class="container-fluid pagina-editar-perfil">

        <!-- Form de edição de perfil: -->

        <div class="col-md-12">

            <form action="<?= $BASE_URL ?>alteracoesUsuario.php" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="type" value="alterarDados">

                <div class="row">

                        <div class="col-md-4">

                            <h1><?= $nomeCompleto ?></h1>

                           

                            <p class="pagina-descricao">Caso queira,
                                Faça a alteração dos seus dados de cadastro abaixo:</p>

                                <div class="form-group">

                                <label for="nome_usuario" class="form-label">Nome: </label>
                                <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" placeholder="Digite o seu nono Nome de Usuário" 
                                value="<?= $usuarioDATA->nome_usuario ?>">

                                </div>

                                <div class="form-group">

                                <label for="Sobrenome_usuario" class="form-label">Sobrenome: </label>
                                <input type="text" class="form-control" id="sobrenome_usuario" name="sobrenome_usuario" placeholder="Digite o seu Sobrenome" 
                                value="<?= $usuarioDATA->sobrenome_usuario ?>">

                                </div>


                                <div class="form-group">

                                <label for="email_usuario" class="form-label">E-mail: </label>
                                <input type="email" class="form-control disabled" id="email_usuario" name="email_usuario" placeholder="Digite o seu novo E-mail "
                                value="<?= $usuarioDATA->email_usuario ?>">

                                </div><br>


                                <input type="submit" class="card-btn" value="Alterar meus Dados">

                                <!--
                                <div class="form-group">

                                <label for="senha_usuario" class="form-label">Senha: </label>
                                <input type="password" class="form-control" id="senha_usuario" name="senha_usuario" placeholder="Crie sua senha">

                                </div> -->

                        </div>

                        <div class="col-md-4">

                            <div id="img-perfil-container" 
                            style="background-image: url('<?= $BASE_URL ?>../IMG/usuarios/<?= $usuarioDATA->img_usuario ?> ')">

                            </div>

                            <div class="form-group">

                                <label for="img_usuario" class="form-label">Sua Foto: </label>
                                <input type="file" class="form-control-file" name="img_usuario">

                            </div><br>

                            <div class="form-group">

                                <label for="bio_usuario" class="form-label">Sua BIO: </label>
                                <textarea name="bio_usuario" placeholder="Conte-nos um pouco sobre você! Oque faz da vida, com oque trabalha e mais..."
                                 id="bio_usuario" rows="5" class="form-control">
                                <?= $usuarioDATA->bio_usuario ?>
                            </textarea>


                            </div>

                        </div>

                </div>

            </form><br>

            <div class="row" id="alterar-senha-container">

                <div class="col-md-4">

                    <h2>Caso queira, Altere sua senha de acesso:  </h2>

                    <p class="pagina-descricao">Digite sua nova senha e depois clique em Alterar Senha: </p>

                    <form action="<?= $BASE_URL ?>alteracoesUsuario.php" method="POST">
                
                        <input type="hidden" name="type" value="alterarSenha">
    
                        <input type="hidden" name="id_usuario" value="<?= $usuarioDATA->id_usuario ?>">

                        <div class="form-group">

                            <label for="senha_usuario" class="form-label">Senha: </label>
                            <input type="password" class="form-control" id="senha_usuario" name="senha_usuario" placeholder="Digite sua nova Senha "
                            value="">

                        </div><br>

                        <div class="form-group">

                            <label for="senha_usuario_confirmacao" class="form-label">Confirme sua Senha: </label>
                            <input type="password" class="form-control" id="senha_usuario_confirmacao" name="senha_usuario_confirmacao" placeholder="Confirme sua nova Senha ">

                        </div><br>

                        <input type="submit" class="card-btn" value="Alterar Senha">

                    </form>

                </div>

            </div>

        </div>

    </div>

    

<?php

//Aproveitamento de Templates -> Rodapé / Footer:

require_once("../templates/footer.php");

?>

