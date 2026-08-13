<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('images/camerawowo.png') }}">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #E6E1D6;
        }

        .font-mono {
            font-family: 'IBM Plex Mono', monospace;
        }
    </style>
</head>

<body class="bg-[#E6E1D6] min-h-screen">
    <header class="flex items-center justify-between bg-[#FBF8F2] px-6 py-4 border-b border-gray-200/80 shadow-sm sticky top-0 z-40">
        <div class="flex items-center space-x-3">
            <div id="avatarWadah" class="w-11 h-11 rounded-full border border-gray-300 flex items-center justify-center overflow-hidden shadow-sm relative bg-white transition-all">
                <span id="indexAvatarText" class="font-bold text-base text-gray-800"></span>
                <img id="indexAvatarImg" src="" alt="Foto Profil" class="w-full h-full object-cover hidden">
            </div>

            <span id="welcomeText" class="text-gray-800 font-mono text-sm font-medium">Selamat datang!</span>
        </div>

        <div class="flex items-center gap-3">
            <button id="btnOpenLaporan" class="px-3.5 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg text-sm transition-all shadow-sm flex items-center gap-1.5">
                <span>Lapor Masalah</span>
            </button>

            <a href="/profile" class="px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white font-medium rounded-lg text-sm transition-all shadow-sm">
                Profil
            </a>

            <button id="btnLogout" class="px-3.5 py-2 border border-gray-300 bg-white hover:bg-gray-100 text-gray-700 font-medium rounded-lg text-sm transition-all">
                Keluar
            </button>
        </div>
    </header>

    <main class="max-w-5xl mx-auto p-6">
    </main>

    <div id="modalLaporan" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden transition-opacity duration-200">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-2xl max-w-md w-full p-6 relative transform transition-all scale-100">
            
            <button id="btnCloseLaporan" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 w-8 h-8 rounded-full flex items-center justify-center hover:bg-gray-100 transition-colors">
                X
            </button>

            <div class="mb-5">
                <h2 class="text-lg font-semibold text-gray-900 tracking-tight flex items-center gap-2">
                Layanan Laporan Masalah
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    Punya keluhan, saran, atau kendala di sistem? Tuliskan pesanmu langsung ke Admin di bawah ini.
                </p>
            </div>

            <form id="formLaporan" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Judul Laporan</label>
                    <input type="text" id="judulLaporan" required placeholder="Contoh: Kendala Ubah Foto Profil"
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Isi Laporan / Pesan</label>
                    <textarea id="pesanLaporan" rows="4" required placeholder="Jelaskan detail masalahmu di sini..."
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all resize-none"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" id="btnCancelLaporan" class="px-4 py-2 rounded-xl text-xs font-medium text-gray-600 hover:bg-gray-100 transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="btnKirimLaporan"
                        class="px-5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-medium text-xs shadow-sm transition-all">
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

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

                    document.getElementById('welcomeText').innerText = `Selamat datang, ${data.name || 'User'}!`;

                    const avatarImg = document.getElementById('indexAvatarImg');
                    const avatarText = document.getElementById('indexAvatarText');
                    const avatarWadah = document.getElementById('avatarWadah');

                    if (data.foto) {
                        avatarImg.src = 'http://127.0.0.1:8000/storage/' + data.foto;
                        avatarImg.classList.remove('hidden');
                        avatarText.classList.add('hidden');
                        avatarWadah.className = "w-11 h-11 rounded-full border border-gray-300 flex items-center justify-center overflow-hidden shadow-sm relative bg-white";
                    } else {
                        avatarText.innerText = (data.name || 'U').charAt(0).toUpperCase();
                        avatarImg.classList.add('hidden');
                        avatarText.classList.remove('hidden');

                        const warnaRetro = getRetroColor(data.name);
                        avatarWadah.className = `w-11 h-11 rounded-full border border-gray-300 flex items-center justify-center overflow-hidden shadow-sm relative text-black ${warnaRetro}`;
                    }
                })
                .catch(() => {
                    localStorage.removeItem('token_v');
                    window.location.href = '/login';
                });
        }

        function getRetroColor(name) {
            const colors = [
                'bg-[#B4F0C3]',
                'bg-[#D4C4FA]',
                'bg-[#FCA5A5]',
                'bg-[#FCD34D]',
                'bg-[#93C5FD]',
                'bg-[#F9A8D4]'
            ];
            const charCode = (name || 'U').toUpperCase().charCodeAt(0);
            return colors[charCode % colors.length];
        }

        const modalLaporan = document.getElementById('modalLaporan');
        const btnOpenLaporan = document.getElementById('btnOpenLaporan');
        const btnCloseLaporan = document.getElementById('btnCloseLaporan');
        const btnCancelLaporan = document.getElementById('btnCancelLaporan');

        const openModal = () => modalLaporan.classList.remove('hidden');
        const closeModal = () => modalLaporan.classList.add('hidden');

        btnOpenLaporan.addEventListener('click', openModal);
        btnCloseLaporan.addEventListener('click', closeModal);
        btnCancelLaporan.addEventListener('click', closeModal);

        modalLaporan.addEventListener('click', (e) => {
            if (e.target === modalLaporan) closeModal();
        });

        const btnLogout = document.getElementById('btnLogout');
        btnLogout.addEventListener('click', async () => {
            const token = localStorage.getItem('token_v');
            btnLogout.innerText = 'KELUAR...';

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
                    window.location.href = '/login';
                } else {
                    alert('Gagal logout: ' + data.message);
                    btnLogout.innerText = 'Keluar';
                }
            } catch (err) {
                alert('Terjadi kesalahan jaringan.');
                btnLogout.innerText = 'Keluar';
            }
        });

        const formLaporan = document.getElementById('formLaporan');
        const btnKirimLaporan = document.getElementById('btnKirimLaporan');

        formLaporan.addEventListener('submit', async (e) => {
            e.preventDefault();

            const judul = document.getElementById('judulLaporan').value;
            const pesan = document.getElementById('pesanLaporan').value;

            btnKirimLaporan.disabled = true;
            btnKirimLaporan.innerText = 'Mengirim...';

            try {
                const res = await fetch('http://127.0.0.1:8000/api/laporan', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token
                    },
                    body: JSON.stringify({ judul, pesan })
                });

                const data = await res.json();

                if (res.ok) {
                    alert('Berhasil: ' + data.message);
                    formLaporan.reset();
                    closeModal();
                } else {
                    alert('Gagal mengirim laporan: ' + (data.message || 'Terjadi kesalahan'));
                }
            } catch (err) {
                alert('Terjadi kesalahan jaringan.');
            } finally {
                btnKirimLaporan.disabled = false;
                btnKirimLaporan.innerText = 'Kirim Laporan';
            }
        });
    </script>
</body>

</html>