<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #E6E1D6;
        }

        .font-mono {
            font-family: 'IBM Plex Mono', monospace;
        }
    </style>
</head>

<body class="bg-[#E6E1D6] min-h-screen">

    <header class="flex items-center justify-between bg-[#FBF8F2] px-6 py-4 shadow-sm mb-12 sticky top-0 z-40 border-b-2 border-[#2B2318]">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 rounded-full border-2 border-[#2B2318] flex items-center justify-center overflow-hidden shadow bg-white">
                <span id="indexAvatarText" class="font-bold text-sm text-black">A</span>
                <img id="indexAvatarImg" src="" alt="Foto Profil" class="w-full h-full object-cover hidden">
            </div>
            <span id="welcomeText" class="text-gray-800 font-mono text-base font-bold">Halo admin!</span>
        </div>

        <div class="flex items-center gap-2">
            <a href="/admin" class="px-4 py-2 text-black font-semibold text-lg font-mono hover:text-gray-700 hover:underline">
                Daftar akun
            </a>
            <a href="/profile" class="px-4 py-2 text-black font-semibold text-lg font-mono hover:text-gray-700 hover:underline">
                Profil
            </a>
            <a href="/pesan" class="px-4 py-2 text-black font-bold text-lg font-mono underline">
                Kotak pesan
            </a>
        </div>

        <div class="flex gap-4">
            <button id="btnLogout" class="px-4 py-1.5 border border-gray-400 rounded-md text-gray-700 hover:bg-gray-200 transition-colors font-semibold text-sm">
                Keluar
            </button>
        </div>
    </header>

    <div class="max-w-6xl mx-auto p-8">

        <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold uppercase tracking-tight text-black">KOTAK PESAN</h1>
                <p class="text-xs text-[#6B6045] mt-1 font-medium">Laporan & saran warga</p>
            </div>
            <div class="flex items-center gap-2">
                <input type="text" id="searchInput" placeholder="CARI NAMA, JUDUL, ATAU ISI..."
                    class="w-72 px-4 py-2 border-2 border-[#2B2318] text-xs font-bold uppercase tracking-wider bg-white focus:bg-[#EDE0BC] transition-colors outline-none placeholder-gray-400">
                <div id="totalBadge" class="px-4 py-2 border-2 border-[#2B2318] bg-white text-xs font-bold uppercase tracking-wider shadow-sm">
                    0 PESAN
                </div>
            </div>
        </div>

        <div id="pesanSistem" class="hidden mb-6 p-3 border-2 border-[#2B2318] text-sm font-bold text-center bg-[#FBF6EA]"></div>

        <div class="border-2 border-[#2B2318] bg-white">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b-2 border-[#2B2318] text-[10px] uppercase tracking-widest bg-[#FBF6EA]">
                            <th class="p-3 border-r border-[#DED2AE] font-bold text-black w-1/4">PELAPOR</th>
                            <th class="p-3 border-r border-[#DED2AE] font-bold text-black">JUDUL & ISI LAPORAN</th>
                            <th class="p-3 border-r border-[#DED2AE] font-bold text-center text-black w-32">STATUS</th>
                            <th class="p-3 font-bold text-center text-black w-56">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="tabelLaporan" class="divide-y divide-[#DED2AE]">
                        <tr>
                            <td colspan="4" class="text-center p-10 text-[#8A7F5E] font-bold text-xs uppercase tracking-widest animate-pulse">
                                Memuat data laporan ...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="paginationNav" class="mt-4 flex justify-between items-center text-sm">
            <span id="pageInfo" class="text-black font-bold">Halaman 1 dari 1 (Total 0 laporan)</span>
            <div class="flex space-x-2">
                <button id="btnPrev" class="px-4 py-2 border-2 border-[#2B2318] text-xs font-bold uppercase tracking-wider hover:bg-[#EDE0BC] transition-colors disabled:opacity-40 disabled:cursor-not-allowed bg-[#E6E1D6]">
                    ← PREV
                </button>
                <button id="btnNext" class="px-4 py-2 border-2 border-[#2B2318] text-xs font-bold uppercase tracking-wider hover:bg-[#EDE0BC] transition-colors disabled:opacity-40 disabled:cursor-not-allowed bg-[#E6E1D6]">
                    NEXT →
                </button>
            </div>
        </div>

    </div>

    <div id="modalBalas" class="hidden fixed inset-0 bg-[#2B2318] bg-opacity-60 flex items-center justify-center p-4 z-50">
        <div class="bg-[#FBF6EA] border-2 border-[#2B2318] max-w-lg w-full p-6 shadow-2xl relative">
            <h2 class="font-bold text-lg uppercase mb-1 text-black">Beri Tanggapan & Kirim Email</h2>
            <p class="text-xs text-gray-600 mb-4">Tuliskan solusi/balasan untuk warga. Pesan ini akan otomatis dikirimkan ke email Gmail mereka.</p>

            <input type="hidden" id="balasLaporanId">

            <div class="mb-4">
                <label class="block text-xs font-bold uppercase mb-1">Pesan Balasan Admin</label>
                <textarea id="teksBalasan" rows="4" placeholder="Contoh: Foto profil kamu sudah kami reset. Silakan coba upload ulang..."
                    class="w-full border-2 border-[#2B2318] p-2 text-xs outline-none focus:bg-amber-50 font-medium"></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button id="btnBatalBalas" class="px-4 py-2 border-2 border-[#2B2318] text-xs font-bold uppercase hover:bg-gray-200">
                    Batal
                </button>
                <button id="btnKirimBalasan" class="px-5 py-2 border-2 border-[#2B2318] bg-[#B4F0C3] hover:bg-[#93ECA8] text-black text-xs font-bold uppercase">
                    Tandai Selesai & Kirim Email
                </button>
            </div>
        </div>
    </div>

    <script>
        const token = localStorage.getItem('token_v');
        let allLaporans = [];
        let filteredLaporans = [];
        let currentPage = 1;
        const itemsPerPage = 5;

        if (!token) {
            window.location.href = '/login';
        } else {
            fetch('http://127.0.0.1:8000/api/profil', {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(user => {
                    if (user.role !== 'admin') {
                        window.location.href = '/index';
                    } else {
                        document.getElementById('welcomeText').innerText = `Halo, ${user.name || 'Admin'}!`;

                        const avatarImg = document.getElementById('indexAvatarImg');
                        const avatarText = document.getElementById('indexAvatarText');
                        const avatarWadah = avatarImg.parentElement;

                        if (user.foto) {
                            avatarImg.src = 'http://127.0.0.1:8000/storage/' + user.foto;
                            avatarImg.classList.remove('hidden');
                            avatarText.classList.add('hidden');
                        } else {
                            avatarText.innerText = (user.name || 'A').charAt(0).toUpperCase();
                            avatarImg.classList.add('hidden');
                            avatarText.classList.remove('hidden');
                            const warnaRetro = getRetroColor(user.name);
                            avatarWadah.className = `w-12 h-12 rounded-full border-2 border-[#2B2318] text-black font-bold flex items-center justify-center overflow-hidden shadow ${warnaRetro}`;
                        }

                        muatLaporan();
                    }
                })
                .catch(() => {
                    localStorage.removeItem('token_v');
                    window.location.href = '/login';
                });
        }

        async function muatLaporan() {
            try {
                const res = await fetch('http://127.0.0.1:8000/api/admin/laporan', {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });
                const responseData = await res.json();
                if (res.ok) {
                    allLaporans = responseData.data || [];
                    filterData();
                }
            } catch (err) {
                console.error('Gagal mengambil data laporan:', err);
            }
        }

        document.getElementById('searchInput').addEventListener('input', function() {
            currentPage = 1;
            filterData();
        });

        function filterData() {
            const query = document.getElementById('searchInput').value.toLowerCase().trim();
            filteredLaporans = allLaporans.filter(l => {
                const name = (l.user?.name || '').toLowerCase();
                const email = (l.user?.email || '').toLowerCase();
                const judul = (l.judul || '').toLowerCase();
                const pesan = (l.pesan || '').toLowerCase();
                return name.includes(query) || email.includes(query) || judul.includes(query) || pesan.includes(query);
            });

            document.getElementById('totalBadge').innerText = `${filteredLaporans.length} PESAN`;
            renderTabel();
        }

        function renderTabel() {
            const tabel = document.getElementById('tabelLaporan');
            tabel.innerHTML = '';

            const totalItems = filteredLaporans.length;
            const totalPages = Math.ceil(totalItems / itemsPerPage) || 1;

            if (currentPage > totalPages) currentPage = totalPages;

            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const paginatedItems = filteredLaporans.slice(start, end);

            if (paginatedItems.length === 0) {
                tabel.innerHTML = `
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-500 font-bold uppercase text-xs">Belum ada laporan dari warga.</td>
                    </tr>`;
            } else {
                paginatedItems.forEach(l => {
                    const user = l.user || { name: 'Anonim', email: '-', foto: null };
                    const warnaWarga = getRetroColor(user.name);

                    const fotoHTML = user.foto ?
                        `<img src="http://127.0.0.1:8000/storage/${user.foto}" class="w-10 h-10 rounded-full border-2 border-[#2B2318] object-cover bg-white">` :
                        `<div class="w-10 h-10 rounded-full border-2 border-[#2B2318] text-black flex items-center justify-center font-bold text-sm ${warnaWarga}">${user.name.charAt(0).toUpperCase()}</div>`;

                    const isSelesai = l.status === 'selesai';

                    const statusSelect = `
                        <select onchange="gantiStatusLaporan(${l.id}, this.value)" class="border-2 border-[#2B2318] px-2 py-1 text-xs font-bold uppercase outline-none cursor-pointer transition-colors text-black ${isSelesai ? 'bg-[#B4F0C3] hover:bg-[#93ECA8]' : 'bg-[#FCA5A5] hover:bg-[#F87171]'}">
                            <option value="pending" ${!isSelesai ? 'selected' : ''}>PENDING</option>
                            <option value="selesai" ${isSelesai ? 'selected' : ''}>SELESAI</option>
                        </select>
                    `;

                    const btnHapus = `<button onclick="hapusLaporan(${l.id})" class="border-2 border-[#2B2318] bg-[#FCA5A5] hover:bg-red-400 text-black px-3 py-1 text-xs font-bold uppercase transition">HAPUS</button>`;

                    const tanggal = new Date(l.created_at).toLocaleString('id-ID', {
                        dateStyle: 'medium',
                        timeStyle: 'short'
                    });

                    const balasanHTML = l.balasan_admin ? `<div class="mt-2 p-2 bg-[#FBF6EA] border border-[#2B2318] text-[11px]"><span class="font-bold">Balasan Admin:</span> ${l.balasan_admin}</div>` : '';

                    const baris = `
                    <tr class="hover:bg-[#EDE0BC] transition-colors border-b border-[#DED2AE]">
                        <td class="p-4 border-r border-[#DED2AE]">
                            <div class="flex items-center space-x-3">
                                ${fotoHTML}
                                <div>
                                    <p class="font-bold text-gray-800 text-sm uppercase">${user.name}</p>
                                    <p class="text-xs text-gray-600 font-medium">${user.email}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 border-r border-[#DED2AE]">
                            <p class="font-bold text-xs text-black uppercase tracking-wide">${l.judul}</p>
                            <p class="text-xs text-gray-700 mt-1 font-medium whitespace-pre-line">${l.pesan}</p>
                            ${balasanHTML}
                            <p class="text-[10px] text-gray-500 mt-2 font-mono">${tanggal}</p>
                        </td>
                        <td class="p-4 text-center border-r border-[#DED2AE]">${statusSelect}</td>
                        <td class="p-4 text-center">
                            ${btnHapus}
                        </td>
                    </tr>`;

                    tabel.innerHTML += baris;
                });
            }

            document.getElementById('pageInfo').innerText = `Halaman ${currentPage} dari ${totalPages} (Total ${totalItems} laporan)`;

            const btnPrev = document.getElementById('btnPrev');
            const btnNext = document.getElementById('btnNext');

            btnPrev.disabled = currentPage === 1;
            btnNext.disabled = currentPage === totalPages || totalPages === 0;

            btnPrev.onclick = () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderTabel();
                }
            };
            btnNext.onclick = () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    renderTabel();
                }
            };
        }

        const modalBalas = document.getElementById('modalBalas');
        const btnBatalBalas = document.getElementById('btnBatalBalas');
        const btnKirimBalasan = document.getElementById('btnKirimBalasan');

        btnBatalBalas.addEventListener('click', () => {
            modalBalas.classList.add('hidden');
            muatLaporan(); 
        });

        function gantiStatusLaporan(id, status) {
            if (status === 'selesai') {
                document.getElementById('balasLaporanId').value = id;
                document.getElementById('teksBalasan').value = '';
                modalBalas.classList.remove('hidden');
            } else {
                eksekusiUpdateStatus(id, 'pending', null);
            }
        }

        btnKirimBalasan.addEventListener('click', async () => {
            const id = document.getElementById('balasLaporanId').value;
            const pesanBalasan = document.getElementById('teksBalasan').value.trim();

            if (!pesanBalasan) {
                alert('Harap isi pesan balasan untuk pengguna!');
                return;
            }

            btnKirimBalasan.disabled = true;
            btnKirimBalasan.innerText = 'MENGIRIM...';

            await eksekusiUpdateStatus(id, 'selesai', pesanBalasan);

            btnKirimBalasan.disabled = false;
            btnKirimBalasan.innerText = 'TANDAI SELESAI & KIRIM EMAIL';
            modalBalas.classList.add('hidden');
        });

        async function eksekusiUpdateStatus(id, status, balasan) {
            try {
                const res = await fetch(`http://127.0.0.1:8000/api/admin/laporan/${id}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token
                    },
                    body: JSON.stringify({
                        status: status,
                        balasan_admin: balasan
                    })
                });

                const data = await res.json();

                if (res.ok) {
                    tampilkanPesan(data.message, 'text-green-800');
                    muatLaporan();
                } else {
                    alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
                    muatLaporan();
                }
            } catch (err) {
                alert('Terjadi kesalahan jaringan.');
                muatLaporan();
            }
        }

        async function hapusLaporan(id) {
            if (!confirm('Apakah kamu yakin ingin menghapus laporan ini?')) return;
            try {
                const res = await fetch(`http://127.0.0.1:8000/api/admin/laporan/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });
                if (res.ok) {
                    tampilkanPesan('Laporan berhasil dihapus!', 'text-green-800');
                    muatLaporan();
                } else {
                    alert('Gagal menghapus laporan');
                }
            } catch (err) {
                alert('Terjadi kesalahan jaringan.');
            }
        }

        function tampilkanPesan(teks, warnaClass) {
            const pesanSistem = document.getElementById('pesanSistem');
            pesanSistem.innerText = teks;
            pesanSistem.className = `mb-6 p-3 border-2 border-[#2B2318] text-sm font-bold text-center bg-[#FBF6EA] block ${warnaClass}`;
            setTimeout(() => pesanSistem.classList.add('hidden'), 3000);
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

        document.getElementById('btnLogout').addEventListener('click', async () => {
            try {
                await fetch('http://127.0.0.1:8000/api/logout', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });
            } catch (err) {}
            localStorage.removeItem('token_v');
            window.location.href = '/login';
        });
    </script>
</body>

</html>