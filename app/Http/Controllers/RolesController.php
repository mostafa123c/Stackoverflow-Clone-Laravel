<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RolesController extends Controller
{
//    public function __construct()
//    {
//        $this->authorizeResource(Role::class);
//    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        Gate::authorize('roles.view');
        $this->authorize('viewAny' , Role::class);

        $roles = Role::Paginate();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        Gate::authorize('roles.create');
        $this->authorize('create' , Role::class);

        return view('roles.create', [
            'role' => new Role(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        Gate::authorize('roles.create');
        $this->authorize('create' , Role::class);

        $request->validate([
            'name' => ['required' , 'string'],
            'abilities' => ['required' , 'array']
        ]);

        $role = Role::create($request->all());
        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
//        Gate::authorize('roles.edit');

        $role = Role::findOrFail($id);

        $this->authorize('update' , $role);

        return view('roles.edit', compact('role'));    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
//        Gate::authorize('roles.edit');

        $request->validate([
            'name' => 'required|unique:roles,name,' . $id ,
            'abilities.php' => ['required|array'],
        ]);

        $role = Role::findOrFail($id);
        $this->authorize('update' , $role);
        $role->update($request->all());

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
//        Gate::authorize('roles.delete');
        $role = Role::findOrFail($id);
        $this->authorize('delete' , $role);

        Role::destroy($id);
        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
