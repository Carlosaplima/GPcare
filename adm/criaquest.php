<?php
       require("modulo.php");         
?>
<script>
function f1() {
	var v = document.getElementById('tipo').value;

    document.getElementById('esconder').style.display = "none";
	document.getElementById('separador').style.display = "none";
	if (v == "Multipla Escolha") {
		document.getElementById('esconder').style.display = "block";
	}
	if (v == "Varias Escolhas") {
    	document.getElementById('esconder').style.display = "block";
		document.getElementById('separador').style.display = "block";
	}
}

</script>

<? 

$direcao = "";
if (isset($_GET['d'])) { $direcao = $_GET['d']; }


if (isset($_GET['id'])) { $id = $_GET['id']; }
if (isset($_POST['id'])) { $id = $_POST['id']; }

if (isset($_GET['idResp'])) { $idResp = $_GET['idResp']; }
if (isset($_POST['idResp'])) { $idResp = $_POST['idResp']; }

$nome = $_POST['nome'];
$questao = $_POST['questao'];
$tipo = $_POST['tipo'];
$respostas = $_POST['respostas'];
$separador = $_POST['separador'];

//Exibe forms
    echo '<ul>';
    $result=mysqli_query($con, 'SELECT id, formulario FROM formularios order by id desc');    
         $rows=mysqli_num_rows($result);		 
         while ($valores = mysqli_fetch_array($result)){ 
			 echo "<li><a href='?id=$valores[0]'>$valores[1]</a></li>";
        } 
		mysqli_free_result($result);
    echo '</ul>';
	

//---------------------- operações com formulario------------------------------------------------------------------------------------------

     if ($_POST['Novo']){
		 $id = "";
		 $idProd ="";
		 $nome ="";
         $questao ="";
         $tipo ="";
         $respostas ="";
         $separador ="";
	 }
		 

     // inserção de formulario
     if ($_POST['Incluir']){
		 // insere formulario		 
		 $inclu = "INSERT INTO formularios (idCat, categoria, formulario,campos, sit) VALUES (0,'','$nome','','')" ;
			mysqli_query($con, $inclu);
            $id = mysqli_insert_id($con);
	 }

	// alteração de formulario
     if ($_POST['Alterar']){
		 // insere formulario		 
		 $inclu = "Update formularios set formulario = '$nome' where id = ".$id;
			mysqli_query($con, $inclu);            
	 }

	// Exclusão de formulario
     if ($_POST['Excluir']){
		 // insere formulario		 
		 $inclu = "delete from  where id = ".$id;
			mysqli_query($con, $inclu);  
			$id = "";
	 }
	 
	 	// carrega form caso tenha id
	if ($id !=""){
         $result=mysqli_query($con, 'SELECT id, formulario FROM formularios where id = '. $id);    
         $rows=mysqli_num_rows($result);		 
         while ($valores = mysqli_fetch_array($result)){ 
			 $nome = $valores[1];
        } 
		mysqli_free_result($result);
	}

//---------------------- ------------------------------------------------------------------------------------------

