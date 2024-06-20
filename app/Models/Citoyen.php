<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Citoyen extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prenom', 'date_naissance', 'lieu_naissance', 'telephone', 'cnib', 'user_id'];
    
    public function getUser($idUser)
    {
        return DB::table('users')->where('id',$idUser)->get();
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}