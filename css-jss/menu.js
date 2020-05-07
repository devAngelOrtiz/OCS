$(document).ready(function(){
	var xmlhttp;
	if(window.XMLHttpRequest)
		xmlhttp=new XMLHttpRequest();
	else
		xmlhttp=new ActiveObject("Microsoft.XMLHTTP");

	$("a[id=categorias]").click(function(){
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState==4 && xmlhttp.status==200 && xmlhttp.responseText=="true")//400 que no lo pudo encontrar //500 no pudo formar la pagina
				categorias();
			else
				if(xmlhttp.responseText=="false")
					window.location="index.html";
		}
		xmlhttp.open("GET","verifica.php",true);
		xmlhttp.send();
		return false;
    });

	$("a[id=subcategorias]").click(function(){
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState==4 && xmlhttp.status==200 && xmlhttp.responseText=="true")//400 que no lo pudo encontrar //500 no pudo formar la pagina
				subcategorias();
			else
				if(xmlhttp.responseText=="false")
					window.location="index.html";
		}
		xmlhttp.open("GET","verifica.php",true);
		xmlhttp.send();
		return false;
    });

    $("a[id=productos]").click(function(){
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState==4 && xmlhttp.status==200 && xmlhttp.responseText=="true")//400 que no lo pudo encontrar //500 no pudo formar la pagina
				productos();
			else
				if(xmlhttp.responseText=="false")
					window.location="index.html";
		}
		xmlhttp.open("GET","verifica.php",true);
		xmlhttp.send();
		return false;
    });

    $("a[id=usuarios]").click(function(){
		 xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState==4 && xmlhttp.status==200 && xmlhttp.responseText=="true")//400 que no lo pudo encontrar //500 no pudo formar la pagina
				usuarios();
			else
				if(xmlhttp.responseText=="false")
					window.location="index.html";
		}
		xmlhttp.open("GET","verifica.php",true);
		xmlhttp.send();
		return false;
    });

    $("a[id=pedidos]").click(function(){
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState==4 && xmlhttp.status==200 && xmlhttp.responseText=="true")//400 que no lo pudo encontrar //500 no pudo formar la pagina
				pedidos();
			else
				if(xmlhttp.responseText=="false")
					window.location="index.html";
		}
		xmlhttp.open("GET","verifica.php",true);
		xmlhttp.send();
		return false;
    });

    $("a[id=reportes]").click(function(){
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState==4 && xmlhttp.status==200 && xmlhttp.responseText=="true")//400 que no lo pudo encontrar //500 no pudo formar la pagina
				reportes();
			else
				if(xmlhttp.responseText=="false")
					window.location="index.html";
		}
		xmlhttp.open("GET","verifica.php",true);
		xmlhttp.send();
		return false;
    });
});

function pedidos()
{
	$.ajax({
		data: null,
	   	url:   'pedidos.php',
	    type:  'post',
	    beforeSend: function () {
       		$("#titulo").html("<span>Pedidos</span>");
	    },
	    success:  function (response) {
          	$("#contenido").html(response);
	    }
	});
}

function usuarios()
{
	$.ajax({
		data: null,
    	url:   'usuarios.php',
        type:  'POST',
        beforeSend: function () {
       		$("#titulo").html("<span>Usuarios</span>");
        },
        success:  function (response) {
       		$("#contenido").html(response);
	    }
	});
}

function categorias()
{
	$.ajax({
		data: null,
	  	url:   'categoria/consulta.php',
	    type:  'post',
	    beforeSend: function () {
	   	$("#titulo").html("<span>Categorias</span>");
	    	var newlink = document.createElement('a');
			newlink.setAttribute('id', 'addcategoria');
			newlink.setAttribute('href', ' ');
			newlink.innerHTML = "<img class='ico-acciones' src='img/agregar.png'/>Agregar Categoria";
			newlink.onclick = formaddcategoria;
	   		document.getElementById('titulo').appendChild(newlink);
	    },
	    success:  function (response) {
		   	$("#contenido").html(response);
		}
	});
}

