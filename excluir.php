<?php
require_once("./authSession.php");
require_once("./BD.php");


try
{
	// Se o comando não veio atraves da página principal
	if (!($_GET["apagar"])=="SIM"){
		header("Location:./erroExclusao.php");
		die();
	}
	//se o usuário clicou no excluir
	else{
		
        $conexao = conn_mysql();
		
	
		$loginexcluir =  utf8_encode(htmlspecialchars($_SESSION["nomeUsuario"]));
				
		$SQLDelete = 'DELETE FROM participantes WHERE login=?';
					  
		$operacao = $conexao->prepare($SQLDelete);					  
		
		$sucesso = $operacao->execute(array($loginexcluir));
		
		$conexao = null;
		
		//verifica se o retorno da execução foi verdadeiro e faz logout no sistema
		if ($sucesso){
			 header("Location: ./sair.php");
		}
		else {
			echo "<h1>Erro na exclusão.</h1>\n";
				$arr = utf8_decode($operacao->errorInfo());		
				echo "<p>$arr[2]</p>";							
			    echo "<p><a href=\"./principal.php\">Retornar</a></p>\n";
		}
    }
}
catch (PDOException $e)
{
   
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}

?>
