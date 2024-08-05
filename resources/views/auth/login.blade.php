<x-simple-layout>

    <!-- Page Content -->
    <div class="bg-image" style="background-image: url({{ asset('media/photos/photo19@2x.jpg') }})">
        <div class="row g-0 justify-content-center bg-primary-dark-op">
            <div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0">
                <div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">
                    <div class="row mb-3">
                        <div class="col-md-12 m-auto">
                            @session('message')
                                <x-alert type="success" :message="session('message')"/>
                            @endsession
                        </div>
                    </div>
                    <div class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-body-extra-light">
            
                        <div class="mb-5 text-center">
                            <a href="/">
                                <img src="{{ asset('media/logo/logo-dark.svg') }}" width="250" alt="letsgogym">
                            </a>
                            {{-- <p class="mt-3 text-uppercase fw-bold fs-sm text-muted">Connexion</p> --}}
                        </div>

                        <form class="js-validation-signin" action="{{ route('login') }}" method="POST">

                            @csrf

                            <div class="mb-4">
                                <div class="input-group input-group-lg">
                                    <input type="text" class="form-control" id="login-email" name="email" value="pesquilou@gmail.com" placeholder="Adresse email" required autofocus>
                                    <span class="input-group-text">
                                        <i class="fa fa-user-circle"></i>
                                    </span>
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <div class="input-group input-group-lg">
                                    <input type="password" class="form-control" id="login-password" name="password" value="password123" placeholder="Mot de passe" required>
                                    <span class="input-group-text">
                                        <i class="fa fa-asterisk"></i>
                                    </span>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="d-sm-flex justify-content-sm-between align-items-sm-center text-center text-sm-start mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="login-remember-me" name="remember" checked="">
                                    <label class="form-check-label" for="login-remember-me">Se souvenir de moi</label>
                                </div>
                              </div>
                        
                            <div class="text-center mb-4">
                                <button type="submit" class="btn btn-hero btn-primary">
                                    <i class="fa fa-fw fa-sign-in-alt opacity-50 me-1"></i> Connexion
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-simple-layout>