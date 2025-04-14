@extends('layouts.template') 
 
@section('content') 
  <div class="card card-outline card-primary"> 
      <div class="card-header"> 
        <h3 class="card-title">{{ $page->title }}</h3> 
        <div class="card-tools"> 
          <a class="btn btn-sm btn-primary mt-1" href="{{ url('penjualan/create') }}">Add Transaction Data</a> 
        </div> 
      </div> 
      <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{session('success')}}</div>
      @endif
        <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan"> 
          <thead> 
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Transaction Code</th>
                <th>Transaction Date</th>
                <th>Employee Name</th>
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
      var dataPenjualan = $('#table_penjualan'). DataTable({ 
         // serverSide: true, if you want to use server side processing 
          serverSide: true,      
ajax: { 
              "url": "{{ url('penjualan/list') }}", 
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
              data: "pembeli",                
              className: "", 
             // orderable: true, if you want this column to be sortable  
              orderable: true,     
              //searchable: true, if you want this field to be searchable 
              searchable: true     
},{ 
              data: "penjualan_kode",                
              className: "", 
             // orderable: true, if you want this column to be sortable  
              orderable: true,     
              //searchable: true, if you want this field to be searchable 
              searchable: true     
},{ 
            data: "penjualan_tanggal",  
            className: "", 
              orderable: true,     
              searchable: true     
},{ 
              //Retrieve result-user data from correlated ORMs 
              data: "user.name",                
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