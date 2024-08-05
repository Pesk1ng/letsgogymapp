<x-layout>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Stock de produits</h1>

                <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#modal-new-stock">
                    <i class="fa fa-fw fa-plus me-1"></i> Ajouter un stock
                </button>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-new-stock" tabindex="-1" role="dialog" aria-labelledby="modal-new-stock" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Ajouter un stock</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <form action="{{ route('stocks.store') }}" onsubmit="return confirm('Êtes-vous sûr de vouloir ajouté du stock pour ce produit ?');" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label" for="product-category">Produits</label>
                                <select class="form-select" id="products" name="product_id" required>
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
                                <label class="form-label" for="stock-quantity">Stock à ajouter</label>
                                <input type="number" min="0" step="5" value="{{ old('quantity') }}" class="form-control" id="stock-quantity" name="quantity" required>
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>
                            
                            <div class="mb-4">
                                <button type="submit" class="btn btn-sm btn-primary">Ajouter un produit</button>
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
            </div>
        </div>

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Tous les stocks ({{ count($stocks) }})</h3>
            </div>
            <div class="block-content bg-body-dark">
                <form action="{{ route('stocks.index') }}" method="GET">
                    <div class="input-group mb-4">
                        <input type="text" class="form-control form-control-alt" id="products-search" name="search" placeholder="Rechercher des stocks de produit..">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                        <a href="{{ route('stocks.index') }}" class="btn btn-secondary ms-2">Réinitialiser</a>
                    </div>
                </form>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th style="width: 100px;">ID</th>
                                <th>Stock ajouté</th>
                                <th class="d-none d-md-table-cell">Produit</th>
                                <th class="d-none d-sm-table-cell">Ajouté</th>
                                <th class="d-none d-sm-table-cell">Par/Cen</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($stocks) > 0)
                                @foreach($stocks as $stock)
                                    <tr>
                                        <td class="fs-sm">
                                            <a class="fw-semibold" data-bs-toggle="modal" data-bs-target="#modal-{{ $stock->id }}">
                                            <strong>{{ $stock->id }}</strong>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $stock->quantity }}</span>
                                        </td>
                                        <td class="d-none d-md-table-cell fs-sm">
                                            <a class="fw-semibold" data-bs-toggle="modal" data-bs-target="#modal-{{ $stock->id }}">{{ $stock->product->product_name }}</a>
                                        </td>
                                        <td class="d-none d-sm-table-cell fs-sm">le {{ \Carbon\Carbon::parse($stock->created_at)->translatedFormat('d-m-Y à H:i')  }}</td>

                                        <td class="d-none d-sm-table-cell fs-sm"><strong>{{ $stock->user->fullname }} &bull; {{ $product->fitnessCenter ? $stock->fitnessCenter->name : 'N/A' }}</strong></td>
                                        
                                        <td class="text-center fs-sm d-flex">
                                            <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce stock ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-alt-secondary text-danger mx-1"><i class="fa fa-fw fa-times"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <p><i>Aucun stock ajouté dernièrement</i></p>
                            @endif
                        </tbody>
                    </table>
                </div>

                <nav aria-label="Photos Search Navigation">
                    {{ $stocks->links('vendor.pagination.bootstrap-5') }}
                </nav>
            </div>
          </div>
    </div>

</x-layout>