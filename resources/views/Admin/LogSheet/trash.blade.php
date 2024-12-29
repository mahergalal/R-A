@extends('Admin.cycleA.layout')

@section('content')

<div class="jumbotron">

 <p>Trash </p>
  <a class="btn btn-primary btn-lg" href="{{route('LogSheet.index')}}" role="button">Home</a>
</div>




<div class="container">
<table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">#</th>
        <th scope="col" >Plane Name </th>
        <th scope="col" >Flight No.</th>
        <th scope="col" >From</th>
        <th scope="col" >To</th>
        <th scope="col" >Takeoff Time</th>
        <th scope="col" >Landing Time</th>
        <th scope="col" >deprature</th>
        <th scope="col" >Arrival</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
        @php
           $i =0;
        @endphp
        @foreach ($LogSheet as $item)
        <tr>
            <th scope="row">{{++ $i}}</th>
            <td>{{$item->name_of_plane}}</td>
                            <td>{{$item->no_of_flight}}</td>
                            <td>{{$item->srart_date}}</td>
                            <td>{{$item->end_date}}</td>
                            <td>{{$item->take_of_time}}</td>
                            <td>{{$item->landing_time}}</td>
                            <td>{{$item->deprature}}</td>
                            <td>{{$item->arrival}}</td>
            <td>
                <div class="container">
                    <div class="row">

                      <div class="col-sm">
                        <a class="btn btn-primary" href="{{route('LogSheet.back.trash',$item->id)}}">Back</a>
                      </div>
                      <div class="col-sm">
                        <button class="btn btn-danger delete-logsheet" data-id="{{ $item->id }}">Delete</button>

                      </div>

                     </div>
                 </div>

            </td>
        </tr>
        @endforeach

    </tbody>
</table>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$(document).ready(function () {
    $('.delete-logsheet').on('click', function () {
        const logSheetId = $(this).data('id');
        const deleteUrl = `/logsheet/delete/${logSheetId}`; // Adjust based on route definition

        if (confirm('Are you sure you want to delete this log sheet?')) {
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    alert(response.message);
                    location.reload(); // Refresh the page to update the table
                },
                error: function (xhr) {
                    alert('An error occurred: ' + xhr.responseText);
                }
            });
        }
    });
});

</script>

@endsection
