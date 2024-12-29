@extends('Admin.layout.layout')
@section('adminContent')
    <main>
        <div class="main-content {{ auth()->check() && auth()->user()->role === 0 ? 'with-sidebar' : 'no-sidebar' }}">

        <div class="section">
        <form action="{{ route('logsheet.store')}}" method="POST" id="logSheetForm">
            @csrf

                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">

                            <div class="card shadow-soft border-light text-center py-4">
                                <div class="card-body">
                            <div class="col-12">

        <div class="form-group">
            <label class="my-1 mr-2" for="name_of_plane">Plane Name</label>
            <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="name_of_plane" required autofocus>
                <option selected name="name_of_plane" value="" >Choose...</option>
                <option name="name_of_plane" value="AFA320">AFA320</option>
                <option name="name_of_plane" value="AFB320" >AFB320</option>
                <option name="name_of_plane"  value="AFC320">AFC320</option>



            </select>
        </div>

        <div class="form-group">
            <label for="exampleFormControlTextarea2">No. of Flight</label>
            <input type="number" name="no_of_flight"  class="form-control" id="exampleInputPassword" aria-describedby="passwordHelp" placeholder="No. of Flight" required autofocus>
        </div>

            </div>
        </div>
        <div>
        <div class="col-12">
            <!-- Form -->
            <div class="row align-items-center border-divider mb-4">
                <div class="col-6 text-left">
                    <label class="h6 label-left" for="exampleInputDate2">From</label>
                    <div class="form-group">
                        <div class="input-group input-group-border">
                            <div class="input-group-prepend"><span class="input-group-text"><span class="far fa-calendar-alt"></span></span></div>
                            <input class="form-control datepicker" name="srart_date" id="exampleInputDate2" placeholder="Start date" type="date" required autofocus>
                        </div>
                    </div>
                </div>
                <div class="col-6 text-right">
                        <label class="h6 label-left" for="exampleInputDate3">To</label>
                        <div class="form-group">
                            <div class="input-group input-group-border">
                            <div class="input-group-prepend"><span class="input-group-text"><span class="far fa-calendar-alt"></span></span></div>
                            <input class="form-control datepicker" name="end_date" id="exampleInputDate3" placeholder="End date" type="date" required autofocus>
                        </div>
                    </div>
                </div>
            </div>
            <div class="input-daterange timepicker row align-items-center">
            <div class="col">
            <div class="form-group">
                <label class="h6" for="exampleInputTime">Takeoff Time</label>
                <div class="input-group input-group-border">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="far fa-clock"></span></span>
                    </div>
                    <input type="time" name="take_of_time" class="form-control timepicker" id="exampleInputTime" placeholder="Select time" required autofocus>
                </div>
            </div>
            </div>
            <div class="col">
            <div class="form-group">
                <label class="h6" for="exampleInputTime">Landing Time</label>
                <div class="input-group input-group-border">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="far fa-clock"></span></span>
                    </div>
                    <input type="time" class="form-control timepicker" name="landing_time" id="exampleInputTime" placeholder="Select time" required autofocus>
                </div>
            </div>
            </div>
        </div>
            <!-- End of Form -->
        </div>
    </div>


    <div class="row align-items-center border-divider">
        <div class="col-6 text-left">
            <label class="h6 label-left" for="departure">Departure</label>
            <div class="form-group">
                <select class="custom-select my-1 mr-sm-2" name="deprature" id="departure"  onchange="handleSelection('departure', 'arrival')" required autofocus>
                    <option value="">Select Departure</option>
                    <option value="Sana'a">Sana'a</option>
                    <option value="Aden">Aden</option>
                    <option value="Cairo">Cairo</option>
                    <option value="Amman">Amman</option>
                    <option value="Mumbai">Mumbai</option>
                  </select>
            </div>
    </div>
    <div class="col-6 text-right">
        <label class="h6 label-left" for="arrival">Arrival</label>
        <div class="form-group">
            <select class="custom-select my-1 mr-sm-2" name="arrival" id="arrival" onchange="handleSelection('arrival', 'departure')" required autofocus>
                <option value="">Select Arrival</option>
                <option value="Sana'a">Sana'a</option>
                <option value="Aden">Aden</option>
                <option value="Cairo">Cairo</option>
                <option value="Amman">Amman</option>
                <option value="Mumbai">Mumbai</option>
              </select>
    </div>
    </div>
    </div>




    <button class="btn btn-primary text-success mr-2 mb-2" type="submit" >Submit </button>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
