<x-app-layout>
    <x-slot name="header">
        <div class="bg-white">
            <nav class="font-semibold text-xl text-gray-800 leading-tight">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item">{{ $title }}</li>
                </ol>
            </div>
        </nav>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card" width="100%">
                <div class="card-header">
                    <div class="hstack gap-2"> 
                        <h5 class="card-title">{{$title}}</title></h5>
                        <a class="btn btn-sm btn-success ms-auto" href="{{ route($edit_url, $data['id']) }}">Modifier</a>
                        @isset($demandepieceURL)
                            <a href="{{route('file.download',$demandepieceURL)}}" target="_blank" class="btn btn-sm btn-primary text-center">
                                Télécharger PDF
                            </a>
                        @endisset  
                        <td class="text-end"> @include('common._delete_form',['entityID'=>$data['id']]) </td>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-sm datatable">
                        @foreach (array_slice($data,1,count($data)) as $key => $value)    
                            <tr>
                                <td class="text-start">{{ $key }}</td>
                                <th class="text-start">{{ $value }}</th>
                            </tr>
                        @endforeach
                    </table>
                    
                </div>
            </div>
            @isset($demandes)
                <div class="card" width="100%">
                    <div class="card-header">
                        <div class="hstack gap-2"> 
                            <h5 class="card-title">Liste des services demandées</h5>
                            <a class="btn btn-success ms-auto" href="{{ route($add_demande_url) }}">Ajouter</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Service</th>
                                    <th>Nbr. de pièces</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($demandes as $row)
                                    <tr> 
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $row->service->intitule }}</td>
                                        <td>{{ count($row->demandePieces) }}</td>
                                        <td>{{ $row->created_at }}</td>
                                        <td class="text-end">
                                            <div class="hstack gap-2">
                                                <a class="btn btn-sm btn-secondary" href="{{ route($show_demande_url, $row->id) }}"><i class="ri-eye-fill">Voir</i></a>
                                                <a  class="btn btn-sm btn-primary" href="{{ route($edit_demande_url, $row->id) }}"><i class="ri-edit-2-line">Editer</i></a>
                                                @include('common._delete_form',['entityID'=>$row->id])
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endisset

            @isset($pieces)
                <div class="card" width="100%">
                    <div class="card-header">
                        <div class="hstack gap-2"> 
                            <h5 class="card-title">Liste des pièces à fournir</h5>
                            <a class="btn btn-success ms-auto" href="{{ route($add_piece_url, $data['id']) }}">Ajouter</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm datatable">
                            @foreach ($pieces as $intitule => $id)    
                                <tr>
                                    <th class="text-start">{{ $intitule }}</th>
                                    <td class="text-end"> @include('common._delete_form',['delete_url'=>$delete_service_piece_url,'entityID'=>$id]) </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            @endisset
            
            @isset($demandepieces)
                <div class="card" width="100%">
                    <div class="card-header">
                        <div class="hstack gap-2"> 
                            <h5 class="card-title">Liste des pièces fournies</h5>
                            <a class="btn btn-success ms-auto" href="{{ route($add_demande_piece_url,  $data['id']) }}">Ajouter</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-sm datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Intitule</th>
                                    <th>Nom du fichier</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($demandepieces as $row)
                                    <tr> 
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $row->piece()->first()->intitule }}</td>
                                        <td>{{ $row->nom_fichier }}</td>
                                        <td class="text-end">
                                            <div class="hstack gap-2">
                                                <a class="btn btn-sm btn-secondary" href="{{ route($show_demande_piece_url, $row->id) }}"><i class="ri-eye-fill">Voir</i></a>
                                                <a  class="btn btn-sm btn-primary" href="{{ route($edit_demande_piece_url, $row->id) }}"><i class="ri-edit-2-line">Editer</i></a>
                                                @include('common._delete_form',['delete_url'=>$delete_demande_piece_url, 'entityID'=>$row->id])
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endisset
        </div>
    </div>
</x-app-layout>
