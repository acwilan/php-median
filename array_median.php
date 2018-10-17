<?php

if (!function_exists('array_median')) :

    /**
     * This function takes an array input, sorts it from low to high and then
     * calculates the median
     * @param $array array The array holding the numbers
     * @return float Calculated median from input
     */
    function array_median($array) {
        sort($array);
        $len = count($array);
        $mid = $len / 2.0;
        return $len % 2 === 0 ?
            ($array[floor($mid)-1] + $array[ceil($mid)]) / 2 :
            $array[intval($mid)];
    }

endif;