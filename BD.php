<?php

function conn_mysql(){
    $servidor = 'localhost';
    $porta = 3306;
    $banco = "daw_yearbook";
    $usuario = "root";
    $senha = "1234";
    
        $conn = new PDO ("mysql:host=$servidor; 
                             port=$porta;
                             dbname=$banco",
                             $usuario, 
                             $senha,
                             array(PDO::ATTR_PERSISTENT => true) 
                           );
    return $conn;
}

?>