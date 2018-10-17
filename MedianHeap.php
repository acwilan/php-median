<?php

/**
 * Class implementation to calculate medians using heaps
 */
class MedianHeap {

    /**
     * @type SqlMaxHeap
     */
    private $maxHeap;
    /**
     * @type SqlMinHeap
     */
    private $minHeap;
    /**
     * @type int
     */
    private $currMedian = NULL;

    /**
     * Private constructor
     */
    private function __construct() {
        $this->maxHeap = new SplMaxHeap();
        $this->minHeap = new SplMinHeap();
    }

    /**
     * This function will add a number to the list
     * @param int $number The number to be added
     * @return void
     */
    private function add($number) {
        // If the number is greater than the current median, we push it to
        // the minHeap
        if ($this->currMedian !== NULL && $number > $this->currMedian) {
            $this->minHeap->insert($number);
        } 
        // Or if the number is less than or equal to the current median, then
        // we push it to the maxHeap
        else {
            $this->maxHeap->insert($number);
        }
        // Then we balance the heaps. If the difference between the maxHeap and
        // minHeap is greater than one, we push the element from the top of the
        // heap that contains less elements, to the heap that contains more elements.
        // If this happens, then the new current median is at the top of the greater
        // heap
        if ($this->maxHeap->count() - $this->minHeap->count() > 1) {
            $this->minHeap->insert($this->maxHeap->extract());
        }
        elseif ($this->minHeap->count() - $this->maxHeap->count() > 1) {
            $this->maxHeap->insert($this->minHeap->extract());
        } 
        // If the heaps are already balanced, then we check if the total number of
        // elements in both heaps is even, then the new median is the average of the
        // elemens at the top of both heaps,
        if (($this->maxHeap->count() + $this->minHeap->count()) % 2 === 0) {
            $this->currMedian = (floatval($this->maxHeap->top() + $this->minHeap->top()) / 2.0);
        } 
        // and if the total number of elements is odd, then the new median will be at
        // the top of the greater heap.
        elseif ($this->maxHeap->count() > $this->minHeap->count()) {
            $this->currMedian = $this->maxHeap->top();
        } 
        else {
            $this->currMedian = $this->minHeap->top();
        }
    }

    /**
     * Static function that will create an instance of MedianHeap and return the
     * median of an array by adding each element to the MedianHeap and returning
     * its median
     * @param array $data Array of numeric values
     * @return int Median of the input
     */
    public static function getMedian($data) {
        $medianHeap = new MedianHeap();
        foreach ($data as $number) {
            $medianHeap->add($number);
        }
        return $medianHeap->currMedian;
    }

}
