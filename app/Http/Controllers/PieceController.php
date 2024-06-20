<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Piece;

class PieceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pieces = [];
        foreach (Piece::all() as $piece) {
            $pieces [] = [
                $piece->id,
                $piece->intitule,
                $piece->created_at 
            ];
        }
        return view('common.index',[
            'cols' => ['Intitulé','Date'],
            'rows' => $pieces,
            'title' => 'Liste des Pieces',
            'new_url' => 'pieces.create',
            'show_url' => 'pieces.show',
            'edit_url' => 'pieces.edit',
            'delete_url' => 'pieces.destroy',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $form = [
            ['name' => 'intitule', 'label' => 'Intitulé','value' => '', 'type' => 'text'],
        ];
        return view('common.create',
            [
                'title' => 'Créer une nouvelle piece',
                'post_url' => 'pieces.store',
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
            'intitule' => 'required|unique:pieces',
        ]);

        Piece::create($request->all());

        return redirect()->route('pieces.index')->with('success', 'Piece créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Piece $piece)
    {
        $data = [
            'id' => $piece->id,
            'Intitulé' => $piece->intitule,
            'Date de création' => $piece->created_at 
        ];

        return view('common.show',[
            'title' => 'Détails du Pièce',
            'data' => $data,
            'edit_url' => 'pieces.edit',
            'delete_url' => 'pieces.destroy',
            'index_url' => 'pieces.index',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Piece $piece)
    {
        $form = [
            ['name' => 'intitule', 'label' => 'Intitulé', 'type' => 'text', 'value' =>$piece->intitule],
        ];
        return view('common.edit',
            [
                'title' => 'Éditer le piece',
                'post_url' => 'pieces.update',
                'entityID' => $piece->id,
                'form' => $form
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Piece $piece)
    {
        $request->validate([
            'intitule' => 'required|unique:pieces,intitule,' . $piece->intitule,
        ]);

        $piece->update($request->all());

        return redirect()->route('pieces.index')->with('success', 'Piece mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Piece $piece)
    {
        $piece->delete();

        return redirect()->route('pieces.index')->with('success', 'Piece supprimé avec succès.');
    }
}
