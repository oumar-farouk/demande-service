<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    use HasFactory;

    protected $fillable = ['intitule'];
    
    public function demandePieces()
    {
        return $this->hasMany(DemandePiece::class);
    }
}