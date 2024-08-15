@extends('layouts.app', ['title' => 'Perbaharui Role'])
@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                @php
                $currentRouteName = Route::current()->uri();
                @endphp
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $currentRouteName }}</a>
                </li>
            </ol>
        </div>
        <form class="card" id="formUpdateRole" action="{{ route('setting.access-utilities.roles.update') }}">
            @csrf
            <div class="container">
                <div class="d-flex justify-content-between text-center">
                    <h5>Perbaharui Role</h5>
                    <a class="btn btn-secondary btn-sm" href="{{ route('setting.access-utilities.roles') }}"><i
                            class="bi bi-chevron-left"></i>Kembali</a>
                </div>
                <div class="card-body pt-4 row">
                    @php
                    use App\Helpers\Main;
                    $id = Main::hashIdsEncode($foundRole->id);
                    @endphp
                    <div class="col-sm-6">
                        <div class="mb-3 form-group">
                            <input class="form-control" type="text" name="id" id="id" value="{{ $id }}" hidden>
                            <label for="name">Nama Role<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" id="name"
                                placeholder="Masukan nama role" value="{{ $foundRole->name }}" required>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="name">Deskripsi Role</label>
                            <textarea class="form-control" name="desc" id="desc">{{ $foundRole->desc }}</textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3 form-group">
                            <label for="guard_name">Guard Name</label>
                            <input class="form-control" type="text" name="guard_name" id="guard_name" value="web"
                                value="{{ $foundRole->guard_name }}" readonly>
                        </div>
                    </div>
                </div>
                <hr>
                <h5>Hak Akses</h5>
                <div class="row mt-4">
                    @foreach($permissions as $category => $items)
                    <div class="col-12 mb-4">
                        <h6>{{ $category }}</h6>
                        <ul class="list-group">
                            @foreach($items as $item)
                            <li class="list-group-item">
                                <div class="form-check">
                                    @php
                                    $isChecked = in_array($item['id'], $foundPermission) ? 'checked' : '';
                                    @endphp
                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                        value="{{ $item['name'] }}" id="permission{{ $item['id'] }}" {{ $isChecked }} />
                                    <label class="form-check-label" for="permission{{ $item['id'] }}">
                                        {{ $item['name'] }}
                                    </label>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <button id="submitBtn" type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scriptjs')
<script>
    $(document).ready(function () {
        $('#formUpdateRole').on('submit', function (event) {
            event.preventDefault();
            var form = this;
            $('#submitBtn').addClass('disabled');
            $('#name').removeClass('is-invalid');
            $('#guard_name').removeClass('is-invalid');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: $(form).attr('action'),
                data: new FormData(form),
                processData: false, contentType: false,
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        text: response.message,
                        showCloseButton: true,
                        confirmButtonText: 'Lanjutkan',
                    })
                    $('#submitBtn').removeClass('disabled');
                    // location.replace('{{ route("setting.access-utilities.roles") }}')
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: "error",
                        text: xhr.responseJSON.message,
                        showCloseButton: true,
                        confirmButtonText: 'Coba Lagi',
                    });
                    $('#submitBtn').removeClass('disabled');
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        if (errors.name) {
                            $('#name').addClass('is-invalid');
                        }
                        if (errors.menu_name) {
                            $('#guard_name').addClass('is-invalid');
                        }
                    }
                }
            })
        });
    });
</script>
@endsection