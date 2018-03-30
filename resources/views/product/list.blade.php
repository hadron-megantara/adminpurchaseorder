@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Data Produk</h3>
        </div>

        <div class="col-md-12 pull-right" style="margin-bottom: 20px; padding-right: 0px">
            <div class="pull-right" style="margin-top: 5px">
                <a href="{{ route('product.list.add') }}" class="btn btn-success btnAddForm" id="btnAddForm"><span class="fa fa-plus"></span> Tambah Produk</a>
            </div>
        </div>

        <div class="row"></div>

        @if(session('success'))
            <div class="panel panel-success">
                <div class="panel-heading notification text-center">
                    {{session('success')}}
                </div>
            </div>
        @endif

        <div class="table-responsive">
        	<table id="customerTable" class="table-bordered" style="width: 100%">
        		<thead>
        			<tr>
        				<th>Nama Produk</th>
        				<th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Aksi</th>
        			</tr>
        		</thead>
        		<tbody>
        		</tbody>
        	</table>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
        $('#customerTable').DataTable({
            processing: true,
            serverSide: true,
            aaSorting: [],
            ajax: '{{ route('product.list.get') }}',
            columns: [
                { data: 'Name', name: 'Name' },
                { data: 'Description', name: 'Description' },
                { data: 'Price', name: 'Price' },
                { data: 'Id', name: 'Id', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"><a href="/product/detail/'+data+'" class="btn-sm btn-success"><span class="fa fa-search"></span> Detail</a></div>';
                    }
                },
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });
	});
</script>

@endsection
