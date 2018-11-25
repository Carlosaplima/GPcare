<?

	   // estou logado?	   

	   if (! isset($_SESSION['LOGIN'])){

             die('<script type="text/javascript">alert("Usuário Não Autorizado");window.location.href="login.php";</script>');		   

	   }   

?>



              <div class="row">

                <div class="col-sm-12 col-md-12"><!-- BOX DOLLAR-->

                  <div class="box-dllr">

                    <div class="stl-icon">

                      <span>

                        <i class="glyphicon glyphicon-usd"></i>

                      </span>

                    </div>

                    <p>:<span>:</span></p>

                  </div>

                </div><!-- FIM BOX DOLLAR -->



                <div class="containerx"><!-- Container DIV mãe -->

                  <div class="col-sm-3 col-md-3 boxs-info-p"><!-- BOX -->

                    <div class="tt_b"><a href="index.php?oq=pedidos">Clinicas</a></div>

                        <?  	

                         	//Pega videos          

                           	$Rprods=mysqli_query($con, "select count(id) from clinicas" );          

                            $nv = "0";

                            while ($Rvalores = mysqli_fetch_array($Rprods)){

                        		  $nv=$Rvalores[0];

                    			  break;

                    	  }

                        	mysqli_free_result($Rprods);

                      	?>



                    <div class="cont-bx-s">

                      <span class="style-v"><? echo $nv; ?></span>

                    </div>

                    <ul class="ul-st-p">

                        <?

                        $Rprods=mysqli_query($con, 'select count(id) from clinicas');

                        $nv = "0";

                        while ($Rvalores = mysqli_fetch_array($Rprods)){

                             $nv=$Rvalores[0];

                             break;

                        }

                        mysqli_free_result($Rprods);

                        ?>



                      <li>Clinicas <span class="box-ccl st_aprovado"><i><? echo $nv; ?></i></span></li>

                      

                      <?

					    $hoje = date("Y-m-d");

                        $Rprods=mysqli_query($con, "select count(id) from clinicas");

                        $nv = "0";

                        while ($Rvalores = mysqli_fetch_array($Rprods)){

                             $nv=$Rvalores[0];

                             break;

                        }

                        mysqli_free_result($Rprods);					

                       ?>



                      <li>Clinicas <span class="box-ccl st_aprovado"><i><? echo $nv; ?></i></span></li>

                      

                      

                    </ul>

                    

                    <!-- ari -->

                    <div class="tt_b"><a href="index.php?oq=pedidos">Clinicas</a></div>

                        <?  	

                         	//Pega videos          

                           	$Rprods=mysqli_query($con, "select count(id) from clinicas" );          

                            $nv = "0";

                            while ($Rvalores = mysqli_fetch_array($Rprods)){

                        		  $nv=$Rvalores[0];

                    			  break;

                    	  }

                        	mysqli_free_result($Rprods);

                      	?>



                    <div class="cont-bx-s">

                      <span class="style-v"><? echo $nv; ?></span>

                    </div>

                    <ul class="ul-st-p">

                        <?

						$hoje = date("Y-m-d");

                        $Rprods=mysqli_query($con, "select count(id) from clinicas");

                        $nv = "0";

                        while ($Rvalores = mysqli_fetch_array($Rprods)){

                             $nv=$Rvalores[0];

                             break;

                        }

                        mysqli_free_result($Rprods);

                        ?>



                      <li>clinicas <span class="box-ccl st_aprovado"><i><? echo $nv; ?></i></span></li>

                      

                      

                    </ul>

                    

                    

                    

                  </div><!-- FIM BOX -->

               

               

                  <div class="col-sm-3 col-md-3 boxs-info-p"><!-- BOX -->                     

                    <div class="cont-main-inf ">                

                      <div class="tt_b"><a href="?oq=prods">Usuários:</a></div>

                      <div class="cont-bx-s">

                      <?

                        $Rprods=mysqli_query($con, 'select count(id) from clinicas');

                        $nv = "0";

                        while ($Rvalores = mysqli_fetch_array($Rprods)){

                             $nv=$Rvalores[0];

                             break;

                        }                        

						mysqli_free_result($Rprods);

                      ?>

                      <span class="style-v"><? echo $nv; ?></span>

                      </div>

                      <div>

                      

                        <ul class="ul-st-p">

                        <?

                        $Rprods=mysqli_query($con, 'select count(id) from clinicas');

                        $nv = "0";

                        while ($Rvalores = mysqli_fetch_array($Rprods)){

                             $nv=$Rvalores[0];

                             break;

                        }                        

						mysqli_free_result($Rprods);                        

						?>



                        <li><a href="index.php?oq=estoque">clinicas</a><span class="box-ccl st_pendente"><i><? echo $nv; ?></i></span></li>

                        </ul>                      

                      

                      </div>



                      

                      

                      

                      <div class="brd_b"><!-- SUBBOX-->                                           

                      <div class="tt_b"></div>               

                      </div>

                      </div>

                  </div><!-- FIM BOX -->





                  <div class="col-sm-3 col-md-3 boxs-info-p"><!-- BOX -->

                    <div class="tt_b"><a href="index.php?oq=clientes">Clinicas</a></div>

                     <div class="cont-bx-s">

                      <?

                      $Rprods=mysqli_query($con, 'select count(id) from clinicas');

                        $nv = "0";

                        while ($Rvalores = mysqli_fetch_array($Rprods)){

                             $nv=$Rvalores[0];

                             break;

                        }                        

						mysqli_free_result($Rprods);                        

                      ?>  

                      <span class="style-v"><? echo $nv; ?></span>

                    </div>

                  </div><!-- FIM BOX -->  





                  <div class="col-sm-3 col-md-3 boxs-info-p"><!-- BOX -->

                    <div class="tt_b"><a href="index.php?oq=suporte">Clinicas</a></div>

                     <div class="cont-bx-s">

                      <?

                      $Rprods=mysqli_query($con, 'select count(id) from clinicas');

                        $nv = "0";

                        while ($Rvalores = mysqli_fetch_array($Rprods)){

                             $nv=$Rvalores[0];

                             break;

                        }                        

						mysqli_free_result($Rprods);                        

                      ?>  

                      <span class="style-v"><? echo $nv; ?></span>

                    </div>

                  </div><!-- FIM BOX -->  



