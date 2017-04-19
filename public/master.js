// Funcion para dar formato a un numero
	function formato_numero(numero, decimales, separador_decimal, separador_miles){
		numero = parseFloat(numero);
		if(isNaN(numero)) return "";
		if(decimales!==undefined) numero=numero.toFixed(decimales);
		numero = numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ",");
		if(separador_miles) {
			var miles=new RegExp("(-?[0-9]+)([0-9]{3})");
			while(miles.test(numero)) {
				numero=numero.replace(miles, "$1" + separador_miles + "$2");
			}
		}
		return numero;
	}
$(document).ready(function(){
// Configuracion de los parametros del datepicker
	$.datepicker.regional['es'] = {
		changeMonth: true,
		changeYear: true,
		closeText: 'Cerrar', 
		prevText: 'Anterior', 
		nextText: 'Siguiente',
		currentText: 'Hoy',
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthNamesShort: ['Ene', 'Feb',' Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
	    monthStatus: 'Ver otro mes',
		yearStatus: 'Ver otro año',
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb'],
		dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
		dateFormat: 'd-MM-yy',
		firstDay: 0,
		initStatus: 'Selecciona la fecha', isRTL: false
	};
	$.datepicker.setDefaults($.datepicker.regional['es']);
	$( ".date-picker" ).datepicker({});
});