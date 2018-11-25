<script>
function retornaProd(c1)
{
	
window.opener.document.form1.t_id.value=c1;
window.opener.document.form1.submit();
window.close();
}

//-->
</script>

<?
$tabela = "movimentos";
if (isset($_POST['filtro'])){$filtro = $_POST['filtro'];}
if (isset($_POST['campo'])){$campo = $_POST['campo'];}
if (isset($_GET['idClinica'])){$idClinica = $_GET['idClinica'];}
if (isset($_POST['idClinica'])){$idClinica = $_POST['idClinica'];}
$idClinica = $_SESSION['CLINICA'];
$where= "";
if (isset($_SESSION['CLINICA'])){
	// mona where
	$where = " where idCli =$idClinica";
}

?>

<p>
<form id="form1" name="form1" method="post" action="">
  <label>
    Pesquisa por 
    <input name="filtro" type="text" id="filtro" value="<? echo $filtro; ?>" />
  </label>
no campo 
<label>
  <select name="campo" id="campo">
  <? 
  // preencher campo
       $result=mysqli_query($con, 'DESCRIBE '.$tabela);       
       $ct = 0;	   
       $NOMEs = array();
       while ($NOMErow = mysqli_fetch_array($result)) {     
	         $sel = "";
			 $NOMEs[$ct]=$NOMErow[0];
			 if ($NOMErow[0] == $campo){$sel = "selected='selected'";}
             echo "<option $sel>$NOMErow[0]</option>";         
			 $ct++;
       }
      mysqli_free_result($result);
  ?>
  
  </select>
</label>
<label>
  <input type="hidden" name="tabela" id="tabela" value="<? echo $tabela; ?>" />
  <input type="submit" name="Filtrar" id="Filtrar" value="Filtrar" />
</label>
</form>
</p>


<table width="100%">
<?  
// prepara query
$query = "select * from $tabela $where";
       $result=mysqli_query($con, $query);       
	   $ct = 0 ;
	    while ($row = mysqli_fetch_array($result)) {     
		
     		if ($ct==0){
				echo '<tr>';
				for ($i=0; $i<count($NOMEs); $i++){
			         echo "<td>$NOMEs[$i]</td>";	 
   			    }    			
				echo '</tr>';
			}
		
		     echo '<tr>';
		     for ($i=0; $i<count($row); $i++){
         			  $cli = 'onClick="retornaProd( '."'".$row[0]."'".')"';
			         echo "<td><a href='#' $cli>$row[$i]</a></td>";	 
			  }
	         echo '</tr>';
			 $ct++;
        }
       mysqli_free_result($result);


?>
</table>
