<? 

$pag = basename($_SERVER['SCRIPT_NAME']);

session_start(); 



?>

<!DOCTYPE html>

<html lang="pt-br">







<head>

	<!-- <meta charset="utf-8">-->

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> -->

    

	<title>Bicdados - A loja virtual para equipamentos 

de automa&ccedil;&atilde;o e suprimentos.</title>



	<meta name="viewport" content="width=device-width, initial-scale=1">

	

	<meta name="title" content="Leitores, Coletores de Dados e Equipamentos de Automação - BicDados">

	<meta name="description" content="A BicDados é a solução em Equipamentos de Automação Comercial, fornece Leitores de Código de Barras, Software Coletor Dados, Impressoras Térmicas e muito mais!">

	<meta name="keywords" content="Leitores de Código de Barras, Impressora Zebra, Locação de Coletores de Dados, Etiqueta Térmica, Software para Coletores de Dados, Ribbons de Cera, Equipamentos de Automação, Impressora de Etiquetas, Leitores Laser, Ribbon Misto">

	<meta property="og:title" content="Leitores, Coletores de Dados e Equipamentos de Automação - BicDados">

	<meta property="og:description" content="A BicDados é a solução em Equipamentos de Automação Comercial, fornece Leitores de Código de Barras, Software Coletor Dados, Impressoras Térmicas e muito mais!">

	<meta property="og:type" content="Website">

	<meta property="og:url" content="http://www.bicdados.com.br/">

	<meta name="robots" content="index, follow">

	<meta name="format-detection" content="telephone=no"/>



	<link rel="shortcut icon" type="image/x-icon" href="imagens/favicon.ico">

	<link rel="shortcut icon" href="imagens/favicon.ico" />

	<link rel="apple-touch-icon" sizes="57x57" href="imagens/favicon/apple-icon-57x57.png">

	<link rel="apple-touch-icon" sizes="60x60" href="imagens/favicon/apple-icon-60x60.png">

	<link rel="apple-touch-icon" sizes="72x72" href="imagens/favicon/apple-icon-72x72.png">

	<link rel="apple-touch-icon" sizes="76x76" href="imagens/favicon/apple-icon-76x76.png">

	<link rel="apple-touch-icon" sizes="114x114" href="imagens/favicon/apple-icon-114x114.png">

	<link rel="apple-touch-icon" sizes="120x120" href="imagens/favicon/apple-icon-120x120.png">

	<link rel="apple-touch-icon" sizes="144x144" href="imagens/favicon/apple-icon-144x144.png">

	<link rel="apple-touch-icon" sizes="152x152" href="imagens/favicon/apple-icon-152x152.png">

	<link rel="apple-touch-icon" sizes="180x180" href="imagens/favicon/apple-icon-180x180.png">

	<link rel="icon" type="image/png" sizes="192x192"  href="imagens/favicon/android-icon-192x192.png">

	<link rel="icon" type="image/png" sizes="32x32" href="imagens/favicon/favicon-32x32.png">

	<link rel="icon" type="image/png" sizes="96x96" href="imagens/favicon/favicon-96x96.png">

	<link rel="icon" type="image/png" sizes="16x16" href="imagens/favicon/favicon-16x16.png">

	<link rel="manifest" href="imagens/favicon/manifest.json">

	<meta name="msapplication-TileColor" content="#ffffff">

	<meta name="msapplication-TileImage" content="imagens/favicon/ms-icon-144x144.png">

	<meta name="theme-color" content="#ffffff">

	



	<link rel="stylesheet" href="css/bootstrap.min.css">

	<link rel="stylesheet" href="css/stylesheet.css">

	<link rel="stylesheet" href="css/main.css">

	<link rel="stylesheet" href="css/main-responivo.css">





<link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">







</head>

<body>



<!-- LiveZilla Tracking Code (ALWAYS PLACE IN BODY ELEMENT) --><div id="livezilla_tracking" style="display:none"></div><script type="text/javascript">

