<x-layout>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Liste des produits</h1>

                <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#modal-new-product">
                    <i class="fa fa-fw fa-plus me-1"></i> Ajouter un produit
                </button>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-new-product" tabindex="-1" role="dialog" aria-labelledby="modal-new-product" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Ajouter un produit</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <form action="{{ route('products.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label" for="product-name">Nom du produit</label>
                                <input type="text" value="{{ old('product_name') }}" class="form-control" id="product-name" name="product_name" required autofocus>
                                <x-input-error :messages="$errors->get('product_name')" class="mt-2" />
                            </div>
                        
                            <div class="mb-4">
                                <label class="form-label" for="product-price">Prix du produit</label>
                                <input type="number" min="0" step="5" value="{{ old('product_price') }}" class="form-control" id="product-price" name="product_price" required>
                                <x-input-error :messages="$errors->get('product_price')" class="mt-2" />
                            </div>
                        
                            {{-- <div class="mb-4">
                                <label class="form-label" for="product-stock">Stock du produit</label>
                                <input type="number" min="0" step="5" value="{{ old('product_stock') }}" class="form-control" id="product-stock" name="product_stock">
                                <x-input-error :messages="$errors->get('product_stock')" class="mt-2" />
                            </div> --}}
                            
                            
                            <div class="mb-4">
                                <label class="form-label" for="product-category">Catégorie du produit</label>
                                <select class="form-select" id="product-category" name="product_category_id" required>
                                    <option value="">Sélectionnez une catégorie</option>
                                    @foreach($productCategories as $category)
                                        <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('product_category_id')" class="mt-2" />
                            </div>
                            
                            @if($centers)
                                <div class="mb-4">
                                    <div class="form-floating mb-4">
                                        <select class="form-select" id="fitness-home" name="fitness_center_id" aria-label="Affecter à un centre" required>
                                        <option>Selectionnez un centre</option>
                                            @foreach($centers as $center)
                                                <option value="{{ $center->id }}">
                                                    {{ $center->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label class="form-label" for="fitness-home">Affecter un centre</label>
                                    </div>
                                    <x-input-error :messages="$errors->get('fitness_center_id')" class="mt-2" />
                                </div>
                            @endif

                            <div class="mb-4">
                                <label class="form-label" for="product-description">Description du produit</label>
                                <textarea class="form-control" id="product-description" name="product_description" rows="4" required>{{ old('product_description') }}</textarea>
                                <x-input-error :messages="$errors->get('product_description')" class="mt-2" />
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
                <h3 class="block-title">Tous les produits ({{ count($products) }})</h3>
                {{-- <div class="block-options">
                    <div class="dropdown">
                        <button type="button" class="btn btn-alt-secondary" id="dropdown-ecom-filters" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Filters <i class="fa fa-angle-down ms-1"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-ecom-filters">
                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                New
                                <span class="badge bg-success rounded-pill">260</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                            Out of Stock
                                <span class="badge bg-danger rounded-pill">63</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                All
                                <span class="badge bg-black-50 rounded-pill">36k</span>
                            </a>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="block-content bg-body-dark">
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="input-group mb-4">
                        <input type="text" class="form-control form-control-alt" id="products-search" name="search" placeholder="Rechercher des produits..">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary ms-2">Réinitialiser</a>
                    </div>
                </form>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th style="width: 100px;">ID</th>
                                <th class="d-none d-md-table-cell">Produit</th>
                                <th>Stock</th>
                                <th class="d-none d-sm-table-cell">Prix</th>
                                <th class="d-none d-sm-table-cell">Cat/Cen</th>
                                <th class="d-none d-sm-table-cell">Ajouté</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($products) > 0)
                                @foreach($products as $product)
                                    <tr>
                                        <td class="fs-sm">
                                            <a class="fw-semibold" data-bs-toggle="modal" data-bs-target="#modal-{{ $product->id }}">
                                            <strong>{{$product->id}}</strong>
                                            </a>
                                        </td>
                                        <td class="d-none d-md-table-cell fs-sm">
                                            <a class="fw-semibold" data-bs-toggle="modal" data-bs-target="#modal-{{ $product->id }}">{{$product->product_name}}</a>
                                        </td>
                                        <td>
                                            @if($product->product_stock >= 0 && $product->product_stock < 10)
                                                <span class="badge bg-danger">{{ $product->product_stock }}</span>
                                            @else
                                                <span class="badge bg-success">{{ $product->product_stock }}</span>
                                            @endif
                                        </td>
                                        <td class="d-none d-sm-table-cell fs-sm">
                                            <strong>{{ number_format($product->product_price, 2, ',','.') }} Fcfa</strong>
                                        </td>
                                        <td class="d-none d-sm-table-cell fs-sm"><strong>{{ $product->category ? $product->category->category_name : 'N/A' }} &bull; {{ $product->fitnessCenter ? $product->fitnessCenter->name : 'N/A' }}</strong></td>
                                        <td class="d-none d-sm-table-cell fs-sm">le {{ \Carbon\Carbon::parse($product->created_at)->translatedFormat('d-m-Y à H:i')  }}</td>
                                        <td class="text-center fs-sm d-flex">
                                            <a class="btn btn-sm btn-alt-secondary mx-1" data-bs-toggle="modal" data-bs-target="#modal-{{ $product->id }}">
                                            <i class="fa fa-fw fa-edit"></i>
                                            </a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-alt-secondary text-danger mx-1"><i class="fa fa-fw fa-times"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <div class="modal" id="modal-{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-{{ $product->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="block block-rounded block-themed block-transparent mb-0">
                                                    <div class="block-header bg-primary-dark">
                                                        <h3 class="block-title">Modifier le produit {{ $product->id }}</h3>
                                                        <div class="block-options">
                                                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="fa fa-fw fa-times"></i>
                                                        </button>
                                                        </div>
                                                    </div>
                                                    <div class="block-content">
                                                        <form action="{{ route('products.update', $product->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-4">
                                                                <label class="form-label" for="product-name">Nom du produit</label>
                                                                <input type="text" value="{{ $product->product_name }}" class="form-control" id="product-name" name="product_name" required autofocus>
                                                                <x-input-error :messages="$errors->get('product_name')" class="mt-2" />
                                                            </div>
                                                        
                                                            <div class="mb-4">
                                                                <label class="form-label" for="product-price">Prix du produit</label>
                                                                <input type="number" min="0" step="5" value="{{ $product->product_price }}" class="form-control" id="product-price" name="product_price" required>
                                                                <x-input-error :messages="$errors->get('product_price')" class="mt-2" />
                                                            </div>
                                                        
                                                            {{-- <div class="mb-4">
                                                                <label class="form-label" for="product-stock">Stock du produit</label>
                                                                <input type="number" min="0" step="5" value="{{ old('product_stock') }}" class="form-control" id="product-stock" name="product_stock">
                                                                <x-input-error :messages="$errors->get('product_stock')" class="mt-2" />
                                                            </div> --}}
                                                            
                                                            <div class="mb-4">
                                                                <label class="form-label" for="product-category">Catégorie du produit</label>
                                                                <select class="form-select" id="product-category" name="product_category_id" required>
                                                                    <option value="">Sélectionnez une catégorie</option>
                                                                    @foreach($productCategories as $category)
                                                                        <option value="{{ $category->id }}" 
                                                                            {{ $category->id == $product->product_category_id ? 'selected' : '' }}>
                                                                            {{ $category->category_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <x-input-error :messages="$errors->get('product_category_id')" class="mt-2" />
                                                            </div>
                                                            
                                                            @if($centers)
                                                                <div class="mb-4">
                                                                    <div class="form-floating mb-4">
                                                                        <select class="form-select" id="fitness-home" name="fitness_center_id" aria-label="Affecter à un centre" required>
                                                                        <option>Selectionnez un centre</option>
                                                                            @foreach($centers as $center)
                                                                                <option value="{{ $center->id }}"
                                                                                    {{ $center->id == $product->fitness_center_id ? 'selected' : '' }}>
                                                                                    {{ $center->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <label class="form-label" for="fitness-home">Affecter un centre</label>
                                                                    </div>
                                                                    <x-input-error :messages="$errors->get('fitness_center_id')" class="mt-2" />
                                                                </div>
                                                            @endif
                                
                                                            <div class="mb-4">
                                                                <label class="form-label" for="product-description">Description du produit</label>
                                                                <textarea class="form-control" id="product-description" name="product_description" rows="4" required>{{ $product->product_description }}</textarea>
                                                                <x-input-error :messages="$errors->get('product_description')" class="mt-2" />
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
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <nav aria-label="Photos Search Navigation">
                    {{ $products->links('vendor.pagination.bootstrap-5') }}
                </nav>
            </div>
          </div>
    </div>

</x-layout>