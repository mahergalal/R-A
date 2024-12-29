<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reports</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" >
<style>
    .card-body{
        width: 150%;
    }
    </style>
</head>
<body>
    <div class="section bg-primary text-dark section-lg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <div class="card bg-primary shadow-soft border-light text-center py-4">
                        <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between">

                    <div class="d-flex flex-column flex-md-row gap-3">
    <form action="/export" method="get">
        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Select Difference:</label>
        <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
        </select>
        <button class="btn btn-primary text-success mr-2 mb-2" type="submit">Export</button>
    </form>

    <form action="/export-hours" method="get">
        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Select Hours Difference:</label>
        <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="150">150</option>
            <option value="200">200</option>
        </select>
        <button class="btn btn-primary text-success mr-2 mb-2" type="submit">Export</button>
    </form>
    <!-- Form for Dates Export -->
<form action="/export-dates" method="get">
    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Select Date Difference:</label>
    <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
        <option value="1_week">1 Week</option>
        <option value="2_weeks">2 Weeks</option>
        <option value="1_month">1 Month</option>
        <option value="2_months">2 Months</option>
    </select>
    <button class="btn btn-primary text-success mr-2 mb-2" "submit">Export</button>
</form>

                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

            <div class="section bg-primary text-dark section-lg">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">

                            <div class="card bg-primary shadow-soft border-light text-center py-4">
                                <div class="card-body d-flex flex-column flex-md-row align-items-center justify-content-between">

                            <div class="d-flex flex-column flex-md-row gap-3">
<form action="{{ route('export.excel') }}" method="GET">
    <div>
        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Select Plane:</label>
        <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
            <option value="AFA">AFA</option>
            <option value="AFB">AFB</option>
            <option value="AFC">AFC</option>
        </select>
    </div>

    <div>
        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Select Filter:</label>
        <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
            <option value="Fresh">Fresh</option>
            <option value="Critical">Critical</option>
            <option value="Non-Critical">Non-Critical</option>
        </select>
    </div>

    <button class="btn btn-primary text-success mr-2 mb-2" type="submit">Export</button>
</form>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- Required Scripts for Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

</body>
</html>
