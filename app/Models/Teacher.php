<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Spatie\Translatable\HasTranslations;

class Teacher extends User
{
    use HasFactory, HasTranslations;
    public $translatable = ['name'];
    protected $guarded=[];

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class);
    }
}
