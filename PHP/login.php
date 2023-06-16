<?php

require_once("../templates/header.php");

?>

    <!-- Corpo Do site:  -->

    <div id="main-container" class="container-fluid">

        <div class="col-md-12">

            <div class="row" id="login-row">

                <div class="col-md-4" id="login-container">

                    <h2>Entrar</h2>

                    <form action="<?= $BASE_URL ?>autenticacao.php" method="POST">

                    <input type="hidden" name="type" value="login">

                    <p>Realize seu Login</p>

                        <div class="form-group">

                            <label for="email_usuario" class="form-label">E-mail: </label>
                            <input type="text" class="form-control" id="email_usuario" name="email_usuario" placeholder="Digite o seu E-mail Cadastrado">

                        </div>
                        <div class="form-group">

                            <label for="senha_usuario" class="form-label">Senha: </label>
                            <input type="password" class="form-control" id="senha_usuario" name="senha_usuario" placeholder="Digite a sua Senha Cadastrada">

                        </div><br>

                        <input type="submit" class="card-btn" value="Entrar">

                    </form>

                    <p>Não possui um Cadastro? Realize seu cadastro <a href="<?= $BASE_URL?>cadastrar.php">aqui</a></p>

                </div>

            </div>

        </div>

    </div>

    

<?php

require_once("../templates/footer.php");

?>