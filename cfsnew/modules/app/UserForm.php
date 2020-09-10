<?php

//incluimos fichero de configuración
//include('conf.php');
require_once(MODULES_DIR.'User.php');
require_once(MODULES_DIR.'Profile.php');

class UserForm extends ModuleForm {

    var $currentFormModule = "User";

	function UserForm($formName,$formMethod,$mainParamName,$formTemplateName) {
		
		ModuleForm::ModuleForm();

		$this->doForm($formName,$formMethod,$mainParamName,$formTemplateName);
				
	}
	
	function addFormElements() {
		
		$profile = new Profile();
		
		$this->currentForm->lang="es";

		//creamos los campos del formulario
		$this->currentForm->addElement('header', '', 'usuarios');
		$this->currentForm->addElement('hidden', 'usr_ID');
		$this->currentForm->addElement('text', 'usr_firstname', 'nombre','size="50"');
		$this->currentForm->addElement('text', 'usr_lastname', 'apellidos','size="50"');
		$this->currentForm->addElement('text', 'usr_occupation', 'cargo','size="50"');
		$this->currentForm->addElement('text', 'usr_login', 'login','size="20"');
		$this->currentForm->addElement('password', 'usr_password', 'password','size="20"');
		$this->currentForm->addElement('password', 'confirm_password', 'confirm_password','size="20"');
		$this->currentForm->addElement('text', 'usr_email', 'email','size="50"');
		$this->currentForm->addElement('select', 'usr_profilefk','perfil',$profile->getFullList("1","2000",array("pro_ID","pro_name"),"","","assoc"));
		$this->currentForm->addElement('hidden', 'usr_lastaccess');
		$this->currentForm->addElement('hidden', 'usr_failedlogs');
		$this->currentForm->addElement('hidden', 'usr_languageFK');
		
		$this->currentForm->addElement('image', null, ADMIN_IMG_DIR.'save_'.$this->currentForm->lang.'.gif');
		
		//print_R($this->currentForm->_elements);

		function checkLogin($fields){
    		$user = new User();
			
			$fields['usr_ID'] = (strlen($fields['usr_ID'])) ? $fields['usr_ID'] : -1;
			
			if(count($user->getFullList("1","1",array("usr_ID"),"usr_login='".$fields['usr_login']."' and usr_ID<>".$fields['usr_ID']))>0)
				return array('usr_login' => 'login_existe');
			else
				return true;
		}
	
		function cmpPass($fields)
		{
			if (strlen($fields['usr_password']) && strlen($fields['confirm_password']) && 
				$fields['usr_password'] != $fields['confirm_password']) {
				return array('usr_password' => 'password_diferentes');
			}
			return true;
		}

		
		
		//validacions
		$this->currentForm->addRule('usr_firstname', 'nombre_obligatorio', 'required', null,'client');
		$this->currentForm->addRule('usr_login', 'login_obligatorio', 'required', null,'client');
		$this->currentForm->addRule('usr_password', 'password_obligatorio', 'required', null,'client');
		$this->currentForm->addRule('confirm_password', 'confirm_obligatorio', 'required', null,'client');
		$this->currentForm->addRule('usr_email', 'email_erroneo', 'email', null,'client');
		
		$this->currentForm->addFormRule('cmpPass');
		$this->currentForm->addFormRule('checkLogin');
					
	}
	
	function setFormValues($ID){
		
		if(strlen($ID)){
			
			$user = new User();
			$user->select($ID);
			
			$values = array();
			
			
			$values = $user->elements;
			// Afegit per Ramon
			$values['confirm_password'] = $values['usr_password'];
			$values["usr_profilefk"] = array($user->elements["usr_profilefk"]);
			// Fi afegit per Ramon
			return $values;
		}
		else{
		
			$values = array();
			return $values;
		}
	}
	
	function updateFormValues() {

		$formArray = $this->currentForm->toArray();
		$formElements = $formArray[sections][0][elements];
		
		$updateValues = array();

		//Recibimos los elementos del formulario y sus valores en $formArray
		for($i=0;$i<count($formElements);$i++)
		{
			//Para cada elemento del formulario asignamos su valor a un array para el update
			if(trim($formElements[$i]["name"]) != "")		    
				
				//tratamos los select
				$value = ($formElements[$i]["type"]=="select") ? $formElements[$i]["value"][0] : $formElements[$i]["value"];

				$updateValues[$formElements[$i]["name"]] = $value;
		}
		
		$user = new User();
		$user->update($updateValues);
		
		// Faltaria els updates d'altres taules si calgués
	}
		
}

?>