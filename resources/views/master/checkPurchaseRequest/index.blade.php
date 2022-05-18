
@extends('layouts.home_master')

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

@section('judul')
Cek Selesai Nota
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Cek Selesai Nota</li>
<li class="breadcrumb-item active">Permintaan Pembelian</li>
@endsection

@section('content')
<div class="container-fluid">
        <h2 class="text-center display-4">Cari NPP</h2>
        <div class="row">
            <div class="col-md-8 offset-md-2">
            <form action="/checkPurchaseRequeste/searchname/" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" name="searchname" placeholder="Nama NPP">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</div>
<div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
            <form action="/checkPurchaseRequeste/searchdate/" method="get">
                <label>Tanggal Pembuatan Awal - Akhir:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                    </div>
                    <input type="text" name="dateRangeSearch" class="form-control float-right" id="reservation" value="{{old('tanggalDibutuhkan','')}}" >
                    <button type="submit" class="btn btn-lg btn-default">
                    <i class="fa fa-search"></i>
                    </button>
                </div>                           
            </form>
        </div>
    </div>
</div>
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Permintaan Pembelian</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Proses</th>
                                <th scope="col">Handle</th>
                                </tr>
                            </thead>
                              <tbody>
                                @foreach($data as $purchaseRequest)
                                <tr >
                                    <th scope="row" name='id'>{{$purchaseRequest->id}}</th>
                                    <td>{{$purchaseRequest->name}}</td>
                                    <td>{{$purchaseRequest->tanggalDibuat}}</td>
                                    @if($purchaseRequest->proses==0)
                                    <td>Belum diproses</td>
                                    @elseif($purchaseRequest->proses==1)
                                    <td>Sedang diproses</td>
                                    @elseif($purchaseRequest->proses==2)
                                    <td>Selesai</td>
                                    @endif
                                    <td>
                                    <a href="{{route('checkPurchaseRequest.edit',[$purchaseRequest->id])}}" class="btn btn-primary btn-responsive">Cek Update</a>
                                    </td>
                                </tr>
                                @endforeach
                            
                            </tbody>
                        <tfoot>
                             <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Proses</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
{{ $data->links('pagination::bootstrap-4') }}
@endsection