/* <![CDATA[ */

var script = document.createElement("script");script.async=true;script.type="text/javascript";var src = "http://www.bicdata.com.br/live/server.php?acid=33f57&request=track&output=jcrpt&nse="+Math.random();setTimeout("script.src=src;document.getElementById('livezilla_tracking').appendChild(script)",1);

/* ]]> */

</script><noscript><img src="http://www.bicdata.com.br/live/server.php?acid=33f57&amp;request=track&amp;output=nojcrpt" width="0" height="0" style="visibility:hidden;" alt="" /></noscript>

<!-- http://www.LiveZilla.net Tracking Code -->









<?

if (isset($_POST['OK']) || isset($_GET['OK']) ) {

	$_SESSION['ESTADO']=$_POST['state'];

	$_SESSION['REGIAO']=$_POST['regiao'];

	$_SESSION['IE']=$_POST['inscricao'];

	

}

	

    if (isset($_POST['xemail'])){	

           // insere no banco	  

		   $achou="*";

           $mm = $_POST['xemail'] ;         		 	 		   



          		   $vvResult = mysql_query("select * from ListaMails where email = '" .$mm. "'");

		                       while ($vvvalores = mysql_fetch_array($vvResult)){									

                               $achou = $vvvalores[1];

                     		   }

		   

                		       if ($achou=="*"){			 

   		                             $inclu = "insert into ListaMails values('','" . $mm . "','".date("YmdHis")."')";			  

                			         mysql_query($inclu);

                                     echo '<script type="text/javascript">alert("Email '.$mm.' Cadastrado!!");</script>';	

     			

                		      }else{			 

                 			         echo '<script type="text/javascript">alert("Email '.$mm.' já Cadastrado!!");</script>';		   

                   		      }		 		  

                  }



				

				 

    if ($_GET['logout']){

		  $_SESSION['USERNAME']="";

		  unset($_SESSION['USERNAME']);

		   $_SESSION['IDUSER']="";

		  unset($_SESSION['IDUSER']);

			   die('<script type="text/javascript">window.location.href="?a=";</script>');	



	}





    if ($_GET['logar']){

	    // verifico conexão no banco

         $epx = "SELECT nome, id FROM clientes where (apelido = '".$_GET['email']."' or email = '".$_GET['email']."') and senha = '".$_GET['password']."'";	

         $result=mysql_query($epx);    

         $UserName = "";

		 $iduser = "";

         $rows=mysql_num_rows($result); 

          while ($valores = mysql_fetch_array($result)){									

              $UserName = $valores[0];

			  $iduser = $valores[1];

			  break;

          }

		  

		  if ($UserName==""){	

		  $_SESSION['IDUSER']="";

		  unset($_SESSION['IDUSER']);

          $_SESSION['USERNAME']="";

		  unset($_SESSION['USERNAME']);

			   die('<script type="text/javascript">alert("Usuário ou senha inválido");window.location.href="?a=";</script>');	

		  }else{		    

			// cria sessão

     		$_SESSION['USERNAME']=$UserName;		

			$_SESSION['IDUSER'] = $iduser;

		  }

		  }

    ?>

	



