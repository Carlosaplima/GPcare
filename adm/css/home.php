

<div  class="main bg-all style-m-p-full">

	<div class="container">

		<div class="row">

			<div class="col-md-12">



				<h1 class="tit-p-pg">Produtos <span>BicDados</span> mais vendidos</h1>

			</div>



			<div class="container-produtos">



<?                     



        if (! isset($_SESSION['ESTADO'])) {			

			$_SESSION['ESTADO']="SP";

			}

		if (! isset($_SESSION['IE'])) {			

            $_SESSION['IE']="Nao";

   			}





        $result=mysql_query("SELECT * FROM MaisVendidos");    

        $rows=mysql_num_rows($result); 

           while ($valores = mysql_fetch_array($result)){	 

               $id = $valores[1];

			   //echo "Peguei o $id-";

 	           $xresult=mysql_query('SELECT idprod, idmarca, titulo, forn FROM Produtos where id = '.$id);    

			   //echo "Pesquisando:SELECT id, idmarca, titulo FROM Produtos where id = .$id-";

               $xrows=mysql_num_rows($xresult);              

			   //echo "Linhas: $xrows";

			   $ct = 0;

               while ($xvalores = mysql_fetch_array($xresult)){

				   $ct=$ct+1;

				   if ($ct>4){break;}

				   $idprod = $xvalores[0];

				   $idmarca = $xvalores[1];

				   $titulo  = $xvalores[2];

				   $forn  = $xvalores[3];

				   

               ?>

 

				<div class="col-xs-6 col-sm-4 col-md-3 box-prd-info-pdt">

					<div class="box-produto">

						<figure>

							<img src="<? echo RetornaImagem("imgs/produtos", $idprod) ?>" class="img-responsive" alt="<? echo $titulo; ?>" title="<? echo $titulo; ?>">

							<span><img  src="<? echo RetornaImagem("imgs/marcas", $idmarca); ?>" class="img-responsive" alt="<? echo $titulo; ?>" title="<? echo $titulo; ?>"></span>

						</figure>			



						<div class="cont-valores">														                       

						<span><? echo $titulo; ?></span>

                            <span></span>                            

							<!-- <span>De: R$ 0.000,00</span> -->                                                        

                            <? 			

                             $Yuf = $_SESSION['ESTADO'];

			                 $Yie = $_SESSION['IE'];							

							 $retorno=PegaPreco($idprod, $forn, $Yuf, $Yie ); ?>                             

							<span><? echo $retorno; ?></span> 

                            <span></span>

							<span></span>

							<span>Preço para <? echo $_SESSION['ESTADO']; 

							if ($Yie=="Sim"){

								echo " Com IE";

							}else{

								echo " Sem IE";

							}

							?></span> 

							<!-- <span>12x de R$ 391,23</span> -->

						</div>



						<a href="produtos.php?id=<? echo $idprod;?>" class="bta icon-bt bg-mais-position bg-color-lrj">Detalhes</a>

   						<? if ($retorno!='Consulte') {?>                        

						<a href="?action=add&id=<? echo $idprod; ?>" class="bta icon-bt bg-car-position bg-color-vm">Adicionar</a>

                       <? }?>

					</div>

				</div>	

               <?			   

			   }

			   }

			   ?>

				



			</div>









		</div>

	</div>

</div >





<div class="main style-m-p-full bg-barras">

	<div class="container">

		<div class="row">

			<div class="col-xs-6 col-md-12">

				<article class="container-box-s">

					<div class="box-s  bg-1">

						<span class="efeito-op color-op-a"></span>



						<a href="/solucoes.php">

							<h2>Soluções <span>BicDados</span></h2>

							<p>Confira as soluções que a BicData pode levar até a sua empresa, seja qual for seu ramo de atuação.</p>

						</a>



					</div>

				</article>





				<article class="container-box-s">

					<div class="box-s bg-2">

						<span class="efeito-op color-op-b"></span>



						<a href="/assistencia-tecnica.php">

							<h2>Assistência técnica</h2>

							<p>Com a assistência técnica da BicData, você evita problemas.</p>

						</a>



					</div>

				</article>	





								<article class="container-box-s">

					<div class="box-s  bg-3">

						<span class="efeito-op color-op-c"></span>



						<a href="/locacao.php">

							<h2>Locação</h2>

							<p>A BicData disponibiliza um amplo estoque para locação imediata.</p>

						</a>



					</div>

				</article>	



			</div>



		</div>

	</div>

