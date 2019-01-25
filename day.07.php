<?php
/**
 * Day 7: Some Assembly Required
 * @see https://adventofcode.com/2015/day/7
 * 5 hrs
 */
class DaySeven {

	protected $input;
	public $result;
	public $operations;

	private $loop = 1;
	private $longest;
	private $time;


	function __construct (string $in) {
		if (is_file($in) && $contents = file_get_contents($in)) {
			$this->input = explode("\n", $contents);
		} else {
			$this->input = explode("\n", $in);
		}
		$this->result = array();
		$this->longest = max(array_map('strlen', $this->input));
	}

	public function set ($var, $value) {
		$this->result[$var] = $value;
		var_dump($this->result);
	}

	private function calc ($a, $b, $operation) {

		switch ($operation) {
			case 'AND':
				return $a & $b; //	And
				break;
			case 'OR':
				return $a | $b; //	Or (inclusive or)
				break;
			case 'XOR':
				return $a ^ $b; //	Xor (exclusive or)
				break;
			case 'NOT':
				return 	  ~ $b; //	Not
				break;
			case 'LSHIFT':
				return $a << $b; //	Shift left
				break;
			case 'RSHIFT':
				return $a >> $b; //	Shift right
				break;
			default:
				echo "Invalid operator: '$operation'";
			return NULL;
		}
	}

	private function getvalue ($var, $lvl = 0) {
		if ($var == "b") var_dump($this->result[$var]);
		if (isset($this->result[$var])) {
			return $this->result[$var];
		} elseif (isset($this->operations[$var])) {
			$matches = $this->operations[$var];
			if (count($matches) == 5) {
				$a = (is_numeric($matches[1])) ? intval($matches[1]) : $this->getvalue($matches[1], $lvl+1);
				$b = (is_numeric($matches[3])) ? intval($matches[3]) : $this->getvalue($matches[3], $lvl+1);
				$res = $this->calc($a, $b, $matches[2]);
				$this->result[$var] = $res;
				return $res;
			} elseif (count($matches) == 4) {
				$b = (is_numeric($matches[2])) ? intval($matches[2]) : $this->getvalue($matches[2], $lvl+1);
				$opr = $matches[1];
				if ($opr == "NOT") {
					$res = $this->calc(NULL, $b, $opr);
					$this->result[$var] = $res;
					return $res;
				} else {
					$this->result[$var] = $b;
					return $b;
				}
			}
		} else {
			return NULL;
		}
	}

	public function process ($variable = "a") {
		foreach ($this->input as $key => $instruction) {
			if (empty($instruction)) {
				continue;
			} elseif (preg_match('/([a-z]*|\d*)\s*(AND|OR|XOR|LSHIFT|RSHIFT)\s*([a-z]+|\d+)\s*->\s*([a-z]+|\d+)/s', $instruction, $matches)) {
				$var = $matches[4];
				$this->operations[$var] = $matches;
			} elseif (preg_match('/(NOT)?\s*([a-z]+|\d+)\s*->\s*([a-z]+|\d+)/s', $instruction, $matches)) {
				$b = $matches[2];
				$opr = $matches[1];
				$var = $matches[3];
				if (is_numeric($b) && empty($opr) && empty($this->result[$var])) {
					$this->result[$var] = intval($b);
				}
				$this->operations[$var] = $matches;
			} else {
				continue;
			}
		}

		return $this->getvalue($variable);
	}


}
$signals = '
123 -> x
456 -> y
x AND y -> d
x OR y -> e
x LSHIFT 2 -> f
y RSHIFT 2 -> g
NOT x -> h
NOT y -> i
';

// var_dump((new DaySeven($signals))->process());

// array(8) {
// 	["d"]=>  int(72)
// 	["e"]=>  int(507)
// 	["f"]=>  int(492)
// 	["g"]=>  int(114)
// 	["h"]=>  int(-124)
// 	["i"]=>  int(-457)
// 	["x"]=>  int(123)
// 	["y"]=>  int(456)


// $task = new DaySeven("input/day07.txt");
// var_dump($task->process("a")); // 46065

$taskb = new DaySeven("input/day07.txt");
$taskb->set("b", 46065);
var_dump($taskb->process("a")); // 14134

?>
