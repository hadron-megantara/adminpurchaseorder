@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Data Pemesanan</h3>
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
            <div id="filterArea" style="margin-bottom:30px;">
                <label><strong>Filter</strong></label>

                Status Pemesanan :
                <select id="filterOrderStatus">
                    <option value="0" @if(isset($_GET['status']) && $_GET['status'] == 0) selected @endif>Pemesanan Masuk</option>
                    <option value="1" @if(isset($_GET['status']) && $_GET['status'] == 1) selected @endif>Pemesanan Telah Dibayar</option>
                    <option value="2" @if(isset($_GET['status']) && $_GET['status'] == 2) selected @endif>Pemesanan Telah Diproses</option>
                    <option value="3" @if(isset($_GET['status']) && $_GET['status'] == 3) selected @endif>Pemesanan Telah Dikirim</option>
                    <option value="4" @if(isset($_GET['status']) && $_GET['status'] == 4) selected @endif>Pemesanan Telah Sampai</option>
                    <option value="5" @if(isset($_GET['status']) && $_GET['status'] == 5) selected @endif>Pemesanan Batal</option>
                </select>

                <span style="margin-left:20px">Kode Pemesanan : </span>
                <input type="text" id="filterOrderCode" name='orderCode' />

                <div class="row clear" style="margin-top:20px"></div>

                <span>Tanggal dari : </span>
                <input type="text" id="filterDateFrom" name="dateFrom" placeholder="Pilih Tanggal" style="position: relative; z-index: 100" />

                <span style="margin-left:20px">Tanggal ke : </span>
                <input type="text" id="filterDateTo" name="dateTo" placeholder="Pilih Tanggal" style="position: relative; z-index: 100" />

            </div>

            <hr/>

            <div class="table-responsive">
            	<table id="customerTable" class="table-bordered text-center" style="width: 100%">
            		<thead>
            			<tr>
                            <th>Tanggal pemesanan</th>
            				<th>Kode Pemesanan</th>
                            <th>Nama Pemesan</th>
            				<th>Alamat</th>
                            <th>HP/Telepon</th>
                            <th style="width:50px">Kode Transaksi</th>
                            <th style="width:100px">Nominal</th>
                            <th style="width:60px">Aksi</th>
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
        @if(isset($_GET['status']))
            var url = "{{ route('order.list.get') }}?status={{$_GET['status']}}";
        @else
            var url = "{{ route('order.list.get') }}";
        @endif

        $('#customerTable').DataTable({
            processing: true,
            serverSide: true,
            aaSorting: [],
            ajax: url,
            columns: [
                { data: 'CreatedDt', name: 'CreatedDt' },
                { data: 'OrderCode', name: 'OrderCode', orderable: false },
                { data: 'Fullname', name: 'Fullname', orderable: false },
                { data: 'Address', orderable: false, render: function(data, type, full) {
                        if(full.PostCode != ''){
                            return data+', '+full.DistrictName+', '+full.CityName+', '+full.ProvinceName+' - '+full.PostCode;
                        } else{
                            return data+', '+full.DistrictName+', '+full.CityName+', '+full.ProvinceName;
                        }
                    }
                },
                { data: 'Phone', name: 'Phone', orderable: false },
                { data: 'TransactionCode', name: 'TransactionCode', orderable: false },
                { data: 'FinalPrice', name: 'FinalPrice', orderable: false, render: function(data, type, full) {
                        data = data.toString();
                        data = data.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
                        return 'Rp '+data;
                    }
                },
                { data: 'OrderCode', name: 'OrderCode', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"><a href="/order/detail/'+data+'" class="btn-sm btn-success"><span class="fa fa-search"></span> Detail</a></div>';
                    }
                },
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        $('#filterOrderStatus').change(function(){
            window.location.replace("/order/list?status="+$(this).val());
        });

        $('#filterDateFrom').datepicker({
            dateFormat: 'yy-mm-dd',
            regional: 'id',
            orientation: "auto",
            maxDate : 'now',
            changeYear: true,
            onClose: function() {
                $("#filterDateTo").datepicker(
                        "change",
                        { minDate: new Date($('#filterDateFrom').val()) }
                );
            }
        });

        $('#filterDateTo').datepicker({
            dateFormat: 'yy-mm-dd',
            regional: 'id',
            orientation: "auto",
            maxDate : 'now',
            changeYear: true,
            onClose: function() {
                $("#filterDateFrom").datepicker(
                        "change",
                        { maxDate: new Date($('#filterDateTo').val()) }
                );
            }
        });
	});
</script>

@endsection
