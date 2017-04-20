<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Clase encargada de realizar la gestión de contactos
 *
 * @package Alegracontacto
 * @author Pedro Velasquez
 */

/**
 *  clases que llaman a los metodos y funciones encargados de cargar 
 * las acciones de la api de alegra.
 */

use Alegra\Api as Api;
use Alegra\Contact as Contact; 
use Alegra\PriceList as Precios;
use Alegra\Term as Terminos;
use Alegra\Seller as Seller;
use Alegra\Resource as Resource;
use Alegra\Support\Address as Address;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

class Alegracontacto extends CI_Controller {

	/**
	 * recarga la funcion padre del controlador, cargamos las librerias que va autilizar el controlador
	 * asi mismo cargamos la clase que nos autoriza a entrar en el api de alegra.
	 *
	 * @return void
	 * @author Pedro velasquez 
	 */

	public function __construct()
	{
		parent::__construct();
		$this->CI = & get_instance();
		$this->CI->load->config('alegraapi');
		Api::auth($this->CI->config->item('user_alegra_api'),$this->CI->config->item('token_alegra_api'));

        $this->form_validation->set_message('required', 'Por favor completa este campo %s.');
        $this->form_validation->set_message('min_length', 'El campo %s debe ser de al menos %s caracteres.');
        $this->form_validation->set_message('valid_email', 'Debe escribir una direccion de email correcta.');
        $this->form_validation->set_message('matches', 'Los campos %s y %s no coinciden.');
        $this->form_validation->set_message('alpha_dash', 'Solo letras permitidas en el campo %s.');
        $this->form_validation->set_message('alpha', 'Solo letras permitidas en el campo %s.');
        $this->form_validation->set_message('is_natural', 'Solo números permitidos en el campo %s.');
        $this->form_validation->set_message('numeric', 'Solo números permitidos en el campo %s.');
        $this->form_validation->set_message('max_length', 'El campo %s Debe tener un máximo de %s caracteres.');

			// try {
			//     // // Save using create method

			//     // $contact = Contact::create(['name' => 'Your contact name']); // Create the contact

			//     // // Save using instance
			//     // $contact = new Contact;
			//     // $contact->name = 'My second contact';
			//     // $contact->save(); // Update the contact

			//     // // Update an existing contact

			//     // $contact = Contact::get(1); // where 1 is the id of resource.
			//     // $contact->identification = '900.123.123-8';
			//     // $contact->email = 'email@server.com';
			//     // $contact->save();

			//     // Get all contacts
			// 	echo '<pre>';
			//     $contacts = Contact::all();
			//     $contacts->each(function ($contact) {
			//         print_r(json_decode($contact,true));
			//     });

			//     // Get a delete

			//     //$contact = Contact::get(1);
			//     //$contact->delete();

			//     // Delete without get

			//    // $contact = new Contact(1);
			//     //$contact->delete();

			//     // Delete using static interface

			//     //Contact::delete(1);

			// } catch (ClientException $e) { // 4.x
			//     echo 'Hemos detectado un error '.$e;
			// } catch (ServerException $e) { // 5.x
			//     echo 'Hemos detectado un error '.$e;
			// } catch (ConnectException $e) {
			//     echo 'Hemos detectado un error '.$e;
			// } catch (RequestException $e) {
			//     echo 'Hemos detectado un error '.$e;
			// } catch (Exception $e) {
			//     echo 'Hemos detectado un error '.$e;
			// }

	}

	/**
	 * es el index el metodo que carga la vista principal del sistema contacto.
	 * carga el header y el footer de la aplicación. para este metodo se podria utilizar un
	 * gestor de plantillas ya sea twing o blade, 
	 *
	 * @return void
	 * @author Pedro Velasqiez 
	 */

	public function index(){

        $head = array(
        	'title'=>'Principal',
        	'description' => 'Contactos',
        	'url_compartir' => base_url()
        	);
        $this->load->view('header',$head);
		$this->load->view('vistaContacto');
		$this->load->view('footer');

	}

	/**
	 * metodo que se encarga de mostrar la vista y el formulario donde el usuario 
	 * podra registrar un contacto.
	 *
	 * @return void
	 * @author Pedro Velasquez
	 */

