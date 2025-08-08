<div class="p-4 bg-white rounded shadow">
    <h2 class="text-lg font-semibold">{{ $admin->name }}</h2>
    <p>{{ $admin->email }}</p>
    <a href="{{ route('user.laporan.kirim', $admin->id) }}" 
       class="mt-2 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Kirim Laporan
    </a>
</div>
