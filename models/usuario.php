<?php



//Utilizando o método DAO:

class Usuario{

    public $id_usuario;
    public $nome_usuario;
    public $sobrenome_usuario;
    public $email_usuario;
    public $senha_usuario;
    public $img_usuario;
    public $bio_usuario;
    public $token_usuario;

    public function coletarNomeCompleto($usuario){

            return $usuario->nome_usuario . " " . $usuario->sobrenome_usuario;

    }

    //Função para realizar a criação dos tokens, sempre modificando a estrutura para não haver tokens iguais: 


    public function gerarToken(){ 

        return bin2hex(random_bytes(50)); //Para gerar diferentes tokens e evitar problemas por tokens iguais . Bytes gerados aleatoriamente .

    }

    public function gerarSenha($senha_usuario){

        return $dadosCadastrar['senha_usuario_confirmacao'] = password_hash($senha_usuario, PASSWORD_DEFAULT);

    }

    public function gerarNomeImg(){

        return bin2hex(random_bytes(60)) . ".jpg"; //Para gerar diferentes arquivos de img e evitar problemas por arquivos iguais . Bytes gerados aleatoriamente .

    }




}

interface usuarioDAOInterface{

    //Para receber um Objeto data :

    public function buildUsuario($data);

    //Para criar o usuario e realizar o Login: 

    public function criarUsuario(Usuario $usuario, $autenticacao = false);

    //Para atualizar o usuario :

    public function alterarUsuario(Usuario $usuario, $redirecionamento = true);

    //Para receber o token do usuario e assim já colocá-lo no sistema :

    public function coletarToken($token_usuario);

    //Para verificar token do usuario :

    public function verificarToken($protected = false);

    

    //Métodos para realizar a autenticação: 


    //Para redirecionar o usuario para uma página / sessão específica :

    public function alterarTokenParaSessao($token, $redirect = true);

    //Para autenticar o usuario por meio do email e da senha: 

    public function autenticarUsuario($email_usuario,$senha_usuario);

    //Para encontrar um usuario por meio do Email: 

    public function encontrarPorEmail($email_usuario);

    //Para encontrar um usuario por meio do Email: 

    public function encontrarPorId($id_usuario);

    //Para encontrar um usuario por meio do Token: 

    public function encontrarPorToken($token_usuario);

    //Para remover o usuario da sessão : 

    public function anularToken();

    //Para realizar a troca da senha do usuario: 

    public function alterarSenha(Usuario $usuario);



}
