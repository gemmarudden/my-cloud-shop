
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Us - Cupcake Cuties</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1 class="logo">🧁 Cupcake Cuties 🧁</h1>
    <p class="tagline">Join our sweet little community! ♡</p>
</header>

<div class="container" style="max-width:500px;">

    <div class="card">

        <h2 style="text-align:center; font-size:30px;">
            Create Your Account ♡
        </h2>

        <p style="text-align:center;">
            We're so happy you're here!
        </p>

        <?php if (isset($_GET['error'])): ?>
            <div class="error">
                <?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="process_register.php">

            <label for="name">Your Name ♡</label>
            <input
                type="text"
                id="name"
                name="name"
                placeholder="Enter your name..."
                maxlength="100"
                required
            >

            <label for="email">Email Address 💌</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email..."
                maxlength="100"
                required
            >

            <label for="password">Password 🔒</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Create a password..."
                minlength="8"
                required
            >

            <button type="submit" class="btn" style="width:100%;">
                Join the Sweet Club! 🧁
            </button>

        </form>

        <p style="text-align:center; margin-top:20px;">
            <a href="index.php" style="color:#d96d9b;">
                ← Back to the cupcake shop
            </a>
        </p>

    </div>

</div>

<footer>
    Sweet dreams are made of cupcakes! ♡
</footer>

</body>
</html>
