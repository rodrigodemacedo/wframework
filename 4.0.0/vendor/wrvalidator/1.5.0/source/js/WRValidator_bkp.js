jQuery(function($){
	
	//
	// ENVIO AUTOMÁTICO DE FORMULÁRIOS EM AJAX
	//
	
	$(".wrv_ajax_submit").submit(function(){
		var jForm = $(this);
		//
		// EXECUTAR AUTOMATICAMENTE UMA FUNÇÃO ANTES DO SUBMIT DO FORM
		//
		
		if((jForm.find('#wrv_fn_before_submit').length != 0) && (jForm.find('#wrv_fn_before_submit').val() != '')){
			var strFnBefore = $("#wrv_fn_before_submit", jForm).val();
			var res = /([a-zA-Z0-9\_]+)\(/.exec(strFnBefore);
			
			if((res != null) && (typeof eval(res[1]) == 'function')){
				eval('strFnBeforeReturn = '+strFnBefore+';');
				console.log(strFnBeforeReturn);
				if(!strFnBeforeReturn)
					return false;
			}else{
				console.log('Função before submit não existe: '+res[1]);
				return false;
			}
		}
		
		
		
		//
		// VALIDAÇÕES
		//
		
		
		
		//campos obrigatórios
		$(".wrv_required", jForm).parent().parent().removeClass('has-error').find('span.msg').html('&nbsp;');
		var bolRequiredError = false;
		$(".wrv_required").each(function(){
			
			if($(this).val() == ''){
				$(this).parent().parent().addClass('has-error').find('span.msg').text('Campo obrigatório');
				bolRequiredError = true;
			}
		});
		if(bolRequiredError) return false;
		
		
		
		//campos de data
		var bolDateError = false;
		$(".wrv_calendar").each(function(){
			
			if($(this).val() == ''){
				$(this).parent().parent().addClass('has-error').find('span.msg').text('Campo obrigatório');
				bolDateError = true;
			}
		});
		if(bolDateError) return false;
		
		
		
		
		
		
		//
		// ENVIO DO FORM
		//
		
		
		console.log($(this).prop('action'));
		
		
		
		return false;
	});
});