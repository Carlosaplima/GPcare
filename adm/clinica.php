
<script>
function popserv(oque)
{
var newWin;
	newWin =window.open("pesquisa.php?tabela="+oque,"kidserv",'resizable=yes,scrollbars=yes')
	return false;
}
</script>
<?

//if (isset($_POST['t_id'])){$t_id = $_POST['t_id'];}

$t_id = $_SESSION['CLINICA'];

if (isset($_POST['t_nome'])){$t_nome = $_POST['t_nome'];}
if (isset($_POST['t_razao'])){$t_razao = $_POST['t_razao'];}
if (isset($_POST['t_doc'])){$t_doc = $_POST['t_doc'];}
if (isset($_POST['t_endereco'])){$t_endereco = $_POST['t_endereco'];}
if (isset($_POST['t_cidade'])){$t_cidade = $_POST['t_cidade'];}
if (isset($_POST['t_estado'])){$t_estado = $_POST['t_estado'];}
if (isset($_POST['t_cep'])){$t_cep = $_POST['t_cep'];}
if (isset($_POST['t_tel'])){$t_tel = $_POST['t_tel'];}
if (isset($_POST['t_contato'])){$t_contato = $_POST['t_contato'];}
if (isset($_POST['t_contatotel'])){$t_contatotel = $_POST['t_contatotel'];}
if (isset($_POST['t_sit'])){$t_sit = $_POST['t_sit'];}
if (isset($_POST['t_logo'])){$t_logo = $_POST['t_logo'];}

if (isset($_POST['Incluir'])){$Incluir = $_POST['Incluir'];}
if (isset($_POST['Alterar'])){$Alterar = $_POST['Alterar'];}
if (isset($_POST['Excluir'])){$Excluir = $_POST['Excluir'];}
if (isset($_POST['Limpar'])){$Limpar = $_POST['Limpar'];}
if (isset($_POST['Pesquisar'])){$Pesquisar = $_POST['Pesquisar'];}

     if ($Alterar){
		 $inclu= "update clinicas set nome= '$t_nome',razao='$t_razao',doc='$t_doc',endereco='$t_endereco',cidade='$t_cidade',estado='$t_estado',cep='$t_cep',telefone='$t_tel',contato='$t_contato',tel_contato='$t_contatotel',sit='$t_sit',logo='$t_logo' where id = " .$t_id;
		 mysqli_query($con, $inclu);
	 }

     if ($t_id){
         $result=mysqli_query($con, 'SELECT * from clinicas where id = '.$t_id);    
             $rows=mysqli_num_rows($result);		 
             while ($valores = mysqli_fetch_array($result)){
                     $t_nome = $valores[1];
                     $t_razao = $valores[2];
                     $t_doc = $valores[3];
                     $t_endereco = $valores[4];
                     $t_cidade = $valores[5];
                     $t_estado = $valores[6];
                     $t_cep = $valores[7];
                     $t_tel = $valores[8];
                     $t_contato = $valores[9];
                     $t_contatotel = $valores[10];
                     $t_sit = $valores[11];
                     $t_logo = $valores[11];
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
    <label>Razão Social
    <input name="t_razao" type="text" id="t_razao" value="<? echo $t_razao; ?>" />
    </label>    
  </p>
  
  <p>
     <label> Documento (CNPJ ou CPF) 
    <input name="t_doc" type="text" id="t_doc" value="<? echo $t_doc; ?>" />
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
      <label>telefone 
    <input name="t_tel" type="text" id="t_tel" value="<? echo $t_tel; ?>" />
    </label>
  </p>
  <p>
      <label>contato 
    <input name="t_contato" type="text" id="t_contato" value="<? echo $t_contato; ?>" />
    </label>
  </p>
  <p>
      <label>tel_contato 
    <input name="t_contatotel" type="text" id="t_contatotel" value="<? echo $t_contatotel; ?>" />
    </label>
  </p>

  <p>
      <label>sit 
    <input name="t_sit" type="text" id="t_sit" value="<? echo $t_sit; ?>" />
    </label>
  </p>

  <p>
      <label>logo
    <input name="t_logo" type="text" id="t_logo" value="<? echo $t_logo; ?>" />
        </label>
  </p>
<HR />
<BR />
  <input type="submit" name="Alterar" id="Alterar" value="Alterar" />
</form>

