<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Unique;

class UserController extends Controller
{
    public function register()
    {
        return view('user.register');
    }

    public function store(Request $request)
    {
        // dump($request->all());
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:4|max:16',
        ]);

        $req = $request->all();
        $req['password'] = bcrypt($req['password']);
        $user = User::create($req);

        Auth::login($user);

        return redirect()->route('home');
    }
    // Requsest - клсасс для получения данных с формы
    // public function store(Request $request)
    // {
    //     // dump($request->all);
    //     // true/false - в переменную не надо афтоматом при фолсе дальше не идет
    //     $request->validate([
    //         'email' => 'required|email|unique:users',
    //         // name=password == name=password_чтототам
    //         'password' => 'required|confirmed|min:4|max:16',
    //     ]);
    //     // User::created(['email' => $request->email])
    //     $req = $request->all();
    //     $req['password'] = bcrypt($req['password']);
    //     // берет все поля yj c защитой
    //     // в filable нужные поля в User.php
    //     $user = User::create($request->all());

    //     // фасад для авторизации
    //     Auth::login($user);

    //     // return redirect()->home();
    //     return redirect()->route('home');
    // }
}
