$(document).ready(function(){
	
	jQuery.validator.addMethod("name", function(value, element) {
        return this.optional(element) || /^[a-záéóóúàèìòùäëïöüñ\s]+$/i.test(value);
        });  
	
    /* Validar el campo nombre */
        jQuery.validator.addMethod("fullname", function(value, element) {
        return this.optional(element) || /^[a-záéóóúàèìòùäëïöüñ\s]+$/i.test(value);
        });     
    /* Validar el formulario */
    $("#btnActualizar").click(function(){
        var formulario = $("#formulario").validate
		({
			rules: /* Accedemos a los campos.*/
			{
				name: {required: true,  name: true },
				fullname: {required: true, fullname: true}
			},
			messages:
			{
				name : {required: 'Este campo es obligatorio', name:'Ingrese su Nombre'},
				fullname : {required: 'Este campo es obligatorio', fullname:'Ingrese su Apellido'}
			},
			submitHandler: function(form){
				var numero=$("#numero").val();
				var name=$("#name").val();
				var fullname=$("#fullname").val();
				var password=$("#password").val();
				var dataString="numero="+numero+"&name="+name+"&fullname="+fullname+"&password="+password+"&update=";
				if($.trim(numero).length>0)
				{
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
				return false;
			}
        });
    });  
	//Valores base de datos en inputs.	
	/*
	var url="https://paulina96madrid.000webhostapp.com/datosPrueba/datos.php";
		$.getJSON(url,function(result){
			console.log(result);
			$.each(result, function(i, field){
				var id=field.id;
				var id_num=field.id_num;
				var name=field.name;
				var fullname=field.fullname;
				var password=field.password;
				$("#numero").val(id_num);
				$("#name").val(name);
				$("#fullname").val(fullname);
				$("#password").val(password);
			});
		}); */
});