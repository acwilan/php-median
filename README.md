# php-median

Small script that tests and benchmarks two different implementations
of median calculation over an array. The first one is using a class
which in turn uses heap strategy to calculate median of a given array,
and the second one is using a plain function that uses an array internally
to store the information.

For the heap, internally the class uses two heaps, one to store the numbers greater than the median and the other to store the numbers smaller than the median. Whenever an item is added to the data storage, it checks against current median, to see which heap to store at. After the item is stored, it checks the total item count in each heap, if it differs from more than one element, then it extracts an element from the greater heap to place in the lower heap. The current median is then recalculated by either the average of the top elements on both heaps if the total count is even, or the element at the top of the heap that contains more elements if the total elements are odd.

The array method takes an array input and first it sorts it out using PHP's `sort()` function. Afterwards it gets the element located at the middle of the array if the total count of elements is odd, or the average of the two elements at (length/2-1) and (length/2).

It includes a PHP script to run the test suite, just type `php median_test.php` to see results in console.

## Requirements

- PHP >= 5 CLI
