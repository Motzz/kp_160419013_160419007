@extends('layouts.home_master')
<style>
    p {
        font-family: 'Nunito', sans-serif;
    }
</style>

@section('judul')
Ubah Nota Terima Barang Pesanan
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Nota</li>
<li class="breadcrumb-item"><a href="{{route('terimaBarangPesanan.index')}}">Terima Barang Pesanan</a></li>
<li class="breadcrumb-item active">Ubah</li>
@endsection

@section('content')
<form action="{{route('terimaBarangPesanan.update', [$transactionGudangBarang->id])}}" method="POST">
    @csrf
    @method('PUT')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!--<div class="callout callout-info">
              <h2>Pembuatan Nota Permintaan Pembelian</h2><br>
            </div>


             Main content -->
                    <div class="invoice p-2 mb-3">

                        <!-- /.row -->

                        <!-- isi row -->
                        <div class="row">
                            <div class="col-12 ">
                                <div class="py-5 ">

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="lastName">Tanggal Pembuatan</label>
                                            <input readonly name="tanggalDibuat" type="date" class="form-control" id="lastName" placeholder="" value="{{$transactionGudangBarang->tanggalDibuat}}" required="">
                                            <div class="invalid-feedback"> Valid last name is required. </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="lastName">Tanggal Datang</label>
                                            <input name="tanggalDatang" type="date" class="form-control" id="lastName" placeholder="" value="{{$transactionGudangBarang->tanggalDatang}}" required="">
                                            <div class="invalid-feedback"> Valid last name is required. </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lastName">Pilih Gudang Awal</label>
                                                <select class="form-control selectpicker" data-live-search="true" data-show-subtext="true" style="width: 100%;" id="idGudang" name="MGudangIDAwal">
                                                    <option value="">
                                                        --Pilih Gudang Awal--
                                                    </option>
                                                    @foreach($dataGudang as $key => $data)
                                                    @if($data->MGudangID == $transactionGudangBarang->MGudangIDAwal)
                                                    <option selected name="idGudang" singkatan="{{$data->ccode}}" value="{{$data->MGudangID}}" {{$data->cname == $data->MGudangID? 'selected' :'' }}>{{$data->cname}}</option>
                                                    @else
                                                    <option name="idGudang" singkatan="{{$data->ccode}}" value="{{$data->MGudangID}}" {{$data->cname == $data->MGudangID? 'selected' :'' }}>{{$data->cname}}</option>
                                                    @endif
                                                    @endforeach

                                                </select>
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lastName">Pilih Gudang Tujuan</label>
                                                <select class="form-control selectpicker" data-live-search="true" data-show-subtext="true" style="width: 100%;" id="idGudangTujuan" name="MGudangIDTujuan">
                                                    <option value="">
                                                        --Pilih Gudang Tujuan--
                                                    </option>
                                                    @foreach($dataGudang as $key => $data)
                                                    @if($data->MGudangID == $transactionGudangBarang->MGudangIDTujuan)
                                                    <option selected name="idGudang" singkatan="{{$data->ccode}}" value="{{$data->MGudangID}}" {{$data->cname == $data->MGudangID? 'selected' :'' }}>{{$data->cname}}</option>
                                                    @else
                                                    <!--<option name="idGudang" singkatan="{{$data->ccode}}" value="{{$data->MGudangID}}" {{$data->cname == $data->MGudangID? 'selected' :'' }}>{{$data->cname}}</option>-->
                                                    @endif
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lastName">Pilih Surat Jalan</label>
                                                <select class="form-control selectpicker" data-live-search="true" data-show-subtext="true" style="width: 100%;" id="SuratJalanID" name="SuratJalanID">


                                                    @foreach($suratJalan as $key => $data)
                                                    @if($data->MGudangIDTujuan == $transactionGudangBarang->MGudangIDTujuan)
                                                    @if($data->id == $transactionGudangBarang->SuratJalanID)
                                                    <option selected idPurchaseReq="{{$data->PurchaseRequestID}}" value="{{$data->id}}" {{$data->name == $data->id? 'selected' :'' }}>{{$data->name}} -{{date("d-m-Y", strtotime($data->tanggalDibuat))}}</option>
                                                    @else
                                                    <option idPurchaseReq="{{$data->PurchaseRequestID}}" value="{{$data->id}}" {{$data->name == $data->id? 'selected' :'' }}>{{$data->name}} -{{date("d-m-Y", strtotime($data->tanggalDibuat))}}</option>
                                                    @endif
                                                    @endif
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lastName">Data Nota Permintaan Pembelian</label>
                                                <select class="form-control selectpicker" data-live-search="true" data-show-subtext="true" style="width: 100%;" name="PurchaseRequestID" id="PurchaseRequestID">
                                                    @foreach($dataPurchaseRequest as $key => $data)
                                                    @if($data->MGudangID == $transactionGudangBarang->MGudangIDTujuan)
                                                    @if($data->id == $transactionGudangBarang->PurchaseRequestID)

                                                    <option selected value="{{$data->id}}" {{$data->name == $data->id? 'selected' :'' }}>{{$data->name}} -{{date("d-m-Y", strtotime($data->tanggalDibuat))}}</option>
                                                    @else
                                                    <option value="{{$data->id}}" {{$data->name == $data->id? 'selected' :'' }}>{{$data->name}} -{{date("d-m-Y", strtotime($data->tanggalDibuat))}}</option>
                                                    @endif
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lastName">Jenis Transaksi</label>
                                                <select class="form-control selectpicker" data-live-search="true" data-show-subtext="true" style="width: 100%;" name="ItemTransaction" readonly>
                                                    <option value="">
                                                        --Pilih Jenis Transaksi--
                                                    </option>
                                                    @foreach($dataItemTransaction as $key => $data)
                                                    @if($data->ItemTransactionID == $transactionGudangBarang->ItemTransactionID)
                                                    <option selected name="idItemTransaction" value="{{$data->ItemTransactionID}}" {{$data->Name == $data->ItemTransactionID? 'selected' :'' }}>{{$data->Name}}</option>
                                                    @else
                                                    <option name="idItemTransaction" value="{{$data->ItemTransactionID}}" {{$data->Name == $data->ItemTransactionID? 'selected' :'' }}>{{$data->Name}}</option>
                                                    @endif
                                                    @endforeach

                                                </select>
                                            </div>

                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="lastName">Keterangan Kendaraan</label>
                                            <textarea rows="3" type="text" name="keteranganKendaraan" class="form-control" value="{{old('keteranganKendaraan',$transactionGudangBarang->keteranganKendaraan)}}">{{$transactionGudangBarang->keteranganKendaraan}}</textarea>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="lastName">Keterangan Nomor Polisi</label>
                                            <textarea rows="3" type="text" name="keteranganNomorPolisi" class="form-control" value="{{old('keteranganNomorPolisi',$transactionGudangBarang->keteranganNomorPolisi)}}">{{$transactionGudangBarang->keteranganNomorPolisi}}</textarea>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="lastName">Keterangan Pengemudi</label>
                                            <textarea rows="3" type="text" name="keteranganPemudi" class="form-control" value="{{old('keteranganPemudi',$transactionGudangBarang->keteranganPemudi)}}">{{$transactionGudangBarang->keteranganPemudi}}</textarea>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="lastName">Keterangan Transaksi</label>
                                            <textarea rows="3" type="text" name="keteranganTransaksi" class="form-control" value="{{old('keteranganTransaksi',$transactionGudangBarang->keteranganTransaksi)}}">{{$transactionGudangBarang->keteranganTransaksi}}</textarea>
                                        </div>

                                    </div>
                                </div>
                                <!-- Page Heading -->
                                <div class="card card-primary">
                                    <!-- form start -->



                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="card card-danger">
                                                <div class="card-header">
                                                    <h3 class="card-title">Pemilihan Barang</h3>
                                                </div>
                                                <div class="card-body">

                                                    <div class="form-group" id='tmbhBarang'>
                                                        <label for="title">Barang</label>
                                                        <select class="form-control selectpicker" data-live-search="true" data-show-subtext="true" style="width: 100%;" name="barang" id="barang">

                                                            <option value="pilih">--Pilih barang--</option>
                                                            <!--@foreach($dataBarang as $key => $data)
                                        <option id="namaBarang" value="{{$data->ItemID}}"{{$data->ItemName == $data->ItemID? 'selected' :'' }}>{{$data->ItemName}}<nbsp>({{$data->unitName}})</option>
                                        @endforeach-->
                                                        </select>
                                                        <input id="jumlahBarang" value="1" min="0.01" type="number" step=".01" class="form-control" placeholder="Jumlah barang" aria-label="Recipient's username" aria-describedby="basic-addon2" />
                                                    </div>

                                                    <div class="form-group " id="ket">
                                                        <label for="Keterangan">Keterangan</label>
                                                        <textarea rows="3" id="keteranganBarang" class="form-control" value="{{old('keterangan','')}}"></textarea>
                                                    </div>



                                                    <input class="btn btn-danger btn-lg btn-block" type="button" id="tambahKeranjang" value="Tambah kedalam Keranjang">
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->

                                        </div>
                                        <!-- /.col (left) -->
                                        <div class="col-md-6">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title">Keranjang</h3>
                                                </div>
                                                <div class="card-body">
                                                    <!-- Date -->
                                                    <!--<input type="hidden" name="tanggalDibutuhkan" value="{{old('tanggalDibutuhkanVal')}}">
                                      <input type="hidden" name="gudang" value="{{old('tanggalDibutuhkanVal')}}">
                                      <input type="hidden" name="tanggalAkhir" value="{{old('tanggalAkhirVal')}}">-->
                                                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                                                        <span class="text-muted">Keranjang</span>
                                                        <span class="badge badge-secondary badge-pill" name="totalBarangnya" id="totalBarangnya" value="{{count($dataTotalDetail)}}">{{count($dataTotalDetail)}}</span>
                                                    </h4>
                                                    <ul class="list-group mb-3 sticky-top" id="keranjang">
                                                        @foreach($dataTotalDetail as $data)
                                                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                                                            <div id="hiddenDiv">
                                                                <input type="hidden" class="cekId" name="itemId[]" value="{{$data->ItemID}}">
                                                                <input type="hidden" id="cekJumlah" class="cekJumlah" name="itemJumlah[]" value="{{$data->jumlah}}">
                                                                <input type="hidden" class="cekKeterangan" name="itemKeterangan[]" value="{{$data->keterangan}}">
                                                                <input type="hidden" class="cekPrd" name="itemPRDID[]" value="{{$data->idPRD}}">
                                                                <h6 class="my-0">{{$data->itemName}}<small class="jumlahVal" value="jumlahBarang[]">({{$data->jumlah}})</small> </h6>
                                                                <small class="text-muted keteranganVal" value="keteranganBarang[]">{{$data->keterangan}}</small><br>
                                                            </div>
                                                            <div>
                                                                <button class="btn btn-primary copyKe" type="button" id="copyKe">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                                        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                                                    </svg>
                                                                </button>
                                                                <button class="btn btn-danger" type="button" id="hapusKeranjang">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square-fill" viewBox="0 0 16 16">
                                                                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                    <!--<li class="list-group-item d-flex justify-content-between">
                                              <span>Total (Rupiah)</span>
                                              <strong name="TotalHargaKeranjang" id="TotalHargaKeranjang" value=0 jumlahHarga=0>0</strong>
                                      </li>-->
                                                    <!-- /.form group -->
                                                </div>
                                                <!---->
                                                <input class="btn btn-primary " type="submit" id="tambah" value="Kirim"><br>

                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                        <!-- /.col (right) -->
                                    </div>


