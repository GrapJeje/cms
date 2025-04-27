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
                <input type="text" id="noteInput" class="note-input" name="noteInput"
                       placeholder="Typ een nieuwe notitie..." maxlength="100" required>
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
                    <div class="note-content">
                        <p><?= htmlspecialchars($note['content']) ?></p>
                        <div class="priority-container">
                            <div class="priority-bar">
                                <?php for ($i = 1; $i <= 3; $i++): ?>
                                    <div class="priority-line <?= $i <= $note['priority'] ? 'active priority-' . $note['priority'] : '' ?>"></div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>

                    <form class="edit-form" action="<?= ROOT_PATH ?>/app/Http/Controllers/NoteController.php"
                          method="POST">
                        <input type="hidden" name="noteId" value="<?= $note['id'] ?>">
                        <input type="hidden" name="action" value="edit">

                        <textarea name="noteInput" class="edit-input" maxlength="100"
                                  required><?= htmlspecialchars($note['content']) ?></textarea>

                        <div class="edit-controls">
                            <div class="priority-selector">
                                <label>Prioriteit:</label>
                                <div class="priority-options">
                                    <?php for ($i = 1; $i <= 3; $i++): ?>
                                        <button type="button"
                                                class="priority-option <?= $i <= $note['priority'] ? 'active' : '' ?>"
                                                data-value="<?= $i ?>">
                                            <?= str_repeat('★', $i) ?>
                                        </button>
                                    <?php endfor; ?>
                                    <input type="hidden" name="priority" value="<?= $note['priority'] ?>">
                                </div>
                            </div>

                            <div class="color-selector">
                                <label>Kleur:</label>
                                <div class="color-options">
                                    <?php
                                    $colors = [
                                        '#FFF9C4' => 'Geel',
                                        '#E3F2FD' => 'Blauw',
                                        '#E8F5E9' => 'Groen',
                                        '#FCE4EC' => 'Roze',
                                        '#F3E5F5' => 'Paars',
                                        '#FFF3E0' => 'Oranje'
                                    ];
                                    foreach ($colors as $hex => $name): ?>
                                        <button type="button"
                                                class="color-option <?= $hex === $note['color'] ? 'active' : '' ?>"
                                                data-value="<?= $hex ?>" style="background-color: <?= $hex ?>">
                                        </button>
                                    <?php endforeach; ?>
                                    <input type="hidden" name="color" value="<?= $note['color'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="edit-buttons">
                            <button type="button" class="cancel-edit-btn">Annuleren</button>
                            <button type="submit" class="save-edit-btn">Opslaan</button>
                        </div>
                    </form>

                    <div class="note-buttons">
                        <button class="edit-btn">Bewerk</button>
                        <form action="app/Http/Controllers/NoteController.php" method="POST">
                            <input type="hidden" name="noteId" value="<?= $note['id'] ?>">
                            <input type="hidden" name="action" value="done">
                            <button type="submit" class="delete-btn">Klaar!</button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>

<script src="public/js/Profile.js"></script>
<script src="public/js/Notes/AddNoteCharCount.js"></script>
<script src="public/js/Notes/EditNoteCard.js"></script>

</body>
</html>
