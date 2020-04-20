$(document).ready(function(){
    var tk = JSON.parse(localStorage.getItem('token'));
    if(tk){
        window.location.href = 'painel';
    }else{
        $("#formLogin").validate({
        rules: {
            user: {
                required: true
            },
            password: {
                required: true
            }
        },
        messages: {
            user: {
                required: '<label style="color: red" class="small">Por favor, informe o nome de usuário.</label>'
            },
            password: {
                required: '<label style="color: red" class="small">Por favor, informe a senha.</label>'
            }
        }
    });
    }

});

$("#formLogin").submit(function (e) {
	if ($('#formLogin').valid()) {
		var formdata = new FormData($("#formLogin")[0]);
		$.ajax({
			type: 'POST',
			url: '../api/usuario/logar',
			data: formdata,
            processData: false,
            contentType: false,
            error: function(e){

            }
        }).done(function (r) {
            localStorage.setItem('token', JSON.stringify(r.token));
            localStorage.setItem('tipo', JSON.stringify(r.tipo_usuario));
            window.location.href = 'painel';

        });
        e.preventDefault();
    }
});