<!-- Modal -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="vertical-alignment-helper">

        <div class="modal-dialog vertical-align-center">

            <div class="modal-content style-modal">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>

                    </button>                                        

                    <h4 class="modal-title" id="myModalLabel">Sua localiza&ccedil;&atilde;o</h4>

                </div>

                <div class="modal-body">                	

					<div class="form">                        

                      <form method="post" action="">   

                      

            			<p>A loja aplica os impostos e fretes com base na sua localiza&ccedil;&atilde;o</p>



			            <fieldset>

			                <label for="state" class="label-style">Seu estado:</label>

			                <select name="state" id="state" class="style-select">

                            <? $ESTADO = $_SESSION['ESTADO']; ?>

                            

                            <?

                            $result=mysql_query('SELECT sigla, nome FROM estados order by sigla');    

                             $rows=mysql_num_rows($result); 

                                while ($valores = mysql_fetch_array($result)){	

								$sel='';

								     if ($ESTADO==$valores[0]){$sel='selected';}

                                    echo "<option value='$valores[0]' $sel>$valores[1]</option>";

								}

    						?>



							</select>

			            </fieldset>



			            <fieldset>

			                <p class="label-style">Sua regi&atilde;o:</p>

                            <? $REGIAO = $_SESSION['REGIAO']; ?>

			                <input id="interior" type="radio" name="regiao" value="Interior"  <? if ($REGIAO=="Interior"){echo " checked='checked'";} ?>>

			                <label for="interior">Interior</label>



			                <input id="capital" type="radio" name="regiao" value="Capital" <? if ($REGIAO=="Capital"){echo " checked='checked'";} ?> >

			                <label for="capital">Capital</label>

			            </fieldset>



			            <fieldset>

			                <p class="label-style">Tem Inscri&ccedil;&atilde;o Estadual?</p>

                             <? $IE = $_SESSION['IE']; ?>

			                <input id="sim" type="radio" name="inscricao" value="Sim" <? if ($IE=="Sim"){echo " checked='checked'";} ?>>

			                <label for="sim">Sim</label>



			                <input id="nao" type="radio" name="inscricao" value="Nao" <? if ($IE=="Nao"){echo " checked='checked'";} ?>>

			                <label for="nao">N&atilde;o</label>

			            </fieldset>



			            <p class="small">

			                <small>Os pre&ccedil;os variados s&atilde;o motivados pela incid&ecirc;ncia do DIFAL &ndash; Diferencial de Al&iacute;quota ICMS, obrigat&oacute;rio nas opera&ccedil;&otilde;es de entrada de mercadoria nos estados destinos em opera&ccedil;&otilde;es interestaduais. A tributa&ccedil;&atilde;o de ICMS &eacute; aplicada integralmente para clientes n&atilde;o contribuintes (ou isentos) de Inscri&ccedil;&atilde;o Estadual.

			                </small>

			            </p>            

            			<input type="submit" name="OK" value="OK" id="aplicar" class="bt-enviar" >

                        <? //data-dismiss="modal"	 ?>

                        </form>

        			</div>

                </div>

            </div>

        </div>

    </div>

</div>





<div class="modal myModallogin fade" id="myModallogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">

    <div class="vertical-alignment-helper">

        <div class="modal-dialog vertical-align-center">

            <div class="modal-content style-modal">

            <form>

                <div class="modal-header">                

                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>

                    </button>

                     <h4 class="modal-title" id="myModalLabel2">Login</h4>

                </div>

                <div class="modal-body">                	

					<div class="form">      

			            <fieldset>

			                <label for="email" class="label-style"></label>

			                <input id="email" type="email" name="email" placeholder="e-mail" class="input-form">

			                <label for="password" class="label-style"></label>

			                <input id="password" type="password" name="password" placeholder="digite sua senha" class="input-form">

			            </fieldset>  

 						<p><a href="cadastro.php">Cadastre-se</a></p>  

            			<p><a href="#">Esqueci minha senha</a></p>     

            			<input type="submit" name="logar" value="Entrar" id="logar" class="bt-enviar" >

            		</div>

                </div>

            </div>

            </form>

        </div>

    </div>

</div>





