<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::get_posts();
        return view('home', compact('posts'));
    }

    public function store(Request $request)
    {
        dump($request->postId);
        // id авторизованного пользовотеля

        // существует-ли пост
        $post = Post::find($request->postId);
        // dd($post->users);
        // проверка на то что у него еще нет такого поста
        $is_user_has_post = $post->users()->where('id', '=', auth()->id());
        if ($post and !$is_user_has_post) {
            // users() -  описывает отношение между моделью Post и моделью User. 
            // Добавление новой связи (добовление записей в промежуточную таблицу - при работе со связью многие к многим) - метод attach()
            // auth()->id() извлекает идентификатор авторизовонного пользовотеля
            // т.е. из всех постов добовляй(сохроняй в БД) через связь по id авторизовонного пользовотеля
            $post->users()->attach(auth()->id());
            // в замен auth()->id() можно добавить нескольким через [12,23]
            return redirect()->home();
        }
    }
}
