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
    <link rel="stylesheet" href="<?= ROOT_PATH; ?>/public/css/note.css">
    <link rel="stylesheet" href="<?= ROOT_PATH; ?>/public/css/Sections/profile.css">
</head>
<body>

<?php require 'Sections/Alert.php'; ?>

<main class="container">
    <header>
        <h1>Cms - De Notitie Manager</h1>
        <div class="profile-container">
            <p>Welkom, <?= ucfirst($user['name']); ?>!</p>
            <img src="<?= ROOT_PATH; ?>/public/images/profile-picture.png" alt="Profiel" class="profile-icon">
            <?php require 'Sections/Profile.php'; ?>
        </div>
    </header>

    <section class="form-section">
        <form class="note-form" autocomplete="off" action="app/Http/Controllers/NoteController.php" method="POST">
            <input type="hidden" name="action" value="add">
            <div class="input-wrapper">
                <input type="text" id="noteInput" class="note-input" name="noteInput" placeholder="Typ een nieuwe notitie..." maxlength="100" required>
                <div id="charCount" class="char-count">0/100</div>
            </div>
            <button type="submit" class="submit-btn">Toevoegen</button>
        </form>
    </section>

    <section class="notes-grid">
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
                            <?php for ($i = 1; $i <= 3; $i++):
                                echo $i <= $note['priority']
                                    ? '<div class="priority-line active priority-' . $note['priority'] . '"></div>'
                                    : '<div class="priority-line"></div>';
                            endfor; ?>
                        </div>
                    </div>
                    <div class="note-buttons">
                        <form action="app/Http/Controllers/NoteController.php" method="POST" style="display: flex; gap: 0.5rem; width: 100%;">
                            <input type="hidden" name="noteId" value="<?= $note['id']; ?>">

                            <button type="submit" name="action" value="edit" class="edit-btn" style="flex: 1;">Edit!</button>
                            <button type="submit" name="action" value="done" class="delete-btn" style="flex: 1;">Klaar!</button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>

<script src="public/js/Profile.js"></script>
<script src="public/js/Notes/AddNoteCharCount.js"></script>

</body>
</html>
