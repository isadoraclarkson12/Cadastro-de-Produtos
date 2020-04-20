<?php
include 'principal.php';
cabecalho('Cadastro de Usuários');
?>
<div class="container">
	<form class="form-row col-md-10" style="margin-top: 20px" id="formUsuario">
		<div class="form-group col-md-12">
			<h1>Cadastro de Usuários</h1>
		</div>
		<div class="form-group col-md-8">
			<label for="">Nome</label>
			<input type="text" name="nome" class="form-control">
			<input type="text" name="user" style="display: none">
			<input type="text" name="status" style="display: none">
		</div>
		<div class="form-group col-md-4">
			<label for="">Data de Nascimento</label>
			<input type="date" name="data_nasc" class="form-control">
		</div>
		<div class="form-group col-md-6">
			<label for="">Rg</label>
			<input type="text" name="rg" class="form-control">
		</div>
		<div class="form-group col-md-6">
			<label for="">Cpf</label>
			<input type="text" name="cpf" class="form-control">
		</div>
		<div class="form-group col-md-2">
			<label for="">Cep</label>
			<input type="text" name="cep" class="form-control">
		</div>
		<div class="form-group col-md-6">
			<label for="">Endereço</label>
			<input type="text" name="endereco" class="form-control">
		</div>
		<div class="form-group col-md-4">
			<label for="">Complemento</label>
			<input type="text" name="complemento" class="form-control" placeholder="Ex.: bloco 3.">
		</div>
		<div class="form-group col-md-3">
			<label for="">Bairro</label>
			<input type="text" name="bairro" class="form-control">
		</div>
		<div class="form-group col-md-6">
			<label for="">Cidade</label>
			<input type="text" name="cidade" class="form-control">
		</div>
		<div class="form-group col-md-3">
			<label for="">UF</label>
			<select class="form-control" name="uf">
				<option value="">Selecione uma opção</option>
				<option value="AC">Acre</option>
				<option value="AL">Alagoas</option>
				<option value="AP">Amapá</option>
				<option value="AM">Amazonas</option>
				<option value="BA">Bahia</option>
				<option value="CE">Ceará</option>
				<option value="DF">Distrito Federal</option>
				<option value="ES">Espírito Santo</option>
				<option value="GO">Goiás</option>
				<option value="MA">Maranhão</option>
				<option value="MT">Mato Grosso</option>
				<option value="MS">Mato Grosso do Sul</option>
				<option value="MG">Minas Gerais</option>
				<option value="PA">Pará</option>
				<option value="PB">Paraíba</option>
				<option value="PR">Paraná</option>
				<option value="PE">Pernambuco</option>
				<option value="PI">Piauí</option>
				<option value="RJ">Rio de Janeiro</option>
				<option value="RN">Rio Grande do Norte</option>
				<option value="RS">Rio Grande do Sul</option>
				<option value="RO">Rondônia</option>
				<option value="RR">Roraima</option>
				<option value="SC">Santa Catarina</option>
				<option value="SP">São Paulo</option>
				<option value="SE">Sergipe</option>
				<option value="TO">Tocantins</option>
			</select>
		</div>
		<div class="form-group col-md-6">
			<label for="">E-mail</label>
			<input type="text" name="email" class="form-control">
		</div>
		<div class="form-group col-md-6">
			<label for="">Nome de Usuário</label>
			<input type="text" name="usuario" class="form-control">
		</div>
		<div class="form-group col-md-6">
			<label for="">Senha</label>
			<input type="password" name="senha" class="form-control">
		</div>
		<div class="form-group col-md-6">
			<label for="">Tipo de Usuário</label>
			<select class="form-control" name="tipo_usuario">
				<option value="">Selecione uma opção</option>
				<option value="1">Master</option>
				<option value="2">Comum</option>
			</select>
		</div>

		<div class="form-group col-md-12 text-right">
			<button type="submit" class="btn btn-warning">Salvar</button>
			<a href="usuarios" class="btn btn-light">Cancelar/Voltar</a>
		</div>
	</form>
</div>
<?php
scripts();
?>
<script type="text/javascript" src="js/usuarios.js"></script>
<?php
fimCorpo();
?>