//---------------------- operações com Questoes------------------------------------------------------------------------------------------

       if ($direcao!=""){
		//mudança de posicao
		
		$query = "select id, campo from forms where id = ".$idResp;	
         $result=mysqli_query($con, $query);    		 
 		 $Meuid= 0;
		 $MeuNome= "";		 
         while ($valores = mysqli_fetch_array($result)){ 
			  		 $Meuid= $valores[0];
            		 $MeuNome= $valores[1];

         } 
		mysqli_free_result($result);

		
		
		
		$query = "select id, campo from forms where ( id = IFNULL((select min(id) from forms where id > $idResp and idForm=$id),0) or  id = IFNULL((select max(id) from forms where id < $idResp and idForm=$id),0))";
		echo '<br>'.$query.'<BR>';
         $result=mysqli_query($con, $query);    
		 $rows=mysqli_num_rows($result);		 
		 //echo "<BR>qtos registros?.".$rows.'<BR>';
		 
		 $idAnt= 0;
		 $NomeAnt= "";
		 
 		 $idProx= 0;
		 $NomeProx= "";
		 $ct = 0;
         while ($valores = mysqli_fetch_array($result)){ 
		 if ($ct==0){
			 		 $idAnt= $valores[0];
            		 $NomeAnt= $valores[1];
		 }else{
			  		 $idProx= $valores[0];
            		 $NomeProx= $valores[1];
		 }
         $ct++;
         } 
		mysqli_free_result($result);

		
		if ($direcao=="d"){
			// move pra baixo
			//pode ser que não tenha nada no idprox, quer dizer que não tem proximo, só vem um registro
			if ($idProx==0){$idProx=$idAnt; $NomeProx=$NomeAnt;}
			
			if ($idProx!=0){
				 $inclu = "Update forms set campo = '$NomeProx' where id = ".$Meuid;
    	 		 mysqli_query($con, $inclu);   
				 
				 $inclu = "Update forms set campo = '$MeuNome' where id = ".$idProx;
    	 		 mysqli_query($con, $inclu);   
			}

		}
		
		if ($direcao=="u"){
			// move pra cima
			if ($idAnt!=0){
				 $inclu = "Update forms set campo = '$NomeAnt' where id = ".$Meuid;
    	 		 mysqli_query($con, $inclu);   
				 
				 $inclu = "Update forms set campo = '$MeuNome' where id = ".$idAnt;
    	 		 mysqli_query($con, $inclu);   
			}

			
			}
		
	   }



	 if ($_POST['Apaga']){
		 // Remove questao
		 $inclu = "delete from forms where id = ".$idResp ;
			mysqli_query($con, $inclu);
			$idResp = "";
	 }
	 
  	 if ($_POST['Muda']){
		 // atualiza questao
		             $resposta = "";		
			
			if ($tipo == "Multipla Escolha" || $tipo == "Varias Escolhas"){
                 $resposta = "" ;                
                 $oo = explode("\n", $respostas);				 
                     for($i=0; $i <=count($oo); $i++){
                        $ss  = "";
                          if ($i != count($oo) ) {
			           		$ss = "¨" ;
           				  }else{
         					$ss = "";
			              }
                       $resposta .= trim($oo[$i]) . $ss;
					 }
            
			    //poe o separador		

     			if ($tipo == "Varias Escolhas"){
                    $resposta .= "|" . $separador;
		     	}

			}			
			
            $qgrava = $tipo . "|" . $questao . "|" . $resposta;      	   
	   
    		$inclu = "update forms set campo='$qgrava' where id = ".$idResp ;
			mysqli_query($con, $inclu);
	 }
	 
	if ($_POST['Grava']){
	   // adiciona  questao em forms	   
            $resposta = "";		
			
			if ($tipo == "Multipla Escolha" || $tipo == "Varias Escolhas"){
                 $resposta = "" ;                
                 $oo = explode("\n", $respostas);				 
                     for($i=0; $i <=count($oo); $i++){
                        $ss  = "";
                          if ($i != count($oo) ) {
			           		$ss = "¨" ;
           				  }else{
         					$ss = "";
			              }
                       $resposta .= trim($oo[$i]) . $ss;
					 }
            
			    //poe o separador		

     			if ($tipo == "Varias Escolhas"){
                    $resposta .= "|" . $separador;
		     	}

			}			
			
            $qgrava = $tipo . "|" . $questao . "|" . $resposta;      	   
	   
    		$inclu = "INSERT INTO forms (idForm,campo,sit) VALUES ($id,'$qgrava','')" ;
			mysqli_query($con, $inclu);
            $xid = mysqli_insert_id($con);	   
	}
//---------------------- ------------------------------------------------------------------------------------------	 
	
	
	
?>




