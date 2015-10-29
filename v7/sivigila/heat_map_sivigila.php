<!DOCTYPE html>

<?php
//Cargar Variables de Criaderos
$sivigila= array();
exec("..\python\sivigila2012.py",$sivigila);
//pasar a un vector php
/* Variables a extraer*/
    
$id[]=0;
$ano[]="";
$departamento[]="";
$municipio[]="";
$vereda[]="";
$evento[]="";
$i=0;
$j=0;
$Numero_de_variables=6;

while ($j<count($sivigila)) {
if ($i+$Numero_de_variables<count($sivigila)){
$id[$j]=trim((string)$sivigila[$i]);
$ano[$j]=trim((string)$sivigila[$i+1]);
$departamento[$j]=trim((string)$sivigila[$i+2]);
$municipio[$j]=trim((string)$sivigila[$i+3]);
$vereda[$j]=trim((string)$sivigila[$i+4]);
$evento[$j]=trim((string)$sivigila[$i+5]);
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
	for($j=0;$j<count($id);$j++)
	{
	
	
	//echo strnatcasecmp($departamento[$j],"VALLE");
	switch ($departamento[$j]) {
    case (strnatcasecmp($departamento[$j],"VALLE")==0):
        //$inv=5;
		
		echo "new google.maps.LatLng(3.447265, -76.521161)";
        break;
    case (strnatcasecmp($departamento[$j],"CAUCA")==0):
        //$inv=4;
        echo "new google.maps.LatLng(2.437868, -76.631024)";
		break;
    case (strnatcasecmp($departamento[$j],"CHOCO")==0):
        //$inv=3;
        echo "new google.maps.LatLng(5.681077, -76.660673)";
		break;
	case (strnatcasecmp($departamento[$j],"ANTIOQUIA")==0):
        //$inv=2;
        echo "new google.maps.LatLng(6.227428, -75.605985)";
		break;
	case (strnatcasecmp($departamento[$j],"ATLANTICO")==0):
        //$inv=1;
        echo "new google.maps.LatLng(10.958649, -74.811944)";
		break;
	default:echo "new google.maps.LatLng(4.614040, -74.080700)";
		
	}
	//$inv=round(($distancia[$j]/($distancia[$j]*$distancia[$j]))*100);
	//echo "new google.maps.LatLng($lat_criaderos[$j], $long_criaderos[$j])";
	//echo "{location: new google.maps.LatLng($lat_criaderos[$j],$long_criaderos[$j]), weight: $inv}";
	//echo $distancia[$j];
	if ($j+1<count($id))
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
   <!-- <div id="panel">
      <button onclick="toggleHeatmap()">Toggle Heatmap</button>
      <button onclick="changeGradient()">Change gradient</button>
      <button onclick="changeRadius()">Change radius</button>
      <button onclick="changeOpacity()">Change opacity</button>
    </div>-->
    <div id="map-canvas"></div>
  </body>
</html>