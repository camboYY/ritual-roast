<?php


/**
 * Include the aws php sdk
 * Follow the below instructions for deep dive
 * https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/getting-started_installation.html
 */
require 'vendor/aws-autoloader.php';

/**
 * Import SecretsManagerClient and AwsException to be used
 */
/**
 * Create a SecretsManagerClient object
 */




$username = getenv("DB_USER");
$password = getenv("DB_PASS");
$host = getenv("DB_HOST");
$database = getenv("DB_NAME");

$connection = new mysqli($host, $username, $password, $database);

if ($connection->connect_error) {
    echo "error in connection";
} else {
    $table = mysqli_real_escape_string($connection, "beverage_voting");

    $checktable = mysqli_query($connection, "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$table' AND TABLE_SCHEMA = '$database'");

    if (mysqli_num_rows($checktable) > 0) {
        
    } else {
        $query = "CREATE TABLE `beverage_voting` (
            `beverage_voting_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `name` varchar(50) NOT NULL,
            `email` varchar(50) NOT NULL,
            `beverage` varchar(50) NOT NULL,
            `created_on` datetime NOT NULL DEFAULT current_timestamp()
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";

        if ($connection->query($query) === TRUE) {
            
        } else {
            echo json_encode(array('message' => 'Error on submit data', 'status' => 'error', 'sql_error' => mysqli_error($connection)));
//            echo "Error creating table: " . $connection->error;
            die();
        }
    }
}
?>
