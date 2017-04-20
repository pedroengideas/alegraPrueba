<!--
	vista encarga de mostar la creación y edición de un contacto
	@author: Pedro Velasquez
 -->

	<div class="container">
		<div class="col-md-12">
			<div class="panel panel-default panel-flat-default">
				<!-- Default panel contents -->
				<div class="panel-heading panel-flat-header">
					<div class="row">
						<div class="col-sm-12">
							<h4 class="pull-left"><i class="fa fa-users fa-1x"></i> CONTACTOS</h4>
							<button type="button" class="btn btn-md btn-success pull-left btn-left accion-crear"><i class="fa fa-plus"></i> Nuevo Contacto</button>

							<ul class="list-inline pull-right">
								<li><input type="checkbox" id="examples-select-all" class="allChecked"> Seleccione contactos</li>
								<li class=""><a data-toggle="collapse" data-target=".list-contact" class="fa fa-arrow-down btn btn-xs"></a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="panel-body list-contact">
					<div class="container-fluid" style="margin-bottom:10px;">
						<div class="col-md-8">Modelo sistemico que permite listar, agregar, editar y eliminar a un Contacto</div>
						<div class="col-md-4">
							<button type="button" data-toggle="collapse" data-target=".input-search-filter" class="btn btn-default pull-right"><i class="fa fa-plus"></i> FILTRAR</button>
							<button type="button" class="btn btn-dange pull-right eliminar-contacto-btn" id="eliminar-contacto-btn"> ELIMINAR CONTACTO</button>
						</div>
					</div>
					<div class="resultado-opcion"><?php echo $this->session->tempdata('data'); ?></div>
					<!-- Table -->
					<div class="container-fluid">
						<form id="chek-contacto-delete" method="POST" role="form">
							<div class="table-responsive">
								<table class="table table-hover table-listado-contacto">
									<thead>
										<tr>
											<th>Seleccionar</th>
											<th>Nombre</th>
											<th>Identificación</th>
											<th>Telefono 1</th>
											<th>Observaciones</th>
											<th>Tipo de contacto</th>
											<th>Acciones</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</form>
					</div>
				</div>
			</div>

		</div>
	</div>

<script type="text/javascript">

