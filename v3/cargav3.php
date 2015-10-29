<html>
<?php 
 exec("google_maps_pointsV2.py");
$fp = fopen("datos.txt", "r");
$i=0;

$lat[]=0;
$long[]=0;
$codigo[]="";
while(!feof($fp)) {
$linea = fgets($fp);
$coordenadas[$i]=$linea; 
$i++;
}
$i=0;
$j=0;
while ($j<count($coordenadas)) {
if ($i+3<count($coordenadas)){
$codigo[$j]=trim((string)$coordenadas[$i]);
$lat[$j]=(float)$coordenadas[$i+1];
$long[$j]=(float)$coordenadas[$i+2]; 


}
$i=$i+3;
$j=$j+1;
}
$i=1;
$j=0;
fclose($fp);
//print_r($codigo);
//for($j=0;$j<count($long);$j++){echo "$codigo[$j] <br> ";}

echo "<meta http-equiv='Content-Type' content='text/html; charset=utf8' /> <title>Mapa Google</title>
<script src='http://maps.google.com/maps/api/js?sensor=false' type='text/javascript'></script>

  <script type='text/javascript'>
		
var ejemplo=4;
var overlay;
USGSOverlay.prototype = new google.maps.OverlayView();

      
	  function mapa_creado() {
	  
           var latlng = new google.maps.LatLng(4.65,-74.05);
           var configuracion = {
            zoom: 5,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
    };
	      var mapa = new google.maps.Map(document.getElementById('tamaño'), configuracion);

";

for($j=0;$j<count($long);$j++){
//print_r($codigo[$j]);

echo "
var latitud=parseFloat( $lat[$j]);
var longitud=parseFloat($long[$j]);
var contenido=' Codigo: <a href=\'http://claimproject.com/redcap570/redcap_v5.10.0/DataEntry/index.php?pid=6&page=conocimientos_actitudes_prcticas_y_sociodemogrfica&id=$codigo[$j]\'> $codigo[$j] </a><br> ';
	 

 //marca puntos en el mapa
		var punto1=new google.maps.LatLng(latitud, longitud);
		
      var marcacion1 = new google.maps.Marker({ position:punto1, map:mapa, title:'$lat[$j], $long[$j]'});  
 
 
 var infowindow = new google.maps.InfoWindow({
  content:contenido
  });

	(function(marcacion1, contenido){                       
        google.maps.event.addListener(marcacion1, 'click', function() {
            infowindow.setContent(contenido);
            infowindow.open(mapa, marcacion1);
        });
    })(marcacion1,contenido);

        
	
	";
	
	}
	
	echo " 



	}
	</script>
</head>
<body onload='mapa_creado()'>
  <div id='tamaño' style='width:800px; height:500px'></div>
</body>
</html>
";




?>
