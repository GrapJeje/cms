<?php
global $notes, $user;
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <?php
    require_once __DIR__ . '/../app/Config/config.php';
    require __DIR__ . '/../app/includes/head.php';
    ?>
    <title>Cms - De Notitie Manager</title>
</head>
<body>

<main class="container">
    <header>
        <h1>Cms - De Notitie Manager</h1>
        <div class="profile-container">
            <p>Welkom, <?= ucfirst($user['name']); ?>!</p>
            <img src="<?= ROOT_PATH ?>/public/images/profile-picture.png" alt="Profiel" class="profile-icon">
            <div class="logout-card" id="logoutCard">
                <form method="POST" action="app/Http/Controllers/AuthController.php">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit" class="logout-btn">Uitloggen</button>
                </form>
            </div>
        </div>
    </header>

    <section class="form-section">
        <form id="noteForm" autocomplete="off">
            <input type="text" id="noteInput" placeholder="Typ een nieuwe notitie..." required>
            <button type="submit">Toevoegen</button>
        </form>
    </section>

    <section id="notes" class="notes-grid">
        <?php if (empty($notes)): ?>
            <article class="note-card">
                <p>Geen notities gevonden. Voeg er een toe!</p>
                <button class="delete-btn" ">Toevoegen</button>
            </article>
        <?php else: ?>
        <?php foreach ($notes as $index => $note): ?>
            <article class="note-card">
                <p><?= htmlspecialchars($note) ?></p>
                <button class="delete-btn" data-index="<?= $index ?>">Klaar!</button>
            </article>
        <?php endforeach; endif; ?>
    </section>
</main>

<script>
    const profileContainer = document.querySelector('.profile-container');
    const logoutCard = document.getElementById('logoutCard');

    profileContainer.addEventListener('click', function(event) {
        if (event.target.closest('.profile-container')) {
            logoutCard.style.display = logoutCard.style.display === 'block' ? 'none' : 'block';
        }
    });

    document.addEventListener('click', function(event) {
        if (!profileContainer.contains(event.target)) {
            logoutCard.style.display = 'none';
        }
    });
</script>

</body>
</html>
