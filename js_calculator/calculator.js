$(document).ready(function() {
	

	var calculator = function(){

		var clicked = '';
		var parts = [];

		this.init = function(){
			$("span.button").bind('click', handlerOperation);
		}

		var handlerOperation = function(event){
			clicked = $(event.target).attr('data-id');
			//If press C, clear input
			//If press other keys, populate data in input
			//If pressed =, perform calculation
			switch(clicked){

				case 'C':
					clearCalcInput();
					break;

				case '=':
					parseOperators();
					break;

				default:
					populateCalcInput();

			}
		}

		var parseOperators = function(){
			parts = [];
			var currentVal = $("#calcInput").val();
			
			var operators = ['\\+','\\-','\\x','\\/'];
			var additionParts = currentVal.split(new RegExp(operators.join('|'),'g'));
			alert(additionParts);
			
			for(var i=0, p=0; i<currentVal.length; i++){

				if(parts[p] == undefined){
					parts[p] = [];
				}

				if(currentVal[i] == 'x' || currentVal[i] == '+' || currentVal[i] == '-' || currentVal[i] == '/'){
					parts[++p] = currentVal[i];
					p++;
				}
				else{
					parts[p] = parts[p] + currentVal[i];
				}
			}

			//If parts is not empty, then proceed
			if(parts!=undefined) {
				var finalValue = performMulDivOperation();
				finalValue = performAddSubOperation();
				$("#calcInput").val(finalValue);
			}
			
		}

		var performMulDivOperation = function(){
			var finalValue = 0;
			if(parts!=undefined){
				if($.inArray('x',parts)==1 || $.inArray('/',parts)==1 ){
					//alert(parts);
					var newParts = parts;
					var skipAdd=0;
					for(p=0, m=0; p<parts.length; p++){
						calculatedValue = -1;
						switch(parts[p]){
							case 'x':
								calculatedValue = parseInt(parts[p-1]) * parseInt(parts[p+1]);
								break;
							case '/':
								calculatedValue = parseInt(parts[p-1]) / parseInt(parts[p+1]);
								break;
						}

						if(calculatedValue!=-1){
							break;
						}
					}

					if(calculatedValue!=undefined){

						newParts.shift();
						newParts.shift();
						newParts.shift();

						newParts.unshift(calculatedValue);

						parts = newParts;
						return performMulDivOperation();
					}
				}
				else{
					finalValue = parts;
				}
			}

			return finalValue;
		}

		var performAddSubOperation = function(){
			var finalValue = 0;
			if(parts!=undefined){
				if($.inArray('+',parts)==1 || $.inArray('-',parts)==1){
					//alert(parts);
					var newParts = parts;
					var skipAdd=0;
					for(p=0, m=0; p<parts.length; p++){
						calculatedValue = -1;
						switch(parts[p]){
							case '+':
								calculatedValue = parseInt(parts[p-1]) + parseInt(parts[p+1]);
								break;
							case '-':
								calculatedValue = parseInt(parts[p-1]) - parseInt(parts[p+1]);
								break;
						}

						if(calculatedValue!=-1){
							break;
						}
					}

					if(calculatedValue!=undefined){

						newParts.shift();
						newParts.shift();
						newParts.shift();

						newParts.unshift(calculatedValue);

						parts = newParts;
						return performAddSubOperation();
					}
				}
				else{
					finalValue = parts;
				}
			}

			return finalValue;
		}

		//Clear Input when pressed 'Cancel' key
		var clearCalcInput = function(){
			$("#calcInput").val('');
			parts = [];
		}


		var populateCalcInput = function(){
			if(clicked != undefined){
				var currentVal = $("#calcInput").val();
				var newVal = currentVal + clicked;
				$("#calcInput").val(newVal);
			}
		}
	};

	var calc = new calculator();
	calc.init();

});
