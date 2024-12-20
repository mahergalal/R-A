@extends('Admin.layout.layout')
@section('adminContent')
<div class="main-content {{ auth()->check() && auth()->user()->role === 0 ? 'with-sidebar' : 'no-sidebar' }}">
    <div class="section">
        <div class="container">
            <div class="row justify-content-left">
                <div class="col-lg-12">
                    <span class="h5">date A</span>
                </div>

                                <div class="row justify-content-left">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <a class="btn btn-primary" type="button" href="{{route('dateA.create')}}"> ADD</button></a>
                                            <a class="btn btn-primary" type="button" href="{{route('dateA.trash')}}"> Trash</button></a>
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
                        @php
                            use Carbon\Carbon;
                        @endphp
                    <table class="table shadow-soft rounded">
                    <thead >
                        <tr>
                            <th class="border-0" scope="col" >ID</th>
                            <th class="border-0" scope="col" >Name</th>
                            <th class="border-0" scope="col" >Serial No.</th>
                            <th class="border-0" scope="col" >Start date</th>
                            <th class="border-0" scope="col" >End date</th>
                            <th class="border-0" scope="col" id="females" >Action</th>


                        </tr>
                    </thead>

                    <tbody>
                        @php
                           $i =0;
                        @endphp
                        @foreach ($dateA as $item)
                        @php
                        $endDate = Carbon::parse($item->max);
                        $currentDate = Carbon::now();
                        $diffInDays = $endDate->diffInDays($currentDate, false);
                        $rowClass = '';

                        if ($diffInDays <= 0 && $diffInDays >= -7) {
                            $rowClass = 'shadow-soft-r9'; // Red for dates within the past 1-7 days
                        } elseif ($diffInDays < -7 && $diffInDays >= -30) {
                            $rowClass = 'shadow-soft-r8'; // Yellow for dates within the past 7-30 days
                        }
                    @endphp
                    <tr class="{{ $rowClass }}">
                            <th scope="row">{{++ $i}}</th>
                            <td>{{$item->name}}</td>
                            <td>{{$item->serial}}</td>
                            <td>{{$item->start}}</td>
                            <td>{{$item->max}}</td>
                            <td>
                                <div class="container">
                                    <div class="row">
                                      <div class="col-sm">
                                        <a class="btn btn-primary" type="button" href="{{route('dateA.edit',$item->id)}}"><i class="fas fa-solid fa-pen"></i></a>                                          </div>

                                      <div class="col-sm">
                                        <a class="btn btn-primary ml-2" type="button" href="{{route('dateA.show',$item->id)}}"><i class="fas fa-light fa-eye"></i></a>
                                      </div>
                                      <div class="col-sm">
                                        <a class="btn btn-primary ml-2" type="button" href="{{route('softda.delete',$item->id)}}"><i class="fas fa-solid fa-trash"></i></a>
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