$(function() {

	$('.eliminar-contacto-btn').css({'display':'none'});

    $('.table-listado-contacto thead th').each( function () {
        var title = $('.table-listado-contacto thead th').eq( $(this).index() ).text();
        if(($(this).index()==1) || ($(this).index()==2) || ($(this).index()==3) || ($(this).index()==4) || ($(this).index()==5)) {
			$('.table-listado-contacto thead th').eq($(this).index()).append( '<div class="input-search-filter collapse"><input class="form-control input-sm input-search" type="text" placeholder="Buscar '+title+'" /></div>');
        } 
    });

    /*
    
	    función que carga una tabla dinamica en jquery para la consulta y la visualización de datos
	    en este caso una lista de contactos, emitidos a travpes de la API de alegra en formato json.

    */

    var oTable = $('.table-listado-contacto').dataTable({
        "sPaginationType":"full_numbers",
        "oLanguage": {
            "sUrl": "<?php echo base_url() ?>assest/data_es.txt"
        },
        "processing": false,
    	"serverSide": false,
        "ajax":{
            "type":'post',
            "dataType":'json',
            "url":"<?php echo base_url()?>index.php/alegracontacto/getListadoTable"
        },
        "columns":[
        	{"data":'id'},
            {"data":'name'},
            {"data":'identification'},
            {"data":'phonePrimary'},
            {"data":'observations'},
            {"data": 'type',
	            render:function(data,type,row){
	                if(type=='display'){

			        	tipo_contacto = data;
			        	tipocs = '';
			        	$.each(tipo_contacto,function(i,items){
			        		if(items=='client'){
			        			tipoc = '<span class="label label-info">Cliente</span> ';
			        		}
			        		if(items=='provider'){
			        			tipoc = '<span class="label label-primary">Proveedor</span>';
			        		}
			        		tipocs = tipoc+' '+tipocs;
			        	});

			        	return tipocs;

	                }

	                return data;
	            }
        	},
            {"data":'id'}
        ],
        rowCallback: function( row, data, index ) {

        	$('td:eq(0)',row).html('<div class="checkbox"><label><input type="checkbox" name="check-contact[]" class="check-contact" value="'+data.id+'"></label></div>');

        	$('td:eq(6)',row).html('<ul class="list-inline"><li class=""><a href="<?php echo base_url('index.php/alegracontacto/getVerContacto')?>" data-id="'+data.id+'" class="btn btn-xs fa fa-eye accion-ver" role="button"></a></li><li class=""><a class="btn btn-xs fa fa-pencil accion-edit" href="<?php echo base_url('index.php/alegracontacto/getEditContacto')?>" data-id="'+data.id+'" role="button"></a></li><li class=""><a class="btn btn-xs fa fa-trash accion-delete" href="'+data.id+'" role="button"></a></li></ul>');

        }
    });

    $('#examples-select-all').click(function () {
        if ($(this).hasClass('allChecked')) {
            $('.table-listado-contacto tbody').find('.check-contact').prop('checked', true);
            $('.eliminar-contacto-btn').css({'display':'inline-block'});
        } else {
            $('.table-listado-contacto tbody').find('.check-contact').prop('checked', false);
            $('.eliminar-contacto-btn').css({'display':'none'});
        }
        $(this).toggleClass('allChecked');
    });

	$('.input-search').keyup(function(){
	      oTable.fnFilter($(this).val());
	})

    /*
    
	    evento click en la clase ver que permite llevar a un link en ajax 
		a la vista crear contacto, este no pasa ningun parametro.

    */

    $('body').on('click','.accion-crear',function(e){
		contenido_result = $('.contenido-contacto');
		e.preventDefault();

		    $.ajax({
		        type:'get',
		        dataType:'json',
		        url:baseurl+'index.php/alegracontacto/getCrearContacto',
		        data:null,
		        beforeSend:function(){
		            contenido_result.html('<div class="loanding text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div>');
		        },
		        success:function(data){
		            contenido_result.html(data.vista);
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

		return false;
    });

});

    /*
    
	    funcion basica en ajax que permite recoger las url y los id de la tabla para generar los 
	    resultados de edición y ver. ya que pertenen a ambos a un ID

    */



function ContactoTable(){

    var oTable = $('.table-listado-contacto').dataTable({
        "sPaginationType":"full_numbers",
        "oLanguage": {
            "sUrl": "<?php echo base_url() ?>assest/data_es.txt"
        },
        "processing": false,
    	"serverSide": false,
        "ajax":{
            "type":'post',
            "dataType":'json',
            "url":"<?php echo base_url()?>index.php/alegracontacto/getListadoTable"
        },
        "columns":[
        	{"data":'id'},
            {"data":'name'},
            {"data":'identification'},
            {"data":'phonePrimary'},
            {"data":'observations'},
            {"data":'id'}
        ],
        rowCallback: function( row, data, index ) {


        	$('td:eq(0)',row).html('<div class="checkbox"><label><input type="checkbox" name="check-contact[]" value="'+data.id+'"></label></div>');

        	$('td:eq(5)',row).html('<ul class="list-inline"><li class=""><a href="<?php echo base_url('index.php/alegracontacto/getVerContacto')?>" data-id="'+data.id+'" class="btn btn-xs fa fa-eye accion-ver" role="button"></a></li><li class=""><a class="btn btn-xs fa fa-pencil accion-edit" href="<?php echo base_url('index.php/alegracontacto/getEditContacto')?> data-id="'+data.id+'" role="button"></a></li><li class=""><a class="btn btn-xs fa fa-trash accion-delete" href="'+data.id+'" role="button"></a></li></ul>');

        }
    });

}


</script>