<header>

	<div class="info-topo bg-blue">		

		<div class="container-fluid">

			<div class="row">

				<div class="col-xs-12 col-md-7 col-sm-6">

					<div class="box-atd-online">   

                    



                    <a href="#" onclick = "javascript:void(window.open('http://bicdata.com.br//live/chat.php','','width=590,height=610,left=0,top=0,resizable=yes,menubar=no,location=no,status=yes,scrollbars=yes'))">

                    

                    <p><script type="text/javascript" id="lz_textlink" src="http://www.bicdata.com.br/live/image.php?acid=cea48&amp;tl=1&amp;srv=aHR0cDovL3d3dy5iaWNkYXRhLmNvbS5ici9saXZlL2ltYWdlLnBocD9hY2lkPWVhYmI3&amp;tlont=T05MSU5F&amp;tloft=T0ZGTElORQ__&amp;tlonc=b25saW5l&amp;tlofc=b2ZmbGluZQ__&amp;xhtml=1"></script></p>

                    

                    </a>



</div>

				</div>

				<div class="col-xs-12 col-md-5 col-sm-6">

					<ul class="info-tels">

						<li><a href="skype:live:7150bdb9c8a9fe05?chat"><i class="fa-skype">Skype</i></a></li>						

						<li><strong>WhatsApp:</strong> (11) 99233.8121</li>

						<li><strong>Vendas:</strong> (11) 2972.6416</li>

					</ul>

				</div>

			</div>

		</div>

	</div>



	<div class="info-logo">	

		<div class="container-fluid">

			<div class="row">

				<div class="col-xs-12 col-sm-6 col-md-4">

					<div class="cont-logo">

						<h1 class="logo"><a href="index.php" title="Bicdados - A loja virtual para equipamentos 

	de automação e suprimentos.">Bicdados</a></h1>

						<p>Coleta de dados e automa&ccedil;&atilde;o</p>

					</div>

				</div>

				<div class="col-sm-6 col-md-3 fone-style">

					<h2 class="ligue">Ligue j&aacute; e pe&ccedil;a seu or&ccedil;amento<br><span>(11)</span> <strong>2972.6416</strong></h2>

				</div>

				<div class="col-xs-12 col-sm-6 col-md-3">	

					<ul class="ul-login">

                    

                    <? 

					    $nomeVIS = 'Visitante';

					if (isset($_SESSION['USERNAME']) && $_SESSION['USERNAME'] !=''){

						$nomeVIS = $_SESSION['USERNAME'];

					}						

						?>

                    

						<li class="col-xs-6">Ol&aacute;, <a href="minha-conta.php"><? echo $nomeVIS; ?></a><br>seja bem-vindo</li>

						<li class="col-xs-6">

                         <? if ($nomeVIS == 'Visitante'){ ?>

                             <a href="javascript:void(0);" data-toggle="modal" data-target="#myModallogin">Entrar</a><br>

                             <a href="cadastro.php">Cadastre-se</a>

                             <? }else{ ?>

                             <a href="?logout=1" data-toggle="modal">Sair</a><br>                             

                             <? } ?>

						</li>

					</ul>

				</div>

                

                <? //pega informações do carrinho

				

				  require_once('compras.php');

                  $cart = new Cart();

				  

				  $action = (isset($_GET['action'])) ? $_GET['action'] : '';

                  $CCid = (isset($_GET['id'])) ? $_GET['id'] : 0;

                  $CQtd = (isset($_GET['qtd'])) ? $_GET['qtd'] : 1;

                 				  

				  switch($action) {  				    

	              	case 'add':  

     					//antes de adicionar verifico se ja tem

						$cc=1;

					    if ($cart->itemExist($CCid)){

    						$cc = $cart->getItem($CCid);

	    					$cc=$cc+$CQtd;

		     				$cart->update($CCid, $cc);

						}else{

							$cart->add($CCid,$CQtd);			             		            							            

						}             			

                		break;

             		case 'remove':

            			$cart->remove($CCid);

            	    	break;

               		case 'empty':

        			    $cart->clear();

                		break;

                }				  

				 

				 

				  $items = $cart->totalCount(); 

				 

				?>              

                

				<div class="col-xs-12 col-sm-6 col-md-2">	

					<div class="container-carrinho">

						<div class="info-carrinho">	                        	

							<span><? echo $items; ?>			

							</span>

						</div>

						<p><a href="carrinho.php">Meu Carrinho</a></p>

                        <p><a href="?action=empty">Esvaziar carrinho</a></p>

					</div>

				</div>

			</div>

		</div>

	</div>	



