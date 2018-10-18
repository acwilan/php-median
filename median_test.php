<?php

define('SMALL_DATASET_SIZE', 100);
define('MEDIUM_DATASET_SIZE', 10000);
define('LARGE_DATASET_SIZE', 1000000);

include_once 'MedianHeap.php';
include_once 'array_median.php';
include_once 'Benchmark.php';

$testSuiteResults = array();

echo "**********************".PHP_EOL;
echo "* Running test suite *".PHP_EOL;
echo "**********************".PHP_EOL;

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
echo PHP_EOL."Testing small dataset with heap strategy. Median: {$testSuiteResults[0]['median']}. Elapsed time: {$testSuiteResults[0]['elapsed']} ms.";

// Using array
Benchmark::instance()
    ->strategy('array')
    ->size('small')
    ->data($data)
    ->call('array_median')
    ->reportTo($testSuiteResults);
echo PHP_EOL."Testing small dataset with array strategy. Median: {$testSuiteResults[1]['median']}. Elapsed time: {$testSuiteResults[1]['elapsed']} ms.";


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
echo PHP_EOL."Testing medium dataset with heap strategy. Median: {$testSuiteResults[2]['median']}. Elapsed time: {$testSuiteResults[2]['elapsed']} ms.";

// Using array
Benchmark::instance()
    ->strategy('array')
    ->size('medium')
    ->data($data)
    ->call('array_median')
    ->reportTo($testSuiteResults);
echo PHP_EOL."Testing medium dataset with array strategy. Median: {$testSuiteResults[3]['median']}. Elapsed time: {$testSuiteResults[3]['elapsed']} ms.";


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
echo PHP_EOL."Testing large dataset with heap strategy. Median: {$testSuiteResults[4]['median']}. Elapsed time: {$testSuiteResults[4]['elapsed']} ms.";

// Using array
Benchmark::instance()
    ->strategy('array')
    ->size('large')
    ->data($data)
    ->call('array_median')
    ->reportTo($testSuiteResults);
echo PHP_EOL."Testing large dataset with array strategy. Median: {$testSuiteResults[5]['median']}. Elapsed time: {$testSuiteResults[5]['elapsed']} ms.";

echo PHP_EOL."Finished. Generating report...";

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
