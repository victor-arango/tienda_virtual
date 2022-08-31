<?php 
	
	//define("BASE_URL", "http://localhost/tienda_virtual/");
	const BASE_URL = "http://localhost/tienda_virtual";

	//Zona horaria
	date_default_timezone_set('America/Bogota');
	

	//Datos de conexión a Base de Datos
	const DB_HOST = "localhost";
	const DB_NAME = "db_tiendavirtual";
	const DB_USER = "root";
	const DB_PASSWORD = "";
	const DB_CHARSET = "charset=utf8";

	//Deliminadores decimal y millar Ej. 24,1989.00
	const SPD = ".";
	const SPM = ",";

	//Simbolo de moneda
	const SMONEY = "$";
	const CURRENCY ="USD";
	const URLPAYPAL = "https://api-m.sandbox.paypal.com";
	const SECRET = "EOkhnHAzgDara1vMZpexiL4d1UpLzqU5T-2bEWNjXh1KHlHmBcdleLizwx9Yej2owCR6jrkBVnGvc6AW";
	const IDCLINTE ="AX8ORAFVAtd-vUKaTLV4iyp2mPgs1dZai5JmyzQq0M8KKInHVFdSpWAH--foyJkC-ThIVEytYxBtImVm";
	// ID CLIENTE PAYPAL CAMBIAR AL PASAR A MODO PRODUCCION
	// const IDCLINTE ="ASo9xiFHaJVhZAmmkHzBEZUIlo8AmHBWsTmZuMbC2ts0hdwYmoCywj82JiFwEu62_mUqr60c1P0A8p-9";
	// const URLPAYPAL = "https://api-m.paypal.com";
	// const SECRET = "EFKwl9zcymydYrZ5PRuB_tCnLPQ28jzaScqPDrD9V1LbWhGXnxMsu3nkaBegGsCx7SbYrfa1jHckGyqQ";

	// datos envio de correo
	const NOMBRE_REMITENTE="GRUPO ALV SAS";
	const EMAIL_REMITENTE="no-reply@grupoalv.com";
	const NOMBRE_EMPRESA="GRUPO ALV SAS";
	const WEB_EMPRESA="www.grupoalv.com";	

	// DATOS EMPRESA
	const DIRECCION = "Carrera 43B # 32B SUR-83 ";
	const TELEMPRESA = "(+57)444 33 29 ";
	const EMAIL_EMPRESA ="info@grupoalv.com";
	const EMAIL_PEDIDOS ="Pedidos@grupoalv.com";

//
const CAT_SLIDER ="1,2,3";
const CAT_BANNER ="1,2,3";

// DATOS PARA ENCRIPTAR / DESENCRIPTAR

const KEY = 'alvDenimLovers';
const METHODENCRIPT= "AES-128-ECB";

// ENVIO
const  COSTOENVIO= 0;


 ?>