<?php
/**
 * Day 2: I Was Told There Would Be No Math
 * @see https://adventofcode.com/2015/day/2
 * 47 mins
 */

class DayTwo {

	protected $input = array();
	protected $result;

	function __construct (string $in) {
		if (is_file($in) && $contents = file_get_contents($in)) {
			$this->input = explode("\n", $contents);
		} else {
			$this->input = array($in);
		}
		$this->result = array();
	}

	protected function getValidDimensions (string $str) {
		$box = explode("x", $str);
		if (count($box) > 2) {
			if(count($box) > 3) {
				echo count($box)."D boxes not supported. Ignoring extra dimensions...\n";
				$box = array_slice($box, 0, 3);
			}

			$valid = array_map('intval', $box);
			if (min($valid) > 0) {
				return $valid;
			} else {
				echo "This is a very bad box: '$str'\n";
				return false;
			}
		} else {
			echo "This is just not a box: '$str'\n";
			return false;
		}
	}

	protected function calculateWrapping (array $box) {
		list($l, $w, $h) = $box;
		$sides = array($l*$w, $w*$h, $h*$l);
		array_push($sides, array_sum($sides)*2);
		return $sides;
	}

	public function process() {
		if (!is_array($this->input)) return NULL;
		foreach ($this->input as $key => $raw) {
			if (empty($raw)) continue;
			if ($prism = $this->getValidDimensions($raw)) {
				$wrapping = $this->calculateWrapping($prism);
				$this->result[$key.":".$raw] = end($wrapping) + min($wrapping); // Boxes with the same size SHOULD be counted too!
			} else {
				$this->result[$raw] = NULL;
			}
		}

		return $this->result;
	}


}

// var_dump((new DayTwo("2x3x4"))->process()); // Should result 58
// var_dump((new DayTwo("1x1x10"))->process()); // Should result 43
// var_dump ((new DayTwo("4x3x4x40"))->process()); // Should result 92
// var_dump ((new DayTwo("4x2x0"))->process());
// var_dump ((new DayTwo("4x20x"))->process());
// var_dump ((new DayTwo("4x20"))->process());
$task = new DayTwo("input/day02.txt");
var_dump(array_sum($task->process())); // 1606483
?>
