<?php
/**
 * Day 3: Perfectly Spherical Houses in a Vacuum – Part Two
 * @see https://adventofcode.com/2015/day/3#part2
 * 22:22 - 22:35
 * Conclusion: the more robots Santa has, the less gifts are delivered.
 */
class DayThreeB {

	const SANTA_COUNT = 2;

	protected $input;
	protected $result;

	private $positions = array();

	function __construct (string $in) {
		if (is_file($in) && $contents = file_get_contents($in)) {
			$this->input = str_split($contents);
		} else {
			$this->input = str_split($in);
		}
		$this->result = array("0:0" => 1);

		for($i = 0; $i < self::SANTA_COUNT; $i ++) {
			$this->positions[$i] = array(0,0);
		}
	}

	protected function saveCurrentPosition ($santa) {
		if (isset($this->positions[$santa][0]) && isset($this->positions[$santa][1])) {
			$key = sprintf("%d:%d", $this->positions[$santa][0], $this->positions[$santa][1]);
			if (isset($this->result[$key])) {
				$this->result[$key] ++;
			} else {
				$this->result[$key] = 1;
			}
		} else {
			echo "404 Santa #$santa not found!?!!4!";
		}
	}
 
	public function process() {
		if (!is_array($this->input)) return NULL;
		foreach ($this->input as $key => $char) {
			$currentSanta = $key %  self::SANTA_COUNT;
			if (!isset($this->positions[$currentSanta])) echo "Santa #$currentSanta may not exist.";
			switch ($char) {
				case '^':
					$this->positions[$currentSanta][1]++;
					break;
				case '>':
					$this->positions[$currentSanta][0]++;
					break;
				case 'v':
					$this->positions[$currentSanta][1]--;
					break;
				case '<':
					$this->positions[$currentSanta][0]--;
					break;
				default:
					echo "Ignoring invalid character: '$char'\n";
					break;
			}
			$this->saveCurrentPosition($currentSanta);
		}

		return $this->result;
	}


}

// var_dump((new DayThreeB("^v"))->process()); // Should result 3
// var_dump((new DayThreeB("^>v<"))->process()); // Should result 3
// var_dump((new DayThreeB("^v^v^v^v^v"))->process()); // Should result 11
// var_dump((new DayThreeB("<>ˇ"))->process()); // Should result 3
$task = new DayThreeB("input/day03.txt");
$result = $task->process();
echo "Santa with ".(DayThreeB::SANTA_COUNT-1)." robot(s) delivered ".array_sum($result)." presents to ".count($result)." houses. The luckiest kid got ".max($result)." presents";
echo "<hr>";
var_dump($result); // array(2631)

?>
