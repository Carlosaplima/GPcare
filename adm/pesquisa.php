<?php
 session_start();
       require("modulo.php");         
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pesquisa</title>
<script>
function retornaProd(c1)
{
	
window.opener.document.form1.t_id.value=c1;
window.opener.document.form1.submit();
window.close();
}

//-->
</script>

</head>

<?
if (isset($_GET['tabela'])){$tabela = $_GET['tabela'];}
if (isset($_POST['tabela'])){$tabela = $_POST['tabela'];}
if (isset($_POST['filtro'])){$filtro = $_POST['filtro'];}
if (isset($_POST['campo'])){$campo = $_POST['campo'];}

if (isset($_GET['idClinica'])){$idClinica = $_GET['idClinica'];}
if (isset($_POST['idClinica'])){$idClinica = $_POST['idClinica'];}
$where= "";
if (isset($idClinica)){
	// mona where
	$where = " where idClinica =$idClinica";
}

?>

<body>
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
  <input type="hidden" name="idClinica" id="idClinica" value="<? echo $idClinica; ?>" />
  <input type="submit" name="Filtrar" id="Filtrar" value="Filtrar" />
</label>
</form>
</p>


<table width="100%">
<?  
// prepara query
$query = "select * from $tabela $where";
//echo $query ;
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
</body>
</html> 