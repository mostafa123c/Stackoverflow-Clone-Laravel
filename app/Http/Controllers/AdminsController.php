<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny' , User::class);

        $admins = User::with('roles')->where('type' , 'admin')->orWhere('type' , 'super-admin')->paginate();


        return view('admins.index' , compact('admins'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create' , User::class);

        $admin = new User();
        $roles = Role::all();
        return view('admins.create' , compact('admin' , 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create' , User::class);

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'type' => 'required|in:admin,super-admin',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::where('email' , $request->email)->first();
        if(!$user){
            return redirect()->back()->with('error' , 'This Admin does not exist');
        };


        DB::beginTransaction();
        try{
            $user->update([
                'type' => $request->type,
            ]);
            $user->roles()->attach($request->role_id);
            DB::commit();
        }catch (\Throwable $e){
            DB::rollback();
            throw $e;
        }

        return redirect()->route('admins.index')->with('success' , 'Admin created successfully');
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
        $this->authorize('update' , User::class);

        $admin = User::findOrFail($id);
        $roles = Role::all();
        return view('admins.edit' , compact('admin' , 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update' , User::class);

        $request->validate([
            'type' => 'required|in:admin,super-admin',
            'role_id' => 'required|exists:roles,id',
        ]);

        $admin = User::findOrFail($id);

        DB::beginTransaction();
        try{
            $admin->update([
                'type' => $request->type,
            ]);
            $admin->roles()->sync($request->role_id);
            DB::commit();
        }catch (\Throwable $e){
            DB::rollback();
            throw $e;
        }

        return redirect()->route('admins.index')->with('success' , 'Admin updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete' , User::class);

        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('admins.index')->with('success' , 'Admin deleted successfully');
    }
}
