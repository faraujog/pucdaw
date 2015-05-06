<?php
require_once("./authSession.php");
require_once("./BD.php");

try
{
	
	if(count($_POST)<3){
		header("Location:./erroEdicao.php");
       	die();
	}
	
	else{
		
		$conexao = conn_mysql();
		
		
		//captura valores do vetor POST
		//utf8_encode para manter consistência da codificação utf8 nas páginas e no banco
		$nome = utf8_encode(htmlspecialchars($_POST['nomecompleto']));
        $email = utf8_encode(htmlspecialchars($_POST['email']));
		$login = utf8_encode(htmlspecialchars($_SESSION["nomeUsuario"]));
		$senha = utf8_encode(htmlspecialchars($_POST['senhausuario']));
		$senhaConf = utf8_encode(htmlspecialchars($_POST['confsenha']));
        $descricao = utf8_encode(htmlspecialchars($_POST['descricao']));
        $cidadepart = utf8_encode(htmlspecialchars($_POST['cidades']));
		
    
		if(($senha!=$senhaConf)||(strlen($senha)<4)||(strlen($senha)>8)){
		header("Location:./erroEdicao.php");
        die();
		}
		
		$SQLUpdate = 'UPDATE participantes SET nomeCompleto=?, email=?, senha=MD5(?), cidade=?, descricao=? WHERE login=?';
			
		$operacao = $conexao->prepare($SQLUpdate);					  
		
		$atualizacao = $operacao->execute(array($nome, $email, $senha, $cidadepart, $descricao, $login));
		
		$conexao = null;
		
		
		if ($atualizacao){
			 header("Location: ./principal.php");
             
		}
		else {
			echo "<h1>Erro na operação.</h1>\n";
				$arr = utf8_decode($operacao->errorInfo());	
				echo "<p>$arr[2]</p>";							
			    echo "<p><a href=\"./principal.php\">Retornar</a></p>\n";
		}
    }
}
catch (PDOException $e)
{
    // caso ocorra uma exceção, exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}

?>
