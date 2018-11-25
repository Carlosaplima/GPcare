<?php
       require("modulo.php");         
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administração</title>
</head>

<body>
Formularios:
<ul>
<?
    $result=mysqli_query($con, 'SELECT id, formulario FROM formularios order by formulario');    
         $rows=mysqli_num_rows($result);		 
         while ($valores = mysqli_fetch_array($result)){
            $i = 0;         
             //echo '<a href="?spw='.$spw.'&oque='.$oque.'&oxa='.$valores[0].'">'.$valores[0].' --- '.$valores[$qualcampo].'</a><br>';          
			 echo "<li><a href='?oque=$valores[0]'>$valores[1]</a></li>";
        } 
		mysqli_free_result($result);
		
?>
</ul>


<? 
if (isset($_GET['oque'])){	

    $idform = $_GET['oque'];
	$formulario = "";
    $campos = "";

	$result=mysqli_query($con, 'SELECT id, formulario, campos FROM formularios where id = '.$_GET['oque']);    
         $rows=mysqli_num_rows($result);		 
         while ($valores = mysqli_fetch_array($result)){
            $i = 0;         
         	$formulario = $valores[2];
			$campos = $valores[2];
        } 
		mysqli_free_result($result);

        // monta formulario com base nas questoes
		$pieces = explode("\n", $campos);
        //print_r($pieces);
		
		for ($i=0; $i<count($pieces); $i++){
 
             $campo = $pieces[$i];
			 // separo nome do campo, do rotulo
			 $cps=explode("¨", $campo);

             $ncampo=$cps[0];   // nome
			 $rotulo = $cps[1];
			 // quebro o rotulo para pegar só o rotulo
			 $cps=explode("|", $rotulo);
			 $rotulo = $cps[0];
			 
			 // se tiver cps 1 é pq pode ser multipla escolha, porem antes separo com subtitulo
			 $cab = "";
			 if (count($cps) >1){
			     $xcps=explode("^", $cps[1]);
	 			   if (count($xcps) >1){
				       $cab = $xcps[1];
					    $cps[1] = str_replace($xcps[1], "",  $cps[1]);
				   }
				   
				   $opcoes = NULL;;
				   // agora verifico se tem multiplas escolhas
				   $xcps=explode(",", $cps[1]);
				   
	   			    if (count($xcps) >1){
						// tenho multiplas escolhas
						for ($a; $a < count($xcps); $a++){
							$opcoes=explode(";",$xcps[$a]);
						}
					}
					
					// vamos exibir?
				if ($cab <> ""){
					echo "<h2>$cab</h2>";
				}					
				   echo $rotulo.': ';
				   
				   if (count($xcps) >1)  {
					   // texto simples
					   echo "<input type='text' id=''><BR>";
				   }else{
					   // select
					   echo "<select id=''>";
					   for ($p=0; $p<count($xcps); $p++){
						   echo "<option>$xcps[$p]</option>";
					   }
					   echo "</select><BR>";
				   }
				   
				   
			 }

			 
		}
}


?>


<BR />
<hr />


