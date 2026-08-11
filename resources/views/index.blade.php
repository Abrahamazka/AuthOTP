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
    body {
        font-family: 'Inter', sans-serif;
        background: var(--paper)
    }

    .font-mono {
        font-family: 'IBM Plex Mono', monospace;
    }
</style>

<body class="bg-[#E6E1D6]">
    <header class="flex items-center justify-between bg-[#FBF8F2] px-6 py-4 shadow-sm">
        <div class="flex items-center space-x-3">
            <div class="w-14 h-14 rounded-full bg-blue-600 text-white flex items-center justify-center overflow-hidden shadow">
                <span id="indexAvatarText" class="font-bold text-sm"></span>
                <img id="indexAvatarImg" src="" alt="Foto Profil" class="w-full h-full object-cover hidden">
            </div>

            <span id="welcomeText" class="text-gray-800 font-mono text-base">Selamat datang!</span>
        </div>
        <div class="flex gap-4">
            <button id="btnLogout" class="px-4 py-1 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-200 transition-colors">
                Keluar
            </button>
            <a href="/profile" class="px-4 py-2 bg-black text-white font-semibold rounded-lg text-sm hover:bg-gray-700">
                Profil
            </a>
        </div>
    </header>

    <script>
        const token = localStorage.getItem('token_v');

        if (!token) {
            window.location.href = '/login';
        } else {
            fetch('http://127.0.0.1:8000/api/profil', {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                })
                .then(res => {
                    if (!res.ok) throw new Error('Unauthenticated');
                    return res.json();
                })
                .then(data => {
                    if (data.role === 'admin') {
                        window.location.href = '/admin';
                        return;
                    }

                    document.getElementById('welcomeText').innerText = `Selamat datang, ${data.name || 'User'} !`;

                    const avatarImg = document.getElementById('indexAvatarImg');
                    const avatarText = document.getElementById('indexAvatarText');

                    if (data.foto) {
                        avatarImg.src = 'http://127.0.0.1:8000/storage/' + data.foto;
                        avatarImg.classList.remove('hidden');
                        avatarText.classList.add('hidden');
                    } else {
                        avatarText.innerText = (data.name || 'U').charAt(0).toUpperCase();
                        avatarImg.classList.add('hidden');
                        avatarText.classList.remove('hidden');
                    }
                })
                .catch(() => {
                    localStorage.removeItem('token_v');
                    window.location.href = '/login';
                });
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