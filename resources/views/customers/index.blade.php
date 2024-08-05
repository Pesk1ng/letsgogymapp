<x-layout>
    @if ($phone_input_exists)
        @section('css')
            <!-- Page JS Plugins CSS -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
            <style>
                .iti{
                    display: block !important;
                }

                .iti .iti__flag-container {
                    margin-right: 20% !important;
                }

                .getwaocard-form .form-group input[type="tel"]{
                    padding-left: 100px !important;
                }
            </style>
        @endsection

        @section('js')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
        @endsection
    @endif

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Clients</h1>

                <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#modal-new-customer">
                    <i class="fa fa-fw fa-plus me-1"></i> Nouveau client
                </button>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-new-customer" tabindex="-1" role="dialog" aria-labelledby="modal-new-customer" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Nouveau client</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <form action="{{ route('customers.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label" for="tag-customer-name">Nom complet du client</label>
                                <input type="text" value="{{ old('fullname') }}" class="form-control" id="tag-customer-name" name="fullname" required autofocus>
                                <x-input-error :messages="$errors->get('fullname')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="phone">Numéro de téléphone</label>
                                <input type="tel" value="{{ old('phoneNumber') }}" class="form-control" id="phone" name="phone" required>
                                <x-input-error :messages="$errors->get('phoneNumber')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="tag-customer-email">Adresse email</label>
                                <input type="email" value="{{ old('email') }}" class="form-control" id="tag-customer-email" name="email">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            
                            <div class="mb-4">
                                <button type="submit" class="btn btn-sm btn-primary">Ajouter un client</button>
                                <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row mb-3">
            <div class="col-md-12 m-auto">
                @session('message')
                    <x-alert type="success" :message="session('message')"/>
                @endsession
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {!! session('error') !!}
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <h2 class="content-heading">   
                <span class="fw-bolder">{{ $customers->count() }} </span>
                Utilisateurs
            </h2>
            <div class="col-12 mb-3">
                <form action="{{ route('customers.index') }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search" placeholder="Rechercher un client..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary ms-2">Réinitialiser</a>
                    </div>
                </form>
            </div>

            @if (count($customers) > 0)
                @foreach ($customers as $customer)

                    <div class="col-md-6 col-xl-3">
                        <a class="block block-rounded block-link-pop" role="button" data-bs-toggle="modal" data-bs-target="#modal-block-tabs" title="cliquez pour voir {{ $customer->fullname }}">
                            <div class="block-content block-content-full d-flex flex-row-reverse align-items-center justify-content-between">
                                <img class="img-avatar img-avatar48 img-avatar-thumb" @if($customer->avatar !== null) src="{{ $customer->avatar }}" @else src="{{asset('media/avatars/avatar16.jpg')}}" @endif  alt="">
                                <div class="me-3">
                                <p class="fw-semibold mb-0">{{ \App\Helpers\StringHelper::truncate($customer->fullname, 14) }}
                                </p>
                                <p class="fs-sm text-muted mb-0">
                                    {{ $customer->phoneNumber }}
                                </p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="modal" id="modal-block-tabs" tabindex="-1" role="dialog" aria-labelledby="modal-block-tabs" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="block block-transparent bg-white mb-0">
                                    <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                                        <li class="nav-item">
                                        <button class="nav-link active" id="btabs-static-home-tab" data-bs-toggle="tab" data-bs-target="#btabs-static-home" role="tab" aria-controls="btabs-static-home" aria-selected="true">
                                            Profil
                                        </button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link" id="btabs-static-profile-tab" data-bs-toggle="tab" data-bs-target="#btabs-static-profile" role="tab" aria-controls="btabs-static-profile" aria-selected="false">
                                                Activités
                                            </button>
                                        </li>
                                        <li class="nav-item ms-auto">
                                            <button class="nav-link" id="btabs-static-settings-tab" data-bs-toggle="tab" data-bs-target="#btabs-static-settings" role="tab" aria-controls="btabs-static-settings" aria-selected="false">
                                                <i class="si si-note"></i>
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="block-content tab-content">
                                        <div class="tab-pane active" id="btabs-static-home" role="tabpanel" aria-labelledby="btabs-static-home-tab" tabindex="0">
                                            <div class="bg-light mb-3 rounded">
                                                <div class="content content-full ribbon ribbon-bookmark ribbon-success">

                                                    <div class="ribbon-box">
                                                        <i class="fa fa-user-check"></i>
                                                    </div>

                                                  <div class="text-center">
                                                    <a class="img-link" href="be_pages_generic_profile.html">
                                                      <img class="img-avatar shadow-lg img-avatar96 img-avatar-thumb" @if($customer->avatar !== null) src="{{ $customer->avatar }}" @else src="{{asset('media/avatars/avatar16.jpg')}}" @endif alt="">
                                                    </a>
                                                    <h1 class="fw-bold my-2 text-black">{{ $customer->fullname }}</h1>
                                                    <h2 class="h4 fw-bold text-black-75 mb-1">
                                                        {{ $customer->phoneNumber }} <br>
                                                        <a class="text-primary-lighter" href="javascript:void(0)">{{ $customer->fitness_home }}</a>
                                                    </h2>
                                                    <p>
                                                        <i><span><small>Ajouté le </small> {{ \Carbon\Carbon::parse($customer->created_at)->translatedFormat('d F Y à H:i') }}</span></i>
                                                        <br>
                                                            <small class="text-muted">par {{ $customer->customer_creator_name }}</small>
                                                            <br>
                                                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce profil ?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">Delete <i class="si si-ban"></i></button>
                                                            </form>
                                                    </p>
                                                  </div>
                                                </div>
                                              </div>
                                        </div>
                                        <div class="tab-pane" id="btabs-static-profile" role="tabpanel" aria-labelledby="btabs-static-profile-tab" tabindex="0">
                                            <h4 class="fw-normal">Récentes activités</h4>
                                            <p>0 activité</p>
                                        </div>
                                        <div class="tab-pane" id="btabs-static-settings" role="tabpanel" aria-labelledby="btabs-static-settings-tab" tabindex="0">
                                            <h4 class="fw-normal">Modifier le profil</h4>
                                            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                    
                                                <div class="mb-4">
                                                    <label class="form-label" for="tag-customer-name">Nom complet du client</label>
                                                    <input type="text" value="{{ $customer->fullname }}" class="form-control" id="tag-customer-name" name="fullname" required autofocus>
                                                    <x-input-error :messages="$errors->get('fullname')" class="mt-2" />
                                                </div>
                    
                                                <div class="mb-4">
                                                    <label class="form-label" for="phone">Numéro de téléphone</label>
                                                    <input type="tel" value="{{ $customer->phoneNumber }}" class="form-control" id="phone" name="phoneNumber" required>
                                                    <x-input-error :messages="$errors->get('phoneNumber')" class="mt-2" />
                                                </div>
                    
                                                <div class="mb-4">
                                                    <label class="form-label" for="tag-customer-email">Adresse email</label>
                                                    <input type="email" value="{{ $customer->email }}" class="form-control" id="tag-customer-email" name="email">
                                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                                </div>
                    
                    
                                                {{-- <div class="mb-4">
                                                    <div class="form-floating mb-4">
                                                        <select class="form-select" id="fitness-home" name="fitness_home" aria-label="Affecter à un centre" required>
                                                        <option>Selectionnez un centre</option>
                                                            @if ($fitnessHomes)
                                                                @foreach($fitnessHomes as $center)
                                                                    <option value="{{ $center->fitness_home }}">
                                                                        {{ $center->fitness_home }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <label class="form-label" for="fitness-home">Affecter un centre</label>
                                                    </div>
                                                </div> --}}
                                                
                                                <div class="mb-4">
                                                    <button type="submit" class="btn btn-sm btn-primary">Mettre à jour un client</button>
                                                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Annuler</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="block-content block-content-full text-end bg-body">
                                        <button type="button" class="btn btn-sm btn-alt-secondary mx-1" data-bs-dismiss="modal"><i class="fa fa-times"></i> Quitter</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-md-6 col-xl-3">
                        <a class="block block-rounded bg-gd-sublime" href="javascript:void(0)">
                        <div class="block-content block-content-full d-flex flex-row-reverse align-items-center justify-content-between">
                            <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{asset('media/avatars/avatar16.jpg')}}" alt="">
                            <div class="me-3">
                            <p class="fw-semibold text-white mb-0">Scott Young</p>
                            <p class="fs-sm text-white-75 mb-0">
                                Web Developer
                            </p>
                            </div>
                        </div>
                        </a>
                    </div> --}}
                @endforeach
            @else
                <p><i>Aucun client disponible</i></p>
            @endif
            
            <nav aria-label="Photos Search Navigation">
                {{ $customers->links('vendor.pagination.bootstrap-5') }}
            </nav>
        </div>
    </div>

    @if ($phone_input_exists)
        @section('jsbtm')
            <script type="text/javascript">
                const phoneInputField = document.querySelector("#phone");
                const phoneInput = window.intlTelInput(phoneInputField, {
                    utilsScript:
                    "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                    autoInsertDialCode: false,
                    separateDialCode:true,
                    initialCountry: "bj",
                    nationalMode:true,
                    hiddenInput:"phoneNumber",
                });
            </script>
        @endsection
    @endif
</x-layout>