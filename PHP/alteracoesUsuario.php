<?php

require_once("url.php");
require_once("conexao.php");
require_once("../models/usuario.php");
require_once("../models/mensagem.php");
require_once("../DAO/usuarioDAO.php");  

$mensagem = new Mensagem();

$usuarioDAO = new UsuarioDAO($pdo,$BASE_URL);

//Verificar o tipo de form(Se o form é de alterar Dados ou para alterar a Senha de Acesso):

$tipoForm = filter_input(INPUT_POST,"type");

//Alterar Dados: 

if($tipoForm === "alterarDados"){

    //Resgata os Dados do Usuário: 

    $usuarioDATA = $usuarioDAO->verificarToken();

    $novosDadosCadastro = filter_input_array(INPUT_POST,FILTER_DEFAULT);

    //Cria um novo Objeto de Usuário: 

    $usuario = new Usuario();

    //Preencher os Dados do Usuário: 

    $usuarioDATA->nome_usuario = $novosDadosCadastro['nome_usuario'];
    $usuarioDATA->sobrenome_usuario = $novosDadosCadastro['sobrenome_usuario'];
    $usuarioDATA->email_usuario = $novosDadosCadastro['email_usuario'];
    $usuarioDATA->bio_usuario = $novosDadosCadastro['bio_usuario'];


    //Para realizar o upload da img do Usuário: 

    if(isset($_FILES['img_usuario']) && !empty($_FILES['img_usuario']['tmp_name'])){

        $img_usuario = $_FILES["img_usuario"];

        $imgTiposPermitidos = ["image/jpeg", "image/jpg", "image/png"];

        $jpgArray = ["image/jpeg", "image/jpg"];

        //Para checar se o dado enviado é realmente uma img, utilizando o método in_array(): 

        if(in_array($img_usuario["type"],$imgTiposPermitidos)){ 

            //Verificar se o tipo da img é jpeg ou jpg: 

                if(in_array($img_usuario,$jpgArray)){

                    $imgFormato = imagecreatefromjpeg($img_usuario["tmp_name"]);

                }else{ //Se a img for do tipo png: 

                    $imgFormato = imagecreatefrompng($img_usuario["tmp_name"]);                

                }

                $imgNome = $usuario->gerarNomeImg();

                imagejpeg($imgFormato, "../IMG/usuarios/" . $imgNome, 100 );

                $usuarioDATA->img_usuario = $imgNome;

        }else{ //Caso o arquivo enviado não seja de nenhum dos tipos permitidos:
            
            $mensagem->setMensagem("Formato Inválido de imagem!", "error", "voltar");

        }


    }

    

    //Para realizar as alteracões : 

    $usuarioDAO->alterarUsuario($usuarioDATA);

    
//Alterar Senha:

}else if($tipoForm === "alterarSenha"){

    $novosDadosCadastro = filter_input_array(INPUT_POST,FILTER_DEFAULT);

    $usuarioDATA = $usuarioDAO->verificarToken();

    $novosDadosCadastro['id_usuario'] = $usuarioDATA->id_usuario;

    if($novosDadosCadastro['senha_usuario'] == $novosDadosCadastro['senha_usuario_confirmacao']){
      
    //Cria um novo Objeto de Usuário: 

    $usuario = new Usuario();

    $senhaFinal = $usuario->gerarSenha($novosDadosCadastro['senha_usuario']);

    $usuario->senha_usuario = $senhaFinal;
    $usuario->id_usuario = $novosDadosCadastro['id_usuario'];

    $usuarioDAO->alterarSenha($usuario);


    }else{

        $mensagem->setMensagem("As duas senhas precisam ser iguais! Tente Novamente!", "error", "voltar");

    }

}else{

    $mensagem->setMensagem("Informções Inválidas no Formulário!", "error", "index.php");

}

?>