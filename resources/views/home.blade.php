@extends('layouts.app')

@section('content')

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<div class="container">

        <button class="btn-primary" onclick="callAjax();"> loader</button>

            @if(Session::has('message'))
            <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif

            <form action="{{route('carts.store')}}" method="post" enctype="multipart/form-data" >
				@csrf
				<div class="form-group">
					<input type="text"  class="form-control" placeholder="Product Name" required name="product">
				</div>



				<div class="form-group">
					<input type="number"  class="form-control" placeholder="Enter Price" required=""  name="price">
				</div>

                <div id="loaderIcon" class="spinner-border text-primary" style="display:none" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <input type="submit" class="btn text-white mb-2" style="width: 100%; background-color: #ce9c46;" value="submit"></input>


			</form>

           <a href="{{route('carts.index')}}">
               <p>Check out page</p>
           </a>

</div>
@endsection

<script>
    function callAjax(e){
        $('#loaderIcon').show();
        // $.ajax({
        //     type: "GET",
        //     url: 'https://api.joind.in/v2.1/talks/10889',
        //     data: {
        //         format: 'json'
        //     },
        //     success: function(response){
        //         console.log(response);
        //     },
        //     complete: function(){
        //         $('#loaderIcon').hide();
        //     }
        // });
    }
</script>
