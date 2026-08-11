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
            <div class="flex border-b border-gray-200 mb-4">
                <button type="button" id="tabPassword" class="flex-1 py-2 text-sm font-bold text-black border-b-2 border-black">
                    Pakai Password
                </button>
                <button type="button" id="tabOtp" class="flex-1 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                    Pakai OTP
                </button>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-800">Email</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    placeholder="contoh@gmail.com">
            </div>

            <div id="wadahPassword">
                <label for="password" class="block text-sm font-medium text-gray-800">Password</label>
                <input type="password" id="password" name="password"
                    class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <p class="text-sm font-small text-gray-500 mt-1">lupa password? <a href="/forgotpw" class="text-blue-500 hover:text-blue-800">klik disini</a></p>
            </div>

            <div class="g-recaptcha flex justify-center" data-sitekey="6LdkeHYtAAAAAAhlwlAwnsdTdAOs4N6GTu1kiyCJ"></div>

            <div class="mt-4">
                <button type="button" id="btnPassword"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#171A33] hover:bg-gray-800 transition-colors duration-200">
                    Login dengan Password
                </button>

                <button type="button" id="btnOtp"
                    class="hidden w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#171A33] hover:bg-gray-800 transition-colors duration-200">
                    Kirim Kode OTP
                </button>
            </div>

            <p class="text-center text-sm font-semibold">Belum ada akun? <a href="/register" class="text-blue-500 hover:text-blue-800">register disini</a></p>
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

        const btnPassword = document.getElementById('btnPassword');
        const btnOtp = document.getElementById('btnOtp');

        const tabPassword = document.getElementById('tabPassword');
        const tabOtp = document.getElementById('tabOtp');
        const wadahPassword = document.getElementById('wadahPassword');
        tabPassword.addEventListener('click', () => {
            tabPassword.className = "flex-1 py-2 text-sm font-bold text-black border-b-2 border-black";
            tabOtp.className = "flex-1 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-0";

            wadahPassword.classList.remove('hidden');
            btnPassword.classList.remove('hidden');
            btnOtp.classList.add('hidden');
        });

        tabOtp.addEventListener('click', () => {
            tabOtp.className = "flex-1 py-2 text-sm font-bold text-black border-b-2 border-black";
            tabPassword.className = "flex-1 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-0";

            wadahPassword.classList.add('hidden');
            btnPassword.classList.add('hidden');
            btnOtp.classList.remove('hidden');
        });

        btnPassword.addEventListener('click', async () => {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const captchaT = grecaptcha.getResponse();

            if (!captchaT) {
                pesanSistem.innerHTML = "Centang reCAPTCHA dulu!";
                pesanSistem.className = "mt-4 text-center text-sm text-red-600 block font-bold";
                return;
            }

            btnPassword.innerHTML = "Memproses...";
            btnPassword.disabled = true;

            try {
                const res = await fetch('http://127.0.0.1:8000/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password,
                        'g-recaptcha-response': captchaT
                    })
                });

                const data = await res.json();

                if (res.ok) {
                    localStorage.setItem('token_v', data.token);
                    const roleUser = data.user.role;
                    if (roleUser == 'admin'){
                        pesanSistem.innerHTML = "Halo bosku, membuka dashboard";
                        pesanSistem.className = "mt-4 text-center text-sm text-green-600 block font-bold";
                        setTimeout(() => {
                            window.location.href = '/admin';
                        }, 1500);
                    } else {
                        pesanSistem.innerHTML = "Berhasil Masuk, Membuka profil...";
                        pesanSistem.className = "mt-4 text-center text-sm text-green-600 block font-bold";
                        setTimeout(() => {
                            window.location.href = '/index';
                        }, 1500); 
                    }
                } else {
                    pesanSistem.innerHTML = data.message;
                    pesanSistem.className = "mt-4 text-center text-sm text-red-600 block";
                    grecaptcha.reset();
                }
            } catch (err) {
                pesanSistem.innerHTML = "Server error atau mati.";
                pesanSistem.className = "mt-4 text-center text-sm text-red-600 block";
                grecaptcha.reset();
            } finally {
                btnPassword.innerHTML = "Login dengan Password";
                btnPassword.disabled = false;
            }
        });

        btnOtp.addEventListener('click', async () => {
            const email = document.getElementById('email').value;
            userEmail = email;
            const captchaT = grecaptcha.getResponse();

            if (!captchaT) {
                pesanSistem.innerHTML = "Centang reCAPTCHA dulu!";
                pesanSistem.className = "mt-4 text-center text-sm text-red-600 block font-bold";
                return;
            }

            btnOtp.innerHTML = "Mengirim...";
            btnOtp.disabled = true;

            try {
                const res = await fetch('http://127.0.0.1:8000/api/login/request-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email,
                        'g-recaptcha-response': captchaT
                    })
                });

                const data = await res.json();

                if (res.ok) {
                    loginForm.classList.add('hidden');
                    otpForm.classList.remove('hidden');
                    formTitle.innerHTML = "Verifikasi 2 Langkah";
                    pesanSistem.innerHTML = data.message;
                    pesanSistem.className = "mt-4 text-center text-sm text-green-600 block font-bold";
                } else {
                    pesanSistem.innerHTML = data.message;
                    pesanSistem.className = "mt-4 text-center text-sm text-red-600 block";
                    grecaptcha.reset();
                }
            } catch (err) {
                pesanSistem.innerHTML = "Server error atau mati.";
                pesanSistem.className = "mt-4 text-center text-sm text-red-600 block";
                grecaptcha.reset();
            } finally {
                btnOtp.innerHTML = "Kirim Kode OTP";
                btnOtp.disabled = false;
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
                    alert('Terlalu banyak percobaan! Silahkan tunggu 5 menit.');
                    return;
                }

                const data = await res.json();

                if (res.ok) {
                    localStorage.setItem('token_v', data.token);
                    const roleUser = data.user.role;

                    if(roleUser == 'admin') {
                        window.location.href = '/admin';
                    } else {
                        window.location.href = '/index';
                    }
                } else {
                    pesanSistem.innerHTML = (data.message || "Kode OTP tidak valid.");
                    pesanSistem.className = "mt-4 text-center text-sm text-red-600 block";
                }
            } catch (err) {
                pesanSistem.innerHTML = "Terjadi kesalahan.";
                pesanSistem.className = "mt-4 text-center text-sm text-red-600 block";
            } finally {
                btnVerify.innerHTML = "Verifikasi & Masuk";
                btnVerify.disabled = false;
            }
        });
    </script>
</body>

</html>