@extends('layouts.account')

@section('title')
Laporan Uang Keluar - UANGKU
@stop

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1> LAPORAN UANG KELUAR</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-chart-area"></i> LAPORAN KESELURUHAN</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('account.laporan_complete.check') }}" method="GET">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="pemasukan" class="custom-control-input" id="pemasukan" {{
                                    old('pemasukan')!='on' ? '' : 'checked' }}>
                                <label class="custom-control-label" for="pemasukan">Pemasukan</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="pengeluaran" class="custom-control-input" id="pengeluaran"
                                    {{ old('pengeluaran')!='on' ? '' : 'checked' }}>
                                <label class="custom-control-label" for="pengeluaran">Pengeluaran</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>TANGGAL AWAL</label>
                                    <input type="text" name="tanggal_awal" value="{{ old('tanggal_awal') }}"
                                        class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-md-2" style="text-align: center">
                                <label style="margin-top: 38px;">S/D</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>TANGGAL AKHIR</label>
                                    <input type="text" name="tanggal_akhir" value="{{ old('tanggal_kahir') }}"
                                        class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary mr-1 btn-submit btn-block" type="submit"
                                    style="margin-top: 30px"><i class="fa fa-filter"></i> FILTER</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            @if (isset($data))
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-chart-area"></i> LAPORAN</h4>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                    <th scope="col">KATEGORI</th>
                                    <th scope="col">NOMINAL</th>
                                    <th scope="col">KETERANGAN</th>
                                    <th scope="col">TANGGAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no = 1;
                                @endphp
                                @foreach ($data as $hasil)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ $no }}</th>
                                    <td>{{ $hasil->name }}</td>
                                    <td>{{ rupiah($hasil->nominal) }}</td>
                                    <td>{{ $hasil->description }}</td>
                                    <td>{{ $hasil->date }}</td>
                                </tr>
                                @php
                                $no++;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{$data->links("vendor.pagination.bootstrap-4")}}
                        </div>
                    </div>

                </div>
            </div>
            @endif


        </div>
    </section>
</div>
@stop