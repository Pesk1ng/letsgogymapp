<x-layout>
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Les centres de fitness</h1>
                <button type="button" class="btn btn-alt-primary my-2">
                    <i class="fa fa-fw fa-plus me-1"></i> Nouveau fitness
                </button>
                {{-- <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Let's go gym</li>
                        <li class="breadcrumb-item active" aria-current="page">
                            @if(Auth::user()->fitness_home == 'all') Tous les centres @endif
                        </li>
                    </ol>
                </nav> --}}
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row mb-3">
            <div class="col-md-12 m-auto">
                @session('message')
                    <x-alert type="success" :message="session('message')"/>
                @endsession
            </div>
        </div>

        <div class="row">
            <h2 class="content-heading">
                <span class="badge bg-primary">2</span>
                Centres de fitness
            </h2>

            @if ($centers)
                @foreach ($centers as $center)
                    <div class="col-md-6 col-xl-4">
                        <div class="block block-rounded">
                            <div class="block-content block-content-full bg-primary-darker text-start">
                                <a class="item item-circle mx-start bg-black-25" href="javascript:void(0)">
                                    <i class="fa fa-2x fa-chess-rook text-white"></i>
                                </a>
                                <p class="text-white fs-2 text-capitalize fw-light mt-3 mb-0">
                                    {{$center->name}}
                                </p>
                                <p class="text-white-75 fs-5 mb-0">
                                    {{$center->location}}<br>
                                </p>
                                <br>
                                @if($admin)
                                    <p class="text-white fs-6 mb-0">
                                        {{$admin->fullname}} <i class="fa fa-chess-king"></i>
                                    </p>
                                @endif

                                @if($manager)
                                    <p class="text-gray-lighter mb-0">
                                        <figcaption class="blockquote-footer mt-1 mb-0">
                                            ( {{$manager->fullname}} <i class="fa fa-user-tie"></i> )
                                          </figcaption>
                                    </p>
                                @endif
                            </div>
                            <div class="block-content block-content-full">
                                {{-- <table class="table table-borderless table-striped table-hover">
                                    <tbody>
                                    <tr>
                                        <td class="text-center" style="width: 40px;">01</td>
                                        <td>
                                        <strong>Half Life 2</strong>
                                        </td>
                                        <td class="text-center" style="width: 40px;">
                                        <strong class="text-success">9.6</strong>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table> --}}
                                <div class="text-end">
                                    <a class="btn btn-sm btn-primary" href="javascript:void(0)">
                                    <i class="fa fa-edit me-1 opacity-50"></i> Modifier
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>    
                @endforeach
            @endif

        </div>
    </div>
</x-layout>