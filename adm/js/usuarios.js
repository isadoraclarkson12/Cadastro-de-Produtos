$(document).ready(function(){
	var tipo = JSON.parse(localStorage.getItem('tipo'));
    $("[name='cpf']").mask('000.000.000-000');
    $("[name='cep']").mask('00.000-000');
    $("[name='rg']").mask('00.000.000-0');
	if(tipo == 1){
		var id = postUrl();
		if(id != null){
			buscarUsuario(id);
			$("[name='user']").val(id);
			$("[name='status']").val(1);

		}		
		listarUsuarios();
		$("#formUsuario").validate({
			rules: {
				nome: {
					required: true
				},
				usuario: {
					required: true
				},
				senha: {
					required: true
				},
				tipo_usuario:{
					required: true
				}
			},
			messages: {
				nome: {
					required: '<label style="color: red" class="small">Por favor, informe o nome completo.</label>'
				},
				usuario: {
					required: '<label style="color: red" class="small">Por favor, informe o nome de usuário.</label>'
				},
				senha: {
					required: '<label style="color: red" class="small">Por favor, informe a senha.</label>'
				},
				tipo_usuario:{
					required: '<label style="color: red" class="small">Por favor, selecione o tipo de usuário.</label>'
				}
			}
		});
		function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("[name='endereco']").val("");
                $("[name='bairro']").val("");
                $("[name='cidade']").val("");
                $("[name='uf']").val("");
            }
		$("[name='cep']").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("[name='endereco']").val(dados.logradouro);
                                $("[name='bairro']").val(dados.bairro);
                                $("[name='cidade']").val(dados.localidade);
                                $("[name='uf']").val(dados.uf);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
	}else{
		window.location.href = 'error.html';
	}
	
});
function postUrl() {
	var url_string = window.location.href;
	var url = new URL(url_string);
	var id = url.searchParams.get("id");
	return id;
}
function listarUsuarios(){
	$.ajax({
		type: 'POST',
		url: '../api/usuario/listar',
		beforeSend: function (request) {
                var token = JSON.parse(localStorage.getItem('token')); //pega token salvo no localStorage
                if (token != null && token != undefined && token != '') {
                	request.setRequestHeader("token", token);
                }
            },
            processData: false,
            contentType: false, 
            error: function(e){
            	console.log('ola');
            	$('#tabUsuarios tbody').html('');
            	var tr = $('<tr>');
            	var td = $('<td>').attr('colspan', '5').html('Sem resultados de busca!').attr('align', 'center');
            	tr.append(td);
            	$('#tabUsuarios tbody').append(tr);
            }
        }).done(function (r) {
        	var usr = r.data;
        	console.log(usr);
        	$('#tabUsuarios tbody').html('');
        	for(var i = 0; i < usr.length; i++){
        		var tr = $('<tr>');
        		var tdUser = $('<td>').html(usr[i].usuario);
        		var tdEmail = $('<td>').html(usr[i].email);
        		var tdTipo = $('<td>').html(usr[i].descricao);
        		var btnAcao = '<a href="cad_usuario?id='+usr[i].id_usuario+'" class="btn btn-warning" style="width:20%;padding:8px"><i class="fa fa-pencil" aria-hidden="true"></i></a><button type="button" class="btn btn-danger btnExcluir" style="width:20%;padding:8px" data-id="'+usr[i].id_usuario+'" data-desc="'+usr[i].usuario+'"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
        		var tdAcao = $('<td>').html(btnAcao).css('textAlign', 'center');
        		tr.append(tdUser);
        		tr.append(tdEmail);
        		tr.append(tdTipo);
        		tr.append(tdAcao);

        		$('#tabUsuarios tbody').append(tr);
        	}
        });
    }
    $("#formUsuario").submit(function (e) {
    	if ($('#formUsuario').valid()) {
    		var formdata = new FormData($("#formUsuario")[0]);
    		$.ajax({
    			type: 'POST',
    			url: '../api/usuario/inserir',
    			data: formdata,
    			error:function(e){
    				alert(e.message);
    			},
    			beforeSend: function (request) {
                var token = JSON.parse(localStorage.getItem('token')); //pega token salvo no localStorage
                if (token != null && token != undefined && token != '') {
                	request.setRequestHeader("token", token);
                }
            },
            processData: false,
            contentType: false
        }).done(function (r) {
        	alert(r.message);
        	window.location.href = 'usuarios';

        });
        e.preventDefault();
    }
    
});
    function buscarUsuario(id){
    	console.log(id);
    	$.ajax({
    		method: "POST",
    		url: "../api/usuario/buscar",
    		data: { id: id},
    		beforeSend: function (request) {
                var token = JSON.parse(localStorage.getItem('token')); //pega token salvo no localStorage
                if (token != null && token != undefined && token != '') {
                	request.setRequestHeader("token", token);
                }
    	}})
    	.done(function( msg ) {
    		var usr = msg.data;
    		console.log('ola');
    		$("[name='nome']").val(usr[0].nome);
    		$("[name='data_nasc']").val(usr[0].data_nasc);
    		$("[name='rg']").val(usr[0].rg);
    		$("[name='cpf']").val(usr[0].cpf);
    		$("[name='cep']").val(usr[0].cep);
    		$("[name='endereco']").val(usr[0].endereco);
    		$("[name='complemento']").val(usr[0].complemento);
    		$("[name='bairro']").val(usr[0].bairro);
    		$("[name='cidade']").val(usr[0].cidade);
    		if(usr[0].uf != null && usr[0].uf != undefined){
    			$("[name='uf']").val(usr[0].uf);
    		}

    		$("[name='email']").val(usr[0].email);
    		$("[name='usuario']").val(usr[0].usuario);
    		$("[name='tipo_usuario']").val(usr[0].id_tipo_usuario);


    	});
    }
    $(document.body).on("click", ".btnExcluir", function (ev) {

    	$('#tituloModal').html('<i class="fa fa-exclamation-triangle" aria-hidden="true" style="color:yellow"></i> Aviso');
    	$('#corpoModal').html('Deseja realmente remover o usuário '+$(this).attr('data-desc')+'?');
    	$('#rodapeModal').html('<button type="button" class="btn btn-outline-warning waves-effect" data-dismiss="modal">Sair</button><button type="button" class="btn btn-warning confirmarExc" data-id="'+$(this).attr('data-id')+'">Remover</button>');
    	$('#modalPadrao').modal('show');

    });
    $(document.body).on("click", ".confirmarExc", function (ev) {
    	$.ajax({
    		method: "POST",
    		url: "../api/usuario/deletar",
    		data: { id: $(this).attr('data-id')}
    	}).done(function (r) {
    		$('#modalPadrao').modal('hide');
    		alert(r.message);
    		listarUsuarios();
    	}).fail(function (r) {
    		$('#modalPadrao').modal('hide');
    		alert(r.message);
    	});
    });