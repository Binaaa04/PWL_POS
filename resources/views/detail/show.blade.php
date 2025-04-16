@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($detail)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    The data you are looking for is not found.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $detail->detail_id }}</td>
                    </tr>
                    <tr>
                        <th>Customer</th>
                        <td>{{ $detail->penjualan->pembeli }}</td>
                    </tr>
                    <tr>
                        <th>Item</th>
                        <td>{{ $detail->barang->barang_nama }}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td>{{ $detail->harga }}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{ $detail->jumlah }}</td>
                    </tr>
                    <tr>
                        <th>Transaction Date</th>
                        <td>{{ $detail->penjualan->penjualan_tanggal }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('detail') }}" class="btn btn-sm btn-default mt-2">Back</a>
        </div>
    </div>
@endsection

@push('css')
@endpush
 
@push('js') 
@endpush 
