@extends('layout.master')
@section('content')
    <section class="section">
        <style>
            .upload-label {
                position: relative;
                display: inline-block;
                cursor: pointer;
            }

            .upload-text {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                color: white;
                font-weight: bold;
                text-align: center;
                background-color: rgba(0, 0, 0, 0.5);
                padding: 10px;
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .upload-label:hover .upload-text {
                opacity: 1;
            }
        </style>
        <div class="card mb-3">
            <div class="row g-0">


                <form action="{{ route('services.store') }}" method="post">
                    @csrf
                    @method('post')

                    <div class="col-md-12">
                        <div class="card-body">
                            <h5 class="card-title">Ajouter un service</h5>
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <div class="form-group">
                                        <label for="name">Nom:</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            minlength="2" maxlength="50" pattern="^[A-Za-zÀ-ÿ\s'\-]+$"
                                            title="Caractères alphabétiques uniquement, y compris les caractères spéciaux tels que é, ï, à, ÿ, ', -, et espace"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label for="des">Description:</label>
                                        <input type="text" class="form-control" id="des" name="description" required>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary mr-3">Enregistrer</button>
                                        <button type="reset" class="btn btn-secondary"
                                            onclick="window.location.href='{{ route('services.index') }}'">Annuler</button>
                                    </div>
                </form>
            </div>
        </div>
        </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#image-upload').on('change', function(e) {
                    var file = e.target.files[0];
                    if (file) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#flag-preview').attr('src', e.target.result);
                            $('#image-error').hide();
                        };
                        reader.readAsDataURL(file);
                    } else {
                        $('#flag-preview').attr('src', '{{ asset('assets/images/default-image.png') }}');
                        $('#image-error').show();
                    }
                });
            });
        </script>
        </div>
    </section>
@endsection
