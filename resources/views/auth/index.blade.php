<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <header class="flex items-center justify-between bg-gray-100 px-6 py-4 shadow-sm">
        <h1 class="text-lg font-semibold text-gray-800">Selamat datang!</h1>
        <button id="btnLogout" class="px-4 py-1 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-200 transition-colors">
            Keluar
        </button>
    </header>

    <script>
        const token = localStorage.getItem('token_vip');

        if (!token) {
            window.location.href= '/login';
        }
        const btnLogout = document.getElementById('btnLogout');

        btnLogout.addEventListener('click', async () => {
            const token = localStorage.getItem('token_vip');

            try {
                const res = await fetch('http://127.0.0.1:8000/api/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token
                    }
                });

                const data = await res.json();

                if (res.ok) {
                    localStorage.removeItem('token_vip');

                    alert(data.message);

                    window.location.href = '/login';
                } else {
                    alert('Gagal logout: ' + data.message);
                }
            } catch (err) {
                alert('Terjadi kesalahan jaringan.');
            }
        });
    </script>
</body>

</html>