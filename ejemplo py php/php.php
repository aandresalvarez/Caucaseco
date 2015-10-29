<?php
$salida= array(); //recogerá los datos que nos muestre el script de Python
 
    echo "Hola Mundo";
    exec("google_maps_pointsV2.py",$salida);
	$salida[99]="alvaro";
    print_r ($salida);
?>