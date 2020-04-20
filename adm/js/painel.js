$(document).ready(function(){
	var tk = JSON.parse(localStorage.getItem('token'));

	if(tk){
		var tipo = JSON.parse(localStorage.getItem('tipo'));
		if(tipo == 1){

		}else{
			$('.super').addClass('hide');
		}
	}else{
		
		window.location.href = 'error.html';
	}
});
function sair(){
	localStorage.clear();
	window.location.href = 'login';
}