<div class="cont-menu">

	<nav class="navbar">

	  	<div class="container-fluid">

		    <div class="navbar-header">

		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">

		        <span class="icon-bar"></span>

		        <span class="icon-bar"></span>

		        <span class="icon-bar"></span>                        

		      </button>     

		    </div>

		    <div class="collapse navbar-collapse" id="myNavbar">

			    <ul class="nav navbar-nav">

					<li class="dropdown">

						<a class="dropdown-toggle" data-toggle="dropdown" href="#">A Bicdados</a>

						<ul class="dropdown-menu">

							<li><a href="empresa.php"><span>Sobre a empresa</span></a></li>

							<li><a href="solucoes.php"><span>Solu&ccedil;&otilde;es</span></a></li>

							<li><a href="assistencia-tecnica.php"><span>Assist&ecirc;ncia t&eacute;cnica</span></a></li>

							<li><a href="locacao.php"><span>Loca&ccedil;&atilde;o</span></a></li>	

						</ul>

					</li>

					<li class="dropdown">

						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Leitores</a>

						<ul class="dropdown-menu style-txt-menu">

                        

						<? 

                        $resultado=mysql_query("SELECT subcategoria from SubCategoria where categoria='Leitores' order by subcategoria");                                 

                                while ($valx = mysql_fetch_array($resultado)){		

								?>

								<li><a href="busca.php?busca=<? echo $valx[0]; ?>"><span><? echo $valx[0]; ?></span></a></li>

                                <?

								}

    					?>                        	

						</ul>

					</li>



					<li class="dropdown">

						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Impressoras</a>

						<ul class="dropdown-menu style-txt-menu">

                        <? 

                        $resultado=mysql_query("SELECT subcategoria from SubCategoria where categoria='Impressoras' order by subcategoria");                                 

                                while ($valx = mysql_fetch_array($resultado)){		

								?>

								<li><a href="busca.php?busca=<? echo $valx[0]; ?>"><span><? echo $valx[0]; ?></span></a></li>

                                <?

								}

    					?> 							

						</ul>

					</li>



					<li class="dropdown">

						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Etiquetas e Ribbons</a>

						<ul class="dropdown-menu style-txt-menu">

							 <? 

                        $resultado=mysql_query("SELECT subcategoria from SubCategoria where categoria='Etiquetas e Ribbons' order by subcategoria");                                 

                                while ($valx = mysql_fetch_array($resultado)){		

								?>

								<li><a href="busca.php?busca=<? echo $valx[0]; ?>"><span><? echo $valx[0]; ?></span></a></li>

                                <?

								}

    					?> 					

						</ul>

					</li>



					<li class="dropdown">

						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Marcas</a>

						<ul class="dropdown-menu style-txt-menu">

							 <? 

                        $resultado=mysql_query("SELECT marca from Marcas order by marca");                                 

                                while ($valx = mysql_fetch_array($resultado)){		

								?>

								<li><a href="busca.php?busca=<? echo $valx[0]; ?>"><span><? echo $valx[0]; ?></span></a></li>

                                <?

								}

    					?> 	

						</ul>

					</li>



					<li class="dropdown">

						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Servi&ccedil;os</a>

						<ul class="dropdown-menu style-txt-menu style-width-line">

							<li><a href="http://br114.teste.website/~bicda063/software_inventario_datacollect.php"><span>Software para Invent&aacute;rios</span></a></li>

							<li><a href="http://br114.teste.website/~bicda063/manutencao_leitores_multimaras.php"><span>Manuten&ccedil;&atilde;o de Leitores Multimarcas</span></a></li>

							<li><a href="http://br114.teste.website/~bicda063/manutencao_impressoras_multimarcas.php"><span>Manuten&ccedil;&atilde;o de Impressoras Multimarcas</span></a></li>

							<li><a href="http://br114.teste.website/~bicda063/manutencao_coletores_multimarcas.php"><span>Manuten&ccedil;&atilde;o de Coletores Multimarcas</span></a></li>

							<li><a href="http://br114.teste.website/~bicda063/site_survey.php"><span>Site Survey</span></a></li>

							<li><a href="http://br114.teste.website/~bicda063/instalacao_configuracao_suporte_aidc.php"><span>Instala&ccedil;&atilde;o, Configura&ccedil;&atilde;o e Suporte de equipamentos AIDC</span></a></li>

						</ul>

					</li>



			        <li><a href="contato.php">Contato</a></li>

			    </ul>      

		    </div>

	  	</div>

	</nav>

