<?php
/**
 * Day 4: The Ideal Stocking Stuffer
 * @see https://adventofcode.com/2015/day/4
 */
class DayFour {

	protected $input;
	protected $result;

	function __construct (string $in) {
		if (is_file($in)) {
			$this->input = file_get_contents($in);
		} else {
			$this->input = $in;
		}
		$this->result = 0;
	}

	public function process($zeroes = 5) {
		// return str_pad("", $zeroes, "0");
		while (strpos(md5($this->input.$this->result), str_pad("", $zeroes, "0")) !== 0) {
			$this->result++;
		}

		return $this->result;
	}


}

// echo (new DayFour("abcdef"))->process(); // Should result 609043
// echo (new DayFour("pqrstuv"))->process(); // Should result 1048970
// echo (new DayFour("420"))->process(); // Should result 2371052
// $task = new DayFour("bgvyzdsv");
// echo $task->process(); // 254575

$task = new DayFour("bgvyzdsv");
echo $task->process(6); // 254575

?>
