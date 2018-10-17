<?php

define('SMALL_DATASET_SIZE', 100);
define('MEDIUM_DATASET_SIZE', 10000);
define('LARGE_DATASET_SIZE', 1000000);

include_once 'MedianHeap.php';
include_once 'array_median.php';
include_once 'Benchmark.php';

$testSuiteResults = array();

echo "Running test suite...";

/**
 * Small dataset
 */

$data = array();
for ($i = 0; $i < SMALL_DATASET_SIZE; $i++) {
    $data []= rand(0, 9999);
}

// Using MedianHeap class
Benchmark::instance()
    ->strategy('heap')
    ->size('small')
    ->data($data)
    ->call(array('MedianHeap', 'getMedian'))
    ->reportTo($testSuiteResults);

// Using array
Benchmark::instance()
    ->strategy('array')
    ->size('small')
    ->data($data)
    ->call('array_median')
    ->reportTo($testSuiteResults);


/**
 * Medium dataset
 */

$data = array();
for ($i = 0; $i < MEDIUM_DATASET_SIZE; $i++) {
    $data []= rand(0, 9999);
}

// Using MedianHeap class
Benchmark::instance()
    ->strategy('heap')
    ->size('medium')
    ->data($data)
    ->call(array('MedianHeap', 'getMedian'))
    ->reportTo($testSuiteResults);

// Using array
Benchmark::instance()
    ->strategy('array')
    ->size('medium')
    ->data($data)
    ->call('array_median')
    ->reportTo($testSuiteResults);


/**
 * Large dataset
 */

$data = array();
for ($i = 0; $i < LARGE_DATASET_SIZE; $i++) {
    $data []= rand(0, 9999);
}

// Using MedianHeap class
Benchmark::instance()
    ->strategy('heap')
    ->size('large')
    ->data($data)
    ->call(array('MedianHeap', 'getMedian'))
    ->reportTo($testSuiteResults);

// Using array
Benchmark::instance()
    ->strategy('array')
    ->size('large')
    ->data($data)
    ->call('array_median')
    ->reportTo($testSuiteResults);

echo " Finished. Generating report...";

$report = array();

foreach ($testSuiteResults as $result) {
    if (!isset($report[$result['strategy']])) {
        $report[$result['strategy']] = array('total' => 0.0);
    }
    if (!isset($report[$result['strategy']][$result['size']])) {
        $report[$result['strategy']][$result['size']] = $result['elapsed'];
        $report[$result['strategy']]['total'] += $result['elapsed'];
    }
}
$report['heap']['avg'] = $report['heap']['total'] / 3.0;
$report['array']['avg'] = $report['array']['total'] / 3.0;

echo " done".PHP_EOL.PHP_EOL;

echo "TIME REPORT RESULTS".PHP_EOL;
echo PHP_EOL;
echo "Heap: ".PHP_EOL;
echo "Total time elapsed: {$report['heap']['total']} ms".PHP_EOL;
echo "Average time: {$report['heap']['avg']} ms".PHP_EOL;
echo PHP_EOL;
echo "Array: ".PHP_EOL;
echo "Total time elapsed: {$report['array']['total']} ms".PHP_EOL;
echo "Average time: {$report['array']['avg']} ms".PHP_EOL;
