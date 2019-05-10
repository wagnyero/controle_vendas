function showLoading(mensagem){
	(mensagem) ? mensagem : mensagem = 'Carregando...';
	$('div#ajaxLoading SPAN').text(mensagem);
	$('div#ajaxLoadingFundo').show();
	$('div#ajaxLoading').show();
	return false;
}

function hideLoading(mensagem){
	(mensagem) ? mensagem : mensagem = 'Carregando...';
	$('div#ajaxLoading SPAN').text(mensagem);
	$('div#ajaxLoadingFundo').hide();
	$('div#ajaxLoading').hide();
	return false;
}

function carregarAjax(caminho, tipo, divAlvo, form, sucesso) {
	if ((!sucesso) || (sucesso == '')){
		if ((divAlvo) || (divAlvo != '')){
			    sucesso = function(txt){
				$(divAlvo).html(txt);
			};
		} else {
			alert ("é necessário definir div alvo!");
			return false;
		}
	}
	
	$.ajax({
		type: tipo,
		url:  caminho,
		data: $(form).serialize(),
		//async: false,
		beforeSend: function(){
			
			showLoading();
			if($("div#modalContainer").is(':visible'))
				$("div#modalContainer").css("z-index",0);
			
		},
		complete: function(){
			if($("div#modalContainer").is(':visible'))
				$("div#modalContainer").css("z-index",9999);
			else	
				hideLoading();
		},
		success: sucesso
	});
	
	return $(divAlvo);
	
}

function showLoadingTela(){
	showLoading();
	if($("div#modalContainer").is(':visible'))
		$("div#modalContainer").css("z-index",0);
}

function hideLoadingTela(){
	if($("div#modalContainer").is(':visible'))
		$("div#modalContainer").css("z-index",9999);
	else	
		hideLoading();
}


function carregarAjaxModal(caminho, tipo, divAlvo, form, sucesso) {
	if ((!sucesso) || (sucesso == '')){
		if ((divAlvo) || (divAlvo != '')){
			    sucesso = function(txt){
				$(divAlvo).html(txt);
			};
		} else {
			alert ("é necessário definir div alvo!");
			return false;
		}
	}

	$.ajax({
		type: tipo,
		url:  caminho,
		data: $(form).serialize(),
		//async: false,
		beforeSend: function(){
			//showLoading();
			$('div#ajaxLoading').show();
			$("div#modalContainer").css("z-index",1);
		},
		complete: function(){
			$('div#ajaxLoading').hide();
			$("div#modalContainer").css("z-index",9999);
			//hideLoading();
		},
		success: sucesso
	});
	return $(divAlvo);
}