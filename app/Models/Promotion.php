<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }


    public function f_grade()
    {
        return $this->belongsTo('App\Models\Grade', 'from_grade');
    }



    public function f_classroom()
    {
        return $this->belongsTo('App\Models\Classroom', 'from_classroom');
    }


    public function f_section()
    {
        return $this->belongsTo('App\Models\Section', 'from_section');
    }


    public function t_grade()
    {
        return $this->belongsTo('App\Models\Grade', 'to_grade');
    }



    public function t_classroom()
    {
        return $this->belongsTo('App\Models\Classroom', 'to_classroom');
    }


    public function t_section()
    {
        return $this->belongsTo('App\Models\Section', 'to_section');
    }
}
