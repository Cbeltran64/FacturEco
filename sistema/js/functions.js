$(document).ready(function(){
    //--------------------- SELECCIONAR FOTO PRODUCTO ---------------------
    $("#foto").on("change",function(){
    	var uploadFoto = document.getElementById("foto").value;
        var foto       = document.getElementById("foto").files;
        var nav = window.URL || window.webkitURL;
        var contactAlert = document.getElementById('form_alert');
        
            if(uploadFoto !='')
            {
                var type = foto[0].type;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
                {
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';                        
                    $("#img").remove();
                    $(".delPhoto").addClass('notBlock');
                    $('#foto').val('');
                    return false;
                }else{  
                        contactAlert.innerHTML='';
                        $("#img").remove();
                        $(".delPhoto").removeClass('notBlock');
                        var objeto_url = nav.createObjectURL(this.files[0]);
                        $(".prevPhoto").append("<img id='img' src="+objeto_url+">");
                        $(".upimg label").remove();
                        
                    }
              }else{
              	alert("No selecciono foto");
                $("#img").remove();
              }              
    });

    $('.delPhoto').click(function(){
    	$('#foto').val('');
    	$(".delPhoto").addClass('notBlock');
    	$("#img").remove();

        if($("#foto_actual") && $("#foto_remove")){
            $("#foto_remove").val('img_producto.png');
        }
    });

    // Modal Form Add Product
    $('.add_product').click(function(e){
        //alert('hola');
        e.preventDefault();
        var producto = $(this).attr('product');
        var action = 'infoProducto';
        //alert(producto);
        
      $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: true,
            data: {action:action, producto:producto},
            success: function(response){
                if(response != 'error'){
                    var info = JSON.parse(response);
                    console.log(info);
                    //$('#producto_id').val(info.codproducto);
                    //$('.nameProducto').html(info.descripcion);
                    
                    $('.bodyModal').html('<form action="" method="post" name="form_add_product" id = "form_add_product" onsubmit="event.preventDefault(); sendDataProduct();">'+
                                            '<h1><i class="fas fa-cubes" style="font-size: 45pt"></i><br>Agregar producto</h1>'+
                                            '<h2 class="nameProducto">'+info.descripcion+'</h2>'+
                                            '<input type="number" name ="cantidad" id="txtcantidad" placeholder="Cantidad del producto" required><br>'+
                                            '<input type="text" name ="precio" id="txtprecio" placeholder="Precio del producto" required><br>'+
                                            '<input type="hidden" name ="producto_id" id="producto_id" value="'+info.codproducto+'"required><br>'+
                                            '<input type="hidden" name ="action" value ="addProduct" required>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Agregar</button>'+
                                            '<a href="#" class="btn_ok btn_cancel closeModal" onclick="closeModal();"><i class="fas fa-ban"></i> Cerrar</a>'+
                                        '</form>');



                }
            },
            error: function(error){
                console.log(error);
            }
        });
        $('.modal').fadeIn();
    });
});

function sendDataProduct(){
    $('.alertAddProduct').html('');
    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: true,
        data: $('#form_add_product').serialize(),
        success: function(response){
            if(response == 'error'){
                $('.alertAddProduct').html('<p style="color: red;">Error al agregar producto.</p>');
            }else{
                var info = JSON.parse(response);
                console.log(info);
                $('#row'+info.producto_id+' .celPrecio').html(info.nuevo_precio);
                $('#row'+info.producto_id+' .celExistencia').html(info.nueva_existencia);
                $('#txtcantidad').val('');
                $('#txtprecio').val('');
                $('.alertAddProduct').html('<p>Producto guardado correctamente</p>');
            }
        },
        error: function(error){
            console.log(error);
        }   
    });
}

function closeModal(){
    $('.alertAddProduct').html('');
    $('#txtcantidad').val('');
    $('#txtprecio').val('');
    $('.modal').fadeOut();
}

