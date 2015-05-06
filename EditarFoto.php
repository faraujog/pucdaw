<?php
require_once("./authSession.php");
require_once("./BD.php");

var_dump($_FILES);

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
      $nomeUsuario = $_SESSION["nomeUsuario"]."/";	  
	  
	  if(!file_exists ( $dirUploads ))
			mkdir($dirUploads, 0500);  
	  
	  $caminhoUpload = $dirUploads.$nomeUsuario;
	  if(!file_exists ( $caminhoUpload ))
			mkdir($caminhoUpload, 0700); 
			
	  $pathCompleto = $caminhoUpload.basename($_FILES["fileName"]["name"]);
      if(move_uploaded_file($_FILES["fileName"]["tmp_name"], $pathCompleto))
           $sucesso = "Foto armazenado com sucesso";
          //echo "<h1>Armazenado em: <a href=\"./paginateste.php?imgfile=".htmlspecialchars($pathCompleto)."\"> $pathCompleto </a></h1>";
         
      else
		echo "<h1>Problemas ao armazenar o arquivo. Tente novamente.<h1>";
    }
  }
else
  {
  echo "<h1>Arquivo inválido<h1>";
  }

//fim do upload
// ---  agora atualiza a foto no bd ---

$conexao = conn_mysql();
$login = utf8_encode(htmlspecialchars($_SESSION["nomeUsuario"]));
	

        $SQLUpdate = 'UPDATE participantes SET arquivoFoto=? where login=?';
			
		$operacao = $conexao->prepare($SQLUpdate);					  
		
		$atualizacao = $operacao->execute(array($pathCompleto,  $login));
		
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

?> 