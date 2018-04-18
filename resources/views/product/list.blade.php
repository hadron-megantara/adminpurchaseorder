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
        	<table id="customerTable" class="table-bordered text-center" style="width: 100%">
        		<thead>
        			<tr>
        				<th>Nama Produk</th>
                        <th>Kategori</th>
        				<th>Deskripsi</th>
                        <th>Diskon</th>
                        <th>Harga Awal</th>
                        <th>Harga Akhir</th>
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
                { data: 'Category', name: 'Category' },
                { data: 'Description', name: 'Description' },
                { data: 'Discount', render: function(data, type, full) {
                        if(full.DiscountType != ''){
                            if(full.DiscountType == 'Percent'){
                                return full.Discount+'%';
                            } else if(full.DiscountType == 'Price'){
                                data = full.Discount;
                                data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                                return 'Rp '+data;
                            }
                        }

                        return '-';
                    }
                },
                { data: 'oldPrice', name: 'oldPrice', render: function(data, type, full) {
                        data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                        return 'Rp '+data;
                    }
                },
                { data: 'newPrice', name: 'newPrice', render: function(data, type, full) {
                        data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                        return 'Rp '+data;
                    }
                },
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
