<?php

require_once __DIR__ . '/../src/Util.php';

function testCalculateSuitabilityScore() {
    $tests = [
        [
            'shipment' => '123 Main Street', // length: 15
            'driver' => 'John Doe', // length: 8, vowelCount: 3 (o, o, e) consonantCount: 4 (J, h, n, D)
            'expected' => 4 // no common factors (besides 1)
        ],
        [
            'shipment' => '456 Oak Avenue', // length: 14
            'driver' => 'Jane Smith', // length: 10, vowelCount: 3 (a, e, i) consonantCount: 6 (J, n, S, m, t, h)
            'expected' => 6.75 // 2 is the common factor (besides 1)
        ],
        [
            'shipment' => 'Rancho Peñasquitos', // length: 18
            'driver' => 'Heriberto García-León', // length: 21, vowelCount: 9 (e, i, e, o, a, í, a, e, ó) consonantCount: 10 (H, r, b, r, t, G, r, c, L, n)
            'expected' => 20.25 // 3 is the common factor (besides 1)
        ],
        // ... (add more test cases as needed)
    ];

    foreach ($tests as $test) {
        $output = calculateSuitabilityScore($test['shipment'], $test['driver']);
        if ($output === $test['expected']) {
            echo "Test passed: {$test['shipment']} => {$test['driver']}\n";
        } else {
            echo "Test failed: {$test['shipment']} => {$test['driver']}. Expected {$test['expected']}, got $output\n";
        }
    }
}

testCalculateSuitabilityScore();

?>
