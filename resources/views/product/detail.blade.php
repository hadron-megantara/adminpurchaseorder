@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Detail Produk</h3>
        </div>

        <form class="form-horizontal" method="POST" action="{{ route('product.list.addProcess') }}" role="form" id="addForm" enctype="multipart/form-data">
            {!! csrf_field() !!}

            <div class="col-md-12 pull-right" style="background-color:#ffffff;">
                <div class="row clear"></div>
                <div class="form-group">
                    <div class='col-md-12'>
                        <h4 style="font-weight:bold">#Informasi Produk</h4>
                        <hr style="margin-top:-5px">
                    </div>

                    <label for="sendMaterialType" class="col-md-2 control-label">Gambar Produk</label>

                    <div class="col-md-10">
                        <?php
                            $countPhoto = 1;
                            $selectedPhoto = 0;
                            $selectedPhotoId = null;
                        ?>

                        <div id="imageListPreview" class="row form-group">
                            @foreach($photo as $photoData)
                                <div class="col-md-2">
                                    <select name="photoColor[]" class="form-control">
                                        <option value="">Pilih Warna</option>
                                        @foreach($color as $color2)
                                            <option value="{{$color2->Id}}" @if($color2->Id == $photoData->_Color) selected @endif>{{$color2->Name}}</option>
                                        @endforeach
                                    </select>

                                    @if($photoData->Selected == 1)
                                        <? $selectedPhotoId = $photoData->Id ?>
                                        <img src="{{$photoData->Photo}}" class="photoClick" id="photoClick_{{$photoData->Id}}" style="width:100%;border:solid #86142B 2px;height:160px;cursor:pointer" />
                                        <div class="text-center chosenPhoto" id="chosenPhoto_{{$photoData->Id}}" style="background-color:#ffffff;border:solid #86142B 2px;border-top:none">
                                            <b style="color:#6B0D1F">Foto Utama</b>
                                        </div>
                                    @else
                                        <img src="{{$photoData->Photo}}" class="photoClick" id="photoClick_{{$photoData->Id}}" style="width:100%;height:160px;cursor:pointer" />
                                        <div class="text-center chosenPhoto" id="chosenPhoto_{{$photoData->Id}}" style="display:none;background-color:#ffffff;border:solid #86142B 2px;border-top:none">
                                            <b style="color:#6B0D1F">Foto Utama</b>
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-md-6">
                                            <btn class="btn btn-primary form-control" style="margin-top:0px;height:20px;width:30px;padding:0px;padding-left:4px"><span class="fa fa-pencil"></span></btn>
                                        </div>

                                        <div class="col-md-6">
                                            <btn class="btn btn-danger form-control" style="height:20px;width:30px;padding:0px;padding-left:4px;margin-right:0px;margin-left:7px"><span class="fa fa-trash"></span></btn>
                                        </div>
                                    </div>
                                </div>

                                @if($countPhoto == 6)
                                    <div class="row clear" style="margin-bottom:20px;"></div>
                                    <?php $countPhoto = 0; ?>
                                @endif

                                <?php
                                    $countPhoto++;

                                    if($photoData->Selected == 1){
                                        $selectedPhoto = $photoData->Id;
                                    }
                                ?>
                            @endforeach

                            <div id="hiddenImageArea" style="display:none">
                                <div class="col-md-2" style="margin-bottom:10px;">
                                    <select name="photoColor[]" class="form-control">
                                        <option value="">Pilih Warna</option>
                                        @foreach($color as $color2)
                                            <option value="{{$color2->Id}}">{{$color2->Name}}</option>
                                        @endforeach
                                    </select>

                                    <img src="" class="photoClick" style="width:100%;height:160px;cursor:pointer" />
                                    <div class="text-center chosenPhoto" style="display:none;background-color:#C5C4CA;border:solid #86142B 2px;border-top:none">
                                        <b>Foto Utama</b>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <btn class="btn btn-primary form-control" style="margin-top:0px;height:20px;width:30px;padding:0px;padding-left:4px"><span class="fa fa-pencil"></span></btn>
                                        </div>

                                        <div class="col-md-6">
                                            <btn class="btn btn-danger form-control" style="height:20px;width:30px;padding:0px;padding-left:4px;margin-right:0px;margin-left:7px"><span class="fa fa-trash"></span></btn>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($selectedPhotoId != null)
                            <input type="hidden" value="{{$selectedPhotoId}}" name="wasSelectedPhotoId" />
                        @endif

                        <input type="hidden" id="selectedPhotoId" name="selectedPhotoId" />

                        <div class="clear row"></div>
                        <input type="file" id="productImage" class="form-control" style="display:none"/>
                        <span id="btnProductImage">
                            <button class="btn btn-success" style="margin-top:-10px"><span class="fa fa-camera"></span> Tambah Gambar</button>
                        </span>

                        {{-- <input type="hidden" name="file_upload_list" id="file_upload_list">
                        <div id="UploadFile" style="margin-top:-30px">Browse</div> --}}
                    </div>
                </div>

                <div class="form-group">
                    <label for="sendMaterialType" class="col-md-2 control-label">Nama Produk</label>

                    <div class="col-md-10">
                        <input id="productName" name="productName" type="text" class="form-control" required value="{{$product['name']}}" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="sendMaterialType" class="col-md-2 control-label">Kategori</label>

                    <div class="col-md-10">
                        <select id="productCategory" name="productCategory" class="form-control" required>
                            <option value="">--- Pilih Kategori ---</option>

                            @foreach($category as $categoryData)
                                <option value="{{$categoryData->Id}}" @if($product['categoryId'] == $categoryData->Id) selected @endif >{{$categoryData->Name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="sendMaterialType" class="col-md-2 control-label">Gender</label>

                    <div class="col-md-10">
                        <select id="productGender" name="productGender" class="form-control" required>
                            <option value="">--- Pilih Gender ---</option>

                            @foreach($gender as $genderData)
                                <option value="{{$genderData->Id}}" @if($product['genderId'] == $genderData->Id) selected @endif >{{$genderData->Name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-12 pull-right" style="background-color:#ffffff;margin-top:20px">
                <div class="row clear" style=""></div>

                <div class='col-md-12'>
                    <h4 style="font-weight:bold">#Harga</h4>
                    <hr style="margin-top:-5px">
                </div>

                <div class="form-group">
                    <label for="sendMaterialType" class="col-md-2 control-label">Harga Awal</label>

                    <div class="col-md-10">
                        <input id="productPrice" type="text" class="form-control" required value="{{$product['oldPrice']}}"/>
                        <input id="productPriceHidden" name="productPrice" type="hidden" value="{{$product['oldPrice']}}" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="sendMaterialType" class="col-md-2 control-label">Diskon</label>

                    <div class="col-md-10">
                        <input type="checkbox" id="productIsDiscount" name="productIsDiscount" value="1" style="margin-top:11px" @if($product['discountType'] != null) checked @endif> Ya
                    </div>
                </div>

                <div class="form-group" id="discountArea">
                    <label for="sendMaterialType" class="col-md-2 control-label">Jumlah Diskon</label>

                    <div class="col-md-10 row">
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
                </div>

                <div class="form-group">
                    <label for="sendMaterialType" class="col-md-2 control-label">Harga Akhir</label>

                    <div class="col-md-10">
                        <input id="productFinalPrice" type="text" class="form-control" required value="{{$product['newPrice']}}" disabled/>
                        <input id="productFinalPriceHidden" name="productFinalPrice" type="hidden" value="{{$product['newPrice']}}" />
                    </div>
                </div>
            </div>

            <div class="col-md-12 pull-right" style="background-color:#ffffff;margin-top:20px">
                <div class="row clear" style=""></div>

                <div class='col-md-12'>
                    <h4 style="font-weight:bold">#Deskripsi Produk</h4>
                    <hr style="margin-top:-5px">
                </div>

                <div class="form-group">
                    <label for="sendMaterialType" class="col-md-2 control-label">Deskripsi</label>

                    <div class="col-md-10">
                        <textarea id="productDescription" name="productDescription" rows="4" class="form-control" style="resize:none;" required>{{$product['description']}}</textarea>
                    </div>
                </div>
            </div>

            <div class="col-md-12 pull-right" style="background-color:#ffffff;margin-top:20px;margin-bottom:20px">
                <div class="form-group">
                    <div class="col-md-12 text-right" style="margin-top:20px">
                        <a href="/product/list" type="button" class="btn btn-default"><span class="fa fa-close"></span> Batal</a>
                        <button type="submit" class="btn btn-success" form="addForm"><span class="fa fa-save"></span> Simpan</button>
                    </div>
                </div>
            </div>
        </form>
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

            calculateFinalPrice();
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
            var number = $(this).val().split('.').join("");
            number = number.replace(/Rp /gi,'');
            $('#productDiscountValHidden').val(number);

            calculateFinalPrice();
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
            $('#productFinalPrice').val($('#productPrice').val());
            $('#productFinalPriceHidden').val($('#productPriceHidden').val());
        });

        function calculateFinalPrice(){
            $('#productDiscountValHidden').val();
            $('#productDiscountType').val();
            $('#productFinalPrice').val();
            $('#productFinalPriceHidden').val();

            var price = $('#productPriceHidden').val();
            var discount = $('#productDiscountValHidden').val();
            if($('#productDiscountType').val() == 'Price'){
                price = price - discount;
                $('#productFinalPriceHidden').val(price);
                $('#productFinalPrice').val(price);
            } else if($('#productDiscountType').val() == 'Percent'){
                discount = price * discount/100;
                price = price - discount;
                $('#productFinalPriceHidden').val(price);
                $('#productFinalPrice').val(price);
            }

            $('#productPrice, #productFinalPrice').priceFormat({
                prefix: 'Rp ',
                centsLimit: 0,
                thousandsSeparator: '.'
            });
        }

        $(document).on('click', "img.photoClick", function() {
            $( ".photoClick" ).each(function( index ) {
                $(this).css({'border': 'none'});
            });

            $( ".chosenPhoto" ).each(function( index ) {
                $(this).hide();
            });

            var id = this.id;
            id = id.substring(11);
            $(this).css({'border': 'solid #86142B 2px'});
            $('#chosenPhoto_'+id).show();
            $('#selectedPhotoId').val(id);
        });

        $('#btnProductImage').click(function(){
            $('#productImage').click();
            return false;
        });

        var newImage = 1;
        var countPhoto = {{$countPhoto}};
        $('#productImage').change(function(e){
            if (this.files && this.files[0]) {
                var formData = new FormData();
                formData.append("file", this.files[0]);
                $.ajax({
    		        type: "POST",
    		        url: "/product/image/upload",
                    data: formData,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
    		        success: function(data) {
                        $('#hiddenImageArea .photoClick').attr('src', "{{url('/')}}/storage/app/"+data);
                        $('#hiddenImageArea .photoClick').attr('id', 'photoClick_new'+newImage);
                        $('#hiddenImageArea .chosenPhoto').attr('id', 'chosenPhoto_new'+newImage);
                        newImage++;
                        $('#imageListPreview').append($('#hiddenImageArea').html());
                        $('#hiddenImageArea .photoClick').attr('id', '');
                        $('#hiddenImageArea .chosenPhoto').attr('id', '');

                        if(countPhoto == 6){
                            $('#imageListPreview').append('<div class="row clear" style="margin-bottom:20px;"></div>');
                            countPhoto = 0;
                        }

                        countPhoto++;
    		        }
    		    });
            }
        });
	});
</script>

@endsection
