<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
    
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Services</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <img src="" alt="" width="50px">
                                        </div>
                                        <div class="ps-3 mx-5">
                                            <h6 class="text-center">{{$nbr_service}}</h6>
                                            <span class="text-muted text-center small pt-2 ps-1">au total</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Citoyens</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <img src="#" alt="" width="50px">
                                        </div>
                                        <div class="ps-3 mx-5">
                                            <h6 class="text-center">{{$nbr_citoyen}}</h6>
                                            <span class="text-muted text-center small pt-2 ps-1">au total</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card">
                                <div class="card-body">
                                    <h5 class="card-title">Demandes </h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <img src="#" alt="" width="50px">
                                        </div>
                                        <div class="ps-3 mx-5">
                                            <h6 class="text-center">{{$nbr_demande}}</h6>
                                            <span class="text-muted text-center small pt-2 ps-1">au total</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Actions récentes</span></h5>
            
                            <div class="activity">
                                <div class="activity-item d-flex">
                                    <div class="activite-label">02-05-2024</div>
                                    <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                    <div class="activity-content">
                                    Une demande crée  
                                    </div>
                                </div>
                            </div>
            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
