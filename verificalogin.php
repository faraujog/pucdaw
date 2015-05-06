<?php
session_start();//para iniciar uma sessão

require_once("BD.php");
if(isset($_POST["loginsi"])){//verificando se o login foi enviado pelo POST

   $log   = utf8_encode(htmlspecialchars($_POST["loginsi"]));    
   $senha = utf8_encode(htmlspecialchars($_POST["senha"])); 
    if(isset($_POST["lembrarLogin"]))
    $lembrar = utf8_encode(htmlspecialchars($_POST["lembrarLogin"]));
    
    else
        $lembrar="";
}
elseif (isset($_COOKIE["loginautomatico"])){
 $log = utf8_encode(htmlspecialchars($_COOKIE["loginbook"]));
 $senha = utf8_encode(htmlspecialchars($_COOKIE["loginautomatico"]));
    
}
else{
    header("Location:erroLogin.php");
}

try
{
    $conexao = conn_mysql(); 
    
    $SQLSelect = 'SELECT * FROM  participantes where senha=MD5(?) AND login=?';
    
    //prepara a execução da sentença
    $operacao = $conexao->prepare($SQLSelect);
    
    //executa o sql
    $pesquisar = $operacao->execute(array($senha, $log));
    
    //capturar os resultados
    $resultados = $operacao->fetchAll();
    
    //fecha a conexao, pois os dados ja estao na variavel
    $conexao = null;
    
    //se há zero ou mais resultados, mensagem de login invalido
    if (count($resultados) != 1) {
         header("Location:erroLogin.php");
         die();
    }
    else { //se encontrar o usuario
        setcookie("loginbook", $log, time()+60*60*24*90); //guarda o login por 90 dias
           if(!empty($lembrar)) {
           setcookie("loginautomatico", $senha, time()+60*60*24*90); //guarda a senha por 90 dias
               
        }
           $_SESSION['auth']=true;
		   $_SESSION['nomeCompleto'] = $resultados[0]['nomeCompleto'];
		   $_SESSION['nomeUsuario'] = $log;
		   header("Location:principal.php");
		   die();    
        
    }
} //try

catch (PDOException $e)
	{
		// caso ocorra uma exceção, exibe na tela
		echo "Erro!: " . $e->getMessage() . "<br>";
		die();
	}

?>