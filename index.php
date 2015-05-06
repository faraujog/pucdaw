<?php
//verificar se existe o cookie
if (isset($_COOKIE['loginautomatico'])) {
    //se existe login automatico chama a página para verificar o logon
    header("Location:verificalogin.php"); 
}
else if (isset($_COOKIE['loginbook'])) //o ultimo login do usuário
    $nomeUsuario = $_COOKIE['loginbook'];
    else $nomeUsuario = "";
    
require_once("BD.php");
include_once("cabecalhobook.html");
?>

<div class="containerdologin">
<form role="form" method="post" action="verificalogin.php">
<h4 id="subtitulo">Favor fazer login no sistema</h4>    
    <div>
    <label for="loginsi">Nome de usuário:</label>    
    <input type="text" placeholder="Login" name="loginsi" value="<?php echo $nomeUsuario ?>" required autofocus>
        </div>
      <div>
      <label for="loginsi">Senha de acesso:</label> 
     <input type="password" placeholder="Senha" name="senha" required>
     </div>
          <label>
          <input type="checkbox"  name="lembrarLogin" value="loginusuario"> Permanecer conectado
        </label>
         <div >
         <button class="botoes" type="submit">Entrar</button>
		<button class="botoes" type="button" onclick="javascript:window.location.href='./cadastro.php'">Cadastrar-se</button>
          </div>
</form>    
</div>

<?php
    echo '<div class="blateral">';
    echo '<p id="titulo">Bem vindo ao Yeabook da turma de pós graduação da PUC Minas</p>';   
echo '<p id="textoindex">O Yeabook virtual da turma de Pós-Graduação do curso de Desenvolvimento de aplicações WEB ofertado pela PUC Minas, onde você pode visualizar o perfil dos alunos do curso e seus interesses.
			Para visualizar o perfil é necessário se cadastrar e realizar o login.</p>';
echo '<p id="textoindex">Alguns de nossos alunos:</p>';
 

try {
   $conexao = conn_mysql();
  
   $SQLSelect  = 'Select * From participantes where arquivoFoto <> ""';     
   $operacao = $conexao->prepare($SQLSelect);     
   $executar = $operacao->execute();  
   $resultados = $operacao->fetchAll();
    
        
    
    if (count($resultados)>0){
     ;
        
        echo '<ol id="thumb_listafotos">';    
              foreach($resultados as $alunosEncontrados){
              $nomealuno = utf8_decode($alunosEncontrados['nomeCompleto']);
              $foto = utf8_decode($alunosEncontrados['arquivoFoto']);
              $login = utf8_decode($alunosEncontrados['login']);
                           
            echo "<li><a href='perfil.php?pessoa=$login'><img heigth= 40 width = 40 class='miniatura' src=$foto alt=$login title=$nomealuno /></a></li>";
                
          }
         
        echo '</ol>';    
        echo '</div>'; 
        //if fim do resultados
        }
     	else{  // SE NAO TIVER FOTO MONTAR UM DIV LATERAL COM O INFORMATIVO
			echo"\n<h3>No momento não temos nenhum aluno cadastrado.</h3>";
		
		}


}
	catch (PDOException $e)
	{
    // caso ocorra uma exceção, exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
	}     
?>


