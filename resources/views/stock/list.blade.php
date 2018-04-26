@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Data Stok Produk</h3>
        </div>

        <div class="col-md-12 pull-right" style="margin-bottom: 20px; padding-right: 0px">
            <div class="pull-right" style="margin-top: 5px">
                <a href="#addModal" class="btn btn-success" data-toggle="modal" id="addNewStockBtn">
                    <span class="fa fa-plus"></span> Tambah Stok
                </a>
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

        <div class="col-md-12" style="background-color:#ffffff;padding-top:30px">
            <div class="table-responsive">
            	<table id="customerTable" class="table-bordered text-center" style="width: 100%">
            		<thead>
            			<tr>
                            <th>Nama Produk</th>
            				<th>Warna</th>
                            <th>Ukuran</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
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
                <h4 class="modal-title">Tambah Stok</h4>
            </div>

            <form method="POST" action="/stock/add">
                <div class="modal-body" style="margin-top:10px">
                    {!! csrf_field() !!}

                    <div class="col-md-12" style="margin-bottom:20px">
                        <label for="addStockName" class="col-md-3 control-label">Nama Produk</label>

                        <div class="col-md-9">
                            <select id="addStockName" name="stockName" class="form-control">
                                <option>--- Pilih Nama Produk ---</option>
                                @foreach($product as $product2)
                                    <option value="{{$product2->Id}}">{{$product2->Name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-bottom:20px">
                        <label for="addStockColor" class="col-md-3 control-label">Warna</label>

                        <div class="col-md-9">
                            <select id="addStockColor" name="stockColor" class="form-control">
                                <option>--- Pilih Warna Produk ---</option>
                                @foreach($color as $color2)
                                    <option value="{{$color2->Id}}">{{$color2->Name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-bottom:20px">
                        <label for="addStockSize" class="col-md-3 control-label">Ukuran</label>

                        <div class="col-md-9">
                            <select id="addStockSize" name="stockSize" class="form-control">
                                <option>--- Pilih Ukuran Produk ---</option>
                                @foreach($size as $size2)
                                    <option value="{{$size2->Id}}">{{$size2->Size}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-bottom:20px">
                        <label for="addStockTotal" class="col-md-3 control-label">Jumlah</label>

                        <div class="col-md-9">
                            <input type="text" name="stockTotal" id="addStockTotal" class="form-control" placeholder="0" />
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

<script type="text/javascript">
	$(document).ready(function(){
        $('#customerTable').DataTable({
            processing: true,
            serverSide: true,
            aaSorting: [],
            ajax: '{{ route('stock.list.get') }}',
            columns: [
                { data: 'ProductName', name: 'ProductName' },
                { data: 'ProductColor', name: 'ProductColor' },
                { data: 'ProductSize', name: 'ProductSize' },
                { data: 'ProductTotal', name: 'ProductTotal', render: function(data, type, full) {
                        data = data.toString();
                        data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                        return data;
                    }
                },
                { data: 'Id', name: 'Id', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"><a href="/stock/detail/'+data+'" class="btn-sm btn-success"><span class="fa fa-search"></span> Detail</a></div>';
                        return '<div class="text-center"><a class="btn btn-primary editStockBtn" id="edit_'+data+'" href="#editModal" data-toggle="modal"id="edit_'+data+'" ><span class="fa fa-pencil"></span></a></div><input type="hidden" id="stockName_'+data+'" value="'+full.ProductName+'" /><input type="hidden" id="stockTotal_'+data+'" value="'+full.ProductTotal+'" />';
                    }
                },
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        $("#addStockTotal").keypress(function (e) {
            if (e.which < 48 || 57 < e.which)
                e.preventDefault();
        });
	});
</script>

@endsection
