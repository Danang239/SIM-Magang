<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('roles');

        // Search name, email, or instansi
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('instansi', 'like', '%' . $search . '%');
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $roleName = $request->input('role');
            $query->role($roleName);
        }

        $users = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();
        $roles = Role::all();

        return view('admin.user.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new Petugas account.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created Petugas in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'no_hp' => ['required', 'string', 'regex:/^[0-9]+$/', 'min:10', 'max:15'],
            'instansi' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Nomor HP hanya boleh berisi angka.',
            'no_hp.min' => 'Nomor HP minimal 10 digit.',
            'no_hp.max' => 'Nomor HP maksimal 15 digit.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'instansi' => $request->instansi,
            'password' => Hash::make($request->password),
        ]);

        // Assign Petugas role
        $user->assignRole('Petugas');

        return redirect()->route('admin.user.index')
            ->with('success', "Akun Petugas {$user->name} berhasil didaftarkan.");
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        // Admin cannot edit themselves via this controller (use profile instead to protect admin account)
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.user.index')
                ->with('error', 'Anda tidak dapat mengedit akun Anda sendiri di sini. Silakan gunakan menu Profil.');
        }

        $roles = Role::all();

        return view('admin.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            abort(403, 'Aksi ditolak.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'no_hp' => ['required', 'string', 'regex:/^[0-9]+$/', 'min:10', 'max:15'],
            'instansi' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'string', 'exists:roles,name'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Nomor HP hanya boleh berisi angka.',
            'role.required' => 'Role pengguna wajib dipilih.',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'instansi' => $request->instansi,
        ]);

        // Sync Spatie role
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.user.index')
            ->with('success', "Akun {$user->name} berhasil diperbarui.");
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.user.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Delete user (cascade will handle child tables if specified or restrict on delete FK constraints)
        $user->delete();

        return redirect()->route('admin.user.index')
            ->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