</form>
</div>
</div>
    </main>


    <!-- <a id="producthunt-badge" href="https://www.producthunt.com/posts/neumorphism-ui?utm_source=badge-featured&utm_medium=badge&utm_souce=badge-neumorphism-ui" target="_blank"><img src="https://api.producthunt.com/widgets/embed-image/v1/featured.svg?post_id=200908&theme=dark" alt="Neumorphism UI - Neumorphism inspired UI web components, sections and pages | Product Hunt Embed" style="width: 250px; height: 54px;" width="250px" height="54px" /></a> -->



    <!-- Core -->
<script src="../../vendor/jquery/dist/jquery.min.js"></script>
<script src="../../vendor/popper.js/dist/umd/popper.min.js"></script>
<script src="../../vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../../vendor/headroom.js/dist/headroom.min.js"></script>

<!-- Vendor JS -->
<script src="../../vendor/onscreen/dist/on-screen.umd.min.js"></script>
<script src="../../vendor/nouislider/distribute/nouislider.min.js"></script>
<script src="../../vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="../../vendor/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="../../vendor/jarallax/dist/jarallax.min.js"></script>
<script src="../../vendor/jquery.counterup/jquery.counterup.min.js"></script>
<script src="../../vendor/jquery-countdown/dist/jquery.countdown.min.js"></script>
<script src="../../vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
<script src="../../vendor/prismjs/prism.js"></script>

<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- Neumorphism JS -->
<script src="../../assets/js/neumorphism.js"></script>
<script src="../js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/moment-with-locales.min.js"></script>
  <script src="js/bootstrap-datetimepicker.min.js"></script>
  <script src="js/main.js"></script>

  <script src = "https://ajax.aspnetCDN.com/ajax/jQuery/jQuery-1.9.0.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
        // Set up CSRF token for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Handle form submission with AJAX
        $('#logSheetForm').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            $.ajax({
                url: '{{ route('logsheet.store') }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        alert(response.message); // Display success message
                        location.reload();
                    }
                },
                error: function(xhr) {
                    // Display error message
                    alert('An error occurred: ' + xhr.responseText);
                }
            });
        });

        // Date validation
    $('#exampleInputDate2, #exampleInputDate3').on('change', function () {
        const fromDate = new Date($('#exampleInputDate2').val());
        const toDate = new Date($('#exampleInputDate3').val());

        if (toDate && fromDate > toDate) {
            alert('"To Date" cannot be earlier than "From Date".');
            $('#exampleInputDate3').val('');
        }
    });

    // Time validation


    // Dropdown validation for departure and arrival

    });
</script>

<script>
    function handleSelection(changedDropdownId, otherDropdownId) {
      const changedDropdown = document.getElementById(changedDropdownId);
      const otherDropdown = document.getElementById(otherDropdownId);

      const selectedValue = changedDropdown.value;

      // Enable all options in the other dropdown
      Array.from(otherDropdown.options).forEach(option => {
        option.disabled = false;
      });

      // Disable the selected value in the other dropdown
      if (selectedValue) {
        Array.from(otherDropdown.options).forEach(option => {
          if (option.value === selectedValue) {
            option.disabled = true;
          }
        });
      }
    }
</script>

<script>
    const takeoffTimeInput = document.getElementById("takeoffTime");
    const landingTimeInput = document.getElementById("landingTime");

    landingTimeInput.addEventListener("change", () => {
        const takeoffTime = takeoffTimeInput.value;
        const landingTime = landingTimeInput.value;

        if (takeoffTime && landingTime) {
            // Convert time strings to Date objects
            const takeoffDate = new Date(1970-01-01T${takeoffTime}:00);
            const landingDate = new Date(1970-01-01T${landingTime}:00);

            // Add 20 hours to the takeoff time
            const maxLandingTime = new Date(takeoffDate.getTime() + 3 * 60 * 60 * 1000);

            if (landingDate > maxLandingTime) {
                alert("The landing time cannot exceed the takeoff time by more than 20 hours.");
                landingTimeInput.value = ""; // Reset landing time
            }
        }
    });

    takeoffTimeInput.addEventListener("change", () => {
        const takeoffTime = takeoffTimeInput.value;
        const landingTime = landingTimeInput.value;

        if (takeoffTime && landingTime) {
            // Convert time strings to Date objects
            const takeoffDate = new Date(1970-01-01T${takeoffTime}:00);
            const landingDate = new Date(1970-01-01T${landingTime}:00);

            // Add 20 hours to the takeoff time
            const maxLandingTime = new Date(takeoffDate.getTime() + 20 * 60 * 60 * 1000);

            if (landingDate > maxLandingTime) {
                alert("The landing time cannot exceed the takeoff time by more than 20 hours.");
                landingTimeInput.value = ""; // Reset landing time
            }
        }
    });
</script>

@endsection
