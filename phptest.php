<!DOCTYPE html>
<html>
<head>
    <title>FileMaker API Test</title>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1>FileMaker API Test</h1>
    <pre>
<?php
// Adjust the include path for the autoloader.php file as per your setup
set_include_path(get_include_path() . PATH_SEPARATOR . 'C:/Program Files/FileMaker/FileMaker Server/Web Publishing/publishing-engine/php');
require 'autoloader.php';

// Define missing CURLOPT constants if they aren't already defined
if (!defined('CURLOPT_SSL_VERIFYPEER')) {
    define('CURLOPT_SSL_VERIFYPEER', 64);
}
if (!defined('CURLOPT_SSL_VERIFYHOST')) {
    define('CURLOPT_SSL_VERIFYHOST', 81);
}
if (!defined('CURLOPT_HTTPAUTH')) {
    define('CURLOPT_HTTPAUTH', 107);
}
if (!defined('CURLOPT_USERPWD')) {
    define('CURLOPT_USERPWD', 10005);
}
if (!defined('CURLAUTH_BASIC')) {
    define('CURLAUTH_BASIC', 1);
}

// Import AirMoi API classes
use airmoi\FileMaker\FileMaker;
use airmoi\FileMaker\FileMakerException;

try {
    echo "==========================================" . PHP_EOL;
    echo " FILEMAKER API UNIT TEST" . PHP_EOL;
    echo "==========================================" . PHP_EOL . PHP_EOL;

    // Initialize FileMaker object with your database details
    // Note: Replace 'username' and 'password' with valid credentials
    // $fm = new FileMaker('FMServer_Sample', 'localhost', 'username', 'password');
     // Initialize FileMaker object without authentication (assuming guest access)
     $fm = new FileMaker('FMServer_Sample', 'localhost', null, null);

    // Display API and server version information
    echo "API version : " . $fm->getAPIVersion() . PHP_EOL;
    echo "Min server version : " . $fm->getMinServerVersion() . PHP_EOL . PHP_EOL;

    // Specify the layout to use
    $layoutName = 'PHP Technology Test'; // Replace with your actual layout name

    // Retrieve layout and list fields
    echo "Getting layout and fields..." . PHP_EOL;
    $layout = $fm->getLayout($layoutName);
    $fields = $layout->listFields();
    echo "Fields: " . implode(', ', $fields) . PHP_EOL . PHP_EOL;

    // Retrieve all records from the specified layout
    echo "Retrieving records..." . PHP_EOL;
    $findAll = $fm->newFindAllCommand($layoutName);
    $result = $findAll->execute();

    // Check if the result is an error
    if (FileMaker::isError($result)) {
        throw new FileMakerException($result->getMessage(), $result->getCode());
    }

    $records = $result->getRecords();
    $recordCount = count($records);
    echo "Total Records Found: $recordCount" . PHP_EOL;

    // Display records in an HTML table
    echo "</pre><table><tr>";
    foreach ($fields as $field) {
        echo "<th>" . htmlspecialchars($field) . "</th>";
    }
    echo "</tr>";

    foreach ($records as $record) {
        echo "<tr>";
        foreach ($fields as $field) {
            echo "<td>" . htmlspecialchars($record->getField($field)) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table><pre>";

} catch (FileMakerException $e) {
    // Handle FileMaker API exceptions
    echo PHP_EOL . "EXCEPTION :" . PHP_EOL;
    echo "  - Code :" . $e->getCode() . PHP_EOL;
    echo "  - Message :" . $e->getMessage() . PHP_EOL;
} catch (Exception $e) {
    // Handle general exceptions
    echo PHP_EOL . "EXCEPTION :" . PHP_EOL;
    echo "  - Code :" . $e->getCode() . PHP_EOL;
    echo "  - Message :" . $e->getMessage() . PHP_EOL;
}
?>
    </pre>
</body>
</html>
