<?php

class PrivatePerson implements Person {

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
        $arrayNames = array_map('str_getcsv', file('/var/www/html/database/PrivatePersonNames.csv'));

        $rand_keys = array_rand($arrayNames, rand(2, 6));
        shuffle($rand_keys);

        return implode(' ', array_map(function($key) use ($arrayNames) { return $arrayNames[$key][0];}, $rand_keys));
    }

    public function ramdomDocument() : string {
        $nineNumbers = sprintf('%09d', rand(0, 999999999));

        $firstDigit = $this->numbersSum(range(2, 10), strrev($nineNumbers));

        $firstDigit = (11 - ($this->mod($firstDigit, 11))) >= 10 ? 0 : (11 - ($this->mod($firstDigit, 11)));

        $secondDigit = $this->numbersSum(range(2, 11), $firstDigit . strrev($nineNumbers));

        $secondDigit = (11 - (self::mod($secondDigit, 11))) >= 10 ? 0 : (11 - (self::mod($secondDigit, 11)));

        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $nineNumbers . $firstDigit . $secondDigit);
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
