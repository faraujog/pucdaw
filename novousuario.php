<?php
require_once("BD.php");
include_once("cabecalhobook.html");


$permissoes = array("gif", "jpeg", "jpg", "png", "image/gif", "image/jpeg", "image/jpg", "image/png");  
$temp = explode(".", basename($_FILES["fileName"]["name"])); 
$extensao = end($temp);

if ((in_array($extensao, $permissoes))
&& (in_array($_FILES["fileName"]["type"], $permissoes))
&& ($_FILES["fileName"]["size"] < $_POST["MAX_FILE_SIZE"]))
  {
  if ($_FILES["fileName"]["error"] > 0)
    {
    echo "<h1>Erro no envio, código: " . $_FILES["fileName"]["error"] . "</h1>";
    }
  else
    {
	  $dirUploads = "uploads/";
      $nomeUsuario = $_POST["nomeusuario"]."/";	  
	  
	  if(!file_exists ( $dirUploads ))
			mkdir($dirUploads, 0500);  
	  
	  $caminhoUpload = $dirUploads.$nomeUsuario;
	  if(!file_exists ( $caminhoUpload ))
			mkdir($caminhoUpload, 0700); 
			
	  $pathCompleto = $caminhoUpload.basename($_FILES["fileName"]["name"]);
      if(move_uploaded_file($_FILES["fileName"]["tmp_name"], $pathCompleto))
          $sucesso = "Foto armazenado com sucesso";
      else
		echo "<h1>Problemas ao armazenar o arquivo. Tente novamente.<h1>";
    }
  }
else
  {
  echo "<h1>Arquivo inválido<h1>";
  }

//fim do upload


try
{
	   //instancia objeto PDO, conectando-se ao mysql
		$conexao = conn_mysql();
		
		//captura valores do vetor POST
		//utf8_encode para manter consistência da codificação utf8 nas páginas e no banco
		$nome          = utf8_encode(htmlspecialchars($_POST['nomecompleto']));
        $email         = utf8_encode(htmlspecialchars($_POST['email']));
		$login         = utf8_encode(htmlspecialchars($_POST['nomeusuario']));
		$senha         = utf8_encode(htmlspecialchars($_POST['senhausuario']));
		$senhaConf     = utf8_encode(htmlspecialchars($_POST['confsenha']));
        $descricao     = utf8_encode(htmlspecialchars($_POST['descricao']));
        $cidadepart    = utf8_encode(htmlspecialchars($_POST['cidades']));
		$caminhodafoto = $pathCompleto;
    
		if(($senha!=$senhaConf)||(strlen($senha)<4)||(strlen($senha)>8)){
		header("Location:./erroCadastro.php");
		die();
		}
		
		// cria instrução SQL parametrizada
		$SQLInsert = 'INSERT INTO participantes (login, senha, nomeCompleto, arquivoFoto, cidade, email, descricao)
			  		  VALUES (?,MD5(?),?,?,?,?,? )';
					  
		//prepara a execução
		$operacao = $conexao->prepare($SQLInsert);					  
		
		//executa a sentença SQL com os parâmetros passados por um vetor
		$inserir = $operacao->execute(array($login, $senha, $nome, $caminhodafoto, $cidadepart, $email, $descricao));
		
		// fecha a conexão ao banco
		$conexao = null;
		
		
		if ($inserir){
			 echo "<h1>Cadastro efetuado com sucesso.</h1>\n";
			 echo "<p class=\"lead\"><a href=\"./index.php\">Página principal</a></p>\n";
		}
		else {
			echo "<h1>Erro na operação.</h1>\n";
				$arr = $operacao->errorInfo();		
				$erro = utf8_decode($arr[2]);
				echo "<p>$erro</p>";							
			    echo "<p><a href=\"./cadastro.php\">Retornar</a></p>\n";
		}
    }

catch (PDOException $e)
{
    
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}

include_once("rodapebook.html");

?>