<?php

class conexaoBD{

//Atributos (Informações do BD):

private $host = 'localhost';
private $port = 3306; //3306(Padrão) -> phpmyadmin ; 3312 = workbench 
private $dbname = 'cinetec';
private $username = 'root';
private $password = '';
private $pdo;

//Método que realizará a conexão com o BD : 

public function connect(){

    $dsn = "mysql:host={$this->host};
    port={$this->port};
    dbname={$this->dbname}; charset=utf8mb4";

    //Array com as mensagens do método PDO : 

    $options = [

        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

        PDO::ATTR_EMULATE_PREPARES => false,


    ];

    try { //Quando Erro = false (quando der sucesso) : 
        
        $this->pdo = new PDO($dsn,$this->username,$this->password,$options); 

        // Teste -> echo"Conexão Realizada Com Sucesso!<br>";

    } catch (PDOException $erro) { //Quando Erro = true (quando der errado) :
        
        throw new Exception('Erro na conexão com o BD!' . $erro->getMessage());

    }

    return $this->pdo;

}
}

//Instanciando o meu objeto da classe de conexaoBD : 

$connect = new conexaoBD();
$pdo = $connect->connect();

?>