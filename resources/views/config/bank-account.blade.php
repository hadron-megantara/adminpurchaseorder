@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Master - Akun Bank</h3>
        </div>

        <div class="col-md-12">
            <div class="pull-right">
                <a href="#addModal" class="btn btn-success" data-toggle="modal" id="addNewCategoryBtn">
                    <span class="fa fa-plus"></span> Tambah Akun Bank
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
            	<table id="bankAccountTable" class="table-bordered" style="width: 100%">
            		<thead>
            			<tr>
                            <th class="text-center">Logo Bank</th>
            				<th>Nama Akun</th>
                            <th>Nomor Akun</th>
                            <th>Nama Bank</th>
                            <th>Kode Bank</th>
                            <th>Cabang</th>
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
                <h4 class="modal-title">Tambah Akun Bank</h4>
            </div>

            <form method="POST" action="/config/bank-account/add">
                <div class="modal-body" style="margin-top:10px">
                    {!! csrf_field() !!}

                    <div class="col-md-12" style="margin-bottom:15px">
                        <label for="addAccountName" class="col-md-3 control-label">Nama Akun</label>

                        <div class="col-md-9">
                            <input type="text" name="accountName" id="addAccountName" class="form-control" placeholder="Masukkan Nama Akun" />
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-bottom:15px">
                        <label for="addAccountNumber" class="col-md-3 control-label">Nomor Akun</label>

                        <div class="col-md-9">
                            <input type="text" name="accountNumber" id="addAccountNumber" class="form-control" placeholder="Masukkan Nomor Akun" />
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-bottom:15px">
                        <label for="addBank" class="col-md-3 control-label">Nama Bank</label>

                        <div class="col-md-9">
                            <select name="bank" class="form-control" id="addBank">
                                <option value="">--- Pilih Bank ---</option>
                                @foreach($bankList as $bankListData)
                                    <option value="{{$bankListData->Id}}">{{$bankListData->Code}} - {{$bankListData->Name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-bottom:15px">
                        <label for="addAccountBranch" class="col-md-3 control-label">Cabang</label>

                        <div class="col-md-9">
                            <input type="text" name="accountBranch" id="addAccountBranch" class="form-control" placeholder="Masukkan Cabang" />
                        </div>
                    </div>

                    <div class="row clear" style="margin-bottom:10px"></div>
                </div>

                <div class="modal-footer" style="margin-top:30px">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Tutup</button>
                        <button type="submit" id="addProcessBtn" class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
                    </div>
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
                <h4 class="modal-title">Ubah Kategori</h4>
            </div>

            <form method="POST" action="/config/category/edit">
                <div class="modal-body" style="margin-top:10px">
                    {!! csrf_field() !!}

                    <div class="col-md-12">
                        <label for="editCategory" class="col-md-3 control-label">Kategori</label>

                        <div class="col-md-9">
                            <input type="text" name="category" id="editCategory" class="form-control" placeholder="Masukkan Kategori" />
                            <input type="hidden" name="categoryId" id="editCategoryId" />
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
                <h4 class="modal-title">Hapus Kategori</h4>
            </div>

            <form method="POST" action="/config/category/delete">
                <div class="modal-body" style="margin-top:10px">
                    {!! csrf_field() !!}

                    <div class="col-md-12 text-center">
                        <p style="font-size:14px">Anda yakin ingin menghapus kategori "<b id="deleteCategoryName"></b>" ?</p>
                        <input type="hidden" name="categoryId" id="deleteCategoryId" />
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
        $('#bankAccountTable').DataTable({
            processing: true,
            serverSide: true,
            aaSorting: [],
            ajax: '{{ route('config.bankAccount.get') }}',
            columns: [
                { data: 'BankPath', name: 'BankPath', orderable: false, render: function(data, type, full) {
                        return '<img src="'+data+'" style="width:100px">';
                    }
                },
                { data: 'AccountName', name: 'AccountName' },
                { data: 'AccountNumber', name: 'AccountNumber' },
                { data: 'BankName', name: 'BankName' },
                { data: 'BankCode', name: 'BankCode' },
                { data: 'Branch', name: 'Branch' },
                { data: 'Id', name: 'Id', orderable: false, render: function(data, type, full) {
                        return '<div class="text-center"><a class="btn btn-primary editBankAccountBtn" id="edit_'+data+'" href="#editModal" data-toggle="modal"id="edit_'+data+'" ><span class="fa fa-pencil"></span></a> <a class="btn btn-danger deleteBankAccountBtn" id="delete_'+data+'" href="#deleteModal" data-toggle="modal"id="delete_'+data+'" ><span class="fa fa-trash"></span></a></div>';
                    }
                }
            ],
            "oLanguage": {
                "sProcessing": "Memproses...",
                "sZeroRecords": "Tidak ada data untuk ditampilkan..."
            },
        });


        $("#bankAccountTable").on("click", ".editCategoryBtn", function(){
            var id = this.id;
            id = id.substring(5);

            $('#editCategoryId').val(id);
            $('#editCategory').val($('#category_'+id).val());
        });

        $("#bankAccountTable").on("click", ".deleteCategoryBtn", function(){
            var id = this.id;
            id = id.substring(7);

            $('#deleteCategoryId').val(id);
            $('#deleteCategoryName').html($('#category_'+id).val());
        });
	});
</script>

@endsection
