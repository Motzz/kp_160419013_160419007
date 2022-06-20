@extends('layouts.home_master')
<style>
            p {
                font-family: 'Nunito', sans-serif;
            }
 </style>

@section('judul')
Edit item Transaksi
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Master</li>
<li class="breadcrumb-item"><a href="{{route('itemTransaction.index')}}">item Transaksi</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection
@section('content')
<div class="container-fluid">

<!-- Page Heading -->
<div class="card card-primary">
    <!-- form start -->
    <form action="{{route('itemTransaction.update',[$itemTransaction->ItemTransactionID])}}" method="POST" >
                @csrf
                @method('PUT')
        <div class="card-body">

            <div class="form-group">
                <label for="title">Nama Item Transaction</label>
                <input require type="text" name="Name" class="form-control" 
                value="{{old('Name',$itemTransaction->Name)}}" >
            </div>

            <div class="form-group">
                <label for="title">Kode</label>
                <input require type="text" name="Code" class="form-control" 
                value="{{old('Code',$itemTransaction->Code)}}" >
            </div>

            <div class="form-group">
                <label for="title">Deskripsi</label>
                <input require type="text" name="Description" class="form-control" 
                value="{{old('Description',$itemTransaction->Description)}}" >
            </div>



        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection
