<html>
	<head>
		<title>Selector de Eventos</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<?php
			$url_json = 'http://opendata.euskadi.eus/contenidos/ds_eventos/agenda_cultura_euskadi/es_kultura/adjuntos/kulturklik.json';
			$url = "http://localhost/Irontec/api.php?url=".$url_json;
			$client = curl_init($url);
			curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
			$response = curl_exec($client);
			$result = json_decode($response, true);
		?>
		<div style="width:700px; margin:0 auto;">
			<h1>Agenda cultural de Euskadi</h1>   
			<form action="" method="POST">
				<input type="text" name="eventtype" placeholder="Tipo de Evento" required/>
				<button type="submit" name="submit">Buscar</button>
			</form>    
			<?php
			if (isset($_POST['eventtype']) && $_POST['eventtype']!="") {
				$eventtype = "'".$_POST['eventtype']."'";
				$url = "http://localhost/Irontec/api.php?eventtype=".$eventtype;
				$client = curl_init($url);
				curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
				$response = curl_exec($client);
				$result = json_decode($response, true);
				
				$bNoRow = FALSE;
				
				foreach($result as $arrayresult){
					foreach($arrayresult as $key=>$value){
						if ($key == 'ORDER' && $value == 400){
							$bNoRow = TRUE;}
					}
				}

				if ($error = json_last_error()){
				}else{
					if (!$bNoRow){
						echo "<table id=\"customers\">";
						echo "<tr>";
						// Recordar que JSON devuelve Nombre, Tipo, FechaInicio, FechaFin, Donde
						echo "<th>Titulo</th><th>Evento</th><th>Inicio</th><th>Fin</th><th>Lugar</th>";
						echo "</tr>";
						foreach($result as $arrayresult){
							echo "<tr>";
							foreach($arrayresult as $key=>$value){
								echo "<td>".$value."</td>";
							}
							echo "</tr>";
						}
						echo "</table>";
					}
				}
			}
			?>
			<br />
		</div>
	</body>
</html>