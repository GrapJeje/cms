const profileContainer = document.querySelector('.profile-container');
const logoutCard = document.getElementById('logoutCard');

profileContainer.addEventListener('click', function (event) {
    if (event.target.closest('.profile-container')) {
        logoutCard.style.display = logoutCard.style.display === 'block' ? 'none' : 'block';
    }
});

document.addEventListener('click', function (event) {
    if (!profileContainer.contains(event.target)) {
        logoutCard.style.display = 'none';
    }
});