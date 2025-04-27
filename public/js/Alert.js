document.addEventListener('DOMContentLoaded', function() {
    const notificationBanner = document.getElementById('notificationBanner');
    const closeButton = document.getElementById('closeButton');

    notificationBanner.style.display = 'flex';

    setTimeout(() => {
        notificationBanner.classList.add('show');
    }, 50);

    closeButton.addEventListener('click', function() {
        notificationBanner.classList.remove('show');
        notificationBanner.classList.add('hide');

        notificationBanner.addEventListener('transitionend', function(e) {
            if (e.propertyName === 'opacity' || e.propertyName === 'transform') {
                notificationBanner.style.display = 'none';
            }
        });
    });
});