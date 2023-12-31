<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Nationality extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable=['name'];

    public $translatable = ['name'];

    public function parents()
    {
        return $this->hasMany(My_Parent::class);

    }

    public function students()
    {
        return $this->hasMany(Student::class);

    }

}
