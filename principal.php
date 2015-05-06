<?php
require_once("authSession.php");
require_once("BD.php");
include_once("cabecalhobook.html");
?>
 
<script type="text/javascript">
function sair(){
	var conf = confirm("Realmente deseja sair?");
	if (conf==true)
	{
		window.location.href="sair.php";
	}
	else
	{
		return false;
	}
}
    
function excluir(){
	var conf = confirm("Realmente deseja apagar seu perfil?");
	if (conf==true)
	{
		window.location.href="excluir.php?apagar=SIM";
	}
	else
	{
		return false;
	}
}    
</script>    

 <nav id=menutopo>
 <form id="buscaalunos" role="form" method="post" action="./principal.php">
       Pesquisar Alunos: <input type="text" placeholder="Nome" name="filtro" >
       <button type="submit" >Buscar</button>
	   </form>
       <ul>
          <li>
            <?PHP echo "Usuário: ".utf8_decode($_SESSION['nomeCompleto'])."";?> 
         </li>
         <li>
       <a href="editar.php?editar=SIM">Editar Perfil</a>
        </li>
        <li>
        <a href="AlterarFoto.php?alterarf=SIM">Alterar Foto</a>
        </li>
           <li>
          <a href="#" onclick="return excluir()">Excluir Perfil</a>
          </li>
             <li>
          <a href="#" onclick="return sair()">Sair</a>
          </li>
        </ul>
        </nav>  
 

<?php
try {
   $conexao = conn_mysql();
  
  if(!empty($_POST['filtro'])){ //tem conteudo
   $nomebusca = utf8_encode(htmlspecialchars($_POST['filtro']));
   $nomebusca = "%".$nomebusca."%";
   $SQLSelect = 'Select * From participantes where nomeCompleto like ?';     
   $operacao = $conexao->prepare($SQLSelect);     
   $executar = $operacao->execute(array($nomebusca));
}else //nao tem pesquisa
{
   $SQLSelect  = 'Select * From participantes';     
   $operacao = $conexao->prepare($SQLSelect);     
   $executar = $operacao->execute();  
}    
    
$resultados = $operacao->fetchAll();

        
        if (count($resultados)>0){
        echo '<section>';
        echo '<ol id="listafotos">';    
              foreach($resultados as $alunosEncontrados){
              $nomealuno = utf8_decode($alunosEncontrados['nomeCompleto']);
              $foto = utf8_decode($alunosEncontrados['arquivoFoto']);
              $login = utf8_decode($alunosEncontrados['login']);
              echo "<li><a href='perfil.php?pessoa=$login'><figure class='fotoalunos'><img class='alunos' src='$foto' alt=$nomealuno title='Clique para acessar o perfil' /><figcaption>$nomealuno</figcaption></figure></a></li>";
                
          }
        echo '</ol>';    
        echo '</section>'; 
        //if fim do resultados
        }
     	else{
			echo"\n<h3 class=\headerprincipal\>Nenhum aluno encontrado.</h3>";
		
		}


}
	catch (PDOException $e)
	{
    // caso ocorra uma exceção, exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
	}     
?>

<?php
include_once("rodapebook.html");
?>