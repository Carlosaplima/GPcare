<?
       require("modulo.php");    
	   error_reporting(E_ALL ^ E_NOTICE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?  echo 'Editando '.$_GET['oque'];  ?></title>
</head>

<body>
<h1><?  echo $_GET['oque'];  ?></h1>
<a href="index.php" target="_self">Voltar</a>
<p>
  <? 


$oque = $_GET['oque'];

       // checa banco de dados se existe
      $result=mysqli_query($con, 'show tables');
      $bcos=mysqli_num_rows($result);
      if ($bcos==0){echo 'Sem Tabelas para exbir';exit;}
        $i = 0; $pode=0;
		while ($URLvalores = mysqli_fetch_array($result)){	 
		       //echo $URLvalores[0];
		       if ($oque==$URLvalores[0]) {$pode=1;break;};
        }        

        $cps = camposarq($oque);
		
$pesquisar = "";
$incluir="";
$excluir = "";
$alterar = "";

if (isset($_GET['pesquisar'])) {$pesquisar=$_GET['pesquisar'];}
if (isset($_POST['pesquisar'])) {$pesquisar=$_POST['pesquisar'];}
if (isset($_GET['pesquisa'])) {$pesquisa=$_GET['pesquisa'];}
if (isset($_POST['pesquisa'])) {$pesquisa=$_POST['pesquisa'];}
if (isset($_GET['checkbox'])) {$checkbox=$_GET['checkbox'];}
if (isset($_POST['checkbox'])) {$checkbox=$_POST['checkbox'];}

// quem é o campo a pesquisar?

if (isset($_POST['qualcampo'])) {$qualcampo=$_POST['qualcampo'];}
if (isset($_GET['qualcampo'])) {$qualcampo=$_GET['qualcampo'];}

//echo '---------------->'.$qualcampo.'-----------';

if (isset($_POST['apagar'])){
 mysqli_query($con, "truncate table ".$oque); 
}


if ($pesquisar){
if ($pesquisa) {
if ($checkbox) {
    $teste = "'%".trim($pesquisa)."%' ";
    }else{
    $teste = "'".trim($pesquisa)."%' ";
    }   
    $result=mysqli_query($con, "SELECT * FROM ".$oque." where ".$qualcampo." like ".$teste." order by ".$qualcampo  );
    }else{
    $result=mysqli_query($con, 'SELECT * FROM '.$oque.' order by '.$qualcampo);
    }
         $rows=mysqli_num_rows($result);		 
         while ($valores = mysqli_fetch_array($result)){
            $i = 0;         
             echo '<a href="?spw='.$spw.'&oque='.$oque.'&oxa='.$valores[0].'">'.$valores[0].' --- '.$valores[$qualcampo].'</a><br>';          
        }   
}

if (isset($_GET['incluir'])) {$incluir=$_GET['incluir'];}
if (isset($_POST['incluir'])) {$incluir=$_POST['incluir'];}

if ($incluir){
    if ($_POST[$cps[1][0]]=='') { 
	// sem nome para incluir, sai
                echo "<script language=\"Javascript\">";
                echo "window.open(\"edita.php?oque=".$oque."\",\"_self\")";
                echo "</script>";				
	 }
    $i = 0;
    $inclu = '';	
    $cps[0][0]='';
    for ($i==0;$i<count($cps);$i++){
         $inclu = $inclu."'".$_POST[$cps[$i][0]]."'," ;
    }
         $inclu = substr($inclu, 0, strlen($inclu)-1);
            $inclu = "INSERT INTO ".$oque." VALUES (".$inclu.")" ;
			mysqli_query($con, $inclu);
            $oxa = mysqli_insert_id($con);
}

if (isset($_GET['excluir'])) {$excluir=$_GET['excluir'];}
if (isset($_POST['excluir'])) {$excluir=$_POST['excluir'];}
if ($excluir){    
    if ($_POST[$cps[0][0]]=='') { 
	// sem id para alterar, sai
                echo "<script language=\"Javascript\">";
                echo "window.open(\"edita.php?oque=".$oque."\",\"_self\")";
                echo "</script>";
	 }

          mysqli_query($con, "delete from ".$oque." where id=".$_POST[$cps[0][0]]);    
}

if (isset($_GET['alterar'])) {$alterar=$_GET['alterar'];}
if (isset($_POST['alterar'])) {$alterar=$_POST['alterar'];}



if ($alterar) {	

    if ($_POST[$cps[0][0]]==='') { 
                echo "<script language=\"Javascript\">";
                echo "window.open(\"edita.php?oque=".$oque."\",\"_self\")";
                echo "</script>";
	 }
    $i = 0;
    $inclu = '';
    for ($i==0;$i<count($cps);$i++){ 	
         $inclu = $inclu.$cps[$i][0]."='".$_POST[$cps[$i][0]]."',";
    }
        $inclu = substr($inclu, 0, strlen($inclu)-1);
            $inclu = "UPDATE ".$oque." SET ".$inclu." where id=".$_POST[$cps[0][0]];
            mysqli_query($con, $inclu );			
            $oxa = $_POST[$cps[0][0]];
} 



if (isset($_GET['oxa'])) {$oxa=$_GET['oxa'];}
if (isset($_POST['oxa'])) {$oxa=$_POST['oxa'];}


if (isset($oxa)) {
     $result=mysqli_query($con, 'SELECT * FROM '.$oque.' where id='.$oxa);    
     $valores = mysqli_fetch_array($result);    
    }
    
  // monta formulario
        echo 'Manutenção de '.$oque;
        echo '<form name="form1" method="post" action="">';
        echo '<table>';
        echo '<tr><td>ID: </td><td>'.$valores[0].'</td></tr>';
     $i = 0;
	 
    for ($i==0;$i<count($cps);$i++){              
      // linha do formulario
      $valexi = $valores[$i];
      $nn = 0;
      if ($cps[$i][0]=='id') { $nn = 1; };    
      if ($cps[$i][0]=='datainc') {$valexi= date("Ymdhis");$nn = 1;};
      if ($cps[$i][0]=='datai') {$valexi= date("Y-m-d"); $nn = 1;};
      if ($cps[$i][0]=='horai') {$valexi= date("h:i:s"); $nn = 1;};
      if ($cps[$i][0]=='quem') {$valexi= 'admin'; $nn = 1;}; 	  
      $tcpo= $cps[$i][1];
      if ($tcpo>=50) {$tcpo=50;}  
      if ($nn==0) {
         $iii = $cps[$i][1];
         if ($iii=='0'){	
            echo '<tr><td width="60" height="21" valign="top">'.$cps[$i][0].'</td>';
            echo '<td width="100"><textarea name="'.$cps[$i][0].'" cols="30" rows="10" id="'.$cps[$i][0].'">'.$valexi.'</textarea></td></tr>';
            }else{
          echo '<tr><td width="60" height="21" valign="top">'.$cps[$i][0].'</td>';
          echo '<td width="100"><input name="'.$cps[$i][0].'" type="text" size="'.$tcpo.'" maxlength="'.$cps[$i][1].'" value="'.$valexi.'">';
		  
      if ($cps[$i][0]=='arquivo'){
      $coisas = $_POST[$cps[$i][0]];
	  $coisas = substr($coisas, (strlen($coisas)-3),  3);
	      if ($coisas=="jpg" || $coisas=="gif" || $coisas="png"){
	         //imagem			       
				   			 
	         echo '<img src ="'.$valexi.'">';
	      }
    }
		  echo '</td></tr>';
          }
	  }else{
	        echo '<tr><td width="60" height="21" valign="top"></td>';
      echo '<td width="250"><input name="'.$cps[$i][0].'" type="hidden" size="'.$cps[$i][1].'" maxlength="'.$cps[$i][1].'" value="'.$valexi.'"></td></tr>';

      }  
	     
     }
	 
    

     echo '</table> ';
     echo '<input name="oque"      type="hidden" value="'.$oque.'">';
     echo '<input name="incluir"   type="submit" value="incluir">'; 
     echo '<input name="alterar"   type="submit" value="alterar">';
     echo '<input name="excluir"   type="submit" value="excluir">';
     echo '<input name="limpar"    type="submit" value="limpar">';
     echo '<input name="Imagens"   type="submit" value="Imagens">';
     echo '<input name="checkbox" type="checkbox" value="1">Que contenha o texto<BR>'; 
     echo '<input name="pesquisa" type="text" size="50" maxlength="100">';
     echo '<input name="pesquisar" type="submit" value="pesquisar">';     
     echo '<input name="apagar" type="submit" value="Apagar Tudo">';     
	 

	 // qual campo pesquisar
      echo '<select name="qualcampo" id="qualcampo">';
  	  $sel = "";
	  if ($qualcampo=='id'){$sel='selected="selected"';}
	  echo '<option '.$sel.'>id</option>';

      for ($xi==0;$xi<count($cps);$xi++){
		  if ($cps[$xi][0]==''){continue;}
		  //echo '--->'.$cps[$xi][0];
		  $sel = "";
		  if ($cps[$xi][0]==$qualcampo){$sel='selected="selected"';}
		  echo '<option '.$sel.'>'.$cps[$xi][0].'</option>';
	  }	  
      echo '</select>';

	 
     echo '</form>';


function camposarq($arq){
	   global $con;
       $result=mysqli_query($con, 'DESCRIBE '.$arq);       
       $ct = 0;
       $campos = array();
       while ($row = mysqli_fetch_array($result)) {     
        $campo[$ct] [0]= $row[0];         
          if (strpos($row[1], "(")) {
              $ini = (strpos($row[1], "(")) ;
              $fim = (strpos($row[1], ")")) ;
              $tt = substr($row[1], $ini+1, $fim-($ini+1));          }       
          if ($row[1]=="double") {$tt = 15;};
          if ($row[1]=="time") {$tt = 8;};
          if ($row[1]=="date") {$tt = 12;};
          if (strpos($row[1], "text")) {$tt = 0;};
        $campo[$ct] [1]= $tt; 
        $ct++;              
       }
      mysqli_free_result($result);
        return $campo;
   }







?>

</body>
</html>