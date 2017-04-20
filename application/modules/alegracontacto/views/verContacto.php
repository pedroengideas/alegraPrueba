	<div class="container">
		<div class="col-md-12">
			<div class="panel panel-default panel-flat-default">
				<!-- Default panel contents -->
				<div class="panel-heading panel-flat-header">
					<div class="row">
						<div class="col-sm-12">
							<h4 class="pull-left"><i class="fa fa-users"></i> CONTACTO - <?php echo $contacto[0]['name']; ?></h4>
							<ul class="list-inline pull-right">
								<li class=""><a href="<?php echo base_url(); ?>" class="fa fa-reply-all btn btn-xs"></a></li>
								<li class=""><a data-toggle="collapse" data-target=".list-contact" class="fa fa-arrow-down btn btn-xs"></a></li>
							</ul>
						</div>
					</div>
				</div>
					<div class="panel-body">
						<div class="alert alert-warning">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<strong>Importante!</strong> si se encuentran campos vacios, se recoomienda llenarlos para mayor información de sus datos personales <a class="btn btn-xs accion-edit" href="<?php echo base_url('index.php/alegracontacto/getEditContacto')?>" data-id="<?php echo $contacto[0]['id'];?>" role="button">Editar Contacto</a>
						</div>
						<div class="container-fluid">
							<div class="col-md-4">
								<div class="table-responsive">
									<table class="table table-hover">
										<thead>
											<tr>
												<th colspan="2">DATOS GENERALES</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th>Nombre:</th>
												<td><?php echo $contacto[0]['name']; ?></td>
											</tr>
											<tr>
												<th>Identificación:</th>
												<td><?php echo $contacto[0]['identification']; ?></td>
											</tr>
											<tr>
												<th>Telefono:</th>
												<td><?php echo $contacto[0]['phonePrimary']; ?></td>
											</tr>
											<tr>
												<th>Telefono 2:</th>
												<td><?php echo $contacto[0]['phoneSecondary']; ?></td>
											</tr>
											<tr>
												<th>Celular:</th>
												<td><?php echo $contacto[0]['mobile']; ?></td>
											</tr>
											<tr>
												<th>Telefono:</th>
												<td><?php echo $contacto[0]['phonePrimary']; ?></td>
											</tr>
											<tr>
												<th>Dirección:</th>
												<td><?php echo $contacto[0]['address']['address']; ?></td>
											</tr>
											<tr>
												<th>Ciudad:</th>
												<td><?php echo $contacto[0]['address']['city']; ?></td>
											</tr>
											<tr>
												<th>Correo Electrónico</th>
												<td><?php echo $contacto[0]['email']; ?></td>
											</tr>
											<tr>
												<th>Tipo de contacto:</th>
												<td>
													<?php 
													if($contacto[0]['type']!=null){
													foreach ($contacto[0]['type'] as $typekey => $typevalue) {
															if($typevalue=='client') {
																echo '<span class="label label-success">Cliente</span> ';	
															} else if($typevalue=='provider') {
																echo '<span class="label label-success">Proveedor</span> ';
															}
														}	
													} ?>
													
												</td>
											</tr>
											<tr>
												<th>Lista de precios:</th>
												<td><?php if($contacto[0]['priceList']!=null) {
														if($contacto[0]['priceList']=='1'){
															echo '<span class="label label-primary">General</span>';
														}
													} ?></td>
											</tr>
											<tr>
												<th>Observación:</th>
												<td><?php echo $contacto[0]['observations']; ?></td>
											</tr>
										</tbody>
									</table>
								</div>	
							</div>
						</div>
					</div>
			</div>
		</div>
	</div>
