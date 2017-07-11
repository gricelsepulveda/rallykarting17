$(function() 
{
	// Datepicker en español
	 $.datepicker.regional['es'] = {
		 closeText: 'Cerrar',
		 prevText: '<Ant',
		 nextText: 'Sig>',
		 currentText: 'Hoy',
		 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
		 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
		 weekHeader: 'Sm',
		 dateFormat: 'dd/mm/yy',
		 firstDay: 1,
		 isRTL: false,
		 showMonthAfterYear: false,
		 yearSuffix: ''
		 };
	 $.datepicker.setDefaults($.datepicker.regional['es']);

	// Unifico los menus para vista responsive 
    var uls = $('.sidebar-nav > ul > *').clone();
    uls.addClass('visible-xs');
    $('#main-menu').append(uls.clone());

    // Mensajes de validator
	jQuery.extend(jQuery.validator.messages, 
	{
	    required: "Este campo es requerido.",    
	    email: "Ingrese un correo válido.",
	    minlength: "Ingrese al menos {0} caracteres"    
	});

	// Formulario de Login
	$("#frmLogin").validate();
	// Formulario de recuperación de clave
	$("#frmClave").validate();

	// Paso una variable a la ventana modal
	$(document).on("click", ".triger-modal", function () 
	{
		var id = $(this).data('id');	
		var target = $(this).attr('href');		
		var url = $(target+" .triger-action-modal").attr('href');
		$(target+" .triger-action-modal").attr('href',url+id);
	});
	// Lightbox
	$(".fancybox").fancybox();	

	/********************** ACCESOS *******************************************/

	$("#frmAgregarAcceso").validate({});
	$("#frmEditarAcceso").validate({});

	// Si hace click en Administrador desactivo permisos por menu
	$("#frmAgregarAcceso input[name='administrador']").click(function()
	{
		$("#frmAgregarAcceso input[name='menu[]']").attr('disabled',$(this).is(':checked'));
		if ($(this).is(':checked'))
		{
			 $("#frmAgregarAcceso input[name='menu[]']").removeAttr('checked');
		}
	})

	$("#frmEditarAcceso input[name='administrador']").click(function()
	{
		$("#frmEditarAcceso input[name='menu[]']").attr('disabled',$(this).is(':checked'));
		if ($(this).is(':checked'))
		{
			 $("#frmEditarAcceso input[name='menu[]']").removeAttr('checked');
		}
	})

	// Selecciono texto al click
	$(".select-all").click(function(){
		$(this).select();
	});
	// Medidor de clave
	 $('#clave').pwstrength();

	 $.validator.addMethod("rut", function(value, element) {
  		return this.optional(element) || $.Rut.validar(value);
		}, "Este campo debe ser un rut valido.");	 
              

	/********************** CONFIGURACIONES *******************************************/

	$("#frmEditarConf").validate({});

	
	/********************** USUARIOS *******************************************/
	
	$("#frmAgregarUsuario").validate({});
	$("#frmEditarUsuario").validate({});

	/***************************** CONTROLADORES **********************************************/
	
	$("#frmAgregarControlador select").chosen();
	$("#frmEditarControlador select").chosen();
	$("#frmAgregarControlador").validate({});
	$("#frmEditarControlador").validate({});
	
	


});