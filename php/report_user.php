<?php
session_start();
include("configs.php");
include("functions.php");

// VERIFICAR SE FOI DEFINIDO ALGUM USUÁRIO
if(empty($_POST['email'])){
    if(empty($_SESSION['email'])){
        $_SESSION['email'] = null;
    } else {
        $_SESSION['email'] = $_SESSION['email'];
    }
} else {
    $_SESSION['email'] = $_POST['email'];
}

$flag_fullname = false;

$retMod = modulos();
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Relatório por usuário">
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
            <p>Este é um exemplo simples de como listar relatórios de todas as playlist e trilhas de um módulo por usuário.</p>
          </div>
            <div class="row">
              <form action="" method="post" class="form">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="email">E-mail</label>
                        <div class="input-group">
                            <input type="text" name="email" value="<?=$_SESSION['email']?>" class="form-control" id="email" placeholder="usuario@empresa.com">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">ok</button>
                            </span>
                        </div>
                    </div>

                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="fullname">Nome</label>
                          <input class="form-control" id="fullname" type="text" disabled>
                    </div>
                  </div>
                </div>

              </form>
                <?
                    if(isset($_GET["mod_id"])>0){

                      $retPL = playlist($_GET["mod_id"]);

                            foreach ($embed = $retPL->data->playlists as $pl => $value) {
                              $retRep = relatorios($value->embed_token, $_SESSION['email']);
                              // VERIFICAR SE EXISTE INFORMAÇÃO DO USUARIO, OU SEJA, SE VISUALIZOU
                              if(empty($retRep->data->user->percent)){
                                $user_value = "sem informações";
                              } else {
                                $user_value = round($retRep->data->user->percent,0) . "%";
                                // GUARDA INFORMACAO DO NOME DO USUARIO
                                if(!$flag_fullname){
                                    $fullname = $retRep->data->user->fullname;
                                    $flag_fullname = true;
                                }
                              }
                                ?>
                                  <?=$value->title?> - <?=$user_value?><br>
                                <?
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

    <?
    if(!$flag_fullname){
      $fullname = "NÃO ENCONTRADO";
    }
    ?>

    <script>
      document.getElementById("fullname").value = "<?=$fullname;?>";
    </script>

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