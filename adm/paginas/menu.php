<nav class="navbar navbar-default sidebar" role="navigation">

    <div class="container-fluid">

    <div class="navbar-header">

      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">

        <span class="sr-only">Toggle navigation</span>

        <span class="icon-bar"></span>

        <span class="icon-bar"></span>

        <span class="icon-bar"></span>

      </button>      

    </div>

    

    <? $pag=$_GET['oq'];  ?>

    

    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">

      <ul class="nav navbar-nav navegacao">





        <!--<li <?php if($pag == '') {?>class="active" <?php }?>><a href="index.php">HOME<span style="font-size:16px;" class="pull-right  showopacity glyphicon 	glyphicon glyphicon-home"></span></a></li>-->





<style type="text/css">

  

nav.sidebar a {

    padding: 20px!important;

    text-align: left;

    width: 100%;

    display: inline-block;

    border-bottom: 1px solid #cccccc;

    text-decoration: none!important;

    color: #3e3e3e;

}

nav.sidebar a:hover {

    background-color: #990900;

    color: #fff!important;

}

.panel-heading {

    padding:0;



}

.collapse li{

 background-color: #ebebeb;

}



.collapse li a{

    color: #939393;

}

.panel-title a{

background-color: #dbdbdb;

    color: #444!important;

    font-weight: 300;

}

.navegacao li a:hover span, .navegacao li.active a span {

    color: #fff;

}

