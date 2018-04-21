@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Master - Gender</h3>
        </div>

        <div class="row">
            <div class="table-responsive">
            	<table id="customerTable" class="table-bordered" style="width: 100%">
            		<thead>
            			<tr>
            				<th>Gender</th>
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
                { data: 'Name', name: 'name' }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });
	});
</script>

@endsection