</div >







<div  class="main bg-all style-m-p-full">

	<div class="container">

		<div class="row">

			<div class="col-md-12">



				<h1 class="tit-p-pg">Produtos <span>BicDados</span> em destaque</h1>

			</div>



			<div class="container-produtos">

        

		<?

        $result=mysql_query('SELECT * FROM Destaque');    

        $rows=mysql_num_rows($result); 

		$ct = 0 ;

           while ($valores = mysql_fetch_array($result)){	 

               $id = $valores[1];			   

 	           $xresult=mysql_query('SELECT id, idmarca, titulo, forn FROM Produtos where id = '.$id);    			   

               $xrows=mysql_num_rows($xresult);              			   

               while ($xvalores = mysql_fetch_array($xresult)){

				   $ct=$ct+1;

				   if ($ct>4){break;}

				   $idprod = $xvalores[0];

				   $idmarca = $xvalores[1];

				   $titulo  = $xvalores[2];

				   $forn  = $xvalores[3];				   

               ?>

				<div class="col-xs-6 col-sm-4 col-md-3 box-prd-info-pdt">

					<div class="box-produto">

						<figure>

							<img src="<? echo RetornaImagem("imgs/produtos", $idprod) ?>" class="img-responsive" alt="<? echo $titulo; ?>" title="<? echo $titulo; ?>">

							<span><img  src="<? echo RetornaImagem("imgs/marcas", $idmarca); ?>" class="img-responsive" alt="<? echo $marca;?>" title="<? echo $marca;?>"></span>

						</figure>			

						<div class="cont-valores">

							<span><? echo $titulo; ?></span>

							<span></span> 

							<? 			

                             $Yuf = $_SESSION['ESTADO'];

			                 $Yie = $_SESSION['IE'];							

							 $retorno=PegaPreco($idprod, $forn, $Yuf, $Yie ); ?>                             

							<span><? echo $retorno; ?></span> 

							<span></span>

							<span>Preço para <? echo $_SESSION['ESTADO']; 

							if ($Yie=="Sim"){

								echo " Com IE";

							}else{

								echo " Sem IE";

							}

							?></span> 

						</div>

						

						<a href="produtos.php?id=<? echo $idprod;?>" class="bta icon-bt bg-mais-position bg-color-lrj">Detalhes</a>

   						<? if ( $retorno!='Consulte') {?>                                                

						<a href="?action=add&id=<? echo $idprod; ?>" class="bta icon-bt bg-car-position bg-color-vm">Adicionar</a>

                                                <? }?>

					</div>

				</div>	

               <?			   

			   }

			   }

			   ?>



			</div>



		</div>

	</div>

</div >



<div  class="main style-border-bottom style-m-p-full">

	<div class="container">

		<div class="row">

			<div class="col-md-12">



				<h1 class="tit-p-pg">Navegue pelas <span>marcas</span></h1>



			</div>



				<div class="container-marcas">	







<!--################# HEADER ################-->

<?php include("marcas.php"); ?>

<!--############# FIM HEADER ################-->





				</div>



		</div>

	</div>

</div >

	





<div  class="container-news bg-barras-invert style-m-p-full style-line-top">	

	<div class="container">

		<div class="row">

			<div class="col-md-12">

			<h1><span>Blog</span> BicDados</h1>

<?

$list_items = include("pegaposts.php");

?>



			<ul class="cont-news-blog">



            <? echo $list_items; ?>            

			<!--	<li><a href="#" target="_blank"><span>20 out 2016</span> Por que investir em uma Impressora de Cartões ZXP Série 3?</a></li>

				<li><a href="#" target="_blank"><span>20 out 2016</span> Impressora Zebra: Tipos e funcionalidades</a></li>

				<li><a href="#" target="_blank"><span>20 out 2016</span> Impressora Zebra: Abra sua própria empresa com impressão de cartões</a></li>

				<li><a href="#" target="_blank"><span>20 out 2016</span> Software para coletor de dados agiliza processo de inventário</a></li>

                -->

			</uL>



			</div>

		</div>

	</div>

</div >













