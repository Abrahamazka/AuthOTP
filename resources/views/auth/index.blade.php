<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('images/camerawowo.png') }}">
</head>
<style>
     body { font-family: 'Inter', sans-serif; background: var(--paper); }
        .font-mono { font-family: 'IBM Plex Mono', monospace; }
</style>
<body class="bg-[#E6E1D6]">
    <header class="flex items-center justify-between bg-[#FBF8F2] px-6 py-4 shadow-sm">
        <h1 class="text-lg font-mono text-gray-800">Selamat datang!</h1>
        <button id="btnLogout" class="px-4 py-1 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-200 transition-colors">
            Keluar
        </button>
    </header>

    <script>
        const token = localStorage.getItem('token_v');

        if (!token) {
            window.location.href = '/login';
        }

        const btnLogout = document.getElementById('btnLogout');

        btnLogout.addEventListener('click', async () => {
            const token = localStorage.getItem('token_v');

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
                    localStorage.removeItem('token_v');

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