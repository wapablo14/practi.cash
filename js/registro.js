$(document).ready(function(){
	
	jQuery.validator.addMethod("nombre", function(value, element) {
        return this.optional(element) || /^[a-záéóóúàèìòùäëïöüñ\s]+$/i.test(value);
	});  

    // Validar el campo nombre.
	jQuery.validator.addMethod("apellido", function(value, element) {
        return this.optional(element) || /^[a-záéóóúàèìòùäëïöüñ\s]+$/i.test(value);
	});     

	//Validar el formulario.
    $("#btnRegistro").click(function(){
		
		var formulario = $("#formulario").validate
		({
			rules: /* Accedemos a los campos.*/
			{
				numero: {required: true, digits: true, minlength: 5, maxlength: 15},
				nombre: {required: true,  nombre: true },
				apellido: {required: true, apellido: true},
			},
			messages:
             {
				numero : {required: 'Este campo es obligatorio', digits:'Ingrese solo numeros', minlength: 'El mínimo permitido son 5 caracteres', maxlength: 'El máximo permitido son 15 caracteres' },
				nombre : {required: 'Este campo es obligatorio', nombre:'Ingrese su Nombre'},
				apellido : {required: 'Este campo es obligatorio', apellido:'Ingrese su Apellido'},
             },
			 
			submitHandler: function(form){
				
				var numero=$("#numero").val();
				var name=$("#name").val();
				var fullname=$("#fullname").val();
				var password=$("#password").val();
				localStorage.setItem("numResult", numero);
				var dataString="numero="+numero+"&name="+name+"&fullname="+fullname+"&password="+password+"&update=";
				if($.trim(numero).length>0){
					if($('#switch').is(':checked')){
					$.ajax({
					type: "POST",
					url:"https://paulina96madrid.000webhostapp.com/datosPrueba/update.php",
					data: dataString,
					crossDomain: true,
					cache: false,
					beforeSend: function(){ $("#insert").val('Connecting...');},
					success: function(data){
						if(data=="success"){
						alert("Registro actualizado.");
						window.location.href = "tarjetas.html";
						}
						else if(data=="error"){
						alert("Error de registro.");
						}
					}
					});
				}
				else{
					$.ajax({
					type: "POST",
					url:"https://paulina96madrid.000webhostapp.com/datosPrueba/update.php",
					data: dataString,
					crossDomain: true,
					cache: false,
					beforeSend: function(){ $("#insert").val('Connecting...');},
					success: function(data){
						if(data=="success")
						{
						alert("Registro actualizado.");
						window.location.href = "usuario.html";
						}
						else if(data=="error")
						{
						alert("Error de registro.");
						}
					}
					});
				}
				}
				return false;
			}
		});
	});
	
	//Valores base de datos en inputs.	
	var url="https://paulina96madrid.000webhostapp.com/datosPrueba/datos.php";
	$.getJSON(url,function(result){
		console.log(result);
		$.each(result, function(i, field){
			var id=field.id;
			var id_num=field.id_num;
			$("#numero").val(id_num);
		});
	});
	
});