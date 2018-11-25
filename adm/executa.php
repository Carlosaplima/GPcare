<?php
       require("modulo.php");         
?>
<script>

function validateForm() {
    var tipo = document.forms["pesquisa"]["tipox"].value;
		
	if (tipo=="Resposta Simples"){
		// testa só o resposta
		    if (document.forms["pesquisa"]["resposta"].value==""){
                  alert("Preencha a Resposta");				
				  return false;
			}
	}
	
	if (tipo=="Multipla Escolha"){
		// testa só RadioGroup1	
		if (document.forms["pesquisa"]["resposta"].value==""){
                  alert("Selecione uma Resposta");				
				  return false;
			}
	}
	
	if (tipo=="Varias Escolhas_nada"){
        //  testa só CheckboxGroup1	
       var checkboxs=document.getElementsByName("resposta");
           var okay=false;
           for(var i=0,l=checkboxs.length;i<l;i++)
                {
                if(checkboxs[i].checked)
                   {
                         okay=true;
                         break;
                   }
                 }		
				
				if (!okay){
                  alert("Selecione uma Resposta");				
				  return false;
			    }
	}
     return true;
	}	
	


</script>
<? 

if (isset($_POST['primeiraVez'])) {
     	$primeiraVez=$_POST['primeiraVez'];
	}


if (isset($_POST['oque'])) {$oque=$_POST['oque'];}
if (isset($_POST['indice'])) {$indice=$_POST['indice'];}
if (isset($_POST['contador'])) {$contador=$_POST['contador'];}else{$contador=0;}
if (isset($_POST['idQuest'])) {$idQuest=$_POST['idQuest'];}
if (isset($_POST['idResp'])) {$idResp=$_POST['idResp'];}

if (isset($_GET['oque'])) {$oque=$_GET['oque'];}
if (isset($_GET['indice'])) {$indice=$_GET['indice'];}
if (isset($_GET['idQuest'])) {$idQuest=$_GET['idQuest'];}
if (isset($_GET['idResp'])) {$idResp=$_GET['idResp'];}

if (isset($_POST['rows'])) {$rows=$_POST['rows'];}
if (isset($_POST['idGravado'])) {$idGravado=$_POST['idGravado'];}

if (isset($_POST['perg'])) {$perg=$_POST['perg'];}
if (isset($_POST['resposta'])) {$resposta=$_POST['resposta'];}
if (isset($_POST['separador'])) {$separador=$_POST['separador'];}
if (isset($_POST['tipo'])) {$tipo=$_POST['tipo'];}


         $result=mysqli_query($con, 'SELECT count(id) FROM questoes where idForm = '.$oque);  
         while ($valores = mysqli_fetch_array($result)){ 
		      $totalQuest = $valores[0];
         } 		
		mysqli_free_result($result);


   if (!isset($primeiraVez)){
	// apago tudo que tiver com 0 nos ids
		 $inclu = "delete from movimentos where idPac=0 and idCli=0 and idUser=0 and idForm	=" . $oque;
			//echo $inclu;
			mysqli_query($con, $inclu); 
	}
			
			$primeiraVez="nao";			



if ($indice==""){$indice=0;}
if (!isset($idQuest) || $idQuest=="" || strlen($idQuest)==0 ||  is_null($idQuest) ){$idQuest="0";}


	// Avançar
     if ($_POST['Avancar']){
		 // insere movimento no formulario	
         $contador ++;
         $quando = date("Ymdhis");
         $dia = date("d/m/Y"); 	
         $hora = date("h:i:s"); 	
        
         if ($tipo=="Varias Escolhas"){
			 $resp = $resposta;
			 $resposta = "";
			      foreach($resp as $check) {
                      $resposta = $resposta.$check.$separador;                        
                  }     
		  }

		 $inclu = "insert into movimentos (idPac,idCli,idUser,idForm,idResp,questao,resposta,quando,data,hora,sit) values (0,0,0,$oque,$idQuest,'$perg','$resposta', '$quando','$dia','$hora','')";
     	 //echo '--->'.$inclu;

			 mysqli_query($con, $inclu);            
			 $idResp = mysqli_insert_id($con);
			 
			 
			 // foi a ultima?
			 if ($contador ==  $totalQuest){
				 // acabou o formulario
				 die ("Questionário Completo");
			 }
	 }
	 

      //Caso seja um avançar, então gravo o registrio
      //id	idPac	idCli	idUser	idForm	idResp	questao	resposta	quando	data	hora	sit



	 $tipo ="";
 	 $pergunta ="";
	 $respostas ="";
	 $separador ="";
	 
	 	// carrega form caso tenha id
        //echo '----->'.$_POST['Voltar'];

         if (isset($_POST["Voltar"])){  
		     $contador --;
    		 $indice = $indice -1;
			 if ($indice == 0 ){
				 $indice = 1;
				 $query = 'SELECT id, tipo, pergunta, respostas, separador FROM questoes where idForm = '.$oque.' and id = '. $idQuest. ' order by id desc limit 1';
			 }else{
				 $query = 'SELECT id, tipo, pergunta, respostas, separador FROM questoes where idForm = '.$oque.' and id < '. $idQuest. ' order by id desc limit 1';
			 }		     
		  }else{
 		     $indice = $indice +1;
			 if ($indice> $totalQuest){
				 $indice =  $totalQuest;
				 $query = 'SELECT id, tipo, pergunta, respostas, separador FROM questoes where idForm = '.$oque.' and id = '. $idQuest. ' order by id desc limit 1';			              }else{					  
                 $query = 'SELECT id, tipo, pergunta, respostas, separador FROM questoes where idForm = '.$oque.' and id > '. $idQuest.' order by id limit 1';  
			 }
		 }

         //echo $query;

         $result=mysqli_query($con, $query);  			 		 
         $rows=mysqli_num_rows($result);		 
         while ($valores = mysqli_fetch_array($result)){ 
			 	 $idQuest =$valores[0];
            	 $tipo =$valores[1];
            	 $pergunta =$valores[2];
            	 $respostas =$valores[3];
             	 $separador =$valores[4];
        } 
		mysqli_free_result($result);

	
	
	// monta form
