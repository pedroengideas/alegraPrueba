	<div class="container">
		<div class="col-md-12">
			<div class="panel panel-default panel-flat-default">
				<!-- Default panel contents -->

				<div class="panel-heading panel-flat-header">
					<div class="row">
						<div class="col-sm-12">
							<h4 class="pull-left"><i class="fa fa-users"></i><?php echo $title; ?></h4>
							<ul class="list-inline pull-right">
								<?php echo $link_contacto; ?>
								<li data-toggle="tooltip" title="Regresar al listado de contacto"><a href="<?php echo base_url(); ?>" class="fa fa-reply-all btn btn-xs"></a></li>
								<li class=""><a data-toggle="collapse" data-target=".nuevo-contact" class="fa fa-arrow-down btn btn-xs"></a></li>
							</ul>
						</div>
					</div>
				</div>
					<div class="panel-body nuevo-contact">
						<form action="" method="POST" role="form" id="form-crear-contacto">
							<div class="alert alert-warning">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<strong>Importante!</strong> El campo nombre debe ser obligatorio
							</div>
							<div class="resultado-contacto"></div>
							<div class="container-fluid">
								<div class="col-md-12">

									<div class="container-fluid">
										<div class="row-fluid">
											<legend>DATOS GENERALES DEL CONTACTO</legend>
										</div>

										<div class="container-fluid">
											<div class="col-md-6">
												<div class="form-group">
													<label for="">Nombre (*)</label>
													<input type="text" name="contacto-name" id="contacto-name" class="form-control input-sm" value="<?php echo $contact->name; ?>" required="required" title="Nombre del contacto">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="">Identificación</label>
													<input type="text" name="contacto-identificacion" id="contacto-identificacion" class="form-control input-sm" value="<?php echo $contact->identification; ?>" title="Identificación">
												</div>
											</div>
										</div>

										<div class="container-fluid">

											<div class="col-md-3">
												<div class="form-group">
													<label for="">Telefono 1</label>
													<input type="text" maxlength="15" name="contacto-telefono1" id="contacto-telefono1" class="form-control input-sm" value="<?php echo $contact->phonePrimary; ?>" title="Primer Teléfono">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="">Telefono 2</label>
													<input type="text" maxlength="15" name="contacto-telefono2" id="contacto-telefono2" class="form-control input-sm" value="<?php echo $contact->phoneSecondary; ?>" title="Telefóno 2">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="">Celular</label>
													<input type="text" maxlength="15" name="contacto-celular" id="contacto-celular" class="form-control input-sm" value="<?php echo $contact->mobile; ?>"  title="Telefono celular">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<label for="">Fax</label>
													<input type="text" maxlength="15" name="contacto-fax" id="contacto-fax" class="form-control input-sm" value="<?php echo $contact->mobile; ?>"  title="Fax">
												</div>
											</div>

										</div>

										<div class="container-fluid">
											<div class="col-md-6">
												<div class="form-group">
													<label for="">Dirección</label>
													<?php if($contact->address!=null){ ?>
														<input type="text" name="contacto-direccion" id="contacto-direccion" class="form-control input-sm" value="<?php echo $contact->address->address; ?>" title="Dirección">
													<?php } else { ?>
														<input type="text" name="contacto-direccion" id="contacto-direccion" class="form-control input-sm" value="" title="Dirección">
													<?php }
													?>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="">Ciudad</label>
													<?php if($contact->address!=null){ ?>
														<input type="text" name="contacto-city" id="contacto-city" class="form-control input-sm" value="<?php echo $contact->address->city; ?>" title="Dirección ciudad">
													<?php } else { ?>
														<input type="text" name="contacto-city" id="contacto-city" class="form-control input-sm" value="" title="Dirección ciudad">
													<?php }
													?>
												</div>
											</div>
										</div>

										<div class="container-fluid">
											<div class="col-md-8">
												<div class="form-group">
													<label for="">Correo Electrónico</label>
													<input type="email" name="contacto-email" id="contacto-email" class="form-control input-sm" value="<?php echo $contact->email; ?>" title="Correo Electronico">
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="">Tipo de contacto </label>
													<div class="input-group">
													<?php
														$tipoContacto = str_replace(array('[','"',']',','), ' ',$contact->type); ?>
															<div class="checkbox-inline">
																<label>
																	<input name="contacto-tipo[]" 
																		<?php  if(strpos($tipoContacto, 'client')) {
																			echo 'checked';
																			} ?> type="checkbox" value="client">
																	<span class="label label-success">Cliente</span>
																</label>
															</div>

															<div class="checkbox-inline">
																<label>
																	<input name="contacto-tipo[]" 
																	<?php  if(strpos($tipoContacto, 'provider')) {
																			echo 'checked';
																			} ?> type="checkbox" value="provider">
																	<span class="label label-success">Proveedor</span>
																</label>
															</div>
													</div>
												</div>
											</div>
										</div>

										<div class="container-fluid">
											<div class="col-md-6">
												<div class="form-group">
													<label for="">Lista de precios</label>
													<?php $precio_act = json_decode(json_encode($contact->priceList),true);
													 ?>

													<select name="contacto-precios" id="contacto-precios" class="form-control input-sm">
														<option value="">Ninguno</option>
														<?php
														if($precio_act!=null){
															foreach ($precios as $prekey => $prevalue) { ?>
																<option <?php if($precio_act['id']==$prevalue['id']){ echo 'selected'; }
																 ?> value="<?php echo $prevalue['id'];?>"><?php echo $prevalue['name'];?></option>
															<?php }				
														} else {

															foreach ($precios as $prekey => $prevalue) { ?>
																<option value="<?php echo $prevalue['id'];?>"><?php echo $prevalue['name'];?></option>
															<?php }	
														}
														?>
													</select>
												</div>
											</div>
										</div>

										<div class="container-fluid">
											<div class="col-md-12">
												<div class="form-group">
													<label for="">Observación</label>
													<textarea name="contacto-observacion" id="contacto-observacion" class="form-control input-sm" rows="3"><?php echo $contact->observations; ?></textarea>
												</div>
											</div>
										</div>

									</div>

								</div>
							</div>
						</form>
					</div>
				<div class="panel-footer panel-flat-header">
					<div class="row">
						<div class="col-sm-12">
							<h4 class="pull-left"><i class="fa fa-users"></i><?php echo $title; ?></h4>
							<ul class="list-inline pull-right">
								<li class=""><?php echo $link_contacto; ?></li>
								<li data-toggle="tooltip" title="Regresar al listado de contacto"><a href="<?php echo base_url(); ?>" class="fa fa-reply-all btn btn-xs"></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>