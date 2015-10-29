<?php 
if(isset($_POST['submit']))
 
{
 
$year = $_POST['year'];
 $tipo_enfermedad = $_POST['enfermedad'];
 $area= $_POST['area'];
 
echo "Casas georeferenciadas y casas positivas para <b>$tipo_enfermedad</b> en el A&#241;o: <b> $year </b><br>";
 

 
}else {$year="null"; $tipo_enfermedad="null"; $area="null";}


//Cargar Variables de Criaderos
$criaderos= array();
exec("..\python\mosquito_breeding_sitesV1.py",$criaderos);
//pasar a un vector php
/* Variables a extraer*/
$lat_criaderos[]=0;
$long_criaderos[]=0;
$id_criaderos[]="";
$cod_criaderos[]="";
$i=0;
$j=0;
$Numero_de_variables=5;
/*extraer criaderos*/




while ($j<count($criaderos)) {
if ($i+$Numero_de_variables<count($criaderos)){
$id_criaderos[$j]=trim((string)$criaderos[$i]);
$cod_criaderos[$j]=trim((string)$criaderos[$i+1]);
$lat_criaderos[$j]=(float)$criaderos[$i+2];

$long_criaderos[$j]=abs((float)$criaderos[$i+3])*(-1); //las coordenadas (longitud) de colombia son negativas - algunas estan digitadas como positivas .. entonces se cambia
}
$i=$i+$Numero_de_variables;
$j=$j+1;


}

//cargar variables de casas con malaria y/o dengue
$variables_py= array(); //recogerá los datos que nos muestre el script de Python
 exec("..\python\cases_and_housesV7.py",$variables_py);
/* Variables a extraer*/
$lat[]=0;
$long[]=0;
$codigo[]="";
$cd_country[]="";
$malaria[]="";
$dt_data_collection[]="";
$cd_site[]="";
$cd_area[]="";
$cd_house[]="";
$dengue[]="";
$i=0;
$j=0;

/*Extraer Casas*/
$Numero_de_variables=10;
while ($j<count($variables_py)) {
if ($i+$Numero_de_variables<count($variables_py)){
$codigo[$j]=trim((string)$variables_py[$i]);
$lat[$j]=(float)$variables_py[$i+1];
$long[$j]=abs((float)$variables_py[$i+2])*-1; //las coordenadas (longitud) de colombia son negativas
$cd_country[$j]=trim((string)$variables_py[$i+3]); 
$malaria[$j]=(float)$variables_py[$i+4]; 
$dt_data_collection[$j]=trim((string)$variables_py[$i+5]);//año de captacion
$cd_area[$j]=trim((string)$variables_py[$i+6]);
$cd_site[$j]=trim((string)$variables_py[$i+7]);
$cd_house[$j]=trim((string)$variables_py[$i+8]);
$dengue[$j]=(float)$variables_py[$i+9]; 

}
$i=$i+$Numero_de_variables;
$j=$j+1;
}
$i=0;
$j=0;

