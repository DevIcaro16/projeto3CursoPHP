<?php

require_once("url.php");
require_once("conexao.php");
require_once("../models/usuario.php");
require_once("../models/mensagem.php");
require_once("../DAO/usuarioDAO.php");  

//Verificar o tipo de form(Se é o form de Login ou de Cadastro):

$tipoForm = filter_input(INPUT_POST,"type");

//echo"$tipoForm";

$mensagem = new Mensagem();

$usuarioDAO = new UsuarioDAO($pdo,$BASE_URL);






//Valores enviados por meio do form: 

if($tipoForm === "cadastrar"){ //Quando for efetuado um cadastro:

     $dadosCadastrar = filter_input_array(INPUT_POST,FILTER_DEFAULT);

     /*
     $nome_usuario = filter_input(INPUT_POST,"nome_usuario");    
     $sobrenome_usuario = filter_input(INPUT_POST,"sobrenome_usuario");    
     $email_usuario = filter_input(INPUT_POST,"email_usuario");    
     $senha_usuario = filter_input(INPUT_POST,"senha_usuario");    
     $senha_usuario_confirmacao = filter_input(INPUT_POST,"senha_usuario_confirmacao");    */

     //Mensagem de Validação caso todos os campos estejam vazios: 



     //Mensagem de Validação para os campos individuais:

     

     if(empty($dadosCadastrar['nome_usuario'])){

          $mensagem->setMensagem("Por favor, Preencha o campo Nome!", "error", "voltar");

     }else if(empty($dadosCadastrar['sobrenome_usuario'])){

          $mensagem->setMensagem("Por favor, Preencha o campo Sobrenome!", "error", "voltar");

     }else if(empty($dadosCadastrar['email_usuario'])){

          $mensagem->setMensagem("Por favor, Preencha o campo Email!", "error", "voltar");

     }else if(empty($dadosCadastrar['senha_usuario'])){

          $mensagem->setMensagem("Por favor, Preencha o campo Senha!", "error", "voltar");

     }else if(empty($dadosCadastrar['senha_usuario_confirmacao'])){

          $mensagem->setMensagem("Por favor, Preencha o campo Confirmação de Senha!", "error", "voltar");

     }else if($dadosCadastrar['senha_usuario'] != $dadosCadastrar['senha_usuario_confirmacao']){

          $mensagem->setMensagem("As senhas precisam ser iguais!", "error", "voltar");

     }else if($usuarioDAO->encontrarPorEmail($dadosCadastrar['email_usuario']) === false){ //Se não existir um usuario com o email já cadastrado

          $usuario = new Usuario();
     
          //Criação de token e senha :

          
          $usuarioToken = $usuario ->gerarToken();
          $dadosCadastrar['senha_usuario_confirmacao'] = $usuario->gerarSenha($dadosCadastrar['senha_usuario']);
     
          $usuario->nome_usuario = $dadosCadastrar['nome_usuario'];
          $usuario->sobrenome_usuario = $dadosCadastrar['sobrenome_usuario'];
          $usuario->email_usuario = $dadosCadastrar['email_usuario'];
          $usuario->senha_usuario = $dadosCadastrar['senha_usuario_confirmacao'];
          $usuario->token_usuario = $usuarioToken;
     
          $autenticacao = true;
     
          $usuarioDAO -> criarUsuario($usuario,$autenticacao);
     
     }else{ //Se existir um usuario com o email já cadastrado
     
          $mensagem->setMensagem("Este Email já consta em nosso sistema! Tente cadastrar outro!", "error", "voltar");
     
     }

   

}else if($tipoForm === "login"){ //Quando for efetuado um login:


          $dadosLogin = filter_input_array(INPUT_POST,FILTER_DEFAULT);

          if(empty($dadosLogin['email_usuario'])){

               $mensagem->setMensagem("Por favor, Preencha o campo Email!", "error", "voltar");
     
          }else if(empty($dadosLogin['senha_usuario'])){
     
               $mensagem->setMensagem("Por favor, Preencha o campo Senha!", "error", "voltar");
     
          }else if($usuarioDAO->autenticarUsuario($dadosLogin['email_usuario'],$dadosLogin['senha_usuario'])){ //Tenta autenticar o Usuário: 


               $mensagem->setMensagem("Olá, Seja Bem Vindo!","success","editarPerfil.php");


          //Realiza o redirecionamento do usuário, caso ele não consiga autenticar:

          }else{
 
               $mensagem->setMensagem("Nome De Usuário e/ou Senha Incorretos!", "error", "voltar");


          }


     }else{ //Caso o usuário envie algum dado / tipo inválido de form: 

          $mensagem->setMensagem("Informções Inválidas no Formulário!", "error", "index.php");

     }


     /*Verificação de dados mínimos : 

     if($nome_usuario && $sobrenome_usuario && $email_usuario && $senha_usuario){




     }else{ //Quando faltar dados válidos, Messagem de Erro:

     $mensagem->setMensagem("Por favor, Preencha todos os dados corretamente!", "error", "voltar");

}*/





?>