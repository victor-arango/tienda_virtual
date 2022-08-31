<?php 

	class Productos extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			//ELIMINA LOS ID DE LAS COOKIES PARA GENERAR UNO NUEVO 
			session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('location: '.base_url().'/login');
			}
		
			getPermisos(4);
		}

		public function Productos()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			
			$data['page_tag'] = "Productos";
			$data['page_title'] = "Productos <small>Tienda virtual</small>";
			$data['page_name'] = "productos";
			$data['page_functions_js'] = "function_productos.js";
			$this->views->getView($this,"productos",$data);
		}

		//METODO OBTIENE LOS PRODUCTOS 
		public function getProductos()
		{
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectProductos();
				for ($i=0; $i < count($arrData); $i++) {
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}
					$arrData[$i]['precio'] =SMONEY.' '.formatMoney($arrData[$i]['precio']);

					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['idproducto'].')" title="Ver Producto"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['idproducto'].')" title="Editar Producto"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){	
						$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['idproducto'].')" title="Eliminar Producto"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}


		//ESTE METODO GUARDA LOS DATOS QUE SE INGRESEN EN EL FORMULARIO DE PRODUCTOS 
		public function setProducto(){
			if($_POST){
				if(empty($_POST['txtNombre']) || empty($_POST['txtCodigo']) || empty($_POST['listCategoria']) || empty($_POST['txtPrecio']) || empty($_POST['listStatus']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					
					$idProducto = intval($_POST['idProducto']);
					$strNombre = strClean($_POST['txtNombre']);
					$strDescripcion = strClean($_POST['txtDescripcion']);
					$strCodigo = strClean($_POST['txtCodigo']);
					$intCategoriaId = intval($_POST['listCategoria']);
					$strPrecio = strClean($_POST['txtPrecio']);
					$intStock = intval($_POST['txtStock']);
					$intStatus = intval($_POST['listStatus']);
					$request_producto = "";

					$ruta = strtolower(clear_cadena($strNombre));
					$ruta = str_replace(" ","-",$ruta);

					if($idProducto == 0)
					{
						$option = 1;
						if($_SESSION['permisosMod']['w']){
							$request_producto = $this->model->insertProducto($strNombre, 
																		$strDescripcion, 
																		$strCodigo, 
																		$intCategoriaId,
																		$strPrecio, 
																		$intStock,
																		$ruta,
																		$intStatus );
						}
					}else{
						$option = 2;
						if($_SESSION['permisosMod']['u']){
							$request_producto = $this->model->updateProducto($idProducto,
																		$strNombre,
																		$strDescripcion, 
																		$strCodigo, 
																		$intCategoriaId,
																		$strPrecio, 
																		$intStock, 
																		$ruta,
																		$intStatus);
						}
					}
					if($request_producto > 0 )
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'idproducto' => $request_producto, 'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'idproducto' => $idProducto, 'msg' => 'Datos Actualizados correctamente.');
						}
					}else if($request_producto == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe un producto con el Código Ingresado.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		
		// METODO PARA LA OBTENCION DE LOS DATOS EN LA SECCION DE PRODUCTOS 
		public function getProducto( $idProducto){
			if($_SESSION['permisosMod']['r']){ 
				$idProducto = intval($idProducto);
				if($idProducto > 0){
					$arrData = $this->model->selectProducto($idProducto);
					if(empty($arrData)){
						$arrResponse= array('status' => false, 'msg' => 'Datos no encontrados.');
					}else {
						$arrImg = $this->model->selectImages($idProducto);
						if(count($arrImg) > 0){
							for ($i=0; $i < count($arrImg); $i++){
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];

							}
						}
						$arrData['images'] = $arrImg;
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
					
				}
			}
			die();
		}



		//ESTE METODO GUARDA LAS FOTOS  QUE SE INGRESEN EN EL FORMULARIO DE PRODUCTOS 
		public function setImage(){
			if($_POST){
				if(empty($_POST['idproducto'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de dato.');
				}else{
					$idProducto = intval($_POST['idproducto']);
					$foto      = $_FILES['foto'];
					$imgNombre = 'pro_'.md5(date('d-m-Y H:m:s')).'.jpg';
					$request_image = $this->model->insertImage($idProducto,$imgNombre);
					if($request_image){
						$uploadImage = uploadImage($foto,$imgNombre);
						$arrResponse = array('status' => true, 'imgname' => $imgNombre, 'msg' => 'Archivo cargado.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error de carga.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();

		}

		// ESTE METODO ELIMINA LAS IMAGENES DE LA SECCION PRODUCTOS 
		public function delFile(){
			if($_POST){
				if(empty($_POST['idproducto']) || empty($_POST['file'])){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos');
				}else{
					//ELIMINAR DE LA BD 
					$idProducto = intval($_POST['idproducto']);
					$imgNombre = strClean($_POST['file']);
					$request_image = $this->model->deleteImage($idProducto,$imgNombre);

					if($request_image){
						$deleteFile =deleteFile($imgNombre);
						$arrResponse = array('status' => true, 'msg' => 'Archivo Eliminado');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Imposible eliminar el archivo');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);	
			}
			die();
		}


		public function delProducto(){
			if($_POST){
				if($_SESSION['permisosMod']['d']){ 
					$intIdProducto = intval($_POST['idProducto']);
					$request_Delete = $this->model->deleteProducto($intIdProducto);
					if($request_Delete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el producto');
					}else {
						$arrResponse = array('status' => false, 'msg' => 'Error al elimar el producto');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();

		}

		

    }
?>