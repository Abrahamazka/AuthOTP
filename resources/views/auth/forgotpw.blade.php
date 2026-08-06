<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('images/camerawowo.png') }}">
</head>

<body class="bg-[#E6E1D6] flex items-center justify-center h-screen">
    <div class="bg-[#FBF8F2] p-8 rounded-md w-96">
        <div id="tahap1">
            <h1 class="font-bold py-2 text-xl">Reset Password</h1>
            <p>Masukkan email Anda untuk menerima kode OTP.</p>
            <div class="py-2 space-x-2">
                <input type="email" id="inputEmail" placeholder="contoh@gmail.com" class="border rounded-md shadow-sm p-2">
                <button class=" border rounded-md shadow-sm p-2 hover:border-black" onclick="mintaOtp()">Kirim</button>
            </div>
        </div>

        <div id="tahap2" style="display: none;">
            <h1 class="font-bold py-2 text-xl">Verifikasi OTP</h1>
            <p>Cek email Anda, masukkan 6 digit angka di bawah ini.</p>
            <div class="py-2 space-x-2">
                <input type="text" id="inputOtp" placeholder="123456" class="border rounded-md shadow-sm p-2 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                <button class=" border rounded-md shadow-sm p-2 hover:border-black" onclick="cekOtp()">Verifikasi</button>
            </div>
        </div>

        <div id="tahap3" style="display: none;">
            <h1 class="font-bold py-2 text-xl">Buat Password Baru</h1>
            <p>Silakan isi password baru anda.</p>
            <div class="py-2">
                <input type="password" id="inputPassword" placeholder="Password Baru" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <input type="password" id="inputConfirmPassword" placeholder="Konfirmasi Password" class="mt-4 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <button class="w-full mt-4 flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" onclick="gantiPassword()">Simpan Password</button>
            </div>
        </div>
    </div>

    <script>
        const token = localStorage.getItem('token_v');
        if (token) {
            window.location.href = '/index';
        }

        async function mintaOtp() {
            const email = document.getElementById('inputEmail').value;

            const res = await fetch('http://127.0.0.1:8000/api/forgot-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    email: email
                })
            });

            if (res.status === 429) {
                alert('Terlalu banyak permintaan! Mohon tunggu 1 menit sebelum mencoba lagi.');
                return;
            }

            if (res.ok) {
                alert('OTP berhasil dikirim!');
            } else {
                alert('Gagal mengirim OTP.');
            }

            if (res.ok) {
                localStorage.setItem('reset_email', email);

                document.getElementById('tahap1').style.display = 'none';
                document.getElementById('tahap2').style.display = 'block';
            } else {
                alert('Email tidak ditemukan atau terjadi kesalahan.');
            }
        }

        async function cekOtp() {
            const otp = document.getElementById('inputOtp').value;
            const email = localStorage.getItem('reset_email');

            const res = await fetch('http://127.0.0.1:8000/api/verify-otp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    email: email,
                    otp: otp
                })
            });

            const data = await res.json();

            if (res.ok) {
                localStorage.setItem('reset_token', data.reset_token);

                alert('OTP Benar! Silakan buat password baru.');

                document.getElementById('tahap2').style.display = 'none';
                document.getElementById('tahap3').style.display = 'block';
            } else {
                alert(data.message || 'OTP Salah!');
            }
        }

        async function gantiPassword() {
            const password = document.getElementById('inputPassword').value;
            const confirmPassword = document.getElementById('inputConfirmPassword').value;

            const email = localStorage.getItem('reset_email');
            const token = localStorage.getItem('reset_token');

            const res = await fetch('http://127.0.0.1:8000/api/password-reset', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    email: email,
                    reset_token: token,
                    password: password,
                    password_confirmation: confirmPassword
                })
            });

            if (res.ok) {
                localStorage.removeItem('reset_email');
                localStorage.removeItem('reset_token');

                alert('Password berhasil diubah! Silakan login.');

                window.location.href = '/login';
            } else {
                alert('Gagal mengganti password. Pastikan minimal 8 karakter dan sama dengan konfirmasi.');
            }
        }
    </script>
</body>

</html>