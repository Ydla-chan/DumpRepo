



s<!-- resources/views/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Dashboard - {{ Auth::user()->name ?? 'User' }}</title>
   @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-4xl mx-auto py-12 px-4">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <p class="text-sm text-gray-600">Halo, {{ Auth::user()->name ?? 'Tamu' }} — ini halaman informasi akun Anda.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('landing') }}" class="text-sm text-gray-600 hover:underline">Landing</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-2 rounded-md shadow">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Flash messages -->
        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-50 border border-green-200 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 rounded bg-red-50 border border-red-200 text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Main grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Profile card -->
            <div class="col-span-1 md:col-span-2 bg-white p-6 rounded-xl shadow">
                <h2 class="text-lg font-semibold mb-4">Profil Pengguna</h2>

                <div class="space-y-3 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <span class="font-medium">Nama</span>
                        <span>{{ Auth::user()->name }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="font-medium">Email</span>
                        <span>{{ Auth::user()->email }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="font-medium">Status Verifikasi</span>
                        <span>
                            @if(Auth::user()->is_verified)
                                <span class="text-green-600 font-medium">Terverifikasi</span>
                            @else
                                <span class="text-yellow-600 font-medium">Belum Verifikasi</span>
                            @endif
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="font-medium">Dibuat pada</span>
                        <span>{{ Auth::user()->created_at?->format('d M Y H:i') ?? '-' }}</span>
                    </div>

                    @if(property_exists(Auth::user(), 'updated_at'))
                        <div class="flex justify-between">
                            <span class="font-medium">Terakhir diperbarui</span>
                            <span>{{ Auth::user()->updated_at?->diffForHumans() ?? '-' }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Session / quick info -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lg font-semibold mb-3">Session & Info Cepat</h3>

                <div class="text-sm text-gray-700 space-y-3">
                    <div>
                        <div class="text-xs text-gray-500">Email verifikasi (session)</div>
                        <div class="font-medium">{{ session('verify_email') ?? '-' }}</div>
                    </div>

                    <div>
                        <div class="text-xs text-gray-500">Role (jika ada)</div>
                        <div class="font-medium">{{ Auth::user()->role ?? '-' }}</div>
                    </div>

                    <div>
                        <div class="text-xs text-gray-500">Semua session (ringkasan)</div>
                        <pre class="text-xs bg-gray-50 p-2 rounded text-gray-600 overflow-auto" style="max-height:140px">
{{ json_encode(session()->all(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}
                        </pre>
                    </div>
                </div>
            </div>
        </div>

        <!-- Optional: more content -->
        <div class="mt-8 bg-white p-6 rounded-xl shadow text-sm text-gray-700">
            <h4 class="font-semibold mb-2">Catatan</h4>
            <ul class="list-disc pl-5 space-y-1">
                <li>Gunakan tombol <strong>Logout</strong> untuk mengakhiri session.</li>
                <li>Jika kamu ingin menampilkan field tambahan (mis. last_login, avatar, dsb), tambahkan kolom di model & migration lalu panggil di sini.</li>
            </ul>
        </div>
    </div>
</body>
</html>
