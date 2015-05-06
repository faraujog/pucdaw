<?php
require_once("authSession.php");
require_once("BD.php");
include_once("cabecalhobook.html");
?>

<?php

try
{
	// Se o comando não veio atraves da página principal
	if (($_GET["pessoa"])==""){
		header("Location:./erroPerfil.php");
		die();
	}
	//se veio pela página principal
	else{
         $conexao = conn_mysql();  

        $perfil = ($_GET["pessoa"]);
				
		 $SQLSelect = 'Select login, nomeCompleto, arquivoFoto, descricao, email, nomecidade FROM participantes, cidades WHERE login = ? and participantes.cidade = cidades.idcidade'; 
         
		 $operacao  = $conexao->prepare($SQLSelect);					  
		
		 $executar = $operacao->execute(array($perfil));
         
         $resultados = $operacao->fetchAll();
		
		 $conexao = null;
              echo "<main id='perfil'>";
              if (count($resultados)>0){
               
              foreach($resultados as $alunoEncontrado){
              $nomealuno = utf8_decode($alunoEncontrado['nomeCompleto']);
              $email     = utf8_decode($alunoEncontrado['email']);  
              $cidade    = utf8_decode($alunoEncontrado['nomecidade']); 
              $descricao = utf8_decode($alunoEncontrado['descricao']);        
              $foto      = utf8_decode($alunoEncontrado['arquivoFoto']);
               echo "<figure><img id='imgpessoal' src='$foto' alt=$nomealuno title='Foto de $nomealuno' width='240' height='320'/></figure>";
              echo "<div id='texto'>";  
              echo "<p><strong>Nome:</strong>$nomealuno</p>";     
              echo "<p><strong>Cidade:</strong>$cidade</p>";
              echo "<p><strong>E-mail:</strong>$email</p>";
              echo "<p><strong>Descrição:</strong>$descricao</p>";
              echo "</div>";      
          }
             
        //if fim do resultados
        }
         echo "</main>";
      
       
        }
}
catch (PDOException $e)
{
echo "Erro!: " . $e->getMessage() ."<br>";
die();
}

?>
        <nav id='voltar'>
            <a href="principal.php">Voltar</a>
        </nav>

<?php
include_once("rodapebook.html");
?>