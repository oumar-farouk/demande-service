<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ServicePiece extends Model
{
    use HasFactory;

    protected $fillable = ['service_id', 'piece_id', 'nombre'];
    
}
