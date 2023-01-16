<?php

namespace App\Http\Controllers\seguridad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\user;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;


class RoleController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;
    
        if (!empty($keyword)) {
          $roles = Role::where('name', 'LIKE', "%$keyword%")
            ->orWhere('guard_name', 'LIKE', "%$keyword%")
            ->latest()->paginate($perPage);
        } else {
          $roles = Role::orderBy('id','DESC')->latest()->paginate($perPage);
        }
        $esabm = true;

        return view('seguridad.roles.index',compact('roles','esabm'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $permission = Permission::get();
        return view('seguridad.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:roles,name',
            'guard_name' => 'required|max:255'
        ]);

        $role = Role::create(['name' => $request->input('name'),
                                'guard_name' => $request->input('guard_name')]);
        //$role->syncPermissions($request->input('permission'));
        $esabm = true;

        return redirect()->route('roles.index',compact('esabm'))
                        ->with('flash_message','Role created successfully');
    }

    public function show($id)
    {
        $roles = Role::findOrfail($id);
        // $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
        //     ->where("role_has_permissions.role_id",$id)
        //     ->get();


        return view('seguridad.roles.show',compact('roles'));
    }

    public function edit($id)
    {
        $roles = Role::findOrFail($id);
        // $permission = Permission::get();
        // $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
        //     ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        //     ->all();


        return view('seguridad.roles.edit',compact('roles'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:roles,name,'. $id,
            'guard_name' => 'required|max:255',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->guard_name = $request->input('guard_name');
        $role->save();
        $esabm = true;
        //$role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index',compact('esabm'))
                        ->with('flash_message','Role updated successfully');
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();

        return redirect()->route('roles.index')
                        ->with('flash_message','Role deleted successfully');
    }

    public function usuarios(int $rolid, int $usuid = null, string $tarea = ''){

        $rol = role::find($rolid);
        $user = user::find($usuid);
        switch ($tarea) {
            case 'asignar':
                $a = $user->assignRole($rol);
                break;

            case 'desasignar':
                $a = $user->removeRole($rol);
                break;
        }

        $user = $rol->users()->paginate(5);
        $users = DB::table('users')                 
            ->select( 'id', 'name', 'last_name', 'email',
                        'email_verified_at', 'password', 'remember_token',
                        'foto', 'created_at', 'updated_at', 'deleted_at')
            ->whereNotIn('id', DB::table('model_has_roles')->select('model_id')->where('role_id', '=', $rolid))
            ->paginate(25);
        $esabm = false;

        $titulo = 'asignados al rol  ->   ' . strtoupper($rol->name);
        $padre = "roles";
        // $rolid = $roles->id;

        return view('seguridad.usuario.index',  compact('padre', 'rolid', 'user', 'users', 'esabm', 'titulo'));   

    }

    public function permisos(int $rolid, int $perid = null, string $tarea = ''){

        $rol = role::find($rolid);
        $per = permission::find($perid);
        switch ($tarea) {
            case 'asignar':
                // asigna el rol
                $a = $rol->givePermissionTo($per);
                break;

            case 'desasignar':
                $a = $rol->revokePermissionTo($per);
                break;
        }

        $permisos = $rol->permissions()->paginate(5);
        $permisoss = DB::table('permissions')                 
            ->select('id', 'name', 'guard_name', 
            'created_at', 'updated_at')
            ->whereNotIn('id', DB::table('role_has_permissions')->select('permission_id')->where('role_id', '=', $rolid))
            ->paginate(25);
        $esabm = false;

        $titulo = 'asignados al rol  ->   ' . strtoupper($rol->name);
        $padre = "roles";
        // $rolid = $roles->id;

        return view('seguridad.permisos.index',  compact('padre', 'rolid', 'permisos', 'permisoss', 'esabm', 'titulo'));   
 
      }

    
}