<form id="form1" name="form1" method="post" action="">
  <p>&nbsp;</p>
  <p>
    <label>Formulário:
      <input type="text" name="nome" id="nome" value="<? echo $nome; ?>"/>
    </label>
  ID: <? echo $id; ?></p>
  <p>
    <input type="submit" name="Incluir" id="Incluir" value="Incluir" />
    <?  if ($id !=""){ ?>
    <input type="submit" name="Excluir" id="Excluir" value="Excluir" />
    <input type="submit" name="Alterar" id="Alterar" value="Alterar" />    
    <? } ?>
    <input type="submit" name="Novo" id="Novo" value="Novo" />
  </p>
  <h2>Questões</h2>

    <? 
	// se tem id resp, então exibo e permito ajuste
	if ($idResp!=""){		
	     $result=mysqli_query($con, 'SELECT campo FROM forms where id='.$idResp);    
         $rows=mysqli_num_rows($result);		 
         while ($valores = mysqli_fetch_array($result)){ 
			 $questao=$valores[0];

			 // quebro e exibo
			 $ob= explode("|", $questao);
             $tipo = $ob[0];

             $questao = $ob[1];

             if  ($ob[0] != "Resposta Simples"){
                //quebra as respostas
                $jj= explode("¨", $ob[2]);
                
    			$respostas = "";
                     for ($i=0;$i<=count($jj); $i++){
                         $respostas .= $jj[$i] . "\n";
				     }
					 
                     if( $tipo== "Varias Escolhas" ) {
				         $separador = $ob[3];				
				     }
             } 
		 }
		  mysqli_free_result($result);
	 }
	 
	 // agora exibo ou não os quadros de acordo com o $tipo
	 $vis1 = "none";
	 $vis2 = "none";

	 if ($tipo=='Multipla Escolha'){$vis1= "block";}
	 if ($tipo=='Varias Escolhas'){$vis1= "block";$vis2= "block";}
	 
	?>
  <div>   
    <p>
      <label>
        <select name="tipo" id="tipo" onchange="f1();">
        <? if ($tipo!=""){ echo "<option>$tipo</option>";}  ?>
          <option>Resposta Simples</option>
          <option>Multipla Escolha</option>
          <option>Varias Escolhas</option>
        </select>
      </label>
  ID:<? echo $idResp; ?></p>    
    </p>
  Questão:
    <p>
      <label>
        <textarea name="questao" id="questao" cols="45" rows="5"><? echo $questao;  ?></textarea>
      </label>
    </p>
  <div id = "esconder" style="display:<? echo $vis1; ?>">

    <p>Respostas 
    	<div id = "separador" style="display:<? echo $vis2; ?>">
        separador 
      <label>
        <input name="separador" type="text" id="separador" size="10" maxlength="10" value = "<? echo $separador;  ?>"/>
      </label>
          </div>
    </p>
    <p>
      <textarea name="respostas" id="respostas" cols="45" rows="5"><? echo $respostas;  ?></textarea>
    </p>
    </div>
  <p>
      <input type="submit" name="Grava" id="Grava" value="Grava" />
      
      	<? if ($idResp!=""){	?>
      <input type="submit" name="Muda" id="Muda" value="Muda" />
      <input type="submit" name="Apaga" id="Apaga" value="Apaga" />  
        <? } ?>
    </p>
  <input type="hidden" name="id" id="id" value="<? echo $id; ?>"/>
  <input type="hidden" name="idResp" id="idResp" value="<? echo $idResp; ?>"/>
</form>
<div>
<ul>
<? 
// exibe questoes

if ($id !=""){
         $result=mysqli_query($con, 'SELECT * FROM forms where idForm = '. $id);    
         $rows=mysqli_num_rows($result);
		 $ct = 0;
         while ($valores = mysqli_fetch_array($result)){ 
		 echo "<li>";
		 if ($ct<$rows-1) {echo "<a href='?id=$id&idResp=$valores[0]&d=d'>↓</a>";}else{echo "<a href='#'>#</a>";}
		 if ($ct>0){ echo "<a href='?id=$id&idResp=$valores[0]&d=u'>↑</a>";}else{echo "<a href='#'>#</a>";}
		 echo "<a href='?id=$id&idResp=$valores[0]'>$valores[0]-$valores[2]</a></li>";
		 $ct++;
        } 
		mysqli_free_result($result);
	}
?>
</ul>
</div>

