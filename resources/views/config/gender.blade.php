@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Pengaturan - Gender</h3>
        </div>

        <div class="row">
            <div class="table-responsive">
            	<table id="customerTable" class="table-bordered" style="width: 100%">
            		<thead>
            			<tr>
            				<th>Gender</th>
            				<th class="actions-column">Aksi</th>
            			</tr>
            		</thead>
            		<tbody>
            		</tbody>
            	</table>
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
            ajax: '{{ route('config.gender.get') }}',
            columns: [
                { data: 'Name', name: 'name' },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"><a class="btn btn-primary editColorBtn" id="edit_'+data+'" href="#colorModalEdit" data-toggle="modal"id="edit_'+data+'" ><span class="fa fa-pencil"></span></a> </div><input type="hidden" id="colorName_'+data+'" value="'+full.Name+'" />';
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
