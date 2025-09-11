@extends('layout.admin.dashboard')

@section('content')

<div class="page-heading">

   <h3>Profile Statistics</h3>

</div>

<div class="page-content">

   <section class="row">

      <div class="col-12 col-lg-12">        

         <div class="row">

            <div class="col-12 col-lg-3 col-md-6">

                <div class="card">

                    <div class="card-body py-4 px-5">

                    <div class="d-flex align-items-center">

                        <div class="avatar avatar-xl">

                            <img src="{{ asset('public/admin/images/faces/1.jpg') }}" alt="Face 1">

                        </div>

                        <div class="ms-3 name">

                            <h5 class="font-bold">{{Session::get('admin_name')}}</h5>

                            <h6 class="text-muted mb-0">{{Session::get('admin_email')}}</h6>

                        </div>

                    </div>

                    </div>

                </div>

            </div>

            <div class="col-12 col-lg-3 col-md-6">

                <div class="card">

                    <div class="card-body py-4 px-5">

                    <div class="d-flex align-items-center">

                        <div class="ms-3 name">

                            <h5 class="font-bold">Current Login</h5>

                            <h6 class="text-muted mb-0">

                                Latitude: {{Session::get('admin_latitude')}}

                                <br> Longitude: {{Session::get('admin_longitude')}}

                            </h6>

                        </div>

                    </div>

                    </div>

                </div>

            </div>

            <div class="col-12 col-lg-3 col-md-6">

                <div class="card">

                    <div class="card-body py-4 px-5">

                    <div class="d-flex align-items-center">

                        <div class="ms-3 name">

                            <h5 class="font-bold">Employee</h5>

                            <h6 class="text-muted mb-0">

                                Total: {{Helper::getTotalCustomer('Employee');}}
                                <br>
                                Today Present: {{Helper::getTodayPresent();}}

                            </h6>

                        </div>

                    </div>

                    </div>

                </div>

            </div>

         </div>

         <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-body py-4 px-5">

                    <div class="d-flex align-items-center" id="replaceMap">                        

                    </div>

                    </div>

                </div>

            </div>

        </div>

      </div>

   </section>

</div>



<script type="text/javascript">

    $(document).ready(function(){

        loadMap();

    });

    function loadMap(){

        var lat = "{{Session::get('admin_latitude')}}";

        var lng = "{{Session::get('admin_longitude')}}";


        $("#replaceMap").html('Processing...');

        $('#my_map').modal('show');

        // Create the Google Maps URL

        var mapUrl = "https://www.google.com/maps?q=" + lat + "," + lng + "&z=15&zoom=4&maptype=satellite&output=embed";


        // Embed the Google Map in an iframe

        var iframe = $("<iframe>")

            .attr("src", mapUrl)

            .attr("width", "100%")

            .attr("height", "400px")

            .attr("frameborder", "0")

            .css("border", "0")

            .css("allowfullscreen", "")

            .css("loading", "lazy");


        // Append the iframe to the map container    

        $("#replaceMap").html(iframe);    

    }

</script>

@endsection