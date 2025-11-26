<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Client;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        // Assign roles if provided
        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('users.show', $user)
            ->with('success', __('messages.msg_user_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $roles = Role::all();
        $clients = Client::all();

        return view('users.edit', compact('user', 'roles', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        // Only hash password if it's provided
        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        // Sync roles if provided
        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        // Sync assigned clients if provided
        if ($request->has('clients')) {
            $clientsData = [];
            foreach ($request->clients as $clientId) {
                $clientsData[$clientId] = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_owner' => false,
                ];
            }
            $user->assignedClients()->sync($clientsData);
        }

        return redirect()->route('users.show', $user)
            ->with('success', __('messages.msg_user_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Prevent deleting the current authenticated user
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', __('messages.msg_cannot_delete_self'));
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', __('messages.msg_user_deleted'));
    }
}
