@extends('layouts.app', ['title' => 'Perbaharui Permission'])
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
        <form class="card p-4" id="formUpdatePermission"
            action="{{ route('setting.access-utilities.permissions.update') }}" method="POST">
            @csrf
            <div class="container">
                <div class="d-flex justify-content-between text-center">
                    <h5>Formulir Permission</h5>
                    <a class="btn btn-secondary btn-sm" href="{{ route('setting.access-utilities.permissions') }}"><i
                            class="bi bi-chevron-left"></i>Kembali</a>
                </div>
                <div class="card-body pt-4 row">
                    <div class="col-sm-6">
                        <input class="form-control" type="text" name="id" id="id"
                            value="{{ \App\Helpers\Main::hashIdsEncode($permission->id) }}" hidden>
                        <div class="mb-3 form-group">
                            <label for="name">Nama Permission<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" id="name"
                                value="{{ $permission->name }}" placeholder="Masukan nama permission">
                        </div>
                        <div class="mb-3 form-group">
                            <label for="menu_name">Kategori Menu<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="menu_name" id="menu_name"
                                value="{{ $permission->menu_name }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3 form-group">
                            <label for="guard_name">Guard Name</label>
                            <input class="form-control" type="text" name="guard_name" id="guard_name" value="web"
                                readonly>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="action_name">Nama Tindakan<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="action_name" id="action_name"
                                value="{{ $permission->action_name }}">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scriptjs')
<script>
    $(document).ready(function () {
        $('#formUpdatePermission').on('submit', function (event) {
            event.preventDefault();
            var form = this;
            $('#name').removeClass('is-invalid');
            $('#menu_name').removeClass('is-invalid');
            $('#action_name').removeClass('is-invalid');
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
                    // location.replace('{{ route("setting.access-utilities.roles") }}')
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: "error",
                        text: xhr.responseJSON.message,
                        showCloseButton: true,
                        confirmButtonText: 'Coba Lagi',
                    });
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        if (errors.name) {
                            $('#name').addClass('is-invalid');
                        }
                        if (errors.menu_name) {
                            $('#menu_name').addClass('is-invalid');
                        }
                        if (errors.action_name) {
                            $('#action_name').addClass('is-invalid');
                        }
                    }
                }
            })
        });
    });
</script>
@endsection