@extends('layouts.app', ['title' => 'Manajemen Pengguna'])

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

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Manajemen menu</h4>
                    <button class="btn btn-primary btn-sm col-sm-2" data-bs-toggle="modal"
                        data-bs-target="#modalTambahData">+ Tambah Data</button>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3"></div>
                    <table class="table table-striped table-bordered" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <!-- Optional footer content -->
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Tambah User -->
<div class="modal fade" id="modalTambahData" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="userForm" action="{{ route('setting.users.store') }}">
                    @csrf
                    <div class="row mb-2 px-2">
                        <label for="nik" class="form-label" required>NIK<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nik" name="nik"
                            placeholder="Masukan NIK pengguna...">
                    </div>
                    <div class="row mb-2 px-2">
                        <label for="name" class="form-label" required>Nama Pengguna<span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Masukan nama pengguna...">
                    </div>

                    <div class="mb-2">
                        <label for="email" class="form-label" required>Email<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="johndoe@email.com">
                    </div>

                    <div class="mb-2">
                        <label for="password" class="form-label" required>Password<span
                                class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Masukan password">
                    </div>

                    <div class="mb-2">
                        <label for="retypePassword" class="form-label" required>Ketik Ulang Password <span
                                class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="retypePassword" name="retypePassword"
                            placeholder="Ketik ulang password">
                    </div>

                    <div class="mb-2">
                        <label for="role" class="form-label" required>Role<span class="text-danger">*</span></label>
                        <select class="form-select role" id="role" name="role" aria-label="role">
                            <option value="">Pilih Role</option>
                        </select>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                <button id="saveBtn" type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User -->
<div class="modal fade" id="editUserModal" data-bs-backdrop="static" aria-labelledby="editUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Ubah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editUserForm" action="{{ route('setting.users.update') }}">
                    @csrf
                    <input type="text" class="form-control" id="idEdit" name="idEdit" hidden>
                    <div class="row px-2">
                        <label for="nikEdit" class="form-label" required>Nama Pengguna<span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nikEdit" name="nikEdit"
                            placeholder="Masukan NIK pengguna...">
                    </div>
                    <div class="row px-2">
                        <label for="nameEdit" class="form-label" required>Nama Pengguna<span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nameEdit" name="nameEdit"
                            placeholder="Masukan nama pengguna...">
                    </div>

                    <div class="mb-2">
                        <label for="emailEdit" class="form-label" required>Email<span
                                class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="emailEdit" name="emailEdit"
                            placeholder="johndoe@email.com">
                    </div>

                    <div class="mb-2">
                        <label for="passwordEdit" class="form-label" required>Password<span
                                class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="passwordEdit" name="passwordEdit"
                            placeholder="Masukan password">
                    </div>

                    <div class="mb-2">
                        <label for="retypePasswordEdit" class="form-label" required>Ketik Ulang Password <span
                                class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="retypePasswordEdit" name="retypePasswordEdit"
                            placeholder="Ketik ulang password">
                    </div>

                    <div class="mb-2">
                        <label for="roleEdit" class="form-label" required>Role<span class="text-danger">*</span></label>
                        <select class="form-select roleEdit" id="roleEdit" name="roleEdit" aria-label="roleEditLabel">
                            <option value="">Pilih Role</option>
                        </select>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                <button id="editBtn" type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
            </form>
        </div>
    </div>
</div>

</div>
@endsection

