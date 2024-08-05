<x-layout>
    <div class="bg-body-light">
        <div class="bg-body-light border-top border-bottom">
            <div class="content content-full py-1">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-grow-1 fs-sm text-uppercase fw-bold mt-2 mb-0 mb-sm-2">
                        <i class="fa fa-calendar-alt fa-fw text-primary"></i> {{ \Carbon\Carbon::now()->translatedFormat('l j F Y') }} 
                        <br class="my-2">
                        <i class="fa fa-user-tie fa-fw text-primary"></i> {{ Auth::user()->role }}
                        <i class="fa fa-building fa-fw text-primary"></i> {{ $fitnessCenterName }}
                    </h1>
                </div>
            </div>

            <div class="content">
                <div class="row g-sm push">
                    <div class="col-6 col-md-4 col-xl-4">
                        <a class="block block-rounded text-center" href="javascript:void(0)">
                            <div class="block-content block-content-full bg-gd-aqua-op ratio ratio-16x9">
                            <div class="d-flex justify-content-center align-items-center">
                                <div>
                                <i class="fa fa-2x fa-user-circle text-white"></i>
                                <div class="fw-semibold mt-3 text-uppercase text-white">Encaisser</div>
                                </div>
                            </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-xl-4">
                        <a class="block block-rounded text-center" href="javascript:void(0)">
                            <div class="block-content block-content-full bg-gd-sea-op ratio ratio-16x9">
                            <div class="d-flex justify-content-center align-items-center">
                                <div>
                                <i class="fa fa-2x fa-briefcase text-white"></i>
                                <div class="fw-semibold mt-3 text-uppercase text-white">Décaisser</div>
                                </div>
                            </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-xl-4">
                        <a class="block block-rounded text-center" href="javascript:void(0)">
                            <div class="block-content block-content-full bg-gd-sun-op ratio ratio-16x9">
                            <div class="d-flex justify-content-center align-items-center">
                                <div>
                                <i class="fa fa-2x fa-sign-out-alt text-white"></i>
                                <div class="fw-semibold mt-3 text-uppercase text-white">Cloturer</div>
                                </div>
                            </div>
                            </div>
                        </a>
                    </div>
                </div>


                <h2 class="content-heading">
                    <i class="fa fa-angle-right text-muted me-1"></i> Caisse du jour
                </h2>
                <div class="block block-rounded">
                    <div class="block-content block-content-full">
                        <div class="row text-center">
                            <div class="col-md-4 py-3">
                                <div class="fs-1 fw-light text-dark mb-1">
                                    <strong>{{ number_format($totalProductSalesToday + $totalContractSalesToday, 2, ',','.') }}</strong>
                                </div>
                                <a class="link-fx fs-sm fw-bold text-uppercase text-muted" href="javascript:void(0)">Caisse Total</a>
                            </div>
                            <div class="col-md-4 py-3">
                                <div class="fs-1 fw-light text-success mb-1">
                                    +{{ number_format(0, 2, ',','.') }}
                                </div>
                                <a class="link-fx fs-sm fw-bold text-uppercase text-muted" href="javascript:void(0)">Encaissement</a>
                            </div>
                            <div class="col-md-4 py-3">
                                <div class="fs-1 fw-light text-danger mb-1">
                                    -{{ number_format(0, 2, ',','.') }}
                                </div>
                                <a class="link-fx fs-sm fw-bold text-uppercase text-muted" href="javascript:void(0)">Décaissement</a>
                            </div>
                        </div>
                    </div>
                </div>

            <h2 class="content-heading">
                <i class="fa fa-angle-right text-muted me-1"></i> Toutes les transactions
            </h2>
            <a class="block block-rounded block-link-shadow border-start border-success border-3"href="[{{ route('dashboard')}}]">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                    <div>
                        <p class="fs-lg fw-semibold mb-0">
                            +{{ number_format($totalProductSalesToday + $totalContractSalesToday, 2, ',','.') }} Fcfa
                        </p>
                    </div>
                    <div class="ms-3">
                        <i class="fa fa-arrow-left text-success"></i>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light">
                    <span class="fs-sm text-muted">Pour toutes les ventes à <strong>{{ $fitnessCenterName }}</strong> aujourd'hui le <strong>{{ \Carbon\Carbon::now()->translatedFormat('l j F Y') }}</strong></span>
                </div>
            </a>
            <hr>

            {{-- <a class="block block-rounded block-link-shadow border-start border-danger border-3"href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                <div>
                    <p class="fs-lg fw-semibold mb-0">
                    -$540,00
                    </p>
                    <p class="text-muted mb-0">
                    xxx-7898 VISA
                    </p>
                </div>
                <div class="ms-3">
                    <i class="fa fa-arrow-right text-danger"></i>
                </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light">
                <span class="fs-sm text-muted">From <strong>Company Inc</strong> at <strong>June 5, 2024 - 08:46</strong></span>
                </div>
            </a>
            <a class="block block-rounded block-link-shadow border-start border-success border-3"href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                <div>
                    <p class="fs-lg fw-semibold mb-0">
                    +$120,00
                    </p>
                    <p class="text-muted mb-0">
                    xxx-485 Account
                    </p>
                </div>
                <div class="ms-3">
                    <i class="fa fa-arrow-left text-success"></i>
                </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light">
                <span class="fs-sm text-muted">From <strong>Company Inc</strong> at <strong>May 25, 2024 - 12:25</strong></span>
                </div>
            </a>
            <a class="block block-rounded block-link-shadow border-start border-success border-3"href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                <div>
                    <p class="fs-lg fw-semibold mb-0">
                    +$698,00
                    </p>
                    <p class="text-muted mb-0">
                    xxx-796 Account
                    </p>
                </div>
                <div class="ms-3">
                    <i class="fa fa-arrow-left text-success"></i>
                </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light">
                <span class="fs-sm text-muted">From <strong>Company Inc</strong> at <strong>May 23, 2024 - 14:23</strong></span>
                </div>
            </a> --}}
        </div>

      </div>
</x-layout>