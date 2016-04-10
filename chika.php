<?php
/*
1 行目には A の座標が x 座標、y 座標の順に半角スペース区切りで与えられる。
2 行目には問題文の k-近傍法で用いる k が与えられる。
3 行目には入力される地価が既知である点の総数 N が与えられる。
続く N 行のうち i 行目 (1 ≦ i ≦ N) には、地価が既知である点の x 座標 x_i、y 座標 y_i、および地価 p_i がこの順に半角スペース区切りで与えられる。
入力は合計で N + 3 行となり、最終行の末尾に改行が一つ入る。
 */


class Chika {

	private $filename = '';

	public function __construct($filename) {
		$this->setFileName($filename);
	}

    public function setFileName($filename) {
        $this->filename = (string)filter_var($filename);
    }

    public function getFileName() {
        return $this->filename;
    }

	function calcChika($filename) {
		$fh = fopen($filename, "r");
		$stdinArr = array();

		$yosoku_point = fgets($fh);
		$yosoku_point_arr = explode(" ",$yosoku_point);
		$x = $yosoku_point_arr[0];
		$y = $yosoku_point_arr[1];

		$kinbou_num = fgets($fh);

		$chika_point_num = fgets($fh);

		$distance_arr = array();
		$chika_arr = array();

		for ( $i = 0; $i < $chika_point_num; $i++ ) {
			$chika_line = fgets($fh);
			$chika_line_arr = explode(" ",$chika_line);

			$chika_line_x = $chika_line_arr[0];
			$chika_line_y = $chika_line_arr[1];
			$chika = $chika_line_arr[2];

			$distance = sqrt(pow(abs($x - $chika_line_x),2) + pow(abs($y - $chika_line_y),2));

			$distance_arr[] = array($i => $distance);
			$chika_arr[] = $chika;
		}

		$total_cnt = count($distance_arr);

		for ( $i = 0; $i < $total_cnt; $i++) {
			for ( $j = $i + 1; $j < $total_cnt; ++$j) {
				if ($distance_arr[$i][$i] > $distance_arr[$j][$j]) {
					$tmp_arr = array($j => $distance_arr[$i][$i]);
					$distance_arr[$i] = array($i => $distance_arr[$j][$j]);
					$distance_arr[$j] = $tmp_arr;

					$tmp_arr = $chika_arr[$i];
					$chika_arr[$i] = $chika_arr[$j];
					$chika_arr[$j] = $tmp_arr;
				}

			}
		}


		$counter = 1;
		$chika_sum = 0;


		foreach( $distance_arr as $key => $value ) {
			$chika_sum += $chika_arr[$key];
			if ( $counter == $kinbou_num ) {
				break;
			}
			$counter++;
		}

		return round($chika_sum / $kinbou_num);
	}
}

$a = new Chika("file.txt");
$filename =  $a -> getFileName();
echo $a -> calcChika($filename)."\n";

$b = new Chika("file2.txt");
$filename =  $b -> getFileName();
echo $b -> calcChika($filename)."\n";

?>