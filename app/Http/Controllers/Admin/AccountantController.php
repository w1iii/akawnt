<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountantController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'accountant');

        if ($request->has('search') && $request->search) {
            $search = '%'.$request->search.'%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                    ->orWhere('email', 'like', $search);
            });
        }

        $accountants = $query->with('jobApplications')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.accountants.index', compact('accountants'));
    }

    public function show(User $accountant)
    {
        $accountant->load('jobApplications');
        return view('admin.accountants.show', compact('accountant'));
    }

    public function create()
    {
        return view('admin.accountants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'accountant',
        ]);

        return redirect()->route('admin.accountants.index')
            ->with('success', 'Accountant created successfully.');
    }

    public function edit(User $accountant)
    {
        return view('admin.accountants.edit', compact('accountant'));
    }

    public function update(Request $request, User $accountant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($accountant->id)],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $accountant->name = $validated['name'];
        $accountant->email = $validated['email'];

        if ($validated['password']) {
            $accountant->password = Hash::make($validated['password']);
        }

        $accountant->save();

        return redirect()->route('admin.accountants.index')
            ->with('success', 'Accountant updated successfully.');
    }

    public function destroy(User $accountant)
    {
        // Check if accountant has accepted applications
        if ($accountant->jobApplications()->where('status', 'accepted')->exists()) {
            return redirect()->route('admin.accountants.index')
                ->with('error', 'Cannot delete accountant with accepted applications.');
        }

        $accountant->delete();

        return redirect()->route('admin.accountants.index')
            ->with('success', 'Accountant deleted successfully.');
    }
}
