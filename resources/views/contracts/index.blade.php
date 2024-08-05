<x-layout>
    @if ($datatable_exist)
        @section('css')
            <!-- Page JS Plugins CSS -->
            <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
            <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
        @endsection

        @section('js')
            <!-- jQuery (required for DataTables plugin) -->
            <script src="{{ asset('js/lib/jquery.min.js') }}"></script>

            <!-- Page JS Plugins -->
            <script src="{{ asset('js/plugins/datatables/dataTables.js') }}"></script>
            <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
            <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.js') }}"></script>
            <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
            <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
            <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
            <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
            <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.js') }}"></script>
            <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

            <!-- Page JS Code -->
            @vite(['resources/js/pages/datatables.js'])
        @endsection
    @endif


    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Contracts</h1>

                <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#modal-new-contract">
                    <i class="fa fa-fw fa-plus me-1"></i> Nouveau contract
                </button>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-new-contract" tabindex="-1" role="dialog" aria-labelledby="modal-new-contract" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Nouveau contract</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <form action="{{ route('contracts.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label" for="tag-contact-name">Nom du contrat</label>
                                <input type="text" value="{{ old('contract_name') }}" class="form-control" id="tag-contact-name" name="contract_name" required autofocus>
                                <x-input-error :messages="$errors->get('contract_name')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="tag-contact-duration">Durée du contrat <small>(en jours)</small></label>
                                <input type="number" min="1" value="{{ old('contract_duration') }}" class="form-control" id="tag-contact-duration" name="contract_duration" required>
                                <x-input-error :messages="$errors->get('contract_duration')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="tag-contact-amount">Montant du contrat</label>
                                <input type="number" min="500" step="500" value="{{ old('contract_amount') }}" class="form-control" id="tag-contact-amount" name="contract_amount" required>
                                <x-input-error :messages="$errors->get('contract_amount')" class="mt-2" />
                            </div>

                            @if(in_array(Auth::user()->role, ['admin', 'superadmin']))
                                <div class="mb-4">
                                    <div class="form-floating mb-4">
                                        <select class="form-select" id="fitness-home" name="fitness_center_id" aria-label="Affecter à un centre" required>
                                        <option>Selectionnez un centre</option>
                                            @if ($centers)
                                                @foreach($centers as $center)
                                                    <option value="{{ $center->id }}">
                                                        {{ $center->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <label class="form-label" for="fitness-home">Affecter un centre</label>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="mb-4">
                                <button type="submit" class="btn btn-sm btn-primary">Créer un contract</button>
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
                    <h3 class="block-title">
                        <span class="fw-bolder">{{ $contracts->count() }}</span> Contrats disponbles
                    </h3>
                </div>
                <div class="block-content block-content-full overflow-x-auto">
                    <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 80px;">Code</th>
                                <th class="d-none d-sm-table-cell" style="width: 25%;">Contrats</th>
                                <th class="d-none d-sm-table-cell">Centre</th>
                                <th class="d-none d-sm-table-cell">Durée</th>
                                <th>Montant </th>
                                <th class="d-none d-sm-table-cell">Créé par</th>
                                <th class="d-none d-sm-table-cell">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($contracts)
                                @foreach ($contracts as $contract)
                                    <tr>
                                        <td>{{ $contract->id }}</td>
                                        <td class="fw-semibold">
                                            <a type="button" class="btn text-primary" data-bs-toggle="modal" data-bs-target="#modal-{{ $contract->id }}">{{ $contract->contract_name }}</a>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <span class="badge bg-primary"><small>{{ $contract->fitnessCenter->name }}</small></span>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <b>{{ $contract->contract_duration }}</b> <small>Jours</small>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <b>{{ number_format($contract->contract_amount, 2, ',','.') }}</b> <small>Fcfa</small>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <span class="text-muted fst-italic"><small>{{ $contract->contract_creator_name }}</small></span>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" data-bs-toggle="modal" data-bs-target="#modal-{{ $contract->id }}">
                                                  <i class="fa fa-pencil-alt"></i>
                                                </button>
                                                <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')" type="submit"><i class="fa fa-fw fa-times text-body-color-dark"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <div class="modal" id="modal-{{ $contract->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-{{ $contract->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="block block-rounded block-themed block-transparent mb-0">
                                                    <div class="block-header bg-primary-dark">
                                                        <h3 class="block-title">Modifier le contrat <u>{{ $contract->contract_code }}</u></h3>
                                                        <div class="block-options">
                                                        <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="fa fa-fw fa-times"></i>
                                                        </button>
                                                        </div>
                                                    </div>
                                                    <div class="block-content">
                                                        <form action="{{ route('contracts.update', $contract->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            
                                                            <div class="mb-4">
                                                                <label class="form-label" for="tag-contact-name">Nom du contrat</label>
                                                                <input type="text" value="{{ $contract->contract_name }}" class="form-control" id="tag-contact-name" name="contract_name" required autofocus>
                                                                <x-input-error :messages="$errors->get('contract_name')" class="mt-2" />
                                                            </div>
                                
                                                            <div class="mb-4">
                                                                <label class="form-label" for="tag-contact-duration">Durée du contrat <small>(en jours)</small></label>
                                                                <input type="number" min="1" value="{{ $contract->contract_duration }}" class="form-control" id="tag-contact-duration" name="contract_duration" required>
                                                                <x-input-error :messages="$errors->get('contract_duration')" class="mt-2" />
                                                            </div>
                                
                                                            <div class="mb-4">
                                                                <label class="form-label" for="tag-contact-amount">Montant du contrat</label>
                                                                <input type="number" min="500" step="500" value="{{ $contract->contract_amount }}" class="form-control" id="tag-contact-amount" name="contract_amount" required>
                                                                <x-input-error :messages="$errors->get('contract_amount')" class="mt-2" />
                                                            </div>                                                            
                                                            
                                                            <div class="mb-4">
                                                                <button type="submit" class="btn btn-sm btn-alt-primary">Mettre à jour</button>
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
            </div>
        </div>
    </div>
</x-layout>