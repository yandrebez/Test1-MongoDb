<?php
//echo("works here");
require_once __DIR__ . '/vendor/autoload.php';


use MongoDB\Client;
//use MongoDB\Driver\ServerApi;

$connectionString = 'mongodb+srv://yandre_localhost:Yandre123@cluster0.ofxuuk9.mongodb.net/?retryWrites=true&w=majority';

// Specify Stable API version 1
//$apiVersion = new MongoDB\Driver\ServerApi(MongoDB\Driver\ServerApi::V1);

// Create a new client and connect to the server
//$client = new Client($uri, [], ['serverApi' => $apiVersion]);
$client = new Client($connectionString);

$database = $client->selectDatabase('Test1');
$collection = $database->selectCollection('userDetails');

// Create a unique index on the 'ID_Number' field
$collection->createIndex(['ID_Number' => 1], ['unique' => true]);
// var_dump($_POST);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['firstName'];
    $surname = $_POST['surname'];
    $idNumber = $_POST['idNumber'];
    $dateOfBirth = $_POST['dateOfBirth'];

    $dateFormat = strtotime($dateOfBirth);
    if ($dateFormat !== false) {
        $newDate = date("d/m/Y", $dateFormat);
        //echo $newDate;
    } else {
        echo "Invalid date format";
    }

    $documentData = [
        'Name' => $name,
        'Surname' => $surname,
        'ID_Number' => $idNumber,
        'Date_of_Birth' => $newDate,
    ];
    

    if (!preg_match("/^[a-zA-Z'-]+$/", $name) || !preg_match("/^[a-zA-Z'-]+$/", $surname)) {
        echo('Please enter valid characters for name and surname. <a href="form.php">Go Back</a>');
        exit;
    }

    
    if(strlen($idNumber )!== 13){
        echo('Please enter a valid ID number. <a href="form.php">Go Back</a>');
        http_response_code(400);
    }else{
        try{
            $collection->insertOne($documentData);
            echo("Login was Successful");
            http_response_code(200);
            exit;
        } catch (Exception $e) {
            http_response_code(400);
            
            // Handle duplicate key error (ID_Number already exists)
            // $errorCode = $e->getCode();
            //  if ($errorCode == 11000) {
            //      // Redirect or display an error message for duplicate ID_Number
            echo('There is already an account registired to the provided ID. <a href="form.php">Go Back</a>"');
            //echo($e);
            exit;
            //      } else {
            //         // Handle other MongoDB exceptions
            //         // Log the error, display an error message, etc.
            //         echo("404 error");
            //         exit;
            // }
        }
    }
}else{
    echo("Method not allowed");
    http_response_code(500);
    exit;
}


//$result = $collection->insertOne($documentData);

// if ($result->getInsertedCount() > 0) {
//     echo "Document inserted successfully!\n";
// } else {
//     echo "Failed to insert document.\n";
// }

// try {
//     // Send a ping to confirm a successful connection
//     $client->selectDatabase('Test1')->command(['ping' => 1]);
//     echo "Pinged your deployment. You successfully connected to MongoDB!\n";
// } catch (Exception $e) {
//     printf($e->getMessage());
// }




// phpinfo();

// echo "MongoDB extension is ";
// echo extension_loaded("mongodb") ? "loaded" : "not loaded";


?>