<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use App\Models\User;
// use Illuminate\Support\Facades\Hash;


// class AuthController extends Controller
// {
//     public function showLogin()
//     {
//         $user = Auth::user();
//         if (Auth::check()) {
//             if($user->role === 'ADMIN'){
//             return redirect('/admin'); // ya está logueado
//             }elseif($user->role === 'DOCENTE'){
//                 return redirect('/docente'); // ya está logueado
//             }
//             }
            
        
//         return view('auth.login');
//     }

//     public function login(Request $request)
//     {
//         $credentials = $request->only('email', 'password');

//         if (Auth::attempt($credentials)) {
//             $request->session()->regenerate();
//             // ✅ Revisamos el rol del usuario logueado
//         $user = Auth::user();

//         if ($user->role === 'ADMIN') {
//             return redirect('/admin');
//         } elseif ($user->role === 'DOCENTE') {
//             return redirect('/docente');;
//         }
           
//         }

//         return back()->withErrors([
//             'email' => 'Credenciales incorrectas.',
//         ]);
//     }

//     public function logout(Request $request)
//     {
//         Auth::logout();
//         $request->session()->invalidate();
//         $request->session()->regenerateToken();
//         return redirect('/login');
//     }
// }

