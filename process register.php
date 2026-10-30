
<?php

// Azure SQL Database connection
$serverName = "tcp:mycardiffmet.database.windows.net,1433";

$connectionOptions = array(
    "Database" => "myDatabase",
    "Uid" => "myadmin",
    "PWD" => getenv("DB_PASSWORD"),
    "Encrypt" => true,
    "TrustServerCertificate" => false
);

// Redirect with an error message
function showError($message) {
    header("Location: register.php?error=" . urlencode($message));
    exit();
}

// Check form submission
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: register.php");
    exit();
}

// Get submitted information
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Validate fields
if ($name === '' || $email === '' || $password === '') {
    showError("Please complete all fields.");
}

if (strlen($name) > 100) {
    showError("Name is too long.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
    showError("Please enter a valid email address.");
}

if (strlen($password) < 8) {
    showError("Password must contain at least 8 characters.");
}

// Check database password
$dbPassword = getenv("DB_PASSWORD");

if (!$dbPassword) {
    error_log("DB_PASSWORD is missing.");
    showError("Database configuration error.");
}

// Connect to Azure SQL
$connectionOptions['PWD'] = $dbPassword;

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    error_log(print_r(sqlsrv_errors(), true));
    showError("Database connection failed.");
}

// Check for duplicate email
$checkSql = "SELECT id FROM shopusers WHERE email = ?";
$checkStmt = sqlsrv_query($conn, $checkSql, array($email));

if ($checkStmt === false) {
    error_log(print_r(sqlsrv_errors(), true));
    sqlsrv_close($conn);
    showError("Unable to check email address.");
}

if (sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC)) {
    sqlsrv_free_stmt($checkStmt);
    sqlsrv_close($conn);
    showError("This email is already registered.");
}

sqlsrv_free_stmt($checkStmt);

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user into database
$sql = "INSERT INTO shopusers (name, email, password)
        VALUES (?, ?, ?)";

$params = array($name, $email, $hashedPassword);

$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    error_log("Registration error: " . print_r(sqlsrv_errors(), true));
    sqlsrv_close($conn);
    showError("Registration failed. Please try again.");
}

// Registration completed successfully
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

// Redirect to success page
header("Location: success.php");
exit();

?>
