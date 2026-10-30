<?php

// Azure SQL connection
$serverName = "tcp:mycardiffmet.database.windows.net,1433";

$connectionOptions = array(
    "Database" => "myDatabase",
    "Uid" => "myadmin",
    "PWD" => getenv("DB_PASSWORD"),
    "Encrypt" => true,
    "TrustServerCertificate" => false
);

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: register.php");
    exit();
}

// Get form details
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Validate fields
if ($name === '' || $email === '' || $password === '') {
    header("Location: register.php?error=" . urlencode("Please complete all fields."));
    exit();
}

if (strlen($name) > 100 ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    strlen($email) > 100 ||
    strlen($password) < 8) {

    header("Location: register.php?error=" . urlencode("Please check your registration details."));
    exit();
}

// Check database password
$dbPassword = getenv("DB_PASSWORD");

if (!$dbPassword) {
    error_log("DB_PASSWORD is missing.");
    header("Location: register.php?error=" . urlencode("Database configuration error."));
    exit();
}

// Connect to Azure SQL
$connectionOptions['PWD'] = $dbPassword;

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    error_log(print_r(sqlsrv_errors(), true));
    header("Location: register.php?error=" . urlencode("Database connection failed."));
    exit();
}

// Check duplicate email
$checkSql = "SELECT id FROM shopusers WHERE email = ?";
$checkStmt = sqlsrv_query($conn, $checkSql, array($email));

if ($checkStmt === false) {
    error_log(print_r(sqlsrv_errors(), true));
    sqlsrv_close($conn);
    header("Location: register.php?error=" . urlencode("Unable to check email."));
    exit();
}

if (sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC)) {
    sqlsrv_free_stmt($checkStmt);
    sqlsrv_close($conn);
    header("Location: register.php?error=" . urlencode("Email already registered."));
    exit();
}

sqlsrv_free_stmt($checkStmt);

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert new customer
$sql = "INSERT INTO shopusers (name, email, password)
        VALUES (?, ?, ?)";

$params = array($name, $email, $hashedPassword);

$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    error_log(print_r(sqlsrv_errors(), true));
    sqlsrv_close($conn);
    header("Location: register.php?error=" . urlencode("Registration failed."));
    exit();
}

// Registration successful
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

header("Location: success.php");
exit();

?>