</style>



 <div class="panel-group" id="accordion">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">ADMINISTRADOR</a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse">
       <li <?php if($pag == 'usuarios') {?>class="active" <?php }?>>
         <a href="?oq=usuarios" class="ajax" data-titulo="Categorias">Usuários<span style="font-size:16px;" class="pull-right  showopacity   glyphicon glyphicon-tag"></span></a>
         </li>       
       <li <?php if($pag == 'clinicas') {?>class="active" <?php }?>>
         <a href="?oq=clinicas">Clinicas<span style="font-size:16px;" class="pull-right  showopacity glyphicon glyphicon-picture"></span></a>                  
         </li>       
       <li <?php if($pag == 'atribuiruser') {?>class="active" <?php }?>>
         <a href="?oq=atribuiruser">Usuários das Clinicas<span style="font-size:16px;" class="pull-right  showopacity glyphicon glyphicon-picture"></span></a>
         
         </li>                
       <li <?php if($pag == 'colabs') {?>class="active" <?php }?>>
         <a href="?oq=colabs">Colaboradores<span style="font-size:16px;" class="pull-right  showopacity glyphicon glyphicon-picture"></span></a>
         </li>       
       <li <?php if($pag == 'pacientes') {?>class="active" <?php }?>>
         <a href="?oq=pacientes">Pacientes<span style="font-size:16px;" class="pull-right  showopacity glyphicon glyphicon-picture"></span></a>
         </li>       
       <li <?php if($pag == 'formularios') {?>class="active" <?php }?>>
         <a href="?oq=criaQuestao" class="ajax" data-titulo="Adminstradores">Formulários</a>
         </li>       
       <li <?php if($pag == 'atribuir') {?>class="active" <?php }?>>
         <a href="?oq=atribuir" class="ajax" data-titulo="Adminstradores">Formulários das Clinicas</a>
         </li>
       <li <?php if($pag == 'movimentos') {?>class="active" <?php }?>>
         <a href="?oq=movimentos">Evoluções<span style="font-size:16px;" class="pull-right  showopacity glyphicon glyphicon-record"></span></a>
         </li>             
       <li <?php if($pag == 'selClinica') {?>class="active" <?php }?>>
         <a href="?oq=selClinica">Selecionar Clinica para Gerenciamento<span style="font-size:16px;" class="pull-right  showopacity glyphicon glyphicon-record"></span></a>
         </li>             

         
      </div>
    </div>


    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
        <?
		 $exi = "";
          // pego a clinica atual, caso tenha
         if (isset($_SESSION['CLINICA'])){			
     	 $result=mysqli_query($con, 'SELECT * from clinicas where id ='.$_SESSION['CLINICA']);             $rows=mysqli_num_rows($result);		 
             while ($valores = mysqli_fetch_array($result)){
				     $xidCli= $valores[0];
                     $xnome = $valores[1];                     
					 $exi = $xidCli.'-'.$xnome;
					 break;
			 }				 
		mysqli_free_result($result);		
		}
		?>
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">GERENCIA<BR /><? echo $exi; ?></a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
       <li <?php if($pag == 'usersCli') {?>class="active" <?php }?>>
         <a href="?oq=usersCli" class="ajax" data-titulo="Categorias">Usuários<span style="font-size:16px;" class="pull-right  showopacity   glyphicon glyphicon-tag"></span></a>
         </li>       

       <li <?php if($pag == 'clinica') {?>class="active" <?php }?>>
         <a href="?oq=clinica">Informações<span style="font-size:16px;" class="pull-right  showopacity glyphicon glyphicon-picture"></span></a>
         </li>       

       <li <?php if($pag == 'colab') {?>class="active" <?php }?>>
         <a href="?oq=colab">Colaboradores<span style="font-size:16px;" class="pull-right  showopacity glyphicon glyphicon-picture"></span></a>
         </li>       

       <li <?php if($pag == 'paciente') {?>class="active" <?php }?>>
         <a href="?oq=paciente">Pacientes<span style="font-size:16px;" class="pull-right  showopacity glyphicon glyphicon-picture"></span></a>
         </li>       

       <li <?php if($pag == 'forms') {?>class="active" <?php }?>>
         <a href="?oq=forms" class="ajax" data-titulo="Adminstradores">Formulários</a>
         </li>              
       <li <?php if($pag == 'movimento') {?>class="active" <?php }?>>
         <a href="?oq=movimento">Evoluções<span style="font-size:16px;" class="pull-right  showopacity glyphicon glyphicon-record"></span></a>
         </li>             
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">COLABORADORES</a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
       <li <?php if($pag == 'usuarios') {?>class="active" <?php }?>>
         <a href="?oq=usuarios" class="ajax" data-titulo="Categorias">Usuários<span style="font-size:16px;" class="pull-right  showopacity   glyphicon glyphicon-tag"></span></a>
         </li>       

       <li <?php if($pag == 'clinicas') {?>class="active" <?php }?>>
         <a href="?oq=clinicas">Clinicas<span style="font-size:16px;" class="pull-right  showopacity glyphicon glyphicon-picture"></span></a>
         </li>       

       <li <?php if($pag == 'colabs') {?>class="active" <?php }?>>
         <a href="?oq=colabs">Colaboradores<span style="font-size:16px;" class="pull-right  showopacity glyphicon glyphicon-picture"></span></a>
         </li>       

       <li <?php if($pag == 'pacientes') {?>class="active" <?php }?>>
         <a href="?oq=pacientes">Pacientes<span style="font-size:16px;" class="pull-right  showopacity glyphicon glyphicon-picture"></span></a>
         </li>       

       <li <?php if($pag == 'formularios') {?>class="active" <?php }?>>
         <a href="?oq=formularios" class="ajax" data-titulo="Adminstradores">Formulários</a>
         </li>              
       <li <?php if($pag == 'movimentos') {?>class="active" <?php }?>>
         <a href="?oq=movimentos">Evoluções<span style="font-size:16px;" class="pull-right  showopacity glyphicon glyphicon-record"></span></a>
         </li>             
      </div>
    </div>


    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">USUARIOS</a>
        </h4>
      </div>
      <div id="collapse4" class="panel-collapse collapse">

       <li <?php if($pag == 'clinicas') {?>class="active" <?php }?>>
         <a href="?oq=clinicas">Clinicas<span style="font-size:16px;" class="pull-right  showopacity glyphicon glyphicon-picture"></span></a>
         </li>       

       <li <?php if($pag == 'colabs') {?>class="active" <?php }?>>
         <a href="?oq=colabs">Colaboradores<span style="font-size:16px;" class="pull-right  showopacity glyphicon glyphicon-picture"></span></a>
         </li>       

       <li <?php if($pag == 'pacientes') {?>class="active" <?php }?>>
         <a href="?oq=pacientes">Pacientes<span style="font-size:16px;" class="pull-right  showopacity glyphicon glyphicon-picture"></span></a>
         </li>       

       <li <?php if($pag == 'movimento') {?>class="active" <?php }?>>
         <a href="?oq=movimento">Evoluções<span style="font-size:16px;" class="pull-right  showopacity glyphicon glyphicon-record"></span></a>
         </li>             
      </div>
    </div>



  </div> 





		  <li><a href="#">SAIR<span style="font-size:16px;" class="pull-right  showopacity glyphicon glyphicon-off"></span></a></li>

      

      </ul>

    </div>

  </div>

</nav>