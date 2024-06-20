<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'intitule', 'frais_dossier'];
    
    public function demandes()
    {
        return $this->hasMany(Demande::class);
    } 
    
    public function getPieces($idService)
    {
        $pieces = DB::table('service_pieces')->join('pieces','pieces.id','=','service_pieces.piece_id')
        ->where('service_pieces.service_id',$idService)->pluck('pieces.id', 'pieces.intitule');
        return $pieces;
    }
}
