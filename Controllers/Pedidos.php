<?php 


    class Pedidos extends Controllers{
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
        
            getPermisos(5);
        }

        public function Pedidos()
        {
            if(empty($_SESSION['permisosMod']['r'])){
                header("Location:".base_url().'/dashboard');
            }
            
            $data['page_tag'] = "Pedidos";
            $data['page_title'] = "PEDIDOS <small>Tienda virtual</small>";
            $data['page_name'] = "pedidos";
            $data['page_functions_js'] = "functions_pedidos.js";
            $this->views->getView($this,"pedidos",$data);
        }

        //METODO OBTIENE LOS PEDIDOS 
        public function getPedidos()
        {
            if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectPedidos();
                // dep($arrData);
				for ($i=0; $i < count($arrData); $i++) {
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

                    $arrData[$i]['transaccion'] = $arrData[$i]['referenciacobro'];
                    if($arrData[$i]['idtransaccionpaypal'] != ""){
                        $arrData[$i]['transaccion'] =$arrData[$i]['idtransaccionpaypal'];
                    }

                    $arrData[$i]['monto'] = SMONEY.formatMoney($arrData[$i]['monto']);

					if($_SESSION['permisosMod']['r']){
						$btnView .= '<a href="'.base_url().'/pedidos/orden/'.$arrData[$i]['idpedido'].'" target="_blanck" 
                        class="btn btn-info bn-sm"> <i class="far fa-eye"></i></a>
                        <button class="btn btn-danger btn-sm" onclick="fntViewPDF('.$arrData[$i]['idpedido'].')"
                        title="Generar PDF"><i class="fas fa-file-pdf"></i></button>'
                        ;
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

    }
?>