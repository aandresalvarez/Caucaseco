<!DOCTYPE html>

<?php
//RED- ETV Encuestas muestra de sangre malaria urbana Estudio entomológico
//Cargar Variables de Criaderos
$criaderos= array();
exec("..\python\MalariaUrban.py",$criaderos);
//pasar a un vector php
/* Variables a extraer*/

//print_r($criaderos);
$id_study[]="";
$cod_casa[]="";
$lat_casa[]=0;
$long_casa[]=0;
$sitio[]=0;



//$toldillos[]="";
$i=0;
$j=0;
$Numero_de_variables=5;

while ($j<count($criaderos)) {
if ($i+$Numero_de_variables<=count($criaderos)){
$id_study[$j]=trim((string)$criaderos[$i]);
$cod_casa[$j]=trim((string)$criaderos[$i+1]);
$lat_casa[$j]= (float)(str_replace(",",".",$criaderos[$i+2])) ;                      //(string)$criaderos[$i+2];
$long_casa[$j]=abs((float)(str_replace(",",".",$criaderos[$i+3])))*-1; 
$sitio[$j]=trim((string)$criaderos[$i+4]);


//$toldillos[$j]=(string)$criaderos[$i+4];
}
$i=$i+$Numero_de_variables;
$j=$j+1;
}
//print_r($cod_casa);

 ?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Malaria Urban</title>
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
	for($j=0;$j<count($long_casa);$j++)
	{
		
        $inv=1;
 	//$inv=round(($toldillos[$j]/($toldillos[$j]*$toldillos[$j]))*100);
	//echo "new google.maps.LatLng($lat_casa[$j], $long_casa[$j])";
	echo "{location: new google.maps.LatLng(parseFloat($lat_casa[$j]),parseFloat($long_casa[$j])), weight: $inv}";
	//echo $toldillos[$j];
	if ($j+1<count($long_casa))
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

  
  var icono_urbano='../markers/mosquito_breeding/bullet_blue.png';
  var icono_periurban='../markers/mosquito_breeding/bullet_gris.png';
  var icono_rural='../markers/mosquito_breeding/bullet_red.png';
  var icono_perdido='../markers/mosquito_breeding/error.png';
  
  
/*   // MAPA QUIBDO
	var imageBounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(5.66829, -76.666777),//izquierda -- abajo
      new google.maps.LatLng(5.72230, -76.625555));//derecha --arriba
		  
		  //MAPA QUIBDO
		  
		 
    historicalOverlay = new google.maps.GroundOverlay(
      'quibdo1.png',
      imageBounds);
  historicalOverlay.setMap(map); */
  
  
  
  
  
  
  
  
  
  
   <?php	  
	
	
	
	
		
	
	
	//Criaderos en el mapa
	for($j=0;$j<count($long_casa);$j++)
	{
		
	
	
		
	   //marca puntos en el mapa
		echo "  var punto=new google.maps.LatLng($lat_casa[$j],$long_casa[$j]);";
		//echo "var marcador = new google.maps.Marker({ position:punto, map:map, map:map,icon:icono_criadero, title:'$lat_casa[$j], $long_casa[$j]'}); ";
		
		if($sitio[$j]== 198){
		
			echo"var contenido='<div  style=\'width: 160px; \'> Codigo:</br> <a href=\'http://claimproject.com/redcap570/redcap_v6.9.4/DataEntry/index.php?pid=175&page=conocimientos_actitudes_prcticas_y_sociodemogrfica&id=$id_study[$j]\'> $cod_casa[$j] </a><br>La Yesquita</br> </div>';";
			echo "var marcador = new google.maps.Marker({ position:punto, map:map, map:map,icon:icono_urbano, title:'$lat_casa[$j], $long_casa[$j]'}); ";
			
		}else if($sitio[$j]== 176){
			
			echo"var contenido='<div  style=\'width: 160px; \'> Codigo:</br> <a href=\'http://claimproject.com/redcap570/redcap_v6.9.4/DataEntry/index.php?pid=175&page=conocimientos_actitudes_prcticas_y_sociodemogrfica&id=$id_study[$j]\'> $cod_casa[$j] </a><br>Cabi</br> </div>';";
			echo "var marcador = new google.maps.Marker({ position:punto, map:map, map:map,icon:icono_periurban, title:'$lat_casa[$j], $long_casa[$j]'}); ";
			
		}else {
			echo"var contenido='<div  style=\'width: 160px; \'> Codigo:</br> <a href=\'http://claimproject.com/redcap570/redcap_v6.9.4/DataEntry/index.php?pid=175&page=conocimientos_actitudes_prcticas_y_sociodemogrfica&id=$id_study[$j]\'> $cod_casa[$j] </a><br>Casablanca</br> </div>';";
			echo "var marcador = new google.maps.Marker({ position:punto, map:map, map:map,icon:icono_rural, title:'$lat_casa[$j], $long_casa[$j]'}); ";
			
			
		}
		
		
		 
		 
		 
		 
		
		
		
		echo " var infowindow = new google.maps.InfoWindow({content:contenido});
			(function(marcador, contenido){                       
				google.maps.event.addListener(marcador, 'click', function() {
					infowindow.setContent(contenido);
					infowindow.open(map, marcador);
        });
    })(marcador,contenido);     
	";
		
		
	}	
	?>
  
  
  
 // heatmap.setMap(map);
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

function agregamap() {
	
  //heatmap.setMap(heatmap.getMap() ? null : map);
    // MAPA QUIBDO
	var imageBounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(5.66829, -76.666777),//izquierda -- abajo
      new google.maps.LatLng(5.72230, -76.625555));//derecha --arriba
		  
		  //MAPA QUIBDO
		  
		 
    historicalOverlay = new google.maps.GroundOverlay(
      'quibdo1.png',
      imageBounds);
  historicalOverlay.setMap(map);
  
}
function quitamap() {
	  
	historicalOverlay.setMap(null);
  
}



google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>

  <body>
  <!--<div id="panel"> -->
      <!--<button onclick="agregamap()">Agregar Mapa (imagen Quibdó)</button>-->
	 <!-- <button onclick="quitamap()">Quitar Mapa</button> -->
      <!--  <button onclick="poligonomap()">poligono</button>
      <button onclick="quitapoligono()">quitar poligono</button>
      <button onclick="changeOpacity()">Change opacity</button>-->
    <!--</div> -->
    <div id="map-canvas"></div>
  </body>
</html>