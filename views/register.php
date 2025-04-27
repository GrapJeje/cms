<!doctype html>
<html lang="en">
<head>
    <?php
    require __DIR__ . '/../app/includes/head.php';
    require_once __DIR__ . '/../app/Config/config.php';
    ?>
    <title>Cms - Register</title>
    <link rel="stylesheet" href="<?= ROOT_PATH; ?>public/css/auth.css">
</head>

<body>
<?php require 'Sections/Alert.php'; ?>

<div class="login-body">
    <main class="login-container">
        <section class="login-card">
            <h1>Welkom!</h1>
            <p>Maak een account aan om verder te gaan</p>

            <?php if (isset($_GET['msg'])): ?>
                <div class="login-message"><?= htmlspecialchars($_GET['msg']) ?></div>
            <?php endif; ?>

            <form action="app/Http/Controllers/AuthController.php" method="POST" class="login-form">
                <input type="hidden" name="action" value="register">
                <div class="form-group">
                    <label for="name">Naam</label>
                    <input type="text" id="name" name="name" required placeholder="Jouw naam">
                </div>

                <div class="form-group">
                    <label for="email">E-mailadres</label>
                    <input type="email" id="email" name="email" required placeholder="jij@example.com">
                </div>

                <div class="form-group">
                    <label for="password">Wachtwoord</label>
                    <input type="password" id="password" name="password" required placeholder="••••••••">
                </div>

                <div class="form-group">
                    <label for="second_password">Herhaal wachtwoord</label>
                    <input type="password" id="second_password" name="second_password" required placeholder="••••••••">
                </div>

                <button type="submit" class="login-button">Aanmelden</button>
            </form>

            <div class="login-footer">
                <p>Al een account? <a href="<?= ROOT_PATH . "/login" ?>">Log hier in</a></p>
            </div>
        </section>
    </main>
</div>
</body>

</html>