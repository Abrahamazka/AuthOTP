<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('images/camerawowo.png') }}">
</head>

<body class="bg-[#E6E1D6] flex items-center justify-center h-screen">

    <div class="bg-[#FBF8F2] p-8 rounded-md w-96">
        <h2 class="text-2xl font-extrabold mb-6 text-center">Buat Akun</h2>

        <form id="registerForm" class="space-y-4">
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
                    placeholder="example@email.com">
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

        const registerForm = document.getElementById('registerForm');
        const pesanSistem = document.getElementById('pesanSistem');

        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const password_confirmation = document.getElementById('password_confirmation').value;

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
                        password_confirmation: password_confirmation
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