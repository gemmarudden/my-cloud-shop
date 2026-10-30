
<?php

// ==========================================
// DATABASE CONNECTION
// ==========================================

$serverName = "tcp:mycardiffmet.database.windows.net,1433";

$connectionOptions = array(
    "Database" => "myDatabase",
    "Uid" => "myadmin",
    "PWD" => getenv("DB_PASSWORD"),
    "Encrypt" => true,
    "TrustServerCertificate" => false
);


// ==========================================
// ERROR REDIRECT FUNCTION
// ==========================================

function redirectWithError($message) {
    header("Location: register.php?error=" . urlencode($message));
    exit();
}


// ==========================================
// PROCESS REGISTRATION FORM
// ==========================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve form data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';


    // ======================================
    // VALIDATE FORM FIELDS
    // ======================================

    if ($name === '' || $email === '' || $password === '') {
        redirectWithError("Please fill in all fields.");
    }

    // Validate name
    if (strlen($name) > 100) {
        redirectWithError("Name must not exceed 100 characters.");
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
        redirectWithError("Please enter a valid email address.");
    }

    // Validate password
    if (strlen($password) < 8) {
        redirectWithError("Password must be at least 8 characters.");
    }


    // ======================================
    // CHECK DATABASE PASSWORD
    // ======================================

    $dbPassword = getenv("DB_PASSWORD");

    if ($dbPassword === false || $dbPassword === '') {
        error_log("Database password environment variable is missing.");
        redirectWithError("Database configuration error. Please try again later.");
    }


    // ======================================
    // CONNECT TO AZURE SQL DATABASE
    // ======================================

    $connectionOptions['PWD'] = $dbPassword;

    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if ($conn === false) {

        error_log("Database connection error: " . print_r(sqlsrv_errors(), true));

        redirectWithError("Database connection failed. Please try again later.");
    }


    // ======================================
    // CHECK FOR EXISTING EMAIL
    // ======================================

    $checkSql = "SELECT id FROM shopusers WHERE email = ?";

    $checkParams = array($email);

    $checkStmt = sqlsrv_query($conn, $checkSql, $checkParams);

    if ($checkStmt === false) {

        error_log("Email check error: " . print_r(sqlsrv_errors(), true));

        sqlsrv_close($conn);

        redirectWithError("Unable to check email address.");
    }

    if (sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC)) {

        sqlsrv_free_stmt($checkStmt);
        sqlsrv_close($conn);

        redirectWithError("This email address is already registered.");
    }

    sqlsrv_free_stmt($checkStmt);


    // ======================================
    // HASH PASSWORD
    // ======================================

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if ($hashedPassword === false) {

        sqlsrv_close($conn);

        redirectWithError("Unable to process your password.");
    }


    // ======================================
    // INSERT NEW USER INTO DATABASE
    // ======================================

    $sql = "INSERT INTO shopusers (name, email, password)
            VALUES (?, ?, ?)";

    $params = array(
        $name,
        $email,
        $hashedPassword
    );

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {

        error_log("Registration database error: " . print_r(sqlsrv_errors(), true));

        sqlsrv_close($conn);

        redirectWithError("Registration failed. Please try again.");
    }


    // ======================================
    // REGISTRATION SUCCESSFUL
    // ======================================

    sqlsrv_free_stmt($stmt);

    sqlsrv_close($conn);

    header("Location: success.php");
    exit();

}


// ==========================================
// DISPLAY REGISTRATION FORM
// ==========================================

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register - MyShop</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            min-height: 100vh;
        }

        .header {
            background-color: #2c3e50;
            color: white;
            padding: 15px 0;
            text-align: center;
            width: 100%;
        }

        .header h1 {
            margin: 5px 0;
            font-size: 24px;
        }

        .header p {
            font-size: 12px;
            margin: 8px 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 20px;
        }

        .register-form {
            background: white;
            padding: 25px;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
            width: 100%;
            max-width: 340px;
        }

        .register-form h2 {
            font-size: 20px;
            margin-top: 0;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 12px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 13px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 9px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 12px;
        }

        input:focus {
            outline: none;
            border-color: #007bff;
        }

        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            width: 100%;
            font-size: 13px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .error {
            color: #721c24;
            padding: 10px;
            margin: 10px 0;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            text-align: center;
            font-size: 12px;
        }

        .back-link {
            text-align: center;
            margin-top: 12px;
            font-size: 12px;
        }

        .back-link a {
            color: blue;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

    </style>

</head>

<body>

    <div class="header">

        <h1>MyShop</h1>

        <p>Create Your Account</p>

    </div>


    <div class="container">

        <div class="register-form">

            <h2>Register</h2>


            <!-- Display error messages -->

            <?php if (isset($_GET['error'])): ?>

                <div class="error">

                    <?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?>

                </div>

            <?php endif; ?>


            <!-- Registration Form -->

            <form method="POST" action="register.php">

                <div class="form-group">

                    <label for="name">Full Name *</label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Enter your full name"
                        maxlength="100"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="email">Email *</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter your email"
                        maxlength="100"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="password">Password *</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        minlength="8"
                        required
                    >

                </div>


                <div class="form-group">

                    <input
                        type="submit"
                        class="btn"
                        value="Register"
                    >

                </div>

            </form>


            <div class="back-link">

                <a href="index.php">Back to Home</a>

            </div>

        </div>

    </div>

</body>

</html>
