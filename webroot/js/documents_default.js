/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
	$('.date').datepicker({
		dateFormat:'yy-mm-dd',
		dayNames:['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
		dayNamesMin:['Do','Lu','Mar','Mier','Jue','Vie','Sab'],
		firstDay:1,
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		//monthNamesShort:['Ene','Feb','Mar','Abr','May','Jun','Jul','Agos','Sep','Oct','Nov','Dic'],
		monthNamesShort:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		nextText:'Siguiente',
		prevText:'Atras',
		closeText:'Aceptar',
		currentText:'Fecha Actual',

		changeMonth:true,
		changeYear:true,
		yearRange: 'c-50:c+10',
		yearSuffix:'<br />Selector de Fecha'	   
	});
	
});