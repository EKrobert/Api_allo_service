@extends('layout.master')
@section('content')
    <!-- Page Content  -->
    <section class="section profile">


        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="cover-container">
                        @if (isset($partnercover) && $partnercover->filename != null)
                            <img src="{{ asset('storage/cover/' . $partnercover->filename) }}" alt="profile-bg" height="325"
                                class="rounded" width="990">
                        @else
                            <img src="{{ asset('assets/images/page-img/profile-bg.jpg') }}" alt="profile-bg"
                                class="rounded img-fluid">
                        @endif
                        <ul class="header-nav d-flex flex-wrap justify-end p-0 m-0">
                            <li><a href="{{ route('partners.edit', $partner->id) }}" class="btn-info btn-sm"><i
                                        class="far fa-edit"></i></a></li>
                            <li><a href="javascript:void();"><i class="ri-settings-4-line"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        @if (isset($partnerlogo) && $partnerlogo->filename != null)
                            <img src="{{ asset('storage/logos/' . $partnerlogo->filename) }}" alt="Profile"
                                class="rounded-circle">
                        @else
                            <img src="{{ asset('assets/images/default-image.png') }}" alt=""
                                class="rounded-circle" />
                        @endif
                        <h2>{{ $partner->name }}</h2>
                        <h4>{{ $partner->domain }}</h4>
                        <h4>Montant: {{ $partner->balance }} FCFA</h4>
                        <div class="social-links mt-2">
                            @if ($partner->whatsapp != null)
                                <a href="https://wa.me/{{ $partner->whatsapp }}" class="whatsapp" target="_blank"><i
                                        class="bi bi-whatsapp"></i></a>
                            @endif
                            @if ($partner->facebook != null)
                                <a href="https://www.facebook.com/{{ $partner->facebook }}" class="facebook"
                                    target="_blank"><i class="bi bi-facebook"></i></a>
                            @endif
                            @if ($partner->instagram != null)
                                <a href="https://www.instagram.com/{{ $partner->instagram }}" class="instagram"
                                    target="_blank"><i class="bi bi-instagram"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
                @if ($partner->is_certified == 1)
                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                            <h4>Cerifié</h4>
                            <img src="{{ asset('assets/images/certification.jpg') }}" alt="Profile"
                                class="rounded-circle">

                        </div>
                    </div>
                @endif
                @if ($partner->galery->count() > 0)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Galerie <a href="{{route('galleries.view',$partner->id)}}">voir+</a></h5>

                            <!-- Slides with controls -->
                            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($partner->galery as $key => $image)
                                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/galleries/' . $image->filename) }}"
                                                class="d-block w-100" alt="Slide {{ $key }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Précédent</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Suivant</span>
                            </button>
                        </div><!-- End Slides with controls -->
                    </div>
                @endif
                
            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">Biographie</h5>
                                <p class="small fst-italic">{{ $partner->biography }}</p>

                                <h5 class="card-title">Détails du profil</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Nom</div>
                                    <div class="col-lg-9 col-md-8">{{ $partner->name }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Categories</div>
                                    <div class="col-lg-9 col-md-8">
                                        @foreach ($partner->categories as $category)
                                            {{ $category->libelle }}
                                            @if (!$loop->last)
                                                {{ ',' }}
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Nombre de compte</div>
                                    <div class="col-lg-9 col-md-8">{{ $numberOfAccount }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">type de compagnie:</div>
                                    <div class="col-lg-9 col-md-8">
                                        @if ($partner->company_type == 1)
                                            Grande
                                        @else
                                            Petite
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Domaine</div>
                                    <div class="col-lg-9 col-md-8">{{ $partner->domain }}</div>
                                </div>

                                {{-- <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Points</div>
                                    <div class="col-lg-9 col-md-8">{{ $partner->points }}</div>
                                </div> --}}

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Address</div>
                                    <div class="col-lg-9 col-md-8">{{ $partner->address }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Numéro de téléphone</div>
                                    <div class="col-lg-9 col-md-8">{{ $partner->phone }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ $partner->email }}</div>
                                </div>
                                @if ($partner->whatsapp != null)
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">WhatsApp</div>
                                        <a href="https://wa.me/{{ $partner->whatsapp }}" target="_blank"
                                            class="col-lg-9 col-md-8">
                                            <div class="col-lg-9 col-md-8">{{ $partner->whatsapp }}</div>
                                        </a>
                                    </div>
                                @endif
                                @if ($partner->facebook != null)
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Facebook</div>
                                        <a class="col-lg-9 col-md-8" href="https://www.facebook.com/{{$partner->facebook}}" target="_blank">{{ $partner->facebook }}</a>
                                    </div>
                                @endif
                                @if ($partner->instagram != null)
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Instagram</div>
                                        <a href="https://www.instagram.com/{{$partner->instagram}}" target="_blank"
                                            class="col-lg-9 col-md-8">{{ $partner->instagram }}</a>
                                    </div>
                                @endif
                                @if ($partner->website != null)
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Site web</div>
                                        <div class="col-lg-9 col-md-8"><a href="https://www.{{$partner->website}}"
                                                target="_blank">{{ $partner->website }}</a></div>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <a class="btn btn-outline-info btn-sm" data-toggle="tooltip" data-placement="top"
                                    data-original-title="Edit" title="Modifier"
                                    href="{{ route('partners.edit', $partner->id) }}"><i class="far fa-edit"></i></a>
                                @can('admin')
                                    <form class="d-inline" action="{{ route('partners.destroy', $partner->id) }}"
                                        method="post" id="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm delete-btn delete-button"
                                            title="Supprimer" style="display:inline" title="Supprimer" type="submit"
                                            data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i
                                                class="ri-delete-bin-line"></i></button>
                                    </form>
                                @endcan
                                <button type="reset" class="btn btn-primary"
                                    onclick="window.location.href='{{ route('partners.index') }}'">Retour</button>
                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>

            <div class="col-lg-8">



            </div>

        </div>


        </div>
        <script>
            function previewImage(event) {
                const input = event.target;
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('preview-logo').setAttribute('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.category').select2();
            });
        </script>
        <!-- script de suppression -->
        <script>
            $('.delete-button').on('click', function(event) {
                event.preventDefault();
                var form = $(this).closest('form');
                Swal.fire({
                    text: "Êtes-vous sûr de vouloir supprimer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        </script>
    </section>
@endsection
