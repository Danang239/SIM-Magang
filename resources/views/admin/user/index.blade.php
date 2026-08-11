<x-layouts.internal>
    <!-- Header Section -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 font-sans">Kelola Pengguna</h2>
            <p class="text-xs text-gray-400 mt-1">Daftar pengguna sistem SIM-MAGANG, atur role hak akses, dan tambah petugas operasional baru.</p>
        </div>
        <a href="{{ route('admin.user.create') }}" class="bg-biogen-medium hover:bg-biogen-light text-white text-xs px-5 py-2.5 rounded-xl font-bold shadow-sm hover:shadow transition-all duration-200 inline-flex items-center space-x-2 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            <span>Tambah Petugas</span>
        </a>
    </div>

    <!-- Notifications -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-sm text-emerald-700 flex items-center space-x-2">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-sm text-red-700 flex items-center space-x-2">
            <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Search & Filter Panel -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 mb-6">
        <form method="GET" action="{{ route('admin.user.index') }}" class="flex flex-col md:flex-row md:items-center gap-4">
            <!-- Search field -->
            <div class="relative flex-grow">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full text-xs rounded-xl border border-gray-200 pl-9 pr-4 py-2.5 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none transition"
                    placeholder="Cari nama, email, atau instansi...">
                <div class="absolute left-3 top-3 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <!-- Role filter -->
            <div class="w-full md:w-48">
                <select name="role"
                    class="w-full text-xs rounded-xl border border-gray-200 px-4 py-2.5 focus:ring-2 focus:ring-biogen-medium focus:border-biogen-medium outline-none bg-white transition">
                    <option value="">-- Semua Role --</option>
                    @foreach($roles as $r)
                        <option value="{{ $r->name }}" {{ request('role') === $r->name ? 'selected' : '' }}>{{ $r->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-center space-x-2 shrink-0">
                <button type="submit" class="bg-biogen-dark hover:bg-biogen-medium text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-sm transition-all duration-200">
                    Filter
                </button>
                @if(request('search') || request('role'))
                    <a href="{{ route('admin.user.index') }}" class="px-4 py-2.5 bg-gray-50 border border-gray-200 hover:bg-gray-100 text-gray-500 rounded-xl text-xs font-semibold transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Users Table Listing -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        @if($users->isEmpty())
            <div class="text-center py-16">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <p class="text-xs text-gray-500 font-medium">Tidak ada pengguna yang ditemukan.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                            <th class="px-6 py-4">Nama Pengguna</th>
                            <th class="px-6 py-4">Nomor HP</th>
                            <th class="px-6 py-4">Asal Instansi</th>
                            <th class="px-6 py-4">Hak Akses / Role</th>
                            <th class="px-6 py-4">Tanggal Daftar</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <!-- Profile Photo -->
                                        @if($user->foto_profil)
                                            <img src="{{ Storage::disk('public')->url($user->foto_profil) }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover shadow-sm">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-emerald-100 text-biogen-medium flex items-center justify-center font-bold text-xs">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-bold text-gray-800 text-sm">{{ $user->name }}</p>
                                            <p class="text-[10px] text-gray-400 font-normal mt-0.5">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    {{ $user->no_hp ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $user->instansi ?? '-' }}
                                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $user->program_studi ?? '-' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $role = $user->roles->pluck('name')->first() ?? 'Tidak ada';
                                        $badgeColor = match($role) {
                                            'Administrator' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                            'Petugas' => 'bg-emerald-100 text-biogen-dark border-emerald-200',
                                            'Pengguna' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            default => 'bg-gray-100 text-gray-700 border-gray-200'
                                        };
                                    @endphp
                                    <span class="inline-block text-[9px] font-bold px-2 py-0.5 rounded-full uppercase border {{ $badgeColor }}">
                                        {{ $role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-400">
                                    {{ $user->created_at->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    @if($user->id !== auth()->id())
                                        <div class="inline-flex items-center space-x-2">
                                            <!-- Edit -->
                                            <a href="{{ route('admin.user.edit', $user->id) }}" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 text-[10px] font-bold px-3 py-1.5 rounded-lg shadow-sm transition-all">
                                                Edit
                                            </a>
                                            <!-- Delete Form -->
                                            <form method="POST" action="{{ route('admin.user.destroy', $user->id) }}"
                                                class="inline-block"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus user {{ $user->name }}? Semua data pengajuannya akan terhapus.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-650 border border-red-200 text-[10px] font-bold px-3 py-1.5 rounded-lg transition-all">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-[10px] text-gray-400 italic font-semibold">Akun Anda</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $users->links() }}
                </div>
            @endif
        @endif
    </div>
</x-layouts.internal>
