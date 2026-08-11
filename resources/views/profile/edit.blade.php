@if(auth()->user()->hasRole('Pengguna'))
    <x-layouts.publik>
        <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 font-sans">Pengaturan Profil</h1>
                <p class="text-xs text-gray-500 mt-1">Perbarui data profil, informasi kontak, dan kata sandi akun Anda.</p>
            </div>

            <div class="p-6 bg-white shadow-sm border border-gray-100 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 bg-white shadow-sm border border-gray-100 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 bg-white shadow-sm border border-gray-100 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </x-layouts.publik>
@else
    <x-layouts.internal>
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 font-sans">Pengaturan Profil</h2>
            <p class="text-xs text-gray-400 mt-1">Perbarui data profil, informasi kontak, dan kata sandi akun internal Anda.</p>
        </div>

        <div class="max-w-3xl space-y-6">
            <div class="p-6 bg-white shadow-sm border border-gray-200 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 bg-white shadow-sm border border-gray-200 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 bg-white shadow-sm border border-gray-200 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </x-layouts.internal>
@endif
