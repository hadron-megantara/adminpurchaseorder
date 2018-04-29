@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Detail Pemesanan - {{$order->orderCode}}</h3>
        </div>

        <div class="row"></div>

        @if(session('success'))
            <div class="panel panel-success">
                <div class="panel-heading notification text-center">
                    {{session('success')}}
                </div>
            </div>
        @endif

        <div class="col-md-12" style="background-color:#ffffff;padding-top:30px;margin-bottom:50px">
            <div class="col-md-8">
                <label class="col-md-12" style="font-size:18px"><strong>Data Pemesanan</strong></label>

                <div class="row clear" style="margin-bottom: 5px"></div>

                <label class="col-md-4">Kode Pemesanan</label>
                <label class="col-md-8"><strong style="color:red">{{$order->orderCode}}</strong></label>

                <label class="col-md-4">Kode Transaksi</label>
                <label class="col-md-8">{{$order->transactionCode}}</label>

                <label class="col-md-4">Nominal</label>
                <label class="col-md-8">Rp {{number_format($order->finalPrice,0,",",".")}}</label>

                <div class="row clear" style="margin-bottom: 15px"></div>

                <hr style="margin-top:0px;margin-bottom:15px">

                <label class="col-md-12" style="font-size:18px"><strong>Data Penerima</strong></label>

                <div class="row clear" style="margin-bottom: 5px"></div>

                <label class="col-md-4">Nama Penerima</label>
                <label class="col-md-8">{{$order->fullname}}</label>

                <label class="col-md-4">No HP/Telepon</label>
                <label class="col-md-8">{{$order->phone}}</label>

                <label class="col-md-4">Alamat Penerima</label>
                <label class="col-md-8">{{$order->address}}, {{$order->districtName}}, {{$order->cityName}}, {{$order->provinceName}} @if($order->postCode != null) - {{$order->postCode}} @endif</label>
            </div>

            <div class="col-md-4">
                <div class="stepStatus" style="border:2px solid #E1E6E9;border-top:none;border-right:none">
                    <label class="col-md-12" style="font-size:18px"><strong>Status Pemesanan</strong></label>

                    <div class="row clear" style="margin-bottom: 15px"></div>

                    @if($order->status != 5)
                        @if($order->status == 0)
                            <label class="col-md-12" style="background:#DFF0D8;border:2px solid #3C763D">
                        @else
                            <label class="col-md-12" style="background:#DFF0D8">
                        @endif
                            Pemesanan Masuk
                            <span class="pull-right"><span class="fa fa-check"></span></span>
                        </label>
                    @else
                        <label class="col-md-12" style="background:#F2DEDE">
                            Pemesanan Masuk
                            <span class="pull-right"><span class="fa fa-check"></span></span>
                        </label>
                    @endif

                    @if($order->status != 5)
                        @if($order->status == 0)
                            <label class="col-md-12" style="background:#FCF8E3">
                                Pemesanan Telah Dibayar
                                <span class="pull-right"><span class="fa fa-minus"></span></span>
                            </label>
                        @elseif($order->status == 1)
                            <label class="col-md-12" style="background:#DFF0D8;border:2px solid #3C763D">
                                Pemesanan Telah Dibayar
                                <span class="pull-right"><span class="fa fa-check"></span></span>
                            </label>
                        @else
                            <label class="col-md-12" style="background:#DFF0D8">
                                Pemesanan Telah Dibayar
                                <span class="pull-right"><span class="fa fa-check"></span></span>
                            </label>
                        @endif
                    @else
                        <label class="col-md-12" style="background:#F2DEDE">
                            Pemesanan Telah Dibayar
                            <span class="pull-right"><span class="fa fa-close"></span></span>
                        </label>
                    @endif

                    @if($order->status != 5)
                        @if($order->status == 0 || $order->status == 1)
                            <label class="col-md-12" style="background:#FCF8E3">
                                Pemesanan Telah Diproses
                                <span class="pull-right"><span class="fa fa-minus"></span></span>
                            </label>
                        @elseif($order->status == 2)
                            <label class="col-md-12" style="background:#DFF0D8;border:2px solid #3C763D">
                                Pemesanan Telah Diproses
                                <span class="pull-right"><span class="fa fa-check"></span></span>
                            </label>
                        @else
                            <label class="col-md-12" style="background:#DFF0D8">
                                Pemesanan Telah Diproses
                                <span class="pull-right"><span class="fa fa-check"></span></span>
                            </label>
                        @endif
                    @else
                        <label class="col-md-12" style="background:#F2DEDE">
                            Pemesanan Telah Diproses
                            <span class="pull-right"><span class="fa fa-close"></span></span>
                        </label>
                    @endif

                    @if($order->status != 5)
                        @if($order->status == 0 || $order->status == 1 || $order->status == 2)
                            <label class="col-md-12" style="background:#FCF8E3">
                                Pemesanan Telah Dikirim
                                <span class="pull-right"><span class="fa fa-minus"></span></span>
                            </label>
                        @elseif($order->status == 3)
                            <label class="col-md-12" style="background:#DFF0D8;border:2px solid #3C763D">
                                Pemesanan Telah Dikirim
                                <span class="pull-right"><span class="fa fa-check"></span></span>
                            </label>
                        @else
                            <label class="col-md-12" style="background:#DFF0D8">
                                Pemesanan Telah Dikirim
                                <span class="pull-right"><span class="fa fa-check"></span></span>
                            </label>
                        @endif
                    @else
                        <label class="col-md-12" style="background:#F2DEDE">
                            Pemesanan Telah Dikirim
                            <span class="pull-right"><span class="fa fa-close"></span></span>
                        </label>
                    @endif

                    @if($order->status != 5)
                        @if($order->status == 0 || $order->status == 1 || $order->status == 2 || $order->status == 3)
                            <label class="col-md-12" style="background:#FCF8E3">
                                Pemesanan Telah Sampai
                                <span class="pull-right"><span class="fa fa-minus"></span></span>
                            </label>
                        @elseif($order->status == 4)
                            <label class="col-md-12" style="background:#DFF0D8;border:2px solid #3C763D">
                                Pemesanan Telah Sampai
                                <span class="pull-right"><span class="fa fa-check"></span></span>
                            </label>
                        @endif
                    @else
                        <label class="col-md-12" style="background:#F2DEDE">
                            Pemesanan Telah Sampai
                            <span class="pull-right"><span class="fa fa-close"></span></span>
                        </label>
                    @endif

                    @if($order->status == 5)
                        <label class="col-md-12" style="background:#F2DEDE">
                            Pemesanan Batal
                            <span class="pull-right"><span class="fa fa-check"></span></span>
                        </label>
                    @else
                        @if($order->status == 0)
                            <label class="col-md-12" style="background:#FCF8E3">
                                Pemesanan Batal
                                <span class="pull-right"><span class="fa fa-minus"></span></span>
                            </label>
                        @endif
                    @endif

                    <div class="row clear" style="margin-bottom: 15px"></div>
                </div>

                <div class="row clear" style="margin-bottom: 15px"></div>

                @if($order->status != 4 && $order->status != 5)
                    <?php
                        if($order->status == 0){
                            $verificateMsg = "Tandai Telah Dibayar";
                        } else if($order->status == 1){
                            $verificateMsg = "Tandai Telah Diproses";
                        } else if($order->status == 2){
                            $verificateMsg = "Tandai Telah Dikirim";
                        } else if($order->status == 3){
                            $verificateMsg = "Tandai Telah Sampai";
                        }
                    ?>

                    <form class="form-horizontal" method="POST" action="/order/detail/{{$order->orderCode}}/update" role="form" id="addForm">
                        {!! csrf_field() !!}

                        <?php
                            $status = 5;

                            if($order->status == 0){
                                $status = 1;
                            } else if($order->status == 1){
                                $status = 2;
                            } else if($order->status == 2){
                                $status = 3;
                            } else if($order->status == 3){
                                $status = 4;
                            }
                        ?>
                        <button type="submit" class="btn btn-primary" value="{{$status}}" name="status"><span class="fa fa-check"></span> {{$verificateMsg}}</button>
                    </form>

                    @if($order->status == 2)
                        <button type="submit" class="btn btn-success"><span class="fa fa-print"></span> Print</button>
                    @endif
                @endif
            </div>

            <div class="row clear" style="margin-bottom: 15px"></div>

            <div class="col-md-12">
                <hr style="margin-top:0px;margin-bottom:15px">

                <label class="col-md-12" style="font-size:18px"><strong>Produk Yang Dipesan</strong></label>
                <div class="row clear" style="margin-bottom: 15px"></div>

                <div class="col-md-12">
                    @foreach($order->products as $product)
                        <div class="col-md-3" style="border:2px solid #DDE2E6;padding:10px">
                            <img src="{{env('API_BASE_URL')}}app/images/{{$product->productPhoto}}" style="width:100%;height:270px" />
                            <label style="margin-top:5px;font-size:16px"><strong>{{$product->productName}}</strong></label>
                            <label><strong>Warna :</strong> {{$product->productColor}}</label>
                            <label><strong>Ukuran :</strong> {{$product->productSize}}</label>
                            <label><strong>Jumlah :</strong> {{$product->productTotal}}</label>
                            <label><strong>Harga /pcs :</strong> Rp {{number_format($product->productPrice,0,",",".")}}</label>
                            <label><strong>Harga Total :</strong> Rp {{number_format($product->productTotalPrice,0,",",".")}}</label>
                        </div>
                    @endforeach
                </div>

                <div class="row clear" style="margin-bottom: 15px"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){

	});
</script>

@endsection
