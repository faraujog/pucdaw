<?php
include_once("cabecalhobook.html");
require_once("BD.php");
require_once("authSession.php");
?>
  

  <script type="text/javascript" src="js/jquery-1.7.2.js"></script>
  <script type="text/javascript">
$(document).ready(function(){
           
        $("select[name=estados]").change(function(){
         var idUF = $(this).val();   
                     
           $("select[name=cidades]").html('<option value="0">Carregando...</option>'); 
            $.post("cidades.php?id="+idUF,
                  {estado:$(this).val()},
                  function(valor){
                      
                       $("select[name=cidades]").html(valor);
                      }
                  )
            })  
            }) 

function editar(){ 
   if (confirm('Tem certeza que deseja alterar seu perfil?')){ 
      document.formeditar.submit() 
   }
    else
	{
		return false;
	}
} 


   </script> 


<?php

try
{
	// Se o comando não veio atraves da página principal
	if (!($_GET["editar"])=="SIM"){
		header("Location:./erroEdicao.php");
		die();
	}
	//se veio pela página principal
	else{
         $conexao = conn_mysql();  

        
        $logineditar =  utf8_encode(htmlspecialchars($_SESSION["nomeUsuario"]));
        				        
        $SQLSelect = 'Select participantes.login, participantes.nomeCompleto, participantes.arquivoFoto, participantes.descricao, participantes.email,cidades.nomecidade, cidades.idcidade, cidades.idestado, estados.nomeestado FROM participantes, cidades, estados WHERE login =? and participantes.cidade = cidades.idcidade and cidades.idestado = estados.idestado';
        
         $operacao  = $conexao->prepare($SQLSelect);					  
		
		 $executar = $operacao->execute(array($logineditar));
         
         $resultados = $operacao->fetchAll();
		
  		 $conexao = null;
        
        }

}
catch (PDOException $e)
{
echo "Erro!: " . $e->getMessage() ."<br>";
die();
}

?>
      

<main class="container">

  <div>
 <form name="formeditar" role="form"  method="post" action="editarAluno.php" enctype="multipart/form-data">
		 <h3 >Editar Perfil</h3>
			  <div>
				<label for="InputNome">Nome Completo:</label>
				<input type="text" id="InputNome" name="nomecompleto" placeholder="Nome completo" required autofocus value="<?php echo (utf8_decode($resultados[0]['nomeCompleto']))?>">
			  </div>
             
              <div>
				<label for="InputNome">Email:</label>
				<input type="email" id="InputNome" name="email" placeholder="seuemail@email.com" required autofocus value="<?php echo (utf8_decode($resultados[0]['email']))?>">
			  </div>
             
			  <div>
				<label for="InputSenha">Nova Senha:</label>
				<input type="password" id="InputSenha" name="senhausuario" placeholder="Senha (4 a 8 caracteres)"  required autofocus>
			  </div>
             
			  <div>
				<label for="InputSenhaConf">Confirmação de Senha:</label>
				<input type="password"  id="InputSenhaConf" name="confsenha" placeholder="Confirme a senha" required autofocus>
			  </div>
             
                <div>
				<label for="estados">Seleciona o Estado:</label>
				<select id="estados" name="estados">
                        <option value="">Selecione o Estado</option>
                <?php
                     
                     $conexao = conn_mysql();
                     $SQLEstado = 'SELECT * FROM estados';
                     $operacao1 = $conexao ->prepare($SQLEstado);
                     $pesquisar = $operacao1->execute();
                     $resultadosUF = $operacao1->fetchAll();
                     $conexao = null;   
                     
                   if (count($resultadosUF) > 0) {
                                              
                         foreach ($resultadosUF as $UFencontradas ){
                            $idUF = $UFencontradas['idEstado'];
                             $nomeUF = utf8_encode($UFencontradas['nomeEstado']);
                             echo "<option value='$idUF'>$nomeUF</option>";  
                             
                         }
                     } else {
                         
                     echo "<option>ERRO - Não foi possível carregar os estados</option>";
                     }
                ?>
                    </select>
                 </div>
                                            
           
          
          <div>
				<label for="cidades">Seleciona a Cidade:</label>
				
                  
                  <select id="cidades" name="cidades" > 
                    <option>Escolha um estado</option>
                    </select>
                </div>
             
               <div>
				<label for="descricao">Descreva você:</label>
				<textarea name="descricao" placeholder="Fale um pouco de você" ><?php echo utf8_decode($resultados[0]['descricao'])?></textarea>
			  </div>
                                  
                    
			  <button class="botoes" type="submit" onclick="editar()" class="btn btn-primary">Alterar</button>
		 </form>
       
	 </div>
    
    </main>
      <nav id='voltar'>
            <a href="principal.php">Voltar</a>
        </nav>

    

<?php
    include_once("rodapebook.html");
?>


