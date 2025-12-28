<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Kela;
use App\Models\Habit; // Add this line
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function loginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        
        if ($credentials['username'] === 'mustafa' && $credentials['password'] === 'moslem78') {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }
        
        return back()->withErrors(['username' => 'Kredensial tidak valid']);
    }

    public function index()
    {
        $totalUsers = User::count();
        $adminCount = User::where('role', User::ADMIN_ROLE)->count();
        $guruCount = User::where('role', User::GURU_ROLE)->count();
        $siswaCount = User::where('role', User::SISWA_ROLE)->count();
        $totalKelas = Kela::count();
        $totalHabits = Habit::count();

        return view('admin.dashboard', compact('totalUsers', 'adminCount', 'guruCount', 'siswaCount', 'totalKelas', 'totalHabits'));
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    // User Management
    public function usersIndex()
    {
        $users = User::with('kela')->get();
        $kelas = Kela::all();
        return view('admin.users.index', compact('users', 'kelas'));
    }

    public function usersCreate()
    {
        $kelas = Kela::all();
        return view('admin.users.create', compact('kelas'));
    }

    public function usersStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in([User::ADMIN_ROLE, User::GURU_ROLE, User::SISWA_ROLE])],
            'kela_id' => 'nullable|exists:classes,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'kela_id' => $request->kela_id,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function usersEdit(User $user)
    {
        $kelas = Kela::all();
        return view('admin.users.edit', compact('user', 'kelas'));
    }

    public function usersUpdate(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in([User::ADMIN_ROLE, User::GURU_ROLE, User::SISWA_ROLE])],
            'kela_id' => 'nullable|exists:classes,id',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->role = $request->role;
        $user->kela_id = $request->kela_id;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function usersDestroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    // Class Management
    public function kelasIndex()
    {
        $kelas = Kela::all();
        return view('admin.kelas.index', compact('kelas'));
    }

    public function kelasCreate()
    {
        return view('admin.kelas.create');
    }

    public function kelasStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:classes',
            'description' => 'nullable|string',
        ]);

        Kela::create($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Class created successfully.');
    }

    public function kelasEdit(Kela $kela)
    {
        return view('admin.kelas.edit', compact('kela'));
    }

    public function kelasUpdate(Request $request, Kela $kela)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('classes')->ignore($kela->id)],
            'description' => 'nullable|string',
        ]);

        $kela->update($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Class updated successfully.');
    }

    public function kelasDestroy(Kela $kela)
    {
        $kela->delete();
        return redirect()->route('admin.kelas.index')->with('success', 'Class deleted successfully.');
    }

    // Habit Management
    public function habitsIndex()
    {
        $habits = Habit::all();
        return view('admin.habits.index', compact('habits'));
    }

    public function habitsCreate()
    {
        return view('admin.habits.create');
    }

    public function habitsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:habits',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Habit::create($request->all());

        return redirect()->route('admin.habits.index')->with('success', 'Habit created successfully.');
    }

    public function habitsEdit(Habit $habit)
    {
        return view('admin.habits.edit', compact('habit'));
    }

    public function habitsUpdate(Request $request, Habit $habit)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('habits')->ignore($habit->id)],
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $habit->update($request->all());

        return redirect()->route('admin.habits.index')->with('success', 'Habit updated successfully.');
    }

    public function habitsDestroy(Habit $habit)
    {
        $habit->delete();
        return redirect()->route('admin.habits.index')->with('success', 'Habit deleted successfully.');
    }

    // User Import
    public function usersImportForm()
    {
        $kelas = Kela::all(); // Fetch all classes
        return view('admin.users.import', compact('kelas'));
    }

    public function usersImportStore(Request $request)
    {
        // To be implemented: file validation, CSV parsing, user creation/update
        $request->validate([
            'import_file' => 'required|file|mimes:csv,txt|max:2048', // Max 2MB, CSV/TXT format
            'kela_id' => 'required|exists:classes,id',
        ]);

        $kelaId = $request->input('kela_id');
        $file = $request->file('import_file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));

        // Skip header row if exists
        $header = array_shift($data); 
        // Assuming CSV format: name,email,password (optional, will auto-generate if missing),role (optional, defaults to siswa)

        $importedCount = 0;
        $errors = [];

        foreach ($data as $row) {
            if (count($row) < 2) { // Minimum name and email
                $errors[] = 'Baris tidak valid: ' . implode(',', $row);
                continue;
            }

            $name = trim($row[0]);
            $email = trim($row[1]);
            $password = isset($row[2]) && !empty(trim($row[2])) ? trim($row[2]) : \Illuminate\Support\Str::random(10); // Auto-generate password
            $role = isset($row[3]) && !empty(trim($row[3])) ? trim($row[3]) : User::SISWA_ROLE; // Default to Siswa

            // Basic validation for CSV row data
            if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Data baris tidak valid (nama atau email): ' . implode(',', $row);
                continue;
            }

            try {
                $user = User::firstOrNew(['email' => $email]);
                $user->name = $name;
                $user->role = $role; // Allow role from CSV, but can be restricted if needed
                $user->kela_id = $kelaId;

                // Only update password if it's new or provided
                if (!$user->exists || (isset($row[2]) && !empty(trim($row[2])))) {
                     $user->password = Hash::make($password);
                }

                $user->save();
                $importedCount++;
            } catch (\Illuminate\Database\QueryException $e) {
                // Handle potential unique constraint violations or other DB errors
                $errors[] = 'Gagal memproses pengguna ' . $email . ': ' . $e->getMessage();
            }
        }
        
        $message = "Berhasil mengimpor $importedCount pengguna.";
        if (!empty($errors)) {
            $message .= " Beberapa baris gagal diimpor: " . implode('; ', $errors);
            return redirect()->back()->with('error', $message);
        }

        return redirect()->route('admin.users.index')->with('success', $message);
    }

    public function downloadUserImportTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="user_import_template.csv"',
        ];

        $columns = ['nama', 'email', 'password', 'role'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
