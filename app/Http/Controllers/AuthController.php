<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use  Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(12)->mixedCase()->symbols()],
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);

        return response()->json(['message' => 'Register berhasil', 'user' => $user], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => ['required'],
            'g-recaptcha-response' => 'required|string',
        ]);

        $googleResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('RECAPTCHA_SECRET'),
            'response' => $request->input('g-recaptcha-response'),
        ]);

        $result = $googleResponse->json();

        if (!($result['success'] ?? false)) {
            return response()->json(['message' => 'Captcha salah!'], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email atau Password salah!'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['status' => 'sukses', 'message' => 'Login berhasil', 'token' => $token, 'user' => $user], 200);
    }

    public function loginOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|exists:users,email',
            'g-recaptcha-response' => 'required|string',
        ]);

        $googleResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('RECAPTCHA_SECRET'),
            'response' => $request->input('g-recaptcha-response'),
        ]);

        $result = $googleResponse->json();

        if (!($result['success'] ?? false)) {
            return response()->json(['message' => 'Captcha salah!'], 422);
        }

        $user = User::where('email', $request->email)->first();

        $otp = random_int(100000, 999999);

        $hashedotp = Hash::make($otp);

        Cache::put('otp_' . $user->email, $hashedotp, now()->addMinutes(1));

        Mail::to($user->email)->send(new OtpMail($otp));

        return response()->json(['message' => 'Cek kode OTP di email anda'], 200);
    }

    public function requestOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|exists:users,email',
            'g-recaptcha-response' => 'required|string',
        ]);

        $googleResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('RECAPTCHA_SECRET'),
            'response' => $request->input('g-recaptcha-response'),
        ]);

        $result = $googleResponse->json();

        if (!($result['success'] ?? false)) {
            return response()->json(['message' => 'Captcha salah!'], 422);
        }

        $user = User::where('email', $request->email)->first();

        $otp = random_int(10000000, 99999999);
        $hashedotp = Hash::make($otp);

        Cache::put('otp_' . $user->email, $hashedotp, now()->addMinutes(1));
        Mail::to($user->email)->send(new OtpMail($otp));

        return response()->json(['message' => 'Cek kode OTP di email anda'], 200);
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        $simpanOtphash = Cache::get('otp_' . $request->email);

        if (!$simpanOtphash || !Hash::check($request->otp, $simpanOtphash)) {
            return response()->json(['message' => 'Kode OTP tidak valid'], 400);
        }

        Cache::forget('otp_' . $request->email);

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['status' => 'sukses', 'message' => 'Login berhasil', 'token' => $token, 'user' => $user], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['status' => 'sukses', 'message' => 'Logout berhasil'], 200);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name'      => 'required|string|max:255',
            'provinsi'  => 'nullable|string',
            'kota'      => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kelurahan' => 'nullable|string',
        ]);

        $user->name      = $request->name;
        $user->provinsi  = $request->provinsi;
        $user->kota      = $request->kota;
        $user->kecamatan = $request->kecamatan;
        $user->kelurahan = $request->kelurahan;

        $user->save();

        return response()->json([
            'message' => 'Profil berhasil diperbarui!',
            'user'    => $user
        ], 200);
    }
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data tidak valid!',
                'errors'  => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Password saat ini salah!'
            ], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password berhasil diperbarui!'], 200);
    }

    public function updateFoto(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {

            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }

            $path = $request->file('foto')->store('avatars', 'public');

            $user->foto = $path;
            $user->save();

            return response()->json([
                'message'  => 'Foto profil berhasil diperbarui!',
                'foto_url' => asset('storage/' . $user->foto)
            ], 200);
        }
        return response()->json(['message' => 'Tidak ada file yang diunggah'], 400);
    }
    public function hapusFoto(Request $request)
    {
        $user = $request->user();

        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);

            $user->foto = null;
            $user->save();

            return response()->json(['message' => 'Foto profil berhasil dihapus!'], 200);
        }

        return response()->json(['message' => 'Tidak ada foto untuk dihapus'], 400);
    }
    public function getAllUsers(Request $request)
    {
        $search = $request->query('search'); 

        $sortBy = $request->query('sort_by', 'created_at'); 
        $sortDir = $request->query('sort_dir', 'desc');

        $allowedSorts = ['name', 'email', 'role', 'kota'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        $sortDir = strtolower($sortDir) === 'asc' ? 'asc' : 'desc';

        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('kota', 'like', "%{$search}%");
        })
        ->orderBy($sortBy, $sortDir)
        ->paginate(10);
        return response()->json(['message' => 'Berhasil mengambil data', 'data' => $users], 200);
    }
    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Target tidak ditemukan!'], 404);
        }

        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->delete();

        return response()->json(['message' => 'Akun berhasil Dihapus!'], 200);
    }

    public function ubahRole(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Target tidak ditemukan!'], 404);
        }

        $user->role = $request->role;
        $user->save();

        return response()->json(['message' => 'Role berhasil diubah!'], 200);
    }

    public function resetPasswordUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Target tidak ditemukan!'], 404);
        }

        $user->password = Hash::make('Sandibaru123');
        $user->save();

        return response()->json(['message' => 'Sandi berhasil direset menjadi: Sandibaru123'], 200);
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => ['required', Password::min(12)->mixedCase()->symbols()],
            'role'     => 'required|in:user,admin',
            'provinsi'  => 'nullable|string',
            'kota'      => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kelurahan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data tidak valid!',
                'errors'  => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'provinsi'  => $request->provinsi,
            'kota'      => $request->kota,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
        ]);

        return response()->json([
            'message' => 'User baru berhasil ditambahkan!',
            'data'    => $user
        ], 201);
    }
    public function updateUserAdmin(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan!'], 404);
    }
    $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email,' . $id,
            'provinsi'  => 'nullable|string',
            'kota'      => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kelurahan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data tidak valid!',
                'errors'  => $validator->errors()
            ], 422);
        }

        $user->name      = $request->name;
        $user->email     = $request->email;
        $user->provinsi  = $request->provinsi;
        $user->kota      = $request->kota;
        $user->kecamatan = $request->kecamatan;
        $user->kelurahan = $request->kelurahan;
        $user->save();

        return response()->json(['message' => 'Data user berhasil diperbarui!'], 200);
        }
}