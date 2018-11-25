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

if ($_POST['Selecionar']){
     // seta session com a Clinica
	 $_SESSION['CLINICA']=$_POST['idCli'];	
	 echo 'clinica selecionada'.$_SESSION['CLINICA'];
}

?>

<p>Seleção de Clinica para Gerenciamento</p>
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
    <input type="submit" name="Selecionar" id="Selecionar" value="Selecionar" />
    <input type="hidden" name="clinica" id="clinica" value="<? echo $clinica; ?>" />
    
  </label>

       <? if (isset($_SESSION['CLINICA'])){		      
	       // retorn clinica
		   	 $result=mysqli_query($con, 'SELECT * from clinicas where id ='.$_SESSION['CLINICA']);    
             $rows=mysqli_num_rows($result);		 
             while ($valores = mysqli_fetch_array($result)){
				     $xidCli= $valores[0];
                     $xnome = $valores[1];
                     $xrazao = $valores[2];                     
                     $xcidade = $valores[5];
                     $xestado = $valores[6];
					 break;
			 }				 
		mysqli_free_result($result);

		   echo "<p>$xidCli</p>";		   		   
		   echo "<h2>$xnome</h2>";
		   echo "<p>$xrazao</p>";		   		   
		   echo "<p>$cidade</p>";		   		   
		   echo "<p>$estado</p>";		   		   		   
	   }
		   
?>
  
  
  <p>&nbsp;</p>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
