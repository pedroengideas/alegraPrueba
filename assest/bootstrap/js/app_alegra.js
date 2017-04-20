var baseurl = $('body').data('href');

$(function () {
    /*
      variable que almacena el contenedor donde se cargan las vistas principales
      vista de agregar
      vista de modificar
      vista de ver
    */

    contenido_ajax = $('.contenido-contacto');

    /*
    funcion que permite cargar una pagina u otra a través de ajax
    */

    ajaxVistaContacto(baseurl+'index.php/alegracontacto/getListadoContacto',null,contenido_ajax);

    /*
     evento click asociado al id agregar contacto y agregar contacto otro que permite
     agrar un contacto y limpiar la pantalla y el otro que agregar el contacto y regresa 
     al listado del contacto. identifica uno de otro por un atributo data llamado tipo que 
     tiene asociado un valor 1 (agregar y crear otro) y 2 (agregar y regresa al listado)
    */

    $('body').on('click','#agregar-contacto, #agregar-contacto-otro',function(){
        tipo = $(this).data('tipo');

        var form = $('body').find('#form-crear-contacto');
        var nombre = form.find('#contacto-name').val();
        var error = false;

            $.ajax({
                type:'post',
                dataType:'json',
                url:baseurl+'index.php/alegracontacto/processCrearContacto',
                data:$('#form-crear-contacto').serialize(),
                beforeSend:function(){
                    $('body').find('.resultado-contacto').html('<div class="loanding text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div>');
                },
                success:function(data){
                    $('body').find('.resultado-contacto').html('');
                    if(data.exito=='b'){
                        $('body').find('.resultado-correcto-contacto').html(data.vista);
                        setTimeout(function(){
                            $('body').find('.resultado-correcto-contacto').html('');
                        },6000);
                        if(tipo=='1'){
                            ajaxVistaContacto(baseurl+'index.php/alegracontacto/getCrearContacto',null,contenido_ajax);
                        } else if(tipo=='2'){
                            ajaxVistaContacto(baseurl+'index.php/alegracontacto/getListadoContacto',null,contenido_ajax);
                        }

                    } else if(data.exito=='e'){
                        $('body').find('.resultado-contacto').html(data.vista);
                        // if(nombre == "" || nombre == " "){
                        //     form.find(' #contacto-name').css({'border-color':'#a94442'});
                        // }
                    }
                }
            });
        return false;
    });

    /*
      permite editar el contacto al darle click al boton de 
      editar de la pantalla contacto.
    */

    $('body').on('click','#editars-contacto',function(){
        idcontact = $(this).attr('href');

        var form = $('body').find('#form-crear-contacto');
        var nombre = form.find('#contacto-name').val();
        var error = false;

            $.ajax({
                type:'post',
                dataType:'json',
                url:baseurl+'index.php/alegracontacto/processEditarContacto/'+idcontact,
                data:$('#form-crear-contacto').serialize(),
                beforeSend:function(){
                    $('body').find('.resultado-contacto').html('<div class="loanding text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div>');
                },
                success:function(data){
                    $('body').find('.resultado-contacto').html('');
                    if(data.exito=='b'){
                        $('body').find('.resultado-correcto-contacto').html(data.vista);
                        setTimeout(function(){
                            $('body').find('.resultado-correcto-contacto').html('');
                        },6000);
                    } else if(data.exito=='e'){
                        $('body').find('.resultado-contacto').html(data.vista);
                        // if(nombre == "" || nombre == " "){
                        //     form.find(' #contacto-name').css({'border-color':'#a94442'});
                        // }
                    }
                }
            });

        return false;
    });

    /*
      boton de la lista de contactos que al darle click 
      nos lleva a la vista de edición de un contacto concreto.
    */

    $('body').on('click','.accion-edit',function(e){
        contenido_result = $('.contenido-contacto');
        e.preventDefault();
        link = $(this).attr('href');
        idlink = $(this).data('id');
        ajaxVistaContacto(link,idlink,contenido_result);
        return false;
    });


    /*

        evento click en la clase ver que permite llevar a un link en ajax 
        a la vista ver contacto

    */

    $('body').on('click','.accion-ver',function(e){
        contenido_result = $('.contenido-contacto');
        e.preventDefault();
        link = $(this).attr('href');
        idlink = $(this).data('id');
        ajaxVistaContacto(link,idlink,contenido_result);
        return false;
    });

    /*
    
        evento click en la clase delete que permite borrar un cliente seleccionado de la tabla
        este le advierte a través de una ventana de confirmación que si esta seguro de realizar la 
        operacion, ya que despues no podra revertirla.

    */

    $('body').on('click','.accion-delete',function(e){
        contenido_result = $('.resultado-opcion');
        e.preventDefault();
        idlink = $(this).attr('href');
            bootbox.confirm({
                message: "Esta seguro que desea eliminar al contacto seleccionado? una ves aceptada no podra revertirla.",
                buttons: {
                    confirm: {
                        label: 'SI',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'NO',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result==true){

                        $.ajax({
                            type:'post',
                            dataType:'json',
                            url:baseurl+'index.php/alegracontacto/getEliminarContacto',
                            data:{idcontacto:idlink},
                            beforeSend:function(){
                                $('body').find('.contenido-contacto').html('<div class="loanding text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div>');
                            },
                            success:function(data){
                                ajaxVistaContacto(baseurl+'index.php/alegracontacto/getListadoContacto',null,contenido_ajax);
                                $('body').find('.resultado-correcto-contacto').html(data.data);
                                
                                //table.ajax.url( 'newData.json' ).load();
                            },
                            error: function(xhr) { // if error occured
                                alert("ha ocurrido un error, por favor verifique");
                                contenido_result.append(xhr.statusText + xhr.responseText);
                                contenido_result.removeClass('loading');
                            },
                            complete: function() {
                                contenido_result.removeClass('loading');
                            }
                        });
                            setTimeout(function(){
                                $('body').find('.resultado-correcto-contacto').html('');
                            },10000);


                    }
                    //console.log('This was logged in the callback: ' + result);
                }
            });
        return false;
    });

    $('body').on('click','#eliminar-contacto-btn',function(e){
        e.preventDefault();
            bootbox.confirm({
                message: "Esta seguro que desea eliminar todos los contactos seleccionados?",
                buttons: {
                    confirm: {
                        label: 'SI',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'NO',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result==true){

                        $('body').find('.resultado-correcto-contacto').html('<div class="loanding text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div>');
                        var form = $('body').find('#chek-contacto-delete').serialize();
                        $.post(baseurl+'index.php/alegracontacto/getEliminarTodosContacto',form,function(data){
                            if(data.exito=='e'){
                                $('body').find('.resultado-correcto-contacto').html(data.data);
                            } else if(data.exito=='b'){
                                $('body').find('.resultado-correcto-contacto').html(data.data);
                                ajaxVistaContacto(baseurl+'index.php/alegracontacto/getListadoContacto',null,contenido_ajax);
                            }
                            setTimeout(function(){
                                $('body').find('.resultado-correcto-contacto').html('');
                            },10000);
                        },'json');

                    }
                    //console.log('This was logged in the callback: ' + result);
                }
            });
        return false;

    });

});

    /*
      funcion que crea la vista de contacto a través de ajax.
    */

function ajaxVistaContacto(urls,id,contenedor){

    $.ajax({
        type:'get',
        dataType:'json',
        url:urls,
        data:{idcontacto:id},
        beforeSend:function(){
            contenedor.html('<div class="loanding text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div>');
        },
        success:function(data){
            contenedor.html(data.vista);
        },
        error: function(xhr) { // if error occured
            alert("ha ocurrido un error, por favor verifique");
            contenedor.append(xhr.statusText + xhr.responseText);
            contenedor.removeClass('loading');
        },
        complete: function() {
            contenedor.removeClass('loading');
        }
    });
}