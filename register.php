
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

            <!-- Display error message if present -->
            <?php if (isset($_GET['error'])): ?>

                <div class="error">
                    <?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?>
                </div>

            <?php endif; ?>

            <!-- Registration form -->
            <form method="POST" action="register.php">

                <div class="form-group">

                    <label for="name">Full Name *</label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Enter your full name"
                        maxlength="100"
                        required>

                </div>

                <div class="form-group">

                    <label for="email">Email *</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter your email"
                        maxlength="100"
                        required>

                </div>

                <div class="form-group">

                    <label for="password">Password *</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        minlength="8"
                        required>

                </div>

                <div class="form-group">

                    <input
                        type="submit"
                        class="btn"
                        value="Register">

                </div>

            </form>

            <div class="back-link">
                <a href="index.php">Back to Home</a>
            </div>

        </div>

    </div>

</body>
</html>
