<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="bg-dark py-3">
      <h3 class="text-white text-center">Simple Laravel 11 CRUD</h3>
    </div>

    <div class="container">
      <div class="row justify-content-center mt-4">
        <div class="col-md-10 d-flex justify-content-end">
          {{-- <a href="/products/create" class="btn btn-dark">Create</a> --}}
          <a href="{{ route('products.create') }}" class="btn btn-dark">Create</a>
        </div>
      </div>
      <div class="row d-flex justify-content-center">
        @if(session('success'))
        <div class="col-md-10 mt-4">
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        </div>
        @endif
        <div class="col-md-10">
          <div class="card border-0 shadow-lg my-4">
            <div class="card-header bg-dark">
              <h3 class="text-white">List Product</h3>
            </div>
            <div class="card-body">
              <table class="table">
                <tr>
                  <th>ID</th>
                  <th></th>
                  <th>Name</th>
                  <th>SKU</th>
                  <th>Price</th>
                  <th>Created at</th>
                  <th>Action</th>
                </tr>
                @if ($products->isNotEmpty())
                @foreach ($products as $keyProduct => $valueProduct)
                <tr>
                  <td>{{$valueProduct->id}}</td>
                  <td>
                    @if ($valueProduct->image != "")
                      <img width="50" src="{{asset('uploads/products/'.$valueProduct->image)}}" alt="">
                    @endif
                  </td>
                  <td>{{$valueProduct->name}}</td>
                  <td>{{$valueProduct->sku}}</td>
                  <td>Rp. {{$valueProduct->price}}</td>
                  <td>{{\Carbon\Carbon::parse($valueProduct->created_at)->format('d F Y')}}</td>
                  <td>
                    <a href="{{route('products.edit',$valueProduct->id)}}" class="btn btn-dark">Edit</a>
                    {{-- <button class="btn btn-danger btn-delete" value="{{$valueProduct->id}}">Delete</button> --}}
                    <a href="#" onclick="deleteProduct({{$valueProduct->id}})" class="btn btn-danger">Delete</a>
                    <form id="delete-product-from-{{$valueProduct->id}}" action="{{route('products.destroy',$valueProduct->id)}}" method="post">
                      @csrf
                      @method('delete')
                    </form>
                  </td>
                </tr>
                @endforeach
                @endif
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
  </body>
</html>

{{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<script>
  // $(".btn-delete").click(function(){
  //   var id = $(this).val();
  //   var data = {"_token": "{{ csrf_token() }}",'id':id};
  //   if (confirm('Yakin Ingin Menghapus Data?')) {
  //     $.ajax({
  //       url: "/products/destroy/",
  //       type: "post",
  //       dataType: "json",
  //       data: data,
  //       success: function (response) {
  //         console.log(response);
  //       },
  //       error: function(jqXHR, textStatus, errorThrown) {
  //         console.log(textStatus, errorThrown);
  //       }
  //     });
  //   }
  // });

  function deleteProduct(id) {
    if (confirm('Yakin Ingin Menghapus Data?')) {
      document.getElementById("delete-product-from-"+id).submit();
    }
  }
</script>