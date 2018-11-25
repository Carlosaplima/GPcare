<?

         session_start();

       require("agbrinc.php");  

        PmeConnect();

       mysql_connect("$DBHost","$DBUser","$DBPass");

       mysql_select_db("$DB");   

       acentos();	   

	   

	   // estou logado?

	   

	   if (! isset($_SESSION['LOGIN'])){

             die('<script type="text/javascript">alert("Usuário Não Autorizado");window.location.href="login.php";</script>');		   

	   }   

	   

       ?>

<!--################# HEADER ################-->

<?php include("paginas/header.php"); ?>

<!--############# FIM HEADER ################-->



<!-- ################ PAGINAS ###############-->

<section class="cadastro style-cont-full">

  <div class="container-fluid">

    <div class="row">

      <div class="col-sm-3 col-md-2 style-col-menu">

        <!--################# MENU ################-->

        

        <?php include("paginas/menu.php"); ?>

        <!--############# FIM MENU ################-->

      </div>





      

      <div class="col-sm-9 col-md-10 style-cont-adm">

      <div class="main">

        <div class="conteudo">

          <!--<h1>Produtos</h1>-->

          <div class="cont-all">



<?

          $oq = $_GET['oq'];

		  

		  if (isset($_GET['oq']){	

						  echo 'ta setado'.$_GET['oq'].'---->'.isset($_GET['oq'];

     		  if ($oq!='home') {

	        	  if (file_exists($oq.".php")){

        		    include($oq.".php");

        		  }else{

		        	  echo 'não existe';

        		  }

		      }

		  }

?>



          </div>

        </div>      

      </div>

      </div>

    </div>

  </div>

</section>

<!-- ################ FIM PAGINAS ###########-->



<!--################# FOOTER ################-->

<?php include("paginas/footer.php"); ?>

<!--################# FIM FOOTER ############-->