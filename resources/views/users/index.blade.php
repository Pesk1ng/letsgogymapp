<x-layout>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Utilisateurs</h1>

                <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#modal-new-user">
                    <i class="fa fa-fw fa-plus me-1"></i> Nouvel Utilisateur
                </button>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-new-user" tabindex="-1" role="dialog" aria-labelledby="modal-new-user" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Nouvel utilisateur</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label" for="tag-user-name">Nom de l'utilisateur</label>
                                <input type="text" value="{{ old('fullname') }}" class="form-control" id="tag-user-name" name="fullname" required autofocus>
                                <x-input-error :messages="$errors->get('fullname')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="tag-user-email">Adresse email</label>
                                <input type="email" value="{{ old('email') }}" class="form-control" id="tag-user-email" name="email" required>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <div class="form-floating mb-4">
                                    <select class="form-select" id="role" name="role" aria-label="Selectionnez un rôle" required>
                                        <option>Selectionnez un rôle</option>
                                        @if ($roles)
                                            @foreach($roles as $role)
                                                @if ($role !== 'superadmin' AND $role !== 'admin')
                                                    <option  value="{{ $role }}">
                                                        {{ $role }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    <label class="form-label" for="role">Choisir un rôle</label>
                                </div>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>

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
                                <x-input-error :messages="$errors->get('fitness_center_id')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="tag-user-passowrd">Mot de passe</label>
                                <input type="password" class="form-control" id="tag-user-passowrd" name="password" required>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="tag-user-password-confirmation">Confirmez le mot de passe</label>
                                <input type="password" class="form-control" id="tag-user-password-confirmation" name="password_confirmation" required>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div> 
                            
                            <div class="mb-4">
                                <button type="submit" class="btn btn-sm btn-primary">Créer un utilisateur</button>
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
            <h2 class="content-heading">
                <span class="fw-bolder">{{ $userCount }}</span>
                Utilisateur.s
            </h2>

            @if (count($users) > 0)
                @foreach ($users as $user)
                    @if ($user->role !== 'superadmin')
                        <div class="col-md-6 col-xl-3">
                            <div class="block block-rounded block-link-pop text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <img class="img-avatar" src="{{asset('media/avatars/avatar16.jpg')}}" alt="">
                                </div>
                                <div class="block-content block-content-full block-content-sm bg-body-light">
                                    <p class="fw-semibold mb-0">{{ $user->fullname }}</p>
                                    <p class="fs-sm fw-medium text-muted mb-0">
                                        <b>{{ $user->role }}</b> à {{ $user->fitnessCenter ? $user->fitnessCenter->name : 'Aucun centre' }}
                                    </p>
                                    <p class="fs-sm fw-small text-muted mb-0">
                                        {{ $user->email }}
                                    </p>
                                </div>
                                <div class="block-content block-content-full">
                                    <div class="row g-sm">
                                        <div class="col-6">
                                            <a type="button" class="btn d-block" data-bs-toggle="modal" data-bs-target="#modal-{{ $user->id }}">
                                                <i class="fa fa-fw fa-edit text-body-color-dark"></i>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')" type="submit"><i class="fa fa-fw fa-trash text-body-color-dark"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  

                        <div class="modal" id="modal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="block block-rounded block-themed block-transparent mb-0">
                                        <div class="block-header bg-primary-dark">
                                            <h3 class="block-title">Modifier l'utilisateur {{ $user->id }}</h3>
                                            <div class="block-options">
                                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                                <i class="fa fa-fw fa-times"></i>
                                            </button>
                                            </div>
                                        </div>
                                        <div class="block-content">
                                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-4">
                                                    <label class="form-label" for="tag-user-name">Nom de l'utilisateur</label>
                                                    <input type="text" value="{{ $user->fullname }}" class="form-control" id="tag-user-name" name="fullname" required autofocus autocomplete="user name">
                                                    <x-input-error :messages="$errors->get('fullname')" class="mt-2" />
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label" for="tag-user-email">Adresse email</label>
                                                    <input type="email" value="{{ $user->email }}" class="form-control" id="tag-user-email" name="email" required autocomplete="adresse email">
                                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                                </div>

                                                <div class="mb-4">
                                                    <div class="form-floating mb-4">
                                                        <select class="form-select" id="role" name="role" aria-label="Selectionnez un rôle" required>
                                                            <option>Selectionnez un rôle</option>
                                                            @if ($roles)
                                                                @foreach($roles as $role)
                                                                    @if($role !== 'superadmin')
                                                                        <option 
                                                                            value="{{ $role }}"
                                                                            @if ($role == $user->role)
                                                                                selected
                                                                            @endif
                                                                        >
                                                                            {{ $role }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <label class="form-label" for="role">Choisir un rôle</label>
                                                    </div>
                                                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                                </div>

                                                <div class="mb-4">
                                                    <div class="form-floating mb-4">
                                                        <select class="form-select" id="fitness-home" name="fitness_center_id" aria-label="Affecter à un centre" required>
                                                        <option>Selectionnez un centre</option>
                                                            @if ($centers)
                                                                @foreach($centers as $center)
                                                                    <option 
                                                                        value="{{ $center->id }}"
                                                                        @if ($center->id == $user->fitness_center_id)
                                                                            selected
                                                                        @endif
                                                                    >
                                                                        {{ $center->name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <label class="form-label" for="fitness-home">Affecter un centre</label>
                                                    </div>
                                                    <x-input-error :messages="$errors->get('fitness_center_id')" class="mt-2" />
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label" for="tag-user-passowrd">Mot de passe</label>
                                                    <input type="password" class="form-control" id="tag-user-passowrd" name="password">
                                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="tag-user-password-confirmation">Confirmez le mot de passe</label>
                                                    <input type="password" class="form-control" id="tag-user-password-confirmation" name="password_confirmation">
                                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
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
                    @endif
                @endforeach
            @else
            <p><i>Aucun client enregistré</i></p>
            @endif

        </div>
    </div>
</x-layout>