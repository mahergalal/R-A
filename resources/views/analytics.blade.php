@extends('Admin.layout.layout')
@section('adminContent')

<body class="analytics-body">
    <h1 class="analytics-header">Analytics Dashboard</h1>

    <!-- Summary Cards -->
    <div class="analytics-summary-cards">
        <div class="analytics-summary-card">
            <h2>Total Fresh Parts</h2>
            <p id="analytics-overallFreshTotal"></p>
        </div>
        <div class="analytics-summary-card">
            <h2>Total Critical Parts</h2>
            <p id="analytics-overallCriticalTotal"></p>
        </div>
        <div class="analytics-summary-card">
            <h2>Total Non-Critical Parts</h2>
            <p id="analytics-overallNonCriticalTotal"></p>
        </div>
    </div>

    <!-- Overall Pie Chart -->
    <div class="analytics-overall-pie">
        <h2>Overall Pie Chart</h2>
        <canvas id="analytics-overallPieChart" width="400" height="400"></canvas>

    </div>

    <!-- Plane-Specific Cards -->
    <div id="analytics-planeCards" class="analytics-plane-cards"></div>

    <div class="text-dark section-lg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card-m10 shadow-soft border-light text-center py-4">
                        <div class="card-body"><a class="h2">Excel Reports </a>
                            <!-- First Row of Forms -->
                            <div class="row mb-4">

                                <div class="col-md-6">

                                    <form action="/export" method="get">
                                        <label for="difference"><b>On Cycles (All Planes) :</b></label>
                                        <select name="difference" id="difference" class="custom-select my-1 mr-sm-2">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary text-success ">Export</button>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <form action="/export-hours" method="get">
                                        <label for="hours_difference"><b>On Hours (All Planes) :</b></label>
                                        <select name="difference" id="hours_difference" class="custom-select my-1 mr-sm-2">
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                            <option value="150">150</option>
                                            <option value="200">200</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary text-success ">Export</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Second Row of Forms -->
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="/export-dates" method="get">
                                        <label for="date_difference"><b>On Dates (All Planes) :</b></label>
                                        <select name="date_difference" id="date_difference" class="custom-select my-1 mr-sm-2 ">
                                            <option value="1_week">1 Week</option>
                                            <option value="2_weeks">2 Weeks</option>
                                            <option value="1_month">1 Month</option>
                                            <option value="2_months">2 Months</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary text-success ">Export</button>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <form action="{{ route('export.excel') }}" method="GET">
                                        <label for="plane"><b>Select Plane:</b></label>
                                        <select name="plane" id="plane" class="custom-select my-1 mr-sm-2" required>
                                            <option value="AFA">AFA</option>
                                            <option value="AFB">AFB</option>
                                            <option value="AFC">AFC</option>
                                        </select>
                                        <label for="filter" class="mt-3"><b>Select Filter (All Types) :</b></label>
                                        <select name="filter" id="filter" class="custom-select my-1 mr-sm-2custom-select my-1 mr-sm-2" required>
                                            <option value="Fresh">Fresh</option>
                                            <option value="Critical">Critical</option>
                                            <option value="Non-Critical">Non-Critical</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary text-success">Export</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fetch analytics data
        fetch('/plane-analytics-data')
            .then(response => response.json())
            .then(data => {
                const planes = Object.keys(data);

                // Calculate overall totals
                let overallFresh = 0, overallCritical = 0, overallNonCritical = 0;

                planes.forEach(plane => {
                    const planeData = data[plane];

                    overallFresh += planeData.fresh.cycles + planeData.fresh.hours + planeData.fresh.dates;
                    overallCritical += planeData.critical.cycles + planeData.critical.dates;
                    overallNonCritical += planeData.non_critical.cycles + planeData.non_critical.dates;
                });

                // Update overall summary cards
                document.getElementById('analytics-overallFreshTotal').innerText = overallFresh;
                document.getElementById('analytics-overallCriticalTotal').innerText = overallCritical;
                document.getElementById('analytics-overallNonCriticalTotal').innerText = overallNonCritical;

                // Render overall pie chart
                const overallPieCtx = document.getElementById('analytics-overallPieChart').getContext('2d');
                new Chart(overallPieCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Fresh', 'Critical', 'Non-Critical'],
                        datasets: [{
                            data: [overallFresh, overallCritical, overallNonCritical],
                            backgroundColor: ['#00674f', '#9b111e', '#00609c'],
                        }]
                    }
                });

                // Render plane-specific cards
                const planeCardsContainer = document.getElementById('analytics-planeCards');
                planes.forEach(plane => {
                    const planeData = data[plane];

                    // Create a card for each plane
                    const card = document.createElement('div');
                    card.classList.add('analytics-plane-card');

                    // Add the Pie Chart
                    card.innerHTML = `
                        <h3>${plane} - Pie Chart</h3>
                        <canvas id="analytics-pie-${plane}" width="300" height="200"></canvas>
                        <table class="analytics-plane-table">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Cycles</th>
                                    <th>Hours</th>
                                    <th>Dates</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Fresh</td>
                                    <td>${planeData.fresh.cycles}</td>
                                    <td>${planeData.fresh.hours}</td>
                                    <td>${planeData.fresh.dates}</td>
                                </tr>
                                <tr>
                                    <td>Critical</td>
                                    <td>${planeData.critical.cycles}</td>
                                    <td>-</td>
                                    <td>${planeData.critical.dates}</td>
                                </tr>
                                <tr>
                                    <td>Non-Critical</td>
                                    <td>${planeData.non_critical.cycles}</td>
                                    <td>-</td>
                                    <td>${planeData.non_critical.dates}</td>
                                </tr>
                            </tbody>
                        </table>
                    `;

                    // Append card to container
                    planeCardsContainer.appendChild(card);

                    // Render the Pie Chart
                    const pieCtx = document.getElementById(`analytics-pie-${plane}`).getContext('2d');
                    new Chart(pieCtx, {
                        type: 'pie',
                        data: {
                            labels: ['Fresh', 'Critical', 'Non-Critical'],
                            datasets: [{
                                data: [
                                    planeData.fresh.cycles + planeData.fresh.hours + planeData.fresh.dates,
                                    planeData.critical.cycles + planeData.critical.dates,
                                    planeData.non_critical.cycles + planeData.non_critical.dates,
                                ],
                                backgroundColor: ['#00674f', '#9b111e', '#00609c'],
                            }]
                        }
                    });
                });
            })
            .catch(error => {
                console.error('Error fetching analytics data:', error);
            });
    </script>



@endsection
