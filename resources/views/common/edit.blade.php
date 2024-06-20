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
                    <h1>{{$title}}</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route($post_url, $entityID) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        @include('common._form')

                        <div class="d-flex justify-content-right">
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
