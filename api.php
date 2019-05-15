<?php
header("Content-Type:application/json");
include('db.php');
//Realizamos la busqueda en la BBDD por el tipo de evento
if (isset($_GET['eventtype']) && $_GET['eventtype']!="") {
	$eventtype = $_GET['eventtype'];
	$result = mysqli_query($con,"SELECT * FROM `tbeventos` WHERE eventtype = $eventtype");
	if(mysqli_num_rows($result)>0){
		$response = [];
		while($row = mysqli_fetch_array($result)){
		$response[] = array(
			'Nombre' => $row['documentname'],
			'Tipo' => $row['eventtype'],
			'Fecha Inicio' => $row['eventstartdate'],
			'Fecha Fin' => $row['eventenddate'],
			'Donde' => $row['eventwhere']);
		}
		$json_response = json_encode($response);
		echo $json_response;
		mysqli_close($con);
	}else{response(400, "No Record Found");}
}elseif  (isset($_GET['url']) && $_GET['url']!="") {
	$url = $_GET['url'];
	$json = file_get_contents($url);
	if (strlen($json) > 0 ){
		//Limpio el retorno de datos
		while ($json[0] != '['):
			$json = substr($json,1);
		endwhile;
		while (substr($json, -1,) <> ']'):
			$json = substr($json, 0, -1);
		endwhile;
		//Trato los valores que quiero guardar
		$obj = json_decode($json, true);
		if ($error = json_last_error()){
			echo response(300, "Invalid JSON");
		}else{
			foreach($obj as $arrayresult){
				foreach($arrayresult as $key=>$value){
					switch ($key) {
					   case 'documentName':
						   $jsonNombre = $value;
						   break;
					   case 'eventType':
							$jsonTipo = $value;
							break;
					   case 'eventStartDate':
							$jsonFechaInicio = $value;
							break;
					   case 'eventEndDate':
							$jsonFechaFin = $value;
							break;
					   case 'eventWhere':
							$jsonDonde = $value;
							break;
					}	
				}
				$query = mysqli_query($con,"SELECT * FROM `tbeventos` WHERE documentName = '$jsonNombre'") or die();
				if(mysqli_num_rows($query) == 0){
					//Formateo la FechaInicio para insertarla
					$strFechaInicio = substr($jsonFechaInicio,0,2)."-".substr($jsonFechaInicio,3,2)."-".substr($jsonFechaInicio,6,4);
					$dtFechaInicio = date_create_from_format('d-m-Y', $strFechaInicio);
					//Formateo la FechaFin para insertarla
					$strFechaFin = substr($jsonFechaFin,0,2)."-".substr($jsonFechaFin,3,2)."-".substr($jsonFechaFin,6,4);
					$dtFechaFin = date_create_from_format('d-m-Y', $strFechaFin);
					$insert = "INSERT INTO tbeventos (documentname, eventtype, eventstartdate, eventenddate, eventwhere) VALUES ('".$jsonNombre."','".$jsonTipo."','".date_format($dtFechaInicio, 'Y-m-d')."','".date_format($dtFechaFin, 'Y-m-d')."','".$jsonDonde."')";
					if (mysqli_query($con, $insert)){
						//echo response(100, "DB Updated ");
					}else{
						//echo response(200, "DB Error ");
					}
				}	
			}
		}
		mysqli_close($con);
	}else{response(400, "No Record Found");}
}else{response(500, "Invalid Request");}
//Utilizo la funcion Response para devolver los valores como un JSON al index.
function response($order, $code){
	$response[] = array(
			'ORDER' => $order,
			'CODE' => $code);
	$json_response = json_encode($response);
	echo $json_response;
}
?>