<?php
function cabecalho($title)
{
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/mdb.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" media="screen" type="text/css" href="css/colorpicker.css" />
  <link rel="stylesheet" href="css/estilo.css">
  <title><?php echo $title; ?></title>
</head>
 
<body>

  <nav class="mb-1 navbar navbar-expand-lg navbar-dark default-color">
  <a class="navbar-brand" href="#">IF SYSTEM</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333"
    aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">Cadastro
        </a>
        <div class="dropdown-menu dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
          <a class="dropdown-item" href="produtos">Produtos</a>
          <a class="dropdown-item" href="#">Usuários</a>
        </div>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto nav-flex-icons">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-default"
          aria-labelledby="navbarDropdownMenuLink-333">
          <a class="dropdown-item" href="#">Editar Perfil</a>
          <a class="dropdown-item" href="#">Sair</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
<?php 
}
function scripts(){
  ?>
  <div class="modal fade" id="modalPadrao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none">
        <h5 class="modal-title" id="tituloModal">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="corpoModal">
        
      </div>
      <div class="modal-footer" id="rodapeModal" style="border-top: none">
        <!-- <button type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Sair</button> -->
        <!-- <button type="button" class="btn btn-primary confirmarExc">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

  <script type="text/javascript" src="js/jquery.min.js"></script>

  <script type="text/javascript" src="js/popper.min.js"></script>

  <script type="text/javascript" src="js/bootstrap.min.js"></script>

  <script type="text/javascript" src="js/mdb.min.js"></script>
<script type="text/javascript" src="js/colorpicker.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
  
 <?php
}

function fimCorpo()
{
  ?>
  
 
</body>
</html>
<?php
}
?>