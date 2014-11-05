var ff_larguraTotal = 0;
var ff_margensEntreCampos = 10;
var ff_elmtLinha = '.linha';
var ff_elmtCampo = '.campo';
var ff_elmtCampoVariavel = '.tamanhox';
var ff_elmtCampoInput = 'input';
var ff_conversaoPxLetra = '8'; // cada letra tem 8px de largura

jQuery(function($){
	ff_larguraTotal = $(ff_elmtLinha).eq(0).innerWidth();
	FastForm_alinhamentoDeLinhas();
});

function FastForm_alinhamentoDeLinhas(){
	var arrTamanhoDosElementosNaLinha = new Array();
	$(ff_elmtLinha).each(function(intLinha){
		jCampos = $(this).find(ff_elmtCampo);
		
		//
		// PROCESSAR OS CAMPOS COM TAMANHO FIXO
		//
		
		var intSomaElementos = 0;
		jCampos.each(function(){
			arrClasses = $(this).attr('class').split(' ');
			var intTamanhoReal;
			var intHasIcon17 = 0;
			
			var arrClassCamposInput = $(this).find('input[type=text]').attr('class');
			if(arrClassCamposInput != undefined){
				arrClassCamposInput = arrClassCamposInput.split(' ');
			}else{
				arrClassCamposInput = new Array();
			}
			
			for(var y = 0 ; y < arrClassCamposInput.length ; y++){
				if(arrClassCamposInput[y].substr(0,6) == 'campo_'){
					intHasIcon17 = 0;
					break;
				}
			}
			
			for(var x = 0 ; x < arrClasses.length ; x++){
				if(arrClasses[x] == 'tamanhox'){
					continue;
				}
				
				if(arrClasses[x].substr(0,7) == 'tamanho'){
					intTamanho = parseInt(arrClasses[x].substr(7));
					intTamanhoReal = intTamanho * ff_conversaoPxLetra - intHasIcon17;
					
					//intChecaTamanhoReal += intTamanhoReal;
					if($(this).find('input[type=text]').length != 0){
						$(this).find('input[type=text]:not(.nofastform)').css('width',intTamanhoReal);
						$(this).css('width',intTamanhoReal+10);
						intSomaElementos += intTamanhoReal+10;
					}else{
						$(this).find('select:not(.nofastform)').css('width',intTamanhoReal+30);
						$(this).css('width',intTamanhoReal+35);
						intSomaElementos += intTamanhoReal+35;
					}
					
					
					
					//console.log(intTamanho);
				}
			}
			
		});
		arrTamanhoDosElementosNaLinha[intLinha] = intSomaElementos;
		
	});
	
	//
	// PROCESSAR OS CAMPOS COM TAMANHO VARIÁVEL
	//
	
	for(var intLinha = 0 ; intLinha < $(ff_elmtLinha).length ; intLinha++){
		var jLinha = $(ff_elmtLinha).eq(intLinha);
		for(var intCampo = 0 ; intCampo < jLinha.find(ff_elmtCampo).length ; intCampo++){
			var jAreaCampo = jLinha.find(ff_elmtCampo).eq(intCampo);
			
			arrClasses = jAreaCampo.attr('class').split(' ');
			for(var x = 0 ; x < arrClasses.length ; x++){
				if((arrClasses[x] != 'tamanhox') || (arrClasses[x] == 'nofastform')){
					continue;
				}
				intTamanhoReal = ff_larguraTotal - arrTamanhoDosElementosNaLinha[intLinha];
				
				jAreaCampo.find('input[type=text], select').css('width',intTamanhoReal - 20);
				jAreaCampo.css('width',intTamanhoReal -10);
			}
		}
		
	}
}

function FastForm_setTamanho(){
	
}