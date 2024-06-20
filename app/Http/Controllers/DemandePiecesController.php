<?php

namespace App\Http\Controllers;

use App\Models\Citoyen;
use App\Models\Demande;
use App\Models\Piece;
use Illuminate\Http\Request;

use App\Models\DemandePiece;

class DemandePiecesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $demandepieces = [];
        foreach (DemandePiece::all() as $piece) {
            $demandepieces [] = [
                $piece->id,
                $piece->demande_id,
                $piece->piece_id,
                $piece->nom_fichier,
                $piece->created_at 
            ];
        }
        return view('common.index',[
            'cols' => ['Demande', 'Pièce', 'Titre document', 'Date'],
            'rows' => $demandepieces,
            'title' => 'Liste des Pièces jointes',
            'new_url' => 'demandepieces.create',
            'show_url' => 'demandepieces.show',
            'edit_url' => 'demandepieces.edit',
            'delete_url' => 'demandepieces.destroy',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $demandeChoices = [];
        foreach (Demande::all() as $demande) {
            $demandeChoices [] = [
                'value' => $demande->id,
                'label' => $demande->id,
            ];
        }
        
        $piecesChoices = [];
        foreach (Piece::all() as $piece) {
            $piecesChoices [] = [
                'value' => $piece->id,
                'label' => $piece->intitule,
            ];
        }

        $form = [
            ['name' => 'demande_id', 'label' => 'Demande', 'type' => 'select', 'choices' =>$piecesChoices,'placeholder' => 'Selectioner une pièce','value' => ''],
            ['name' => 'piece_id', 'label' => 'Pièce', 'type' => 'select', 'choices' =>$piecesChoices, 'placeholder' => 'Selectioner une pièce','value' => ''],
            ['name' => 'file', 'label' => 'Choisir un fichier', 'type' => 'file', 'accept' => '.pdf',],
        ];

        return view('common.create',
            [
                'title' => 'Créer une nouvelle piece',
                'post_url' => 'demandepieces.store',
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
            'demande_id' => 'required',
            'piece_id' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('file');
        $filename = time() . '-' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);

        $piece = new DemandePiece(['piece_id' => $request->piece_id,
            'demande_id' => $request->demande_id,
            'chemin_fichier' => $filename,
            'nom_fichier' => $file->getClientOriginalName()]);
        $piece->save();
        
        return redirect()->route('demandepieces.index')->with('success', 'DemandePiece créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, DemandePiece $demandepiece)
    {
        $demandeur = Citoyen::where(['user_id' => $request->user()->id])->first();

        $data = [
            'id' => $demandepiece->id,
            'Demandeur' => $demandeur->nom .' '.$demandeur->prenom,
            'Pièce' => $demandepiece->piece()->first()->intitule,
            'Nom du fichier' => $demandepiece->nom_fichier,
            'Date de création' => $demandepiece->created_at 
        ];

        return view('common.show',[
            'title' => 'Détails du Pièce',
            'data' => $data,
            'edit_url' => 'demandepieces.edit',
            'delete_url' => 'demandepieces.destroy',
            'index_url' => 'demandepieces.index',
            'demandepieceURL' => $demandepiece->chemin_fichier
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DemandePiece $demandepiece)
    {
        $demandeChoices = [];
        foreach (Demande::all() as $demande) {
            $demandeChoices [] = [
                'value' => $demande->id,
                'label' => $demande->id,
            ];
        }
        
        $piecesChoices = [];
        foreach (Piece::all() as $piece) {
            $piecesChoices [] = [
                'value' => $piece->id,
                'label' => $piece->intitule,
            ];
        }

        $form = [
            ['name' => 'piece_id', 'label' => 'Pièce', 'type' => 'select', 'value' => $demandepiece->piece()->first()->id, 'choices' =>$piecesChoices, 'placeholder' => 'Selectioner une pièce'],
            ['name' => 'file', 'label' => 'Choisir un fichier', 'type' => 'file', 'value' => '','accept' => '.pdf'],

        ];
        return view('common.edit',
            [
                'title' => 'Éditer le piece',
                'post_url' => 'demandepieces.update',
                'entityID' => $demandepiece->id,
                'form' => $form
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DemandePiece $demandepiece)
    {
        $request->validate([
            'piece_id' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('file');
        $filename = time() . '-' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);
        

        $demandepiece->update([
            'piece_id' => $request->piece_id,
            'demande_id' => $demandepiece->demande_id,
            'nom_fichier' => $file->getClientOriginalName(),
            'chemin_fichier' =>  $filename
        ]);

        return redirect()->route('demandepieces.index')->with('success', 'DemandePiece mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DemandePiece $demandepiece)
    {
        $demandepiece->delete();

        return redirect()->route('demandepieces.index')->with('success', 'DemandePiece supprimé avec succès.');
    }
}
