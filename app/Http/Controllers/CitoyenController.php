<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Citoyen;
use App\Models\User;


class CitoyenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $citoyens = [];
        foreach (Citoyen::all() as $citoyen) {
            $citoyens [] = [
                $citoyen->id,
                $citoyen->nom,
                $citoyen->prenom,
                $citoyen->telephone,
                $citoyen->cnib,
                $citoyen->created_at 
            ];
        }
        
        return view('common.index',[
            'cols' => ['Nom', 'Prénom', 'Téléphone', 'Réf. CNIB','Date'],
            'rows' => $citoyens,
            'title' => 'Liste des Citoyens',
            'new_url' => 'citoyens.create',
            'show_url' => 'citoyens.show',
            'edit_url' => 'citoyens.edit',
            'delete_url' => 'citoyens.destroy',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $users = [];
        foreach (User::all() as $user) {
            $users [] = [
                'value' => $user->id,
                'label' => $user->name,
            ];
        }
        $form = [
            ['name' => 'nom', 'label' => 'Nom', 'type' => 'text','value' => ''],
            ['name' => 'prenom', 'label' => 'Prénom', 'type' => 'text','value' => ''],
            ['name' => 'date_naissance', 'label' => 'Date de naissance', 'type' => 'date','value' => ''],
            ['name' => 'lieu_naissance', 'label' => 'Lieu d naissance', 'type' => 'text','value' => ''],
            ['name' => 'telephone', 'label' => 'Téléphone', 'type' => 'text','value' => ''],
            ['name' => 'cnib', 'label' => 'Réf. CNIB', 'type' => 'text','value' => ''],
            ['name' => 'user', 'label' => 'User', 'type' => 'select','value' => '', 'placeholder' => 'Selectionner un utilisateur', 'choices' => $users],
        ];
        return view('common.create',
            [
                'title' => 'Créer un nouveau citoyen',
                'post_url' => 'citoyens.store',
                'form' => $form
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'date_naissance' => 'required',
            'lieu_naissance' => 'required',
            'telephone' => 'required',
            'cnib' => 'required',
            'user' => 'required',
        ]);
     
        $citoyen = new Citoyen([
            'nom' =>  $request->nom,
            'prenom' =>  $request->prenom,
            'date_naissance' =>  $request->date_naissance,
            'lieu_naissance' =>  $request->lieu_naissance,
            'telephone' =>  $request->telephone,
            'cnib' =>  $request->cnib,
            'user_id' =>  $request->user,
        ]);

        $citoyen->save();
        
        return redirect()->route('citoyens.index')->with('success', 'Citoyen créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Citoyen $citoyen)
    {
        $data = [
            'id' => $citoyen->id,
            'Nom' => $citoyen->nom,
            'Prénom' => $citoyen->prenom,
            'Date de naissance' => $citoyen->date_naissance,
            'Lieu de naissance' => $citoyen->lieu_naissance,
            'Téléphone' => $citoyen->telephone,
            'Email' => $citoyen->telephone,
            'Réf. CNIB' => $citoyen->cnib,
            'Date de création' => $citoyen->created_at 
        ];

        return view('common.show',[
            'title' => 'Détails du Citoyen',
            'data' => $data,
            'demandes' => $citoyen->demandes()->get(),
            'edit_url' => 'citoyens.edit',
            'delete_url' => 'citoyens.destroy',
            'index_url' => 'citoyens.index',
            'add_demande_url' => 'demandes.create',
            'show_demande_url' => 'demandes.show',
            'edit_demande_url' => 'demandes.edit',
            'delete_demande_url' => 'demandes.destroy',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Citoyen $citoyen)
    {
        $users = [];
        foreach (User::all() as $user) {
            $users [] = [
                'value' => $user->id,
                'label' => $user->name,
            ];
        }

        $form = [
            ['name' => 'nom', 'label' => 'Nom', 'type' => 'text', 'value' => $citoyen->nom],
            ['name' => 'prenom', 'label' => 'Prénom', 'type' => 'text', 'value' => $citoyen->prenom],
            ['name' => 'date_naissance', 'label' => 'Date de naissance', 'type' => 'date', 'value' => $citoyen->date_naissance],
            ['name' => 'lieu_naissance', 'label' => 'Lieu d naissance', 'type' => 'text', 'value' => $citoyen->lieu_naissance],
            ['name' => 'telephone', 'label' => 'Téléphone', 'type' => 'text', 'value' => $citoyen->telephone],
            ['name' => 'cnib', 'label' => 'Réf. CNIB', 'type' => 'text', 'value' => $citoyen->cnib],
            ['name' => 'user', 'label' => 'User', 'type' => 'select','value' => $citoyen->user_id, 'placeholder' => 'Selectionner un utilisateur', 'choices' => $users],
        ];

        return view('common.edit',
            [
                'title' => 'Éditer le citoyen',
                'post_url' => 'citoyens.update',
                'entityID' => $citoyen->id,
                'form' => $form
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Citoyen $citoyen)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'date_naissance' => 'required',
            'lieu_naissance' => 'required',
            'telephone' => 'required',
            'cnib' => 'required',
            'user' => 'required',
        ]);

        $citoyen->update($request->all());

        return redirect()->route('citoyens.index')->with('success', 'Citoyen mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Citoyen $citoyen)
    {
        $citoyen->delete();

        return redirect()->route('citoyens.index')->with('success', 'Citoyen supprimé avec succès.');
    }
}
