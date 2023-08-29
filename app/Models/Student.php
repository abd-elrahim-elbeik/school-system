<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Student extends Model
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

}
