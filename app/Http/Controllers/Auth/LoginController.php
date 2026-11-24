<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class LoginController extends Controller
{
    /**
     * Mostrar formulario de inicio de sesión.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Procesar inicio de sesión.
     */
    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ]);

        $usuario = Usuario::where('nombre_usuario', $request->usuario)
            ->orWhere('correo_login', $request->usuario)
            ->first();

        if (!$usuario || !$usuario->estado || !Hash::check($request->password, $usuario->password)) {
            return back()
                ->withErrors(['usuario' => 'Las credenciales son incorrectas.'])
                ->onlyInput('usuario');
        }

          // Iniciar sesión
        Auth::login($usuario);

        $request->session()->regenerate();

         // Obtener el rol del usuario
        $usuario->load('rol');

         // Redireccionar según el rol
        switch ($usuario->rol?->nombre) {

            case 'Administrador':
                return redirect()->route('admin.dashboard');

            case 'Recepcionista':
                return redirect()->route('recepcionista.dashboard');

            case 'Cliente':
                return redirect()->route('cliente.dashboard');

            default:
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->withErrors([
                        'usuario' => 'El usuario no tiene un rol válido.'
            ]);
      }
    }

    /**
     * Cerrar sesión.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}