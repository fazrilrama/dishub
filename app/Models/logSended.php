<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logSended extends Model
{
    use HasFactory;
    protected $table = 'log_message';
    protected $primaryKey = 'id';
    protected $fillable = [
        'SID',
        'person_id',
        'message',
        'created_at'
    ];
}