?>
	
     <form method="post" name="pesquisa" onsubmit="return validateForm();">


      <p><?  echo $indice.'/'.$idQuest.'  -  '.$idGravado; ?></p>
      <h1><?  echo $pergunta; $perg = $pergunta; ?></h1>
       <hr />
  <p>&nbsp;</p>
          <!-- 
		  <option>Resposta Simples</option>
          <option>Multipla Escolha</option>
          <option>Varias Escolhas</option>
		  -->


<? if ($tipo=="Resposta Simples"){ ?>
       <div>
       <label>
          <textarea name="resposta" id="resposta" cols="100%" rows="5"></textarea>
          <br />
       </label>
        </div>

      <? }else{
                     if ($tipo=="Multipla Escolha"){ 
                        echo "<div>";
                        // quebro as opções por enter
                   	   $oo = explode("\n", $respostas);				 
                             for($i=0; $i <=count($oo); $i++){
                     			 if (trim($oo[$i])==""){continue;}
			            		   ?>
                                   <p>
                                   <label>
                                   <input type="radio" name="resposta" value="<? echo trim($oo[$i]); ?>" id="resposta" />
                                    <? echo trim($oo[$i]); ?></label>                 
                                   
                                   </p>
					               <?					             
                             }
                      echo "</div>";					     
                   }else{ 
                      echo "<div>";  
                	   $oo = explode("\n", $respostas);		

                             for($i=0; $i <=count($oo); $i++){
                				 //$oo[$i]= trim($oo[$i]);
                				 if (trim($oo[$i])==""){continue;}                        					   ?>
                                     <p>
             				       <label>
                                   <input type="checkbox" name="resposta[]" value="<? echo trim($oo[$i]); ?>" id="resposta" />
                                    <? echo trim($oo[$i]); ?>                  
                                   </label>
                                   </p>
					                 <?			            
		                     } 		 
                        echo "<div>";
                    } 
        }  ?>
  <p>
       
       <hr />
        <input type="hidden" name="oque" id="oque" value = "<? echo $oque; ?>"/>
        <input type="hidden" name="indice" id="indice" value = "<? echo $indice; ?>"/>
        <input type="hidden" name="idQuest" id="idQuest" value ="<? echo $idQuest; ?>"/>
        <input type="hidden" name="tipox" id="tipox" value ="<? echo $tipo; ?>"/>
        <input type="hidden" name="tipo" id="tipo" value ="<? echo $tipo; ?>"/>
        <input type="hidden" name="rows" id="rows" value ="<? echo $rows; ?>"/>
        <input type="hidden" name="separador" id="separador" value ="<? echo $separador; ?>"/>
        <input type="hidden" name="perg" id="perg" value ="<? echo $perg; ?>"/>
        <input type="hidden" name="primeiraVez" id="primeiraVez" value ="<? echo $primeiraVez; ?>"/>
        <input type="hidden" name="contador" id="contador" value ="<? echo $contador; ?>"/>        
        <input type="hidden" name="idGravado" id="idGravado" value ="<? echo $idGravado; ?>"/> 
        <? 		
		        echo '---->'.$contador;				
		if ($contador >1){ ?>
        <input type="Submit" name="Voltar" id="Voltar" value ="Voltar"/>        
   		<? } ?>
        <? if ($contador < $totalQuest) { ?>
        <input type="Submit" name="Avancar" id="Avancar" value ="Avançar"/>
		<? } ?>
      </p>
</form>
	