<!DOCTYPE html>

<?php
//Cargar Variables de Criaderos
$criaderos= array();
exec("..\python\mosquito_breeding_sitesV1.py",$criaderos);
//pasar a un vector php
/* Variables a extraer*/
$lat_criaderos[]=0;
$long_criaderos[]=0;
$id_criaderos[]="";
$cod_criaderos[]="";
$distancia[]="";
$i=0;
$j=0;
$Numero_de_variables=5;

while ($j<count($criaderos)) {
if ($i+$Numero_de_variables<=count($criaderos)){
$id_criaderos[$j]=trim((string)$criaderos[$i]);
$cod_criaderos[$j]=trim((string)$criaderos[$i+1]);
$lat_criaderos[$j]=(float)$criaderos[$i+2];
$long_criaderos[$j]=abs((float)$criaderos[$i+3])*-1; //las coordenadas (longitud) de colombia son negativas - algunas estan digitadas como positivas .. entonces se cambia
$distancia[$j]=(float)$criaderos[$i+4];
}
$i=$i+$Numero_de_variables;
$j=$j+1;
}


 ?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Heatmaps</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      #panel {
        position: absolute;
        top: 5px;
        left: 50%;
        margin-left: -180px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=visualization"></script>
    <script>
// Adding 500 Data Points
var map, pointarray, heatmap;

<?php 

echo "var taxiData = [";
//Criaderos en el mapa
	for($j=0;$j<count($long_criaderos);$j++)
	{
	if($distancia[$j]==0)
	{
	$distancia[$j]=1;
	}
	switch ($distancia[$j]) {
    case ($distancia[$j]<15):
        $inv=5;
        break;
    case ($distancia[$j]<30):
        $inv=4;
        break;
    case ($distancia[$j]<60):
        $inv=3;
        break;
	case ($distancia[$j]<120):
        $inv=2;
        break;
	case ($distancia[$j]<240):
        $inv=1;
        break;
	default:$inv=0.5;
		
}
	
	//$inv=round(($distancia[$j]/($distancia[$j]*$distancia[$j]))*100);
	//echo "new google.maps.LatLng($lat_criaderos[$j], $long_criaderos[$j])";
	echo "{location: new google.maps.LatLng($lat_criaderos[$j],$long_criaderos[$j]), weight: $inv}";
	//echo $distancia[$j];
	if ($j+1<count($long_criaderos))
		{echo ",";}
	
	
	}
echo "];";


?>

function initialize() {
  var mapOptions = {
    zoom: 6,
    center: new google.maps.LatLng(4.65,-74.09),
    mapTypeId: google.maps.MapTypeId.MAP
  };

  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  var pointArray = new google.maps.MVCArray(taxiData);

  heatmap = new google.maps.visualization.HeatmapLayer({
    data: pointArray
  });

  

  var icono_criadero='../markers/mosquito_breeding/mb_lake1.png';
   <?php	  
	
		
	
	
	//Criaderos en el mapa
	for($j=0;$j<count($long_criaderos);$j++)
	{
	 echo"var contenido='<div  style=\'width: 160px; \'> Codigo:</br> <a href=\'http://claimproject.com/redcap570/redcap_v5.10.0/DataEntry/index.php?pid=86&page=p2_criaderos&id=$id_criaderos[$j]\'> $cod_criaderos[$j] </a> <br> Distancia: $distancia[$j]</div>';";
		  //marca puntos en el mapa
		echo "  var punto=new google.maps.LatLng($lat_criaderos[$j], $long_criaderos[$j]);";
		
		echo "var marcador = new google.maps.Marker({ position:punto, map:map, map:map,icon:icono_criadero, title:'$lat_criaderos[$j], $long_criaderos[$j]'}); ";
		 echo " var infowindow = new google.maps.InfoWindow({content:contenido});
			(function(marcador, contenido){                       
				google.maps.event.addListener(marcador, 'click', function() {
					infowindow.setContent(contenido);
					infowindow.open(map, marcador);
        });
    })(marcador,contenido);
		  
		  ";
		
		
		
	}?>
  
  
  
  heatmap.setMap(map);
  var gradient = [
    'rgba(0, 255, 255, 0)',
    'rgba(0, 255, 255, 1)',
    'rgba(0, 191, 255, 1)',
    'rgba(0, 127, 255, 1)',
    'rgba(0, 63, 255, 1)',
    'rgba(0, 0, 255, 1)',
    'rgba(0, 0, 223, 1)',
    'rgba(0, 0, 191, 1)',
    'rgba(0, 0, 159, 1)',
    'rgba(0, 0, 127, 1)',
    'rgba(63, 0, 91, 1)',
    'rgba(127, 0, 63, 1)',
    'rgba(191, 0, 31, 1)',
    'rgba(255, 0, 0, 1)'
  ]
  heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
  heatmap.set('opacity', heatmap.get('opacity') ? null : 10);
   heatmap.set('radius', heatmap.get('radius') ? null : 65);
   
 
   
   
   
   
   
}

function toggleHeatmap() {
  heatmap.setMap(heatmap.getMap() ? null : map);
}


google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>

  <body>
   <div id="panel">
      <button onclick="toggleHeatmap()">Toggle Heatmap</button>
      <button onclick="changeGradient()">Change gradient</button>
      <button onclick="changeRadius()">Change radius</button>
      <button onclick="changeOpacity()">Change opacity</button>
    </div>
    <div id="map-canvas"></div>
  </body>
</html>