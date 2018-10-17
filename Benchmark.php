<?php

class Benchmark {

    private static $instance = NULL;

    private $callableFunction;
    private $strategy;
    private $size;
    private $elapsedTime;
    private $median;
    private $data = NULL;

    private function __construct() {
    }

    /**
     * @return Benchmark Instance of Benchmark class
     */
    public static function instance() {
        if (self::$instance === NULL) {
            self::$instance = new Benchmark();
        }
        return self::$instance;
    }

    /**
     * @param string $strategy Strategy to use (heap or array)
     * @return Benchmark The Benchmark chain
     */
    public function strategy($strategy) {
        $this->strategy = $strategy;
        return $this;
    }

    /**
     * @param string $size The size of the dataset (SMALL, MEDIUM, LARGE)
     * @return Benchmark The Benchmark chain
     */
    public function size($size) {
        $this->size = $size;
        return $this;
    }

    /**
     * @param array $data The data to be tested
     * @return Benchmark The Benchmark chain
     */
    public function data($data) {
        $this->data = $data;
        return $this;
    }

    /**
     * @param Callable $callableFunction The function to be invoked 
     * @return Benchmark The Benchmark chain
     */
    public function call($callableFunction) {
        if (is_callable($callableFunction)) {
            if ($this->data === NULL) {
                throw new RuntimeException("Must set data property before calling function");
            }
            else {
                $startTime = microtime(TRUE);
                $this->median = $callableFunction($this->data);
                $endTime = microTime(TRUE);
                $this->elapsedTime = $endTime - $startTime;
                $this->data = NULL;
            }
        } 
        else {
            throw new RuntimeException("Argument passed should be a callable function");
        }
        return $this;
    }

    /**
     * @param array $report The report array to be added the result
     */
    public function reportTo(&$report) {
        if ($report === NULL || !is_array($report)) {
            throw new RuntimeException("Report should be an initialized array");
        }
        $report []= [
            'strategy' => $this->strategy, 
            'size' => $this->size, 
            'median' => $this->median, 
            'elapsed' => $this->elapsedTime 
        ];
    }

}
