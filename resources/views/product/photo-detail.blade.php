@extends('layouts.app')

@section('content')

<style>
    .photoClick{
        cursor: pointer;
    }
</style>

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Detail Produk</h3>
        </div>

        <div class="col-md-12 pull-right" style="background-color:#ffffff;">
            <div class="row">
                <a href="/product/detail/{{$productId}}" class="col-md-6 text-center" style="background:#DADADA;border:solid 1px">
                    <span class="" style="font-size:16px; font-weight:bold">Keterangan Produk</span>
                </a>

                <a href="/product/photo-detail/{{$productId}}" class="col-md-6 text-center" style="background:#ffffff;border:solid 1px;border-bottom:none">
                    <span class="" style="font-size:16px; font-weight:bold">Foto Produk</span>
                </a>
            </div>

            <div class="row clear" style="margin-bottom:30px"></div>

            <div class="col-md-12">
                * Keterangan : Foto yang di border merah akan menjadi foto yang ditampilkan di List Produk Halaman utama
            </div>

            <div class="row clear" style="margin-bottom:10px"></div>

            <?php
                $countPhoto = 1;
                $selectedPhoto = 0;
            ?>

            @foreach($photo as $photoData)
                <div class="col-md-4">
                    <select name="photoColor[]" class="form-control">
                        <option value="">--- Pilih Warna ---</option>
                        @foreach($color as $color2)
                            <option value="{{$color2->Id}}" @if($color2->Id == $photoData->_Color) selected @endif>{{$color2->Name}}</option>
                        @endforeach
                    </select>

                    @if($photoData->Selected == 1)
                        <img src="{{$photoData->Photo}}" class="photoClick" id="photoClick_{{$photoData->Id}}" style="width:100%;border:solid red 2px" />
                    @else
                        <img src="{{$photoData->Photo}}" class="photoClick" id="photoClick_{{$photoData->Id}}" style="width:100%;" />
                    @endif
                </div>

                @if($countPhoto == 3)
                    <div class="row clear" style="margin-bottom:50px;"></div>
                    <?php $countPhoto = 0; ?>
                @endif

                <?php
                    $countPhoto++;

                    if($photoData->Selected == 1){
                        $selectedPhoto = $photoData->Id
                    }
                ?>
            @endforeach
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
        $('.photoClick').click(function(){
            $( ".photoClick" ).each(function( index ) {
                $(this).css({'border': 'none'});
            });

            $(this).css({'border': 'solid red 2px'});
        });
	});
</script>

@endsection
