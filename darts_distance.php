<?php
/*
1行目には初期値点の高さo_y,矢の初速s,角度θがスペース区切りの数値で入力。
2行目には的までの距離xと高さyと的の大きさがスペース区切りの数値で入力。
*/

$filename = "B006.txt";
$fh = fopen($filename, "r");

$shoki_line = fgets($fh);
$shoki_line_arr = explode(" ",$shoki_line);
$o_y = $shoki_line_arr[0];
$s = $shoki_line_arr[1];
$siita = $shoki_line_arr[2];


$mato_line = fgets($fh);
$mato_line_arr = explode(" ",$mato_line);
$kyori_x = $mato_line_arr[0];
$height_y = $mato_line_arr[1];
$mato_size = $mato_line_arr[2];

$g = 9.8;

$y = $o_y + $kyori_x * tan( deg2rad( $siita )) - (($g * pow($kyori_x,2)) / (2 * pow($s,2) * pow(cos( deg2rad( $siita ) ),2)));

$mato_under = $height_y - ($mato_size / 2 );
$mato_center = $height_y;
$mato_upper = $height_y + ($mato_size / 2 );

if ( $y > $mato_under && $y < $mato_upper) {
    $center_distance = round(abs($y - $mato_center),1);
	echo "Hit ".$center_distance."\n";
} else {
	echo "Miss\n";
}


?>