
<!DOCTYPE html>

<?php
//RED- ETV Encuestas muestra de sangre malaria urbana Estudio entomológico
//Cargar Variables de Criaderos
$criaderos= array();
exec("..\python\REDETVEncuestasmuestradesangre.py",$criaderos);
//pasar a un vector php
/* Variables a extraer*/
$lat_criaderos[]=0;
$long_criaderos[]=0;
$id_criaderos[]="";
$cod_casa[]="";
$urbano[]=0;
$periurban[]=0;
$rural[]=0;

//$toldillos[]="";
$i=0;
$j=0;
$Numero_de_variables=7;

while ($j<count($criaderos)) {
if ($i+$Numero_de_variables<=count($criaderos)){
$id_criaderos[$j]=trim((string)$criaderos[$i]);
$cod_casa[$j]=trim((string)$criaderos[$i+1]);
$lat_criaderos[$j]= (float)(str_replace(",",".",$criaderos[$i+2])) ;                      //(string)$criaderos[$i+2];
$long_criaderos[$j]=abs((float)(str_replace(",",".",$criaderos[$i+3])))*-1; 
$urbano[$j]=(float)$criaderos[$i+4];
$periurban[$j]=(float)$criaderos[$i+5];
$rural[$j]=(float)$criaderos[$i+6];
//$toldillos[$j]=(string)$criaderos[$i+4];
}
$i=$i+$Numero_de_variables;
$j=$j+1;
}


 ?>
<html>
  <head>
    <meta charset="utf-8">
    <title>RED- ETV Encuestas muestra de sangre malaria urbana Estudio entomológico</title>
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
		
        $inv=1;
 	//$inv=round(($toldillos[$j]/($toldillos[$j]*$toldillos[$j]))*100);
	//echo "new google.maps.LatLng($lat_criaderos[$j], $long_criaderos[$j])";
	echo "{location: new google.maps.LatLng(parseFloat($lat_criaderos[$j]),parseFloat($long_criaderos[$j])), weight: $inv}";
	//echo $toldillos[$j];
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
	for($j=0;$j<count($long_criaderos);$j++)
	{
		
	
	
		
	   //marca puntos en el mapa
		echo "  var punto=new google.maps.LatLng($lat_criaderos[$j],$long_criaderos[$j]);";
		//echo "var marcador = new google.maps.Marker({ position:punto, map:map, map:map,icon:icono_criadero, title:'$lat_criaderos[$j], $long_criaderos[$j]'}); ";
		
		if ($urbano[$j]==1){
		echo"var contenido='<div  style=\'width: 160px; \'> Codigo:</br> <a href=\'http://claimproject.com/redcap570/redcap_v6.9.4/DataEntry/index.php?pid=187&page=informacin_de_la_persona_seleccionada_para_la_toma&id=$id_criaderos[$j]\'> $cod_casa[$j] </a> <br>Tipo: URBANA</div>';";	
		echo "var marcador = new google.maps.Marker({ position:punto, map:map, map:map,icon:icono_urbano, title:'$lat_criaderos[$j], $long_criaderos[$j]'}); ";
		
		
		}
		elseif ($periurban[$j]==1)
		{
			echo"var contenido='<div  style=\'width: 160px; \'> Codigo:</br> <a href=\'http://claimproject.com/redcap570/redcap_v6.9.4/DataEntry/index.php?pid=187&page=informacin_de_la_persona_seleccionada_para_la_toma&id=$id_criaderos[$j]\'> $cod_casa[$j] </a> <br>Tipo:PERI_URBANA</div>';";
			echo "var marcador = new google.maps.Marker({ position:punto, map:map, map:map,icon:icono_periurban, title:'$lat_criaderos[$j], $long_criaderos[$j]'}); ";
			
		}elseif ($rural[$j]==1)
		{
			echo"var contenido='<div  style=\'width: 160px; \'> Codigo:</br> <a href=\'http://claimproject.com/redcap570/redcap_v6.9.4/DataEntry/index.php?pid=187&page=informacin_de_la_persona_seleccionada_para_la_toma&id=$id_criaderos[$j]\'> $cod_casa[$j] </a> <br>Tipo:RURAL</div>';";
			echo "var marcador = new google.maps.Marker({ position:punto, map:map, map:map,icon:icono_rural, title:'$lat_criaderos[$j], $long_criaderos[$j]'}); ";
			
		
		}else
		{
			echo"var contenido='<div  style=\'width: 160px; \'> Codigo:</br> <a href=\'http://claimproject.com/redcap570/redcap_v6.9.4/DataEntry/index.php?pid=187&page=informacin_de_la_persona_seleccionada_para_la_toma&id=$id_criaderos[$j]\'> $cod_casa[$j] </a> <br>Tipo:SIN DATOS</div>';";
			echo "var marcador = new google.maps.Marker({ position:punto, map:map, map:map,icon:icono_perdido, title:'$lat_criaderos[$j], $long_criaderos[$j]'}); ";
			
		}
		
		 
		 
		 
		 
		
		
		
		echo " var infowindow = new google.maps.InfoWindow({content:contenido});
			(function(marcador, contenido){                       
				google.maps.event.addListener(marcador, 'click', function() {
					infowindow.setContent(contenido);
					infowindow.open(map, marcador);
        });
    })(marcador,contenido);
		  
		  ";
		
		
		
	}?>
  
  
  
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
  <div id="panel">
      <button onclick="agregamap()">Agregar Mapa (imagen Quibdó)</button>
	  <button onclick="quitamap()">Quitar Mapa</button>
      <!--  <button onclick="poligonomap()">poligono</button>
      <button onclick="quitapoligono()">quitar poligono</button>
      <button onclick="changeOpacity()">Change opacity</button>-->
    </div>
    <div id="map-canvas"></div>
  </body>
</html>