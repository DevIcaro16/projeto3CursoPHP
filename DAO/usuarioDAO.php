<?php

require_once("../models/usuario.php");
require_once("../models/mensagem.php");


class UsuarioDAO implements usuarioDAOInterface{

    private $connect;
    private $url;
    private $mensagem;

    //Constructor : 

        public function __construct(PDO $connect, $url){

            $this->connect = $connect;
            $this->url = $url;
            $this->mensagem = new Mensagem($url);

        }

       //Para receber um Objeto data :

       public function buildUsuario($data){

            $usuario = new Usuario();    

            $usuario->id_usuario = $data["id_usuario"];
            $usuario->nome_usuario = $data["nome_usuario"];
            $usuario->sobrenome_usuario = $data["sobrenome_usuario"];
            $usuario->email_usuario = $data["email_usuario"];
            $usuario->senha_usuario = $data["senha_usuario"];
            $usuario->img_usuario = $data["img_usuario"];
            $usuario->bio_usuario = $data["bio_usuario"];
            $usuario->token_usuario = $data["token_usuario"];

            
            return $usuario;


       }

       //Para criar o usuario e realizar o Login: 
   
       public function criarUsuario(Usuario $usuario, $autenticacaoUsuario = false){

        $result_query_criar_usuario = $this->connect->prepare("INSERT INTO usuario
        (nome_usuario,sobrenome_usuario,email_usuario,senha_usuario,token_usuario) VALUES 
        (:nome_usuario,:sobrenome_usuario,:email_usuario,:senha_usuario,:token_usuario)");

        $result_query_criar_usuario->bindParam(":nome_usuario",$usuario->nome_usuario);
        $result_query_criar_usuario->bindParam(":sobrenome_usuario",$usuario->sobrenome_usuario);
        $result_query_criar_usuario->bindParam(":email_usuario",$usuario->email_usuario);
        $result_query_criar_usuario->bindParam(":senha_usuario",$usuario->senha_usuario);
        $result_query_criar_usuario->bindParam(":token_usuario",$usuario->token_usuario);

        $result_query_criar_usuario->execute();

        //Para autenticar usuário, caso autenticação seja verdadeira / true :

        if($autenticacaoUsuario){

            $this->alterarTokenParaSessao($usuario->token_usuario);

        }
       

       }
   
       //Para atualizar o usuario :
   
       public function alterarUsuario(Usuario $usuario, $redirecionamento = true){

        $result_query_atualizar_usuario = $this->connect->prepare("UPDATE usuario SET 
        
        nome_usuario = :nome_usuario,
        sobrenome_usuario = :sobrenome_usuario,
        email_usuario = :email_usuario,
        img_usuario = :img_usuario,
        bio_usuario = :bio_usuario,
        token_usuario = :token_usuario

        WHERE id_usuario = :id_usuario
        
        ");


        $result_query_atualizar_usuario->bindParam(":nome_usuario",$usuario->nome_usuario);
        $result_query_atualizar_usuario->bindParam(":sobrenome_usuario",$usuario->sobrenome_usuario);
        $result_query_atualizar_usuario->bindParam(":email_usuario",$usuario->email_usuario);
        $result_query_atualizar_usuario->bindParam(":img_usuario",$usuario->img_usuario);
        $result_query_atualizar_usuario->bindParam(":bio_usuario",$usuario->bio_usuario);
        $result_query_atualizar_usuario->bindParam(":token_usuario",$usuario->token_usuario);
        $result_query_atualizar_usuario->bindParam(":id_usuario",$usuario->id_usuario);

        $result_query_atualizar_usuario->execute();

        if($redirecionamento){

            //Redirecionar para o perfil do usuario

            $this->mensagem -> setMensagem("Seus Dados Foram Atualizados com Sucesso!","success","editarPerfil.php");

        }
            

       }
   
       //Para receber o token do usuario e assim já colocá-lo no sistema :
   
       public function coletarToken($token_usuario){

                


       }
   
       //Para verificar token do usuario :
   
       public function verificarToken($protected = false){

            if(!empty($_SESSION["token_usuario"])){

                //Para coletar o token da session : 

                $token = $_SESSION['token_usuario'];

                $usuario = $this->encontrarPorToken($token);

                if($usuario){

                    return $usuario;

                }else if($protected){  //Para não deixar acessar a página de edição, caso o usuário não esteja logado no sistema!

                    //Redirecionar o Usuário que não estar autenticado: 

                    $this->mensagem -> setMensagem("É necessário realizar a sua autenticação para acessar esta página!","error","index.php");

                }

            }else if($protected){ //Para não deixar acessar a página de edição, caso o usuário não esteja logado no sistema!

                 //Redirecionar o Usuário que não estar autenticado: 

                 $this->mensagem -> setMensagem("É necessário realizar a sua autenticação para acessar esta página!","error","index.php");

            }

       }
   
       
   
       //Métodos para realizar a autenticação: 
   
   
       //Para redirecionar o usuario para uma página / sessão específica :
   
       public function alterarTokenParaSessao($token, $redirecionamento = true){

            //Salvar token na sessão: 

            $_SESSION["token_usuario"] = $token;

            if($redirecionamento){

                //Redirecionar para o perfil do usuario

                $this->mensagem ->setMensagem("Seja Bem Vindo!","success","editarPerfil.php");

            }

       }
   
       //Para autenticar o usuario por meio do email e da senha: 
   
       public function autenticarUsuario($email_usuario,$senha_usuario) {

            $usuario = $this->encontrarPorEmail($email_usuario);  

            if($usuario){ 
                
                //Verifica se as senhas são iguais:

                if(password_verify($senha_usuario,$usuario->senha_usuario)){

                    //Como não há mais token, é necessário gerar um novo token e inserir na sessão: 

                    $token_usuario = $usuario->gerarToken();

                    $this->alterarTokenParaSessao($token_usuario, false);

                    //Atualizar token do usuário: 

                    $usuario->token_usuario = $token_usuario;


                    $this->alterarUsuario($usuario, false);

                    return true; 


                }else{

                    return false;

                }

            }else{

                return false;

            }


       }
   
       //Para encontrar um usuario por meio do Email: 
   
       public function encontrarPorEmail($email_usuario){


            if($email_usuario != ""){

                $result_query_select_email = $this->connect->prepare("SELECT * FROM usuario WHERE email_usuario = :email_usuario");

                $result_query_select_email->bindParam(":email_usuario",$email_usuario);

                $result_query_select_email->execute();

                if($result_query_select_email->rowCount() > 0){

                    $data = $result_query_select_email->fetch();
                    $usuario = $this->buildUsuario($data);

                    return $usuario;
                    

                }else{

                    return false;

                }
                

            }else{

                return false;

            }
            

       }
   
       //Para encontrar um usuario por meio do ID: 
   
       public function encontrarPorId($id_usuario){

            

       }

   
       //Para encontrar um usuario por meio do Token: 
   
       public function encontrarPorToken($token_usuario){

            
            if($token_usuario != ""){

                $result_query_select_token = $this->connect->prepare("SELECT * FROM usuario WHERE token_usuario = :token_usuario");

                $result_query_select_token->bindParam(":token_usuario",$token_usuario);

                $result_query_select_token->execute();

                if($result_query_select_token->rowCount() > 0){

                    $data = $result_query_select_token->fetch();
                    $usuario = $this->buildUsuario($data);

                    return $usuario;
                    

                }else{

                    return false;

                }
                

            }else{

                return false;

            }


       }


       public function anularToken(){


            //Remover Token da session: 

            $_SESSION["token_usuario"] = "";

            //Para redirecionar o Usuário quando ele deslogar / logout : 

            $this->mensagem->setMensagem("Você Deslogou com Sucesso! Volte Sempre!","success","index.php");

       }

   
       //Para realizar a troca da senha do usuario: 
   
       public function alterarSenha(Usuario $usuario){

            $result_query_alterar_senha = $this->connect->prepare("UPDATE usuario SET senha_usuario = :senha_usuario WHERE id_usuario = :id_usuario");

            $result_query_alterar_senha->bindParam(":senha_usuario",$usuario->senha_usuario);
            $result_query_alterar_senha->bindParam(":id_usuario",$usuario->id_usuario);

            $result_query_alterar_senha->execute();

            //Para realizar o redirecionamento e apresentar a mensagem de sucesso! : 

            $this->mensagem->setMensagem("Sua senha foi alterada com Sucesso!","success","editarPerfil.php");

       }

}



