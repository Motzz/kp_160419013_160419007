<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sadhana Arifnusa | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('assets/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('assets/plugins/summernote/summernote-bs4.min.css')}}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="{{asset('assets/plugins/bs-stepper/css/bs-stepper.min.css')}}">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="{{asset('assets/plugins/dropzone/min/dropzone.min.css')}}">
  <!-- Theme style-->
  <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
  <!-- Toastr  -->
  <link rel="stylesheet" href="{{asset('assets/plugins/toastr/toastr.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- script comboboc-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css%22%3E">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>

</head>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Invoice</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Invoice</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" colspan="3">
                        <h2> <img src="" alt="">NOTA PURCHASE ORDER</h2>
                      </th>
                      <th scope="col" colspan="3">
                        <b>Nama Purchase Order : {{$purchaseOrder->name}}</b><br>
                        <b>Tanggal pembuatan :{{date("d-m-Y", strtotime($purchaseOrder->tanggalDibuat))}}</b>



                      </th>
                      <th scope="col" colspan="1">
                        @foreach($dataPerusahaan as $key => $data)

                        @if($data->MPerusahaanID == $purchaseOrder->MPerusahaanID)
                        @if($data->Gambar !="" || $data->Gambar !=null)
                        <img src='{{asset($data->Gambar)}}' alt='' width='100' height='100'>
                        @endif
                        @endif

                        @endforeach
                      </th>
                    </tr>
                  </thead>
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" colspan="3">
                        <b>Keterangan:</b>
                        <br>
                        <b>Lokasi:</b><span style="white-space: pre-line">{{$purchaseOrder->keteranganLokasi}}</span> <br>
                        <b>Pembayaran:</b><span style="white-space: pre-line">{{$purchaseOrder->keteranganPembayaran}}</span><br>
                        <b>Penagihan:</b><span style="white-space: pre-line">{{$purchaseOrder->keteranganPenagihan}}</span><br>
                      </th>
                      <th scope="col" colspan="4" style="vertical-align: top;">
                        <b>Jatuh Tempo:</b> {{date("d-m-Y", strtotime($purchaseOrder->tanggal_akhir))}}<br>

                        @foreach($dataPerusahaan as $key => $data)

                        @if($data->MPerusahaanID == $purchaseOrder->MPerusahaanID)
                        <b>Perusahaan:</b> {{$data->cname}}<br>
                        <b>Nomor NPWP:</b> {{$data->NomorNPWP}}<br>
                        <b>Alamat NPWP:</b> {{$data->AlamatNPWP}} <br>
                        @endif

                        @endforeach

                        @foreach($dataSupplier as $key => $data)
                        @if($data->SupplierID == $purchaseOrder->idSupplier)
                        <b>Supplier:</b> {{$data->Name}}<br>
                        @endif
                        @endforeach

                        @foreach($dataPayment as $key => $data)
                        @if($data->PaymentTermsID == $purchaseOrder->idPaymentTerms)
                        <b>Pembayaran:</b>{{$data->PaymentName}}<br>
                        @endif
                        @endforeach
                      </th>
                    </tr>
                  </thead>
                  <thead class="thead-light">
                    <tr>
                      <th scope="col" colspan="7">
                        <b>Status:
                          @if($purchaseOrder->approved==0)
                          <span style="white-space: pre-line">Belum diproses</span><br>
                          @elseif($purchaseOrder->approved==1)
                          <span style="white-space: pre-line">Disetujui</span><br>
                          @elseif($purchaseOrder->approved==2)
                          <span style="white-space: pre-line">Ditolak</span><br>
                          @endif
                        </b>
                        <br>
                        <b>Keterangan status:</b><span style="white-space: pre-line">{{$purchaseOrder->keterangan}}</span> <br>
                      </th>

                    </tr>
                  </thead>

                </table>
              </div>
              <!-- /.col -->
            </div>

            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th class="text-center"  colspan="3">Nama Barang</th>
                      <th class="text-center">Jumlah</th>
                      <th class="text-center">Harga</th>
                      <!--<th>Pajak</th>-->
                      <th class="text-center">Diskon</th>
                      <th class="text-center">Harga Diskon</th>
                      <!--<th>PPN</th>-->
                      <th class="text-center">Harga PPN</th>
                      <th class="text-center" >Total Harga</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                    $totalHarga = 0;
                    $totalHargaDiskon = 0;
                    $totalHargaPPN = 0;
                    @endphp
                    @foreach($dataDetail as $data)
                    <tr>
                      @if($data->idPurchaseOrder==$purchaseOrder->id)
                      <th scope="row" >{{ $loop->index + 1 }}</th>
                      @foreach($dataBarang as $dataBrg)
                      @if($data->idItem==$dataBrg->ItemID)
                      <th scope="row" colspan="3">
                        {{$dataBrg->ItemName}}<br>
                        <small><span style="white-space: pre-line">{{$data->keterangan}}</span></small>
                      </th>
                      <!--nanti looping -->
                      @endif
                      @endforeach

                      <td class="text-right" >{{$data->jumlah}}</td>
                      <td class="text-right">@php echo number_format($data->harga,2,',','.'); @endphp</td>

                      <!--@foreach($dataTax as $dataTx)
                      @if($data->idTax==$dataTx->TaxID)
                      <td>{{$dataTx->Name}}</td>
                      @endif
                      @endforeach-->


                      <td class="text-right">@php echo number_format($data->diskon,2,',','.'); @endphp</td>
                      <!--<td class="text-right">@php echo "Rp " . number_format((((float)$data->harga- (float)$data->diskon) * $data->jumlah),2,',','.'); @endphp</td>-->
                      <td class="text-right">@php echo number_format((((float)$data->diskon) * $data->jumlah),2,',','.'); @endphp</td>
                      <!--<td class="text-right">{{$data->TaxPercent}} %</td>-->
                      <td class="text-right">@php echo number_format((((float)$data->harga- (float)$data->diskon) * $data->jumlah) * ((float)$data->TaxPercent) / 100.0,2,',','.'); @endphp</td>
                      <td class="text-right">@php echo "Rp." . number_format((((float)$data->harga- (float)$data->diskon) * $data->jumlah) * (100.0 + (float)$data->TaxPercent) / 100.0,2,',','.'); @endphp</td>
                      @php
                      $totalHarga += (float)$data->harga * $data->jumlah;
                      $totalHargaDiskon += $data->diskon * $data->jumlah;
                      $totalHargaPPN += (((float)$data->harga- (float)$data->diskon) * $data->jumlah) * (float)$data->TaxPercent / 100.0;
                      @endphp

                      @endif
                    </tr>
                    @endforeach
                  </tbody>
                  <thead class="thead-light justify-content-center">
                    <tr>
                      <!--<th scope="col" colspan="6"></th>-->
                      <th scope="col" colspan="7" class="text-right"> Total Harga</th>
                      <th scope="col" colspan="10" class="text-right"> @php echo "Rp " . number_format($totalHarga,2,',','.'); @endphp </th>
                    </tr>
                    <tr>
                      <!--<th scope="col" colspan="6"></th>-->
                      <th scope="col" colspan="7" class="text-right"> Total Harga Diskon </th>
                      <th scope="col" colspan="10" class="text-right"> @php echo "Rp " . number_format($totalHargaDiskon,2,',','.'); @endphp </th>
                    </tr>
                    <tr>
                      <!--<th scope="col" colspan="6"></th>-->
                      <th scope="col" colspan="7" class="text-right"> DPP </th>
                      <th scope="col" colspan="10" class="text-right"> @php echo "Rp " . number_format($totalHarga - $totalHargaDiskon,2,',','.'); @endphp </th>
                    </tr>
                    <tr>
                      <!--<th scope="col" colspan="6"></th>-->
                      <th scope="col" colspan="7" class="text-right"> Total Harga PPN </th>
                      <th scope="col" colspan="10" class="text-right"> @php echo "Rp " . number_format($totalHargaPPN,2,',','.'); @endphp </th>
                    </tr>
                    <tr>
                      <!--<th scope="col" colspan="6"></th>-->
                      <th scope="col" colspan="7" class="text-right"> Total Keseluruhan </th>
                      <th scope="col" colspan="10" class="text-right"> @php echo "Rp " . number_format($purchaseOrder->totalHarga,2,',','.'); @endphp </th>
                    </tr>
                  </thead>


                </table>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th scope="col" colspan="3">Approval :
                        <br /><br /><br /><br /><br />Tanda tangan <br />
                        @if($purchaseOrder->approved==1)
                        @foreach($dataUser as $user)
                        @if($user->id == $purchaseOrder->approved_by)
                        {{$user->name}}
                        @endif
                        @endforeach
                        @endif<br />
                      </th>

                      <th scope="col" colspan="4">Supplier :
                        <br /><br /><br /><br /><br />Tanda tangan <br />
                        @foreach($dataSupplier as $supplier)
                        @if($supplier->SupplierID == $purchaseOrder->idSupplier)
                        {{$supplier->AtasNama}}
                        @endif
                        @endforeach<br />
                      </th>

                      <th scope="col" colspan="3">Pembuat :
                        <br /><br /><br /><br /><br />Tanda tangan <br />
                        @foreach($dataUser as $user)
                        @if($user->id == $purchaseOrder->CreatedBy)
                        {{$user->name}}
                        @endif
                        @endforeach<br />
                      </th>

                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <!-- /.row -->

          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer no-print">
  <div class="float-right d-none d-sm-block">
    <b>Version</b> 3.2.0
  </div>
  <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script>
  window.addEventListener("load", window.print());
  $('#hargaTotal').html("Rp." + formatRupiah($('#hargaTotal').attr('hargaT')));
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

 
</script>