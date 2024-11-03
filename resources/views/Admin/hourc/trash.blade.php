@extends('Admin.hourc.layout')

@section('content')
<div class="jumbotron">

 <p>Trash </p>
  <a class="btn btn-primary btn-lg" href="{{route('hourc.index')}}" role="button">Home</a>
</div>




<div class="container">
<table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Part Name</th>
        <th scope="col">Serial NO</th>
        <th scope="col">current Hour</th>
        <th scope="col">max Hour</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
        @php
           $i =0;
        @endphp
        @foreach ($hourc as $item)
        <tr>
            <th scope="row">{{++ $i}}</th>
            <td>{{$item->name}}</td>
            <td>{{$item->serial}}</td>
            <td>{{$item->current}}</td>
            <td>{{$item->max}}</td>
            <td>
                <div class="container">
                    <div class="row">

                      <div class="col-sm">
                        <a class="btn btn-primary" href="{{route('hourc.back.trash',$item->id)}}">Back</a>
                      </div>
                      <div class="col-sm">
                        <a class="btn btn-danger" href="{{route('hourc.delete.trash',$item->id)}}">Delete</a>
                      </div>

                     </div>
                 </div>

            </td>
        </tr>
        @endforeach

    </tbody>
</table>

</div>
@endsection