	public function getCrearContacto(){

		try {

			$data['accion'] = 1;

			$data['title'] = ' NUEVO CONTACTO';

			$data['link_contacto'] = '<li class=""><a href="#" title="Agregar y crear otro contacto" class="btn btn-xs agregar-contacto-otro" id="agregar-contacto-otro" data-tipo="1">Agregar y crear otro contacto</a></li> <li class=""><a href="#" title="Agregar un nuevo contacto" class="btn btn-xs agregar-contacto" id="agregar-contacto" data-tipo="2">Agregar Contacto</a></li>';

			$contact = new Contact;

			$precios = Precios::all();
			$precioss = json_decode(json_encode($precios),true);

			$data['contact'] = $contact;
			$data['precios'] = $precioss;
			$json['vista'] = $this->load->view('crearEditContacto',$data,true);

		} catch (ClientException $e) { // 4.x
			$json['vista'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		} catch (ServerException $e) { // 5.x
		    $json['vista'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		} catch (ConnectException $e) {
		    $json['vista'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		} catch (RequestException $e) {
		    $json['vista'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		} catch (Exception $e) {
		    $json['vista'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		}

		echo json_encode($json);

	}

	public function processCrearContacto(){

		//print_r($this->input->post());
		//exit();

		$this->form_validation->set_rules('contacto-name', 'Nombre *', 'trim|required');
		$this->form_validation->set_rules('contacto-identificacion', 'identificador', 'trim');
		$this->form_validation->set_rules('contacto-email', 'Correo Electronico', 'trim|valid_email');
		$this->form_validation->set_rules('contacto-telefono1', 'Telefono 1', 'trim|numeric|max_length[12]');
		$this->form_validation->set_rules('contacto-telefono2', 'Telefono 2', 'trim|numeric|max_length[12]');
		$this->form_validation->set_rules('contacto-celular', 'Telefono celular', 'trim|numeric|max_length[12]');
		$this->form_validation->set_rules('contacto-fax', 'Fax', 'trim|numeric|max_length[12]');
		$this->form_validation->set_rules('contacto-observacion', 'Observación', 'trim|max_length[400]');

		//$this->form_validation->set_rules('periodo-recibo', 'Selecione un periodo', 'trim|required');
			//echo strtotime($ano_mes);
			$json['exito'] = 'e';

		try {

			if($this->form_validation->run() == TRUE){

			    //GUARDA UN CONTACTO EN EL SISTEMA

			    $contact = new Contact;
			    $contact->name = $this->input->post('contacto-name',TRUE);            
		        $contact->identification = $this->input->post('contacto-identificacion',TRUE);
		        $contact->email = $this->input->post('contacto-email',TRUE);
		        $contact->phonePrimary = $this->input->post('contacto-telefono1',TRUE);
		        $contact->phoneSecondary = $this->input->post('contacto-telefono2',TRUE);
		        $contact->fax = $this->input->post('contacto-fax',TRUE);
		        $contact->mobile = $this->input->post('contacto-celular',TRUE);
		        $contact->observations = $this->input->post('contacto-observacion',TRUE);
		        $contact->address->address = $this->input->post('contacto-direccion',TRUE);
		        $contact->address->city = $this->input->post('contacto-city',TRUE);
		        if($this->input->post('contacto-tipo',TRUE)==null){
		        	$contact->type = array();
		        } else {
		        	$contact->type = $this->input->post('contacto-tipo',TRUE);
		        }
		        if($this->input->post('contacto-precios')!=null || $this->input->post('contacto-precios')!=''){
		        	$contact->priceList = $this->input->post('contacto-precios');
		        } else {
		        	$contact->priceList = array();
		        }
		        //($this->input->post('tipo-cliente',TRUE)) ? $this->input->post('tipo-cliente',TRUE) : array();//$this->input->post('contacto-name');
		        //$contact->seller = $this->input->post('contacto-name');
		        //$contact->term = $this->input->post('contacto-name');
		        //$contact->priceList = $this->input->post('contacto-name');

			    $contact->save(); // Update the contact

				$json['exito'] = 'b';
				$json['vista'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>muy bien!</strong> El contacto se ha agregado con exito</div>';

			} else {

				$json['exito'] = 'e';
				$json['vista'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Importante!</strong> '.str_replace("\n", "", validation_errors('<div>', '</div><p></p>')).'</div>';

			}

		} catch (ClientException $e) { // 4.x
			$json['vista'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Hemos detectado un error '.$e.'</div>';
		} catch (ServerException $e) { // 5.x
		    $json['vista'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Hemos detectado un error '.$e.'</div>';
		} catch (ConnectException $e) {
		    $json['vista'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Hemos detectado un error '.$e.'</div>';
		} catch (RequestException $e) {
		    $json['vista'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Hemos detectado un error '.$e.'</div>';
		} catch (Exception $e) {
		    $json['vista'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Hemos detectado un error '.$e.'</div>';
		}

		echo json_encode($json);

	}

	/**
	 * metodo que se encarga de mostrar la vista donde el usuario podra editar 
	 * un contacto
	 *
	 * @return void
	 * @author Pedro Velasquez
	 */

	public function getEditContacto(){

		try {

			$data['accion'] = 2;

			$data['title'] = ' EDITAR CONTACTO';

			$idContacto = $this->input->get('idcontacto');

			$contact = Contact::get($idContacto);
			$precios = Precios::all();
			$precioss = json_decode(json_encode($precios),true);
			$data['precios'] = $precioss;

			$data['link_contacto'] = '<li class=""><a href="'.$contact->id.'" title="Editar un contacto" class="btn btn-xs editars-contacto" id="editars-contacto">Editaar Contacto</a></li>';

			$data['contact'] = $contact;

			$json['vista'] = $this->load->view('crearEditContacto',$data,true);

		} catch (ClientException $e) { // 4.x
			$json['vista'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		} catch (ServerException $e) { // 5.x
		    $json['vista'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		} catch (ConnectException $e) {
		    $json['vista'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		} catch (RequestException $e) {
		    $json['vista'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		} catch (Exception $e) {
		    $json['vista'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		}

		echo json_encode($json);

	}

	public function processEditarContacto($idcontac){

		$this->form_validation->set_rules('contacto-name', 'Nombre *', 'trim|required');
		$this->form_validation->set_rules('contacto-identificacion', 'identificador', 'trim');
		$this->form_validation->set_rules('contacto-email', 'Correo Electronico', 'trim|valid_email');
		$this->form_validation->set_rules('contacto-telefono1', 'Telefono 1', 'trim|numeric|max_length[12]');
		$this->form_validation->set_rules('contacto-telefono2', 'Telefono 2', 'trim|numeric|max_length[12]');
		$this->form_validation->set_rules('contacto-celular', 'Telefono celular', 'trim|numeric|max_length[12]');
		$this->form_validation->set_rules('contacto-fax', 'Fax', 'trim|numeric|max_length[12]');
		$this->form_validation->set_rules('contacto-observacion', 'Observación', 'trim|max_length[400]');

		//$this->form_validation->set_rules('periodo-recibo', 'Selecione un periodo', 'trim|required');
			//echo strtotime($ano_mes);
			$json['exito'] = 'e';

		try {

			if($this->form_validation->run() == TRUE){

			    //GUARDA UN CONTACTO EN EL SISTEMA

			    $contact = Contact::get($idcontac);
			    $contact->name = $this->input->post('contacto-name',TRUE);            
		        $contact->identification = $this->input->post('contacto-identificacion',TRUE);
		        $contact->email = $this->input->post('contacto-email',TRUE);
		        $contact->phonePrimary = $this->input->post('contacto-telefono1',TRUE);
		        $contact->phoneSecondary = $this->input->post('contacto-telefono2',TRUE);
		        $contact->fax = $this->input->post('contacto-fax',TRUE);
		        $contact->mobile = $this->input->post('contacto-celular',TRUE);
		        $contact->observations = $this->input->post('contacto-observacion',TRUE);

		        $contact->address->address = $this->input->post('contacto-direccion',TRUE);
		        $contact->address->city = $this->input->post('contacto-city',TRUE);

		        if($this->input->post('contacto-tipo',TRUE)==null){
		        	$contact->type = array();
		        } else {
		        	$contact->type = $this->input->post('contacto-tipo',TRUE);
		        }
		        if($this->input->post('contacto-precios')!=null || $this->input->post('contacto-precios')!=''){
		        	$contact->priceList = $this->input->post('contacto-precios');
		        } else {
		        	$contact->priceList = array();
		        }
		        
			    $contact->save(); // Update the contact

				$json['exito'] = 'b';
				$json['vista'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>muy bien!</strong> El contacto se ha agregado con exito</div>';

			} else {

				$json['exito'] = 'e';
				$json['vista'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Importante!</strong> '.str_replace("\n", "", validation_errors('<div>', '</div><p></p>')).'</div>';

			}

		} catch (ClientException $e) { // 4.x
			$json['vista'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Hemos detectado un error '.$e.'</div>';
		} catch (ServerException $e) { // 5.x
		    $json['vista'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Hemos detectado un error '.$e.'</div>';
		} catch (ConnectException $e) {
		    $json['vista'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Hemos detectado un error '.$e.'</div>';
		} catch (RequestException $e) {
		    $json['vista'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Hemos detectado un error '.$e.'</div>';
		} catch (Exception $e) {
		    $json['vista'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Hemos detectado un error '.$e.'</div>';
		}

		echo json_encode($json);

	}

	/**
	 * función encargada de mostrar la vista del listado de contactos
	 *
	 * @return void
	 * @author Pedro Velasquez
	 */

	public function getListadoContacto(){

		$json['vista'] = $this->load->view('listadoContacto',null,true);

		echo json_encode($json);

	}

	/**
	 * función que se encarga de formatear los datos que van hacer leidos 
	 * en la función de javascript del DataTable, esta función es llamada 
	 * a través de un evento ajax en la función del datatable
	 *
	 * @return void
	 * @author Pedro Velasquez
	 */

	public function getListadoTable(){

		try {

			//$tipoContacto = 

		    $contacts = Contact::all();
		    foreach ($contacts as $key => $value) {
		        $contactos[] = json_decode($value,true);
		    }
		    //echo '<pre>';
		    //print_r($contactos);

		    $json['data'] = $contactos;

		} catch (ClientException $e) { // 4.x
			$json['data'] = 'Hemos detectado un error '.$e;
		} catch (ServerException $e) { // 5.x
		    $json['data'] = 'Hemos detectado un error '.$e;
		} catch (ConnectException $e) {
		    $json['data'] = 'Hemos detectado un error '.$e;
		} catch (RequestException $e) {
		    $json['data'] = 'Hemos detectado un error '.$e;
		} catch (Exception $e) {
		    $json['data'] = 'Hemos detectado un error '.$e;
		}

		echo json_encode($json);

	}

	/**
	 * metodo encargado de eliminar a un contacto en especifico, seleccionado en la tabla
	 * de contactos.
	 *
	 * @return void
	 * @author Pedro Velasquez
	 */

	public function getEliminarContacto(){


		try {

			$idContacto = $this->input->post('idcontacto');
			$contact = Contact::get($idContacto);
			$contact->delete();

			$json['data'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Se ha eliminado el usuario con exito</div>';

		} catch (ClientException $e) { // 4.x
			$json['data'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		} catch (ServerException $e) { // 5.x
		    $json['data'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		} catch (ConnectException $e) {
		    $json['data'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		} catch (RequestException $e) {
		    $json['data'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		} catch (Exception $e) {
		    $json['data'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		}

		echo json_encode($json);

	}

	public function getEliminarTodosContacto(){


		try {

			$json['exito'] = 'e';
			if($this->input->post('check-contact')==null){
				throw new Exception("Debe seleccionar al menos un contacto", 1);
				
			} else {

				$idContacto = $this->input->post('check-contact');
				foreach ($idContacto as $idckey => $idcvalue) {
					$contact = Contact::get($idcvalue);
					$contact->delete();
				}

				$json['exito'] = 'b';
				$json['data'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Se ha eliminado el usuario con exito</div>';


			}

		} catch (ClientException $e) { // 4.x
			$json['data'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Hemos detectado un error '.$e.'</div>';
		} catch (ServerException $e) { // 5.x
		    $json['data'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Hemos detectado un error '.$e.'</div>';
		} catch (ConnectException $e) {
		    $json['data'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Hemos detectado un error '.$e.'</div>';
		} catch (RequestException $e) {
		    $json['data'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Hemos detectado un error '.$e.'</div>';
		} catch (Exception $e) {
		    $json['data'] = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Hemos detectado un error Debes seleccionar al menos un contacto</div>';
		}

		echo json_encode($json);

	}

	/**
	 * metodo encargado de ver o visualizar a un contacto en particular.
	 *
	 * @return void
	 * @author Pedro Velasquez
	 */

	public function getVerContacto(){

		try {

			$idContacto = $this->input->get('idcontacto');
			$contact = Contact::get($idContacto);

			$verContacto = json_decode(json_encode(array($contact)),true);

			$data['contacto'] = $verContacto;

			$json['vista'] = $this->load->view('verContacto',$data,true);

		} catch (ClientException $e) { // 4.x
			$json['vista'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		} catch (ServerException $e) { // 5.x
		    $json['vista'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		} catch (ConnectException $e) {
		    $json['vista'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		} catch (RequestException $e) {
		    $json['vista'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		} catch (Exception $e) {
		    $json['vista'] = '<div class="alert alert-danger"> Hemos detectado un error '.$e.'</div>';
		}

		echo json_encode($json);

	}

}

/* in del archivof  */
/* Location: ./application/modules/alegracontacto/controllers/ */