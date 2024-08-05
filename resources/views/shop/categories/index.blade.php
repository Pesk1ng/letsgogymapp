<x-layout>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Catégories de produits</h1>

                <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#modal-new-category">
                    <i class="fa fa-fw fa-plus me-1"></i> Ajouter une catégorie
                </button>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-new-category" tabindex="-1" role="dialog" aria-labelledby="modal-new-category" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Ajouter une catégorie</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label" for="tag-category-name">Nom de la catégorie</label>
                                <input type="text" value="{{ old('category_name') }}" class="form-control" id="tag-category-name" name="category_name" required autofocus>
                                <x-input-error :messages="$errors->get('category_name')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="tag-categorie-description-short">Petite Description</label>
                                <textarea class="form-control" id="tag-categorie-description-short" name="category_description" rows="4" required>{{ old('category_description') }}</textarea>
                                <x-input-error :messages="$errors->get('category_description')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <button type="submit" class="btn btn-sm btn-primary">Créer une catégorie</button>
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

        <div class="row">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Catégories des produits</h3>
                </div>
                <div class="block-content">
                    <div class="row">
                        @if (count($categories) > 0)
                            @foreach ($categories as $category)
                                <div class="col-md-12 category-item">
                                    <div class="block block-rounded block-bordered block-link-shadow">
                                        <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                            <div class="me-3">
                                                <p class="fs-lg fw-semibold mb-0">
                                                    {{ $category->category_name }}
                                                </p>
                                                <p class="text-muted fs-5 mb-0">
                                                    {{ $category->category_description }}
                                                </p>
                                                <p class="fst-italic text-muted">
                                                    créée par <small><b>{{ $category->customer_creator_name }}</b></small>  (<small><b>{{ $category->fitnessCenter ? $category->fitnessCenter->name : 'N/A' }}</b></small>)
                                                </p>
                                            </div>
                                            <div class="d-flex">
                                                <a href="" class="item item-rounded bg-body-light mx-1" data-bs-toggle="modal" data-bs-target="#modal-{{ $category->id }}">
                                                    <i class="fa fa-edit fa-1x text-primary"></i>
                                                </a>
                                                <form class="item item-rounded bg-body-light mx-1" action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn" type="submit"><i class="fa fa-trash fa-1x text-danger"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal" id="modal-{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-{{ $category->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="block block-rounded block-themed block-transparent mb-0">
                                                <div class="block-header bg-primary-dark">
                                                    <h3 class="block-title">Mettre à jour la catégorie {{ $category->id }}</h3>
                                                    <div class="block-options">
                                                    <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                                        <i class="fa fa-fw fa-times"></i>
                                                    </button>
                                                    </div>
                                                </div>
                                                <div class="block-content">
                                                    <form action="{{ route('categories.update', $category->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-4">
                                                            <label class="form-label" for="tag-category-name">Nom de la catégorie</label>
                                                            <input type="text" value="{{ $category->category_name }}" class="form-control" id="tag-category-name" name="category_name" required autofocus>
                                                            <x-input-error :messages="$errors->get('category_name')" class="mt-2" />
                                                        </div>
                            
                                                        <div class="mb-4">
                                                            <label class="form-label" for="tag-categorie-description-short">Petite Description</label>
                                                            <textarea class="form-control" id="tag-categorie-description-short" name="category_description" rows="4" required>{{ $category->category_description }}</textarea>
                                                            <x-input-error :messages="$errors->get('category_description')" class="mt-2" />
                                                        </div>
                            
                                                        <div class="mb-4">
                                                            <button type="submit" class="btn btn-sm btn-primary">Mettre à jour</button>
                                                            <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p><i>Aucune catégorie disponible</i></p>
                        @endif
                    </div>
                </div>

                <nav aria-label="Photos Search Navigation">
                    {{ $categories->links('vendor.pagination.bootstrap-5') }}
                </nav>
            </div>
        </div>
    </div>

</x-layout>