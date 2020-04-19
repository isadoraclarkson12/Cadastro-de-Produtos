<?php
include 'principal.php';
cabecalho('Produtos');
?>
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<h1>Produtos</h1>
		</div>
    <div class="col-md-6 text-right">
      <a href="cad_produto" class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Produto</a>
    </div>
		<div class="col-md-12">
			<table class="table table-sm" id="tabProdutos">
  <thead>
    <tr>
      <th scope="col">Descrição</th>
      <th scope="col">Cor</th>
       <th scope="col">Valor</th>
      <th scope="col">Situação</th>
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
<script type="text/javascript" src="js/produtos.js"></script>
<?php
fimCorpo();
?>