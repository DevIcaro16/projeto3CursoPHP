<?php

require_once("../templates/header.php");

if($usuarioDAO){

    $usuarioDAO->anularToken();

}

?>