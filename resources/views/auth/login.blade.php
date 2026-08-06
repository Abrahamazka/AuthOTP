<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="icon" type="image/png" href="{{ asset('images/camerawowo.png') }}">
</head>

<body class="bg-[#E6E1D6] flex items-center justify-center h-screen">

    <div class="bg-[#FBF8F2] p-8 rounded-md w-96">
        <h2 id="formTitle" class="text-2xl font-extrabold mb-6 text-center">Masuk ke Akun</h2>

        <form id="loginForm" class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-800">Email</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    placeholder="example@email.com">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-800">Password</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <p class="text-sm font-small text-gray-500">lupa password? <a href="/forgotpw" class="text-blue-500 hover:text-blue-800">klik disini</a></p>
            </div>

            <div class="g-recaptcha flex justify-center" data-sitekey="6LdkeHYtAAAAAAhlwlAwnsdTdAOs4N6GTu1kiyCJ"></div>

            <button type="submit" id="btnSubmit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#171A33] hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Kirim Kode OTP
            </button>

            <p class="text-center text-semibold">Belum ada akun? <a href="/register" class="text-blue-500 hover:text-blue-800">register disini</a></p>
        </form>

        <form id="otpForm" class="space-y-4 hidden">
            <div>
                <label for="otp" class="block text-sm font-medium text-gray-800">Kode OTP</label>
                <input type="text" id="otp" name="otp" required
                    class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                    placeholder="123456">
            </div>
            <button type="submit" id="btnVerify"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#171A33]">
                Verifikasi & Masuk
            </button>
        </form>

        <div id="pesanSistem" class="mt-4 text-center text-sm hidden"></div>
    </div>

    <script>
        const token = localStorage.getItem('token_v');
        if (token) {
            window.location.href = '/index';
            }

        const loginForm = document.getElementById('loginForm');
        const otpForm = document.getElementById('otpForm');
        const pesanSistem = document.getElementById('pesanSistem');
        const formTitle = document.getElementById('formTitle');

        let userEmail = '';

        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            userEmail = email;

            const btn = document.getElementById('btnSubmit');
            btn.innerHTML = "Memproses...";
            btn.disabled = true;

            try {
                const res = await fetch('http://127.0.0.1:8000/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password
                    })
                });

                if (res.status === 429) {
                    alert('Terlalu banyak percobaan! Mohon tunggu 1 menit sebelum mencoba lagi.');
                    return;
                }

                const data = await res.json();

                if (res.ok) {
                    loginForm.classList.add('hidden');
                    otpForm.classList.remove('hidden');
                    formTitle.innerHTML = "Verifikasi 2 Langkah";

                    pesanSistem.innerHTML = "BERHASIL, " + data.message;
                    pesanSistem.className = "mt-4 text-center text-sm text-black block font-bold";
                } else {
                    pesanSistem.innerHTML = "GAGAL, " + data.message;
                    pesanSistem.className = "mt-4 text-center text-sm text-black block";
                }
            } catch (err) {
                pesanSistem.innerHTML = "Server error atau mati.";
                pesanSistem.className = "mt-4 text-center text-sm text-black block";
            } finally {
                btn.innerHTML = "Kirim Kode OTP";
                btn.disabled = false;
            }
        });

        otpForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const otpValue = document.getElementById('otp').value;
            const btnVerify = document.getElementById('btnVerify');

            btnVerify.innerHTML = "Memverifikasi...";
            btnVerify.disabled = true;

            try {
                const res = await fetch('http://127.0.0.1:8000/api/login/verify-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: userEmail,
                        otp: otpValue
                    })
                });
                if (res.status === 429) {
                    alert('Terlalu banyak percobaan! Silahkan tunggu 5 menit sebelum bisa mencoba lagi');
                    return;
                }

                const data = await res.json();

                if (res.ok) {
                    localStorage.setItem('token_v', data.token);

                    pesanSistem.innerHTML = "Berhasil Masuk...";
                    pesanSistem.className = "mt-4 text-center text-sm text-black block font-bold";

                    setTimeout(() => {
                        window.location.href = '/index';
                    }, 1500);

                } else {
                    pesanSistem.innerHTML = (data.message || "Kode OTP tidak valid.");
                    pesanSistem.className = "mt-4 text-center text-sm text-black block";
                }
            } catch (err) {
                pesanSistem.innerHTML = "Terjadi kesalahan.";
                pesanSistem.className = "mt-4 text-center text-sm text-black block";
            } finally {
                btnVerify.innerHTML = "Verifikasi & Masuk";
                btnVerify.disabled = false;
            }
        });
    </script>
</body>

</html>