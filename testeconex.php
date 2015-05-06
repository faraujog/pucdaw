<?php
require_once("BD.php");
include_once("cabecalhobook.html");


try{
    $conexao = conn_mysql();
    if ($conexao) {
    
    echo "<h1>Conectei ao banco de dado</h1>";
}
else 
{    
    echo "<h1>NÃO Conectei ao banco de dado</h1>"; 
}
}
catch (PDOException $e)
	{
		// caso ocorra uma exceção, exibe na tela
		echo "Erro!: " . $e->getMessage() . "<br>";
        echo "<p><b>NAO POSSO CONECTAR E ESTOU NO CATCH<p><b>";
		die();
	}

include_once("rodapebook.html");
?>