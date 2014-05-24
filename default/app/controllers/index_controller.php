<?php

/**
 * Controller por defecto si no se usa el routes
 * 
 */
class IndexController extends AppController
{

    public function index()
    {
       
    
            if (Input::haspost('usuario')){

            	$user = Input::post("usuario");

				$usuario = $user['nombreusuario'];

				$pwd = md5($user['password']);

	            $auth = new Auth("model", "class: usuario", "nombreusuario: $usuario", "password: $pwd");
	 
	            if ($auth->authenticate()){
	                Flash::success("Correcto");
	            } 
	            else{
	                Flash::error("Falló");
                }
	        }
	    
    }
    public function lista(){
        $this->usuario = Load::model("usuario")->find('order: creado desc');
    }
    public function crear(){
    	if (Input::haspost('usuario')) {
    		$usuario = Load::model('usuario',Input::post('usuario'));
    		$usuario->password = md5($usuario->password);
    		$usuario->creado = date('Y-m-d H:i:s');
    		$usuario->rol = "U";
    		if ($usuario->save()) {
    			Flash::valid('Usuario registrado');
    		}else{
    			Flash::error('Usuario no registrado');
    		}
    	}
    }
    public function editar($id){
    	if (Input::haspost('usuario')) {
    		$usuario = Load::model('usuario',Input::post('usuario'));
    		if ($usuario->update()) {
    			Flash::valid('Usuario Editado');
    		}else{
    			Flash::error('Usuario no Editado');
    		}
    	}
    	$this->usuario = Load::model('usuario')->find($id);
    }
    public function eliminar($id){
    	if (Input::haspost('usuario')) {
    		$usuario = Load::model('usuario')->find($id);
    		if ($usuario->delete()) {
    			Flash::valid('Usuario Eliminado');
    		}else{
    			Flash::error('Usuario no Eliminado');
    		}
    	}
    }
    /*Prueba de edición de codigo*/
}
