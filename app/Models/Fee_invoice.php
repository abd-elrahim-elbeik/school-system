<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee_invoice extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function grade()
    {
      return $this->belongsTo(Grade::class);
    }

    public function classroom()
    {
      return $this->belongsTo(Classroom::class);
    }

    public function student()
    {
      return $this->belongsTo(Student::class);
    }

    public function fee()
    {
      return $this->belongsTo(Fee::class);
    }

}
