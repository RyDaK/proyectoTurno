<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	
	function fn_404(){
		$config['css']['style']=array();
		$config['single'] = true;
		$config['view'] = 'templates/404';
		$this->view($config);
	}
	function dos_decimales($number){
		$x = number_format($number, 2, '.', '.');

		return $x;
	}
	function date_change_format($fecha){
		$fecha = new DateTime($fecha);
		return $fecha->format('d/m/Y');
	}
	
	function date_change_format_bd($fecha){
		$array_fecha = explode('/',$fecha);
		return trim($array_fecha[2]).'-'.trim($array_fecha[1]).'-'.trim($array_fecha[0]);
	}
	
	function enviar_sms($asunto,$mensaje,$destinatarios){
		
		$auth_basic = base64_encode("webmaster@turno.macctec.com:km45xb35");
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.labsmobile.com/json/send",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => '{"message":"'.$mensaje.'", "tpoa":"'.$asunto.'","recipient":[{"msisdn":"'.$destinatarios.'"}]}',
		  CURLOPT_HTTPHEADER => array(
			"Authorization: Basic ".$auth_basic,
			"Cache-Control: no-cache",
			"Content-Type: application/json"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
			
		
		if ($err) {
		  return false;
		} else {
		  return $response;
		}
	}
	
	function createMessage( $config = array() ){
		$defaults = array( 'type' => 0, 'message' => '', 'iconSize' => 'fa-2x' );
		$config += $defaults;

		$icon = '';
		$message = '';

		$iconSize = ' '.$config['iconSize'];
		$marginTop = '';
			if( $config['iconSize'] == 'fa-2x' ){
				$marginTop = 'mt-1';
			}
			elseif( $config['iconSize'] == 'fa-3x' ){
				$marginTop = 'mt-2';
			}

		switch( $config['type'] ){
			case 0:
					if( empty($config['message']) ){
						$config['message'] = 'No se logró ejecutar la acción, consulte con el administrador';
					}

					$icon .= 'fas fa-times-circle'.$iconSize.' color-red';
					$message .= 'Error! '.$config['message'].'.';
				break;
			case 1:
					$icon .= 'fas fa-check-circle'.$iconSize.' color-green';
					$message .= 'Ok! '.$config['message'].'.';
				break;
			case 2:
					$icon .= 'fas fa-exclamation-circle'.$iconSize.' color-yellow';
					$message .= 'Alerta! '.$config['message'].'.';
				break;
			case 3:
					$icon .= 'fas fa-question-circle'.$iconSize.' color-blue';
					$message .= $config['message'];
				break;
			case 4:
					$icon .= 'fas fa-user-times'.$iconSize.' color-purple';
					$message .= $config['message'].'.';
				break;
			default:
					$icon .= 'far fa-comment-alt fa-3x';
					$message .= $config['message'];
				break;
		}

		$html = '';
			// $html .= '<p class="text-left">';
				// $html .= '<i class="'.$icon.' mr-2"></i>'.$message.'.';
			// $html .= '</p>';
			$html .= '<i class="'.$icon.' mr-2 float-left"></i>';
			$html .= '<p class="text-left '.$marginTop.'">'.$message.'</p>';

		return $html;

	}


	function moneda( $valor, $igv = false, $dec = 2  ){
		if($igv) $valor = $valor/1.18;
		if( is_string( $valor ) ) return $valor;
		else {
			$valor = 'S/ '.number_format( $valor, $dec, '.', ',' );
			return $valor;
		}
	}
	function getActualDateTime(){
		$dateTimeObject = new DateTime();
		$actualDateTime = date_format($dateTimeObject, 'Y-m-d H:i:s');
		$actualDateTime = explode(" ", $actualDateTime);
		$actualDateTime = implode("T", $actualDateTime);
		return $actualDateTime;
	}

	function cambiarAFechaAgradableParaUsuario($fecha){
		$array_fecha = explode(' ', $fecha);
		$fecha = explode('-', $array_fecha[0]);
		$fecha = $fecha[2] . '/' . $fecha[1] . '/' . $fecha[0];
		return $fecha;
	}
