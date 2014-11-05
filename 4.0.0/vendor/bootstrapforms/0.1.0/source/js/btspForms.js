
function WRBootstrapForms(){
	
	
	
	this.listOptionsRemove = function(strUrl, strRegisterName, intRegisterId){
		
		bootbox.dialog({
			message: "Tem certeza que deseja realmente remover o item \"" + strRegisterName+"\"?",
			title: "Remoção",
			buttons: {
				success: {
					label: "Sim, tenho certeza",
					className: "btn-danger",
					callback: function() {
						console.log('remover');
					}
				},
				danger: {
					label: "Não, cancelar",
					className: "btn-default",
					callback: function() {
						console.log('cancelar');
					}
				}
			}
		});
		
	};
	
	this.alert = function(strTitle, strMessage, strBtnLabel, strIcon){
		
		if(strBtnLabel == undefined)
			strBtnLabel = '<i class="glyphicon glyphicon-ok"></i> OK';
		
		if((typeof strMessage != 'string'))
			strMessage = '.';
		
		//console.log(strMessage);
		bootbox.dialog({
			message: this.getMessageBody(strMessage, strIcon),
			title: strTitle,
			buttons: {
				success: {
					label: strBtnLabel,
					className: "btn-primary",
				}
			}
		});
	};
	
	this.cadastro = function(strTitle, strMessage, strGoTo, jForm){
		bootbox.dialog({
			message: this.getMessageBody(strMessage, 'ok-sign'),
			title: strTitle,
			buttons: {
				cancel: {
					label: '<i class="glyphicon glyphicon-plus-sign"></i> Cadastrar mais um...',
					className: "btn-primary",
					callback: function(){
						jForm[0].reset();
					}
				},
				success: {
					label: '<i class="glyphicon glyphicon-arrow-left"></i> OK',
					className: "btn-primary",
					callback: function() {
						window.location = strGoTo;
					}
				},
			}
		});
	};
	
	this.edicao = function(strTitle, strMessage, strGoTo, jForm){
		bootbox.dialog({
			message: this.getMessageBody(strMessage, 'ok-sign'),
			title: strTitle,
			buttons: {
				success: {
					label: '<i class="glyphicon glyphicon-arrow-left"></i> OK',
					className: "btn-primary",
					callback: function() {
						window.location = strGoTo;
					}
				},
			}
		});
	};
	
	
	this.getMessageBody = function(strMessage, strIcon){
		if(strIcon == undefined)
			strIcon = 'info-sign';
		
		return '<div class="glyphicon glyphicon-'+strIcon+'" style="color: #BBB; font-size: 50px; float: left; width: 70px; cursor: default"></div><div class="btsMessage" style="float: left; width: 470px">'+strMessage+'</div><div style="clear: both"></div>';
	};
}

var objWRBootstrapForms = new WRBootstrapForms();