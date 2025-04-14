@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($penjualan)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    The data you are looking for is not found.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $penjualan->penjualan_id }}</td>
                    </tr>
                    <tr>
                        <th>Customer</th>
                        <td>{{ $penjualan->pembeli }}</td>
                    </tr>
                    <tr>
                        <th>Transaction Code</th>
                        <td>{{ $penjualan->penjualan_kode }}</td>
                    </tr>
                    <tr>
                        <th>Transaction Date</th>
                        <td>{{ $penjualan->penjualan_tanggal }}</td>
                    </tr>
                    <tr>
                        <th>Employee Name</th>
                        <td>{{ $penjualan->user->name }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default mt-2">Back</a>
        </div>
    </div>
@endsection

@push('css')
@endpush
 
@push('js') 
@endpush 
