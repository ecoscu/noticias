<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Periodico extends Model
{
    use HasFactory;
    use Sluggable;

    protected $table = 'periodicos';

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'user_periodico');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true
            ]
        ];
    }
}
