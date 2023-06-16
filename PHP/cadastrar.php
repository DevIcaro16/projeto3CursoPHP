<?php

require_once("../templates/header.php");

 

?>

    <!-- Corpo Do site:  -->

    <div id="main-container" class="container-fluid">

        <div class="col-md-12">

            <div class="row" id="cadastrar-row">

                <div class="col-md-4" id="cadastrar-container">

                    <h2>Cadastrar</h2>

                    <form action="<?= $BASE_URL ?>autenticacao.php" method="POST">

                        <input type="hidden" name="type" value="cadastrar">

                        <p>Crie sua Conta</p>

                        <div class="form-group">

                            <label for="nome_usuario" class="form-label">Nome: </label>
                            <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" placeholder="Digite o seu Primeiro Nome" 
                            value="<?php if(isset($usuarioDATA->nome_usuario)){echo $usuarioDATA->nome_usuario;}?>">

                        </div>

                        <div class="form-group">

                            <label for="sobrenome_usuario" class="form-label">Sobrenome: </label>
                            <input type="text" class="form-control" id="sobrenome_usuario" name="sobrenome_usuario" placeholder="Digite o seu Sobrenome">

                        </div>


                        <div class="form-group">

                            <label for="email_usuario" class="form-label">E-mail: </label>
                            <input type="email" class="form-control" id="email_usuario" name="email_usuario" placeholder="Digite o seu E-mail ">

                        </div>

                        
                        <div class="form-group">

                        <label for="senha_usuario" class="form-label">Senha: </label>
                        <input type="password" class="form-control" id="senha_usuario" name="senha_usuario" placeholder="Crie sua senha">

                        </div>


                        <div class="form-group">

                        <label for="senha_usuario_confirmacao" class="form-label">Confirme sua Senha: </label>
                        <input type="password" class="form-control" id="senha_usuario_confirmacao" name="senha_usuario_confirmacao" placeholder="Digite novamente sua senha">

                        </div><br>



                    <input type="submit" class="card-btn" value="Cadastrar">

                </form>

                <p>Já possui um Cadastro? Realize seu Login <a href="<?= $BASE_URL?>login.php">aqui</a></p>

            </div>

        </div>

    </div>

</div>

    

<?php

require_once("../templates/footer.php");


?>