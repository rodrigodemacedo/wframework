/**
 * Classe que valida dados de um determinado formulário
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @version 1.0 <2010-04-18>
 * @param string strFormName Nome do formulário que contém os dados a serem validados 
 */
function jRulesValidator(strFormName, strCssClassToMark){
	
	//
	// ATTRIBUTES
	//
	
	/**
	 * Nome do formulário onde os campos serão validados
	 * 
	 * @author Rodrigo
	 * @since 1.0
	 * @type string
	 * @var strForm
	 */
	this.strForm = strFormName;
	
	/**
	 * True ou false para indicar se algum campo não obedeceu a validação imposta
	 * 
	 * @author Rodrigo
	 * @since 1.0
	 * @type boolean
	 * @var bolHasError
	 */
	this.bolHasError = false;
	
	/**
	 * Guarda as informações dos campos que não obedeceram a validação imposta
	 * 
	 * @author Rodrigo
	 * @since 1.0
	 * @type Array
	 * @var arrErrorsFound
	 */
	this.arrErrorsFound = new Array();
	
	/**
	 * Guarda as informações dos campos que não obedeceram a validação imposta
	 * 
	 * @author Rodrigo
	 * @since 1.0
	 * @type Object[]
	 * @var arrErrorsFound
	 */
	this.arrObjValidationTypes = new Array(
		{type: 'req', methodToCall:'validateRequired'},
		{type: 'mail', methodToCall:'validateMail'},
		{type: 'multipleSelect', methodToCall:'validateMultipleSelect'}/*,
		{type: 'cpf', methodToCall:'validateCpf'}*/
	);
	
	this.strCssClassToMark = strCssClassToMark;
	
	//
	// METHODS
	//
	
	/**
	 * Método que inicia a validação dos dados do formulário informado no construtor
	 * 
	 * @author Rodrigo
	 * @since 1.0
	 * @type string
	 * @return void
	 */
	this.init = function(){
		//retirar a marcacao dos campos
		if(this.strCssClassToMark != undefined){
			jQuery(this.strForm + " input, " + this.strForm + " select, " + this.strForm + " textarea").removeClass(this.strCssClassToMark);
		}
		
		//pegar todos os campos que devem ser validados
		var arrJqCampos = jQuery(".jRulesValidator");
		
		//iterá-los
		for (var k = 0 ; k < arrJqCampos.length ; k++){
			//pegar os tipos da validacao do campo em questao e converter em array
			var strTipos = arrJqCampos.eq(k).text();
			var arrTipos = strTipos.split('|');
			
			//iterar as validações do campo em questão
			for (var i = 0 ; i < arrTipos.length ; i++){
				for (var j = 0 ; j < this.arrObjValidationTypes.length ; j++){
					if(arrTipos[i] == this.arrObjValidationTypes[j].type){
						//chamar o metodo correspondente a validacao
						eval('this.' + this.arrObjValidationTypes[j].methodToCall + '(arrJqCampos.eq(k));');
					}
				}
			}
		}
		
		//verificar se houveram erros
		if(this.arrErrorsFound.length != 0){
			//definir o booleano de indicacao de erro para true
			this.bolHasError = true;
		}
	}
	
	/**
	 * Faz a exibição dos erros encontrados, podendo se fornecer uma classe css para marcar os campos invalidos
	 * 
	 * @author Rodrigo
	 * @since 1.0
	 * @type string
	 * @return void
	 */
	this.showErrors = function(){
		//mensagem
		var strErro = 'Foram encontrados alguns erros que devem ser corrigidos:\n\n';
		for ( var i = 0; i < this.arrErrorsFound.length; i++) {
			if(strCssClassToMark != undefined){
				jQuery('#' + this.arrErrorsFound[i].id).addClass(strCssClassToMark);
			}
			
			strErro += this.arrErrorsFound[i].errorMsg + '\n';
		}
		
		return strErro;
	}
	
	/**
	 * Adiciona mais um registro de erro na lista. Na mensagem de erro, insira um [?] para 
	 * inserir o strLabel do campo, exemplo: 'Erro, o campo [?] precisa ser preenchido'
	 * 
	 * 
	 * @author Rodrigo
	 * @since 1.0
	 * @type string
	 * @return void
	 */
	this.addError = function(strId, strLabel, strErrorMsg){
		//substituir o [?] pelo label na mensagem
		var i = -1;
		do{
			i = strErrorMsg.indexOf('[?]', ++i);
			strErrorMsg = strErrorMsg.replace('[?]',strLabel);
		}while(i >= 0);
		
		//adicionar ao array de erros
		this.arrErrorsFound.push({
			'id': strId,
			'label': strLabel,
			'errorMsg': strErrorMsg
		});
	}
	
	/**
	 * Adiciona mais um registro de erro na lista por meio do objeto ".jRulesValidator".
	 * 
	 * @author Rodrigo
	 * @since 1.0
	 * @type string
	 * @return void
	 */
	this.addErrorFromObj = function(jObject, strErrorMsg){
		//Adiciona mais um registro de erro na lista
		this.addError(jObject.next().attr('id'), jObject.attr('title'), strErrorMsg);
	}
	
	/**
	 * Informa se o campo tem uma certa validação, ou seja, ao se forncer 'req', por exemplo,
	 * a função retorna true ou false caso ela o tenha.
	 * 
	 * @author Rodrigo
	 * @since 1.0
	 * @type string
	 * @return boolean
	 */
	this.hasValidation = function(strValidation, jObject){
		return jObject.text().indexOf(strValidation) >= 0;
	}
	
	//
	// VALIDATIONS
	//
	
	/**
	 * Valida os campos obrigatórios.
	 * 
	 * @author Rodrigo
	 * @since 1.0
	 * @type string
	 */
	this.validateRequired = function(jObject){//verificar se o campo está vazio
		//pegar o elemento que detém o valor a ser testado
		var objJqInput = jObject.next();
		
		switch (objJqInput.attr('tagName').toLowerCase()) {
			case 'input':
			case 'textarea':
				if(objJqInput.val() == ""){
					//adicionar o campo ao array de erros encontrados
					this.addErrorFromObj(jObject,'O campo [?] está vazio.');
				}
			break;
			
			case 'select':
				//verificar se é select múltiplo ou simples
				if(objJqInput.attr('multiple')){
					if(objJqInput.children('option').length == 0){
						this.addErrorFromObj(jObject,'O campo [?] está vazio.');
					}
					
				}else{
					if((objJqInput.val() == null) || (objJqInput.val() == "")){
						//adicionar o campo ao array de erros encontrados
						this.addErrorFromObj(jObject,'Não foi selecionado nenhum ítem no campo [?].');
					}
				}
				
			break;
		}
	}
	
	/**
	 * Valida os campos do tipo e-mail.
	 * 
	 * @author Rodrigo
	 * @since 1.0
	 * @type string
	 */
	this.validateMail = function(jObject){
		var bolValidate = true;
		var strMail = jObject.next().val();
		if((!this.hasValidation('req',jObject)) && (strMail == '')){
			bolValidate = false;
		}
		
		if(bolValidate){
			var strPattern = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
			if(((typeof(strMail) == "string") || (typeof(strMail) == "object")) && (strPattern.test(strMail))){
				//
			}else{
				this.addErrorFromObj(jObject,'O campo [?] é inválido. Exemplo de e-mail válido: example@server.com');
			}
		}
	
	}
	
	/**
	 * Valida os campos do tipo e-mail.
	 * 
	 * @author Thiago Jordao
	 * @since 1.0
	 * @type string
	 */
	this.validateMultipleSelect = function(jObject){
		var rel = jObject.attr('rel');
		eval('var objRel = ' + rel + ';');
		
		var bolValidate = false;
		
		if(objRel.tipo = 'checkbox1'){
			jQuery("input[classe='" + objRel.classe + "']:checked").each(function(){
				bolValidate = true;
			});
		}
		
		if(! bolValidate){
			this.addErrorFromObj(jObject,'Você precisa selecionar pelo menos um valor no campo [?].');
		}
	}
	
	
	/*
	this.validateCpf = function(jObject){
		var strCpf = jObject.next().val();
		var strFiltro = /^\d{3}.\d{3}.\d{3}-\d{2}$/i;
		
		//testar a máscara
		if(!strFiltro.test(strCpf)){
			this.addErrorFromObj(jObject,'O campo [?] está inválido. O formato é 123.456.789-00');
			return false;
		}
		
		//retirar a pontuação da máscara
		strCpf = strCpf.replace('.','').replace('.','').replace('.','').replace('-','');
		 
		if(strCpf.length != 11 || strCpf == "00000000000" || strCpf == "11111111111" ||
			strCpf == "22222222222" || strCpf == "33333333333" || strCpf == "44444444444" ||
			strCpf == "55555555555" || strCpf == "66666666666" || strCpf == "77777777777" ||
			strCpf == "88888888888" || strCpf == "99999999999"){
			
			this.addErrorFromObj(jObject,'O campo [?] está inválido. O formato é 123.456.789-00');
			return false
		}
		
		soma = 0;
		for(i = 0; i < 9; i++){
			soma += parseInt(strCpf.charAt(i)) * (10 - i);
		}
		
		resto = 11 - (soma % 11);
		if(resto == 10 || resto == 11){
			resto = 0;
		}
		
		if(resto != parseInt(strCpf.charAt(9))){
			this.addErrorFromObj(jObject,'O campo [?] está inválido. O formato é 123.456.789-00');
			return false;
		}
		
		soma = 0;
		for(i = 0; i < 10; i ++){
			soma += parseInt(strCpf.charAt(i)) * (11 - i);
			return false;
		}
		
		resto = 11 - (soma % 11);
		if(resto == 10 || resto == 11){
			resto = 0;
		}
		
		if(resto != parseInt(strCpf.charAt(10))){
			this.addErrorFromObj(jObject,'O campo [?] está inválido. O formato é 123.456.789-00');
			return false;
		}
	}
	*/
}