<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = ['citoyen_id', 'service_id'];
    
    public function citoyen()
    {
        return $this->belongsTo(Citoyen::class);
    }
    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    
    public function demandePieces()
    {
        return $this->hasMany(DemandePiece::class);
    }  
    public function pieces($idService)
    {
        $pieces = DB::table('service_pieces')->join('pieces','pieces.id','=','service_pieces.piece_id')
        ->where('service_pieces.service_id',$idService)->pluck('pieces.id', 'pieces.intitule');
        return $pieces;
    }
}