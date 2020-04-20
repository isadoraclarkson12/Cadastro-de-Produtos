<?php
include 'principal.php';
cabecalho('Cadastro de Produtos');
?>
<div class="container">
	<form class="form-row col-md-10" style="margin-top: 20px" id="formCadProd">
		<div class="form-group col-md-12">
			<h1>Cadastro de Produtos</h1>
		</div>
		<div class="form-group col-md-6">
			<label for="">Descrição</label>
			<input type="text" name="descricao" class="form-control">
			<input type="text" name="prod" style="display: none">
			<input type="text" name="status" style="display: none">
		</div>
		<div class="form-group col-md-6">
			<label for="">Valor</label>
			<input type="text" name="valor" class="form-control" data-thousands="." data-decimal=",">
		</div>
		<div class="form-group col-md-12">
			<label for="">Variação de cor</label>
			<select class="form-control" name="variacaoCor">
				<option value="">Selecione uma opção</option>
				<option value="1">Produto sem variação de cor</option>
				<option value="2">Produto com variação de cor</option>
			</select>
		</div>
		<div class="form-group col-md-12 cvariacao hide">
			<label>Selecione uma ou mais cores</label><br>
			<input type="checkbox" name="color[]" value="aqua"><label for="" style="background-color: aqua; border: 1px solid black" title="Azul Marinho">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="checkbox" name="color[]" value="black"><label for="" style="background-color: black; border: 1px solid black" title="Preto">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="checkbox" name="color[]" value="white"><label for="" style="background-color: white; border: 1px solid black" title="Branco">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="checkbox" name="color[]" value="green"><label for="" style="background-color: green; border: 1px solid black" title="Verde">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="checkbox" name="color[]" value="yellow"><label for="" style="background-color: yellow; border: 1px solid black" title="Amarelo">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="checkbox" name="color[]" value="blue"><label for="" style="background-color: blue; border: 1px solid black" title="Azul">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="checkbox" name="color[]" value="pink"><label for="" style="background-color: pink; border: 1px solid black" title="Rosa">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="checkbox" name="color[]" value="beige"><label for="" style="background-color: beige; border: 1px solid black" title="Bege">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="checkbox" name="color[]" value="orange"><label for="" style="background-color: orange; border: 1px solid black" title="Laranja">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="checkbox" name="color[]" value="maroon"><label for="" style="background-color: maroon; border: 1px solid black" title="Marrom">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="checkbox" name="color[]" value="brown"><label for="" style="background-color: brown; border: 1px solid black" title="Castanho">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="checkbox" name="color[]" value="gray"><label for="" style="background-color: gray; border: 1px solid black" title="Cinza">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="checkbox" name="color[]" value="silver"><label for="" style="background-color: silver; border: 1px solid black" title="Prata">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="checkbox" name="color[]" value="blueviolet"><label for="" style="background-color: blueviolet; border: 1px solid black" title="Azul Violeta">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="checkbox" name="color[]" value="cadetblue"><label for="" style="background-color: cadetblue; border: 1px solid black" title="Azul Cadete">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="checkbox" name="color[]" value="lightgreen"><label for="" style="background-color: lightgreen; border: 1px solid black" title="Verde Claro">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="checkbox" name="color[]" value="lightsalmon"><label for="" style="background-color: lightsalmon; border: 1px solid black" title="Salmão Claro">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
		</div>
		<div class="form-group col-md-12 svariacao hide">
			<label>Selecione a cor</label><br>
			<input type="radio" name="wcolor[]" value="aqua"><label for="" style="background-color: aqua; border: 1px solid black" title="Azul Marinho">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="radio" name="wcolor[]" value="black"><label for="" style="background-color: black; border: 1px solid black" title="Preto">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="radio" name="wcolorwcolor[]" value="white"><label for="" style="background-color: white; border: 1px solid black" title="Branco">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="radio" name="wcolor[]" value="green"><label for="" style="background-color: green; border: 1px solid black" title="Verde">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="radio" name="wcolor[]" value="yellow"><label for="" style="background-color: yellow; border: 1px solid black" title="Amarelo">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="radio" name="wcolor[]" value="blue"><label for="" style="background-color: blue; border: 1px solid black" title="Azul">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="radio" name="wcolor[]" value="pink"><label for="" style="background-color: pink; border: 1px solid black" title="Rosa">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="radio" name="wcolor[]" value="beige"><label for="" style="background-color: beige; border: 1px solid black" title="Bege">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="radio" name="wcolor[]" value="orange"><label for="" style="background-color: orange; border: 1px solid black" title="Laranja">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="radio" name="wcolor[]" value="maroon"><label for="" style="background-color: maroon; border: 1px solid black" title="Marrom">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="radio" name="wcolor[]" value="brown"><label for="" style="background-color: brown; border: 1px solid black" title="Castanho">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="radio" name="wcolor[]" value="gray"><label for="" style="background-color: gray; border: 1px solid black" title="Cinza">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="radio" name="wcolor[]" value="silver"><label for="" style="background-color: silver; border: 1px solid black" title="Prata">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="radio" name="wcolor[]" value="blueviolet"><label for="" style="background-color: blueviolet; border: 1px solid black" title="Azul Violeta">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="radio" name="wcolor[]" value="cadetblue"><label for="" style="background-color: cadetblue; border: 1px solid black" title="Azul Cadete">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="radio" name="wcolor[]" value="lightgreen"><label for="" style="background-color: lightgreen; border: 1px solid black" title="Verde Claro">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
			<input type="radio" name="wcolor[]" value="lightsalmon"><label for="" style="background-color: lightsalmon; border: 1px solid black" title="Salmão Claro">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
		</div>
		<div class="form-group col-md-12 text-right">
			<button type="submit" class="btn btn-warning">Salvar</button>
			<a href="produtos" class="btn btn-light">Cancelar/Voltar</a>
		</div>
	</form>
</div>
<?php
scripts();
?>
<script type="text/javascript" src="js/produtos.js"></script>
<?php
fimCorpo();
?>