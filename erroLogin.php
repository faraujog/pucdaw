<?php
setcookie("loginusuario", '', time()-42000); 
setcookie("loginautomatico", '', time()-42000); 

include_once("cabecalhobook.html");;

?>

    <div class="container">

      <div>
        <h1>Não foi possível realizar o login.</h1>
		<p><a href="./index.php">Tente novamente.</a></p>
        
	 </div>

	  
	  
    </div>

<?php
include_once("rodapebook.html");
?>