function agrcategoria()
{
	var datos= {
		"nombre" :  $("#nombre").val(),
		"idcategoria" : $("#idcategoria").val()
	};
	$.ajax({
		data: datos,
	  	url:   'categoria/agregar.php',
	    type:  'post',
	    beforeSend: function () {
	   		$("#titulo").html("<span>Agregar Categorias</span>");
	    },
	    success:  function (response) {
	    	$("#contenido").html(response+"<center><input type='submit' value='Aceptar' onclick='categorias();' class='aceptar'/></center>");
		}
	});
	return false;
}

function vercategoria(id)
{
	var datos= {
		"id" : id
	};
	$.ajax({
		data: datos,
	  	url:   'categoria/ver.php',
	    type:  'post',
	     beforeSend: function () {
	   	$("#titulo").html("<span>Ver Categoria</span>");
	    	var newlink = document.createElement('a');
			newlink.setAttribute('id', 'addcategoria');
			newlink.setAttribute('href', ' ');
			newlink.innerHTML = "<img class='ico-acciones' src='img/agregar.png'/>Agregar Categoria";
			newlink.onclick = formaddcategoria;
	   		document.getElementById('titulo').appendChild(newlink);
	    },
	    success:  function (response) {
		   	$("#contenido").html(response);
		}
	});
	return false;
}

function elicategoria(id)
{
	var datos= {
		"id" : id,
		"acc": "eli"
	};
	$.ajax({
		data: datos,
	  	url:   'categoria/eliminar.php',
	    type:  'post',
	    beforeSend: function () {
	   		$("#titulo").html("<span>Eliminar Categoria</span>");
	    },
	    success:  function (response) {
		   	$("#contenido").html(response);
		}
	});
	return false;
}
function delcategoria(id)
{
	var datos= {
		"id" : id,
		"acc": "del"	
	};
	$.ajax({
		data: datos,
	  	url:   'categoria/eliminar.php',
	    type:  'post',
	    success:  function (response) {
		   	$("#contenido").html(response);
		}
	});
	return false;
}

function modcategoria(id)
{
	var datos= {
		"id" : id,
		"acc": "mod"
	};
	$.ajax({
		data: datos,
	  	url:   'categoria/modificar.php',
	    type:  'post',
	   	beforeSend: function () {
	   		$("#titulo").html("<span>Modificar Categorias</span>");
	    },
	    success:  function (response) {
		   	$("#contenido").html(response);
		}
	});
	return false;
}

function updcategoria(id)
{
	var datos= {
		"id" : id,
		"acc": "upd",
		"nombre" :  $("#nombre").val()
	};
	$.ajax({
		data: datos,
	  	url:   'categoria/modificar.php',
	    type:  'post',
	    success:  function (response) {
		   	$("#contenido").html(response);
		}
	});
	return false;
}


function productos()
{
	$.ajax({
		data: null,
    	url:   'producto/consulta.php',
	    type:  'post',
        beforeSend: function () {
       		$("#titulo").html("<span>Productos</span>");
       		var newlink = document.createElement('a');
			newlink.setAttribute('id', 'addproducto');
			newlink.setAttribute('href', ' ');
			newlink.innerHTML = "<img class='ico-acciones' src='img/agregar.png'/>Agregar Producto";
			newlink.onclick = formaddproducto;
    		document.getElementById('titulo').appendChild(newlink);
		},
	    success:  function (response) {
	    	$("#contenido").html(response);
	    }
	});
}

function agrproducto()
{
	var data = new FormData();
	jQuery.each(jQuery('#file')[0].files, function(i, file) {
	    data.append(i, file);
	});
	data.append("nombre", $("#nombre").val());
	data.append("marca", $("#marca").val());
	data.append("precio", $("#precio").val());
	data.append("descripcion", $("#descripcion").val());
	data.append("idsubcategoria", $("#idsubcategoria").val());
	data.append("cantidad", $("#cantidad").val());
	
	$.ajax({
		data: data,
	  	url:   'producto/agregar.php',
	    type:  'POST',
	    processData: false,
		contentType: false,
	    beforeSend: function () {
	   		$("#titulo").html("<span>Agregar Producto</span>");
	    },
	    success:  function (response) {
		   $("#contenido").html(response+"<center><input type='submit' value='Aceptar' onclick='productos();' class='aceptar'/></center>");
		}
	});
	return false;
}

