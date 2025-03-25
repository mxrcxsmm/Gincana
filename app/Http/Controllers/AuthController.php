<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function showLoginForm()
    {
        return view('login'); // Asegúrate de que esta vista exista o cámbiala por 'login'
    }

    /**
     * Procesa el formulario de login.
     */
    public function login(Request $request)
    {
        // Validar los datos de entrada con mensajes personalizados.
        $credentials = $request->validate([
            'email'    => 'required|email|max:255',
            'password' => 'required|string|min:6',
        ], [
            'email.required'    => 'El correo electrónico es requerido.',
            'email.email'       => 'El correo electrónico no es válido.',
            'password.required' => 'La contraseña es requerida.',
        ]);

        // Intentar autenticar
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            // Redirigir según el rol
            if ($user->role_id == 1) {
                return redirect()->intended('admin/lugares')
                    ->with('success', 'Has iniciado sesión correctamente.');
            } else {
                return redirect()->intended('inicio/')
                    ->with('success', 'Has iniciado sesión correctamente.');
            }
        }

        // Si falla la autenticación, volvemos al formulario con mensajes de error.
        return back()->withErrors([
            'email'    => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            'password' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->with('error', 'Credenciales incorrectas. Por favor, inténtalo de nuevo.')
          ->onlyInput('email');
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Has cerrado sesión.');
    }

    /**
     * Muestra el formulario de registro.
     */
    public function showRegistrationForm()
    {
        return view('register');
    }

    /**
     * Procesa el registro de un nuevo usuario.
     */
    public function register(Request $request)
    {
        // Validar datos de registro
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'email'    => 'required|string|email|max:150|unique:usuarios',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'nombre.required'   => 'El nombre es requerido.',
            'nombre.string'     => 'El nombre debe ser una cadena.',
            'nombre.max'        => 'El nombre no puede superar los 100 caracteres.',
            'email.required'    => 'El correo electrónico es requerido.',
            'email.string'      => 'El correo electrónico debe ser una cadena.',
            'email.email'       => 'El correo electrónico no es válido.',
            'email.max'         => 'El correo electrónico no puede superar los 150 caracteres.',
            'email.unique'      => 'Este correo electrónico ya está en uso.',
            'password.required' => 'La contraseña es requerida.',
            'password.string'   => 'La contraseña debe ser una cadena.',
        ]);

        $user = new User();
        $user->nombre = $request->nombre;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = 2; // Asigna rol de usuario regular
        $user->grupo_id = null; // O ajusta según la lógica de grupos
        $user->save();

        // Autenticar al usuario automáticamente tras el registro
        Auth::login($user);

        return redirect()->intended('inicio');
    }
}
