@extends('Admin.layout.layout')
@section('adminContent')
<div class="main-content {{ auth()->check() && auth()->user()->role === 0 ? 'with-sidebar' : 'no-sidebar' }}">
    <div class="section">
        <div class="container">
            <div class="row justify-content-left">
                <div class="col-lg-12">
                    <span class="h5">LogSheet</span>
                </div>

                                <div class="row justify-content-left">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <a class="btn btn-primary" type="button" href="{{route('logsheet.store')}}"> ADD</button></a>
                                            <a class="btn btn-primary" type="button" href="{{route('LogSheet.trash')}}"> Trash</button></a>
                                        </div>
                                        <!--Buttons-->

                            </div>

                        </div>

                    </div>

                </div>

                <div class="container" style="color: black">
                    @if ( $message = Session::get('success'))

                    <div class="alert alert-primary" role="alert">

                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{$message}}
                      </div>
                    @endif

                </div>
                <div class="mb-5">

                    <div class="container">
                    <table class="table shadow-soft rounded">
                    <thead >
                        <tr>
                            <th class="border-0" scope="col" >ID</th>
                            <th class="border-0" scope="col" >Plane Name </th>
                            <th class="border-0" scope="col" >Flight No.</th>
                            <th class="border-0" scope="col" >From</th>
                            <th class="border-0" scope="col" >To</th>
                            <th class="border-0" scope="col" >Takeoff Time</th>
                            <th class="border-0" scope="col" >Landing Time</th>
                            <th class="border-0" scope="col" >deprature</th>
                            <th class="border-0" scope="col" >Arrival</th>
                            <th class="border-0" scope="col" id="females" >Action</th>


                        </tr>
                    </thead>

                    <tbody>
                        @php
                           $i =0;
                        @endphp
                        @foreach ($logSheets as $item)
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

           
                                    <div class="row justify-content-left">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <a class="btn btn-primary" type="button" href="{{route('LogSheet.edit',$item->id)}}"><i class="fas fa-solid fa-pen"></i></a>
                                                <a class="btn btn-primary ml-2" type="button" href="{{route('softl.delete',$item->id)}}"><i class="fas fa-solid fa-trash"></i></a>
                                            </div>
                                            <!--Buttons-->

                                </div>
                                      {{--
                 <div class="col-sm">
                                        <form action="{{route('cycleA.destroy',$item->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-danger"> Delete</button>
                                        </form>
                                      </div>

                                      --}}


                                 </div>

                            </td>
                        </tr>
                        @endforeach

                    </tbody>

                    </table>

                </div>
                </div>
                </div>
                </div>

@endsection