function verproductos(id,sub)
{
	var datos= {
		"id" : id,
		"sub":sub
	};
	$.ajax({
		data: datos,
	  	url:   'producto/ver.php',
	    type:  'post',
	     beforeSend: function () {
	   	$("#titulo").html("<span>Ver Producto</span>");
	    	var newlink = document.createElement('a');
			newlink.setAttribute('id', 'addproducto');
			newlink.setAttribute('href', ' ');
			newlink.innerHTML = "<img class='ico-acciones' src='img/agregar.png'/>Agregar Producto";
			newlink.onclick = formaddproducto;
	   		document.getElementById('titulo').appendChild(newlink);
	    },
	    success:  function (response) {
		   	$("#contenido").html(response);
		}
	});
	return false;
}
function verProductosSubcategoria(id)
{
	var datos= {
		"id" : id
	};
	$.ajax({
		data: datos,
    	url:   'producto/consultaporcategoria.php',
	    type:  'post',
        beforeSend: function () {
       		$("#titulo").html("<span>Productos por Subcategoria</span>");
		},
	    success:  function (response) {
	    	$("#contenido").html(response);
	    }
	});
	return false;
}

function eliproductos(id,sub)
{
	var datos= {
		"id" : id,
		"sub":sub,
		"acc": "eli"
	};
	$.ajax({
		data: datos,
	  	url:   'producto/eliminar.php',
	    type:  'post',
	    beforeSend: function () {
	   		$("#titulo").html("<span>Eliminar Producto</span>");
	    },
	    success:  function (response) {
		   	$("#contenido").html(response);
		}
	});
	return false;
}
function delproductos(id,sub)
{
	var datos= {
		"id" : id,
		"sub": sub,
		"acc": "del"
	};
	$.ajax({
		data: datos,
	  	url:   'producto/eliminar.php',
	    type:  'post',
	    success:  function (response) {
		   	$("#contenido").html(response);
		}
	});
	return false;
}

function modproductos(id,sub)
{
	var datos= {
		"id" : id,
		"sub":sub,
		"acc": "mod"
	};
	$.ajax({
		data: datos,
	  	url:   'producto/modificar.php',
	    type:  'post',
	   	beforeSend: function () {
	   		$("#titulo").html("<span>Modificar Producto</span>");
	    },
	    success:  function (response) {
		   	$("#contenido").html(response);
		}
	});
	return false;
}

function updproductos(id,sub)
{
	var data = new FormData();
	jQuery.each(jQuery('#file')[0].files, function(i, file) {
	    data.append(i, file);
	});
	data.append("id", id);
	data.append("nombre", $("#nombre").val());
	data.append("marca", $("#marca").val());
	data.append("precio", $("#precio").val());
	data.append("descripcion", $("#descripcion").val());
	data.append("idsubcategoria", $("#idsubcategoria").val());
	data.append("cantidad", $("#cantidad").val());
	data.append("acc", "upd");
	data.append("sub", 0);

	$.ajax({
		data: data,
	  	url:   'producto/modificar.php',
	    type:  'post',
	    processData: false,
		contentType: false,
	    success:  function (response) {
		   	$("#contenido").html(response);
		}
	});
	return false;
}

function subcategorias()
{
	$.ajax({
		data: null,
	  	url:   'subcategoria/consulta.php',
	    type:  'post',
	    beforeSend: function () {
	   	$("#titulo").html("<span>Subcategorias</span>");
	    	var newlink = document.createElement('a');
			newlink.setAttribute('id', 'addcategoria');
			newlink.setAttribute('href', ' ');
			newlink.innerHTML = "<img class='ico-acciones' src='img/agregar.png'/>Agregar Subcategoria";
			newlink.onclick = formaddsubcategoria;
	   		document.getElementById('titulo').appendChild(newlink);
	    },
	    success:  function (response) {
		   	$("#contenido").html(response);
		}
	});
}

