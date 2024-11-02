<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;

class UserController extends Controller
{
    // сообщения наошибки
    private $messages = [
        'email.required' => 'Поле не должно быть пустным',
        'email.unique' => 'Пользователь существует',
        'email.email' => 'Значение должно быть почтой',
        'password.min' => 'Слабый пароль',
        'password.max' => 'Превышено кол-во симовлов в пароле',
        'password.confirmed' => 'Пароли не совпадают',
        'password.required' => 'Поле не должно быть пустным',
    ];

    public function register()
    {
        return view('user.register');
    }

    public function store(Request $request)
    {
        // пришла информация
        // dump($request->all());

        // рабочий вариант но выведет сообщения на англ
        // $request->validate([
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required|confirmed|min:4|max:16',
        // ]);

        // проверка правил
        $rules = [
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:4|max:16',
        ];

        Validator::make($request->all(), $rules, $this->messages)->validate();

        $req = $request->all();
        $req['password'] = bcrypt($req['password']);
        $user = User::create($req);

        Auth::login($user);
        // временное хранилище для сессии
        // доступно до перезагрузке по ключу success
        session()->flash('success', 'Регистрация пройдена');
        return redirect()->route('home');
    }

    public function login()
    {
        return view('user.login');
    }

    public function checkLogin(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $cred = Validator::make($request->all(), $rules, $this->messages)->validate();

        // if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        if (Auth::attempt($cred)) {
            return redirect()->route('home');
        }

        // return back()->with('одноразовое сообщение в сесии');
        return back()->with('login-error', 'Некоректный логин или пароль');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('user.login');
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
