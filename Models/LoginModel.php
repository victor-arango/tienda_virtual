<?php 

	class LoginModel extends Mysql
	{
        private $intIdUsuario;
        private $strUsuario;
        private $strPassword;
        private $strToken;

		public function __construct()
		{
			parent::__construct();
		}	


        //METODO PARA VERIFICAR SI EL USUARIO SE ENCUENTRA EN LA BASE DE DATOS 

        public function LoginUser(string $usuario, string $password)
        {
            $this->strUsuario = $usuario;
            $this->strPassword = $password;
             $sql = "SELECT idpersona,status FROM persona WHERE 
                    email_user = '$this->strUsuario' AND
                    password = '$this->strPassword' AND
                    status !=0 ";
            $request = $this->select($sql);
            return $request;
        }

        public function sessionLogin(int $iduser){
            $this->intIdUsuario =$iduser;
            // BUSCA EL ROL DEL USUARIO PARA DELIMITAR LAS ACCIONES QUE PUEDE REALIZAR EN EL SITIO
            $sql = "SELECT p.idpersona,
							p.identificacion,
							p.nombres,
							p.apellidos,
							p.telefono,
							p.email_user,
							p.nit,
							p.nombrefiscal,
							p.direccionfiscal,
							r.idrol,r.nombrerol,
							p.status 
					FROM persona p
					INNER JOIN rol r
					ON p.rolid = r.idrol
					WHERE p.idpersona = $this->intIdUsuario";
			$request = $this->select($sql);
			$_SESSION['userData'] = $request;
			return $request;
		}

        public function getUserEmail(string $strEmail){
            $this->strUsuario =$strEmail;
            $sql ="SELECT idpersona,nombres,apellidos,status FROM persona WHERE email_user = '$this->strUsuario' AND status = 1";
            $request =  $this->select($sql);
            return $request;

        }
        // METODO PARA ENVIAR TOKEN A LA BASE DE DATOS PARA LUEGO VALIDARLO DESDE LA MISMA CON LA RESPUESTA DEL CORREO ELECTRONICO 
        public function setTokenUser(int $idpersona, string $token){
			$this->intIdUsuario = $idpersona;
			$this->strToken = $token;
			$sql = "UPDATE persona SET token = ? WHERE idpersona = $this->intIdUsuario ";
			$arrData = array($this->strToken);
			$request = $this->update($sql,$arrData);
			return $request;
		}

        //METODO PARA VALIDAR QUE EL TOKEN SI CORRESPONDA AL USUARIO
        public function getUsuario(string $email, string $token){
			$this->strUsuario = $email;
			$this->strToken = $token;
			$sql = "SELECT idpersona FROM persona WHERE 
					email_user = '$this->strUsuario' and 
					token = '$this->strToken' and 					
					status = 1 ";
			$request = $this->select($sql);
			return $request;
		}


        //METODO PARA LA INSERCCION DE LA NUEVA CONTRASEÑA EN LA BASE DE DATOS 

		public function insertPassword(int $idPersona, string $password){
			$this->intIdUsuario = $idPersona;
			$this->strPassword = $password;
			$sql = "UPDATE persona SET password = ?, token = ? WHERE idpersona = $this->intIdUsuario ";
			$arrData = array($this->strPassword,"");
			$request = $this->update($sql,$arrData);
			return $request;

        }
	}



 ?>