function agrsubcategoria()
{
	var datos= {
		"nombre" :  $("#nombre").val(),
		"idcategoria" : $("#idcategoria").val()
	};
	$.ajax({
		data: datos,
	  	url:   'subcategoria/agregar.php',
	    type:  'post',
	    beforeSend: function () {
	   		$("#titulo").html("<span>Agregar Subcategorias</span>");
	    },
	    success:  function (response) {
	    	$("#contenido").html(response+"<center><input type='submit' value='Aceptar' onclick='subcategorias();' class='aceptar'/></center>");
		}
	});
	return false;
}

function verSubcategoriasCategorias(id)
{
	var datos= {
		"id" : id
	};
	$.ajax({
		data: datos,
    	url:   'subcategoria/consultaporcategoria.php',
	    type:  'post',
        beforeSend: function () {
       		$("#titulo").html("<span>Subcategoria por Categoria</span>");
		},
	    success:  function (response) {
	    	$("#contenido").html(response);
	    }
	});
	return false;
}

function versubcategoria(id,cat)
{
	var datos= {
		"id" : id,
		"cat" : cat
	};
	$.ajax({
		data: datos,
	  	url:   'subcategoria/ver.php',
	    type:  'post',
	     beforeSend: function () {
	   	$("#titulo").html("<span>Ver Subcategoria</span>");
	    	var newlink = document.createElement('a');
			newlink.setAttribute('id', 'addcategoria');
			newlink.setAttribute('href', ' ');
			newlink.innerHTML = "<img class='ico-acciones' src='img/agregar.png'/>Agregar Subcategoria";
			newlink.onclick = formaddsubcategoria;
	   		document.getElementById('titulo').appendChild(newlink);
	    },
	    success:  function (response) {
		   	$("#contenido").html(response);
		}
	});
	return false;
}

function elisubcategoria(id,cat)
{
	var datos= {
		"id" : id,
		"acc": "eli",
		"cat" : cat
	};
	$.ajax({
		data: datos,
	  	url:   'subcategoria/eliminar.php',
	    type:  'post',
	    beforeSend: function () {
	   		$("#titulo").html("<span>Eliminar Subcategoria</span>");
	    },
	    success:  function (response) {
		   	$("#contenido").html(response);
		}
	});
	return false;
}
function delsubcategoria(id,cat)
{
	var datos= {
		"id" : id,
		"acc": "del",
		"cat" : cat	
	};
	$.ajax({
		data: datos,
	  	url:   'subcategoria/eliminar.php',
	    type:  'post',
	    success:  function (response) {
		   	$("#contenido").html(response);
		}
	});
	return false;
}

function modsubcategoria(id,cat)
{
	var datos= {
		"id" : id,
		"acc": "mod",
		"cat" : cat
	};
	$.ajax({
		data: datos,
	  	url:   'subcategoria/modificar.php',
	    type:  'post',
	   	beforeSend: function () {
	   		$("#titulo").html("<span>Modificar Subcategorias</span>");
	    },
	    success:  function (response) {
		   	$("#contenido").html(response);
		}
	});
	return false;
}

function updsubcategoria(id,cat)
{
	var datos= {
		"id" : id,
		"acc": "upd",
		"nombre" :  $("#nombre").val(),
		"idcategoria" : $("#idcategoria").val(),
		"cat" : cat
	};
	$.ajax({
		data: datos,
	  	url:   'subcategoria/modificar.php',
	    type:  'post',
	    success:  function (response) {
		   	$("#contenido").html(response);
		}
	});
	return false;
}

function formaddcategoria(){
	$("#titulo").html("<span>Agregar Categorias</span>");
	$("#contenido").html("<form onSubmit='return agrcategoria();'><table>"+
				"<tr><td><span class='r'>Nombre: </span></td><td><input class='entrada-texto' name='nombre' id='nombre' type='text' placeholder='Nombre de la categoria' maxlength='45' autofocus required /></td></tr></table>"+
				"<center><input type='submit' value='Aceptar' class='aceptar'/> "+
				"<input type='button' value='Cancelar' onclick='categorias()' class='cancelar'/></center></form>");	
	return false;
}