</form>
</div>
</div>
<!-- /.col -->
</div>


<!-- this row will not appear when printing -->

<!-- /.invoice -->
</div><!-- /.col -->
</div><!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</form>

<script type="text/javascript">
    var tambahCombo = "";
    var totalTambah = 0;
    $('#TotalHargaKeranjang').val(0);




    $(document).ready(function() {

        /*var id = $("#idGudangTujuan option:selected").val();
        var optionnya = '';
        var dataPurchaseRequest = <?php echo json_encode($dataPurchaseRequest); ?>;
        var transactionGudangBarang = <?php echo json_encode($transactionGudangBarang); ?>;
        optionnya += '<option value="pilih" selected>--Pilih Purchase Request--</option>\n';
        $.each(dataPurchaseRequest, function(key, value) {
            if (value.MGudangID.toString() == id.toString()) {
                if (value.id == transactionGudangBarang.PurchaseRequestID) {
                    optionnya += '<option selected id="idPr" value="' + value.id + '">' + value.name + '-(' + value.tanggalDibuat + ')</option>\n';
                } else {
                    optionnya += '<option id="idPr" value="' + value.id + '">' + value.name + '-(' + value.tanggalDibuat + ')</option>\n';
                }
            }
        });


        $("#PurchaseRequestID").empty();
        //$("#PurchaseRequestID option:selected").selectpicker("val", optionnya)
        $("#PurchaseRequestID").append(optionnya);
        $('.selectpicker').selectpicker('refresh');*/

        /* var optionnya = '';

         var suratJalan = <?php echo json_encode($suratJalan); ?>;

         //alert('masuk sini');
         optionnya += '<option value="pilih" selected>--Pilih Surat Jalan--</option>\n';
         $.each(suratJalan, function(key, value) {

             if (value.MGudangIDTujuan.toString() == id.toString()) {
                 if (value.id == transactionGudangBarang.SuratJalanID) {
                     optionnya += '<option selected id="idSj" idPurchaseReq="' + value.PurchaseRequestID + '" value="' + value.id + '">' + value.name + '-(' + value.tanggalDibuat + ')</option>\n';
                 } else {
                     optionnya += '<option id="idSj" idPurchaseReq="' + value.PurchaseRequestID + '" value="' + value.id + '">' + value.name + '-(' + value.tanggalDibuat + ')</option>\n';
                 }
             }
         });

         $("#SuratJalanID").empty();
         $("#SuratJalanID").append(optionnya);*/

        var pr = $("#SuratJalanID option:selected").attr("idPurchaseReq");
        var optionnya = '';

        var suratJalanDetail = <?php echo json_encode($suratJalanDetail); ?>;
        optionnya += '<option value="pilih" selected>--Pilih Barang--</option>\n';
        $.each(suratJalanDetail, function(key, value) {
            if (value.idPR.toString() == pr.toString()) {
                optionnya += '<option id="namaBarang" namaBarang=' + value.itemName + ' idPrdId=' + value.PurchaseRequestDetailID + ' value="' + value.ItemID + '">' + value.itemName + '<nbsp>(' + value.unitName + ')</option>\n';
            }

        });

        $("#barang").empty();
        $("#barang").append(optionnya);
        $('.selectpicker').selectpicker('refresh');

        $("#idGudangTujuan").on("change", function() { //sudah

            var id = this.value;
            var optionnya = '';

            var dataPurchaseRequest = <?php echo json_encode($dataPurchaseRequest); ?>;

            //alert('masuk sini');
            optionnya += '<option value="pilih" selected>--Pilih Purchase Request--</option>\n';
            $.each(dataPurchaseRequest, function(key, value) {

                if (value.MGudangID.toString() == id.toString()) {
                    //alert('masuk'); 
                    optionnya += '<option id="idPr" value="' + value.id + '">' + value.name + '-(' + value.tanggalDibuat + ')</option>\n';
                    //alert(optionnya);         
                }
            });


            $("#PurchaseRequestID").empty();
            $("#PurchaseRequestID").append(optionnya);
            //$('.selectpicker').selectpicker('refresh');
            var optionnya = '';

            var suratJalan = <?php echo json_encode($suratJalan); ?>;

            //alert('masuk sini');
            optionnya += '<option value="pilih" selected>--Pilih Surat Jalan--</option>\n';
            $.each(suratJalan, function(key, value) {

                if (value.MGudangIDTujuan.toString() == id.toString()) {
                    //alert('masuk'); 
                    optionnya += '<option id="idSj" idPurchaseReq="' + value.PurchaseRequestID + '" value="' + value.id + '">' + value.name + '-(' + value.tanggalDibuat + ')</option>\n';
                    //alert(optionnya);         
                }
            });

            $("#SuratJalanID").empty();
            $("#SuratJalanID").append(optionnya);

            $('.selectpicker').selectpicker('refresh');
            $('#keranjang').empty();
        });

        $("#SuratJalanID").on("change", function() { //sudah

            var id = $("#SuratJalanID option:selected").attr("idPurchaseReq");
            var optionnya = '';
            var dataPurchaseRequest = <?php echo json_encode($dataPurchaseRequest); ?>;
            optionnya += '<option value="pilih">--Pilih Purchase Request--</option>\n';
            $.each(dataPurchaseRequest, function(key, value) {
                if (value.id.toString() == id.toString()) {
                    optionnya += '<option selected id="idPr" value="' + value.id + '">' + value.name + '-(' + value.tanggalDibuat + ')</option>\n';
                }
            });
            $("#PurchaseRequestID").empty();
            $("#PurchaseRequestID").append(optionnya);


            var pr = $("#SuratJalanID option:selected").attr("idPurchaseReq");
            //alert(pr);
            var optionnya = '';

            var suratJalanDetail = <?php echo json_encode($suratJalanDetail); ?>;

            // alert('masuk sini');
            optionnya += '<option value="pilih" selected>--Pilih Barang--</option>\n';
            // alert(optionnya);
            $.each(suratJalanDetail, function(key, value) {
                if (value.idPR.toString() == pr.toString()) {
                    //alert('masuk'); 
                    //alert("masuk cek");
                    optionnya += '<option id="namaBarang" namaBarang=' + value.itemName + ' idPrdId=' + value.PurchaseRequestDetailID + ' value="' + value.ItemID + '">' + value.itemName.substring(0, 30) + '<nbsp>(' + value.unitName + ')</option>\n';
                    // alert(optionnya);
                }
            });


            $("#barang").empty();
            $("#barang").append(optionnya);
            $('.selectpicker').selectpicker('refresh');
            $('#keranjang').empty();
        });

        $("#barang").on("change", function() { //sudah

            var id = this.value;
            var idPrdId = $("#barang option:selected").attr('idPrdId');
            var suratJalan = $("#SuratJalanID option:selected").val();
            var optionnya = '';
            var maxAngka = 0;
            var suratJalanDetail = <?php echo json_encode($suratJalanDetail); ?>;
            var dataDetail = <?php echo json_encode($dataTotalDetail); ?>;


            $.each(suratJalanDetail, function(key, value) {
                if (value.PurchaseRequestDetailID.toString() == idPrdId.toString() && value.ItemID.toString() == id.toString() && value.suratJalanID.toString() == suratJalan.toString()) {
                    maxAngka = parseFloat(value.jumlah) + parseFloat(value.jumlahProsesTerima);

                    $.each(dataDetail, function(k, v) {
                        if (v.idPRD.toString() == value.PurchaseRequestDetailID.toString() && value.ItemID.toString() == v.ItemID.toString()) {
                            maxAngka -= parseFloat(v.jumlah);
                        }
                    });

                    $.each($('.cekPrd'), function(idx, val) {
                        if (val.value == value.PurchaseRequestDetailID) {
                            var jumlahBarang = $('.cekJumlah:eq(' + idx + ')').val();
                            maxAngka = maxAngka - jumlahBarang;

                        }
                    });
                    //alert(maxAngka);
                    $("#jumlahBarang").attr({
                        "max": maxAngka,
                        "min": 0.01,
                        "placeholder": "Jumlah Barang (Maksimal: " + maxAngka + ")",
                        "value": "",
                    });
                    if (maxAngka <= 0) {
                        $('#jumlahBarang').prop('readonly', true);
                    } else {
                        $('#jumlahBarang').prop('readonly', false);
                    }
                }
            });

        });

    });

    $('body').on('click', '#copyKe', function() { //belum
        //alert($(this).index('.copyKe'));
        var i = $(this).index('#copyKe');

        var idBarang = $('.cekId:eq(' + i + ')').val();
        var jumlahBarang = $('.cekJumlah:eq(' + i + ')').val();

        var hargaBarang = $('.cekHarga:eq(' + i + ')').val();
        var keteranganBarang = $('.cekKeterangan:eq(' + i + ')').val();
        var diskonBarang = $('.cekDiskon:eq(' + i + ')').val();

        $("#barang").val(idBarang).change();
        $("#jumlahBarang").val(jumlahBarang);
        $("#keteranganBarang").val(keteranganBarang);

        $('.selectpicker').selectpicker('refresh');

    });



    $('body').on('click', '#hapusKeranjang', function() {
        //alert($('.cekId:eq(2)').val());
        //alert($('.cekId').length);cekJumlah
        var jumlah = $(this).parent().parent().children("#hiddenDiv").children(".cekJumlah").val();
        //alert(jumlah);
        $("#jumlahBarang").attr({
            "max": parseFloat($("#jumlahBarang").attr("max")) + parseFloat(jumlah),
            "min": 0.01,
            "placeholder": "Jumlah Barang (Maksimal: " + (parseFloat($("#jumlahBarang").attr("max")) + parseFloat(jumlah)) + ")",
            "value": "",
        });
        $(this).parent().parent().remove();
        var totalSekarang = $('#totalBarangnya').attr("value");
        totalSekarang = parseFloat(totalSekarang) - 1.0;
        $('#totalBarangnya').attr("value",totalSekarang);
        $('#totalBarangnya').html(parseFloat(totalSekarang));
    });

    $('body').on('click', '#tambahKeranjang', function() {

        var idBarang = $("#barang").val(); //
        var namaBarang = $("#barang option:selected").html(); //
        var idprdID = $("#barang option:selected").attr("idPrdId");
        //alert(idprdID);
        //var hargaBarang = $("#barang option:selected").attr("harga");
        var jumlahBarang = parseFloat($("#jumlahBarang").val()); //
        var keteranganBarang = $("#keteranganBarang").val(); //

        var indexSama = null;
        for (let i = 0; i < $('.cekId').length; i++) {
            if ($('.cekId:eq(' + i + ')').val() == idBarang) {
                if ($('.cekPrd:eq(' + i + ')').val() == idprdID) {
                    indexSama = i;
                }
            }
        }

        if (idBarang == "" || namaBarang == "--Pilih Barang--" || namaBarang == "undefined" || namaBarang == null || jumlahBarang <= 0 || jumlahBarang.toString() == "NaN" || jumlahBarang == null || keteranganBarang == "") {
            alert('Harap lengkapi atau isi data Barang dengan benar');
            die;
        } else if (jumlahBarang > $("#jumlahBarang").attr("max")) {
            $('#jumlahBarang').val("");
            alert("harap masukkan jumlah barang yang sesuai");
            die;
        } else if (indexSama != null) {
            //alert("masuk indexSama");
            var jumlah = $('.cekJumlah:eq(' + indexSama + ')').val();
            $('.cekJumlah:eq(' + indexSama + ')').val(parseFloat(jumlah) + parseFloat(jumlahBarang));
            var keterangan = $('.cekKeterangan:eq(' + indexSama + ')').val();
            $('.cekKeterangan:eq(' + indexSama + ')').val(keterangan + ".\n" + keteranganBarang);

            $('.keteranganVal:eq(' + indexSama + ')').html($('.cekKeterangan:eq(' + indexSama + ')').val());
            $('.jumlahVal:eq(' + indexSama + ')').html(($('.cekJumlah:eq(' + indexSama + ')').val()));

            var maxAngka = parseFloat($("#jumlahBarang").attr("max")) - parseFloat(jumlahBarang);
        } else {
            //alert("masuk");
            var htmlKeranjang = "";
            htmlKeranjang += '<li class="list-group-item d-flex justify-content-between lh-condensed">\n';
            htmlKeranjang += '<div id="hiddenDiv">\n';
            htmlKeranjang += '<input type="hidden" class="cekId" name="itemId[]" value="' + idBarang + '">\n';
            htmlKeranjang += '<input type="hidden" id="cekJumlah" class="cekJumlah" name="itemJumlah[]" value="' + jumlahBarang + '">\n';
            htmlKeranjang += '<input type="hidden" class="cekKeterangan" name="itemKeterangan[]" value="' + keteranganBarang + '">\n';
            //htmlKeranjang += '<input type="hidden" class="cekHarga" name="itemHarga[]" value="'+hargaBarang+'">\n';
            htmlKeranjang += '<input type="hidden" class="cekPrd" name="itemPRDID[]" value="' + idprdID + '">\n';
            htmlKeranjang += '<h6 class="my-0">' + namaBarang + '<small class="jumlahVal" value="' + jumlahBarang + '">(' + jumlahBarang + ')</small> </h6>\n';
            htmlKeranjang += '<small class="text-muted keteranganVal" value="' + keteranganBarang + '">' + keteranganBarang + '</small><br>\n';
            htmlKeranjang += '</div>\n';
            htmlKeranjang += '<div>\n';
            htmlKeranjang += '<button class="btn btn-primary copyKe" type="button" id="copyKe">\n';
            htmlKeranjang += '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">\n';
            htmlKeranjang += '<path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>\n';
            htmlKeranjang += '</svg>\n';
            htmlKeranjang += '</button>\n';
            htmlKeranjang += '<button class="btn btn-danger" type="button" id="hapusKeranjang">\n';
            htmlKeranjang += '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square-fill" viewBox="0 0 16 16">\n';
            htmlKeranjang += '<path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>\n';
            htmlKeranjang += '</svg>\n';
            htmlKeranjang += '</button>\n';
            htmlKeranjang += '</div>\n';
            htmlKeranjang += '</li>\n';

            $('#keranjang').append(htmlKeranjang);
            var totalSekarang = $('#totalBarangnya').attr("value");
            totalSekarang = parseFloat(totalSekarang) + 1.0;
            $('#totalBarangnya').attr("value",totalSekarang);
            $('#totalBarangnya').html(parseFloat(totalSekarang));

        }

        $("#barang").val("").change(); //
        $("#jumlahBarang").val(""); //
        $("#keteranganBarang").val(""); //
    });

    /* Tanpa Rupiah */
    var tanpa_rupiah = document.getElementById('tanpa-rupiah');
    tanpa_rupiah.addEventListener('keyup', function(e) {
        $('#hargaBarang').val(this.value.toString().replace(/\./g, ''));
        //alert(this.value.toString().replace(/\./g, ''));
        tanpa_rupiah.value = formatRupiah(this.value);
    });

    var tanpa_rupiah_diskon = document.getElementById('tanpa-rupiah-diskon');
    tanpa_rupiah_diskon.addEventListener('keyup', function(e) {
        $('#diskonBarang').val(this.value.toString().replace(/\./g, ''));
        tanpa_rupiah_diskon.value = formatRupiah(this.value);
    });

    /* Dengan Rupiah */
    var dengan_rupiah = document.getElementById('dengan-rupiah');
    dengan_rupiah.addEventListener('keyup', function(e) {
        $('#hargaBarang').val(this.value.toString().replace(/\./g, ''));
        dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
    });

    /* Fungsi */
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    $(document).ready(function() {
        $('input[name=jenis0]').click(function() {

            if ($("#barang").is(':checked')) {
                $("#tmbhBarang").show();
                $("#total").show();
                $("#ket").hide();
                //$("#buttonBarang").show();
            } else {
                $("#ket").show();
                $("#tmbhBarang").hide();
                //$("#buttonBarang").hide();
            }
        });
    });

    /*$('#myForm input').on('change', function() {
           $("input[name=jenis]").change(function(){

            if($("#barang").is(':checked'))
            {
              $("#tmbhBarang").show();
              $("#total").show();
               $("#ket").hide();
               //$("#buttonBarang").show();
            }
            else
            {
              $("#ket").show();
              $("#tmbhBarang").hide();
              //$("#buttonBarang").hide();
            }
        });
      //alert($('input[name=jenis]:checked', '#myForm').val()); 
    });*/
</script>
@endsection