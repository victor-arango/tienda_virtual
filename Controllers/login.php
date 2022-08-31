<?php 

	class login extends Controllers{
		public function __construct()
		{
			//VALIDACION DE SESSION INICIADA Y REDIRECCIONAMIENTO HACIA LA URL DASHBOARD 
			session_start();
			if(isset($_SESSION['login']))
			{
				header('location: '.base_url().'/dashboard');
			}
			
			parent::__construct();
		}

		public function login()
		{
			
			$data['page_tag'] = "login";
			$data['page_title'] = "login - tienda virtual";
			$data['page_name'] = "login";
			$data['page_functions_js'] = "functions_login.js";
			$this->views->getView($this,"login",$data);
		}
		// METODO PARA LA VALIDACION DE DATOS CORRESPONDIENTES A LA BASE DE DATOS 
		public function loginUser(){
			//dep($_POST);
			if($_POST){
				if(empty($_POST['txtEmail']) || empty($_POST['txtPassword'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de datos' );
				}else{
					$strUsuario  =  strtolower(strClean($_POST['txtEmail']));
					$strPassword = hash("SHA256",$_POST['txtPassword']);
					$requestUser = $this->model->loginUser($strUsuario, $strPassword);
					if(empty($requestUser)){
						$arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecto.' ); 
					}else{
						$arrData = $requestUser;
						if($arrData['status'] == 1){
							$_SESSION['idUser'] = $arrData['idpersona'];
							$_SESSION['login'] = true;
							$arrData = $this->model->sessionLogin($_SESSION['idUser']);
							sessionUser($_SESSION['idUser']);
							$arrResponse = array('status' => true, 'msg' => 'ok');
						}else{
							$arrResponse = array('status' => false, 'msg' => 'Usuario inactivo.');
						}
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function resetPass(){
			if($_POST){
				error_reporting(0);
				if(empty($_POST['txtEmailReset'])){
					$arrResponse = array('status' => false, 'msg' => 'Error en los datos.');
				}else {
					$token = token();
					$strEmail = strtolower(strClean($_POST['txtEmailReset']));
					$arrData = $this->model->getUserEmail($strEmail);

					if(empty($arrData)){
						$arrResponse = array('status' => false, 'msg' => 'Usuario no encontrado.');
					}else {
						$idpersona = $arrData['idpersona'];
						$nombreUsuario = $arrData['nombres'].' '.$arrData['apellidos'];

						$url_recovery = base_url().'/login/confirmUser/'.$strEmail.'/'.$token;
						$requestUpdate =  $this->model->setTokenUser($idpersona,$token);
// METODO PARA EL ENVIO DE CORREO ELECTRONICO A LOS USUARIOS PARA CAMBIO DE CONTRASEÑA
						$dataUsuario = array('nombreUsuario' => $nombreUsuario,
											'email' =>$strEmail,
											'asunto' =>'Recuperar cuenta -'.NOMBRE_REMITENTE,
											'url_recovery' => $url_recovery);

						if($requestUpdate){

							$SendEmail = sendEmail($dataUsuario,'email_cambioPassword');

							if($SendEmail){
								$arrResponse = array('status' => true, 'msg' => 'se ha enviado un email a tu cuenta de correo electrónico para cambiar tu contraseña.');
							}else {
								$arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta más tarde.');
							}
							
						}else{
							
						}
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
// verificamos que el usuario que realizo la peticion si coincida con el usuario 
		public function confirmUser(string $params){

			if(empty($params)){
				header('location: ',base_url());
			}else {
				$arrParams = explode(',',$params);
				$strEmail = strClean($arrParams[0]);
				$strToken = strClean($arrParams[1]);
				
				$arrResponse =$this->model->getUsuario($strEmail,$strToken);
				if(empty($arrResponse)){
					header("location: ".base_url());
				}else{
					$data['page_tag'] = "Cambiar contraseña";
					$data['page_title'] = "cambiar contraseña";
					$data['email'] = $strEmail;
					$data['token'] = $strToken;
					$data['page_name'] = "cambiar_contrasenia";
					$data['idpersona'] =$arrResponse['idpersona'];
					$data['page_functions_js'] = "functions_login.js";
					$this->views->getview($this,"cambiar_password",$data);
				}

			}
			die();

		}

		public function setPassword(){

			if(empty($_POST['idUsuario']) || empty($_POST['txtEmail']) || empty($_POST['txtToken']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm'])){

					$arrResponse = array('status' => false, 'msg' => 'Error de datos' );										
				}else{
					$intIdpersona = intval($_POST['idUsuario']);
					$strPassword = $_POST['txtPassword'];
					$strPasswordConfirm = $_POST['txtPasswordConfirm'];
					$strEmail = strClean($_POST['txtEmail']);
					$strToken = strClean($_POST['txtToken']);

					if($strPassword != $strPasswordConfirm){
						$arrResponse = array('status' => false, 
											 'msg' => 'Las contraseñas no son iguales.' );
					}else{
						$arrResponseUser = $this->model->getUsuario($strEmail,$strToken);
						if(empty($arrResponseUser)){
							$arrResponse = array('status' => false, 
											 'msg' => 'Erro de datos.' );
						}else{
							$strPassword = hash("SHA256",$strPassword);
							$requestPass = $this->model->insertPassword($intIdpersona,$strPassword);

							if($requestPass){
								$arrResponse = array('status' => true, 
													 'msg' => 'Contraseña actualizada con éxito.');
							}else{
								$arrResponse = array('status' => false, 
													 'msg' => 'No es posible realizar el proceso, intente más tarde.');
							}
						}
					}
				}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

	}
	
 ?>