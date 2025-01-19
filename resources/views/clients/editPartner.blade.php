@extends('layout.master')
@section('content')
    <!-- Page Content  -->
    <section class="section">

        <style>
            label {
                display: block;
                margin-bottom: 10px;
            }

            input[type=checkbox] {
                display: inline-block;
                width: 20px;
                height: 10px;
                margin-right: 5px;
                vertical-align: middle;
                position: relative;
                top: 2px;
            }
        </style>
        <style>
            .bordered-image {
                border: 0.75px solid #3b3b3b;
                padding: 2px;
            }

            #preview-container {
                position: relative;
            }

            .image-overlay {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: rgba(0, 0, 0, 0.5);
                padding: 10px;
                text-align: center;
            }

            .overlay-text {
                color: #fff;
                font-weight: bold;
            }

            .hide-overlay {
                display: none;
            }

            .bordered-image:hover,
            .overlay-text:hover,
            .image-overlay:hover {
                cursor: pointer;
            }
        </style>

        <div class="row">
            <div class="col-lg-3">
                <div class="card p-3">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Modifier le partenaire</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form action="{{ route('partners.update', $partner->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <div class="container">
                                    <label for="logo-upload" class="custom-button"></label>
                                    <input type="file" id="logo-upload" class="custom-file-input" name="logo"
                                        accept="image/*" style="display: none;">
                                    <div id="preview-container">
                                        <div class="image-overlay">
                                            <span class="overlay-text">Logo</span>
                                        </div>
                                        @if (isset($partnerlogo) && $partnerlogo->filename != null)
                                            <img id="preview-image" class="rounded-circle img-fluid"
                                                src="{{ asset('storage/logos/' . $partnerlogo->filename) }}" alt="">
                                        @else
                                            <img id="preview-image" class="rounded-circle img-fluid bordered-image"
                                                src="{{ asset('assets/images/default-image.png') }}" alt="">
                                        @endif
                                    </div>
                                </div>
                                {{-- <div class="container">
                                    
                                    <label for="logo-upload" class="custom-button" required>Logo</label>
                                </div>
                                <input type="file" id="logo-upload" class="custom-file-input" name="logo"
                                    accept="image/*" onchange="previewImage(event)"> --}}
                            </div>
                            {{-- <div class="form-group">
                                <label for="linkedin">LinkedIn</label>
                                <div class="form-control">
                                    <span class="form-control">linkedin.com/in/</span>
                                    <input id="linkedin" name="linkedin" type="text" placeholder="USER123" />
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <label for="furl" class="ml-1">Facebook:</label>
                                <input type="text" class="form-control" id="furl" placeholder="Facebook"
                                    name="facebook" value="{{ $partner->facebook }}">
                                @error('facebook')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="turl" class="ml-1">Whatsapp:</label>
                                <input type="text" class="form-control" id="turl" placeholder="Ex: 22896855263"
                                    name="whatsapp" value="{{ $partner->whatsapp }}" pattern="[0-9]*"
                                    title="Veuillez entrer un numéro de téléphone valide">
                                    {{-- pattern="^\+(?:[1-9]\d{0,2})-(?:\d{1,4}){1,3}\d{1,4}$" --}}
                                @error('whatsapp')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="instaurl" class="ml-1">Instagram:</label>
                                <input type="text" class="form-control" id="instaurl" placeholder="Instagram"
                                    name="instagram" value="{{ $partner->instagram }}"
                                    pattern="^[a-zA-Z0-9._]+$"
                                        title="Veuillez entrer un nom d'utilisateur Instagram valide">
                                @error('instagram')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="lurl" class="ml-1">Site Web:</label>
                                <input type="text" class="form-control" id="lurl" placeholder="Website"
                                    name="website" value="{{ $partner->website }}"
                                    pattern="^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w\.-]*)*\/?$">
                                @error('website')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card p-3">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Modifier le partenaire</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <div class="new-user-info">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="fname" class="ml-1">Nom:</label>
                                    <input type="text" class="form-control" id="fname" value="{{ $partner->name }}"
                                        name="name" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lname" class="ml-1">Domaine</label>
                                    <input type="text" class="form-control" id="lname"
                                        value="{{ $partner->domain }}" name="domain">
                                    @error('domain')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleFormControlTextarea1" class="ml-1">Biographie</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="biography" row="5">{{ $partner->biography }}</textarea>
                                    @error('biography')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="mobno" class="ml-1">Numéro de téléphone:</label>
                                    <input type="text" class="form-control" id="mobno"
                                        value="{{ $partner->phone }}" name="phone"
                                        pattern="^\+(?:[1-9]\d{0,2})-(?:\d{1,4}){1,3}\d{1,4}$" required>
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cat" class="ml-1">Categories:</label>
                                    <div class="form-group">
                                        <select id="cat" class="select2jsMultiSelect form-control category"
                                            multiple="multiple" name="categorie_id[]" required>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ in_array($category->id, $partnerCategories) ? 'selected' : '' }}>
                                                    {{ $category->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="altconno" class="ml-1">Address</label>
                                    <input type="text" class="form-control" id="altconno"
                                        value="{{ $partner->address }}" name="address">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email" class="ml-1">Email:</label>
                                    <input type="email" class="form-control" id="email"
                                        value="{{ $partner->email }}" name="email"
                                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="rpass" class="ml-1">Connection:</label>
                                    <select class="form-control" type="select" name="connection">
                                        <option value="0" {{ $partner->connection == '0' ? 'selected' : '' }}>
                                            Mobile</option>
                                        <option value="1" {{ $partner->connection == '1' ? 'selected' : '' }}>
                                            Dashboard et mobile</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="" class="ml-1">
                                        <h4>Certifié:</h4>
                                    </label>
                                    <label>
                                        <input type="radio" name="is_certified" value="1"
                                            {{ $partner->is_certified == 1 ? 'checked' : '' }}>
                                        Oui
                                    </label>
                                    <label>
                                        <input type="radio" name="is_certified" value="0"
                                            {{ $partner->is_certified == 0 ? 'checked' : '' }}>
                                        Non
                                    </label>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="" class="ml-1">
                                        <h4>Type de compagnie :</h4>
                                    </label>
                                    <label>
                                        <input type="radio" name="company_type" value="1"
                                            {{ $partner->company_type == 1 ? 'checked' : '' }}>
                                        Grande
                                    </label>
                                    <label>
                                        <input type="radio" name="company_type" value="0"
                                            {{ $partner->company_type == 0 ? 'checked' : '' }}>
                                        Petite
                                    </label>
                                </div>

                            </div>
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary mr-3">Modifier</button>
                                <button type="reset" class="btn btn-secondary"
                                    onclick="window.location.href='{{ route('partners.index') }}'">Annuler</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.category').select2();
            });
        </script>
        {{-- <script>
            function previewImage(event) {
                var input = event.target;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        document.getElementById('preview-image').src = e.target.result;
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script> --}}

        <script>
            var previewContainer = document.getElementById('preview-container');
            var fileInput = document.getElementById('logo-upload');
            var overlayText = document.querySelector('.image-overlay');
            var defaultImage = document.getElementById('default-image');

            previewContainer.addEventListener('click', function() {
                fileInput.click();
            });

            fileInput.addEventListener('change', function(event) {
                var input = event.target;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var previewImage = document.getElementById('preview-image');
                        previewImage.src = e.target.result;
                        overlayText.style.display = 'none'; // Cacher le texte
                        defaultImage.style.display = 'none'; // Cacher l'image par défaut
                        previewContainer.style.display = 'block';
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });

            fileInput.addEventListener('click', function() {
                if (fileInput.value === '') {
                    overlayText.style.display = 'block'; // Afficher à nouveau le texte
                    defaultImage.style.display = 'block'; // Afficher à nouveau l'image par défaut
                    previewContainer.style.display = 'none';
                }
            });
        </script>
    </section>
    <!-- Wrapper END -->
@endsection
