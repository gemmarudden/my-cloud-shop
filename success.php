
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registration Successful - MyShop</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            text-align: center;
        }

        .header {
            background-color: #2c3e50;
            color: white;
            padding: 15px 0;
            text-align: center;
            width: 100%;
        }

        .header h1 {
            font-size: 24px;
            margin: 5px 0;
        }

        .header p {
            font-size: 12px;
            margin: 8px 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
            width: 100%;
            padding: 20px;
        }

        .success-message {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
            width: 100%;
            max-width: 500px;
        }

        .success-icon {
            font-size: 48px;
            color: #28a745;
            margin-bottom: 20px;
        }

        .success-message h2 {
            color: #333;
            margin-bottom: 15px;
        }

        .success-message p {
            color: #555;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin: 10px 5px;
            font-size: 14px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        @media (max-width: 480px) {

            .success-message {
                padding: 25px 15px;
            }

            .btn {
                display: block;
                margin: 12px 0;
            }

        }

    </style>

</head>

<body>

    <!-- Website Header -->

    <div class="header">

        <h1>MyShop</h1>

        <p>Registration Successful</p>

    </div>


    <!-- Success Message -->

    <div class="container">

        <div class="success-message">

            <div class="success-icon">
                &#10004;
            </div>

            <h2>Registration Successful!</h2>

            <p>
                Your account has been created successfully.
                Welcome to MyShop!
            </p>

            <div style="margin-top: 30px;">

                <a href="index.php" class="btn">
                    Go Back to Home
                </a>

                <a href="register.php" class="btn btn-success">
                    Register Another User
                </a>

            </div>

        </div>

    </div>

</body>

</html>
