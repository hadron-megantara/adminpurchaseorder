@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Pengaturan - Kategori</h3>
        </div>

        <div class="col-md-12">
            <div class="pull-right">
                <a href="#addModal" class="btn btn-success" data-toggle="modal">
                    <span class="fa fa-plus"></span> Tambah Kategori
                </a>
            </div>

            <div class="row clear" style="margin-bottom:20px"></div>

            <div class="table-responsive">
            	<table id="customerTable" class="table-bordered" style="width: 100%">
            		<thead>
            			<tr>
            				<th>Kategori</th>
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
                <h4 class="modal-title">Tambah Kategori</h4>
            </div>

            <div class="modal-body">
                <form method="POST" action="/config/category/add">
                    <div class="col-md-12">
                        <label for="addCategory" class="col-md-4 control-label">Kategori</label>

                        <div class="col-md-8">
                            <input type="text" name="category" id="addCategory" class="form-control" />
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
        $('#customerTable').DataTable({
            processing: true,
            serverSide: true,
            aaSorting: [],
            ajax: '{{ route('config.category.get') }}',
            columns: [
                { data: 'Name', name: 'name' },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"><a class="btn btn-primary editColorBtn" id="edit_'+data+'" href="#colorModalEdit" data-toggle="modal"id="edit_'+data+'" ><span class="fa fa-pencil"></span></a> <a class="btn btn-danger deleteColorBtn" id="delete_'+data+'" href="#colorModalDelete" data-toggle="modal"id="delete_'+data+'" ><span class="fa fa-trash"></span></a></div><input type="hidden" id="colorName_'+data+'" value="'+full.Name+'" />';
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });
	});
</script>

@endsection
