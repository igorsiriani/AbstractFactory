<?php

class LegalPerson implements Person {

    protected $name;
    protected $document;

    public function __construct() {
        $this->name = $this->randomName();
        $this->document = $this->ramdomDocument();
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDocument() : string {
        return $this->document;
    }

    public function randomName (): string {
        $arrayNames = array_map('str_getcsv', file('/var/www/html/database/LegalPersonNames.csv'));

        $rand_keys = array_rand($arrayNames, rand(1, 3));
        if(!is_array($rand_keys)) {
            $rand_keys = array($rand_keys);
        } else {
            shuffle($rand_keys);
        }

        return implode(' ', array_map(function($key) use ($arrayNames) { return $arrayNames[$key][0];}, $rand_keys));
    }

    public function ramdomDocument() : string {
        $twelveNumbers = sprintf('%08d', rand(0, 99999999)) . '0001';

        $firstDigit = $this->numbersSum(array_merge(range(2, 9), range(2, 5)), strrev($twelveNumbers));

        $firstDigit = (11 - ($this->mod($firstDigit, 11))) >= 10 ? 0 : (11 - ($this->mod($firstDigit, 11)));

        $secondDigit = $this->numbersSum(array_merge(range(2, 9), range(2, 6)), $firstDigit . strrev($twelveNumbers));

        $secondDigit = (11 - (self::mod($secondDigit, 11))) >= 10 ? 0 : (11 - (self::mod($secondDigit, 11)));

        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $twelveNumbers . $firstDigit . $secondDigit);
    }

    private function mod($dividend, $divider) : int{
        return round($dividend - (floor($dividend / $divider) * $divider));
    }

    private function numbersSum($multipliers, $varNineNumbers) {
        return array_sum(array_map(function($value, $key) use ($varNineNumbers) {
            return $varNineNumbers[$key] * $value;
        }, $multipliers, array_keys($multipliers)));
    }
}