@extends('layouts.home_master')
<style>
            p {
                font-family: 'Nunito', sans-serif;
            }
 </style>

@section('judul')
Edit Tag Gudang
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Master</li>
<li class="breadcrumb-item"><a href="{{route('tagMGudang.index')}}">Tag-Gudang</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="container-fluid">

<!-- Page Heading -->
<div class="card card-primary">
    <!-- form start -->
    <form action="{{route('tagMGudang.update',[$mGudang->MGudangID])}}" method="POST" >
        @csrf
        @method('PUT')
        <div class="card-body">

            <div class="form-group">
                <label for="title">Nama Gudang</label>
                <input disabled type="text" name="cid" maxlength="5" class="form-control" 
                value="{{old('cidpulau',$mGudang->cname)}}">
            </div>
            <div class="form-group">
                <label>Multiple</label>
                    <select name="gudangAreaSimpan[]" class="select2" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                        @foreach($data as $d)
                            <option id="tagnya{{$d->MGudangAreaSimpanID}}" value="{{$d->MGudangAreaSimpanID}}"{{$d->cname == $d->MGudangAreaSimpanID? 'selected' :'' }}>{{$d->cname}}</option>    
                         @endforeach
                    </select>
            </div>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>

<script type="text/javascript">
$(document).ready(function() {
    var dataTag = <?php echo json_encode($dataTag); ?>;
    $.each(dataTag, function( key, value ){
        $("#tagnya"+value.MGudangAreaSimpanID).prop('selected',true)
    });
});
</script>
@endsection
