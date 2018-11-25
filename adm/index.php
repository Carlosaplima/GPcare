<?

     session_start();

      require("modulo.php");     	   

      

	  // estou logado?	            

      if (! isset($_SESSION['LOGIN'])){

            die('<script type="text/javascript">alert("Usuário Não Autorizado");window.location.href="login.php";</script>');		   

	   }   

	   

       ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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

  



  

           if ( !isset($_GET['oq'])  || $_GET['oq']=='') {	

     		  include("main.php");

		   }else{                

         	        $oque=$_GET['oq'];
					
   					     include($oque.".php");                    		                  

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