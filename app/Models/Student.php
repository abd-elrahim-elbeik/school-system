<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;
use Spatie\Translatable\HasTranslations;

class Student extends User
{
    use HasFactory,SoftDeletes,HasTranslations;

    public $translatable = ['name'];
    protected $guarded =[];

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }


    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }



    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }


    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }


    public function myparent()
    {
        return $this->belongsTo(MyParent::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function student_account()
    {
        return $this->hasMany(StudentAccount::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

}
