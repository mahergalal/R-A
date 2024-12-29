@extends('Admin.layout.layout')
@section('adminContent')
<div class="main-content {{ auth()->check() && auth()->user()->role === 0 ? 'with-sidebar' : 'no-sidebar' }}" >
    <div class="section">
        <div class="container">
            <div class="row justify-content-left">
                <div class="col-lg-12">
                    <span class="h5">Hour A Trash</span>
                </div>

                                <div class="row justify-content-left">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <a class="btn btn-primary" type="button" href="{{route('hour.index')}}"> Home</button></a>
                                        </div>
                                        <!--Buttons-->

                            </div>

                        </div>

                    </div>

                </div>


                <div class="mb-5">

                    <div class="container">
                    <table class="table shadow-soft rounded">
                    <thead >
                        <tr>
                            <th class="border-0" scope="col" >ID</th>
                            <th class="border-0" scope="col" >Name</th>
                            <th class="border-0" scope="col" >Serial No.</th>
                            <th class="border-0" scope="col" >current</th>
                            <th class="border-0" scope="col" >max </th>
                            <th class="border-0" scope="col" id="females" >Action</th>


                        </tr>
                    </thead>

                    <tbody>
                        @php
                           $i =0;
                        @endphp
                        @foreach ($hour as $item)

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
                                        <a class="btn btn-primary" type="button" href="{{route('hour.back.trash',$item->id)}}">Back</a>                                          </div>

                                      <div class="col-sm">
                                        <a class="btn btn-primary ml-2" type="button" href="{{route('hour.delete.trash',$item->id)}}">Delete</i></a>
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
