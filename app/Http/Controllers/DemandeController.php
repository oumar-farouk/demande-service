<?php

namespace App\Http\Controllers;

use App\Models\Citoyen;
use App\Models\DemandePiece;
use Illuminate\Http\Request;

use App\Models\Demande;
use App\Models\Piece;
use App\Models\Service;

class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $demandes = [];
        if($request->user()->roles == 'ROLE_ADMIN')
        {
            $cols = ['Citoyen','Service','Nbr. pièces', 'Date de création'];
            foreach (Demande::all() as $demande) {
                $demandes [] = [
                    $demande->id,
                    $demande->citoyen()->first()->nom,
                    $demande->service()->first()->intitule,
                    $demande->demandePieces()->count(),
                    $demande->created_at 
                ];
            }
        }else if($request->user()->roles == 'ROLE_USER'){
            $cols = ['Service','Nbr. pièces', 'Statut', 'Date de création'];
            foreach (Demande::where('citoyen_id', '=', Citoyen::where(['user_id' =>  $request->user()->id])->first()->id)->get() as $demande) {
                $demandes [] = [
                    $demande->id,
                    $demande->service()->first()->intitule,
                    $demande->demandePieces()->count(),
                    'En cours',
                    $demande->created_at 
                ];
            }
        }
        
        return view('common.index',[
            'cols' => $cols,
            'rows' => $demandes,
            'title' => 'Liste des Demandes',
            'new_url' => 'demandes.create',
            'show_url' => 'demandes.show',
            'edit_url' => 'demandes.edit',
            'delete_url' => 'demandes.destroy',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $serviceChoices = [];
        foreach (Service::all() as $service) {
            $serviceChoices [] = [
                'value' => $service->id,
                'label' => $service->intitule,
            ];
        }

        $citoyenChoices = [];
        foreach (Citoyen::all() as $citoyen) {
            $citoyenChoices [] = [
                'value' => $citoyen->id,
                'label' => $citoyen->nom,
            ];
        }
        
        $form = [['name' => 'service_id', 'label' => 'Service','value' => '', 'type' => 'select', 'choices' =>$serviceChoices, 'placeholder' => 'Selectioner un service']];
        
        if($request->user()->roles == 'ROLE_ADMIN')
        {
            $form [] = ['name' => 'citoyen_id', 'label' => 'Citoyen','value' => '', 'type' => 'select', 'choices' =>$citoyenChoices, 'placeholder' => 'Selectioner un citoyen'];
        }

        return view('common.create',
            [
                'title' => 'Nouvelle demande',
                'post_url' => 'demandes.store',
                'form' => $form
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['service_id' => 'required', 'citoyen_id' => 'nullable']);

        $citoyen_id = $request->citoyen_id ?  $request->citoyen_id : Citoyen::where(['user_id' =>  $request->user()->id])->first()->id;

        $demande = new Demande(['citoyen_id'=>$citoyen_id,'service_id' =>  $request->service_id]);

        $demande->save();

        return redirect()->route('demandes.index')->with('success', 'Demande créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Demande $demande)
    {
        $data = [
            'id' => $demande->id,
            'Demandeur' => $demande->citoyen()->first()->nom .' '. $demande->citoyen()->first()->prenom,
            'Service visé' => $demande->service()->first()->intitule,
        ];

        return view('common.show',[
            'title' => 'Détails du Demande',
            'data' => $data,
            'demandepieces' => $demande->demandePieces()->get(),
            'index_url' => 'demandes.index',
            'edit_url' => 'demandes.edit',
            'delete_url' => 'demandes.destroy',
            'add_demande_piece_url' => 'demandes.addpiece',
            'show_demande_piece_url' => 'demandepieces.show',
            'edit_demande_piece_url' => 'demandepieces.edit',
            'delete_demande_piece_url' => 'demandepieces.destroy',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Demande $demande)
    {
        $serviceChoices = [];
        foreach (Service::all() as $service) {
            $serviceChoices [] = [
                'value' => $service->id,
                'label' => $service->intitule,
            ];
        }

        $citoyenChoices = [];
        foreach (Citoyen::all() as $citoyen) {
            $citoyenChoices [] = [
                'value' => $citoyen->id,
                'label' => $citoyen->nom,
            ];
        }

        $form = [['name' => 'service_id', 'label' => 'Service','value' => $demande->service()->first()->id, 'type' => 'select', 'choices' =>$serviceChoices, 'placeholder' => 'Selectioner un service']];
        
        if($request->user()->roles == 'ROLE_ADMIN')
        {
            $form [] = ['name' => 'citoyen_id', 'label' => 'Citoyen','value' =>  $demande->citoyen()->first()->id, 'type' => 'select', 'choices' =>$citoyenChoices, 'placeholder' => 'Selectioner un citoyen'];
        }

        return view('common.edit',
            [
                'title' => 'Éditer le demande',
                'post_url' => 'demandes.update',
                'entityID' => $demande->id,
                'form' => $form
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Demande $demande)
    {
        $request->validate(['service_id' => 'required', 'citoyen_id' => 'nullable']);

        $citoyen_id = $request->citoyen_id ?  $request->citoyen_id : Citoyen::where(['user_id' =>  $request->user()->id])->first()->id;

        $demande->update(['citoyen_id'=>$citoyen_id,'service_id' =>  $request->service_id]);

        return redirect()->route('demandes.index')->with('success', 'Demande mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Demande $demande)
    {
        $demande->delete();

        return redirect()->route('demandes.index')->with('success', 'Demande supprimé avec succès.');
    }

    public function addDemandePiece(Demande $demande)
    {        
        
        $pieces = $demande->pieces($demande->service()->first()->id);
        $demandePieces = $demande->demandePieces()->get()->pluck('piece_id')->toArray(); 
                 
        $piecesChoices = [];
        foreach ($pieces as $value => $key) {

            if(!in_array($key, $demandePieces )){
                $piecesChoices [] = [
                    'value' => $key,
                    'label' => $value
                ];
            }
        }
        $form = [
            ['name' => 'demande_id', 'label' => 'Demande', 'type' => 'hidden', 'value' => $demande->id,],
            ['name' => 'piece_id', 'label' => 'Pièce', 'type' => 'select', 'choices' =>$piecesChoices, 'placeholder' => 'Selectioner une pièce','value' => '',],
            ['name' => 'file', 'label' => 'Choisir un fichier', 'type' => 'file', 'accept' => '.pdf',],
        ];

        return view('common.create',
            [
                'title' => 'Ajouter une nouvelle piece à la demande '.$demande->id,
                'post_url' => 'demandes.storepiece',
                'form' => $form
            ]
        );
    }

    public function storeDemandePiece(Request $request)
    {
        $request->validate([
            'piece_id' => 'required',
            'file' => 'required|mimes:pdf|max:2048'
        ]);

        $file = $request->file('file');
        $filename = time() . '-' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);

        $piece = new DemandePiece(['piece_id' => $request->piece_id,
            'demande_id' => $request->demande_id,
            'chemin_fichier' => $filename,
            'nom_fichier' => $file->getClientOriginalName()]);
        $piece->save();
        
        return redirect()->route('demandes.show',[$request->demande_id])->with('success', 'DemandePiece créé avec succès.');
    }

}
