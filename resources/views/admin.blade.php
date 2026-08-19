<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
            <a href="/pesan" class="px-4 py-2 text-black font-bold text-lg font-mono hover:underline">
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
                <h1 class=" text-3xl font-bold uppercase">Daftar akun</h1>
                <p class="text-xs text-[#6B6045] mt-1">Dashboard admin</p>
            </div>
            <div>
                <input type="text" id="searchInput" placeholder="Cari nama, email, atau kota..."
                    class="w-64 px-4 py-2 border-2 border-[#2B2318] text-xs font-bold uppercase tracking-wider hover:bg-[#EDE0BC] transition-colors">
                <button id="btnBukaModal" class="px-4 py-2 border-2 border-[#2B2318] text-xs font-bold uppercase tracking-wider hover:bg-[#EDE0BC] transition-colors">
                    Tambah entri
                </button>
            </div>
        </div>

        <div id="pesanSistem" class="hidden mb-6 p-3 border-2 border-[#2B2318] text-sm font-bold text-center bg-[#FBF6EA]"></div>

        <div class="border-2 border-[#2B2318] bg-white">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b-2 border-[#2B2318] text-[10px] uppercase tracking-widest bg-[#FBF6EA]">
                            <th onclick="ubahSort('name')" class="p-3 border-r border-[#DED2AE] font-bold cursor-pointer hover:bg-[#EDE0BC] transition-colors group">
                                User <span id="icon-name" class="ml-1 sort-icon text-[#8A7F5E]"></span>
                            </th>
                            <th onclick="ubahSort('email')" class="p-3 border-r border-[#DED2AE] font-bold cursor-pointer hover:bg-[#EDE0BC] transition-colors group">
                                Email <span id="icon-email" class="ml-1 sort-icon text-[#8A7F5E]"></span>
                            </th>
                            <th onclick="ubahSort('role')" class="p-3 border-r border-[#DED2AE] font-bold text-center cursor-pointer hover:bg-[#EDE0BC] transition-colors group">
                                Role <span id="icon-role" class="ml-1 sort-icon text-[#8A7F5E]"></span>
                            </th>
                            <th onclick="ubahSort('kota')" class="p-3 border-r border-[#DED2AE] font-bold text-center cursor-pointer hover:bg-[#EDE0BC] transition-colors group">
                                Kota domisili <span id="icon-kota" class="ml-1 sort-icon text-[#8A7F5E]"></span>
                            </th>
                            <th class="p-3 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tabelUsers" class="divide-y divide-[#DED2AE]">
                        <tr>
                            <td colspan="5" class="text-center p-10 text-[#8A7F5E] font-bold text-xs uppercase tracking-widest animate-pulse">
                                Memuat data ...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="paginationNav" class="mt-4 flex justify-between items-center text-sm">
            <span id="pageInfo" class="text-black font-semibold">Memuat info halaman...</span>
            <div class="flex space-x-2">
                <button id="btnPrev" class="px-4 py-2 border-2 border-[#2B2318] text-xs font-bold uppercase tracking-wider hover:bg-[#EDE0BC] transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                    ← Prev
                </button>
                <button id="btnNext" class="px-4 py-2 border-2 border-[#2B2318] text-xs font-bold uppercase tracking-wider hover:bg-[#EDE0BC] transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                    Next →
                </button>
            </div>
        </div>

        </main>

        <div id="modalTambah" class="hidden fixed inset-0 bg-[#2B2318] bg-opacity-60 flex items-center justify-center p-4 z-50">
            <div class="flex max-w-2xl w-full max-h-[90vh] shadow-2xl relative">

                <div class="bg-[#FBF6EA] border-2 border-[#2B2318] flex-1 flex flex-col min-h-0">

                    <div class="px-6 pt-5 pb-4 border-b-2 border-dashed border-[#2B2318]">
                        <p class="text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Isi data pengguna baru</p>
                        <h2 class="font-slab text-xl font-bold">Tambah user</h2>
                    </div>

                    <div class="overflow-y-auto px-6 py-5 flex-1">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">

                            <div class="sm:col-span-2 text-[10px] uppercase tracking-widest text-[#8A7F5E]">Data akun</div>

                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Nama lengkap</label>
                                <input type="text" id="addNama" class="field-line w-full h-1/2">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Email</label>
                                <input type="email" id="addEmail" class="field-line w-full h-1/2">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Password</label>
                                <input type="password" id="addPassword" class="field-line w-full h-1/2">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Role</label>
                                <select id="addRole" class="field-line w-full h-1/2">
                                    <option value="user">USER</option>
                                    <option value="admin">ADMIN</option>
                                </select>
                            </div>

                            <div class="sm:col-span-2 text-[10px] uppercase tracking-widest text-[#8A7F5E] pt-3 mt-1 border-t border-dashed border-[#C9BFA0]">
                                Alamat domisili
                            </div>

                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Provinsi</label>
                                <select id="addProvinsi" class="field-line w-full">
                                    <option value="">- Pilih Provinsi -</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Kota / kabupaten</label>
                                <select id="addKota" class="field-line w-full">
                                    <option value="">- Pilih Kota -</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Kecamatan</label>
                                <select id="addKecamatan" class="field-line w-full">
                                    <option value="">- Pilih Kecamatan -</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Kelurahan</label>
                                <select id="addKelurahan" class="field-line w-full">
                                    <option value="">- Pilih Kelurahan -</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="px-6 py-4 border-t-2 border-dashed border-[#2B2318] flex justify-end gap-3">
                        <button id="btnTutupModal" class="px-4 py-2 border-2 border-[#2B2318] text-xs font-bold uppercase tracking-wider hover:bg-[#EDE0BC] transition-colors">
                            Batal
                        </button>
                        <button id="btnSimpanWarga" class="px-5 py-2 text-xs font-bold uppercase tracking-wider transition-colors">
                            Simpan user
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div id="Edit" class="hidden fixed inset-0 bg-[#2B2318] bg-opacity-60 flex items-center justify-center p-4 z-50">
            <div class="flex max-w-2xl w-full max-h-[90vh] shadow-2xl relative">
                <div class="bg-[#FBF6EA] border-2 border-[#2B2318] flex-1 flex flex-col min-h-0">
                    <div class="px-6 pt-5 pb-4 border-b-2 border-dashed border-[#2B2318]">
                        <p class="text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Perbarui data pengguna</p>
                        <h2 class="font-slab text-xl font-bold">Edit User</h2>
                    </div>

                    <div class="overflow-y-auto px-6 py-5 flex-1">
                        <input type="hidden" id="editUserId">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                            <div class="sm:col-span-2 text-[10px] uppercase tracking-widest text-[#8A7F5E]">Data Akun</div>

                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Nama Lengkap</label>
                                <input type="text" id="editNama" class="field-line w-full border border-gray-300 p-2 text-xs">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Email</label>
                                <input type="email" id="editEmail" class="field-line w-full border border-gray-300 p-2 text-xs">
                            </div>

                            <div class="sm:col-span-2 text-[10px] uppercase tracking-widest text-[#8A7F5E] pt-3 mt-1 border-t border-dashed border-[#C9BFA0]">
                                Alamat Domisili
                            </div>

                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Provinsi</label>
                                <select id="editProvinsi" class="field-line w-full"></select>
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Kota / Kabupaten</label>
                                <select id="editKota" class="field-line w-full"></select>
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Kecamatan</label>
                                <select id="editKecamatan" class="field-line w-full"></select>
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Kelurahan</label>
                                <select id="editKelurahan" class="field-line w-full"></select>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 border-t-2 border-dashed border-[#2B2318] flex justify-end gap-3">
                        <button id="btnTutupModalEdit" class="px-4 py-2 border-2 border-[#2B2318] text-xs font-bold uppercase hover:bg-[#EDE0BC]">
                            Batal
                        </button>
                        <button id="btnUpdateUser" class="px-5 py-2 border-2 border-[#2B2318] bg-[#2B2318] text-white hover:bg-black text-xs font-bold uppercase">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const token = localStorage.getItem('token_v');
            const tabelUsers = document.getElementById('tabelUsers');
            const pesanSistem = document.getElementById('pesanSistem');
            const apiWilayah = 'https://www.emsifa.com/api-wilayah-indonesia/api';

            let myUserId = null;

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
                            myUserId = user.id;

                            document.getElementById('welcomeText').innerText = `Halo, ${user.name || 'Admin'}!`;
                            const avatarImg = document.getElementById('indexAvatarImg');
                            const avatarText = document.getElementById('indexAvatarText');
                            const avatarWadah = avatarImg.parentElement;

                            if (user.foto) {
                                avatarImg.src = 'http://127.0.0.1:8000/storage/' + user.foto;
                                avatarImg.classList.remove('hidden');
                                avatarText.classList.add('hidden');

                                avatarWadah.className = "w-12 h-12 rounded-full border-2 border-[#2B2318] flex items-center justify-center overflow-hidden shadow bg-white";
                            } else {
                                avatarText.innerText = (user.name || 'A').charAt(0).toUpperCase();
                                avatarImg.classList.add('hidden');
                                avatarText.classList.remove('hidden');
                                const warnaRetro = getRetroColor(user.name);
                                avatarWadah.className = `w-12 h-12 rounded-full border-2 border-[#2B2318] text-black font-bold flex items-center justify-center overflow-hidden shadow ${warnaRetro}`;
                            }
                            tarikDataWarga();
                        }
                    })
                    .catch(() => {
                        localStorage.removeItem('token_v');
                        window.location.href = '/login';
                    });
            }
            let currentPage = 1;
            let currentSearch = '';
            let searchTimeout = null;
            let currentSortBy = 'created_at';
            let currentSortDir = 'desc';

            async function tarikDataWarga(page = 1, search = '') {
                currentPage = page;
                currentSearch = search;

                try {
                    const url = `http://127.0.0.1:8000/api/admin/users?page=${page}&search=${encodeURIComponent(search)}&sort_by=${currentSortBy}&sort_dir=${currentSortDir}`;
                    const res = await fetch(url, {
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Accept': 'application/json'
                        }
                    });

                    const json = await res.json();

                    if (res.ok) {
                        cetakTabel(json.data.data);
                        renderPagination(json.data);
                    } else {
                        tabelUsers.innerHTML = `<tr><td colspan="5" class="text-center p-4 text-red-600">${json.message}</td></tr>`;
                    }
                } catch (err) {
                    tabelUsers.innerHTML = `<tr><td colspan="5" class="text-center p-4 text-red-600">Gagal terhubung ke server.</td></tr>`;
                }
            }

            function renderPagination(meta) {
                const pageInfo = document.getElementById('pageInfo');
                const btnPrev = document.getElementById('btnPrev');
                const btnNext = document.getElementById('btnNext');

                pageInfo.innerText = `Halaman ${meta.current_page} dari ${meta.last_page} (Total ${meta.total} user)`;

                btnPrev.disabled = meta.current_page === 1;
                btnNext.disabled = meta.current_page === meta.last_page || meta.last_page === 0;

                btnPrev.onclick = () => {
                    if (meta.current_page > 1) tarikDataWarga(meta.current_page - 1, currentSearch);
                };

                btnNext.onclick = () => {
                    if (meta.current_page < meta.last_page) tarikDataWarga(meta.current_page + 1, currentSearch);
                };
            }

            document.getElementById('searchInput').addEventListener('input', function(e) {
                clearTimeout(searchTimeout);
                const query = e.target.value.trim();
                
                    tarikDataWarga(1, query);
            });

            function cetakTabel(users) {
                tabelUsers.innerHTML = '';

                users.forEach(u => {
                    const warnaWarga = getRetroColor(u.name);

                    const fotoHTML = u.foto ?
                        `<img src="http://127.0.0.1:8000/storage/${u.foto}" class="w-10 h-10 rounded-full border-2 border-[#2B2318] object-cover shadow-sm bg-white">` :
                        `<div class="w-10 h-10 rounded-full border-2 border-[#2B2318] text-black flex items-center justify-center font-bold shadow-sm ${warnaWarga}">${u.name.charAt(0).toUpperCase()}</div>`;
                    const roleSelect = `
                <select onchange="gantiRole(${u.id}, this.value)" class="border rounded p-1 text-xs font-bold outline-none cursor-pointer ${u.role === 'admin' ? 'bg-purple-100 text-purple-800 border-purple-300' : 'bg-green-100 text-green-800 border-green-300'}">
                    <option value="user" ${u.role === 'user' ? 'selected' : ''}>USER</option>
                    <option value="admin" ${u.role === 'admin' ? 'selected' : ''}>ADMIN</option>
                </select>
            `;

                    const tombolHapus = u.id === myUserId ?
                        `<span class="text-xs text-gray-400 italic">Ini Anda</span>` :
                        `<button onclick="hapusWarga(${u.id})" class="border-2 border-[#2B2318] bg-red-400 hover:bg-red-500 text-black px-2 py-1 text-xs font-bold uppercase transition">Hapus</button>`;

                    const tombolReset = u.id === myUserId ?
                        `` :
                        `<button onclick="resetSandi(${u.id})" class="border-2 border-[#2B2318] bg-blue-400 hover:bg-blue-500 text-black px-2 py-1 text-xs font-bold uppercase transition ml-2">Reset Sandi</button>`;

                    const baris = `
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 flex items-center space-x-3">
                        ${fotoHTML}
                        <span class="font-bold text-gray-800">${u.name}</span>
                    </td>
                    <td class="p-4 text-gray-600 font-medium">${u.email}</td>
                    <td class="p-4 text-center">${roleSelect}</td>
                    <td class="p-4 text-gray-600">${u.kota || '-'}</td>
                    <td class="p-4 text-center">
                        ${tombolHapus}
                        ${tombolReset}
                    </td>
                </tr>
            `;

                    tabelUsers.innerHTML += baris;
                });
            }

            async function gantiRole(id, roleBaru) {
                if (!confirm(`Yakin mengubah role menjadi ${roleBaru.toUpperCase()}?`)) {
                    tarikDataWarga();
                    return;
                }

                try {
                    const res = await fetch(`http://127.0.0.1:8000/api/admin/users/${id}/role`, {
                        method: 'PUT',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            role: roleBaru
                        })
                    });
                    const data = await res.json();

                    if (res.ok) {
                       if(id === myUserId && roleBaru == 'user'){
                        alert('Role anda diubah menjadi user!');
                        window.location.href = '/index';
                        return;
                       }
                    } else {
                        tampilkanPesan(data.message, 'text-red-700');
                    }
                } catch (e) {
                    tampilkanPesan('Terjadi kesalahan koneksi.', 'text-red-700');
                }
            }

            async function hapusWarga(id) {
                if (!confirm('Hapus akun ini secara permanen?')) return;

                try {
                    const res = await fetch(`http://127.0.0.1:8000/api/admin/users/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Accept': 'application/json'
                        }
                    });
                    const data = await res.json();

                    if (res.ok) {
                        tampilkanPesan(data.message, 'text-green-700');
                        tarikDataWarga();
                    } else {
                        tampilkanPesan(data.message, 'text-red-700');
                    }
                } catch (e) {
                    tampilkanPesan('Terjadi kesalahan koneksi.', 'text-red-700');
                }
            }

            async function resetSandi(id) {
                if (!confirm('Yakin ingin mereset sandi menjadi "Sandibaru123" ?')) return;

                try {
                    const res = await fetch(`http://127.0.0.1:8000/api/admin/users/${id}/password-reset`, {
                        method: 'PUT',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Accept': 'application/json'
                        }
                    });
                    const data = await res.json();

                    if (res.ok) {
                        tampilkanPesan(data.message, 'text-blue-700');
                    } else {
                        tampilkanPesan((data.message || 'Gagal reset sandi'), 'text-red-700');
                    }
                } catch (e) {
                    tampilkanPesan('Terjadi kesalahan koneksi.', 'text-red-700');
                }
            }

            function tampilkanPesan(teks, warnaClass) {
                pesanSistem.innerHTML = teks;
                pesanSistem.className = `mb-4 p-3 rounded-lg text-sm font-bold text-center block ${warnaClass}`;
                setTimeout(() => pesanSistem.classList.add('hidden'), 3000);
            }

            $(document).ready(function() {
                $('#addProvinsi, #addKota, #addKecamatan, #addKelurahan').select2({
                    dropdownParent: $('#modalTambah'),
                    width: '100%'
                });

                $('#addProvinsi').on('change', function() {
                    let idProv = $(this).find(':selected').data('id');

                    $('#addKota, #addKecamatan, #addKelurahan').html('<option value="">- Pilih -</option>').trigger('change.select2');

                    if (idProv) {
                        $('#addKota').html('<option value="">Memuat Kota...</option>').trigger('change.select2');
                        fetch(`${apiWilayah}/regencies/${idProv}.json`)
                            .then(res => res.json())
                            .then(regencies => {
                                let options = '<option value="">- Pilih Kota -</option>';
                                regencies.forEach(k => {
                                    options += `<option value="${k.name}" data-id="${k.id}">${k.name}</option>`;
                                });
                                $('#addKota').html(options).trigger('change.select2');
                            });
                    }
                });

                $('#addKota').on('change', function() {
                    let idKota = $(this).find(':selected').data('id');

                    $('#addKecamatan, #addKelurahan').html('<option value="">- Pilih -</option>').trigger('change.select2');

                    if (idKota) {
                        $('#addKecamatan').html('<option value="">Memuat Kecamatan...</option>').trigger('change.select2');
                        fetch(`${apiWilayah}/districts/${idKota}.json`)
                            .then(res => res.json())
                            .then(districts => {
                                let options = '<option value="">- Pilih Kecamatan -</option>';
                                districts.forEach(kec => {
                                    options += `<option value="${kec.name}" data-id="${kec.id}">${kec.name}</option>`;
                                });
                                $('#addKecamatan').html(options).trigger('change.select2');
                            });
                    }
                });

                $('#addKecamatan').on('change', function() {
                    let idKec = $(this).find(':selected').data('id');

                    $('#addKelurahan').html('<option value="">- Pilih -</option>').trigger('change.select2');

                    if (idKec) {
                        $('#addKelurahan').html('<option value="">Memuat Kelurahan...</option>').trigger('change.select2');
                        fetch(`${apiWilayah}/villages/${idKec}.json`)
                            .then(res => res.json())
                            .then(villages => {
                                let options = '<option value="">- Pilih Kelurahan -</option>';
                                villages.forEach(kel => {
                                    options += `<option value="${kel.name}">${kel.name}</option>`;
                                });
                                $('#addKelurahan').html(options).trigger('change.select2');
                            });
                    }
                });
            });

            document.getElementById('btnBukaModal').addEventListener('click', () => {
                document.getElementById('modalTambah').classList.remove('hidden');

                $('#addProvinsi').html('<option value="">Memuat Provinsi...</option>').trigger('change.select2');
                fetch(`${apiWilayah}/provinces.json`)
                    .then(res => res.json())
                    .then(provinces => {
                        let options = '<option value="">- Pilih Provinsi -</option>';
                        provinces.forEach(prov => {
                            options += `<option value="${prov.name}" data-id="${prov.id}">${prov.name}</option>`;
                        });
                        $('#addProvinsi').html(options).trigger('change.select2');
                    });
            });

            document.getElementById('btnTutupModal').addEventListener('click', () => {
                document.getElementById('modalTambah').classList.add('hidden');
            });

            document.getElementById('btnSimpanWarga').addEventListener('click', async () => {
                const nama = document.getElementById('addNama').value.trim();
                const email = document.getElementById('addEmail').value.trim();
                const password = document.getElementById('addPassword').value.trim();
                const role = document.getElementById('addRole').value;

                if (!nama || !email || !password) {
                    alert('Nama, Email, dan Password wajib diisi!');
                    return;
                }

                const btnSimpanWarga = document.getElementById('btnSimpanWarga');
                btnSimpanWarga.disabled = true;
                btnSimpanWarga.innerText = "Menyimpan...";

                try {
                    const res = await fetch('http://127.0.0.1:8000/api/admin/users', {
                        method: 'POST',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            name: nama,
                            email: email,
                            password: password,
                            role: role,
                            provinsi: $('#addProvinsi').val(),
                            kota: $('#addKota').val(),
                            kecamatan: $('#addKecamatan').val(),
                            kelurahan: $('#addKelurahan').val()
                        })
                    });

                    const data = await res.json();

                    if (res.ok) {
                        tampilkanPesan(data.message, 'text-green-700');
                        document.getElementById('modalTambah').classList.add('hidden');

                        document.getElementById('addNama').value = '';
                        document.getElementById('addEmail').value = '';
                        document.getElementById('addPassword').value = '';
                        $('#addProvinsi, #addKota, #addKecamatan, #addKelurahan').val('').trigger('change.select2');

                        tarikDataWarga();
                    } else {
                        const errDetail = data.errors ? Object.values(data.errors).flat().join(', ') : data.message;
                        alert(errDetail);
                    }
                } catch (e) {
                    alert('Terjadi kesalahan koneksi ke server.');
                } finally {
                    btnSimpanWarga.disabled = false;
                    btnSimpanWarga.innerText = "Simpan User";
                }
            });

            function cetakTabel(users) {
                tabelUsers.innerHTML = '';

                users.forEach(u => {
                    const warnaWarga = getRetroColor(u.name);

                    const fotoHTML = u.foto ?
                        `<img src="http://127.0.0.1:8000/storage/${u.foto}" class="w-10 h-10 rounded-full border-2 border-[#2B2318] object-cover shadow-sm bg-white">` :
                        `<div class="w-10 h-10 rounded-full border-2 border-[#2B2318] text-black flex items-center justify-center font-bold shadow-sm ${warnaWarga}">${u.name.charAt(0).toUpperCase()}</div>`;

                    const roleSelect = `
                    <select onchange="gantiRole(${u.id}, this.value)" class="border-2 border-[#2B2318] px-2 py-1 text-xs font-bold uppercase outline-none cursor-pointer transition-colors text-black ${u.role === 'admin' ? 'bg-[#D4C4FA] hover:bg-[#BFA8F8]' : 'bg-[#B4F0C3] hover:bg-[#93ECA8]'}">
                        <option value="user" ${u.role === 'user' ? 'selected' : ''}>USER</option>
                        <option value="admin" ${u.role === 'admin' ? 'selected' : ''}>ADMIN</option>
                    </select>
                    `;

                    let kolomAksi = '';

                    if (u.role === 'admin') {
                        if (u.id === myUserId) {
                            kolomAksi = `<span class="text-xs text-gray-400 italic font-bold">Ini Anda</span>`;
                        } else {
                            kolomAksi = `<span class="text-xs text-gray-400 italic font-bold">Sesama Admin</span>`;
                        }
                    } else {
                        const btnEdit = `<button onclick="bukaModalEdit('${u.id}', '${encodeURIComponent(u.name)}', '${u.email}', '${u.provinsi || ''}', '${u.kota || ''}', '${u.kecamatan || ''}', '${u.kelurahan || ''}')" class="border-2 border-[#2B2318] bg-amber-300 hover:bg-amber-400 text-black px-2 py-1 text-xs font-bold uppercase transition">Edit</button>`;
                        const btnHapus = `<button onclick="hapusWarga(${u.id})" class="border-2 border-[#2B2318] bg-red-400 hover:bg-red-500 text-black px-2 py-1 text-xs font-bold uppercase transition ml-1">Hapus</button>`;
                        const btnReset = `<button onclick="resetSandi(${u.id})" class="border-2 border-[#2B2318] bg-blue-400 hover:bg-blue-500 text-black px-2 py-1 text-xs font-bold uppercase transition ml-1">Reset Sandi</button>`;

                        kolomAksi = `${btnEdit} ${btnHapus} ${btnReset}`;
                    }

                    const baris = `
                    <tr class="hover:bg-[#EDE0BC] transition-colors border-b border-[#DED2AE]">
                        <td class="p-4 flex items-center space-x-3 border-r border-[#DED2AE]">
                            ${fotoHTML}
                            <span class="font-bold text-gray-800">${u.name}</span>
                        </td>
                        <td class="p-4 text-black font-medium border-r border-[#DED2AE]">${u.email}</td>
                        <td class="p-4 text-center border-r border-[#DED2AE]">${roleSelect}</td>
                        <td class="p-4 text-black border-r border-[#DED2AE] uppercase text-xs font-bold">${u.kota || '-'}</td>
                        <td class="p-4 text-center">
                            ${kolomAksi}
                        </td>
                    </tr>
                    `;

                    tabelUsers.innerHTML += baris;
                });
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
            $(document).ready(function() {
                $('#editProvinsi, #editKota, #editKecamatan, #editKelurahan').select2({
                    dropdownParent: $('#Edit'),
                    width: '100%'
                });

                $('#editProvinsi').on('change', function() {
                    let idProv = $(this).find(':selected').data('id');
                    $('#editKota, #editKecamatan, #editKelurahan').html('<option value="">- Pilih -</option>').trigger('change.select2');
                    if (idProv) {
                        fetch(`${apiWilayah}/regencies/${idProv}.json`)
                            .then(res => res.json())
                            .then(regencies => {
                                let options = '<option value="">- Pilih Kota -</option>';
                                regencies.forEach(k => {
                                    options += `<option value="${k.name}" data-id="${k.id}">${k.name}</option>`;
                                });
                                $('#editKota').html(options).trigger('change.select2');
                            });
                    }
                });

                $('#editKota').on('change', function() {
                    let idKota = $(this).find(':selected').data('id');
                    $('#editKecamatan, #editKelurahan').html('<option value="">- Pilih -</option>').trigger('change.select2');
                    if (idKota) {
                        fetch(`${apiWilayah}/districts/${idKota}.json`)
                            .then(res => res.json())
                            .then(districts => {
                                let options = '<option value="">- Pilih Kecamatan -</option>';
                                districts.forEach(kec => {
                                    options += `<option value="${kec.name}" data-id="${kec.id}">${kec.name}</option>`;
                                });
                                $('#editKecamatan').html(options).trigger('change.select2');
                            });
                    }
                });

                $('#editKecamatan').on('change', function() {
                    let idKec = $(this).find(':selected').data('id');
                    $('#editKelurahan').html('<option value="">- Pilih -</option>').trigger('change.select2');
                    if (idKec) {
                        fetch(`${apiWilayah}/villages/${idKec}.json`)
                            .then(res => res.json())
                            .then(villages => {
                                let options = '<option value="">- Pilih Kelurahan -</option>';
                                villages.forEach(kel => {
                                    options += `<option value="${kel.name}">${kel.name}</option>`;
                                });
                                $('#editKelurahan').html(options).trigger('change.select2');
                            });
                    }
                });
            });

            function bukaModalEdit(id, namaEnc, email, prov, kota, kec, kel) {
                document.getElementById('editUserId').value = id;
                document.getElementById('editNama').value = decodeURIComponent(namaEnc);
                document.getElementById('editEmail').value = email;

                $('#editProvinsi').html(`<option value="${prov}">${prov || '- Pilih Provinsi -'}</option>`).trigger('change.select2');
                $('#editKota').html(`<option value="${kota}">${kota || '- Pilih Kota -'}</option>`).trigger('change.select2');
                $('#editKecamatan').html(`<option value="${kec}">${kec || '- Pilih Kecamatan -'}</option>`).trigger('change.select2');
                $('#editKelurahan').html(`<option value="${kel}">${kel || '- Pilih Kelurahan -'}</option>`).trigger('change.select2');

                fetch(`${apiWilayah}/provinces.json`)
                    .then(res => res.json())
                    .then(provinces => {
                        let options = `<option value="${prov}">${prov || '- Pilih Provinsi -'}</option>`;
                        provinces.forEach(p => {
                            options += `<option value="${p.name}" data-id="${p.id}">${p.name}</option>`;
                        });
                        $('#editProvinsi').html(options).trigger('change.select2');
                    });

                document.getElementById('Edit').classList.remove('hidden');
            }

            document.getElementById('btnTutupModalEdit').addEventListener('click', () => {
                document.getElementById('Edit').classList.add('hidden');
            });

            document.getElementById('btnUpdateUser').addEventListener('click', async () => {
                const id = document.getElementById('editUserId').value;
                const btn = document.getElementById('btnUpdateUser');

                btn.disabled = true;
                btn.innerText = "Menyimpan...";

                try {
                    const res = await fetch(`http://127.0.0.1:8000/api/admin/users/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            name: document.getElementById('editNama').value,
                            email: document.getElementById('editEmail').value,
                            provinsi: $('#editProvinsi').val(),
                            kota: $('#editKota').val(),
                            kecamatan: $('#editKecamatan').val(),
                            kelurahan: $('#editKelurahan').val()
                        })
                    });

                    const data = await res.json();

                    if (res.ok) {
                        tampilkanPesan(data.message, 'text-green-700');
                        document.getElementById('Edit').classList.add('hidden');
                        tarikDataWarga(currentPage, currentSearch);
                    } else {
                        const errDetail = data.errors ? Object.values(data.errors).flat().join(', ') : data.message;
                        alert(errDetail);
                    }
                } catch (e) {
                    alert('Terjadi kesalahan koneksi.');
                } finally {
                    btn.disabled = false;
                    btn.innerText = "Simpan Perubahan";
                }
            });

            function ubahSort(kolom) {
                if (currentSortBy === kolom) {
                    currentSortDir = currentSortDir === 'asc' ? 'desc' : 'asc';
                } else {
                    currentSortBy = kolom;
                    currentSortDir = 'asc';
                }
                document.querySelectorAll('.sort-icon').forEach(el => el.innerHTML = '');
                const icon = currentSortDir === 'asc' ? '↑' : '↓';
                document.getElementById('icon-' + kolom).innerHTML = icon;
                tarikDataWarga(1, currentSearch);
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
        </script>
</body>

</html>