function formaddsubcategoria(){
	$.ajax({
		data: null,
    	url:   'categoria/select.php',
        type:  'post',
         beforeSend: function () {
       		$("#titulo").html("<span>Agregar Subcategorias</span>");
        },
        success:  function (response) 
        {
			$("#contenido").html("<form onSubmit='return agrsubcategoria();'><table>"+
				"<tr><td><span class='r'>Nombre: </span></td><td><input class='entrada-texto' name='nombre' id='nombre' type='text' placeholder='Nombre de la subcategoria' maxlength='40' autofocus required /></td><td>"+
				"<tr><td><span class='r'>Categoria: </span></td><td>"+response+"</td></tr></table>"+
				"<center><input type='submit' value='Aceptar' class='aceptar'/> "+
				"<input type='button' value='Cancelar' onclick='subcategorias()' class='cancelar'/></center></form>");
	    }
	});
	
	return false;
}

function selectTodos(ele) {
    var checkboxes = document.getElementsByTagName('input');
    //alert(checkboxes.length);
    if(checkboxes.length>3)
	    if (ele.checked ) {
	    	document.getElementById('eliminarP').removeAttribute("disabled");
	    	document.getElementById('modificarP').removeAttribute("disabled");
	        for (var i = 0; i < checkboxes.length; i++) {
	            if (checkboxes[i].type == 'checkbox') {
	                checkboxes[i].checked = true;
	            }
	        }
	    } else {
	    	$("#cam").html('');
	    	document.getElementById('eliminarP').disabled = true;
	    	document.getElementById('modificarP').disabled = true;
	        for (var i = 0; i < checkboxes.length; i++) {
	            if (checkboxes[i].type == 'checkbox') {
	                checkboxes[i].checked = false;
	            }
	        }
	    }
    return false;
}

function seleccion(ele) {
    var checkboxes = document.getElementsByTagName('input'),i;
    document.getElementById('selectall').checked = false;
    if (ele.checked) {
    	document.getElementById('eliminarP').removeAttribute("disabled");
    	document.getElementById('modificarP').removeAttribute("disabled");
    } else {
        for (i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type == 'checkbox') 
            	if(checkboxes[i].checked==true)
            		break;
        }
        if(i==checkboxes.length)
        {
        	document.getElementById('eliminarP').disabled = true;
    		document.getElementById('modificarP').disabled = true;
    		$("#cam").html('');
    	}
    }
    return false;
}

function ModificarProductoSelec(sub)
{
	document.getElementById('eliminarP').disabled = true;
    document.getElementById('modificarP').disabled = true;
	$.ajax({
		data: null,
	  	url:   'subcategoria/select.php',
	    type:  'post',
	    success:  function (response) {
		   	$("#cam").html("<table><tr><td><p class='r'>Seleccione la nueva subcategoria</p></td><td>"+response+"</td></tr><tr><td><input type='submit' value='Aceptar' onclick='updProductoSelec("+sub+")' class='aceptar r'/></td><td><input type='button' value='Cancelar' onclick='activar()' class='cancelar l'/></tr></td></table>");
		}
	});
	return false;
}

function updProductoSelec(sub)
{
	var pos=0,datos= [ {name:0, value:$("#idsubcategoria").val()} ];
	var checkboxes = document.getElementsByTagName('input');
    for (i = 0; i < checkboxes.length; i++) 
    {
        if (checkboxes[i].type == 'checkbox') 
        	if(checkboxes[i].checked==true)
        		if(checkboxes[i].value>0)
        		{
        			datos.push({name:pos+=1, value: ""+checkboxes[i].value});
        		}
          		
	}

	$.ajax({
		data: datos,
	  	url:   'producto/modificarvarios.php',
	    type:  'post',
	    success:  function (response) {
		   	$("#contenido").html(response+"<input type='submit' value='Aceptar' onclick='verProductosSubcategoria("+sub+")' class='aceptar'/>");
		}
	});
	return false;
}

