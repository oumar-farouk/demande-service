<?php

namespace App\Http\Controllers;

use App\Models\Piece;
use App\Models\ServicePiece;
use Illuminate\Http\Request;

use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = [];
        foreach (Service::all() as $service) {
            $services [] = [
                $service->id,
                $service->code,
                $service->intitule,
                count($service->getPieces($service->id)),
                $service->frais_dossier,
            ];
        }
        return view('common.index',[
            'cols' => ['Code', 'Intitulé', 'Nbr. pièce', 'Frais de dossier'],
            'rows' => $services,
            'title' => 'Liste des Services',
            'new_url' => 'services.create',
            'show_url' => 'services.show',
            'edit_url' => 'services.edit',
            'delete_url' => 'services.destroy',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $form = [
            ['name' => 'code', 'label' => 'Code','value' => '', 'type' => 'text'],
            ['name' => 'intitule', 'label' => 'Intitulé','value' => '', 'type' => 'text'],
            ['name' => 'frais_dossier', 'label' => 'Frais de dossier','value' => '', 'type' => 'number'],
        ];
        return view('common.create',
            [
                'title' => 'Créer un nouveau service',
                'post_url' => 'services.store',
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
            'code' => 'required|unique:services',
            'intitule' => 'required',
            'frais_dossier' => 'required|numeric',
        ]);

        Service::create($request->all());

        return redirect()->route('services.index')->with('success', 'Service créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        $data = [
            'id' => $service->id,
            'Code' => $service->code,
            'Intitulé' => $service->intitule,
            'Frais de dossier' => $service->frais_dossier, 
            'Date de création' => $service->created_at 
        ];

        $pieces = $service->getPieces($service->id);

        return view('common.show',[
            'title' => 'Détails du Service',
            'data' => $data,
            'pieces' => $pieces,
            'edit_url' => 'services.edit',
            'delete_url' => 'services.destroy',
            'index_url' => 'services.index',
            'add_piece_url' => 'services.addpiece',
            'delete_service_piece_url' => 'services.destroypiece',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $form = [
            ['name' => 'code', 'label' => 'Code', 'type' => 'text', 'value' =>$service->code],
            ['name' => 'intitule', 'label' => 'Intitulé', 'type' => 'text', 'value' =>$service->intitule],
            ['name' => 'frais_dossier', 'label' => 'Frais de dossier', 'type' => 'number', 'value' =>$service->frais_dossier],
        ];
        return view('common.edit',
            [
                'title' => 'Éditer le service',
                'post_url' => 'services.update',
                'entityID' => $service->id,
                'form' => $form
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'code' => 'required|unique:services,code,' . $service->id,
            'intitule' => 'required',
            'frais_dossier' => 'required|numeric',
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Service mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service supprimé avec succès.');
    }
 

    /**
     * Show the form for creating a new resource.
     */
    public function createpiece(Service $service)
    {
        $serviceChoices = [];
        foreach (Service::all() as $service) {
            $serviceChoices [] = [
                'value' => $service->id,
                'label' => $service->intitule,
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
            ['name' => 'service_id', 'label' => 'Service','value' => $service->id, 'type' => 'select', 'choices' =>$serviceChoices, 'placeholder' => 'Selectioner un service'],
            ['name' => 'piece_id', 'label' => 'Pièce','value' =>'', 'type' => 'select', 'choices' =>$piecesChoices, 'placeholder' => 'Selectioner une pièce'],
            ['name' => 'nombre', 'label' => 'Nombre','value' =>'', 'type' => 'number'],
        ];
        
        return view('common.create',
            [
                'title' => 'Ajouter une pièce à un service',
                'post_url' => 'services.storepiece',
                'form' => $form
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storepiece(Request $request)
    {
        $request->validate([
            'service_id' => 'required',
            'piece_id' => 'required',
            'nombre' => 'required',
        ]);
        
        ServicePiece::create($request->all());

        return redirect()->route('services.index')->with('success', 'Service créé avec succès.');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function editpiece(ServicePiece $servicePiece)
    {
        $serviceChoices = [];
        foreach (Service::all() as $service) {
            $serviceChoices [] = [
                'value' => $service->id,
                'label' => $service->intitule,
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
            ['name' => 'service','label' => 'Service', 'type' => 'select', 'value' => $servicePiece->service, 'choices' =>$serviceChoices, 'placeholder' => 'Selectioner un service'],
            ['name' => 'piece', 'label' => 'Pièce', 'type' => 'select', 'value' => $servicePiece->piece, 'choices' =>$piecesChoices, 'placeholder' => 'Selectioner une pièce'],
            ['name' => 'nombre', 'label' => 'Nombre', 'type' => 'number', 'value' => $servicePiece->nombre]
        ];
        return view('common.create',
            [
                'title' => 'Ajouter une pièce à un service',
                'post_url' => 'services.storepiece',
                'form' => $form
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updatepiece(Request $request, ServicePiece $servicePiece)
    {
        $request->validate([
            'service' => 'required',
            'piece' => 'required',
            'nombre' => 'required',
        ]);
        
        $servicePiece->update($request->all());

        return redirect()->route('services.index')->with('success', 'Service créé avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroypiece(ServicePiece $servicepiece)
    {
        $servicepiece->delete();

        return redirect()->route('services.index')->with('success', 'La piece du service supprimé avec succès.');
    }
}
