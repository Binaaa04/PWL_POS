@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($item)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    The data you are looking for is not found.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $item->barang_id }}</td>
                    </tr>
                    <tr>
                        <th>Item Code</th>
                        <td>{{ $item->barang_kode }}</td>
                    </tr>
                    <tr>
                        <th>Item Name</th>
                        <td>{{ $item->barang_nama }}</td>
                    </tr>
                    <tr>
                        <th>Purchase Price</th>
                        <td>{{ $item->harga_beli }}</td>
                    </tr>
                    <tr>
                        <th>Selling Price</th>
                        <td>{{ $item->harga_jual }}</td>
                    </tr>
                    <tr>
                        <th>Category Item</th>
                        <td>{{ $item->kategori->kategori_nama }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('item') }}" class="btn btn-sm btn-default mt-2">Back</a>
        </div>
    </div>
@endsection

@push('css')
@endpush
 
@push('js') 
@endpush 
