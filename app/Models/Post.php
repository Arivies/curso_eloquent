<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "category_id",
        "title",
        "slug",
        "likes",
        "dislikes",
        "content",
    ];

    protected $appends = [
        "title_with_author"
    ];

    protected $casts=[
        "created_at"=>"datetime:Y-m-d",
    ];

 /* PARA CARGAR AUTOMATICAMENTE DATOS DEL USUARIO
    protected $with=[
        "user:id,name,email"
    ];*/

    protected static function booted() {
        static::addGlobalScope("currentMonth", function (Builder $builder) {
            $builder->whereMonth("created_at", now()->month);
        });
    }

    public function user(){
        return $this->BelongsTo(User::class)->withDefault([
            "id"=>-1,
            "name"=>"No Existe"
        ]);
    }

    public function category(){
        return $this->BelongsTo(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function sortedTags(){
        return $this->belongsToMany(Tag::class)
            ->orderBy("tag");
    }


    public function setTitleAttribute(string $title) {
        $this->attributes["title"] = $title;
        $this->attributes["slug"] = Str::slug($title);
    }

    public function getTitleWithAuthorAttribute(){
        return sprintf("%s - %s", $this->title, $this->user->name);
    }

    public function scopeWhereHasTagWithTags(Builder $builder){

        return $builder
                ->select(["id", "title"])
                ->with("tags:id,tag")
                ->whereHas("tags");
    }





}
