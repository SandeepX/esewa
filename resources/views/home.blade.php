@extends('layouts.app')

@section('content')
<div class="container">
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
						
				<input type="submit" class="btn text-white mb-2" style="width: 100%; background-color: #ce9c46;" value="submit"></input>
			
  
			</form>

           <a href="{{route('carts.index')}}"  <p>Check out page</p></a>
		
</div>
@endsection
