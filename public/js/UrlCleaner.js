document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('msg')) {
        history.replaceState({}, document.title, window.location.pathname);
    }
});