<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Form</title>
</head>
<body>
    <form action="code.php" method="post">
        <div>
            <div>
                <label for="firstName">Name:</label>
                <input type="text" name="firstName" id="firstName">
            </div><br>
            <div>
                <label for="surname">Surname:</label>
                <input type="text" name="surname" id="surname">
            </div><br>
            <div>
                <label for="idNumber">ID Number:</label>
                <input type="number" name="idNumber" id="idNumber" minlength="13" maxlength="13">
            </div><br>
            <div>
                <label for="dateOfBirth">Date of Birth:</label>
                <input type="date" name="dateOfBirth" id="dateOfBirth">
            </div><br>
        </div>
        <div>
            <button type="submit" name="btnSubmit">Submit</button>
            <button type="reset" name="btnCancel">Cancel</button>
        </div>
    </form>
</body>
<?php
//Linking html form page to index.php
//include("index.php");
?>
</html>