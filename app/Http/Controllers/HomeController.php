<?php

namespace App\Http\Controllers;

use App\Post;
use App\Post_User;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::get_posts();
        // получить посты авторизованного пользовотеля
        $favourites = (auth()->id()) ? User::find(auth()->id())->posts : [];
        return view('home', compact('posts', 'favourites'));
    }

    public function store(Request $request)
    {
        // без middleware
        // проверка авторизован ли пользователь
        // if (!auth()->check()) {
        //     return redirect()->route('user.login')->with('error', 'Войдите в систему, что-бы добавить пост в избранное');
        // }
        if (!auth()->check()) {
            return redirect()->route('user.login')->with('error', 'Пожалуйста, войдите в систему, чтобы добавить пост в избранное.');
        }
        // id авторизованного пользовотеля
        // существует-ли пост
        $post = Post::find($request->postId);
        if (!$post) {
            return redirect()->back()->with('error', 'Пост не найден');
        }
        // dd($post->users);
        // проверка на то что у него еще нет такого поста
        // get использовать нельзя т.к. он получает данные из тбл укак SELECT
        // $is_user_has_post = $post->users()->where('user_id', '=', auth()->id())->get();

        // ВАРИАНТ 1
        $is_user_has_post = $post->users()->where('user_id', auth()->id())->exists();        // dump($is_user_has_post);
        // users() -  описывает отношение между моделью Post и моделью User. 
        // Добавление новой связи (добовление записей в промежуточную таблицу - при работе со связью многие к многим) - метод attach()
        // auth()->id() извлекает идентификатор авторизовонного пользовотеля
        // т.е. из всех постов добовляй(сохроняй в БД) через связь по id авторизовонного пользовотеля
        // в замен auth()->id() можно добавить нескольким через [12,23]
        if (!$is_user_has_post) {
            $post->users()->attach(auth()->id());
            return redirect()->home()->with('success', 'Пост добавлен в избранное');
        } else {
            return redirect()->home()->with('fail', 'Пост уже в избранном');
        }

        //                      ВАРИАНТ 2 (обойтись без проверок)
        // 
        // $post->users()->syncWithoutDetaching(auth()->id());
        // 
        //                      ЗАМЕНЯЕТ ТО ЧТО НИЖЕ
        // $is_user_has_post = $post->users()->where('user_id', auth()->id())->exists();
        // if (!$is_user_has_post) {
        //      $post->users()->attach(auth()->id());
        //      return redirect()->home()->with('success', 'Пост добавлен в избранное');
        // } else {
        //      return redirect()->home()->with('success', 'Пост уже в избранное');
        // }
    }

    // // или через middleware с добавление auth
    // public function delete(Request $request)
    // {
    //     if (!auth()->check()) {
    //         return redirect()->route('user.login')->with('error', 'Пожалуйста, войдите в систему, чтобы удалить пост из избранного');
    //     }
    //     dd($request);
    // }
    public function delete(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('user.login')->with('error', 'Пожалуйста, войдите в систему, чтобы удалить пост из избранного');
        } else {
            $id = $request->id;
            $post = Post::find($id);
            $result = $post->users()->detach(auth()->id());
            echo $result;
        }
    }
}
