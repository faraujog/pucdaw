<?php
include_once("cabecalhobook.html");
require_once("BD.php");
require_once("authSession.php");
?>
  

<?php

    // Se o comando não veio atraves da página principal
	if (!($_GET["alterarf"])=="SIM"){
		header("Location:./erroEdicao.php");
		die();
    }
?>
      

<main id="perfil">

  <div>
 <form  action="EditarFoto.php" method="post" enctype="multipart/form-data" class="form-signin" role="form">
		 <h3 >Alterar foto do perfil.</h3>
             <input type="hidden" name="MAX_FILE_SIZE" value="500000">
             <label for="fileName">Selecione uma foto:</label>
             <input type="file" name="fileName" id="fileName">  
             <button type="submit" class="btn btn-primary">Alterar Foto</button>
            </div>
      
	 </form>
       
	 </div>
    
    </main>
      <nav id='voltar'>
            <a href="principal.php">Voltar</a>
        </nav>

    

<?php
    include_once("rodapebook.html");
?>