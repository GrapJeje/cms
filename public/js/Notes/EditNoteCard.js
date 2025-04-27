document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const noteCard = this.closest('.note-card');
            noteCard.classList.add('edit-mode');
        });
    });

    document.querySelectorAll('.cancel-edit-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const noteCard = this.closest('.note-card');
            noteCard.classList.remove('edit-mode');
        });
    });

    document.querySelectorAll('.priority-option').forEach(button => {
        button.addEventListener('click', function () {
            const value = this.dataset.value;
            const container = this.closest('.priority-options');

            container.querySelectorAll('.priority-option').forEach(opt => {
                opt.classList.remove('active');
                if (opt.dataset.value <= value) {
                    opt.classList.add('active');
                }
            });

            container.querySelector('input[name="priority"]').value = value;
        });
    });

    document.querySelectorAll('.color-option').forEach(button => {
        button.addEventListener('click', function () {
            const value = this.dataset.value;
            const container = this.closest('.color-options');

            container.querySelectorAll('.color-option').forEach(opt => {
                opt.classList.remove('active');
            });
            this.classList.add('active');

            container.querySelector('input[name="color"]').value = value;
        });
    });
});