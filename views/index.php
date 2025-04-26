<?php
global$notes;
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <?php require ROOT_PATH . '/app/includes/head.php'; ?>
    <title>Cms - De Notitie Manager</title>
</head>
<body>

<main class="container">
    <header>
        <h1>Cms - De Notitie Manager</h1>
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

</body>
</html>
