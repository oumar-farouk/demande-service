<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandePiece extends Model
{
    use HasFactory;

    protected $fillable = ['piece_id', 'demande_id', 'chemin_fichier', 'nom_fichier'];
    
    public function piece()
    {
        return $this->belongsTo(Piece::class);
    }
    
    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}