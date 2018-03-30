@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Detail Produk</h3>
        </div>

        <div class="col-md-12 pull-right" style="background-color:#ffffff;padding-top:20px">
            <form class="form-horizontal" method="POST" action="{{ route('product.list.addProcess') }}" role="form" id="addForm" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <div class="form-group">
                    <div class="col-md-2">&nbsp;</div>
                    <label for="sendMaterialType" class="col-md-2 control-label">Nama Produk</label>

                    <div class="col-md-6">
                        <input id="productName" name="productName" type="text" class="form-control" required value="{{$product['name']}}" />
                    </div>
                    <div class="col-md-2">&nbsp;</div>
                </div>

                <div class="form-group">
                    <div class="col-md-2">&nbsp;</div>

                    <label for="sendMaterialType" class="col-md-2 control-label">Deskripsi</label>

                    <div class="col-md-6">
                        <textarea id="productDescription" name="productDescription" rows="4" class="form-control" style="resize:none;" required>{{$product['description']}}</textarea>
                    </div>

                    <div class="col-md-2">&nbsp;</div>
                </div>

                <div class="form-group">
                    <div class="col-md-2">&nbsp;</div>

                    <label for="sendMaterialType" class="col-md-2 control-label">Gender</label>

                    <div class="col-md-6">
                        <select id="productGender" name="productGender" class="form-control" required>
                            <option value="">--- Pilih Gender ---</option>

                            @foreach($gender as $genderData)
                                <option value="{{$genderData->Id}}" @if($product['gender'] == $genderData->Id) selected @endif >{{$genderData->Name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">&nbsp;</div>
                </div>

                <div class="form-group">
                    <div class="col-md-2">&nbsp;</div>

                    <label for="sendMaterialType" class="col-md-2 control-label">Kategori</label>

                    <div class="col-md-6">
                        <select id="productCategory" name="productCategory" class="form-control" required>
                            <option value="">--- Pilih Kategori ---</option>

                            @foreach($category as $categoryData)
                                <option value="{{$categoryData->Id}}" @if($product['category'] == $categoryData->Id) selected @endif >{{$categoryData->Name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">&nbsp;</div>
                </div>

                <div class="form-group">
                    <div class="col-md-2">&nbsp;</div>

                    <label for="sendMaterialType" class="col-md-2 control-label">Harga</label>

                    <div class="col-md-6">
                        <input id="productPrice" type="text" class="form-control" required value="{{$product['price']}}"/>
                        <input id="productPriceHidden" name="productPrice" type="hidden" value="{{$product['price']}}" />
                    </div>

                    <div class="col-md-2">&nbsp;</div>
                </div>

                <div class="form-group">
                    <div class="col-md-2">&nbsp;</div>

                    <label for="sendMaterialType" class="col-md-2 control-label">Gambar</label>

                    <div class="col-md-6">
                        <input type="hidden" name="file_upload_list" id="file_upload_list">
                        <div id="UploadFile">Browse</div>
                    </div>

                    <div class="col-md-2">&nbsp;</div>
                </div>

                <div class="form-group">
                    <div class="col-md-2">&nbsp;</div>

                    <div class="col-md-8 text-right">
                        <a href="/product/list" type="button" class="btn btn-default"><span class="fa fa-close"></span> Batal</a>
                        <button type="submit" class="btn btn-success" form="addForm"><span class="fa fa-save"></span> Simpan</button>
                    </div>

                    <div class="col-md-2">&nbsp;</div>
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
