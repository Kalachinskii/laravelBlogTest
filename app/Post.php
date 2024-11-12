<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function category()
    {
        // пост относиться к категории
        return $this->belongsTo(Category::class);
    }

    public static function get_posts()
    {
        // модель автоматически связана с БД
        // dump(Post::all()->toArray());

        // ленивая загрузка - через форычь

        // жадная загрузка - только при связи
        // : это тяни, в таблице category : id,name - пробелы не допустимы
        $posts = Post::with('category:id,name')->get();
        return $posts;
    }

    public function users()
    {
        // отношения «многие ко многим»
        return $this->belongsToMany(User::class);
    }
}
