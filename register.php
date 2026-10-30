
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Join Us - Cupcake Cuties</title>

    <link rel="stylesheet" href="style.css">

    <style>
        body {
            background: #fffaf5;
        }

        .register-container {
            max-width: 480px;
            margin: 45px auto;
            padding: 20px;
        }

        .register-card {
            background: #ffffff;
            padding: 35px;
            border-radius: 25px;
            border: 3px solid #f8d5e5;
            box-shadow: 0 8px 20px rgba(217, 109, 155, 0.12);
        }

        .cupcake-icon {
            font-size: 75px;
            text-align: center;
            margin-bottom: 10px;
        }

        .register-card h2 {
            text-align: center;
            font-size: 30px;
            color: #d96d9b;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #98788b;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-weight: 800;
            color: #795568;
            margin-bottom: 7px;
        }

        .form-group input {
            width: 100%;
            padding: 13px;
            border: 2px solid #f5d9e5;
            border-radius: 15px;
            font-size: 14px;
            font-family: 'Nunito', Arial, sans-serif;
        }

        .form-group input:focus {
            outline: none;
            border-color: #e99abb;
        }

        .register-button {
            width: 100%;
            padding: 14px;
            background: #ed9fbd;
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            transition: 0.2s;
        }

        .register-button:hover {
            background: #d96d9b;
            transform: translateY(-2px);
        }

        .error {
            background: #ffe0e8;
            color: #a83c61;
            border: 1px solid #f5bdcf;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
        }

        .back-link {
            text-align: center;
            margin-top: 22px;
        }

        .back-link a {
            color: #d96d9b;
            font-weight: 800;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .decoration {
            text-align: center;
            color: #d99ab7;
            margin-top: 20px;
            font-size: 20px;
        }
    </style>

</head>

<body>

    <!-- Website Header -->

    <header>

        <h1 class="logo">🧁 Cupcake Cuties 🧁</h1>

        <p class="tagline">
            Baked with love, sprinkled with happiness! ♡
        </p>

        <nav>
            <a href="index.php">Home</a>
            <a href="register.php">Join Us</a>
        </nav>

    </header>


    <!-- Registration Form -->

    <div class="register-container">

        <div class="register-card">

            <div class="cupcake-icon">
                🧁
            </div>

            <h2>Create Your Account ♡</h2>

            <p class="subtitle">
                Join our sweet little cupcake community!
            </p>


            <!-- Display Error Messages -->

            <?php if (isset($_GET['error']) && $_GET['error'] !== ''): ?>

                <div class="error">
                    <?php
                    echo htmlspecialchars(
                        $_GET['error'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </div>

            <?php endif; ?>


            <!-- Registration Form -->

            <form method="POST" action="process_register.php">

                <div class="form-group">

                    <label for="name">
                        Your Name ♡
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Enter your name..."
                        maxlength="100"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="email">
                        Email Address 💌
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter your email..."
                        maxlength="100"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="password">
                        Create Password 🔒
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Create a password..."
                        minlength="8"
                        required
                    >

                </div>


                <button type="submit" class="register-button">
                    Join the Sweet Club! 🧁
                </button>

            </form>


            <div class="back-link">

                <a href="index.php">
                    ← Back to Cupcake Shop
                </a>

            </div>


            <div class="decoration">
                ♡ 🍓 ✨ 🧁 ✨ 🍓 ♡
            </div>

        </div>

    </div>


    <!-- Footer -->

    <footer>
        <p>Made with love at Cupcake Cuties ♡</p>
        <p>Sweet treats and happy hearts!</p>
    </footer>

</body>

</html>
