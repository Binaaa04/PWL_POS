@extends('layouts.template') 
 
@section('content') 
  <div class="card card-outline card-primary"> 
      <div class="card-header"> 
        <h3 class="card-title">{{ $page->title }}</h3> 
        <div class="card-tools"> 
          <a class="btn btn-sm btn-primary mt-1" href="{{ url('detail/create') }}">Add Detail Transaction Data</a> 
        </div> 
      </div> 
      <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{session('success')}}</div>
      @endif
        @if (session('error'))
        <div class="alert alert-danger">{{session('error')}}</div>
      @endif
        <table class="table table-bordered table-striped table-hover table-sm" id="table_detail"> 
          <thead> 
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Item</th>
                <th>Total</th>
                <th>Quantity</th>
                <th>Transaction Date</th>
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
      var dataDetail = $('#table_detail'). DataTable({ 
         // serverSide: true, if you want to use server side processing 
          serverSide: true,      
ajax: { 
              "url": "{{ url('detail/list') }}", 
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
              data: "penjualan.pembeli",                
              className: "", 
             // orderable: true, if you want this column to be sortable  
              orderable: false,     
              //searchable: true, if you want this field to be searchable 
              searchable: false    
},{ 
              //Retrieve result-user data from correlated ORMs 
              data: "barang.barang_nama",                
              className: "", 
              orderable: false,     
              searchable: false     
},{ 
              data: "harga",                
              className: "", 
             // orderable: true, if you want this column to be sortable  
              orderable: true,     
              //searchable: true, if you want this field to be searchable 
              searchable: true     
},{ 
              data: "jumlah",                
              className: "", 
             // orderable: true, if you want this column to be sortable  
              orderable: true,     
              //searchable: true, if you want this field to be searchable 
              searchable: true     
},{ 
            data: "penjualan.penjualan_tanggal",  
            className: "", 
              orderable: false,     
              searchable: false     
},{ 
              data: "action",  
              className: "", 
              orderable: false,     
              searchable: false     
}] 
}); 
}); 
  </script> 
@endpush 