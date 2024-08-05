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
        <div class="bg-image" style="background-image: url({{ asset('media/various/bg_dashboard.jpg') }});">
            <div class="bg-primary-dark-op">
              <div class="content content-full">
                <div class="row my-3">
                  <div class="col-md-6 d-md-flex align-items-md-center">
                    <div class="py-4 py-md-0 text-center text-md-start">
                      <h1 class="fs-2 text-white mb-2">Dashboard</h1>
                      <h2 class="fs-lg fw-normal text-white-75 mb-0">Gestion des ventes</h2>
                    </div>
                  </div>
                  <div class="col-md-6 d-md-flex align-items-md-center">
                    <div class="row w-100 text-center">
                      <div class="col-4 col-lg-4 col-xl-4 text-end">
                        <p class="fs-3 fw-semibold text-white mb-0">
                            {{ number_format($totalContractSalesToday, 2, ',','.') }}
                        </p>
                        <p class="fs-sm fw-semibold text-white-75 text-uppercase mb-0">
                          <i class="far fa-chart-bar opacity-75 me-1"></i> Fitness
                        </p>
                      </div>
                      <div class="col-4 col-lg-4 col-xl-4 text-end">
                        <p class="fs-3 fw-semibold text-white mb-0">
                            {{ number_format($totalSalesToday, 2, ',','.') }}
                        </p>
                        <p class="fs-sm fw-semibold text-white-75 text-uppercase mb-0">
                          <i class="far fa-chart-bar opacity-75 me-1"></i> Boutique
                        </p>
                      </div>

                      <div class="col-4 col-lg-4 col-xl-4 text-end">
                        <p class="fs-3 fw-semibold text-white mb-0">
                          860
                        </p>
                        <p class="fs-sm fw-semibold text-white-75 text-uppercase mb-0">
                          <i class="far fa-chart-bar opacity-75 me-1"></i> Visites
                        </p>
                      </div>
                    </div>
                  </div>
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

        <div class="row items-push">
            <div class="col-xl-6">
                <div class="block block-rounded block-mode-loading-refresh h-100 mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Vendre des contrats d'abonnement</h3>
                        <div class="block-options">
                            <a href="{{ route('dashboard') }}" class="btn-block-option">
                                <i class="si si-refresh"></i>
                            </a>
                            <button type="button" class="btn-block-option" data-bs-toggle="modal" data-bs-target="#modal-new-contract-sale">
                                <i class="si si-bag"></i>
                            </button>
                            <button type="button" class="btn-block-option" data-bs-toggle="modal" data-bs-target="#modal-new-customer">
                                <i class="si si-user-follow"></i>
                            </button>
                        </div>
                    </div>

                    <div class="block-content block-content-full block-content-sm bg-body-dark">
                        <form action="{{ route('dashboard') }}" method="GET">
                            <input type="text" class="form-control form-control-alt" name="shop_contracts_sales_serach" value="{{ request()->query('search') }}" placeholder="Rechercher une vente..">
                        </form>
                    </div>

                    <div class="modal" id="modal-new-contract-sale" tabindex="-1" role="dialog" aria-labelledby="modal-new-contract-sale" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="block block-rounded block-themed block-transparent mb-0">
                                    <div class="block-header bg-warning">
                                        <h3 class="block-title">Vendre un abonnement</h3>
                                        <div class="block-options">
                                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                                <i class="fa fa-fw fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="block-content">
                                        <form method="POST" action="{{ route('contracts_sales.store') }}" onsubmit="return confirm('Confirmez la ventre d\'un abonnement ?');">
                                            @csrf
                                            <div class="mb-4">
                                                <label class="form-label" for="customer">Client</label>
                                                <select class="form-select" id="customer" name="customer_id" required>
                                                    <option>Sélectionnez un Client</option>
                                                    @if($customers)
                                                        @foreach($customers as $customer)
                                                            <option value="{{ $customer->id }}">
                                                                {{ $customer->fullname }} &bullet; {{ $customer->phoneNumber }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label" for="contract">Contrats</label>
                                                <select class="form-select" id="contract" name="contract_id" required>
                                                    <option>Sélectionnez un contrat d'abonnement</option>
                                                    @if($contracts)
                                                        @foreach($contracts as $contract)
                                                            <option value="{{ $contract->id }}">
                                                                {{ $contract->contract_name }} &bullet; {{ $contract->fitnessCenter->name }} &bullet; {{ $contract->contract_price }} Fcfa
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <x-input-error :messages="$errors->get('contract_id')" class="mt-2" />
                                            </div>
                                        
                                            <div class="mb-4">
                                                <label class="form-label" for="sale-quantity">Stock à ajouter</label>
                                                <input type="number" min="0" step="1" value="1" class="form-control" id="sale-quantity" name="quantity_sold" required>
                                                <x-input-error :messages="$errors->get('quantity_sold')" class="mt-2" />
                                            </div>
                                            
                                            <div class="mb-4">
                                                <button type="submit" class="btn btn-sm btn-primary">Vendre un produit</button>
                                                <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Annuler</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="block-content">
                        <table class="table table-striped table-hover table-borderless table-vcenter fs-sm">
                            <thead>
                                <tr class="text-uppercase">
                                    <th class="fw-bold">Client</th>
                                    <th class="d-none d-sm-table-cell fw-bold">Vendeur</th>
                                    <th class="d-none d-sm-table-cell fw-bold text-end" style="width: 120px;">Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($contractSales) > 0)
                                    @foreach($contractSales as $contractSale)
                                        <tr>
                                            <td>
                                                <div class="fw-semibold fs-base">{{ $contractSale->user_name }}</div>
                                                <div class="text-muted"><span class="badge bg-success">{{ $contractSale->contract->contract_name }}</span></div>
                                            </td>
                                            <td class="d-none d-sm-table-cell fs-sm text-muted">
                                                {{$contractSale->user_name}}
                                            </td>
                                            <td class="d-none d-sm-table-cell text-end">
                                                <b>{{ $contractSale->total_amount }}</b> Fcfa 
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <p class="fst-italic">Aucun abonnement ce jour</p>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-xl-6">
                <div class="block block-rounded block-mode-loading-refresh h-100 mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Ventes des produits</h3>
                        <div class="block-options">
                            <a href="{{ route('dashboard') }}" class="btn-block-option">
                                <i class="si si-refresh"></i>
                            </a>
                            <button type="button" class="btn-block-option" data-bs-toggle="modal" data-bs-target="#modal-new-product-sale">
                                <i class="si si-handbag"></i>
                            </button>
                            <button type="button" class="btn-block-option" data-bs-toggle="modal" data-bs-target="#modal-new-customer">
                                <i class="si si-user-follow"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full block-content-sm bg-body-dark">
                        <form action="{{ route('dashboard') }}" method="GET">
                            <input type="text" class="form-control form-control-alt" name="shop_sales_serach" value="{{ request()->query('search') }}" placeholder="Rechercher une vente..">
                        </form>
                    </div>

                    <div class="modal" id="modal-new-product-sale" tabindex="-1" role="dialog" aria-labelledby="modal-new-product-sale" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="block block-rounded block-themed block-transparent mb-0">
                                    <div class="block-header bg-primary-dark">
                                        <h3 class="block-title">Vendre un produit</h3>
                                        <div class="block-options">
                                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                                <i class="fa fa-fw fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="block-content">
                                        <form action="{{ route('product_sales.store') }}" onsubmit="return confirm('Confirmez la ventre d\'un produit ?');" method="POST">
                                            @csrf
                                            <div class="mb-4">
                                                <label class="form-label" for="customer">Client acheteur</label>
                                                <select class="form-select" id="customer" name="customer_id" required>
                                                    <option>Sélectionnez un Client</option>
                                                    @if($customers)
                                                        @foreach($customers as $customer)
                                                            <option value="{{ $customer->id }}">
                                                                {{ $customer->fullname }} &bullet; {{ $customer->phoneNumber }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label" for="product">Produits</label>
                                                <select class="form-select" id="product" name="product_id" required>
                                                    <option>Sélectionnez une produit</option>
                                                    @if($products)
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}">
                                                                {{ $product->product_name }} &bullet; {{ $product->fitnessCenter->name }} &bullet; {{ $product->product_price }} Fcfa
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                                            </div>
                                        
                                            <div class="mb-4">
                                                <label class="form-label" for="sale-quantity">Stock à ajouter</label>
                                                <input type="number" min="0" step="1" value="1" class="form-control" id="sale-quantity" name="quantity_sold" required>
                                                <x-input-error :messages="$errors->get('quantity_sold')" class="mt-2" />
                                            </div>
                                            
                                            <div class="mb-4">
                                                <button type="submit" class="btn btn-sm btn-primary">Vendre un produit</button>
                                                <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Annuler</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="block-content">
                        <table class="table table-striped table-hover table-borderless table-vcenter fs-sm">
                            <thead>
                                <tr class="text-uppercase">
                                    <th class="fw-bold">Produit</th>
                                    <th class="d-none d-sm-table-cell fw-bold">Vendeur</th>
                                    <th class="fw-bold">Qtité</th>
                                    <th class="d-none d-sm-table-cell fw-bold text-end" style="width: 120px;">Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($sales) > 0)
                                    @foreach($sales as $sale)
                                        <tr>
                                            <td>
                                                <span class="fw-semibold">{{ $sale->product->product_name}}</span>
                                            </td>
                                            <td class="d-none d-sm-table-cell">
                                                <span class="fs-sm text-muted">
                                                    {{ $sale->user_name }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-semibold text-warning">{{ $sale->quantity_sold}}</span>
                                            </td>
                                            <td class="d-none d-sm-table-cell text-end">
                                                <b>{{ $sale->total_amount }}</b> Fcfa 
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <p class="fst-italic">Aucune vente ce jour</p>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-new-customer" tabindex="-1" role="dialog" aria-labelledby="modal-new-customer" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-themed block-transparent mb-0">
                    <div class="block-header bg-secondary">
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