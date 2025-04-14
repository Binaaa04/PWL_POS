@extends('layouts.template') 
 
@section('content') 
  <div class="card card-outline card-primary"> 
      <div class="card-header"> 
        <h3 class="card-title">{{ $page->title }}</h3> 
        <div class="card-tools"> 
          <a class="btn btn-sm btn-primary mt-1" href="{{ url('barang/create') }}">Add Item Data</a> 
        </div> 
      </div> 
      <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{session('success')}}</div>
      @endif
        @if (session('error'))
        <div class="alert alert-danger">{{session('error')}}</div>
      @endif
        <table class="table table-bordered table-striped table-hover table-sm" 
id="table_barang"> 
          <thead> 
            <tr>
                <th>ID</th>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Purchase Price</th>
                <th>Selling Price</th>
                <th>Category Item</th>
                <th>Action</th>
            </tr> 
          </thead> 
      </table> 
    </div> 
  </div> 
@endsection 
 
@push('css') 
@endpush 
 
@push('js') 
  <script> 
    $(document).ready(function() { 
      var dataBarang = $('#table_barang'). DataTable({ 
         // serverSide: true, if you want to use server side processing 
          serverSide: true,      
ajax: { 
              "url": "{{ url('barang/list') }}", 
              "dataType": "json", 
              "type": "POST" ,
}, 
columns: [ 
{ 
             // sequence number of laravel datatable addIndexColumn() 
              data: "DT_RowIndex",     
              className: "text-center", 
              orderable: false, 
              searchable: false     
},{ 
              data: "barang_kode",                
              className: "", 
             // orderable: true, if you want this column to be sortable  
              orderable: true,     
              //searchable: true, if you want this field to be searchable 
              searchable: true     
},{ 
            data: "barang_nama",  
            className: "", 
              orderable: true,     
              searchable: true     
},{ 
              data: "harga_beli",                
              className: "", 
             // orderable: true, if you want this column to be sortable  
              orderable: true,     
              //searchable: true, if you want this field to be searchable 
              searchable: true     
},{ 
              data: "harga_jual",                
              className: "", 
             // orderable: true, if you want this column to be sortable  
              orderable: true,     
              //searchable: true, if you want this field to be searchable 
              searchable: true     
},
{ 
              //Retrieve result-kategori data from correlated ORMs 
              data: "kategori.kategori_nama",                
              className: "", 
              orderable: false,     
              searchable: false     
},
{ 
              data: "action",  
              className: "", 
              orderable: false,     
              searchable: false     
}] 
}); 
}); 
  </script> 
@endpush 