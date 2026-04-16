<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminWhitelist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    private function isWhitelisted($email)
    {
        return AdminWhitelist::where('email', $email)->exists();
    }

    public function index(Request $request)
    {
        $whitelistedEmails = AdminWhitelist::pluck('email')->toArray();

        $query = Admin::whereNotIn('email', $whitelistedEmails);

        if ($request->has('search') && $request->search) {
            $search = '%'.$request->search.'%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                    ->orWhere('email', 'like', $search);
            });
        }

        if ($request->has('filter') && $request->filter) {
            if ($request->filter === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->filter === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        $admins = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.management.index', compact('admins'));
    }

    public function create()
    {
        if (! $this->isWhitelisted(auth()->guard('admin')->user()->email)) {
            abort(403, 'Only whitelisted admins can create new admins.');
        }

        return view('admin.management.create');
    }

    public function store(Request $request)
    {
        if (! $this->isWhitelisted(auth()->guard('admin')->user()->email)) {
            abort(403, 'Only whitelisted admins can create new admins.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.management.index')
            ->with('success', 'Admin created successfully.');
    }

    public function edit(Admin $admin)
    {
        if (! $this->isWhitelisted(auth()->guard('admin')->user()->email)) {
            abort(403, 'Only whitelisted admins can edit admins.');
        }

        return view('admin.management.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        if (! $this->isWhitelisted(auth()->guard('admin')->user()->email)) {
            abort(403, 'Only whitelisted admins can update admins.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('admins')->ignore($admin->id)],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];

        if ($validated['password']) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return redirect()->route('admin.management.index')
            ->with('success', 'Admin updated successfully.');
    }

    public function destroy(Admin $admin)
    {
        if (! $this->isWhitelisted(auth()->guard('admin')->user()->email)) {
            abort(403, 'Only whitelisted admins can delete admins.');
        }

        if ($admin->id === auth()->guard('admin')->id()) {
            return redirect()->route('admin.management.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $admin->delete();

        return redirect()->route('admin.management.index')
            ->with('success', 'Admin deleted successfully.');
    }
}
