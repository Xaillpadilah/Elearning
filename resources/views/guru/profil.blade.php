<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Guru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="max-w-5xl mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-4">
                <a href="{{ route('guru.dashboardguru') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                    ← Kembali
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Profil Guru</h2>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    Keluar
                </button>
            </form>
        </div>

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        <!-- Layout -->
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Form Kiri -->
            <div class="md:w-2/3">
                <form method="POST" action="{{ route('guru.profil.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nama -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                        @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- NIK -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">NIK</label>
                        <input type="text" value="{{ $guru->nik }}" disabled
                            class="w-full px-4 py-2 border rounded bg-gray-100 text-gray-600">
                    </div>


                    <!-- Upload Foto -->
                    <div class="mb-4">
                        <label for="foto" class="block text-gray-700 font-medium mb-1">Ganti Foto Profil</label>
                        <input type="file" name="foto" accept="image/*"
                            class="block mt-1 text-sm text-gray-700">
                        @error('foto') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Tombol -->
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            <!-- Foto Profil -->
            <div class="md:w-1/3 flex flex-col items-center justify-center text-center border-t md:border-t-0 md:border-l border-gray-200 pt-6 md:pt-0 md:pl-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Foto Profil</h3>
                <img src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('images/default-profile.png') }}"
                     alt="Foto Profil"
                     class="w-40 h-40 object-cover rounded-full border mb-4">
            </div>
        </div>
    </div>

</body>
</html>
