<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $with = ['user', 'category', 'photos'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public  function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function scopeSearch($q)
    {
        return  $q->when(request('keyword'), function ($q, $keyword) {
            $q->where(function ($q) use ($keyword) {
                $q->orWhere("title", "like", "%$keyword%")
                    ->orWhere("description", "like", "%$keyword%");
            });
        });
    }
    //accessor
    // public function getTitleAttribute($value)
    // {
    //     return strtoupper($value);
    // }

    public function getTimeAttribute($value)
    {
        // return $this->created_at->format('d/m/y');
        return "<p class='small mb-0 text-black-50'>
        <i class='bi bi-calendar'></i>
        {{$this->created_at->format('d M Y')}}</p>
        <p class='small mb-0 text-black-50'>
        <i class='bi bi-clock'></i>
        {{$this->created_at->format('h : m A')}}</p>";
    }

    //mutator
    // public function setTitleAttribute($value)
    // {
    //     $this->attributes['title'] = strtolower($value);
    // }

    //observer
    // protected static function booted()
    // {
    //     static::created(function () {
    //         logger('CREATED NEW POST');
    //     });
    // }
}
