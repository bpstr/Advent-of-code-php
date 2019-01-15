<?php
/**
 * Day 1: Not Quite Lisp
 * @see https://adventofcode.com/2015/day/1
 */
class DayOne {

	protected $input;
	protected $result;

	function __construct (string $in) {
		if (is_file($in) && $contents = file_get_contents($in)) {
			$this->input = str_split($contents);
		} else {
			$this->input = str_split($in);
		}
		$this->result = 0;
	}

	public function process() {
		if (!is_array($this->input)) return NULL;
		foreach ($this->input as $char) {
			switch ($char) {
				case '(':
					$this->result++;
					break;
				case ')':
					$this->result--;
					break;
				default:
					echo "Ignoring invalid character: '$char'\n";
					break;
			}
		}

		return $this->result;
	}


}

// echo (new DayOne("(()(()("))->process(); // Should result 3
// echo (new DayOne("))(((((q()"))->process(); // Should result 3
// echo (new DayOne("))("))->process(); // Should result -1
// echo (new DayOne(")())())"))->process(); // Should result -3
$task = new DayOne("input/day01.txt");
echo $task->process(); // 138
?>
