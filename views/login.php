<!doctype html>
<html lang="en">
<head>
    <?php require __DIR__ . '/../app/includes/head.php'; ?>
    <title>Cms - Login</title>
    <link rel="stylesheet" href="public/css/auth.css">
</head>

<body class="login-body">
<main class="login-container">
    <section class="login-card">
        <h1>Welkom terug</h1>
        <p>Log in om verder te gaan</p>

        <?php if (isset($_GET['msg'])): ?>
            <div class="login-message"><?= htmlspecialchars($_GET['msg']) ?></div>
        <?php endif; ?>

        <form action="/authenticate" method="POST" class="login-form">
            <div class="form-group">
                <label for="email">E-mailadres</label>
                <input type="email" id="email" name="email" required placeholder="jij@example.com">
            </div>

            <div class="form-group">
                <label for="password">Wachtwoord</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>

            <button type="submit" class="login-button">Inloggen</button>
        </form>

        <div class="login-footer">
            <p>Nog geen account? <a href="/register">Registreer hier</a></p>
        </div>
    </section>
</main>
</body>

</html>