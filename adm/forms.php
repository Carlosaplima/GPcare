<?
session_start();
$idCli= $_SESSION['CLINICA'];

if ($_POST['executar']){
		 // executa formulario
		 $idexe = str_replace("executar_", "", $_POST['executar']);
		 echo "<script language=\"Javascript\">";
                echo "window.open(\"executa.php?oque=".$idexe."\",\"_blank\")";
                echo "</script>";
	 }


echo '<form method="post">';

		   // exibo os formularios do cliente		
             $result=mysqli_query($con, 'SELECT a.idform, b.formulario, a.id  from formCli as a inner join formularios as b on a.idForm =b.id where idClinica='.$idCli);    
             $rows=mysqli_num_rows($result);		 
             while ($valores = mysqli_fetch_array($result)){
				     $idForm= $valores[0];
                     $idNome = $valores[1];
					 $iddel = $valores[2];
					 echo "<p> $iddel - $idForm - $idNome <input type='submit' id='executar' name = 'executar' value = 'executar_$idForm'></p>";                     
             } 
		mysqli_free_result($result);		   
echo '</form>';


?>