/*print_r ($codigo);
print_r($malaria);
print_r($dengue);*/ 
//for($j=0;$j<count($long);$j++){echo "$codigo[$j] <br> ";}


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<style type="text/css">
html,body{margin:0;padding:0}
body{font: 76% arial,sans-serif}
p{margin:0 10px 5px}
a{display:block;color: #981793;padding:5px}
div#header h1{height:80px;line-height:80px;margin:0;
  padding-left:10px;background: #EEE;color: #79B30B}
div#content p{line-height:1.4}
div#navigation{background:#FFF}
div#extra{background:#FFF}
div#footer{background: #FFF;color: #FFF}
div#footer p{margin:0;padding:5px 10px}

div#wrapper{float:right;width:100%;margin-right:-33%}
div#content{margin-right:33%}
div#navigation{float:left;width:32.9%}
div#navigation_cols{float:left;width:32.9%}
div#extra{float:left;clear:left;width:32.9%}
div#footer{clear:both;width:100%}
</style>

<title>Mapa De Casas</title>
 <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=weather"></script>
<!--<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>-->

      <script type="text/javascript">
	  

      
	  function mapa_creado() {
	  
           var Colombia = new google.maps.LatLng(4.65,-74.05);
           var configuracion = {
            zoom: 5,
            center: Colombia,
            mapTypeId: google.maps.MapTypeId.ROADMAP
    };
	// DIMENSIONES MAPA QUIBDO 
	var imageBounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(5.66829, -76.666777),//izquierda -- abajo
      new google.maps.LatLng(5.72230, -76.625555));//derecha --arriba
	
	
	
	
	
	
	
	
			var mapa = new google.maps.Map(document.getElementById("tamaño"), configuracion);
			var icono= '../markers/house/simple_brown_house.png';
			var icono_positivo_malaria= '../markers/house/simple_red_house.png';
			var icono_positivo_dengue='../markers/house/simple_green_house.png';
			var icono_positivo_malaria_y_dengue='../markers/house/simple_yellow_house.png';	
			var icono_criadero='../markers/mosquito_breeding/mb_lake1.png';
		  
		  
		  //CARGAR IMAGENMAPA QUIBDO
		  
		   historicalOverlay = new google.maps.GroundOverlay(
      '../images/quibdo.png',
      imageBounds);
  historicalOverlay.setMap(mapa);
		  
		  
		  // NUBES Y TEMPERATURA
		 /* var weatherLayer = new google.maps.weather.WeatherLayer({
    temperatureUnits: google.maps.weather.TemperatureUnit.CELSIUS
  });
  weatherLayer.setMap(mapa);*/

  /*var cloudLayer = new google.maps.weather.CloudLayer();
  cloudLayer.setMap(mapa);*/
		  
		  
		  
	<?php	  
	
		
	//print_r($long_criaderos);
	
	//Criaderos en el mapa
	for($j=0;$j<count($long_criaderos);$j++)
	{
	 echo"var contenido='<div  style=\'width: 150px; \'> Codigo:</br> <a href=\'http://claimproject.com/redcap570/redcap_v5.10.0/DataEntry/index.php?pid=86&page=p2_criaderos&id=$id_criaderos[$j]\'> $cod_criaderos[$j] </a> </div>';";
		  //marca puntos en el mapa
		echo "  var punto=new google.maps.LatLng($lat_criaderos[$j], $long_criaderos[$j]);";
		
		echo "var marcador = new google.maps.Marker({ position:punto, map:mapa, map:mapa,icon:icono_criadero, title:'$lat_criaderos[$j], $long_criaderos[$j]'}); ";
		 echo " var infowindow = new google.maps.InfoWindow({content:contenido});
			(function(marcador, contenido){                       
				google.maps.event.addListener(marcador, 'click', function() {
					infowindow.setContent(contenido);
					infowindow.open(mapa, marcador);
        });
    })(marcador,contenido);
		  
		  ";
		
		
		
	}
	
	
	
	
	
	
	for($j=0;$j<count($long);$j++)
		   {
		   if ($year=="null" and $tipo_enfermedad=="null" and $area=="null") /// MARCA TODOS LOS PUNTOS EN AZUL LA PRIMERA VEZ
		   {
		   echo"var contenido='<div  style=\'width: 150px; \'> Codigo:</br> <a href=\'http://claimproject.com/redcap570/redcap_v5.10.0/DataEntry/index.php?pid=6&page=conocimientos_actitudes_prcticas_y_sociodemogrfica&id=$codigo[$j]\'> $codigo[$j] </a> </div>';";
		  //marca puntos en el mapa
		echo "  var punto=new google.maps.LatLng($lat[$j], $long[$j]);";
		
		echo "var marcador = new google.maps.Marker({ position:punto, map:mapa, map:mapa,icon:icono, animation: google.maps.Animation.DROP, title:'$lat[$j], $long[$j]'}); ";
		 echo " var infowindow = new google.maps.InfoWindow({content:contenido});
			(function(marcador, contenido){                       
				google.maps.event.addListener(marcador, 'click', function() {
					infowindow.setContent(contenido);
					infowindow.open(mapa, marcador);
        });
    })(marcador,contenido);
		  
		  ";
		
		
		
		
		   }
		   
		  if($dt_data_collection[$j]==$year and $cd_area[$j]==$area )
		  {
		   echo"var contenido='<div  style=\'width: 150px; \'> Codigo:</br> <a href=\'http://claimproject.com/redcap570/redcap_v5.10.0/DataEntry/index.php?pid=6&page=conocimientos_actitudes_prcticas_y_sociodemogrfica&id=$codigo[$j]\'> $codigo[$j] </a> </div>';";
		  //marca puntos en el mapa
		echo "  var punto=new google.maps.LatLng($lat[$j], $long[$j]);";
		
		
		
		if ($dengue[$j]==1 and $malaria[$j]==1 and $tipo_enfermedad =="Malaria-Dengue"){
		
		
		echo "var marcador = new google.maps.Marker({ position:punto, map:mapa, map:mapa,icon:icono_positivo_malaria_y_dengue, animation: google.maps.Animation.DROP, title:'.::Positivo Malaria y Dengue::.'}); ";
		 echo " var infowindow = new google.maps.InfoWindow({content:contenido});
			(function(marcador, contenido){                       
				google.maps.event.addListener(marcador, 'click', function() {
					infowindow.setContent(contenido);
					infowindow.open(mapa, marcador);
        });
    })(marcador,contenido);
		  
		  ";
		 
		 
		 }
		 elseif ($dengue[$j]==1 and ($tipo_enfermedad =="Malaria-Dengue" or $tipo_enfermedad =="Dengue") )
		 {
		 echo "var marcador = new google.maps.Marker({ position:punto, map:mapa, map:mapa,icon:icono_positivo_dengue, animation: google.maps.Animation.DROP, title:'.::Positivo Dengue::.'}); ";
		 echo " var infowindow = new google.maps.InfoWindow({content:contenido});
			(function(marcador, contenido){                       
				google.maps.event.addListener(marcador, 'click', function() {
					infowindow.setContent(contenido);
					infowindow.open(mapa, marcador);
        });
    })(marcador,contenido);
		  
		  ";
		  }
		  elseif ($malaria[$j]==1 and ($tipo_enfermedad =="Malaria-Dengue" or $tipo_enfermedad =="Malaria"))
		  {
		  echo "var marcador = new google.maps.Marker({ position:punto, map:mapa, map:mapa,icon:icono_positivo_malaria, animation: google.maps.Animation.DROP, title:'.::Positivo Malaria::.'}); ";
		 echo " var infowindow = new google.maps.InfoWindow({content:contenido});
			(function(marcador, contenido){                       
				google.maps.event.addListener(marcador, 'click', function() {
					infowindow.setContent(contenido);
					infowindow.open(mapa, marcador);
        });
    })(marcador,contenido);
		  
		  ";
		  }
		  else
		  {
		   echo "var marcador = new google.maps.Marker({ position:punto, map:mapa, map:mapa,icon:icono, animation: google.maps.Animation.DROP, title:'$lat[$j], $long[$j]'}); ";
		 echo " var infowindow = new google.maps.InfoWindow({content:contenido});
			(function(marcador, contenido){                       
				google.maps.event.addListener(marcador, 'click', function() {
					infowindow.setContent(contenido);
					infowindow.open(mapa, marcador);
        });
    })(marcador,contenido);
		  
		  ";
		  }
		 
		 
		  }
		    } ?>
			
			
	}
	
	
	

	 
	 
	 
	
