<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('images/camerawowo.png') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body class="bg-[#E6E1D6] flex items-center justify-center h-screen">

    <div class="bg-[#FBF8F2] p-8 rounded-md w-96">
        <h2 class="text-2xl font-extrabold mb-6 text-center">Buat Akun</h2>

        <form id="registerForm" class="space-y-4">
            <div class="space-y-4 mb-6 p-4 bg-gray-50 border border-gray-200 rounded-md">
                <h3 class="font-bold text-gray-700">Alamat Lengkap</h3>

                <div id="wadah-provinsi">
                    <label class="block text-sm font-medium text-gray-800">Provinsi</label>
                    <select id="provinsi" name="provinsi" class="w-full select2">
                        <option value="">Pilih Provinsi...</option>
                    </select>
                </div>

                <div id="wadah-kota" class="hidden transition-all duration-300">
                    <label class="block text-sm font-medium text-gray-800">Kota/Kabupaten</label>
                    <select id="kota" name="kota" class="w-full select2">
                        <option value="">Pilih Kota...</option>
                    </select>
                </div>

                <div id="wadah-kecamatan" class="hidden transition-all duration-300">
                    <label class="block text-sm font-medium text-gray-800">Kecamatan</label>
                    <select id="kecamatan" name="kecamatan" class="w-full select2">
                        <option value="">Pilih Kecamatan...</option>
                    </select>
                </div>

                <div id="wadah-kelurahan" class="hidden transition-all duration-300">
                    <label class="block text-sm font-medium text-gray-800">Kelurahan/Desa</label>
                    <select id="kelurahan" name="kelurahan" class="w-full select2">
                        <option value="">Pilih Kelurahan...</option>
                    </select>
                </div>
            </div>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-800">Nama</label>
                <input type="text" id="name" name="name" required
                    class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Justinus laksana">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-800">Email</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    placeholder="contoh@gmail.com">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-800">Password</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-800">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <button type="submit" id="btnSubmit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Buat akun
            </button>

            <p class="text-center text-semibold">Sudah ada akun? <a href="/login" class="text-blue-500 hover:text-blue-800">login disini</a></p>
        </form>

        <div id="pesanSistem" class="mt-4 text-center text-sm hidden"></div>
    </div>

    <script>
        const token = localStorage.getItem('token_v');
        if (token) {
            window.location.href = '/index';
        }

        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });

            fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
                .then(response => response.json())
                .then(provinces => {
                    let options = '<option value="">Pilih Provinsi...</option>';
                    provinces.forEach(prov => {
                        options += `<option value="${prov.name}" data-id="${prov.id}">${prov.name}</option>`;
                    });
                    $('#provinsi').html(options);
                });

            $('#provinsi').on('change', function() {
                let idProv = $(this).find(':selected').data('id');

                $('#wadah-kecamatan, #wadah-kelurahan').addClass('hidden');
                $('#kota, #kecamatan, #kelurahan').html('<option value="">Pilih...</option>');

                if (idProv) {
                    $('#wadah-kota').removeClass('hidden');
                    $('#kota').html('<option value="">Loading...</option>');

                    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${idProv}.json`)
                        .then(response => response.json())
                        .then(regencies => {
                            let options = '<option value="">Pilih Kota...</option>';
                            regencies.forEach(kota => {
                                options += `<option value="${kota.name}" data-id="${kota.id}">${kota.name}</option>`;
                            });
                            $('#kota').html(options);
                        });
                } else {
                    $('#wadah-kota').addClass('hidden');
                }
            });

            $('#kota').on('change', function() {
                let idKota = $(this).find(':selected').data('id');

                $('#wadah-kelurahan').addClass('hidden');
                $('#kecamatan, #kelurahan').html('<option value="">Pilih...</option>');

                if (idKota) {
                    $('#wadah-kecamatan').removeClass('hidden');
                    $('#kecamatan').html('<option value="">Loading...</option>');

                    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${idKota}.json`)
                        .then(response => response.json())
                        .then(districts => {
                            let options = '<option value="">Pilih Kecamatan...</option>';
                            districts.forEach(kec => {
                                options += `<option value="${kec.name}" data-id="${kec.id}">${kec.name}</option>`;
                            });
                            $('#kecamatan').html(options);
                        });
                } else {
                    $('#wadah-kecamatan').addClass('hidden');
                }
            });

            $('#kecamatan').on('change', function() {
                let idKecamatan = $(this).find(':selected').data('id');

                $('#kelurahan').html('<option value="">Pilih...</option>');

                if (idKecamatan) {
                    $('#wadah-kelurahan').removeClass('hidden');
                    $('#kelurahan').html('<option value="">Loading...</option>');

                    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${idKecamatan}.json`)
                        .then(response => response.json())
                        .then(villages => {
                            let options = '<option value="">Pilih Kelurahan...</option>';
                            villages.forEach(kel => {
                                options += `<option value="${kel.name}">${kel.name}</option>`;
                            });
                            $('#kelurahan').html(options);
                        });
                } else {
                    $('#wadah-kelurahan').addClass('hidden');
                }
            });
        });

        const registerForm = document.getElementById('registerForm');
        const pesanSistem = document.getElementById('pesanSistem');

        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const password_confirmation = document.getElementById('password_confirmation').value;
            const provinsi = $('#provinsi').val();
            const kota = $('#kota').val();
            const kecamatan = $('#kecamatan').val(); 
            const kelurahan = $('#kelurahan').val();

            const btn = document.getElementById('btnSubmit');
            btn.innerHTML = "Memproses...";
            btn.disabled = true;

            try {
                const res = await fetch('http://127.0.0.1:8000/api/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        name: name,
                        email: email,
                        password: password,
                        password_confirmation: password_confirmation,
                        provinsi: provinsi,
                        kota: kota,
                        kecamatan: kecamatan,
                        kelurahan: kelurahan
                    })
                });

                const data = await res.json();

                if (res.ok) {
                    pesanSistem.innerHTML = "Berhasil! Mengalihkan ke login...";
                    pesanSistem.className = "mt-4 text-center text-sm text-black block font-bold";

                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 1500);
                } else {
                    pesanSistem.innerHTML = (data.message || "Gagal mendaftar.");
                    pesanSistem.className = "mt-4 text-center text-sm text-black block";
                }
            } catch (err) {
                pesanSistem.innerHTML = "Terjadi kesalahan.";
                pesanSistem.className = "mt-4 text-center text-sm text-black block";
            } finally {
                btn.innerHTML = "Buat akun";
                btn.disabled = false;
            }
        });
    </script>
</body>

</html>