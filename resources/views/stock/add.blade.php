@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Detail Produk</h3>
        </div>

        <form class="form-horizontal" method="POST" action="{{ route('product.list.addProcess') }}" role="form" id="addForm" enctype="multipart/form-data">
            {!! csrf_field() !!}

            <div class="col-md-12" style="background-color:#ffffff;">
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
                            <div id="hiddenImageArea" style="display:none">
                                <div class="col-md-2 photoAreaSub" style="margin-bottom:10px;">
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
                                        <div class="col-md-12 text-center">
                                            <btn class="btn btn-danger form-control deletePhotoBtn" style="height:20px;width:30px;padding:0px;padding-left:4px;margin-right:0px;margin-left:7px"><span class="fa fa-trash"></span></btn>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" class="photoPathHidden" name="photoPath[]" />
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
                        <input id="productName" name="productName" type="text" class="form-control" required />
                    </div>
                </div>

                <div class="form-group">
                    <label for="sendMaterialType" class="col-md-2 control-label">Kategori</label>

                    <div class="col-md-10">
                        <select id="productCategory" name="productCategory" class="form-control" required>
                            <option value="">--- Pilih Kategori ---</option>

                            @foreach($category as $categoryData)
                                <option value="{{$categoryData->Id}}" >{{$categoryData->Name}}</option>
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
                                <option value="{{$genderData->Id}}" >{{$genderData->Name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="background-color:#ffffff;margin-top:20px">
                <div class='col-md-12'>
                    <h4 style="font-weight:bold">#Harga</h4>
                    <hr style="margin-top:-5px">
                </div>

                <div class="form-group">
                    <label for="sendMaterialType" class="col-md-2 control-label">Harga Awal</label>

                    <div class="col-md-10">
                        <input id="productPrice" type="text" class="form-control" required />
                        <input id="productPriceHidden" name="productPrice" type="hidden" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="sendMaterialType" class="col-md-2 control-label">Diskon</label>

                    <div class="col-md-10">
                        <input type="checkbox" id="productIsDiscount" name="productIsDiscount" value="1" style="margin-top:11px"> Ya
                    </div>
                </div>

                <div class="form-group" id="discountArea" style="display:none">
                    <label for="sendMaterialType" class="col-md-2 control-label">Jumlah Diskon</label>

                    <div class="col-md-10 row">
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="productDiscountVal" />
                            <input type="hidden" class="form-control" name="productDiscountVal" id="productDiscountValHidden" />
                        </div>

                        <div class="col-md-4">
                            <select id="productDiscountType" name="productDiscountType" class="form-control" required>
                                @foreach($discountType as $discountType2)
                                    <option value="{{$discountType2->Id}}" >{{$discountType2->Type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row clear" style="margin-bottom:20px"></div>

                    <label for="discountStartDt" class="col-md-2 control-label">Tanggal Mulai</label>

                    <div class="col-md-4 row">
                        <div class="col-md-12">
                            <input type="text" id="discountStartDt" name="discountStartDt" class="form-control" placeholder="Pilih Tanggal" style="position: relative; z-index: 100" />
                        </div>
                    </div>

                    <label for="discountStartHour" class="col-md-2 control-label">Jam</label>

                    <div class="col-md-4 row">
                        <div class="col-md-5">
                            <input type="number" id="discountStartHour" name="discountStartHour" class="form-control" placeholder="00" value="00" />
                        </div>

                        <label for="discountStartHour" class="col-md-1 control-label">:</label>

                        <div class="col-md-5">
                            <input type="number" id="discountStartMin" name="discountStartMin" class="form-control" placeholder="00" value="00" />
                        </div>
                    </div>

                    <div class="row clear" style="margin-bottom:20px"></div>

                    <label for="discountEndDt" class="col-md-2 control-label">Tanggal Selesai</label>

                    <div class="col-md-4 row">
                        <div class="col-md-12">
                            <input type="text" id="discountEndDt" name="discountEndDt" class="form-control" placeholder="Pilih Tanggal" style="position: relative; z-index: 100" />
                        </div>
                    </div>

                    <label for="discountEndHour" class="col-md-2 control-label">Jam</label>

                    <div class="col-md-4 row">
                        <div class="col-md-5">
                            <input type="number" id="discountEndHour" name="discountEndHour" class="form-control" placeholder="00" value="00" />
                        </div>

                        <label for="discountEndHour" class="col-md-1 control-label">:</label>

                        <div class="col-md-5">
                            <input type="number" id="discountEndMin" name="discountEndMin" class="form-control" placeholder="00" value="00" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="sendMaterialType" class="col-md-2 control-label">Harga Akhir</label>

                    <div class="col-md-10">
                        <input id="productFinalPrice" type="text" class="form-control" required disabled/>
                        <input id="productFinalPriceHidden" name="productFinalPrice" type="hidden" />
                    </div>
                </div>
            </div>

            <div class="col-md-12 pull-right" style="background-color:#ffffff;margin-top:20px">
                <div class='col-md-12'>
                    <h4 style="font-weight:bold">#Deskripsi Produk</h4>
                    <hr style="margin-top:-5px">
                </div>

                <div class="form-group">
                    <label for="sendMaterialType" class="col-md-2 control-label">Deskripsi</label>

                    <div class="col-md-10">
                        <textarea id="productDescription" name="productDescription" rows="4" class="form-control" style="resize:none;" required></textarea>
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
            if($('#productDiscountType').val() == '2'){
                $('#productDiscountVal').priceFormat({
                    prefix: 'Rp ',
                    centsLimit: 0,
                    thousandsSeparator: '.'
                });
            } else if($('#productDiscountType').val() == '1'){
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
            if($('#productDiscountType').val() == '2'){
                price = price - discount;
                $('#productFinalPriceHidden').val(price);
                $('#productFinalPrice').val(price);
            } else if($('#productDiscountType').val() == '1'){
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
                        $('#hiddenImageArea .photoPathHidden').val(data);
                        $('#hiddenImageArea .photoPathHidden').attr('id', 'photoPathHidden'+newImage);
                        $('#hiddenImageArea .deletePhotoBtn').attr('id', 'deletePhotoBtn'+newImage);
                        $('#hiddenImageArea .photoAreaSub').attr('id', 'photoAreaSub'+newImage);

                        newImage++;

                        $('#imageListPreview').append($('#hiddenImageArea').html());
                        $('#hiddenImageArea .photoClick').attr('id', '');
                        $('#hiddenImageArea .chosenPhoto').attr('id', '');
                        $('#hiddenImageArea .photoPathHidden').attr('id', '');
                        $('#hiddenImageArea .deletePhotoBtn').attr('id', '');
                        $('#hiddenImageArea .photoAreaSub').attr('id', '');

                        if(countPhoto == 6){
                            $('#imageListPreview').append('<div class="row clear" style="margin-bottom:20px;"></div>');
                            countPhoto = 0;
                        }

                        countPhoto++;
    		        }
    		    });
            }
        });

        $(document).on('click', ".deletePhotoBtn", function() {
            var id = this.id;
            id = id.substring(14);

            $.ajax({
                url: '{{ route('product.image.remove') }}',
                method: "POST",
                dataType: "json",
                data: { name: $('#photoPathHidden'+id).val()},
            });

            $('#photoAreaSub'+id).remove();
            if($('#selectedPhotoId').val() == 'new'+id){
                $('#selectedPhotoId').val('');
            }
        });

        $('#discountStartDt').datepicker({
            dateFormat: 'yy-mm-dd',
            regional: 'id',
            orientation: "auto",
            minDate : 'now',
            changeYear: true,
            onClose: function() {
                $("#discountEndDt").datepicker(
                        "change",
                        { minDate: new Date($('#discountStartDt').val()) }
                );
            }
        });

        $('#discountEndDt').datepicker({
            dateFormat: 'yy-mm-dd',
            regional: 'id',
            orientation: "auto",
            minDate : 'now',
            changeYear: true,
            onClose: function() {
                $("#discountStartDt").datepicker(
                        "change",
                        { maxDate: new Date($('#discountEndDt').val()) }
                );
            }
        });

        // $('#discountStartHour, #discountStartMin').change(function(){
        //     if($(this).val() == '' || parseInt($(this).val()) < 0){
        //         $(this).val('00');
        //     }
        // });

        $("#discountStartHour, #discountStartMin").keypress(function (e) {
            if (e.which < 48 || 57 < e.which)
                e.preventDefault();
        });

        $("#discountStartHour").change(function (e) {
            if($(this).val() < 0){
                $(this).val('00');
            } else if($(this).val() > 24){
                $(this).val('1');
            }
        });

        $("#discountStartMin, #discountEndHour").change(function (e) {
            if($(this).val() < 0){
                $(this).val('00');
            } else if($(this).val() > 59){
                $(this).val('1');
            }
        });

        $("#discountStartMin, #discountEndMin").change(function (e) {
            if($.isNumeric($('#discountStartMin').val()) === false){
                $(this).val('00');
            }
        });

        $('#discountStartHour, #discountStartMin, #discountEndHour, #discountEndMin').click(function(){
            $(this).select();
        });
	});
</script>

@endsection
