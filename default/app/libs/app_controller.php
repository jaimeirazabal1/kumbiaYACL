<?php
/**
 * @see Controller nuevo controller
 */
require_once CORE_PATH . 'kumbia/controller.php';

/**
 * Controlador principal que heredan los controladores
 *
 * Todas las controladores heredan de esta clase en un nivel superior
 * por lo tanto los metodos aqui definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 */
class AppController extends Controller
{

    public $acl; //variable objeto ACL
	public $userRol = ""; //variable con el rol del usuario autenticado en la aplicación
 
	final protected function initialize(){

		if(Auth::is_valid()) $this->userRol = Auth::get("rol");
 
		$this->acl = new Acl();
		//Se agregan los roles
		$this->acl->add_role(new AclRole("")); // Visitantes
		$this->acl->add_role(new AclRole("A")); // Administradores
		$this->acl->add_role(new AclRole("U")); // Usuarios
 
		//Se agregan los recursos
		$this->acl->add_resource(new AclResource("index"), 'index','crear','lista');
		$this->acl->add_resource(new AclResource("test"), "index");
 
		//Se crean los permisos
		 // Inicio
		$this->acl->allow("", "index", array("index","crear","lista"));
		$this->acl->allow("U", "index", array("index","crear","lista"));
		 // Test
		$this->acl->allow("U", "test", array("index"));
	}
 
	final protected function finalize()
	{

	}
	protected function before_filter(){
		// Verificando si el rol del usuario actual tiene permisos para la acción a ejecutar
		if(!$this->acl->is_allowed($this->userRol, $this->controller_name, $this->action_name)){
			Flash::error("Acceso negado");
			return false;
		}
	}

}
