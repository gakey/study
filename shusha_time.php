<?php
/*
 a b c　　#配座駅へまで時間 a 分, 配座駅から儀野駅の乗車時間 b 分, 儀野駅から会社までの時間 c 分
 N　　　　#配座駅から出る電車の本数を表す整数 N
 h_1 m_1　#1本目の電車の発車時刻 h_1 時 m_1 分
 h_2 m_2　#2本目の電車の発車時刻 h_2 時 m_2 分
 ...
 h_N m_N　#N本目の電車の発車時刻 h_N 時 m_N 分

 */

$filename = "B013.txt";
$fh = fopen($filename, "r");

$time_line = fgets($fh);
$time_line_arr = explode(" ",$time_line);

$train_num = fgets($fh);

$limit_time_sec = strtotime("08:59");

$train_arr = array();

for ( $i = 0; $i < $train_num; $i++) {
	$time_arr = explode(" ",trim(fgets($fh)));
	$hour = str_pad($time_arr[0],2,"0",STR_PAD_LEFT);
	$minute = str_pad($time_arr[1],2,"0",STR_PAD_LEFT);
	$train_arr[$i] = $hour.":".$minute;
}

rsort($train_arr);

$to_baiza_time = $time_line_arr[0];
$to_gino_time = $time_line_arr[1];
$to_office_time = $time_line_arr[2];

foreach ( $train_arr as $baiza_train_time ) {

	$baiza_train_time_sec = strtotime($baiza_train_time);
	$total_time_sec = $baiza_train_time_sec + ( $to_gino_time * 60 ) + ( $to_office_time * 60 );

	if ($limit_time_sec >= $total_time_sec) {
		echo date("H:i", $baiza_train_time_sec - ( $to_baiza_time * 60 ))."\n";
		break;
	}

}

?>