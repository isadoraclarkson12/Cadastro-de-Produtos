<?php
include 'principal.php';
cabecalho('Usuários');
?>
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<h1>Usuários</h1>
		</div>
    <div class="col-md-6 text-right">
      <a href="cad_usuario" class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Usuário</a>
    </div>
		<div class="col-md-12">
			<table class="table table-sm" id="tabUsuarios">
  <thead>
    <tr>
      <th scope="col">Usuário</th>
      <th scope="col">E-mail</th>
       <th scope="col">Tipo</th>
      <th scope="col" style="text-align: center">Ação</th>
    </tr>
  </thead>
  <tbody>
   
  </tbody>
</table>
		</div>
	</div>
</div>
<?php
scripts();
?>
<script type="text/javascript" src="js/usuarios.js"></script>
<?php
fimCorpo();
?>