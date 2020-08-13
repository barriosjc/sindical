<?php

namespace App\Http\Controllers\seguridad;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('seguridad.usuario.profile');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::user()->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|max:12|required_with:current_password',
            'password_confirmation' => 'nullable|min:8|max:12|required_with:new_password|same:new_password'
        ]);


        $user = User::findOrFail(Auth::user()->id);
        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');

        if (!is_null($request->input('current_password'))) {
            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = $request->input('new_password');
            } else {
                return redirect()->back()->withInput();
            }
        }

        $user->save();

        return redirect()->route('profile');
    }

    public function updatefoto(Request $rq){
        $rq->validate([
            'foto' => 'image'
        ]);

        $user = User::findOrFail(Auth::user()->id);        
        if ($rq->hasFile('file')){
            // guarda el archivo dentro de storage/app/public/fotos
            $foto_vieja = $user->foto;
            if(!empty($foto_vieja)){
                Storage::delete($foto_vieja);
            }
            //guarda storage/app/public/fotos
            $path = $rq->file('file')->store('public/fotos');
            $user->foto = $path;
            $user->save();

        }

        return redirect()->route('profile');
    }
}