@section('scriptjs')
<script>
    $(document).ready(function () {
        let roleUrl = "{{ route('setting.users.roles') }}";
        let table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('setting.users') }}",
            dom: "<'row'<'col-sm-9 mb-4 gap-2'l><'col-sm-3'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-9 mt-4'i><'col-sm-3 mt-4'p>>",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'email_verified_at', name: 'email_verified_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            language: {
                searchPlaceholder: "Cari Data..."
            }
        });

        // Inisialisasi Select2 untuk modal tambah data
        $(".role").select2({
            dropdownParent: $("#modalTambahData"),
            ajax: {
                url: roleUrl,
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data.map(item => ({
                            id: item.name,
                            text: item.name
                        }))
                    };
                },
                cache: true
            }
        });

        // Inisialisasi Select2 untuk modal edit data
        $(".roleEdit").select2({
            dropdownParent: $("#editUserModal"),
            ajax: {
                url: roleUrl,
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data.map(item => ({
                            id: item.name,
                            text: item.name
                        }))
                    };
                },
                cache: true
            }
        });

        $(document).on('click', '#btnEditUser', function () {
            let id = $(this).data('id');
            $('#editUserModal').modal('show');

            $.ajax({
                type: 'GET',
                url: '{{ route("setting.users.edit", ":id") }}'.replace(':id', id),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#idEdit').val(response.data.id);
                    $('#nameEdit').val(response.data.name);
                    $('#emailEdit').val(response.data.email);
                    $('#nikEdit').val(response.data.nik);
                    let selectedRole = response.role;
                    let newOption = new Option(selectedRole, selectedRole, true, true);
                    $("#roleEdit").append(newOption).trigger('change');
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: "error",
                        text: xhr.responseJSON.message,
                        showCloseButton: true,
                        confirmButtonText: 'Coba Lagi',
                    });
                }
            });
        });

        $('#userForm').on('submit', function (event) {
            event.preventDefault();
            let password = $('#password').val();
            let retypePassword = $('#retypePassword').val();
            let form = this;
            $('#saveBtn').addClass('disabled');

            $('#name').removeClass('is-invalid');
            $('#email').removeClass('is-invalid');
            $('#nik').removeClass('is-invalid');
            $('#role').removeClass('is-invalid');

            if (password !== retypePassword) {
                alert('Password tidak sesuai, mohon periksa kembali!');
                $('#saveBtn').removeClass('disabled');
            } else {
                $.ajax({
                    type: 'POST',
                    url: $(form).attr('action'),
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            text: response.message,
                            showCloseButton: true,
                            confirmButtonText: 'Lanjutkan',
                        });
                        $('#saveBtn').removeClass('disabled');
                        $('#modalTambahData').modal('hide');
                        table.ajax.reload();
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: "error",
                            text: xhr.responseJSON.message,
                            showCloseButton: true,
                            confirmButtonText: 'Coba Lagi',
                        });
                        $('#saveBtn').removeClass('disabled');
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.name) {
                                $('#name').addClass('is-invalid');
                            }
                            if (errors.email) {
                                $('#email').addClass('is-invalid');
                            }
                            if (errors.nik) {
                                $('#nik').addClass('is-invalid');
                            }
                            if (errors.password) {
                                $('#password').addClass('is-invalid');
                            }
                            if (errors.role) {
                                $('#role').addClass('is-invalid');
                            }
                        }
                    }
                });
            }
        });

        $('#editUserForm').on('submit', function (event) {
            event.preventDefault();
            let password = $('#passwordEdit').val();
            let retypePassword = $('#retypePasswordEdit').val();
            $('#editBtn').addClass('disabled');

            if (password !== retypePassword) {
                alert('Password tidak sesuai, mohon periksa kembali!');
            } else {
                $.ajax({
                    type: 'PUT',
                    url: $(this).attr('action'),
                    data: JSON.stringify({
                        id: $('#idEdit').val(),
                        name: $('#nameEdit').val(),
                        email: $('#emailEdit').val(),
                        nik: $('#nikEdit').val(),
                        password: $('#passwordEdit').val(),
                        role: $('#roleEdit').val()
                    }),
                    processData: false,
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            text: response.message,
                            showCloseButton: true,
                            confirmButtonText: 'Lanjutkan',
                        });
                        $('#editBtn').removeClass('disabled');
                        $('#editUserModal').modal('hide');
                        table.ajax.reload();
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: "error",
                            text: xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan.',
                            showCloseButton: true,
                            confirmButtonText: 'Coba Lagi',
                        });
                        $('#editBtn').removeClass('disabled');
                    }
                });
            }
        });


        $(document).on('click', '.delete-item', function (event) {
            let id = $(this).data('id');
            let name = $(this).data('name');
            var url = '{{ route("setting.users.destroy", ":id") }}';
            url = url.replace(':id', id);

            Swal.fire({
                title: 'Peringatan!',
                text: `Apakah anda yakin ingin menghapus role ${name}?`,
                showDenyButton: true,
                confirmButtonText: "Ya, lanjutkan",
                denyButtonText: `Batalkan`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: 'application/json',
                        processData: false, contentType: false,
                        success: function (response) {
                            Swal.fire({
                                icon: "success",
                                text: response.message,
                                showCloseButton: true,
                                confirmButtonText: 'Oke',
                            })
                            table.ajax.reload();
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                icon: "error",
                                text: xhr.responseJSON.message,
                                showCloseButton: true,
                                confirmButtonText: 'Coba Lagi',
                            });
                        }
                    })
                }
            });
        });
    });
</script>
@endsection