<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html::-webkit-scrollbar,
        body::-webkit-scrollbar {
            display: none;
        }

        html,
        body {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-[#E6E1D6] min-h-screen p-8">

    <div class="max-w-3xl mx-auto bg-[#FBF6EA] border-2 border-[#2B2318] flex flex-col">

        <div class="p-8">
            <div class="flex justify-end w-full mb-4">
                <a href="#" id="btnKembali" class="px-4 py-2 border-2 border-[#2B2318] text-xs font-bold uppercase tracking-wider hover:bg-[#EDE0BC] transition-colors bg-[#FBF6EA]">
                    Kembali →
                </a>
            </div>
            <div id="pesanSistem" class="hidden mb-6 p-3 border-2 border-[#2B2318] text-xs font-bold text-center uppercase"></div>

            <div class="flex flex-col items-center mb-8">
                <div id="avatarWadah" class="w-24 h-24 rounded-full border-2 border-[#2B2318] flex items-center justify-center text-3xl font-bold shadow-sm overflow-hidden relative">
                    <span id="avatarText">U</span>
                    <img id="avatarImg" src="" class="hidden w-full h-full object-cover">
                </div>
                <div class="flex gap-2 mt-4">
                    <input type="file" id="fotoInput" class="hidden" accept="image/*">
                    <button id="btnPilihFoto" onclick="document.getElementById('fotoInput').click()" class="border-2 border-[#2B2318] bg-amber-300 px-3 py-1 text-[10px] font-bold uppercase hover:bg-amber-400 transition-colors">
                        Pilih Foto
                    </button>
                    <button id="btnHapusFoto" class="hidden border-2 border-[#2B2318] bg-red-400 px-3 py-1 text-[10px] font-bold uppercase hover:bg-red-500 transition-colors">
                        Hapus
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5 text-sm">
                <div class="sm:col-span-2 text-[10px] uppercase tracking-widest text-[#8A7F5E] border-b-2 border-[#2B2318] pb-1">Data Pribadi</div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Nama Lengkap</label>
                    <div id="namaUser" class="w-full border-2 border-[#2B2318] bg-white p-2 text-xs font-bold uppercase min-h-[36px] flex items-center"></div>
                    <input type="text" id="inputNamaUser" class="hidden w-full border-2 border-[#2B2318] p-2 text-xs font-bold uppercase bg-white outline-none focus:bg-[#EDE0BC]">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Email</label>
                    <div id="emailUser" class="w-full border-2 border-[#2B2318] bg-[#E6E1D6] text-gray-500 p-2 text-xs font-bold min-h-[36px] flex items-center cursor-not-allowed"></div>
                </div>

                <div class="sm:col-span-2 text-[10px] uppercase tracking-widest text-[#8A7F5E] border-b-2 border-[#2B2318] pb-1 mt-2">Alamat Domisili</div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Provinsi</label>
                    <div id="provinsiUser" class="w-full border-2 border-[#2B2318] bg-white p-2 text-xs font-bold uppercase min-h-[36px] flex items-center"></div>
                    <select id="inputProvinsi" class="hidden w-full border-2 border-[#2B2318] p-2 text-xs font-bold uppercase bg-white outline-none focus:bg-[#EDE0BC]"></select>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Kota / Kabupaten</label>
                    <div id="kotaUser" class="w-full border-2 border-[#2B2318] bg-white p-2 text-xs font-bold uppercase min-h-[36px] flex items-center"></div>
                    <select id="inputKota" class="hidden w-full border-2 border-[#2B2318] p-2 text-xs font-bold uppercase bg-white outline-none focus:bg-[#EDE0BC]"></select>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Kecamatan</label>
                    <div id="kecamatanUser" class="w-full border-2 border-[#2B2318] bg-white p-2 text-xs font-bold uppercase min-h-[36px] flex items-center"></div>
                    <select id="inputKecamatan" class="hidden w-full border-2 border-[#2B2318] p-2 text-xs font-bold uppercase bg-white outline-none focus:bg-[#EDE0BC]"></select>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Kelurahan</label>
                    <div id="kelurahanUser" class="w-full border-2 border-[#2B2318] bg-white p-2 text-xs font-bold uppercase min-h-[36px] flex items-center"></div>
                    <select id="inputKelurahan" class="hidden w-full border-2 border-[#2B2318] p-2 text-xs font-bold uppercase bg-white outline-none focus:bg-[#EDE0BC]"></select>
                </div>

                <div class="sm:col-span-2 mt-2">
                    <button id="btnEdit" class="w-full py-2 border-2 border-[#2B2318] bg-[#2B2318] text-white hover:bg-black text-xs font-bold uppercase tracking-wider transition-colors">
                        Edit Profil
                    </button>
                    <div id="wadahSimpan" class="hidden flex gap-2 w-full">
                        <button id="btnBatal" class="flex-1 py-2 border-2 border-[#2B2318] bg-[#EDE0BC] text-black hover:bg-[#DED2AE] text-xs font-bold uppercase tracking-wider transition-colors">
                            Batal
                        </button>
                        <button id="btnSimpan" class="flex-1 py-2 border-2 border-[#2B2318] bg-[#B4F0C3] text-black hover:bg-[#93ECA8] text-xs font-bold uppercase tracking-wider transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t-2 border-dashed border-[#2B2318]">
                <h3 class="text-[12px] font-bold text-black uppercase tracking-widest mb-4">Ganti Password</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div class="sm:col-span-2">
                        <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Password Saat Ini</label>
                        <input type="password" id="currentPassword" class="w-full border-2 border-[#2B2318] p-2 text-xs font-bold bg-white outline-none focus:bg-[#EDE0BC] transition-colors">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Password Baru</label>
                        <input type="password" id="newPassword" class="w-full border-2 border-[#2B2318] p-2 text-xs font-bold bg-white outline-none focus:bg-[#EDE0BC] transition-colors">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[#8A7F5E] mb-1">Konfirmasi Password Baru</label>
                        <input type="password" id="newPassword_confirmation" class="w-full border-2 border-[#2B2318] p-2 text-xs font-bold bg-white outline-none focus:bg-[#EDE0BC] transition-colors">
                    </div>
                </div>

                <div id="pesanPassword" class="hidden mt-4 text-xs font-bold text-center uppercase p-2 border-2 border-[#2B2318]"></div>

                <div class="mt-4 flex justify-end">
                    <button id="btnGantiPassword" class="px-6 py-2 border-2 border-[#2B2318] bg-blue-400 text-black text-xs font-bold uppercase hover:bg-blue-500 transition-colors">
                        Simpan Password
                    </button>
                </div>
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

                        document.getElementById('avatarWadah').className = "w-24 h-24 rounded-full border-2 border-[#2B2318] flex items-center justify-center text-3xl font-bold shadow-sm overflow-hidden relative bg-white";
                    } else {
                        avatarText.innerText = (user.name || 'U').charAt(0).toUpperCase();
                        avatarImg.classList.add('hidden');
                        avatarText.classList.remove('hidden');
                        btnHapusFoto.classList.add('hidden');

                        const warnaWadah = getRetroColor(user.name);
                        document.getElementById('avatarWadah').className = `w-24 h-24 rounded-full border-2 border-[#2B2318] flex items-center justify-center text-3xl font-bold text-black shadow-sm overflow-hidden relative ${warnaWadah}`;
                    }
                    const btnKembali = document.getElementById('btnKembali');
                    if (btnKembali) {
                        if (user.role === 'admin') {
                            btnKembali.href = '/admin';
                        } else {
                            btnKembali.href = '/index';
                        }
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
        document.getElementById('btnGantiPassword').addEventListener('click', async () => {
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const newPasswordConfirmation = document.getElementById('newPassword_confirmation').value;
            const btn = document.getElementById('btnGantiPassword');

            if (!currentPassword || !newPassword || !newPasswordConfirmation) {
                tampilkanPesanPw('Semua kolom password wajib diisi!', 'bg-red-100 text-red-700');
                return;
            }

            btn.disabled = true;
            btn.innerText = 'Menyimpan...';

            try {
                const res = await fetch('http://127.0.0.1:8000/api/profil/password', {
                    method: 'PUT',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        current_password: currentPassword,
                        new_password: newPassword,
                        new_password_confirmation: newPasswordConfirmation
                    })
                });

                const data = await res.json();

                if (res.ok) {
                    tampilkanPesanPw(data.message, 'bg-green-100 text-green-700');
                    document.getElementById('currentPassword').value = '';
                    document.getElementById('newPassword').value = '';
                    document.getElementById('newPassword_confirmation').value = '';
                } else {
                    const errDetail = data.errors ? Object.values(data.errors).flat().join('<br>') : data.message;
                    tampilkanPesanPw(errDetail, 'bg-red-100 text-red-700');
                }
            } catch (err) {
                tampilkanPesanPw('Terjadi kesalahan koneksi.', 'bg-red-100 text-red-700');
            } finally {
                btn.disabled = false;
                btn.innerText = 'Simpan Password';
            }
        });

        function tampilkanPesanPw(teks, classWarna) {
            const pesanBox = document.getElementById('pesanPassword');
            pesanBox.innerHTML = teks;
            pesanBox.className = `mt-4 text-xs font-bold text-center uppercase p-2 block border-2 border-[#2B2318] ${classWarna}`;
            setTimeout(() => pesanBox.classList.add('hidden'), 4000);
        }
    </script>
</body>

</html>