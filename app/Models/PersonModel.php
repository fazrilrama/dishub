<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonModel extends Model
{
    use HasFactory;
    protected $table = 'person_estimate';
    protected $primaryKey = 'id';
    protected $fillable = ['fullname', 'email', 'phone', 'no_pol', 'end_date', 'status', 'created_at'];
}
