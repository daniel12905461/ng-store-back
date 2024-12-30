<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        $user = new User([
            'email' => $request->email,
            'name' => $request->name,
            'user' => $request->user,
            'password' => bcrypt($request->password),
        ]);

        $user->save();

        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'ok' =>true,
            'user'=> $user,
            'token'=>$token
        ]);
    }

    public function login(Request $request){

        // $data = $request->only('user', 'password');

        // if (! Auth::attempt($data)) {
        if (! Auth::attempt(['user' =>  $request->user, 'password' => $request->password])) {
            return response()->json([
                'ok' =>false,
                'message'=> 'Usuario o contraseña incorrectos',
            ], 409);
        }

        $token = Auth::user()->createToken('authToken')->accessToken;

        return response()->json([
            'ok' =>true,
            'user' => Auth::user(),
            // 'roles'=> Auth::user()->rols()->get(),
            'token'=>$token
        ]);
    }

    public function logout()
    {
        if (Auth::check()) {
            // Auth::user()->AauthAcessToken()->delete();
            $token = Auth::user()->token();
            $token->revoke();
        }

        return response()->json([
          'ok' => true,
          'message' => 'Sesión cerrada con éxito',
        ]);
    }

    public function me(){
        return response()->json([
            'ok' =>true,
            'user'=> Auth::user()
        ]);
    }

    public function index()
    {
        //
        $users = User::paginate();
        // $users = User::with('rols')->get();
        return response()->json(['ok' => true, 'data' => $users], 200);
    }

    public function roles()
    {
        // $user = Auth::user();
        $rols = Rol::all();
        // $userRols = User::with('rols')->where('id',$user->id)->first();

        $data = [];
        foreach ($rols as $i => $rol) {
            $data[$i] = [
                'id' => $rol->id,
                'name' => $rol->nombre,
                'display_name' => $rol->nombre_aux,
                'selected' => false,
            ];
            // foreach ($userRols->rols as $i => $rol_aux) {
            //     if ($rol_aux->nombre === $rol->nombre) {
            //         $data[$i] = [
            //             'id' => $rol->id,
            //             'name' => $rol->nombre,
            //             'display_name' => $rol->nombre_aux,
            //             'selected' => true,
            //         ];
            //     }
            // }
        }

        return response()->json(['ok' => true, 'rols' => $data], 200);
    }

    public function store(Request $request)
    {
        //
        $user = new User();
        $user->nombres = $request->input('nombres');
        $user->apellidos = $request->input('apellidos');
        $user->user = $request->input('user');
        // $user->password = $request->input('password');
        $user->password = Hash::make($request->input('password'));
        $user->remember_token = Str::random(10);
        // $user->activo = true;
        // $user->admin = '1';
        // $user->control = '0';
        $user->name = 'none';
        $user->email = Str::random(10) . '@example.com';
        $user->email_verified_at = now();     

        // $roles = $request->input('roles');
        
        // UserRol::where('user_id', $user->id)->delete();
        // foreach ($roles as $rolData) {
        //     if ($rolData['selected'] == true) {
        //         $userRol = new UserRol();
        //         $userRol->user_id = $user->id;
        //         $userRol->rol_id = $rolData['id'];
        //         $userRol->save();
        //     }
        // }

        $imagen_file = $request->file('imagen');
        if ($imagen_file) {
            $ruta_imagen = Str::random(10).$imagen_file->getClientOriginalName();
            \Storage::disk('images')->put($ruta_imagen, \File::get($imagen_file));
            $user->imagen = $ruta_imagen;
        }else {
            $user->imagen = '';
            // return response()->json('La Imagen del Libro es requerido', 404);
        }
        $user->save(); 

        return response()->json(['ok' => true, 'data' => $user], 201);
    }

    public function show($id)
    {
        //
        $user = User::findOrFail($id);
        // $user = User::with('rols')->findOrFail($id);
        
        // $rols = Rol::all();
        // $data_rols = [];
        // foreach ($rols as $i => $rol) {
        //     $data_rols[$i] = [
        //         'id' => $rol->id,
        //         'name' => $rol->nombre,
        //         'display_name' => $rol->nombre_aux,
        //         'selected' => false,
        //     ];
        //     foreach ($user->rols as $rol_aux) {
        //         if ($rol_aux->nombre === $rol->nombre) {
        //             $data_rols[$i] = [
        //                 'id' => $rol->id,
        //                 'name' => $rol->nombre,
        //                 'display_name' => $rol->nombre_aux,
        //                 'selected' => true,
        //             ];
        //         }
        //     }
        // }

        $data = [
            'id' => $user->id,
            'nombres' => $user->nombres,
            'apellidos' => $user->apellidos,
            'user' => $user->user,
            'activo' => $user->activo,
            'admin' => $user->admin,
            'control' => $user->control,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            // 'roles' => $data_rols
        ];

        return response()->json(['ok' => true, 'data' => $data], 200);
    }

    public function update($id, Request $request)
    {
        //
        $user = User::findOrFail($id);
        $user->nombres = $request->input('nombres');
        $user->apellidos = $request->input('apellidos');
        $user->user = $request->input('user');
        // $user->password = $request->input('password');
        $user->password = Hash::make($request->input('password'));
        $user->remember_token = Str::random(10);
        // $user->activo = true;
        // $user->admin = '1';
        // $user->control = '0';
        $user->name = 'none';
        $user->email = Str::random(10) . '@example.com';
        $user->email_verified_at = now();
        $user->save();      

        // $roles = $request->input('roles');
        
        // // $roles_Aux = UserRol::where('user_id', $user->id)->get();
        // UserRol::where('user_id', $user->id)->delete();
        // // foreach ($roles_Aux as $rol) {
        // //     $rol->delete();
        // // }
        // foreach ($roles as $rolData) {
        //     if ($rolData['selected'] == true) {
        //         $userRol = new UserRol();
        //         $userRol->user_id = $user->id;
        //         $userRol->rol_id = $rolData['id'];
        //         $userRol->save();
        //     }
        // }

        return response()->json(['ok' => true, 'data' => $user], 201);
    }

    public function destroy($id)
    {
        //
        $user = User::findOrFail($id);
        $user->delete();

        // UserRol::where('user_id', $user->id)->delete();

        return response()->json(['ok' => true, 'data' => $user], 201);
    }
}
