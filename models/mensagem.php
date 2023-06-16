<?php

session_start();

class Mensagem{

    private $url;

    public function __constructor($url){

        $this->url = $url;

    }

    public function setMensagem($msg, $tipo, $redirecionamento = "index.php"){

        $_SESSION["msg"] = $msg;
        $_SESSION["tipo"] = $tipo;

        if($redirecionamento != "voltar"){ //Caso não haja erro, o Usuário será redirecionado a página de destino: 

            header("Location: $this->url" . $redirecionamento);

        }else{ //Para voltar a url / página anterior que o Usuário estava: 

            header("Location: " . $_SERVER["HTTP_REFERER"]);

        }

    }
    public function getMensagem(){

        if(!empty($_SESSION["msg"])){

            return [

                "msg" => $_SESSION["msg"],
                "tipo" => $_SESSION['tipo']

            ];

        }else{

            return false;

        }

    }
    public function limparMensagem(){

        $_SESSION["msg"] = "";
        $_SESSION['tipo'] = "";
        

    }
   

}

?>