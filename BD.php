<?php

function conn_mysql(){
    $servidor = 'br-cdbr-azure-south-a.cloudapp.net';
    $porta = 3306;
    $banco = "dawyearA3JWRG8UN";
    $usuario = "bb7c243ce131f7";
    $senha = "da358e93";
    
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