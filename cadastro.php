<?php
include_once("cabecalhobook.html");
require_once("BD.php");
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
   </script>  


          
<div class="container">

      <div>
        <form method="post" action="novousuario.php" enctype="multipart/form-data"  class="form-signin">
		 <h3>Cadastro de Usuário</h3>
			  <div>
				<label for="InputNome">Nome Completo:</label>
				<input type="text"  id="InputNome" name="nomecompleto" placeholder="Nome completo" required autofocus>
			  </div>
             
              <div>
				<label for="InputNome">Email:</label>
				<input type="email" id="InputNome" name="email" placeholder="seuemail@email.com" required autofocus>
			  </div>
             
			  <div>
			  <label for="InputLogin">Login:</label>
				<input type="text"  id="InputLogin" name="nomeusuario" placeholder="Login desejado" required>
			  </div>
             
			  <div>
				<label for="InputSenha">Senha:</label>
				<input type="password" id="InputSenha" name="senhausuario" placeholder="Senha (4 a 8 caracteres)" required autofocus>
			  </div>
             
			  <div>
				<label for="InputSenhaConf">Confirmação de Senha:</label>
				<input type="password" id="InputSenhaConf" name="confsenha" placeholder="Confirme a senha" required autofocus>
			  </div>
             
                <div>
				<label for="estado">Seleciona o Estado:</label>
				<select id="estados" name="estados">
                        <option value="0">Escolha um Estado</option>
                <?php
                     
                     $conexao = conn_mysql();
                     $SQLEstado = 'SELECT * FROM estados';
                     $operacao1 = $conexao ->prepare($SQLEstado);
                     $pesquisar = $operacao1->execute();
                     $resultados = $operacao1->fetchAll();
                     $conexao = null;   
                     
                     if (count($resultados) > 0) {
                          
                             foreach ($resultados as $UFencontradas ){
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
				  <label for="cidade">Seleciona a Cidade:</label>
                  <select id="cidades" name="cidades"> 
                  <option>Escolha um estado</option>
                  </select>
                  </div>
             
                 <div>
				 <label for="descricao">Descreva você:</label>
				 <textarea name="descricao" placeholder="Fale um pouco de você"></textarea>
			     </div>
              
            <div>
            <input type="hidden" name="MAX_FILE_SIZE" value="500000">
            <label for="fileName">Selecione uma foto:</label>
            <input type="file" name="fileName" id="fileName" placeholder="Escolha uma foto">      </div>
            <button type="submit" class="botoes">Cadastrar</button>
	<button class="botoes" type="button" onclick="javascript:window.location.href='./index.php'">Cancelar</button>
        </form>
       
     </div>
     </div>

<?php
include_once("rodapebook.html");
?>


