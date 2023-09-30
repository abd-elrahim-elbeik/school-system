<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Spatie\Translatable\HasTranslations;

class MyParent extends User
{
    use HasFactory,HasTranslations;

    public $translatable = ['Name_Father','Job_Father','Name_Mother','Job_Mother'];
    protected $guarded=[];

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }

    public function typeblood()
    {
        return $this->belongsTo(TypeBlood::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }


}
