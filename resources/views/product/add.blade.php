@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Tambah Produk</h3>
        </div>

        <div class="col-md-12 pull-right" style="background-color:#ffffff;padding-top:20px">
            <form class="form-horizontal" method="POST" action="{{ route('product.list.addProcess') }}" role="form" id="addForm">
                {!! csrf_field() !!}

                <div class="form-group" style="background-color:">
                    <div class="col-md-12">
                        <h3 style="font-weight:bold">#Informasi Produk</h3>
                    </div>
                </div>

                <div class="form-group" style="margin-top:-10px">
                    <label for="sendMaterialType" class="col-md-2 control-label">Nama Produk</label>

                    <div class="col-md-4">
                        <input id="productName" name="productName" type="text" class="form-control" required placeholder="Masukkan Nama Produk" />
                    </div>

                    <label for="sendMaterialType" class="col-md-2 control-label">Deskripsi</label>

                    <div class="col-md-4">
                        <textarea id="productDescription" name="productDescription" type="text" class="form-control" style="resize:none" required placeholder="Masukkan Deskripsi Produk"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="sendMaterialType" class="col-md-2 control-label">Gender</label>

                    <div class="col-md-4">
                        <select id="productGender" name="productGender" class="form-control" required>
                            <option value="">Pilih Gender</option>

                            @foreach($gender as $genderData)
                                <option value="{{$genderData->Id}}">{{$genderData->Name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <label for="sendMaterialType" class="col-md-2 control-label">Kategori</label>

                    <div class="col-md-4" style="margin-top:10px">
                        @foreach($category as $categoryData)
                            <input type="checkbox" name="productCategory[]" value="{{$categoryData->Id}}"> <span>{{$categoryData->Name}}</span><br>
                            <div style="margin-bottom:5px"></div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <label for="sendMaterialType" class="col-md-2 control-label">Harga</label>

                    <div class="col-md-4">
                        <input id="productPrice" type="text" class="form-control" required placeholder="Masukan Harga" />
                        <input id="productPriceHidden" name="productPrice" type="hidden" />
                    </div>
                </div>

                <hr style="margin-bottom:0px"></hr>

                <div class="form-group">
                    <div class="col-md-12">
                        <h3 style="font-weight:bold">#Foto</h3>
                    </div>
                </div>

                <div class="form-group" style="margin-top:-10px">
                    <label for="sendMaterialType" class="col-md-2 control-label">Gambar Produk</label>

                    <div class="col-md-4">
                        <input type="hidden" name="file_upload_list" id="file_upload_list">
                        <div id="UploadFile">Browse</div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-2">&nbsp;</div>

                    <div class="col-md-10 text-right">
                        <a href="/product/list" type="button" class="btn btn-default"><span class="fa fa-close"></span> Batal</a>
                        <button type="submit" class="btn btn-success" form="addForm"><span class="fa fa-save"></span> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
        $('#productPrice').priceFormat({
            prefix: 'Rp ',
            centsLimit: 0,
            thousandsSeparator: '.'
        });

        $('#productPrice').keyup(function(){
            var number = $(this).val().split('.').join("");
            number = number.replace(/Rp /gi,'');
            $('#productPriceHidden').val(number);
        });

        $("#UploadFile").uploadFile({
            url: "{{ route('product.detail.uploadFile') }}",
            dragDrop: true,
            fileName: "photo",
            returnType: "json",
            showDelete: true,
            allowDuplicates: false,
            allowedTypes:"jpg,jpeg,png",
            showProgress: true,
            onSuccess:function(files, data, jqXHR)
              {
                if("error" in data){
                  alert(data.error.error);
                  location.reload();
                }
                else {
                $('#file_upload_list').val($('#file_upload_list').val() + ","+data.toString());
              }
              },
            deleteCallback: function (data, pd) {

              var filename = data[0];
                for (var i = 0; i < data.length; i++) {
                    $.post("{{ route('product.detail.removeFile') }}", {op: "delete",name: data[i]},
                        function (resp,textStatus, jqXHR) {
                            //Show Message
                            console.log(filename);
                            var list_file = $('#file_upload_list').text();
                            var list_new = list_file.replace(","+filename,"");
                            $('#file_upload_list').val(list_new);
                            alert("File Deleted");
                        });
                }
                pd.statusbar.hide(); //You choice.

            }
        });

        function getFileName(filepath) {
            var paths = filepath.split('\\');
            var filename = paths[paths.length - 1];
            return filename.replace(" ", "_")
        }

        function getBase64(file, callback) {
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function () {
                var docs = reader.result.split(',');
                callback(docs[1]);
            };
            reader.onerror = function (error) {
                console.log('Error: ', error);
            };
        }
	});
</script>

@endsection
