document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const url = this.href;

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('main-content').innerHTML = data.html;

                // Optional: update URL tanpa reload
                window.history.pushState({}, '', url);
            })
            .catch(err => {
                document.getElementById('main-content').innerHTML = "<h2>Gagal memuat halaman.</h2>";
            });
        });
    });
});