function EliminarProductoSelec(sub)
{
	document.getElementById('eliminarP').disabled = true;
    document.getElementById('modificarP').disabled = true;
    $("#cam").html("<center><p>Desea eliminar los productos seleccionados</p><input type='submit' value='Aceptar' onclick='delProductoSelec("+sub+")' class='aceptar'/><input type='button' value='Cancelar' onclick='activar()' class='cancelar'/></center>");
    return false;
}

function delProductoSelec(sub)
{
	var pos=-1,datos=[];
	var checkboxes = document.getElementsByTagName('input');
    for (i = 0; i < checkboxes.length; i++) 
    {
        if (checkboxes[i].type == 'checkbox') 
        	if(checkboxes[i].checked==true)
        		if(checkboxes[i].value>0)
        		{
        			datos.push({name:pos+=1, value: ""+checkboxes[i].value});
        		}
          		
	}

	$.ajax({
		data: datos,
	  	url:   'producto/eliminarvarios.php',
	    type:  'post',
	    success:  function (response) {
		   	$("#contenido").html(response+"<input type='submit' value='Aceptar' onclick='verProductosSubcategoria("+sub+")' class='aceptar'/>");
		}
	});
	return false;
}

function activar()
{
	$("#cam").html('');
	document.getElementById('eliminarP').removeAttribute("disabled");
    document.getElementById('modificarP').removeAttribute("disabled");
    return false;
}

function formaddproducto(){
	$.ajax({
		data: null,
    	url:   'subcategoria/select.php',
        type:  'post',
         beforeSend: function () {
       		$("#titulo").html("<span>Agregar Producto</span>");
        },
        success:  function (response) 
        {
			$("#contenido").html(" <form enctype='multipart/form-data' method='post' id='formproducto' onSubmit='return agrproducto();' ><table><tr><td><span class='r'>Nombre: </span>"
				+"</td><td><input class='entrada-texto' id='nombre' type='text' placeholder='Nombre del producto' maxlength='100' autofocus required />"
				+"</td></tr><tr><td><span class='r'>Marca: </span></td><td><input class='entrada-texto' id='marca' type='text' placeholder='Marca' maxlength='45' autofocus required />"
				+"</td></tr><tr><td><span class='r'>Precio: </span></td><td><input class='entrada-texto' id='precio' min='1' type='number' placeholder='Precio' autofocus required />"
				+"</td></tr><tr><td><span class='r'>Cantidad: </span></td><td><input class='entrada-texto' id='Cantidad' min='1' type='number' placeholder='Cantidad' autofocus required />"
				+"</td></tr><tr><td><span class='r'>Descripcion: </span></td><td><textarea rows='5' id='descripcion' maxlength='500' required></textarea></td></tr><tr><td><span class='r'>Subcategoria: </span>"
				+"</td><td>"+response+"</td></tr>"
				+"<tr><td><span class='r'>Imagen: </span></td><td><input class='entrada-texto' type='file' id='file'  multiple='' accept='image/jpeg, image/png' required>"
				+"</td></tr></table>"
				+"<center><input type='submit' value='Aceptar' class='aceptar'/> "
				+"<input type='button' value='Cancelar' onclick='productos();' class='cancelar'/></center></form>");
		}
	});
	return false;
}

function ModificarSucategoriasSelec(cat)
{
	document.getElementById('eliminarP').disabled = true;
    document.getElementById('modificarP').disabled = true;
	$.ajax({
		data: null,
	  	url:   'categoria/select.php',
	    type:  'post',
	    success:  function (response) {
		   	$("#cam").html("<table><tr><td><p class='r'>Seleccione la nueva categoria</p></td><td>"+response+"</td></tr><tr><td><input type='submit' value='Aceptar' onclick='updCategoriaSelec("+cat+")' class='aceptar r'/></td><td><input type='button' value='Cancelar' onclick='activar()' class='cancelar l'/></tr></td></table>");
		}
	});
	return false;
}

