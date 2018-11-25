<?php 
       session_start();
$pag = basename($_SERVER['SCRIPT_NAME']);?>


<head>

    <!-- <meta charset="utf-8">-->

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> -->

	<title>Admin - GPCare</title>



	<meta name="viewport" content="width=device-width, initial-scale=1">

	

	<meta name="title" content="Admin GpCare">	

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





	<link rel="stylesheet" href="css/fontes.css" >





	<link rel="stylesheet" href="admin.css">
</head>
<body>
<header>

<?php if($pag == 'login.php') {?>
<style type="text/css">
	body,html{ height: 100%;}
</style>
<?php }?>

<?php if($pag !== 'login.php') {?>

<div class="info-logo style-logo-adm">	
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-5 col-sm-6 col-md-12">
					<div class="cont-logo">
					<div class="logo"><a href="index.php" title="Zan">GPCare</a></div>						
					</div>
				</div>	
			</div>
		</div>
	</div>	
	<?php }?>
<div class="container-fluid style_http_host">
	<div class="row">
		<div class="col-xs-5 col-sm-6 col-md-12">

			<!-- <h2><? // echo $_SERVER['HTTP_HOST']; ?></h2> -->

		</div>

	</div>

</div>



</header>





