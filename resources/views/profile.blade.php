<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#E6E1D6] min-h-screen p-8">

    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md p-8">
        <div class="flex justify-between items-center pb-4 mb-6 border-b">
            <h1 class="text-xl font-bold text-gray-800">Profil Saya</h1>
            <a href="/index" class="text-sm font-semibold text-blue-600 hover:underline">← Kembali ke Dashboard</a>
        </div>

        <div id="pesanSistem" class="hidden mb-4 p-3 rounded-lg text-sm font-bold text-center"></div>

        <div class="flex flex-col items-center mb-6">
            <div class="w-24 h-24 rounded-full bg-blue-600 text-white flex items-center justify-center overflow-hidden mb-3 shadow">
                <span id="avatarText" class="text-3xl font-bold">U</span>
                <img id="avatarImg" src="" alt="Foto Profil" class="w-full h-full object-cover hidden">
            </div>
            <label class="cursor-pointer bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs px-3 py-1.5 rounded-md font-semibold transition">
                Pilih Foto Baru
                <input type="file" id="fotoInput" class="hidden" accept="image/*">
            </label>
            <button id="btnHapusFoto" class="hidden mt-2 text-xs font-bold text-red-300 hover:text-red-500 transition">
                Hapus Foto
            </button>
        </div>

        <div class="space-y-4 text-sm">
            <div>
                <label class="block text-gray-500 font-semibold text-xs">NAMA LENGKAP</label>
                <p id="namaUser" class="text-gray-800 font-medium border-b pb-1 text-base">-</p>
                <input type="text" id="inputNamaUser" class="hidden w-full border rounded p-2 mt-1 text-base">
            </div>
            <div>
                <label class="block text-gray-500 font-semibold text-xs">EMAIL</label>
                <p id="emailUser" class="text-gray-800 font-medium border-b pb-1 text-base">-</p>
            </div>

            <div class="mt-6 pt-4">
                <h2 class="text-base font-bold text-gray-700 mb-3">Alamat Domisili</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-500 text-xs font-semibold">PROVINSI</label>
                        <p id="provinsiUser" class="text-gray-800 font-medium border-b pb-1">-</p>
                        <select id="inputProvinsi" class="hidden w-full border rounded p-2 mt-1"></select>
                    </div>
                    <div>
                        <label class="block text-gray-500 text-xs font-semibold">KOTA / KABUPATEN</label>
                        <p id="kotaUser" class="text-gray-800 font-medium border-b pb-1">-</p>
                        <select id="inputKota" class="hidden w-full border rounded p-2 mt-1"></select>
                    </div>
                    <div>
                        <label class="block text-gray-500 text-xs font-semibold">KECAMATAN</label>
                        <p id="kecamatanUser" class="text-gray-800 font-medium border-b pb-1">-</p>
                        <select id="inputKecamatan" class="hidden w-full border rounded p-2 mt-1"></select>
                    </div>
                    <div>
                        <label class="block text-gray-500 text-xs font-semibold">KELURAHAN</label>
                        <p id="kelurahanUser" class="text-gray-800 font-medium border-b pb-1">-</p>
                        <select id="inputKelurahan" class="hidden w-full border rounded p-2 mt-1"></select>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex flex-col space-y-3">
            <button id="btnEdit" class="w-full bg-black hover:bg-gray-400 text-white font-bold py-2 rounded-lg text-sm transition">
                Edit Profil
            </button>
            <div id="wadahSimpan" class="hidden flex space-x-3 w-full">
                <button id="btnBatal" class="flex-1 bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 rounded-lg text-sm transition">
                    Batal
                </button>
                <button id="btnSimpan" class="flex-1 bg-black hover:bg-gray-400 text-white font-bold py-2 rounded-lg text-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

    <script>
        const token = localStorage.getItem('token_v');

        const btnEdit = document.getElementById('btnEdit');
        const btnBatal = document.getElementById('btnBatal');
        const btnSimpan = document.getElementById('btnSimpan');
        const wadahSimpan = document.getElementById('wadahSimpan');
        const pesanSistem = document.getElementById('pesanSistem');
        const avatarImg = document.getElementById('avatarImg');
        const avatarText = document.getElementById('avatarText');
        const fotoInput = document.getElementById('fotoInput');
        const btnHapusFoto = document.getElementById('btnHapusFoto');
        const txtNama = document.getElementById('namaUser');
        const txtProvinsi = document.getElementById('provinsiUser');
        const txtKota = document.getElementById('kotaUser');
        const txtKecamatan = document.getElementById('kecamatanUser');
        const txtKelurahan = document.getElementById('kelurahanUser');
        const inpNama = document.getElementById('inputNamaUser');
        const inpProvinsi = document.getElementById('inputProvinsi');
        const inpKota = document.getElementById('inputKota');
        const inpKecamatan = document.getElementById('inputKecamatan');
        const inpKelurahan = document.getElementById('inputKelurahan');
        const apiWilayah = 'https://www.emsifa.com/api-wilayah-indonesia/api';

        if (!token) {
            window.location.href = '/login';
        } else {
            loadDataProfil();
        }

        function loadDataProfil() {
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
                .then(user => {
                    txtNama.innerText = user.name || '-';
                    document.getElementById('emailUser').innerText = user.email || '-';
                    txtProvinsi.innerText = user.provinsi || '-';
                    txtKota.innerText = user.kota || '-';
                    txtKecamatan.innerText = user.kecamatan || '-';
                    txtKelurahan.innerText = user.kelurahan || '-';

                    if (user.foto) {
                        avatarImg.src = 'http://127.0.0.1:8000/storage/' + user.foto;
                        avatarImg.classList.remove('hidden');
                        avatarText.classList.add('hidden');
                        btnHapusFoto.classList.remove('hidden');
                    } else {
                        avatarText.innerText = (user.name || 'U').charAt(0).toUpperCase();
                        avatarImg.classList.add('hidden');
                        avatarText.classList.remove('hidden');
                        btnHapusFoto.classList.add('hidden');
                    }
                })
                .catch(() => {
                    localStorage.removeItem('token_v');
                    window.location.href = '/login';
                });
        }

        function toggleEditMode(isEditing) {
            txtNama.classList.toggle('hidden', isEditing);
            txtProvinsi.classList.toggle('hidden', isEditing);
            txtKota.classList.toggle('hidden', isEditing);
            txtKecamatan.classList.toggle('hidden', isEditing);
            txtKelurahan.classList.toggle('hidden', isEditing);

            inpNama.classList.toggle('hidden', !isEditing);
            inpProvinsi.classList.toggle('hidden', !isEditing);
            inpKota.classList.toggle('hidden', !isEditing);
            inpKecamatan.classList.toggle('hidden', !isEditing);
            inpKelurahan.classList.toggle('hidden', !isEditing);

            btnEdit.classList.toggle('hidden', isEditing);
            wadahSimpan.classList.toggle('hidden', !isEditing);
            pesanSistem.classList.add('hidden');
        }

        function loadProvinces() {
            inpProvinsi.innerHTML = `<option value="${txtProvinsi.innerText}">-- ${txtProvinsi.innerText} --</option>`;
            fetch(`${apiWilayah}/provinces.json`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(prov => {
                        inpProvinsi.innerHTML += `<option value="${prov.name}" data-id="${prov.id}">${prov.name}</option>`;
                    });
                });
        }

        inpProvinsi.addEventListener('change', function() {
            const id = this.options[this.selectedIndex].getAttribute('data-id');
            inpKota.innerHTML = '<option value="">Memuat Kota...</option>';
            inpKecamatan.innerHTML = '';
            inpKelurahan.innerHTML = '';

            if (!id) return;

            fetch(`${apiWilayah}/regencies/${id}.json`)
                .then(res => res.json())
                .then(data => {
                    inpKota.innerHTML = '<option value="">- Pilih Kota -</option>';
                    data.forEach(kota => {
                        inpKota.innerHTML += `<option value="${kota.name}" data-id="${kota.id}">${kota.name}</option>`;
                    });
                });
        });

        inpKota.addEventListener('change', function() {
            const id = this.options[this.selectedIndex].getAttribute('data-id');
            inpKecamatan.innerHTML = '<option value="">Memuat Kecamatan...</option>';
            inpKelurahan.innerHTML = '';

            fetch(`${apiWilayah}/districts/${id}.json`)
                .then(res => res.json())
                .then(data => {
                    inpKecamatan.innerHTML = '<option value="">- Pilih Kecamatan -</option>';
                    data.forEach(kec => {
                        inpKecamatan.innerHTML += `<option value="${kec.name}" data-id="${kec.id}">${kec.name}</option>`;
                    });
                });
        });

        inpKecamatan.addEventListener('change', function() {
            const id = this.options[this.selectedIndex].getAttribute('data-id');
            inpKelurahan.innerHTML = '<option value="">Memuat Kelurahan...</option>';

            fetch(`${apiWilayah}/villages/${id}.json`)
                .then(res => res.json())
                .then(data => {
                    inpKelurahan.innerHTML = '<option value="">- Pilih Kelurahan -</option>';
                    data.forEach(kel => {
                        inpKelurahan.innerHTML += `<option value="${kel.name}" data-id="${kel.id}">${kel.name}</option>`;
                    });
                });
        });
        btnEdit.addEventListener('click', () => {
            inpNama.value = txtNama.innerText !== '-' ? txtNama.innerText : '';

            loadProvinces();
            inpKota.innerHTML = `<option value="${txtKota.innerText}">${txtKota.innerText}</option>`;
            inpKecamatan.innerHTML = `<option value="${txtKecamatan.innerText}">${txtKecamatan.innerText}</option>`;
            inpKelurahan.innerHTML = `<option value="${txtKelurahan.innerText}">${txtKelurahan.innerText}</option>`;

            toggleEditMode(true);
        });

        btnBatal.addEventListener('click', () => {
            toggleEditMode(false);
        });

        btnSimpan.addEventListener('click', async () => {
            btnSimpan.innerHTML = "Menyimpan...";
            btnSimpan.disabled = true;

            try {
                const res = await fetch('http://127.0.0.1:8000/api/profil/update', {
                    method: 'PUT',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        name: inpNama.value,
                        provinsi: inpProvinsi.value,
                        kota: inpKota.value,
                        kecamatan: inpKecamatan.value,
                        kelurahan: inpKelurahan.value
                    })
                });

                const data = await res.json();

                if (res.ok) {
                    pesanSistem.innerHTML = data.message;
                    pesanSistem.className = "mb-4 p-3 rounded-lg text-sm font-bold text-center bg-green-100 text-green-700 block";
                    loadDataProfil();
                    toggleEditMode(false);
                } else {
                    pesanSistem.innerHTML = data.message || "Data tidak valid";
                    pesanSistem.className = "mb-4 p-3 rounded-lg text-sm font-bold text-center bg-red-100 text-red-700 block";
                }
            } catch (error) {
                pesanSistem.innerHTML = "Server error atau koneksi terputus.";
                pesanSistem.className = "mb-4 p-3 rounded-lg text-sm font-bold text-center bg-red-100 text-red-700 block";
            } finally {
                btnSimpan.innerHTML = "Simpan Perubahan";
                btnSimpan.disabled = false;
            }
        });
        fotoInput.addEventListener('change', async function() {
            const file = this.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('foto', file);

            pesanSistem.innerHTML = "Mengunggah foto, mohon tunggu...";
            pesanSistem.className = "mb-4 p-3 rounded-lg text-sm font-bold text-center bg-blue-100 text-blue-700 block";
            pesanSistem.classList.remove('hidden');

            try {
                const res = await fetch('http://127.0.0.1:8000/api/profil/foto', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await res.json();

                if (res.ok) {
                    pesanSistem.innerHTML = data.message;
                    pesanSistem.className = "mb-4 p-3 rounded-lg text-sm font-bold text-center bg-green-100 text-green-700 block";

                    avatarImg.src = data.foto_url;
                    avatarImg.classList.remove('hidden');
                    avatarText.classList.add('hidden');
                } else {
                    pesanSistem.innerHTML = (data.message || "File tidak sesuai format");
                    pesanSistem.className = "mb-4 p-3 rounded-lg text-sm font-bold text-center bg-red-100 text-red-700 block";
                }
            } catch (error) {
                pesanSistem.innerHTML = " Server error saat mengunggah foto.";
                pesanSistem.className = "mb-4 p-3 rounded-lg text-sm font-bold text-center bg-red-100 text-red-700 block";
            }
        });
        btnHapusFoto.addEventListener('click', async () => {
            if (!confirm('Yakin ingin menghapus foto profil?')) return;

            pesanSistem.innerHTML = "Menghapus foto...";
            pesanSistem.className = "mb-4 p-3 rounded-lg text-sm font-bold text-center bg-blue-100 text-blue-700 block";
            pesanSistem.classList.remove('hidden');

            try {
                const res = await fetch('http://127.0.0.1:8000/api/profil/foto', {
                    method: 'DELETE', 
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json();

                if (res.ok) {
                    pesanSistem.innerHTML = data.message;
                    pesanSistem.className = "mb-4 p-3 rounded-lg text-sm font-bold text-center bg-green-100 text-green-700 block";
                    loadDataProfil();
                } else {
                    pesanSistem.innerHTML = data.message;
                    pesanSistem.className = "mb-4 p-3 rounded-lg text-sm font-bold text-center bg-red-100 text-red-700 block";
                }
            } catch (error) {
                pesanSistem.innerHTML = "Server error saat menghapus foto.";
                pesanSistem.className = "mb-4 p-3 rounded-lg text-sm font-bold text-center bg-red-100 text-red-700 block";
            }
        });
    </script>
</body>

</html>