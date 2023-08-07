<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class My_Parent extends Model
{
    use HasFactory;


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


}