function updCategoriaSelec(cat)
{
	var pos=0,datos= [ {name:0, value:$("#idsubcategoria").val()} ];
	var checkboxes = document.getElementsByTagName('input');
    for (i = 0; i < checkboxes.length; i++) 
    {
        if (checkboxes[i].type == 'checkbox') 
        	if(checkboxes[i].checked==true)
        		if(checkboxes[i].value>0)
        		{
        			datos.push({name:pos+=1, value: ""+checkboxes[i].value});
        		}
          		
	}

	$.ajax({
		data: datos,
	  	url:   'subcategoria/modificarvarios.php',
	    type:  'post',
	    success:  function (response) {
		   	$("#contenido").html(response+"<input type='submit' value='Aceptar' onclick='verSubcategoriasCategorias("+cat+")' class='aceptar'/>");
		}
	});
	return false;
}

function EliminarSubcategoriasSelec(cat)
{
	document.getElementById('eliminarP').disabled = true;
    document.getElementById('modificarP').disabled = true;
    $("#cam").html("<center><p>Desea eliminar las subcategorias seleccionadas</p><input type='submit' value='Aceptar' onclick='delCategoriaSelec("+cat+")' class='aceptar'/><input type='button' value='Cancelar' onclick='activar()' class='cancelar'/></center>");
    return false;
}

function delCategoriaSelec(cat)
{
	var pos=-1,datos=[];
	var checkboxes = document.getElementsByTagName('input');
    for (i = 0; i < checkboxes.length; i++) 
    {
        if (checkboxes[i].type == 'checkbox') 
        	if(checkboxes[i].checked==true)
        		if(checkboxes[i].value>0)
        		{
        			datos.push({name:pos+=1, value: ""+checkboxes[i].value});
        		}
          		
	}

	$.ajax({
		data: datos,
	  	url:   'subcategoria/eliminarvarios.php',
	    type:  'post',
	    success:  function (response) {
		   	$("#contenido").html(response+"<input type='submit' value='Aceptar' onclick='verSubcategoriasCategorias("+cat+")' class='aceptar'/>");
		}
	});
	return false;
}

function EliminarImagen(id,ruta)
{
	document.getElementById(id).innerHTML="<span class='text'>Realmente desea eliminar esta Imagen?</span>"
			+"<input type='button' value='Aceptar' onclick='DelImagen("+id+",\""+ruta+"\")' class='aceptarmini'/>"
			+"<input type='button' value='Cancelar' onclick='vaciardiv("+id+")' class='cancelarmini'/></center>";
}

function DelImagen(id,ruta)
{
	var datos= {
		"id" : id,
		"ruta" : ruta
	};
	$.ajax({
		data: datos,
	  	url:   'producto/eliminarImgenes.php',
	    type:  'post',
	    success:  function (response) {
		   	if(response == 'true')
		   	{
		   		$("#img"+id).html("");
				$(id).html("<span class='text'>Se ha eliminado exitosamente</span>");
		   	}
		   	else
		   	{
		   		$(id).html("<span class='text'>"+response+"</span>");
		   	}
		   	setTimeout(vaciardiv(id),1000);
		}
	});
	return false;
}

function vaciardiv(name)
{
	document.getElementById(name).innerHTML="";
}

function pdfpedido(id)
{
	window.open("reporPedidos.php?id="+id);
}

function imprimirpdfpedido(id)
{
	window.open("impPedidos.php?id="+id);
}

function reportes()
{
	$.ajax({
		data: null,
	  	url:   'getselectspedidos.php',
	    type:  'post',
	    beforeSend: function () {
	   		$("#titulo").html("<span>Reportes</span>");
	    },
	    success:  function (response) {
		   	$("#contenido").html(response);
		}
	});
}

function genrep()
{
	var posicion=document.getElementById('marca').value;
	var nombre=document.getElementById('nombre').value;
	var filtro=document.getElementById('filtro').value;
	window.open("pdf2.php?productos="+posicion+"&&nombre="+nombre+"&&filtro="+filtro);
}

function imprimir()
{
	var posicion=document.getElementById('marca').value;
	var nombre=document.getElementById('nombre').value;
	var filtro=document.getElementById('filtro').value;
	window.open("imprimir.php?productos="+posicion+"&&nombre="+nombre+"&&filtro="+filtro);
}