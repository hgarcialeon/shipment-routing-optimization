<?php

require_once('HungarianAlgorithm.php');

/**
 * This function calculates the suitability score (SS) between a shipment and a driver based on the given algorithm.
 *
 * @param string $shipment The street name of the shipment destination.
 * @param string $driver The name of the driver.
 * @return float The calculated suitability score.
 */
function calculateSuitabilityScore($shipment, $driver) {
    $streetNameLength = mb_strlen($shipment, 'UTF-8');
    $driverNameLength = mb_strlen($driver, 'UTF-8');

    $vowelCount = mb_strlen(preg_replace('/[^aeiouAEIOUáéíóúÁÉÍÓÚ]/u', '', $driver));
    $consonantCount = mb_strlen(preg_replace('/[^a-zA-ZñÑáéíóúÁÉÍÓÚ]/u', '', $driver)) - $vowelCount;
    
    $baseSS = 0;
    if ($streetNameLength % 2 == 0) {
        // If the length of the shipment's destination street name is even, the base suitability score (SS) is the number of vowels in the driver’s
        // name multiplied by 1.5.
        $baseSS = $vowelCount * 1.5;
    } else {
        // If the length of the shipment's destination street name is odd, the base SS is the number of consonants in the driver’s name multiplied by 1.
        $baseSS = $consonantCount;
    }

    // If the length of the shipment's destination street name shares any common factors (besides 1) with the length of the driver’s name, 
    // the SS is increased by 50% above the base SS.
    for ($i = 2; $i <= min($streetNameLength, $driverNameLength); $i++) {
        if ($streetNameLength % $i == 0 && $driverNameLength % $i == 0) {
            $baseSS *= 1.5;
            break;
        }
    }

    return $baseSS;
}

/**
 * This function calculates the cost matrix required for the Hungarian algorithm.
 * The cost matrix is calculated based on the suitability score between each shipment and driver.
 *
 * @param array $shipments An array of shipment destination street names.
 * @param array $drivers An array of driver names.
 * @return array The cost matrix where each element represents the negative of the suitability score.
 */
function calculateCostMatrix($shipments, $drivers) {
    $costMatrix = [];

    foreach ($shipments as $shipment) {
        $row = [];

        foreach ($drivers as $driver) {
            // Calculate the suitability score between the current shipment and driver
            $score = calculateSuitabilityScore($shipment, $driver);

            // The Hungarian algorithm minimizes the cost, so we take the negative of the suitability score to convert our maximization problem into a minimization problem
            $row[] = -1 * $score;
        }

        $costMatrix[] = $row;
    }

    return $costMatrix;
}

/**
 * This function calculates the optimal assignment of shipments to drivers in order to maximize the total suitability score (SS).
 * It utilizes the Hungarian algorithm to find the optimal assignment that maximizes the total SS.
 * The function returns the total SS and a detailed assignment array which includes each shipment, the assigned driver, and the individual SS for that assignment.
 *
 * @param array $costMatrix A 2D array representing the negative suitability scores between each shipment and driver.
 * @param array $shipments An array of shipment destination street names.
 * @param array $drivers An array of driver names.
 * @return array An array containing the total suitability score and the detailed assignment array.
 */
function calculateOptimalAssignment($costMatrix, $shipments, $drivers) {
    // Create a new instance of the HungarianAlgorithm class and initialize it with the cost matrix
    $ha = new HungarianAlgorithm();  
    $ha->initData($costMatrix);  
    
    // Run the Hungarian algorithm to get the optimal assignment
    $assignment = $ha->runAlgorithm();

    $result = [];
    $totalScore = 0;

    // Loop through each assignment to calculate the total score and prepare the result array
    foreach ($assignment as $index => $assign) {
        // Find the index of the assigned driver for the current shipment
        $driverIndex = array_search(1, $assign);

        // If a driver was found for the current shipment, calculate the score and add it to the result array
        if ($driverIndex !== false) {
            // Calculate the score for the current assignment (note: the score is stored as a negative number in the cost matrix)
            $score = -$costMatrix[$index][$driverIndex];
            
            // Add the current assignment and score to the result array
            $result[] = [
                'shipment' => $shipments[$index],
                'driver' => $drivers[$driverIndex],
                'score' => $score
            ];
            
            // Add the score for the current assignment to the total score
            $totalScore += $score;
        }
    }

    // Sort the results by score in descending order
    usort($result, function($a, $b) {
        return $b['score'] <=> $a['score'];
    });
    
    // Return the total score and the sorted result array
    return [
        'totalScore' => $totalScore,
        'assignment' => $result
    ];
}

?>