@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Master - Warna</h3>
        </div>

        <div class="col-md-12">
            <div class="pull-right">
                <a href="#addModal" class="btn btn-success" data-toggle="modal" id="addNewColorBtn">
                    <span class="fa fa-plus"></span> Tambah Warna
                </a>
            </div>
        </div>

        <div class="row clear" style="margin-bottom:20px"></div>

        <div class="col-md-12" style="background-color:#ffffff;padding-top:30px">
            @if(session('success'))
                <div class="panel panel-success" style="margin-bottom:20px">
                    <div class="panel-heading notification text-center">
                        {{session('success')}}
                    </div>
                </div>
            @endif

            <div class="table-responsive">
            	<table id="colorTable" class="table-bordered" style="width: 100%">
            		<thead>
            			<tr>
            				<th>Warna</th>
            				<th class="actions-column" width="100px">Aksi</th>
            			</tr>
            		</thead>
            		<tbody>
            		</tbody>
            	</table>
            </div>
	    </div>
    </div>
</div>

<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Warna</h4>
            </div>

            <form method="POST" action="/config/color/add">
                <div class="modal-body" style="margin-top:10px">
                    {!! csrf_field() !!}

                    <div class="col-md-12">
                        <label for="addColor" class="col-md-3 control-label">Warna</label>

                        <div class="col-md-9">
                            <input type="text" name="color" id="addColor" class="form-control" placeholder="Masukkan Warna" />
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="margin-top:30px">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Tutup</button>
                    <button type="submit" id="addProcessBtn" class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ubah Warna</h4>
            </div>

            <form method="POST" action="/config/color/edit">
                <div class="modal-body" style="margin-top:10px">
                    {!! csrf_field() !!}

                    <div class="col-md-12">
                        <label for="editColor" class="col-md-3 control-label">Warna</label>

                        <div class="col-md-9">
                            <input type="text" name="color" id="editColor" class="form-control" placeholder="Masukkan Warna" />
                            <input type="hidden" name="colorId" id="editColorId" />
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="margin-top:30px">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Tutup</button>
                    <button type="submit" id="addProcessBtn" class="btn btn-primary"><span class="fa fa-pencil"></span> Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Hapus Warna</h4>
            </div>

            <form method="POST" action="/config/color/delete">
                <div class="modal-body" style="margin-top:10px">
                    {!! csrf_field() !!}

                    <div class="col-md-12 text-center">
                        <p style="font-size:14px">Anda yakin ingin menghapus warna "<b id="deleteColorName"></b>" ?</p>
                        <input type="hidden" name="colorId" id="deleteColorId" />
                    </div>
                </div>

                <div class="modal-footer" style="margin-top:30px">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Tutup</button>
                    <button type="submit" id="addProcessBtn" class="btn btn-danger"><span class="fa fa-trash"></span> Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
        $('#colorTable').DataTable({
            processing: true,
            serverSide: true,
            aaSorting: [],
            ajax: '{{ route('config.color.get') }}',
            columns: [
                { data: 'Name', name: 'Name' },
                { data: 'Id', name: 'Id', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"><a class="btn btn-primary editColorBtn" id="edit_'+data+'" href="#editModal" data-toggle="modal"id="edit_'+data+'" ><span class="fa fa-pencil"></span></a> <a class="btn btn-danger deleteColorBtn" id="delete_'+data+'" href="#deleteModal" data-toggle="modal"id="delete_'+data+'" ><span class="fa fa-trash"></span></a></div><input type="hidden" id="color_'+data+'" value="'+full.Name+'" />';
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        $("#colorTable").on("click", ".editColorBtn", function(){
            var id = this.id;
            id = id.substring(5);

            $('#editColorId').val(id);
            $('#editColor').val($('#color_'+id).val());
        });

        $("#colorTable").on("click", ".deleteColorBtn", function(){
            var id = this.id;
            id = id.substring(7);
            console.log(id);

            $('#deleteColorId').val(id);
            $('#deleteColorName').html($('#color_'+id).val());
        });
	});
</script>

@endsection
