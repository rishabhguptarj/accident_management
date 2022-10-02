<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsvModel extends Model
{
    use HasFactory;
    protected $table = "fatalities";
    protected $fillable = ['country','state','city','pincode','fatalities','age','gender','vehicle','insured_status','created_at'];
}
