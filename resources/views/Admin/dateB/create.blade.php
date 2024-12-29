@extends('Admin.layout.layout')
@section('adminContent')


<div class="main-content section bg-primary text-dark section-lg {{ auth()->check() && auth()->user()->role === 0 ? 'with-sidebar' : 'no-sidebar' }}">
    <div class="container">
        <div class="section">
        <div class="row justify-content-center">
            <div class="col-lg-12">

            <form  action="{{ route('dateB.store')}}" method="POST">
                @csrf
                <div class="card bg-primary shadow-soft border-light text-center py-4">
                    <div class="card-body">

                        <div class="form-group mb-4">
                            <label for="exampleInputName">Name</label>
                            <input type="text" name="name"  class="form-control" id="exampleInputName" aria-describedby="nameHelp" placeholder="name" required autofocus>
                        </div>
                        <div class="form-group mb-4">
                            <label for="exampleInputComID"> Serial</label>
                            <input type="number" name="serial"   class="form-control" id="exampleInputComID" aria-describedby="comIDHelp" placeholder="serial" required autofocus>
                        </div>
                        <label class="h6" for="exampleInputDate2">Start Date</label>
                        <div class="form-group">
                            <div class="input-group input-group-border">
                                <div class="input-group-prepend"><span class="input-group-text"><span class="far fa-calendar-alt"></span></span></div>
                                <input class="form-control datepicker" name="start" id="exampleInputDate2" placeholder="Start date" type="date" required autofocus>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="h6" for="exampleInputDate2">End Date</label>
                    <div class="form-group">
                        <div class="input-group input-group-border">
                            <div class="input-group-prepend"><span class="input-group-text"><span class="far fa-calendar-alt"></span></span></div>
                            <input class="form-control datepicker" name="max" id="exampleInputDate2" placeholder="End date" type="date" required autofocus">
                        </div>
                    </div>
                        </div>



                        <div class="row justify-content-left mt-4">
                            <div class="col-lg-12">
                                <button class="btn btn-primary animate-down-2 mr-2 text-success" type="submit">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    </div>
</div>
<script>
    $(document).ready(function() {
            $('#exampleInputDate2, #exampleInputDate3').datepicker({
                format: "yyyy/mm/dd", // Date format set to 'YYYY/MM/DD'
                autoclose: true,
                todayHighlight: true,
                icons: {
                    time: 'far fa-clock',
                    date: 'far fa-calendar-alt',
                    up: 'fas fa-chevron-up',
                    down: 'fas fa-chevron-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right'
                }
            });

            // Optional: Add a validation to check date format before form submission
            $('form').on('submit', function() {
                const dateFrom = $('#exampleInputDate2').val();
                const dateTo = $('#exampleInputDate3').val();

                if (!moment(dateFrom, 'YYYY/MM/DD', true).isValid() || !moment(dateTo, 'YYYY/MM/DD', true).isValid()) {
                    alert('Please enter the date in the correct format (YYYY/MM/DD).');
                    return false; // Prevent submission if format is invalid
                }
            });
        });

    </script>

@endsection
