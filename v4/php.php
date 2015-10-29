<?php
$salida= array(); //recogerá los datos que nos muestre el script de Python
 
   
    exec("google_maps_pointsV4.py",$salida);
	
    print_r ($salida);
?>