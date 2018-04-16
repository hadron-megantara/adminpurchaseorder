@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Detail Produk</h3>
        </div>

        <div class="col-md-12 pull-right" style="background-color:#ffffff;">
            <div class="row">
                <a href="/product/detail/{{$product['id']}}" class="col-md-6 text-center" style="background:#ffffff;border:solid 1px;border-bottom:none">
                    <span class="" style="font-size:16px; font-weight:bold">Keterangan Produk</span>
                </a>

                <a href="/product/photo-detail/{{$product['id']}}" class="col-md-6 text-center" style="background:#DADADA;border:solid 1px">
                    <span class="" style="font-size:16px; font-weight:bold">Foto Produk</span>
                </a>
            </div>

            <div class="row clear" style="margin-bottom:30px"></div>

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

                    <label for="sendMaterialType" class="col-md-2 control-label">Harga Awal</label>

                    <div class="col-md-6">
                        <input id="productPrice" type="text" class="form-control" required value="{{$product['oldPrice']}}"/>
                        <input id="productPriceHidden" name="productPrice" type="hidden" value="{{$product['oldPrice']}}" />
                    </div>

                    <div class="col-md-2">&nbsp;</div>
                </div>

                <div class="form-group">
                    <div class="col-md-2">&nbsp;</div>

                    <label for="sendMaterialType" class="col-md-2 control-label">Diskon</label>

                    <div class="col-md-6">
                        <input type="checkbox" id="productIsDiscount" name="productIsDiscount" value="1" style="margin-top:11px" @if($product['discountType'] != null) checked @endif> Ya
                    </div>

                    <div class="col-md-2">&nbsp;</div>
                </div>

                <div class="form-group" id="discountArea">
                    <div class="col-md-2">&nbsp;</div>

                    <label for="sendMaterialType" class="col-md-2 control-label">Jumlah Diskon</label>

                    <div class="col-md-6 row">
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="productDiscountVal" @if($product['discountType'] != null) value="{{$product['discount']}}" @endif />
                            <input type="hidden" class="form-control" name="productDiscountVal" id="productDiscountValHidden" @if($product['discountType'] != null) value="{{$product['discount']}}" @endif />
                        </div>

                        <div class="col-md-4">
                            <select id="productDiscountType" name="productDiscountType" class="form-control" required>
                                @foreach($discountType as $discountType2)
                                    <option value="{{$discountType2->Type}}" @if($product['discountType'] == $discountType2->Type) selected @endif >{{$discountType2->Type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">&nbsp;</div>
                </div>

                <div class="form-group">
                    <div class="col-md-2">&nbsp;</div>

                    <label for="sendMaterialType" class="col-md-2 control-label">Harga Akhir</label>

                    <div class="col-md-6">
                        <input id="productFinalPrice" type="text" class="form-control" required value="{{$product['newPrice']}}"/>
                        <input id="productFinalPriceHidden" name="productFinalPrice" type="hidden" value="{{$product['newPrice']}}" />
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
        @if($product['discountType'] == null)
            $('#discountArea').hide();
        @elseif($product['discountType'] == 'Price')
            $('#productDiscountVal').priceFormat({
                prefix: 'Rp ',
                centsLimit: 0,
                thousandsSeparator: '.'
            });
        @endif

        $('#productPrice, #productFinalPrice').priceFormat({
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

        $('#productIsDiscount').click(function(){
            if($(this).is(':checked')){
                $('#discountArea').show();
            } else{
                $('#discountArea').hide();
            }
        });

        $('#productDiscountVal').keyup(function(event){
            if($('#productDiscountType').val() == 'Price'){
                var number = $(this).val().split('.').join("");
                number = number.replace(/Rp /gi,'');
                $('#productDiscountValHidden').val(number);
            } else{
                $('#productDiscountValHidden').val($(this).val());
            }
        });

        $('#productDiscountVal').keypress(function(event){
            if($('#productDiscountType').val() == 'Price'){
                $('#productDiscountVal').priceFormat({
                    prefix: 'Rp ',
                    centsLimit: 0,
                    thousandsSeparator: '.'
                });
            } else if($('#productDiscountType').val() == 'Percent'){
                $('#productDiscountVal').priceFormat({
                    prefix: '',
                    centsLimit: 0,
                    thousandsSeparator: ''
                });
            }
        });

        $('#productDiscountType').change(function(){
            $('#productDiscountVal').val('');
            $('#productDiscountValHidden').val('');
        });
	});
</script>

@endsection
