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
<?

if (isset($_POST['t_id'])){$t_id = $_POST['t_id'];}
if (isset($_POST['t_nome'])){$t_nome = $_POST['t_nome'];}
if (isset($_POST['t_doc'])){$t_doc = $_POST['t_doc'];}
if (isset($_POST['t_dtnasc'])){$t_dtnasc = $_POST['t_dtnasc'];}
if (isset($_POST['t_sexo'])){$t_sexo = $_POST['t_sexo'];}
if (isset($_POST['t_endereco'])){$t_endereco = $_POST['t_endereco'];}
if (isset($_POST['t_cidade'])){$t_cidade = $_POST['t_cidade'];}
if (isset($_POST['t_estado'])){$t_estado = $_POST['t_estado'];}
if (isset($_POST['t_cep'])){$t_cep = $_POST['t_cep'];}
if (isset($_POST['t_contato'])){$t_contato = $_POST['t_contato'];}
if (isset($_POST['t_tel'])){$t_tel = $_POST['t_tel'];}
if (isset($_POST['t_sit'])){$t_sit = $_POST['t_sit'];}
if (isset($_POST['t_idClinica'])){$t_idClinica= $_POST['t_idClinica'];}


if (isset($_POST['Incluir'])){$Incluir = $_POST['Incluir'];}
if (isset($_POST['Alterar'])){$Alterar = $_POST['Alterar'];}
if (isset($_POST['Excluir'])){$Excluir = $_POST['Excluir'];}
if (isset($_POST['Limpar'])){$Limpar = $_POST['Limpar'];}
if (isset($_POST['Pesquisar'])){$Pesquisar = $_POST['Pesquisar'];}

     if ($Incluir){
		 $inclu= "insert into pacientes (id,nome, doc, datanasc, sexo, endereco,cidade,estado,cep,responsavel, telefone,sit,idClinica) values (0,'$t_nome','$t_doc','$t_dtnasc','$t_sexo','$t_endereco','$t_cidade','$t_estado','$t_cep','$t_contato','$t_tel','$t_sit',$idClinica)";
		 mysqli_query($con, $inclu);
         $t_id = mysqli_insert_id($con);
	 }

     if ($Alterar){
		 $inclu= "update pacientes set nome= '$t_nome',doc='$t_doc',datanasc = '$t_dtnasc', sexo = '$t_sexo',endereco='$t_endereco',cidade='$t_cidade',estado='$t_estado',cep='$t_cep',telefone='$t_tel',responsavel='$t_contato',sit='$t_sit', idClinica = $t_idClinica where id = " .$t_id;
        		 mysqli_query($con, $inclu);
	 }


     if ($Excluir){
		 $inclu= "delete from pacientes where id = ". $t_id;
		 mysqli_query($con, $inclu);
         $t_id  = "";
	 }

     if ($Limpar){
         $t_id  = "";
	 }



     if ($t_id){
         $result=mysqli_query($con, 'SELECT * from pacientes where id = '.$t_id);    
             $rows=mysqli_num_rows($result);		 
             while ($valores = mysqli_fetch_array($result)){			 
				 			 
                     $t_nome = $valores[1];                     
                     $t_doc = $valores[2];
					 $t_dtnasc = $valores[3];
					 $t_sexo = $valores[4];
                     $t_endereco = $valores[5];
                     $t_cidade = $valores[6];
                     $t_estado = $valores[7];
                     $t_cep = $valores[8];
                     $t_contato = $valores[9];
                     $t_tel = $valores[10];
                     $t_sit = $valores[11];
					 $t_idClinica= $valores[12];

             } 
		mysqli_free_result($result);
	 }

?>

<p>Manutenção</p>
<p><a href="index.php">Voltar</a>?</p>
<form id="form1" name="form1" method="post" action="">
  <p>ID: <? echo $t_id; ?>
    <input name="t_id" type="hidden" id="t_id" value="<? echo $t_id; ?>" />
  </p>
  <p>
    <label>Nome
      <input name="t_nome" type="text" id="t_nome" value="<? echo $t_nome; ?>" />    
    </label>
  </p>
  
  <p>
    <label>Documento (CNPJ ou CPF)
      <input name="t_doc" type="text" id="t_doc" value="<? echo $t_doc; ?>" />
    </label>
  </p>
  <p>
    <label>Data Nascimento
      <input name="t_dtnasc" type="text" id="t_dtnasc" value="<? echo $t_dtnasc; ?>" />
    </label>    
  </p>
  
  <p>
    <label>Sexo 
      <input name="t_sexo" type="text" id="t_sexo" value="<? echo $t_sexo; ?>" />
    </label>
  </p>
  
  <p>
     <label>endereco 
    <input name="t_endereco" type="text" id="t_endereco" value="<? echo $t_endereco; ?>" />
     </label>
  </p>
  <p>
      <label>cidade 
    <input name="t_cidade" type="text" id="t_cidade" value="<? echo $t_cidade; ?>" />
    </label>
  </p>
  <p>
      <label>estado 
    <input name="t_estado" type="text" id="t_estado" value="<? echo $t_estado; ?>" />
    </label>
  </p>

  <p>
      <label>cep 
    <input name="t_cep" type="text" id="t_cep" value="<? echo $t_cep; ?>" />
    </label>
  </p>

  <p>
    <label>contato
      <input name="t_contato" type="text" id="t_contato" value="<? echo $t_contato; ?>" />
    </label>
  </p>
  <p>
    <label>telefone 
      <input name="t_tel" type="text" id="t_tel" value="<? echo $t_tel; ?>" />
    </label>
  </p>
  <p>
    <label>sit 
      <input name="t_sit" type="text" id="t_sit" value="<? echo $t_sit; ?>" />
    </label>
  </p>
  <p>
    <label>idClinica 
      <input name="t_idClinica" type="text" id="t_idClinica" value="<? echo $t_idClinica; ?>" />
    </label>
  </p>


  <p><BR />
    <label>
      <input type="submit" name="Incluir" id="Incluir" value="Incluir" />
    </label>
  <input type="submit" name="Alterar" id="Alterar" value="Alterar" />
  <input type="submit" name="Excluir" id="Excluir" value="Excluir" />
  <input type="submit" name="Limpar" id="Limpar" value="Limpar" />
 <input type="submit" name="Pesquisar" id="Pesquisar" value="Pesquisar" onclick="return popserv('pacientes')"/>
</p>
</form>

