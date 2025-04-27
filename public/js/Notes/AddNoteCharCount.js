const noteInput = document.getElementById('noteInput');
const charCount = document.getElementById('charCount');

noteInput.addEventListener('input', () => {
    const length = noteInput.value.length;
    charCount.textContent = `${length}/100`;

    if (length > 100) charCount.style.color = 'red';
    else charCount.style.color = '#666';
});