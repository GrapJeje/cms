<?php if (isset($_GET['alert'])): ?>
    <div class="alert-container" id="notificationBanner">
        <link rel="stylesheet" href="<?= ROOT_PATH; ?>/public/css/Sections/Alert.css">
        <p class="notification-content"><?= $_GET['alert'] ?></p>
        <button class="close-button" id="closeButton" aria-label="Sluit melding">&times;</button>
        <script src="<?= ROOT_PATH; ?>/public/js/Alert.js" defer></script>
    </div>
<?php endif; ?>