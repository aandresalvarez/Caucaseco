<html>
<?php 
 exec("google_maps_points.py");
$fp = fopen("datos.txt", "r");
$i=1;

$lat[]=0;
$long[]=0;
while(!feof($fp)) {
$linea = fgets($fp);
$coordenadas[$i]=(float)$linea; 
$i++;
}

for($i=1;$i<count($coordenadas);$i++)
{

if ($i%2==0) // Vemos si 54 dividido en 2 da resto 0 si lo da
{$long[$i]=(float)$coordenadas[$i];
	$lat[$i]=(float)$coordenadas[$i+1]; 

} //escribo Par
else //Sino
{ $lat[$i]=(float)$coordenadas[$i];
	$long[$i]=(float)$coordenadas[$i+1];

 } //Escribo impar



}
$i=1;

fclose($fp);


/*
for($j=1;$j<count($long);$j++){
echo $long[$j];
echo "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX\n $j ";
}*/


echo "<meta http-equiv='Content-Type' content='text/html; charset=utf8' /> <title>Mapa Google</title>
<script src='http://maps.google.com/maps/api/js?sensor=false' type='text/javascript'></script>

  <script type="text/javascript">
		
var ejemplo=4;

      
	  function mapa_creado() {
	  
           var latlng = new google.maps.LatLng(4.65,-74.05);
           var configuracion = {
            zoom: 5,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
    };
	      var mapa = new google.maps.Map(document.getElementById('tamaño'), configuracion);


var latitud=parseFloat( 3.44);
var longitud=parseFloat(-74.05);

 //marca puntos en el mapa
		var punto1=new google.maps.LatLng(latitud, longitud);
      var marcacion1 = new google.maps.Marker({ position:punto1, map:mapa, title:'cali colombia'});  
//print_r($lat);




		    
	}
	
	

	 
	 
	 
	
</script>


</head>

<body onload='mapa_creado()'>
  <div id='tamaño' style='width:800px; height:500px'></div>
</body>


</html>




";




?>


<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />


<title>Mapa Google</title>

<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>

      <script type="text/javascript">
		
var ejemplo=4;

      
	  function mapa_creado() {
	  
           var latlng = new google.maps.LatLng(4.65,-74.05);
           var configuracion = {
            zoom: 5,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
    };
	      var mapa = new google.maps.Map(document.getElementById('tamaño'), configuracion);


var latitud=parseFloat( 3.44);
var longitud=parseFloat(-74.05);

 //marca puntos en el mapa
		var punto1=new google.maps.LatLng(latitud, longitud);
      var marcacion1 = new google.maps.Marker({ position:punto1, map:mapa, title:'cali colombia'});  
//print_r($lat);




		    
	}
	
	

	 
	 
	 
	
</script>
</head>

<body onload='mapa_creado()'>
  <div id='tamaño' style='width:800px; height:500px'></div>
</body>


</html>