
<?php

// Database connection details
$serverName = "tcp:mycardiffmet.database.windows.net,1433";

$connectionOptions = array(
    "Database" => "myDatabase",
    "Uid" => "myadmin",
    "PWD" => getenv("DB_PASSWORD"),
    "Encrypt" => true,
    "TrustServerCertificate" => false
);

// Only process form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get form data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic validation
    if (!empty($name) && !empty($email) && !empty($password)) {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: register.html?error=Invalid+email+address");
            exit();
        }

        if (strlen($password) < 8) {
            header("Location: register.html?error=Password+must+be+at+least+8+characters");
            exit();
        }

        // Connect to Azure SQL Database
        $conn = sqlsrv_connect($serverName, $connectionOptions);

        if ($conn === false) {

            // Database connection error
            error_log(print_r(sqlsrv_errors(), true));

            header("Location: register.html?error=Database+connection+failed");
            exit();

        } else {

            // Hash password before storing
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into database
            $sql = "INSERT INTO shopusers (name, email, password)
                    VALUES (?, ?, ?)";

            $params = array($name, $email, $hashed_password);

            $stmt = sqlsrv_query($conn, $sql, $params);

            if ($stmt === false) {

                // Capture database errors
                error_log(print_r(sqlsrv_errors(), true));

                sqlsrv_close($conn);

                header("Location: register.html?error=Registration+failed");
                exit();

            } else {

                // Registration successful
                sqlsrv_free_stmt($stmt);
                sqlsrv_close($conn);

                header("Location: success.php");
                exit();
            }
        }

    } else {

        // Required fields are missing
        header("Location: register.html?error=Please+fill+all+fields");
        exit();
    }

} else {

    // Redirect users accessing this page directly
    header("Location: register.html");
    exit();
}

?>
