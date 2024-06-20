<x-app-layout>
    <x-slot name="header">
        <nav class="font-semibold text-xl text-gray-800 leading-tight">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item">{{ $title }}</li>
            </ol>
        </nav>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
            <div class="card" width="100%">
                <div class="card-header">
                    <div class="hstack gap-2"> 
                        <h5 class="card-title">{{$title}}</title></h5>
                        <a class="btn btn-success ms-auto" href="{{ route($new_url) }}">Nouveau</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    @foreach ($cols as $col)    
                                    <th>{{ $col }}</th>
                                    @endforeach
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $row)
                                    <tr> 
                                        <td>{{ $loop->index + 1 }}</td>
                                        @foreach (array_slice($row,1,count($row)) as $col)
                                            <td>{{ $col }}</td>
                                        @endforeach
                                        <td class="text-end">
                                            <div class="hstack gap-2">
                                                <a class="btn btn-sm btn-secondary" href="{{ route($show_url, $row[0]) }}"><i class="ri-eye-fill">Voir</i></a>
                                                <a  class="btn btn-sm btn-primary" href="{{ route($edit_url, $row[0]) }}"><i class="ri-edit-2-line">Editer</i></a>
                                                @include('common._delete_form',['entityID'=>$row[0]])
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
