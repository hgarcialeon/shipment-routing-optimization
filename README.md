# Shipment Routing Optimization Program

This program optimizes the assignment of shipments to drivers based on a specific suitability score algorithm. It takes two newline separated files as input, one containing the street addresses of shipment destinations and the other containing the names of the drivers. The program then calculates the suitability score for each driver-shipment pair and assigns shipments to drivers in a way that maximizes the total suitability score.

## Approach to Solve the Problem

1. **Parsing Input Files**: The program reads two newline separated files to obtain the list of shipment destinations and the list of drivers.
   
2. **Calculating Suitability Score (SS)**: Utilizing a top-secret algorithm, the program calculates the SS for each shipment-driver pair.

3. **Optimizing Total SS**: An algorithm is employed to maximize the total SS across the set of drivers, ensuring the most suitable driver is assigned to each shipment.

4. **Outputting Results**: The program outputs the total SS along with the matching between shipment destinations and drivers, providing a clear and optimized assignment strategy.

## Requirements

- PHP 7.4 or higher
- A modern terminal to run PHP scripts from the command line

## Installation

1. Clone the repository to your local machine using the following command:

```bash
git clone https://github.com/hgarcialeon/shipment-routing-optimization.git
```

2. Navigate to the project directory:

```bash
cd shipment-routing-optimization
```

## Usage

1. **Preparing Input Files**: Create two newline separated files in the `examples/` directory:
- `example_shipments.txt`: This file should contain the street addresses of shipment destinations, one per line.
- `example_drivers.txt`: This file should contain the names of the drivers, one per line.

2. **Running the Program**: Navigate to the `src/` directory and use the following command to run the program:

```bash
cd src/
php main.php ../examples/example_shipments.txt ../examples/example_drivers.txt
```

3. **Viewing the Results**: The program will display the total suitability score and the assignments of shipment destinations to drivers, ordered by score from highest to lowest.

## Testing

To ensure the program functions correctly, you can run the included test cases. Currently, there is a test script available to test the `calculateSuitabilityScore` function. Here's how you can run it:

1. Navigate to the `tests/` directory:
```bash
cd tests/
```

2. Run the `TestUtil.php` script to execute the test cases:
```bash
php TestUtil.php
```

This script will run a series of test cases on the `calculateSuitabilityScore` function and output whether each test passed or failed, along with the expected and actual results.

Feel free to add more test cases to the `TestUtil.php` script to cover more scenarios and ensure the robustness of the function.

## Assumptions

#### 1. Street Name Length Calculation:
- Assumption 1: The length of the shipment's destination street name includes spaces and potentially multibyte characters (like "ñ"). The mb_strlen function is used to correctly calculate the length of street names, considering multibyte characters as a single character.

#### 2. Driver Name Length Calculation:
- Assumption 2: The length of the driver's name includes spaces and potentially multibyte characters. The mb_strlen function is used to correctly calculate the length of driver names, considering multibyte characters as a single character.

#### 3. Vowel and Consonant Count in Driver's Name:
- Assumption 3: The algorithm assumes that the driver's names are constructed using an alphabet predominantly found in English or Spanish languages. This includes the handling of special characters such as "ñ" and accented vowels (á, é, í, ó, ú, and their uppercase counterparts). The vowel count is determined using the regular expression /[^aeiouAEIOUáéíóúÁÉÍÓÚ]/u, which counts all the vowels including the accented ones. The consonant count is determined by first counting all the alphabetic characters (including "ñ" and "Ñ" and accented vowels) using the regular expression /[^a-zA-ZñÑáéíóúÁÉÍÓÚ]/u, and then subtracting the vowel count from this total. This approach ensures a correct count of vowels and consonants for names in these languages, potentially limiting its effectiveness with names from other languages.

#### 4. Case Sensitivity:
- Assumption 4: The algorithm is case-insensitive when counting vowels and consonants in the driver's name. This means that both uppercase and lowercase vowels are counted as vowels, and the same for consonants.

#### 5. File Formatting:
- Assumption 5: The files are well-formatted, meaning that each line in the shipment file contains a valid street address and each line in the driver file contains a valid driver name. There are no blank lines or lines with only spaces.

#### 6. Error Handling:
- Assumption 6: The algorithm does not include error handling for malformed input, as per the instructions. This means that it does not handle cases where the input files contain invalid data (like lines with only spaces or numbers in the driver names).