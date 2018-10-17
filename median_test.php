<?php

include_once 'MedianHeap.php';
include_once 'array_median.php';

//*
$array = [];
for ($i = 0; $i < 10000; $i++) {
    $array []= rand(0, 99999);
}
/*/
$array = [1, 2, 3, 4, 5, 6, 8, 9];
//*/

print_r(MedianHeap::getMedian($array));

echo PHP_EOL;

print_r(array_median($array));