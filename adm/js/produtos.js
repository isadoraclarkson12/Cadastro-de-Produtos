$(document).ready(function(){
	listarProdutos();
    $("[name='valor']").maskMoney();
	var id = postUrl();
	if(id != null){
		buscarProduto(id);
		$("[name='prod']").val(id);
		$("[name='status']").val(1);
	}
	$("[name='teste']").ColorPicker({flat: false, });
	$("#formCadProd").validate({
		rules: {
			descricao: {
				required: true
			},
			valor: {
				required: true
			},
			variacaoCor: {
				required: true
			}
		},
		messages: {
			descricao: {
				required: '<label style="color: red" class="small">Por favor, informe a descrição do produto.</label>'
			},
			valor: {
				required: '<label style="color: red" class="small">Por favor, informe o valor do produto.</label>'
			},
			variacaoCor: {
				required: '<label style="color: red" class="small">Por favor, informe se existe ou não variação de cor do produto.</label>'
			}
		}
	});
});

function postUrl() {
    var url_string = window.location.href;
    var url = new URL(url_string);
    var id = url.searchParams.get("id");
    return id;
}

$("#formCadProd").submit(function (e) {
	if ($('#formCadProd').valid()) {
		var formdata = new FormData($("#formCadProd")[0]);
		$.ajax({
			type: 'POST',
			url: '../api/produtos/inserir',
			data: formdata,
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
            window.location.href = 'produtos';

        }).fail(function () {
        	alert('Erro ao salvar produto no banco de dados!');
        });
        e.preventDefault();
    }
});
$("[name='variacaoCor']").change(function(){
	if($("[name='variacaoCor']").val() == 1){
		$('.svariacao').removeClass('hide');
		$('.cvariacao').addClass('hide');
	}else if($("[name='variacaoCor']").val() == 2){
		$('.cvariacao').removeClass('hide');
		$('.svariacao').addClass('hide');
	}else{
		$('.svariacao').addClass('hide');
		$('.cvariacao').addClass('hide');
	}
});
function buscarProduto(id){
	$.ajax({
  method: "POST",
  url: "../api/produtos/buscar",
  data: { id: id}
})
  .done(function( msg ) {
    var prod = msg.data;

    $("[name='descricao']").val(prod[0].descricao);
    var valor = parseFloat(prod[0].valor).toFixed(2);
    valor = valor.toString().replace('.', ',');
    $("[name='valor']").val(valor);
    if(prod[0].variacao_cor == 'S'){
    	$("[name='variacaoCor']").val(2);
    	var cores = prod[0].cores;
    	$('.cvariacao').removeClass('hide');
    	$("[name='color[]']").each(
         function(){
           for(var i = 0; i < cores.length; i++){
           	if(cores[i].descricao == $(this).val()){
           		$(this).attr("checked", true);
           	}
           }               
         }
    );
    }else{
    	$("[name='variacaoCor']").val(1);
    	$('.svariacao').removeClass('hide');
    	$("[name='wcolor[]']").each(
         function(){
           
           	if(prod[0].cor == $(this).val()){
           		$(this).attr("checked", true);
           	}
                        
         }
    );
    }
  });
}
function listarProdutos(){
	$.ajax({
		type: 'POST',
		url: '../api/produtos/listar',
		beforeSend: function (request) {
                var token = JSON.parse(localStorage.getItem('token')); //pega token salvo no localStorage
                if (token != null && token != undefined && token != '') {
                	request.setRequestHeader("token", token);
                }
            },
            processData: false,
            contentType: false
        }).done(function (r) {
        	var prod = r.data;
        	$('#tabProdutos tbody').html('');
        	for(var i = 0; i < prod.length; i++){
        		var tr = $('<tr>');
        		var tdDesc = $('<td>').html(prod[i].descricao);
        		var valor = parseFloat(prod[i].valor).toFixed(2);
        		valor = valor.toString().replace('.', ',');
        		var tdValor = $('<td>').html(valor);
        		if(prod[i].id_situacao == 1){
        			var tdSit = $('<td>').html('Ativo');
        		}else{
        			var tdSit = $('<td>').html('Inativo');
        		}
        		var btnAcao = '<a href="cad_produto?id='+prod[i].id_produto+'" class="btn btn-warning" style="width:20%;padding:8px"><i class="fa fa-pencil" aria-hidden="true"></i></a><button type="button" class="btn btn-danger btnExcluir" style="width:20%;padding:8px" data-id="'+prod[i].id_produto+'" data-desc="'+prod[i].descricao+'"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
        		var tdAcao = $('<td>').html(btnAcao).css('textAlign', 'center');
        		tr.append(tdDesc);
        		tr.append(tdValor);
        		tr.append(tdSit);
        		tr.append(tdAcao);

        		$('#tabProdutos tbody').append(tr);
        	}
        }).fail(function () {
        	$('#tabProdutos tbody').html('');
        	var tr = $('<tr>');
        	var td = $('<td>').attr('colspan', '5').html('Sem resultados de busca!').attr('align', 'center');
        	tr.append(td);
        	$('#tabProdutos tbody').append(tr);
        });
}
$(document.body).on("click", ".btnExcluir", function (ev) {
    
    $('#tituloModal').html('<i class="fa fa-exclamation-triangle" aria-hidden="true" style="color:yellow"></i> Aviso');
    $('#corpoModal').html('Deseja realmente remover o produto '+$(this).attr('data-desc')+'?');
$('#rodapeModal').html('<button type="button" class="btn btn-outline-warning waves-effect" data-dismiss="modal">Sair</button><button type="button" class="btn btn-warning confirmarExc" data-id="'+$(this).attr('data-id')+'">Remover</button>');
    $('#modalPadrao').modal('show');

});

$(document.body).on("click", ".confirmarExc", function (ev) {
    $.ajax({
  method: "POST",
  url: "../api/produtos/deletar",
  data: { id: $(this).attr('data-id')}
}).done(function (r) {
    $('#modalPadrao').modal('hide');
    alert(r.message);
    listarProdutos();
}).fail(function (r) {
    $('#modalPadrao').modal('hide');
    alert(r.message);
});
});
