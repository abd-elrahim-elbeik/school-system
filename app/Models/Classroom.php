<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Classroom extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['name_class'];

    public $translatable = ['name_class'];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

}
