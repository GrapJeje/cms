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
    <link rel="stylesheet" href="<?= ROOT_PATH ?>/public/css/note.css">
    <link rel="stylesheet" href="<?= ROOT_PATH ?>/public/css/profile.css">
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

    <?php if (isset($_GET['msg'])): ?>
        <div class="login-message"><?= htmlspecialchars($_GET['msg']) ?></div>
    <?php endif; ?>

    <section class="form-section">
        <form id="noteForm" autocomplete="off" action="app/Http/Controllers/NoteController.php" method="POST">
            <input type="hidden" name="action" value="add">
            <input type="text" id="noteInput" name="noteInput" placeholder="Typ een nieuwe notitie..." required>
            <button type="submit">Toevoegen</button>
        </form>
    </section>

    <section id="notes" class="notes-grid">
        <?php if (empty($notes)): ?>
            <article class="note-card">
                <p>Geen notities gevonden. Voeg er een toe!</p>
            </article>
        <?php else: ?>
            <?php foreach ($notes as $index => $note): ?>
                <article class="note-card" style="background-color: <?= $note['color'] ?>">
                    <p><?= htmlspecialchars($note['content']) ?></p>

                    <div class="priority-container">
                        <div class="priority-bar">
                            <?php
                            for ($i = 1; $i <= 3; $i++):
                                echo $i <= $note['priority'] ? '<div class="priority-line active"></div>' : '<div class="priority-line"></div>';
                            endfor;
                            ?>
                        </div>
                    </div>
                    <div class="note-buttons">
                        <form action="app/Http/Controllers/NoteController.php" method="POST">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="noteId" value="<?= $note['id'] ?>">
                            <button class="edit-btn" data-index="<?= $index ?>">Edit!</button>
                        </form>

                        <form action="app/Http/Controllers/NoteController.php" method="POST">
                            <input type="hidden" name="action" value="done">
                            <input type="hidden" name="noteId" value="<?= $note['id'] ?>">
                            <button class="delete-btn" data-index="<?= $index ?>">Klaar!</button>
                        </form>
                    </div>
                </article>
            <?php endforeach; endif; ?>
    </section>
</main>

<script src="public/js/Profile.js"></script>

</body>
</html>
