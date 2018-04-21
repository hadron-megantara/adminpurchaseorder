@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>List Customer</h3>
        </div>

        <div class="col-md-12" style="background-color:#ffffff;padding-top:30px">
            <div class="table-responsive">
            	<table id="customerTable" class="table-bordered" style="width: 100%">
            		<thead>
            			<tr>
            				<th>Email</th>
                            <th>Nama Pelanggan</th>
            				<th>No HP/Telp</th>
                            <th>Status</th>
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
            ajax: '{{ route('customer.get') }}',
            columns: [
                { data: 'Email', name: 'email' },
                { data: 'Fullname', name: 'name' },
                { data: 'Phone', name: 'phone' },
                { data: 'Status', name: 'status' },
                { data: 'id', name: 'id', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"><a class="btn btn-primary detailCustomerBtn" id="detail_'+data+'" href="#userModalDetail" data-toggle="modal"id="detail_'+data+'" ><span class="fa  fa-search"></span></a> <a class="btn btn-danger banCustomerBtn" id="ban_'+data+'" href="#userModalDetail" data-toggle="modal"id="ban_'+data+'" ><span class="fa fa-ban"></span></a> </div><input type="hidden" id="customerName_'+data+'" value="'+full.Fullname+'" /><input type="hidden" id="customerEmail_'+data+'" value="'+full.Email+'" /><input type="hidden" id="customerPhone_'+data+'" value="'+full.Phone+'" />';
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
