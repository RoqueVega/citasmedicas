<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Redirect;
use App\Models\User;
use App\Models\AgendaCita;

class AuthController extends Controller
{
    public function login()
    {
        return redirect()->route('access.login');
    }

    public function signIn(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|max:20'
        ],
        [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe de ser válido.',
            'password.required' => 'La contraseña es obligatorio.'
        ]);

        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);
        if(!$token){
            if(env('TEST_MOD_API', 0) == 1){
                return response()->json([
                    'status' => 'error', 
                    'message' => 'El usuario no tiene acceso.', 
                    'authorisation' => [
                        'token' => $token, 
                        'type' => 'bearer'
                    ], 
                    'code' => 401
                ]);
            }
            $this->alerta("No tiene acceso.", "warning");
            return response()->view('login', [
                'mensaje' => 'Acceso inválido.!'
            ]);
        }
        
        $user = Auth::user();
        if(env('TEST_MOD_API', 0) == 1){
            return response()->json([
                'status' => 'success', 
                'user' => $user,  
                'authorisation' => [
                    'token' => $token, 
                    'type' => 'bearer'
                ]
            ]);
        }

        $agendaCitas = AgendaCita::all();
        return redirect()->route('agenda.citas.index'
        ,['agendaCitas' => $agendaCitas])
        ->header('status', 'success')
        ->header('Accept', 'application/json')
        ->header('Authorization', 'Bearer '.$token);
    }

    public function logout()
    {
        Auth::logout();
        if(env('TEST_MOD_API', 0) == 1){
            return response()->json([
                'status' => 'success', 
                'message' => 'Se ha cerrado la sesión.'
            ]);
        }
        return response()->view('login');
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success', 
            'user' => Auth::user(), 
            'authorisation' => [
                'token' => Auth::refresh(), 
                'type' => 'bearer'
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:150',
            'email' => 'required|email',
            'password' => 'required|min:8|max:20',
            'confirmPassword' => 'required|min:8|max:20'
        ],
        [
            'name.required' => 'Nombre obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe de ser válido.',
            'email.unique' => 'El correo electrónico ya existe.',
            'password.required' => 'La contraseña es obligatorio.',
            'confirmPassword.required' => 'La la confirmación de la contraseña es obligatorio.'
        ]);

        if (strcmp($request->password, $request->password) !== 0) {
            $this->alerta("Las contraseñas no coinciden.", "warning");
            return back()->withInput();
        }

        if(User::where("email", $request->email)->exists()){
            $this->alerta("El correo electrónico ya esta registrado.", "warning");
            return back()->withInput();
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('access.login');
        /*$token = Auth::login($user);
        return response()->json([
            'status' => 'success', 
            'message' => 'El usuario se creo correctamente.', 
            'user' => $user,  
            'authorisation' => [
                'token' => $token, 
                'type' => 'bearer'
            ] 
        ]);*/
    }
}
