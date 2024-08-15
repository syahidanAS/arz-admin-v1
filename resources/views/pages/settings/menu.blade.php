@extends('layouts.app', ['title' => 'Manajemen Menu'])

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
                        data-bs-target="#staticBackdrop">+ Tambah Data</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="display">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Menu</th>
                                    <th>URL</th>
                                    <th>Kelompok</th>
                                    <th>Sub Menu</th>
                                    <th>Tindakan</th>
                                </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Tambah Menu -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="menuForm" action="{{ route('setting.menus.store') }}">
                    @csrf
                    <div class="row px-2">
                        <label for="name" class="form-label" required>Nama Menu<span
                                class="text-danger">*</span></label>
                        <br>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukan nama menu..."
                            required>
                    </div>

                    <div class="my-4">
                        <label for="url" class="form-label" required>Tipe Menu<span class="text-danger">*</span></label>
                        <select class="form-select type" id="type" name="type" aria-label="Default select example"
                            runat="server">
                            <option selected disabled>Pilih Tipe Menu</option>
                            <option value="parent">Menu Utama</option>
                            <option value="child-level-1">Sub Menu Level 1</option>
                            <option value="child-level-2">Sub Menu Level 2</option>
                        </select>
                    </div>

                    <div class="">
                        <label for="icon" class="form-label" required>Icon</label>
                        <br>
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Mausukan icon SVG.."
                            required>
                    </div>

                    <div class="" id="urlbox">
                        <label for="url" class="form-label" required>Url</label>
                        <input type="text" class="form-control" id="url" name="url" placeholder="/nama-menu">
                    </div>

                    <div class="" id="parent_box" style="display: none;">
                        <label for="parent_id" class="form-label" required>Menu Parent</label>
                        <select class="form-select parents" id="parent_id" name="parent_id" aria-label="parents"
                            runat="server">
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

<!-- Edit Menu -->
<div class="modal fade" id="editMenuModal" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Ubah Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="updateMenuForm" action="{{ route('setting.menus.update') }}">
                    @csrf
                    <input type="text" class="form-control" id="idEdit" name="idEdit" hidden>
                    <div class="row px-2">
                        <label for="nameEdit" class="form-label" required>Nama Menu<span
                                class="text-danger">*</span></label>
                        <br>
                        <input type="text" class="form-control" id="nameEdit" name="nameEdit"
                            placeholder="Masukan nama menu..." required>
                    </div>
                    <div class="">
                        <label for="iconEdit" class="form-label" required>Icon</label>
                        <br>
                        <input type="text" class="form-control" id="iconEdit" name="iconEdit"
                            placeholder="Mausukan icon SVG.." required>
                    </div>

                    <div class="" id="urlEditBox">
                        <label for="urlEdit" class="form-label" required>Url</label>
                        <input type="text" class="form-control" id="urlEdit" name="urlEdit" placeholder="/nama-menu">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                <button id="editBtn" type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scriptjs')
<script type="text/javascript">
    let parent_id_box = document.getElementById("parent_box");
    let parentUrl = "{{ route('setting.menus.parents.children') }}";
    let deleteUrl = "{{ route('setting.menus.destroy') }}";

    let choosedParent = null

    $('#type').change(function () {
        let condition = $(this).val();
        if (condition === "parent") {
            parent_id_box.style.display = "none";
            choosedParent = null;
        } else if (condition === "child-level-1") {
            parent_id_box.style.display = "block";
            choosedParent = 1;
        } else {
            parent_id_box.style.display = "block";
            choosedParent = 2;
        }

        $(".parents").select2({
            dropdownParent: $("#staticBackdrop"),
            ajax: {
                url: parentUrl + '?condition=' + choosedParent,
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data.map(item => ({
                            id: item.id,
                            text: item.name
                        }))
                    }
                },
                cache: true
            }
        });
    });
    $(document).ready(function () {
        $(".type").select2({
            dropdownParent: $("#staticBackdrop"),
        });
        let table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('setting.menus') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'url', name: 'url' },
                { data: 'type', name: 'type' },
                { data: 'children', name: 'children' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
        });


        $('#menuForm').on('submit', function (event) {
            event.preventDefault();
            var form = this;
            $('#saveBtn').addClass('disabled');
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
                    $('#saveBtn').removeClass('disabled');
                    $('#staticBackdrop').modal('hide');
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
                }
            })
        })

        $('#updateMenuForm').on('submit', function (event) {
            event.preventDefault();
            $('#editBtn').addClass('disabled');
            $.ajax({
                type: 'PUT',
                url: $(this).attr('action'),
                data: JSON.stringify({
                    id: $('#idEdit').val(),
                    name: $('#nameEdit').val(),
                    icon: $('#iconEdit').val(),
                    url: $('#urlEdit').val()
                }),
                processData: false,
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(response);
                    Swal.fire({
                        icon: "success",
                        text: response.message,
                        showCloseButton: true,
                        confirmButtonText: 'Lanjutkan',
                    });
                    $('#editBtn').removeClass('disabled');
                    $('#editMenuModal').modal('hide');
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
        })
    });

    function deleteItem(id, name) {
        Swal.fire({
            title: 'Peringatan!',
            text: `Apakah anda yakin ingin menghapus menu ${name}? jika anda menghapus menu ini, maka menu dibawahnya akan ikut terhapus!`,
            showDenyButton: true,
            confirmButtonText: "Ya, lanjutkan",
            denyButtonText: `Batalkan`,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: deleteUrl + '?id=' + id,
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
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
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
    }

    function editItem(id) {
        $('#editMenuModal').modal('show');
        $.ajax({
            type: 'GET',
            url: '{{ route("setting.menus.edit", ":id") }}'.replace(':id', id),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: 'application/json',
            processData: false, contentType: false,
            success: function (response) {
                $('#idEdit').val(response.data.id);
                $('#nameEdit').val(response.data.name);
                $('#iconEdit').val(response.data.icon);
                $('#urlEdit').val(response.data.url);
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

</script>
@endsection