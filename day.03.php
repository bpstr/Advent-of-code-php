<?php
/**
 * Day 3: Perfectly Spherical Houses in a Vacuum
 * @see https://adventofcode.com/2015/day/3
 * 10 mins
 */
class DayThree {

	protected $input;
	protected $result;

	private $posX = 0;
	private $posY = 0;

	function __construct (string $in) {
		if (is_file($in) && $contents = file_get_contents($in)) {
			$this->input = str_split($contents);
		} else {
			$this->input = str_split($in);
		}
		$this->result = array("0:0" => 1);
	}

	protected function saveCurrentPosition () {
		$key = sprintf("%d:%d", $this->posX, $this->posY);
		if (isset($this->result[$key])) {
			$this->result[$key] ++;
		} else {
			$this->result[$key] = 1;
		}
	}

	public function process() {
		if (!is_array($this->input)) return NULL;
		foreach ($this->input as $char) {
			switch ($char) {
				case '^':
					$this->posY++;
					break;
				case '>':
					$this->posX++;
					break;
				case 'v':
					$this->posY--;
					break;
				case '<':
					$this->posX--;
					break;
				default:
					echo "Ignoring invalid character: '$char'\n";
					break;
			}
			$this->saveCurrentPosition();
		}

		return $this->result;
	}


}

// var_dump((new DayThree(">"))->process()); // Should result 2
// var_dump((new DayThree("^>v<"))->process()); // Should result 4
// var_dump((new DayThree("^v^v^v^v^v"))->process()); // Should result 2
// var_dump((new DayThree("<>ˇ"))->process()); // Should result 2
$task = new DayThree("input/day03.txt");
$result = $task->process();
echo "Santa delivered ".array_sum($result)." presents to ".count($result)." houses. The luckiest kid got ".max($result)." presents";
echo "<hr>";
var_dump($result); // array(2572)

?>
