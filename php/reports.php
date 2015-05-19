<?php
include("configs.php");
include("functions.php");

$retMod = modulos();
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Relatórios">
    <meta name="author" content="replay4.me">

    <title>Template para Empresas - Relatórios</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/examples/offcanvas/offcanvas.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="http://getbootstrap.com/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <style>
    .dropdown:hover .dropdown-menu {
      display: block;
    }
  </style>

  <body>
    <nav class="navbar navbar-fixed-top navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="?">Replay4me</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <?
                foreach ($retMod->data->modules as $mod => $value) {
                    if(!empty($value->parent)){
                      ?>
                      <li class="dropdown">
                        <a href="?mod_id=<?=$value->id?>" class="dropdown-toggle" role="button" aria-expanded="false"><?=$value->title?> <span class="caret"></span></a>
                          <ul class="dropdown-menu" role="menu">
                            <?
                              foreach ($value->parent as $par => $parent) {
                                ?>
                                <li><a href="?mod_id=<?=$parent->id?>"><?=$parent->title?></a></li>
                                <?
                              }
                            ?>
                          </ul>
                        </li>
                      <?
                    } else {
                    ?>
                        <li><a href="?mod_id=<?=$value->id?>"><?=$value->title?></a></li>
                    <?
                    }
                }
            ?>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->

    <div class="container">

      <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-12">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>
          <div class="jumbotron">
            <h1>Relatórios de Exemplo</h1>
            <p>Este é um exemplo simples de como listar e exibir os relatórios das playlist por módulo.</p>
          </div>
            <div class="row">
                <?
                    if(isset($_GET["mod_id"])>0){

                        // VERIFICA SE EXISTE EMBED_TOKEN PARA EXIBIR O RELATÓRIO
                        if(isset($_GET["embed_token"])==""){

                            $retPL = playlist($_GET["mod_id"]);

                            foreach ($embed = $retPL->data->playlists as $pl => $value) {
                                ?>
                                  <a href="?mod_id=<?=$_GET["mod_id"]?>&embed_token=<?=$value->embed_token?>"><?=$value->title?></a><br>
                                <?
                            }
                        } else {
                          if(empty($_GET["email"])){
                              $retRep = relatorios($_GET["embed_token"], "");
                              foreach ($users = $retRep->data->users_who_watched as $user => $value) {
                                  ?>
                                    <a href="?mod_id=<?=$_GET["mod_id"]?>&embed_token=<?=$_GET["embed_token"]?>&email=<?=$value->email?>"><?=$value->fullname?></a> - <?=round($value->percent,0)?>%</br>
                                  <?
                              }
                           } else {
                            $retRep = relatorios($_GET["embed_token"], $_GET["email"]);
                            $user = $retRep->data->user
                              ?>
                                <?=$user->fullname?></a> - <?=round($user->percent,0)?>%
                              <?
                           }
                        }
                    }
                ?>
            </div><!--/row-->
        </div><!--/.col-xs-12.col-sm-12-->

      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Replay4me 2015</p>
      </footer>

    </div><!--/.container-->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="http://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>

    <script src="http://getbootstrap.com/examples/offcanvas/offcanvas.js"></script>
  </body>
</html>