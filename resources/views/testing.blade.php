@extends('layouts.app')

@section('content')

<?php
    if(isset($_GET['status'])){
        $status = $_GET['status'];
    } else{
        $status = 9;
    }
?>

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Data Order</h3>
        </div>

        Filter :
        <select id="filter">
            <option value="">Pilih Filter</option>
            @foreach ($orderStatus as $orderStatus2)
                <option value="{{$orderStatus2->kode}}" @if($orderStatus2->kode == $status) selected @endif>{{$orderStatus2->keterangan}}</option>
            @endforeach
        </select>

        <div class="col-md-12" style="margin-top:30px">
            <div class="row" style="background-color:#ffffff">
                <div class="table-responsive">
                	<table id="orderTable" class="table-bordered text-center" style="width: 100%">
                		<thead>
                			<tr>
                                <th>uid</th>
                				<th>sales_id</th>
                                <th>tanggal</th>
                                <th>rs_mdn</th>
                			</tr>
                		</thead>
                		<tbody>
                		</tbody>
                	</table>
                </div>
    	    </div>
        </div>

    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
        $('#orderTable').DataTable({
            processing: true,
            serverSide: true,
            aaSorting: [],
            ajax: "{{ route('testing.order') }}?status={{$status}}",
            columns: [
                { data: 'uid', name: 'uid' },
                { data: 'sales_id', name: 'sales_id', orderable: false },
                { data: 'tanggal', name: 'tanggal', orderable: false },
                { data: 'rs_mdn', name: 'rs_mdn', orderable: false },
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });

        $('#filter').change(function(){
            window.location.replace("/testing?status="+$(this).val());
        });
	});
</script>

@endsection