</div>



<div class="cont-lcz-bsc">

	<div class="container">

		<div class="row">

			<div class="col-sm-7 col-md-5">

				<div class="cont-localizacao">

					<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal">

						<p>Clique e selecione a sua localiza&ccedil;&atilde;o</p>

						<p>A loja aplica os impostos e fretes com base na sua localiza&ccedil;&atilde;o</p>

					</a>

				</div>

			</div>

			<div class="col-sm-5 col-md-7">

				<div class="cont-busca">

					<form action="busca.php">

						<div class="form-group">

							<label for="produto">

								<input name="busca" type="text" class="form-control" id="produto" value="<? echo $busca; ?>" placeholder="Busque seu produto">

		          </label>

							<button type="submit" class="btn">buscar</button>

						</div>

					</form>

				</div>

			</div>

		</div>

	</div>

</div>



<? if($pag == 'index.php' || $pag == '' ) {?>

<div class="cont-banner">

	<div class="container-fluid">

		<div class="row">

		<div class="col-md-12">

				<div id="myCarousel" class="carousel slide" data-ride="carousel">

			

						<ol class="carousel-indicators">

							<li data-target="#myCarousel" data-slide-to="0" class="active"></li>

							<li data-target="#myCarousel" data-slide-to="1"></li>

							<li data-target="#myCarousel" data-slide-to="2"></li>

							<li data-target="#myCarousel" data-slide-to="3"></li>

						</ol>

				

						<div class="carousel-inner" role="listbox">

							<div class="item active">

								<figure >     

									<img src="imagens/banner-loja.jpg" alt="banner" class="img-responsive" style="width:100%;">

								</figure>



							</div>



							<div class="item">

								<img src="imagens/banner-coletor.jpg" alt="banner" class="img-responsive" style="width:100%;">

							</div>



							<div class="item">

								<img src="imagens/banner-impressora.jpg" alt="banner" class="img-responsive" style="width:100%;">

							</div>



							<div class="item">

								<img src="imagens/banner.jpg" alt="banner" class="img-responsive" style="width:100%;">

							</div>

						</div>



				

						<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">

							<span class="setas seta-esquerda" aria-hidden="true"></span>

							<span class="sr-only">Previous</span>

						</a>

						<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">

							<span class="setas seta-direita" aria-hidden="true"></span>

							<span class="sr-only">Next</span>

						</a>

					</div>

				</div>

			</div>

		</div>

	</div>











<div class="container-quality">

	<div class="cont-quality-style">

		<div class="container">

			<div class="row">

			<div class="col-sm-12 col-md-12">

				<ul class="ul-cont-imagens">

					<li><span>Vendas e Entrega para todo Brasil</span></li>

					<li><span>Op&ccedil;&atilde;o de entrega com Frete Gr&aacute;tis</span></li>

					<li><span>Formas de pagamento</span></li>

					<li><span>Desconto para pagamento &agrave; Avista</span></li>

				</ul>

			</div>

			</div>

		</div>

	</div>

</div>



<?}?>



</header>