<?php

// Array with names
$a[] = "Anna";
$a[] = "Badrish";
$a[] = "Chandra";
$a[] = "Dinesh";
$a[] = "Elephant";
$a[] = "Fish";
$a[] = "Ganesh";
$a[] = "Hemanth";
$a[] = "Ice cream";
$a[] = "John";
$a[] = "Kiran";
$a[] = "Likith";
$a[] = "Naveen";
$a[] = "Om";
$a[] = "Petter";
$a[] = "Aravindh";
$a[] = "Rupesh";
$a[] = "Car";
$a[] = "Dog";
$a[] = "Elephant";
$a[] = "tiger";
$a[] = "Sunny";
$a[] = "Tharun";
$a[] = "Uma";
$a[] = "Vani";
$a[] = "lokesh";
$a[] = "chaitu";
$a[] = "vijay";
$a[] = "pushpa";
$a[] = "Vicky";

$q = $_REQUEST["q"];

$hint = "";
// lookup all hints from array if $q is different from ""
if ($q !== "") {
    $q = strtolower($q);
    $len = strlen($q);
    foreach ($a as $name) {
        if (stristr($q, substr($name, 0, $len))) {
            if ($hint === "") {
                $hint = $name;
            } else {
                $hint .= ", $name";
            }
        }
    }
}
echo $hint === "" ? "no suggestion" : $hint;
