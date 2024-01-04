<?php
//echo("works here");
require_once __DIR__ . '/vendor/autoload.php';


use MongoDB\Client;
//$connectionString = getenv('MONGODB_CONNECTION_STRING');
$connectionString = 'mongodb+srv://yandre_localhost:Yandre123@cluster0.ofxuuk9.mongodb.net/';

if (!$connectionString) {
    // If not set, provide a default value or handle the error accordingly
    die('MongoDB connection string not set.');
}
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
    

    //Prevents users from using special characters or numbers in name/surname field
    if (!preg_match("/^[a-zA-Z'-]+$/", $name) || !preg_match("/^[a-zA-Z'-]+$/", $surname)) {
        echo('Please enter valid characters for name and surname. <a href="form.php">Go Back</a>');
        exit;
    }

    //if the ide number is not exactly = 13 numbers long it will not be accepted
    if(strlen($idNumber )!== 13){
        echo('Please enter a valid ID number. <a href="form.html">Go Back</a>');
        http_response_code(400);
    }else{
        try{
            $collection->insertOne($documentData);
            echo("Sign Up Successful");
            http_response_code(200);
            exit;
        } catch (Exception $e) {
            http_response_code(400);
            //echo($e);
            echo('<link rel="stylesheet" href="style.css">');

            // Repopulate the form with the user's input
            echo('<form action="code.php" method="post">');
            echo('<p>There is already an account registered to the provided ID. Please review and resubmit the form.</p>');
            echo(' <label for="firstName">Name:</label>');
            echo('<input type="text" name="firstName" value="' . htmlspecialchars($name) . '" />');
            echo('<label for="surname">Surname:</label>');
            echo('<input type="text" name="surname" value="' . htmlspecialchars($surname) . '" />');
            echo('<label for="idNumber">ID Number:</label>');
            echo('<input type="number" name="idNumber" value="' . htmlspecialchars($idNumber) . '" minlength="13" maxlength="13" />');
            echo('<label for="dateOfBirth">Date of Birth:</label>');
            echo('<input type="text" name="dateOfBirth" value="' . htmlspecialchars($dateOfBirth) . '" pattern="^(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/\d{4}$" placeholder="DD/MM/YYYY" />');
            echo('<input type="submit" value="Submit" />');
            echo('</form>');
            
            exit;
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