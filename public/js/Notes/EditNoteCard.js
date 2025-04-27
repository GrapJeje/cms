document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('edit-btn')) {
            e.preventDefault();
            const noteCard = e.target.closest('.note-card');
            noteCard.classList.add('edit-mode');
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('cancel-edit-btn')) {
            e.preventDefault();
            const noteCard = e.target.closest('.note-card');
            noteCard.classList.remove('edit-mode');
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('priority-option')) {
            const value = e.target.dataset.value;
            const container = e.target.closest('.priority-options');

            container.querySelectorAll('.priority-option').forEach(opt => {
                opt.classList.remove('active');
                if (opt.dataset.value <= value) {
                    opt.classList.add('active');
                }
            });

            container.querySelector('input[name="priority"]').value = value;
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('color-option')) {
            const value = e.target.dataset.value;
            const container = e.target.closest('.color-options');

            container.querySelectorAll('.color-option').forEach(opt => {
                opt.classList.remove('active');
            });
            e.target.classList.add('active');

            container.querySelector('input[name="color"]').value = value;
        }
    });
});