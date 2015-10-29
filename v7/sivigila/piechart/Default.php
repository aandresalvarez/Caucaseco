<?php
//Cargar Variables de Criaderos
$sivigila= array();
exec("..\..\python\sivigila2012.py",$sivigila);
//pasar a un vector php
/* Variables a extraer*/
    

$departamento[]="";
$paracito[]="";
$casos[]="";
$i=0;
$j=0;
$Numero_de_variables=3;

while ($j<count($sivigila)) {
if ($i+$Numero_de_variables<count($sivigila)){
$departamento[$j]=trim((string)$sivigila[$i]);
$paracito[$j]=trim((string)$sivigila[$i+1]);
$casos[$j]=trim((string)$sivigila[$i+2]);
}
$i=$i+$Numero_de_variables;
$j=$j+1;
}

 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>How to create Chart on Google Maps - Google Visualization</title>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.10&sensor=false&.js"></script>

    <script type="text/javascript" src="https://www.google.com/jsapi?.js"></script>

    <script type="text/javascript" src="js/jquery-1.7.2.js"></script>

    <script type="text/javascript">
	
	// Loading Google Visualization API Reference
        google.load( 'visualization', '1', { packages:['corechart'] });


        // Creating chart as marker
        function ChartMarker( options ) {
            this.setValues( options );
            
            this.$inner = $('<div>').css({
                position: 'relative',
                left: '-50%', top: '-50%',
                width: options.width,
                height: options.height,
                fontSize: '1px',
                lineHeight: '1px',
                backgroundColor: 'transparent',
                cursor: 'default'
            });

            this.$div = $('<div>')
                .append( this.$inner )
                .css({
                    position: 'absolute',
                    display: 'none'
                });
        };

        ChartMarker.prototype = new google.maps.OverlayView;

        ChartMarker.prototype.onAdd = function() {
            $( this.getPanes().overlayMouseTarget ).append( this.$div );
        };

        ChartMarker.prototype.onRemove = function() {
            this.$div.remove();
        };

        ChartMarker.prototype.draw = function() {
            var marker = this;
            var projection = this.getProjection();
            var position = projection.fromLatLngToDivPixel( this.get('position') );

            this.$div.css({
                left: position.x,
                top: position.y,
                display: 'block'
            })

            this.$inner
                .html( '<img src="' + this.get('image') + '"/>' )
                .click( function( event ) {
                    var events = marker.get('events');
                    events && events.click( event );
                });
                
            this.chart = new google.visualization.PieChart( this.$inner[0] );
            this.chart.draw( this.get('chartData'), this.get('chartOptions') );
        };
        
        // Initializing map with data for pie chart

        function initialize() {
            var latLng = new google.maps.LatLng(4.614040, -74.080700);

            var map = new google.maps.Map( $('#map_canvas')[0], {
                zoom: 6,
                center: latLng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            <?php 

//Criaderos en el mapa
//print_r(array_unique($departamento));
$departamento1[]=0;
$i=0;
for($j=0;$j<count($departamento)-1;$j++)
	{
	
	if($departamento[$j]!=$departamento[$j+1]){
	$departamento1[$i]=$departamento[$j];
	$i=$i+1;
	}
	
	}
	for($j=0;$j<count(array_unique($departamento1));$j++)
	{
	echo "var data_$departamento1[$j] = google.visualization.arrayToDataTable([  [ 'Parasito', 'Num Casos' ],";
		for($i=0;$i<count($paracito);$i++){
			echo "[ '$paracito[$i]', $casos[$i]]";
			if ($i+1<count($paracito))
				{echo ",";}
		}
		echo "]);";
		
		}
		
?>	
 var options = {
                fontSize: 11,
                backgroundColor: 'transparent',
                legend: 'none'
            };	
<?php 		
	for($j=0;$j<count(array_unique($departamento1));$j++)
	{
	switch ($departamento1[$j]) {
    case (strnatcasecmp((String)$departamento1[$j],"VALLE")==0):
        
		echo "var latLng_$departamento1[$j] = new google.maps.LatLng(3.447265, -76.521161);";
        break;
    case (strnatcasecmp((String)$departamento1[$j],"CAUCA")==0):
        echo "var latLng_$departamento1[$j] = new google.maps.LatLng(2.437868, -76.631024);";
        
		break;
    case (strnatcasecmp((String)$departamento1[$j],"CHOCO")==0):
        echo "var latLng_$departamento1[$j] = new google.maps.LatLng(5.681077, -76.660673);";
        
		break;
	case (strnatcasecmp((String)$departamento1[$j],"ANTIOQUIA")==0):
        echo "var latLng_$departamento1[$j] = new google.maps.LatLng(6.227428, -75.605985);";
        break;
	case (strnatcasecmp((String)$departamento1[$j],"ATLANTICO")==0):
        echo "var latLng_$departamento1[$j] = new google.maps.LatLng(10.958649, -74.811944);";
       	break;
	default:echo "var latLng_$departamento1[$j] = new google.maps.LatLng(4.614040, -74.080700);";
		
	}
	}
?>	
<?php 	
	for($j=0;$j<count(array_unique($departamento1));$j++)
	{
	echo"
	var marker = new ChartMarker({
                map: map,
                position: latLng_$departamento1[$j],
                width: '100px',
                height: '100px',
                chartData: data_$departamento1[$j],
                chartOptions: options,
                events: {
                    click: function( event ) {
                        alert( 'Latitude: ' + marker.position.hb + 'and Longitude: ' + marker.position.ib ); //Clicked marker lat lng
                    }
                }
            });";
	}
?>
          
        };

        $( initialize );
	
	
	
	
	
	
	
	</script>

</head>
<body onload="initialize();">
    <form id="form1" runat="server">
    <br />
    <br />
    <div id="map_canvas" style="width: auto; height: 600px;">
    </div>
    </form>
</body>
</html>
