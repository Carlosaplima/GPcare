<?php
       require("modulo.php");         
?>

<script>
function popserv(oque)
{
var newWin;
	newWin =window.open("pesquisa.php?tabela="+oque,"kidserv",'resizable=yes,scrollbars=yes')
	return false;
}
</script>


<p><a href = "index.php">Voltar</a></p>
<?
// abre Clinica
if ($_POST['Abrir']){
             $result=mysqli_query($con, 'SELECT * from clinicas where id = '.$_POST['idCli']);   
			 
             $rows=mysqli_num_rows($result);		 
             while ($valores = mysqli_fetch_array($result)){
				     $idCli= $valores[0];
					 $clinica = $idCli;
                     $nome = $valores[1];
                     $razao = $valores[2];                     
                     $cidade = $valores[5];
                     $estado = $valores[6];	
					 unset($_POST['clinica']);
             } 
		mysqli_free_result($result);
	
}

if ($_POST['clinica']){
             $result=mysqli_query($con, 'SELECT * from clinicas where id = '.$_POST['clinica']);   
			 
             $rows=mysqli_num_rows($result);		 
             while ($valores = mysqli_fetch_array($result)){
				     $idCli= $valores[0];
					 $clinica = $idCli;
                     $nome = $valores[1];
                     $razao = $valores[2];                     
                     $cidade = $valores[5];
                     $estado = $valores[6];
             } 
		mysqli_free_result($result);
	
}


if ($_POST['excluir']){
		 $inclu= "delete from userCli where id=".str_replace('X_',"",$_POST['excluir']);
		// echo '---=-'.$inclu;
		 mysqli_query($con, $inclu);
}

if ($_POST['Atribuir']){
	//atribuo clinica a idform
	//id	idForm	idClinica	sit
		 $inclu= "insert into userCli (id, idUser, idClinica, sit) values (0,".$_POST['idUser'].",".$_POST['clinica'].",'')";
		 mysqli_query($con, $inclu);
}

?>

<p>Atribuição de Usuários para Clinicas</p>
<p>Selecione a Clinica</p>
<form id="form1" name="form1" method="post" action="">
  <label>
    <select name="idCli" id="idCli">
    <?
             $result=mysqli_query($con, 'SELECT * from clinicas order by nome');    
             $rows=mysqli_num_rows($result);		 
             while ($valores = mysqli_fetch_array($result)){
				     $sel = "";
					 if ($idCli ==$valores[0]){$sel="selected = 'selected'";}
				     $xidCli= $valores[0];
                     $xnome = $valores[1];
                     $xrazao = $valores[2];                     
                     $xcidade = $valores[5];
                     $xestado = $valores[6];
					 echo "<option value ='$xidCli' $sel>$xnome-$xcidade/$xestado</option>";                     
             } 
		mysqli_free_result($result);
		
		
?>
    </select>
    <input type="submit" name="Abrir" id="Abrir" value="Abrir" />
    <input type="hidden" name="clinica" id="clinica" value="<? echo $clinica; ?>" />
    
    

  </label>

       <? if ($idCli){
		      
		   echo "<p>$clinica</p>";		   		   
		   echo "<h2>$nome</h2>";
		   echo "<p>$cidade/$estado</p>";		   
		   
		   
		   	// mostra usuarios disponiveis
			echo '<select name="idUser" id="idUser">';
	         $result=mysqli_query($con, 'SELECT id, user from usuarios where id not in (select idUser from userCli where idClinica='.$idCli.")");    
             $rows=mysqli_num_rows($result);		 
             while ($valores = mysqli_fetch_array($result)){
				     $idUser= $valores[0];
                     $idNome = $valores[1];
					 echo "<option value = '$idUser'>$idUser-$idNome</option>";                     
             } 
		mysqli_free_result($result);		   
			echo '</select>';
            echo '<input type="submit" name="Atribuir" id="Atribuir" value="Atribuir" />';
		   
		   //id	idForm	idClinica	sit

		   // exibo os usuários do cliente		
             $result=mysqli_query($con, 'SELECT a.idUser, b.user, a.id  from userCli as a inner join usuarios as b on a.idUser =b.id where idClinica='.$idCli);    
             $rows=mysqli_num_rows($result);		 
             while ($valores = mysqli_fetch_array($result)){
				     $idForm= $valores[0];
                     $idNome = $valores[1];
					 $iddel = $valores[2];
					 echo "<p> <input type='submit' id='excluir' name = 'excluir' value = 'X_$iddel'> $iddel - $idForm - $idNome</p>";                     
             } 
		mysqli_free_result($result);		   
	   }
?>
  
  
  <p>&nbsp;</p>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