</script>
</head>

<body onload="mapa_creado()">




<div id="container" >

<div id="wrapper">
<div id="content">
<div id="tamaño" style="width:500px; height:400px"> </div>
  </div>
</div>
<div id="navigation">
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<table ><tr>
<td><strong>1) A&#241;o:</strong><br>
	<select name="year" size=4>
   <option value="2011">2011</option> 
   <option value="2012">2012</option> 
   <option value="2013">2013</option>
   <option value="2014">2014</option> 
	</select></td>
<td><b>2) Casos de:</b><br>
	<select name="enfermedad" size=3>
   <option value="Malaria">Malaria</option> 
   <option value="Dengue">Dengue</option> 
   <option value="Malaria-Dengue">Malaria y Dengue</option>
	</select></td>
<td></td>
</tr>
<tr>

<td><b>3) &#193;rea:</b><br>
	<select name="area" size=3>
   <option value="2">Tierralta</option> 
   <option value="1">Buenaventura</option> 
   <option value="3">Tumaco</option>
   <option value="12">Quibdo</option>
	</select></td>
	<td><input type="submit" name="submit" value="Ver Casos"></td>
<td></td>
</tr>
</table>
</form>
</div>
 
 <hr>
 <div id="extra">
<p><strong>Leyenda: Casas:</strong></p>
<img src="../markers/house/simple_brown_house.png">: Casa encuestada.<br>
<img src="../markers/house/simple_red_house.png">: Con uno o mas casos de <strong>Malaria.</strong><br>
<img src="../markers/house/simple_green_house.png">: Con uno o mas casos de <strong>Dengue.</strong><br>
<img src="../markers/house/simple_yellow_house.png">: Con uno o mas casos de <strong>Malaria y Dengue.</strong><br><br>
<p><b>Nota:</b> El mapa esta integrado con REDCap: click sobre la casa de inter&#233;s para mas informaci&#243;n.</p>
</div>
 

  


<div id="footer"><p>Caucaseco Scientific Research Center, Cali, Colombia.</p></div>
</div>
 

 
 
 


</body>


</html>
