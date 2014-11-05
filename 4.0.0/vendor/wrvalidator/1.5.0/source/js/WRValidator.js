jQuery(function($){
	
	$('form input, form textarea, form select').blur(function(){
		//ao ajustar o campo obrigatório, a classe indicativa de erro é retirada
		if(($(this).val() != '') && ($(this).hasClass('wrv_required')))
			$(this).parent().parent().removeClass('has-error');
		
	});
	
	
    $('.wrv_calendar').datepicker({
    	language: "pt-BR",
        format: "dd/mm/yyyy",
        weekStart: 1,
        autoclose: true
    });
    /*
    $('.wrv_time').datetimepicker({
    	language: "pt-BR",
    	pickDate: false,
    	pickSeconds: false,
    	
    	
    	//format: "dd/mm/yyyy",
    	//weekStart: 1,
    	
    	//autoclose: true
    });
    
    $('.wrv_calendar_time').datetimepicker({
    	language: "pt-BR",
    	pickSeconds: false,
    	
    	
    	format: "dd/MM/yyyy",
    	//weekStart: 1,
    	
    	//autoclose: true
    });
    */
    $('.wrv_numeros').keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
	});
    
    
    
    
    
    
    
    
    
    
    
	//
	// ENVIO AUTOMÁTICO DE FORMULÁRIOS EM AJAX
	//
	
    
    
    
    
	$(".wrv_ajax_submit").submit(function(){
		var jForm = $(this);
		//
		// EXECUTAR AUTOMATICAMENTE UMA FUNÇÃO ANTES DO SUBMIT DO FORM
		//
		
		if((jForm.find('.wrv_fn_before_submit').length != 0) && (jForm.find('.wrv_fn_before_submit').val() != '')){
			var strFnBefore = $(".wrv_fn_before_submit", jForm).val();
			var res = /([a-zA-Z0-9\_]+)\(/.exec(strFnBefore);
			
			if((res != null) && (typeof eval(res[1]) == 'function')){
				eval('strFnBeforeReturn = '+strFnBefore+';');
				//console.log(strFnBeforeReturn);
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
		
		//console.log("Validating...");
		
		//campos obrigatórios
		$(".wrv_required", jForm).parent().parent().removeClass('has-error').find('span.msg').html('&nbsp;');
		var bolRequiredError = false;
		
		$(".wrv_required", jForm).each(function(){
			
			if($(this).val() == ''){
				$(this).parent().parent().addClass('has-error').find('span.msg').text('Campo obrigatório');
				bolRequiredError = true;
			}
		});
		if(bolRequiredError) return false;
		
		/*
		//campos de data
		$(".wrv_calendar").each(function(){
			$(this).rules( "add", {
				required: true,
				errorPlacement: function() {
					jElementRequired.parent().parent().find('span.msg').text("Data inválida");
				}
			});
		});
		*/
		
		
		//console.log("Sending...");
		
		
		//
		// ENVIO DO FORM
		//
		/*
		objParams = {};
		$('input, textarea, select', jForm).each(function(){
			
			if(($(this).attr('name') != undefined) && ($(this).attr('name') != '')){
				
				switch ($(this)[0].tagName) {
					case 'INPUT':
						switch ($(this).attr('type')) {
							case 'textarea':
							case 'radio':
								eval('objParams.'+$(this).attr('name')+' = $("input[name='+$(this).attr('name')+']:checked").val();');
								break;
								
							case 'checkbox':
								eval('var chb_tmp = $("input[name='+$(this).attr('name')+']:checked").val();');
								if(chb_tmp != undefined)
									eval('objParams.'+$(this).attr('name')+' = $("input[name='+$(this).attr('name')+']:checked").val();');
								else
									eval('objParams.'+$(this).attr('name')+' = false;');
								break;
								
							default:
								eval('objParams.'+$(this).attr('name')+' = $("[name='+$(this).attr('name')+']").val();');
						}
					break;

				default:
					eval('objParams.'+$(this).attr('name')+' = $("[name='+$(this).attr('name')+']").val();');
				}
			}
		});
		*/
		
		bsAlert('Aguarde...', 'info', $("#form_msg", jForm));
		var arrJCamposEnvio = $('input:not([type=radio]), input[type=radio]:checked, textarea, select', jForm);
		$.post(jForm.prop('action'),arrJCamposEnvio,function(objReturn){
			
			
			//
			// EXECUTAR AUTOMATICAMENTE UMA FUNÇÃO APÓS O SUBMIT DO FORM
			//
			
			if((jForm.find('.wrv_fn_after_submit').length != 0) && (jForm.find('.wrv_fn_after_submit').val() != '')){
				var strFnAfter = $(".wrv_fn_after_submit", jForm).val();
				var res = /([a-zA-Z0-9\_]+)\(/.exec(strFnAfter);
				//console.log(res);
				if((res != null) && (typeof eval(res[1]) == 'function')){
					strFnAfter = strFnAfter.replace(')', ', objReturn, jForm)');
					strFnAfter = strFnAfter.replace('(, ', '(');
					eval('strFnAfterReturn = '+strFnAfter+';');
					if(strFnAfterReturn == false)
						return false;
				}else{
					//console.log('Função after submit não existe: '+res[1]);
					return false;
				}
			}
			
			
			//
			// OPERAÇÕES PADRÃO
			//
			
			
			if((jForm.find('.wrv_fn_operation_type_add').length > 0) && (objReturn.intErrorCode == 0)){
				//operação padrão de cadastro
				objWRBootstrapForms.cadastro("Cadastro", objReturn.strMessage, jForm.find('.wrv_fn_operation_type_add').val(), jForm);
				
			}else if((jForm.find('.wrv_fn_operation_type_edit').length > 0) && (objReturn.intErrorCode == 0)){
					//operação padrão de cadastro
					objWRBootstrapForms.edicao("Alteração de dados", objReturn.strMessage, jForm.find('.wrv_fn_operation_type_edit').val(), jForm);
			
			}else{
				var strTypeMessage = 'success';
				if(objReturn.intErrorCode != 0)
					strTypeMessage = 'danger';
				
				if((objReturn.intErrorCode != 0) && ((objReturn.semAlert == undefined) || (objReturn.semAlert == false)))
					objWRBootstrapForms.alert("Atenção", objReturn.strMessage);
			}
			
			
			
		}, 'json');
		
		
		
		return false;
	});
});


function bsAlert(strMessage, strType, jForm){
	var strAlert = '';
	strAlert += '<div class="alert alert-'+strType+' alert-dismissable">';
	strAlert += '	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
	strAlert += "	" + strMessage + "\n";
	strAlert += '</div>';
	
	$("div.form_message", jForm).html(strAlert);
}