<?php
/**
 * Day 2: I Was Told There Would Be No Math – Part Two
 * @see https://adventofcode.com/2015/day/2#part2
 */

class DayTwoB {

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

	protected function calculateRibbon (array $box) {
		// the shortest distance around its sides ???
		list($l, $w, $h) = $box;
		$surface = array(($l+$w)*2, ($w*$h)*2, ($h*$l)*2);
		return min ($surface);
	}

	protected function calculateBow (array $box) {
		list($l, $w, $h) = $box;
		return $l*$w*$h;
	}

	public function process() {
		if (!is_array($this->input)) return NULL;
		foreach ($this->input as $key => $raw) {
			if (empty($raw)) continue;
			if ($prism = $this->getValidDimensions($raw)) {
				$this->result[$key.":".$raw] = $this->calculateRibbon($prism) + $this->calculateBow($prism);
			} else {
				$this->result[$raw] = NULL;
			}
		}

		return $this->result;
	}


}

var_dump((new DayTwoB("2x3x4"))->process()); // Should result 34
var_dump((new DayTwoB("1x1x10"))->process()); // Should result 14
$task = new DayTwoB("input/day02.txt");
var_dump(array_sum($task->process())); // 3854530 < too high


?>
