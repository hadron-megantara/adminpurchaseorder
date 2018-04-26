@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="content">
        <div class="page-title">
            <h3>Master - Info</h3>
        </div>

        <div class="row clear" style="margin-bottom:20px"></div>

        <div class="col-md-12" style="background-color:#ffffff;padding-top:30px;padding-bottom:30px">
            @if(session('success'))
                <div class="panel panel-success" style="margin-bottom:20px">
                    <div class="panel-heading notification text-center">
                        {{session('success')}}
                    </div>
                </div>
            @endif

            <div class="col-md-3 text-center">
                <label style="font-weight:bold;font-size:16px">Logo</label>
                <img id="companyLogoImage" src="{{$owner->Logo}}" style="width:100%;height:200px;margin-bottom:20px"/>

                <input type="file" id="companyLogo" class="form-control" style="display:none"/>
                <span id="btnCompanyLogo" class="text-center">
                    <button class="btn btn-success" style="margin-top:-10px"><span class="fa fa-camera"></span> Upload Gambar</button>
                </span>
            </div>

            <div class="col-md-9">
                <form class="form-horizontal" method="POST" action="{{ route('config.info.edit') }}" role="form" id="editForm">
                    {!! csrf_field() !!}
                    <input type="hidden" id="logoPath" name="logoPath" />

                    <label class="col-md-12">Nama Perusahaan</label>

                    <div class="col-md-12">
                        <input type="text" name="companyName" class="form-control" value="{{$owner->Name}}" placeholder="Masukkan Nama Perusahaan"/>
                    </div>

                    <div class="row clear" style="margin-bottom:15px"></div>

                    <label class="col-md-12">Alamat</label>

                    <div class="col-md-12">
                        <textarea class="form-control" name="companyAddress" value="{{$owner->Phone}}" placeholder="Masukkan Nomor HP/Telepon" rows="4" style="resize:none">{{$owner->Address}}</textarea>
                    </div>

                    <div class="row clear" style="margin-bottom:15px"></div>

                    <label class="col-md-12">HP/Telepon</label>

                    <div class="col-md-12">
                        <input type="text" class="form-control" name="companyPhone" value="{{$owner->Phone}}" placeholder="Masukkan Nomor HP/Telepon"/>
                    </div>

                    <div class="row clear" style="margin-bottom:30px"></div>

                    <div class="col-md-12">
                        <div class="pull-right">
                            <button class="btn btn-default" style="width:120px;height:40px"><span class="fa fa-close"></span> Batal</button>
                            <button type="submit" class="btn btn-primary" style="width:120px;height:40px"><span class="fa fa-save"></span> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
	    </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
        $('#btnCompanyLogo').click(function(){
            $('#companyLogo').click();
            return false;
        });

        $('#companyLogo').change(function(e){
            if (this.files && this.files[0]) {
                var formData = new FormData();
                formData.append("file", this.files[0]);
                $.ajax({
    		        type: "POST",
    		        url: "/config/info/logo/upload",
                    data: formData,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
    		        success: function(data) {
                        $('#companyLogoImage').attr('src', "{{url('/')}}/storage/app/"+data);
                        $('#logoPath').val(data);
    		        }
    		    });
            }
        });
	});
</script>

@endsection
