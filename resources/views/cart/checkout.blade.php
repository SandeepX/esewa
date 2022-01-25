@extends('layouts.app')

@section('content')
<div class="container">
        @if(Session::has('success'))
            <p class="alert alert-success" id="alert">{{ Session::get('success') }}</p>
        @endif

        @if(Session::has('failure'))
            <p class="alert alert-danger" id="alert">{{ Session::get('failure') }}</p>
        @endif
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Product</th>
      <th scope="col">Price</th>

    </tr>
  </thead>
  <tbody>
  @foreach($Cartdetail as $key =>$value)

    <tr>
      <th scope="row">{{++$key}}</th>
      <td>{{$value->product}}</td>
      <td>{{$value->price}}</td>

    </tr>
  @endforeach


  </tbody>
</table>
<hr>

    <tr >
     Total product cost Excluding other charges:   <th>{{$total}}</th>
    </tr>
    <br>
    </br>




  <form action="https://uat.esewa.com.np/epay/main" method="POST">
      <input value="{{$amt}}" name="tAmt" type="hidden">
      <input value="{{$total}}" name="amt" type="hidden">
      <input value="{{$txAmt}}" name="txAmt" type="hidden">
      <input value="{{$psc}}" name="psc" type="hidden">
      <input value="{{$pdc}}" name="pdc" type="hidden">
      <input value="EPAYTEST" name="scd" type="hidden">
      <input value="{{$pid}}" name="pid" type="hidden">
      <input value="http://127.0.0.1:8001/verification-payment?q=su" type="hidden" name="su">
      <input value="http://127.0.0.1:8001/verification-payment?q=fu" type="hidden" name="fu">
      <button value="Submit" class="btn btn-success"  type="submit">pay with eSewa</button>
  </form>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


  <script>
    $(document).ready(function(){
      setTimeout(function(){
        $('#alert').slideUp();
      } , 3000);


    });

  </script>





@endsection
