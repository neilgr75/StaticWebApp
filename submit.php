<?php
// Azure SQL connection settings
$serverName   = "ng-test-server.database.windows.net"; // e.g. myserver.database.windows.net
$databaseName = "NGTestDB";
$username     = "ng";            // for Azure SQL
$password     = "Paws7805";

$connectionOptions = array(
    "Database" => $databaseName,
    "Uid"      => $username,
    "PWD"      => $password,
    "Encrypt"  => 1,
    "TrustServerCertificate" => 0
);

// Connect to Azure SQL
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Get form values (basic example – add validation/sanitization as needed)
$firstname = $_POST['firstname'] ?? '';
$lastname  = $_POST['lastname'] ?? '';
$email     = $_POST['email'] ?? '';

// Prepare INSERT statement
$sql = "INSERT INTO Registrations (FirstName, LastName, Email)
        VALUES (?, ?, ?)";

$params = array($firstname, $lastname, $email);

$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    echo "Error inserting data.<br>";
    die(print_r(sqlsrv_errors(), true));
} else {
    echo "Registration saved successfully.";
}

// Clean up
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
