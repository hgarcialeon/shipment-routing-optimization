<?php

require_once 'Util.php';

/**
 * The main function that orchestrates the shipment assignment process.
 *
 * @param string $shipmentsFilePath Path to the file containing shipment addresses.
 * @param string $driversFilePath Path to the file containing driver names.
 */
function main($shipmentsFilePath, $driversFilePath) {
    // Read the shipments and drivers data from the respective files
    $shipments = file($shipmentsFilePath, FILE_IGNORE_NEW_LINES);
    $drivers = file($driversFilePath, FILE_IGNORE_NEW_LINES);

    // Calculate the cost matrix which contains the suitability scores for each shipment-driver pair    
    $costMatrix = calculateCostMatrix($shipments, $drivers);
    
    // Calculate the optimal assignment of shipments to drivers to maximize the total suitability score    
    $result = calculateOptimalAssignment($costMatrix, $shipments, $drivers);    

    displayResults($result);
}

/**
 * Function to display the results in a readable format.
 *
 * @param array $result The result array containing total score and assignment details.
 */
function displayResults($result) {
    echo "Total Suitability Score: {$result['totalScore']}\n";
    foreach ($result['assignment'] as $assignment) {
        echo "Shipment: " . $assignment['shipment'] . " - Driver: " . $assignment['driver'] . " - Score: " . $assignment['score'] . "\n";
    }
}
// Execute the main function with command line arguments for file paths
main($argv[1], $argv[2]);

?>