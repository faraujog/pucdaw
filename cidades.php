<?php
require_once("BD.php");
//header( 'Cache-Control: no-cache' );
//header( 'Content-type: application/xml; charset="utf-8"', true );


//recuperar o select estado

$estado = $_GET['id'];
$conexao = conn_mysql();

$SQLCidade = 'SELECT idCidade, nomeCidade FROM cidades WHERE idEstado=?';
$operacaocid = $conexao->prepare($SQLCidade); 
$operacaocid->execute(array($estado));
$cidades = $operacaocid->fetchAll(PDO::FETCH_ASSOC);
$conexao = null;

 if ($cidades == 0) {
    
    echo '<option value="0">ERRO - Não cidades nesse estado</option>';
 } 
else{
          foreach ($cidades as $acheicidades){
             echo  "<option value=\"".$acheicidades['idCidade']."\">".
                            utf8_encode($acheicidades['nomeCidade'])."</option>";
              echo "<p>".utf8_encode($acheicidades['nomeCidade'])."</p>";
            
           }
    
}
     
?>