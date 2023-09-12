<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Fee extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title'];

    protected $guarded =[];

    public function grade()
    {
      return $this->belongsTo(Grade::class);
    }

    public function classroom()
    {
      return $this->belongsTo(Classroom::class);
    }


}
