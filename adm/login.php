<?
       session_start();
       require("modulo.php"); 	   
       ?>

<!--################# HEADER ################-->
<?php include("paginas/header.php"); ?>
<!--############# FIM HEADER ################-->
<? 
if (isset($_GET['inputEmail']) || isset($_POST['inputEmail'])) {			
       $inputEmail = $_GET['inputEmail'];
       $inputPassword = $_GET['inputPassword'];
       if (isset($_POST['inputEmail'])){$inputEmail = $_POST['inputEmail'];}
	   if (isset($_POST['inputPassword'])){$inputPassword = $_POST['inputPassword'];}
           $rows = 1;
        if ($rows<1){

          	die('<script type="text/javascript">alert("Usuário ou senha inválido");window.location.href="login.php";</script>');	

		}else{	

            $_SESSION['LOGIN']=$inputEmail;		

			

			//echo $_SESSION['LOGIN'].'Logado:' . isset($_SESSION['LOGIN']);

			

            die('<script type="text/javascript">alert("Seja Bem vindo: '.$inputEmail.'");window.location.href="index.php";</script>');	

		}

}



?>





<!-- ################ PAGINAS ###############-->

<section class="cadastro style-m-p-full login-box">

	<div class="container">

		<div class="row">

			<h1>Bem-vindo ao Admin GPCare</h1>

			<div class="clo-xs-12 col-sm-6 col-md-6 style-mg-auto">

				<div class="cont-form">		

					<form method="post">

					  <div class="control-group">

					    <label class="control-label" for="inputEmail">Login</label>

					    <div class="controls">

					      <input name="inputEmail" id="inputEmail" class="box-input-cor" type="text" placeholder="Digite o seu e-mail..." />

					    </div>

					  </div>

					  <div class="control-group">

					    <label class="control-label" for="inputPassword">Senha</label>

					    <div class="controls">

					      <input name="inputPassword" id="inputPassword" class="box-input-cor" type="password" placeholder="Digite a sua senha..." />

					    </div>

					  </div>

					  <div class="control-group">

					    <div class="controls">

					      <!-- <p><a href="../recuperarsenha.php?a=a" alt="esqueci minha senha">Esqueci minha senha</a></p>					       -->

                          <button class="btn" type="submit">Acessar</button>

					    </div>

					  </div>

					</form>

				</div>

			</div>

		</div>

	</div>

</section>

<!-- ################ FIM PAGINAS ###########-->





<!--################# FOOTER ################-->

<?php include("paginas/footer.php"); ?>

<!--################# FIM FOOTER ############-->

































