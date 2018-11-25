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

</head>
</head>
<?

	
if (isset($_POST['t_id'])){$t_id = $_POST['t_id'];}
if (isset($_POST['t_user'])){$t_user = $_POST['t_user'];}
if (isset($_POST['t_nome'])){$t_nome = $_POST['t_nome'];}
if (isset($_POST['t_senha'])){$t_senha = $_POST['t_senha'];}
if (isset($_POST['t_doc'])){$t_doc = $_POST['t_doc'];}
if (isset($_POST['t_tel'])){$t_tel = $_POST['t_tel'];}
if (isset($_POST['t_sit'])){$t_sit = $_POST['t_sit'];}
if (isset($_POST['t_priv'])){$t_priv = $_POST['t_priv'];}


if (isset($_POST['Incluir'])){$Incluir = $_POST['Incluir'];}
if (isset($_POST['Alterar'])){$Alterar = $_POST['Alterar'];}
if (isset($_POST['Excluir'])){$Excluir = $_POST['Excluir'];}
if (isset($_POST['Limpar'])){$Limpar = $_POST['Limpar'];}
if (isset($_POST['Pesquisar'])){$Pesquisar = $_POST['Pesquisar'];}


     if ($Incluir){
		 $inclu= "insert into usuarios (id,user,senha,nome,doc,sit,priv, telefone) values (0,'$t_user','$t_senha','$t_nome','$t_doc','$t_sit','$t_priv','$t_tel')";
		 mysqli_query($con, $inclu);
         $t_id = mysqli_insert_id($con);
	 }

     if ($Alterar){
		 $inclu= "update usuarios set user = '$t_user', senha = '$t_senha',nome= '$t_nome',doc='$t_doc',sit='$t_sit', priv = '$t_priv', telefone = '$t_tel' where id = " .$t_id;
		 mysqli_query($con, $inclu);
	 }


     if ($Excluir){
		 $inclu= "delete from usuarios where id = ". $t_id;
		 mysqli_query($con, $inclu);
         $t_id  = "";
	 }

     if ($Limpar){
         $t_id  = "";
	 }



     if ($t_id){
         $result=mysqli_query($con, 'SELECT * from usuarios where id = '.$t_id);    
             $rows=mysqli_num_rows($result);		 
             while ($valores = mysqli_fetch_array($result)){
				 	//id	user	senha	nome	doc	telefone	priv	sit

                     $t_user = $valores[1];
					 $t_senha= $valores[2];
					 $t_nome = $valores[3];
					 $t_doc= $valores[4];
					 $t_tel= $valores[5];
					 $t_priv= $valores[6];
					 $t_sit= $valores[7];
					 
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
    <label>User
      <input name="t_user" type="text" id="t_user" value="<? echo $t_user; ?>" />
    </label>
  </p>
  <p>
    <label>Senha
      <input name="t_senha" type="text" id="t_senha" value="<? echo $t_senha; ?>" />
    </label>
  </p>
  <p>
    <label>Nome
      <input name="t_nome" type="text" id="t_nome" value="<? echo $t_nome; ?>" />    
    </label>
  </p>
  
  <p>
    <label> Documento (CNPJ ou CPF) 
      <input name="t_doc" type="text" id="t_doc" value="<? echo $t_doc; ?>" />
    </label>
  </p>
  <p>
    <label>Telefone
      <input name="t_tel" type="text" id="t_tel" value="<? echo $t_tel; ?>" />
    </label>
</p>
  <p>
    <label>Privilegio
      <select id="t_priv" name = "t_priv">
      <option <? if ($t_priv=="Usuario"){echo 'selected= "selected"';} ?>>Usuario</option>
      <option <? if ($t_priv=="Administrador"){echo 'selected= "selected"';} ?>>Administrador</option>
      <option <? if ($t_priv=="Gerente"){echo 'selected= "selected"';} ?>>Gerente</option>
      </select>
    </label>
  </p>
<p>
  <label>sit 
    <input name="t_sit" type="text" id="t_sit" value="<? echo $t_sit; ?>" />
  </label>
  </p>
  <p>&nbsp;</p>
  

  <p><BR />
    <label>
      <input type="submit" name="Incluir" id="Incluir" value="Incluir" />
    </label>
  <input type="submit" name="Alterar" id="Alterar" value="Alterar" />
  <input type="submit" name="Excluir" id="Excluir" value="Excluir" />
  <input type="submit" name="Limpar" id="Limpar" value="Limpar" />
  <input type="submit" name="Pesquisar" id="Pesquisar" value="Pesquisar" onclick="return popserv('usuarios')"/>
</p>
</form>
