@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    hola
                    <br>
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card">
                <div class="box p-2 rounded bg-info text-center">
                    <h1 class="font-weight-light text-white">{{ $cantidadEstudiantes }}</h1>
                    <h6 class="text-white">Estudiantes</h6>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card">
                <div class="box p-2 rounded bg-primary text-center">
                    <h1 class="font-weight-light text-white">{{ $cantidadUsuarios }}</h1>
                    <h6 class="text-white">Usuarios</h6>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card">
                <div class="box p-2 rounded bg-success text-center">
                    <h1 class="font-weight-light text-white">{{ $cantidadCarreras }}</h1>
                    <h6 class="text-white">Carreras</h6>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card">
                <div class="box p-2 rounded bg-warning text-center">
                    <h1 class="font-weight-light text-white">{{ $mediaPuntajeAnual }}</h1>
                    <h6 class="text-white">Media Puntaje Anual</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Column -->
        <div class="col-12">
            <div class="card">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="p-3">
                            <h2 class="text-center text-info"><strong>Porcentaje de Estudiantes por Carrera</strong></h2>
                            <!-- <div class="message-box mt-4">
                                <div class="message-widget">
                                    <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <div class="w-75 d-inline-block v-middle pl-2">
                                            <h5 class="message-title mb-0 mt-1">Pavan kumar </h5>
                                            <span class="font-12 text-nowrap d-block text-muted text-truncate">Just see the my admin!</span>
                                            <span class="font-12 text-nowrap d-block text-muted">9:30 AM</span>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="user-img position-relative d-inline-block"> <img src="../assets/images/users/2.jpg" alt="user" class="rounded-circle w-100"> <span class="profile-status rounded-circle busy"></span> </span>
                                        <div class="w-75 d-inline-block v-middle pl-2">
                                            <h5 class="message-title mb-0 mt-1">Sonu Nigam</h5> <span class="font-12 text-nowrap d-block text-muted text-truncate">I've sung a song! See you at</span> <span class="font-12 text-nowrap d-block text-muted">9:10 AM</span> </div>
                                    </a>
                                    <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="user-img position-relative d-inline-block"> <img src="../assets/images/users/3.jpg" alt="user" class="rounded-circle w-100"> <span class="profile-status rounded-circle away"></span> </span>
                                        <div class="w-75 d-inline-block v-middle pl-2">
                                            <h5 class="message-title mb-0 mt-1">Arijit Sinh</h5> <span class="font-12 text-nowrap d-block text-muted text-truncate">I am a singer!</span> <span class="font-12 text-nowrap d-block text-muted">9:08 AM</span> </div>
                                    </a>
                                    <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="user-img position-relative d-inline-block"> <img src="../assets/images/users/4.jpg" alt="user" class="rounded-circle w-100"> <span class="profile-status rounded-circle offline"></span> </span>
                                        <div class="w-75 d-inline-block v-middle pl-2">
                                            <h5 class="message-title mb-0 mt-1">Pavan kumar</h5> <span class="font-12 text-nowrap d-block text-muted text-truncate">Just see the my admin!</span> <span class="font-12 text-nowrap d-block text-muted">9:02 AM</span> </div>
                                    </a>
                                </div>
                            </div> -->
                            <div id="piechart_3d" style="width: 550px; height: 350px;"></div>
                        </div>
                    </div>
                    <div class="col-lg-8 border-left">
                        <div class="card-body">
                            <div class="d-md-flex no-block align-items-center">
                                <h4 class="font-weight-medium">Ingresos Mensuales</h4>
                                <div class="ml-auto">
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <h6 class="text-muted"><i class="fa fa-circle mr-1 text-info"></i>{{ date('Y') }}</h6>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="top_x_div" style="width: 800px; height: 350px;"></div>
                            <!-- <div class="revenue" style="height: 350px;">
                                <div id="top_x_div" style="width: 800px; height: 350px; text-align: center;"></div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>

    <!-- <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="p-3">
                            <h2>Welcome Steave</h2>
                            <h6 class="card-subtitle">you have 4 new messages</h6>
                            <div class="message-box mt-4">
                                <div class="message-widget">
                                    <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="user-img position-relative d-inline-block"> <img src="../assets/images/users/1.jpg" alt="user" class="rounded-circle w-100"> <span class="profile-status rounded-circle online"></span> </span>
                                        <div class="w-75 d-inline-block v-middle pl-2">
                                            <h5 class="message-title mb-0 mt-1">Pavan kumar</h5> <span class="font-12 text-nowrap d-block text-muted text-truncate">Just see the my admin!</span> <span class="font-12 text-nowrap d-block text-muted">9:30 AM</span> </div>
                                    </a>
                                    <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="user-img position-relative d-inline-block"> <img src="../assets/images/users/2.jpg" alt="user" class="rounded-circle w-100"> <span class="profile-status rounded-circle busy"></span> </span>
                                        <div class="w-75 d-inline-block v-middle pl-2">
                                            <h5 class="message-title mb-0 mt-1">Sonu Nigam</h5> <span class="font-12 text-nowrap d-block text-muted text-truncate">I've sung a song! See you at</span> <span class="font-12 text-nowrap d-block text-muted">9:10 AM</span> </div>
                                    </a>
                                    <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="user-img position-relative d-inline-block"> <img src="../assets/images/users/3.jpg" alt="user" class="rounded-circle w-100"> <span class="profile-status rounded-circle away"></span> </span>
                                        <div class="w-75 d-inline-block v-middle pl-2">
                                            <h5 class="message-title mb-0 mt-1">Arijit Sinh</h5> <span class="font-12 text-nowrap d-block text-muted text-truncate">I am a singer!</span> <span class="font-12 text-nowrap d-block text-muted">9:08 AM</span> </div>
                                    </a>
                                    <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="user-img position-relative d-inline-block"> <img src="../assets/images/users/4.jpg" alt="user" class="rounded-circle w-100"> <span class="profile-status rounded-circle offline"></span> </span>
                                        <div class="w-75 d-inline-block v-middle pl-2">
                                            <h5 class="message-title mb-0 mt-1">Pavan kumar</h5> <span class="font-12 text-nowrap d-block text-muted text-truncate">Just see the my admin!</span> <span class="font-12 text-nowrap d-block text-muted">9:02 AM</span> </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 border-left">
                        <div class="card-body">
                            <div class="d-md-flex no-block align-items-center">
                                <h4 class="font-weight-medium">Product Calculation</h4>
                                <div class="ml-auto">
                                    <ul class="list-inline">
                                        <li class="pl-0 list-inline-item">
                                            <h6 class="text-muted"><i class="fa fa-circle mr-1 text-success"></i>2016</h6>
                                        </li>
                                        <li class="list-inline-item">
                                            <h6 class="text-muted"><i class="fa fa-circle mr-1 text-info"></i>2020</h6>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="revenue" style="height: 350px;">
                                <div class="chartist-tooltip" style="top: 229px; left: 38.3438px;"></div>
                                <svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-line" style="width: 100%; height: 100%;">
                                    <g class="ct-grids">
                                        <line x1="30" x2="30" y1="15" y2="315" class="ct-grid ct-horizontal"></line>
                                        <line x1="168.76116071428572" x2="168.76116071428572" y1="15" y2="315" class="ct-grid ct-horizontal"></line>
                                        <line x1="307.52232142857144" x2="307.52232142857144" y1="15" y2="315" class="ct-grid ct-horizontal"></line>
                                        <line x1="446.28348214285717" x2="446.28348214285717" y1="15" y2="315" class="ct-grid ct-horizontal"></line>
                                        <line x1="585.0446428571429" x2="585.0446428571429" y1="15" y2="315" class="ct-grid ct-horizontal"></line>
                                        <line x1="723.8058035714287" x2="723.8058035714287" y1="15" y2="315" class="ct-grid ct-horizontal"></line>
                                        <line x1="862.5669642857143" x2="862.5669642857143" y1="15" y2="315" class="ct-grid ct-horizontal"></line>
                                        <line x1="1001.328125" x2="1001.328125" y1="15" y2="315" class="ct-grid ct-horizontal"></line>
                                        <line y1="315" y2="315" x1="30" x2="1001.328125" class="ct-grid ct-vertical"></line>
                                        <line y1="277.5" y2="277.5" x1="30" x2="1001.328125" class="ct-grid ct-vertical"></line>
                                        <line y1="240" y2="240" x1="30" x2="1001.328125" class="ct-grid ct-vertical"></line>
                                        <line y1="202.5" y2="202.5" x1="30" x2="1001.328125" class="ct-grid ct-vertical"></line>
                                        <line y1="165" y2="165" x1="30" x2="1001.328125" class="ct-grid ct-vertical"></line>
                                        <line y1="127.5" y2="127.5" x1="30" x2="1001.328125" class="ct-grid ct-vertical"></line>
                                        <line y1="90" y2="90" x1="30" x2="1001.328125" class="ct-grid ct-vertical"></line>
                                        <line y1="52.5" y2="52.5" x1="30" x2="1001.328125" class="ct-grid ct-vertical"></line>
                                        <line y1="15" y2="15" x1="30" x2="1001.328125" class="ct-grid ct-vertical"></line>
                                    </g>
                                    <g>
                                        <g class="ct-series ct-series-a">
                                            <path d="M30,315L30,315C76.254,302.5,122.507,288.214,168.761,277.5C215.015,266.786,261.269,249.375,307.522,249.375C353.776,249.375,400.03,315,446.283,315C492.537,315,538.791,71.25,585.045,71.25C631.298,71.25,677.552,296.25,723.806,296.25C770.06,296.25,816.313,240,862.567,240C908.821,240,955.074,277.5,1001.328,296.25L1001.328,315Z" class="ct-area"></path><path d="M30,315C76.254,302.5,122.507,288.214,168.761,277.5C215.015,266.786,261.269,249.375,307.522,249.375C353.776,249.375,400.03,315,446.283,315C492.537,315,538.791,71.25,585.045,71.25C631.298,71.25,677.552,296.25,723.806,296.25C770.06,296.25,816.313,240,862.567,240C908.821,240,955.074,277.5,1001.328,296.25" class="ct-line"></path><line x1="30" y1="315" x2="30.01" y2="315" class="ct-point" ct:value="0"></line><line x1="168.76116071428572" y1="277.5" x2="168.7711607142857" y2="277.5" class="ct-point" ct:value="2"></line><line x1="307.52232142857144" y1="249.375" x2="307.53232142857144" y2="249.375" class="ct-point" ct:value="3.5"></line><line x1="446.28348214285717" y1="315" x2="446.29348214285716" y2="315" class="ct-point" ct:value="0"></line><line x1="585.0446428571429" y1="71.25" x2="585.0546428571429" y2="71.25" class="ct-point" ct:value="13"></line><line x1="723.8058035714287" y1="296.25" x2="723.8158035714287" y2="296.25" class="ct-point" ct:value="1"></line><line x1="862.5669642857143" y1="240" x2="862.5769642857143" y2="240" class="ct-point" ct:value="4"></line><line x1="1001.328125" y1="296.25" x2="1001.338125" y2="296.25" class="ct-point" ct:value="1"></line></g><g class="ct-series ct-series-b"><path d="M30,315L30,315C76.254,290,122.507,240,168.761,240C215.015,240,261.269,315,307.522,315C353.776,315,400.03,240,446.283,240C492.537,240,538.791,315,585.045,315C631.298,315,677.552,240,723.806,240C770.06,240,816.313,315,862.567,315C908.821,315,955.074,265,1001.328,240L1001.328,315Z" class="ct-area"></path><path d="M30,315C76.254,290,122.507,240,168.761,240C215.015,240,261.269,315,307.522,315C353.776,315,400.03,240,446.283,240C492.537,240,538.791,315,585.045,315C631.298,315,677.552,240,723.806,240C770.06,240,816.313,315,862.567,315C908.821,315,955.074,265,1001.328,240" class="ct-line"></path><line x1="30" y1="315" x2="30.01" y2="315" class="ct-point" ct:value="0"></line><line x1="168.76116071428572" y1="240" x2="168.7711607142857" y2="240" class="ct-point" ct:value="4"></line><line x1="307.52232142857144" y1="315" x2="307.53232142857144" y2="315" class="ct-point" ct:value="0"></line><line x1="446.28348214285717" y1="240" x2="446.29348214285716" y2="240" class="ct-point" ct:value="4"></line><line x1="585.0446428571429" y1="315" x2="585.0546428571429" y2="315" class="ct-point" ct:value="0"></line><line x1="723.8058035714287" y1="240" x2="723.8158035714287" y2="240" class="ct-point" ct:value="4"></line><line x1="862.5669642857143" y1="315" x2="862.5769642857143" y2="315" class="ct-point" ct:value="0"></line><line x1="1001.328125" y1="240" x2="1001.338125" y2="240" class="ct-point" ct:value="4"></line></g></g><g class="ct-labels"><foreignObject style="overflow: visible;" x="30" y="320" width="138.76116071428572" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 139px; height: 20px;">0</span></foreignObject><foreignObject style="overflow: visible;" x="168.76116071428572" y="320" width="138.76116071428572" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 139px; height: 20px;">4</span></foreignObject><foreignObject style="overflow: visible;" x="307.52232142857144" y="320" width="138.76116071428572" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 139px; height: 20px;">8</span></foreignObject><foreignObject style="overflow: visible;" x="446.28348214285717" y="320" width="138.76116071428572" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 139px; height: 20px;">12</span></foreignObject><foreignObject style="overflow: visible;" x="585.0446428571429" y="320" width="138.76116071428578" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 139px; height: 20px;">16</span></foreignObject><foreignObject style="overflow: visible;" x="723.8058035714287" y="320" width="138.76116071428567" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 139px; height: 20px;">20</span></foreignObject><foreignObject style="overflow: visible;" x="862.5669642857143" y="320" width="138.76116071428567" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 139px; height: 20px;">24</span></foreignObject><foreignObject style="overflow: visible;" x="1001.328125" y="320" width="30" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 30px; height: 20px;">30</span></foreignObject><foreignObject style="overflow: visible;" y="277.5" x="10" height="37.5" width="10"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 38px; width: 10px;">0k</span></foreignObject><foreignObject style="overflow: visible;" y="240" x="10" height="37.5" width="10"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 38px; width: 10px;">2k</span></foreignObject><foreignObject style="overflow: visible;" y="202.5" x="10" height="37.5" width="10"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 38px; width: 10px;">4k</span></foreignObject><foreignObject style="overflow: visible;" y="165" x="10" height="37.5" width="10"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 38px; width: 10px;">6k</span></foreignObject><foreignObject style="overflow: visible;" y="127.5" x="10" height="37.5" width="10"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 38px; width: 10px;">8k</span></foreignObject><foreignObject style="overflow: visible;" y="90" x="10" height="37.5" width="10"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 38px; width: 10px;">10k</span></foreignObject><foreignObject style="overflow: visible;" y="52.5" x="10" height="37.5" width="10"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 38px; width: 10px;">12k</span></foreignObject><foreignObject style="overflow: visible;" y="15" x="10" height="37.5" width="10"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 38px; width: 10px;">14k</span></foreignObject><foreignObject style="overflow: visible;" y="-15" x="10" height="30" width="10"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 30px; width: 10px;">16k</span></foreignObject></g></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Row -->
    <!-- <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex align-items-center">
                        <div>
                            <h4 class="card-title">Members Activity</h4>
                            <h6 class="card-subtitle">what members preformance status</h6>
                        </div>
                        <div class="ml-auto">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary">Today</button>
                                <button type="button" class="btn btn-secondary">Week</button>
                                <button type="button" class="btn btn-secondary">Month</button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mt-5">
                        <table class="table table-hover v-middle no-wrap">
                            <thead>
                                <tr>
                                    <th class="border-0" style="width: 60px;"> Member </th>
                                    <th class="border-0">Name </th>
                                    <th class="border-0">Earnings </th>
                                    <th class="border-0">Posts </th>
                                    <th class="border-0">Reviews </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <img class="rounded-circle" src="../assets/images/users/1.jpg" alt="user" width="50"> </td>
                                    <td>
                                        <a href="javascript:;">Govinda</a>
                                    </td>
                                    <td> $325 </td>
                                    <td> 45 </td>
                                    <td>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star-half-full text-warning"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img class="rounded-circle" src="../assets/images/users/2.jpg" alt="user" width="50"> </td>
                                    <td>
                                        <a href="javascript:;">Genelia</a>
                                    </td>
                                    <td> $225 </td>
                                    <td> 35 </td>
                                    <td>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star-half-full text-warning"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img class="rounded-circle" src="../assets/images/users/3.jpg" alt="user" width="50"> </td>
                                    <td>
                                        <a href="javascript:;">Hrithik</a>
                                    </td>
                                    <td> $185 </td>
                                    <td> 28 </td>
                                    <td>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star-half-full text-warning"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img class="rounded-circle" src="../assets/images/users/4.jpg" alt="user" width="50"> </td>
                                    <td>
                                        <a href="javascript:;">Salman</a>
                                    </td>
                                    <td> $125 </td>
                                    <td> 25 </td>
                                    <td>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star-half-full text-warning"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img class="rounded-circle" src="../assets/images/users/2.jpg" alt="user" width="50"> </td>
                                    <td>
                                        <a href="javascript:;">Genelia</a>
                                    </td>
                                    <td> $225 </td>
                                    <td> 35 </td>
                                    <td>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star text-warning"></i>
                                        <i class="fa fa-star-half-full text-warning"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-center">
                            <button class="btn btn-success">Check more</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Customer Support</h4>
                    <h6 class="card-subtitle">24 new support ticket request generate</h6>
                </div>
                <div class="comment-widgets scrollable mt-2 ps-container ps-theme-default" style="height: 507px;" data-ps-id="76687600-17a5-6215-8c23-afddb7a3e6e0">
                    <div class="d-flex flex-row comment-row p-3">
                        <div class="p-2"><span class="round text-white d-inline-block text-center"><img src="../assets/images/users/1.jpg" alt="user" width="50" class="rounded-circle"></span></div>
                        <div class="comment-text w-100 py-1 py-md-3 pr-md-3 pl-md-4 px-2">
                            <h5>James Anderson</h5>
                            <p class="mb-1">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum has beenorem Ipsum is simply dummy text of the printing and type setting industry.</p>
                            <div class="comment-footer">
                                <span class="text-muted float-right">April 14, 2016</span>
                                <span class="badge badge-light-info text-info">Pending</span>
                                <span class="action-icons">
                                        <a href="javascript:void(0)" class="pl-3 align-middle"><i class="ti-pencil-alt"></i></a>
                                        <a href="javascript:void(0)" class="pl-3 align-middle"><i class="ti-check"></i></a>
                                        <a href="javascript:void(0)" class="pl-3 align-middle"><i class="ti-heart"></i></a>    
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-row comment-row p-3 active">
                        <div class="p-2"><span class="round text-white d-inline-block text-center"><img src="../assets/images/users/2.jpg" alt="user" width="50" class="rounded-circle"></span></div>
                        <div class="comment-text active w-100 py-1 py-md-3 pr-md-3 pl-md-4 px-2">
                            <h5>Michael Jorden</h5>
                            <p class="mb-1">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum has beenorem Ipsum is simply dummy text of the printing and type setting industry..</p>
                            <div class="comment-footer ">
                                <span class="text-muted float-right">April 14, 2016</span>
                                <span class="badge badge-light-success text-success">Approved</span>
                                <span class="action-icons active">
                                        <a href="javascript:void(0)" class="pl-3 align-middle"><i class="ti-pencil-alt"></i></a>
                                        <a href="javascript:void(0)" class="pl-3 align-middle"><i class="icon-close"></i></a>
                                        <a href="javascript:void(0)" class="pl-3 align-middle"><i class="ti-heart text-danger"></i></a>    
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-row comment-row p-3">
                        <div class="p-2"><span class="round text-white d-inline-block text-center"><img src="../assets/images/users/3.jpg" alt="user" width="50" class="rounded-circle"></span></div>
                        <div class="comment-text w-100 py-1 py-md-3 pr-md-3 pl-md-4 px-2">
                            <h5>Johnathan Doeting</h5>
                            <p class="mb-1">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum has beenorem Ipsum is simply dummy text of the printing and type setting industry.</p>
                            <div class="comment-footer">
                                <span class="text-muted float-right">April 14, 2016</span>
                                <span class="badge badge-light-danger text-danger">Rejected</span>
                                <span class="action-icons">
                                        <a href="javascript:void(0)" class="pl-3 align-middle"><i class="ti-pencil-alt"></i></a>
                                        <a href="javascript:void(0)" class="pl-3 align-middle"><i class="ti-check"></i></a>
                                        <a href="javascript:void(0)" class="pl-3 align-middle"><i class="ti-heart"></i></a>    
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-row comment-row p-3">
                        <div class="p-2"><span class="round text-white d-inline-block text-center"><img src="../assets/images/users/4.jpg" alt="user" width="50" class="rounded-circle"></span></div>
                        <div class="comment-text w-100 py-1 py-md-3 pr-md-3 pl-md-4 px-2">
                            <h5>James Anderson</h5>
                            <p class="mb-1">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum has beenorem Ipsum is simply dummy text of the printing and type setting industry..</p>
                            <div class="comment-footer">
                                <span class="text-muted float-right">April 14, 2016</span>
                                <span class="badge badge-light-info text-info">Pending</span>
                                <span class="action-icons">
                                            <a href="javascript:void(0)" class="pl-3 align-middle"><i class="ti-pencil-alt"></i></a>
                                            <a href="javascript:void(0)" class="pl-3 align-middle"><i class="ti-check"></i></a>
                                            <a href="javascript:void(0)" class="pl-3 align-middle"><i class="ti-heart"></i></a>    
                                        </span>
                            </div>
                        </div>
                    </div>
                <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;"><div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
            </div>
        </div>
    </div> -->
        <!-- Row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex no-block">
                        <div>
                            <h4 class="card-title">Resumen de Cuentas Pendientes</h4>
                            <h6 class="card-subtitle">Consultar los Registros Mensuales</h6>
                        </div>
                        <div class="ml-auto">
                            <select class="custom-select">
                                <option selected="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body bg-light">
                    <div class="row">
                        <div class="col-md-6">
                            <h2 class="mb-0">Enero {{ date('Y') }}</h2>
                            <h4 class="font-weight-light mt-0">Reporte de este mes</h4></div>
                        <div class="col-md-6 align-self-center display-6 text-info text-left text-md-right">3,690 Bs.</div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover no-wrap">
                        <thead>
                            <tr>
                                <th class="text-center border-0">#</th>
                                <th class="border-0">NOMBRE</th>
                                <th class="border-0">CARRERA</th>
                                <th class="border-0">FECHA</th>
                                <th class="border-0">SALDO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td class="txt-oflo">Juan Perez</td>
                                <td><span class="badge badge-success py-1">Contaduria General</span> </td>
                                <td class="txt-oflo">18 de Enero de 2020</td>
                                <td><span class="text-success">350 Bs.</span></td>
                            </tr>
                            <tr>
                                <td class="text-center">2</td>
                                <td class="txt-oflo">Jorge Alejandro Salas Aguilera</td>
                                <td><span class="badge badge-info py-1">Secretariado Administrativo</span></td>
                                <td class="txt-oflo">19 de Enero de 2020</td>
                                <td><span class="text-info">200 Bs.</span></td>
                            </tr>
                            <tr>
                                <td class="text-center">3</td>
                                <td class="txt-oflo">Maria Rene Guzman Lopez</td>
                                <td><span class="badge badge-info py-1">Secretariado Administrativo</span></td>
                                <td class="txt-oflo">19 de Enero de 2020</td>
                                <td><span class="text-info">200 Bs.</span></td>
                            </tr>
                            <tr>
                                <td class="text-center">4</td>
                                <td class="txt-oflo">Danny Mayta</td>
                                <td><span class="badge badge-danger py-1">Secretariado Administrativo</span></td>
                                <td class="txt-oflo">20 de Enero de 2020</td>
                                <td><span class="text-danger">350 Bs.</span></td>
                            </tr>
                            <tr>
                                <td class="text-center">5</td>
                                <td class="txt-oflo">Ximena Mamani</td>
                                <td><span class="badge badge-warning py-1">Contaduria General</span></td>
                                <td class="txt-oflo">21 de Enero de 2020</td>
                                <td><span class="text-success">350 Bs.</span></td>
                            </tr>
                            <tr>
                                <td class="text-center">6</td>
                                <td class="txt-oflo">Mario Colque</td>
                                <td><span class="badge badge-success py-1">Contaduria General</span> </td>
                                <td class="txt-oflo">23 de Enero de 2020</td>
                                <td><span class="text-danger">140 Bs.</span></td>
                            </tr>
                            <tr>
                                <td class="text-center">7</td>
                                <td class="txt-oflo">Shalen Valdez</td>
                                <td><span class="badge badge-success py-1">Contaduria General</span> </td>
                                <td class="txt-oflo">24 de Enero de 2020</td>
                                <td><span class="text-success">350 Bs.</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
    <!-- Row -->
    <!-- <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card bg-info">
                <div class="card-body">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item flex-column">
                                <i class="fab fa-twitter fa-2x text-white"></i>
                                <p class="text-white">25th Jan</p>
                                <h3 class="text-white font-weight-light">Now Get <span class="font-weight-bold">50% Off</span><br>on buy</h3>
                                <div class="d-flex text-white mt-3">
                                    <span>
                                        <i>- john doe</i>
                                    </span>
                                    <div class="ml-auto">
                                        <button class="btn btn-dark waves-effect waves-light mt-3">Default</button>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item flex-column">
                                <i class="fab fa-twitter fa-2x text-white"></i>
                                <p class="text-white">25th Jan</p>
                                <h3 class="text-white font-weight-light">Now Get <span class="font-weight-bold">50% Off</span><br>
                            on buy</h3>
                                <div class="d-flex text-white mt-3">
                                    <span>
                                        <i>- john doe</i>
                                    </span>
                                    <div class="ml-auto">
                                        <button class="btn btn-dark waves-effect waves-light mt-3">Default</button>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item flex-column active">
                                <i class="fab fa-twitter fa-2x text-white"></i>
                                <p class="text-white">25th Jan</p>
                                <h3 class="text-white font-weight-light">Now Get <span class="font-weight-bold">50% Off</span><br>
                            on buy</h3>
                                <div class="d-flex text-white mt-3">
                                    <span>
                                        <i>- john doe</i>
                                    </span>
                                    <div class="ml-auto">
                                        <button class="btn btn-dark waves-effect waves-light mt-3">Default</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-primary">
                <div class="card-body">
                    <div id="myCarousel2" class="carousel slide vert" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item flex-column">
                                <i class="fab fa-facebook fa-2x text-white"></i>
                                <p class="text-white">25th Jan</p>
                                <h3 class="text-white">Now Get <span class="font-weight-bold">50% Off</span><br>
                            on buy</h3>
                                <div class="d-flex text-white mt-3">
                                    <span>
                                        <i>- john doe</i>
                                    </span>
                                    <div class="ml-auto">
                                        <button class="btn btn-dark waves-effect waves-light mt-3">Default</button>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item flex-column active">
                                <i class="fab fa-facebook fa-2x text-white"></i>
                                <p class="text-white">25th Jan</p>
                                <h3 class="text-white">Now Get <span class="font-weight-bold">50% Off</span><br>
                            on buy</h3>
                                <div class="d-flex text-white mt-3">
                                    <span>
                                        <i>- john doe</i>
                                    </span>
                                    <div class="ml-auto">
                                        <button class="btn btn-dark waves-effect waves-light mt-3">Default</button>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item flex-column"> <i class="fab fa-facebook fa-2x text-white"></i>
                                <p class="text-white">25th Jan</p>
                                <h3 class="text-white">Now Get <span class="font-weight-bold">50% Off</span><br>
                            on buy</h3>
                                <div class="d-flex text-white mt-3">
                                    <span>
                                        <i>- john doe</i>
                                    </span>
                                    <div class="ml-auto">
                                        <button class="btn btn-dark waves-effect waves-light mt-3">Default</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-success">
                <div class="card-body">
                    <div id="myCarousel3" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item flex-column">
                                <i class="fas fa-map-marker-alt fa-2x text-white"></i>
                                <p class="text-white">25th Jan</p>
                                <h3 class="text-white">Now Get <span class="font-weight-bold">50% Off</span><br>on buy</h3>
                                <div class="d-flex text-white mt-3">
                                    <span>
                                        <i>- john doe</i>
                                    </span>
                                    <div class="ml-auto">
                                        <button class="btn btn-dark waves-effect waves-light mt-3">Default</button>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item flex-column active">
                                <i class="fas fa-map-marker-alt fa-2x text-white"></i>
                                <p class="text-white">25th Jan</p>
                                <h3 class="text-white">Now Get <span class="font-weight-bold">50% Off</span><br>on buy</h3>
                                <div class="d-flex text-white mt-3">
                                    <span>
                                        <i>- john doe</i>
                                    </span>
                                    <div class="ml-auto">
                                        <button class="btn btn-dark waves-effect waves-light mt-3">Default</button>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item flex-column">
                                <i class="fas fa-map-marker-alt fa-2x text-white"></i>
                                <p class="text-white">25th Jan</p>
                                <h3 class="text-white">Now Get <span class="font-weight-bold">50% Off</span><br>on buy</h3>
                                <div class="d-flex text-white mt-3">
                                    <span>
                                        <i>- john doe</i>
                                    </span>
                                    <div class="ml-auto">
                                        <button class="btn btn-dark waves-effect waves-light mt-3">Default</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div id="myCarousel4" class="carousel vert slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item flex-column">
                                <i class="fas fa-map-marker-alt fa-2x"></i>
                                <p>25th Jan</p>
                                <h3>Now Get <span class="font-weight-bold">50% Off</span><br>on buy</h3>
                                <div class="d-flex mt-3">
                                    <span>
                                        <i>- john doe</i>
                                    </span>
                                    <div class="ml-auto">
                                        <button class="btn btn-dark waves-effect waves-light mt-3">Default</button>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item flex-column active">
                                <i class="fas fa-map-marker-alt fa-2x"></i>
                                <p>25th Jan</p>
                                <h3>Now Get <span class="font-weight-bold">50% Off</span><br>on buy</h3>
                                <div class="d-flex mt-3">
                                    <span>
                                        <i>- john doe</i>
                                    </span>
                                    <div class="ml-auto">
                                        <button class="btn btn-dark waves-effect waves-light mt-3">Default</button>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item flex-column"> <i class="fas fa-map-marker-alt fa-2x"></i>
                                <p>25th Jan</p>
                                <h3>Now Get <span class="font-weight-bold">50% Off</span><br> on buy</h3>
                                <div class="d-flex mt-3">
                                    <span>
                                        <i>- john doe</i>
                                    </span>
                                    <div class="ml-auto">
                                        <button class="btn btn-dark waves-effect waves-light mt-3">Default</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Row -->
    <!-- <div class="row">
        <div class="col-lg-6">
            <div class="card earning-widget">
                <div class="card-body">
                    <div>
                        <div class="d-md-flex align-items-center no-block">
                            <div>
                                <h4 class="card-title mb-0">Total Earning</h4>
                                <h2 class="mt-1">$586</h2>
                            </div>
                            <div class="ml-auto">
                                <select class="custom-select">
                                    <option selected="">March</option>
                                    <option value="1">February</option>
                                    <option value="2">May</option>
                                    <option value="3">April</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top table-responsive">
                    <table class="table v-middle table-borderless mb-0 no-wrap">
                        <tbody>
                            <tr>
                                <td style="width:40px"><img src="../assets/images/users/1.jpg" width="50" class="rounded-circle" alt="logo"></td>
                                <td>Andrew Simon</td>
                                <td class="text-right"><span class="badge py-1 rounded text-info badge-light-info">$2300</span></td>
                            </tr>
                            <tr>
                                <td><img src="../assets/images/users/2.jpg" width="50" class="rounded-circle" alt="logo"></td>
                                <td>Daniel Kristeen</td>
                                <td class="text-right"><span class="badge py-1 rounded text-success badge-light-success">$3300</span></td>
                            </tr>
                            <tr>
                                <td><img src="../assets/images/users/3.jpg" width="50" class="rounded-circle" alt="logo"></td>
                                <td>Dany John</td>
                                <td class="text-right"><span class="badge py-1 rounded text-primary badge-light-primary">$4300</span></td>
                            </tr>
                            <tr>
                                <td><img src="../assets/images/users/4.jpg" width="50" class="rounded-circle" alt="logo"></td>
                                <td>Chris gyle</td>
                                <td class="text-right"><span class="badge py-1 rounded text-warning badge-light-warning">$5300</span></td>
                            </tr>
                            <tr>
                                <td><img src="../assets/images/users/5.jpg" width="50" class="rounded-circle" alt="logo"></td>
                                <td>Opera mini</td>
                                <td class="text-right"><span class="badge py-1 rounded text-danger badge-light-danger">$4567</span></td>
                            </tr>
                            <tr>
                                <td><img src="../assets/images/users/6.jpg" width="50" class="rounded-circle" alt="logo"></td>
                                <td>Microsoft edge</td>
                                <td class="text-right"><span class="badge py-1 rounded text-megna badge-light-megna">$7889</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Feeds</h4>
                    <ul class="feeds pl-0 mb-0 mt-3 pt-1">
                        <li class="feed-item d-flex p-2 align-items-center">
                            <a href="javascript:void(0)" class="btn btn-circle d-flex align-items-center justify-content-center bg-light-info">
                                <i class="fas fa-bell"></i>
                            </a>
                            <div class="ml-3 text-truncate">You have 4 pending tasks.</div>
                            <div class="justify-content-end text-truncate ml-auto">
                                <span class="text-muted font-12">Just Now</span>
                            </div>
                        </li>
                        <li class="feed-item d-flex p-2 align-items-center">
                            <a href="javascript:void(0)" class="btn btn-circle d-flex align-items-center justify-content-center bg-light-success">
                                <i class="ti-server"></i>
                            </a>
                            <div class="ml-3 text-truncate">Server #1 overloaded.</div>
                            <div class="justify-content-end text-truncate ml-auto">
                                <span class="text-muted font-12">2 Hours ago</span>
                            </div>
                        </li>
                        <li class="feed-item d-flex p-2 align-items-center">
                            <a href="javascript:void(0)" class="btn btn-circle d-flex align-items-center justify-content-center bg-light-warning">
                                <i class="ti-shopping-cart"></i>
                            </a>
                            <div class="ml-3 text-truncate">New order received.</div>
                            <div class="justify-content-end text-truncate ml-auto">
                                <span class="text-muted font-12">31 May</span>
                            </div>
                        </li>
                        <li class="feed-item d-flex p-2 align-items-center">
                            <a href="javascript:void(0)" class="btn btn-circle d-flex align-items-center justify-content-center bg-light-danger">
                                <i class="ti-user"></i>
                            </a>
                            <div class="ml-3 text-truncate">New user registered.</div>
                            <div class="justify-content-end text-truncate ml-auto">
                                <span class="text-muted font-12">30 May</span>
                            </div>
                        </li>
                        <li class="feed-item d-flex p-2 align-items-center">
                            <a href="javascript:void(0)" class="btn btn-circle d-flex align-items-center justify-content-center bg-light-inverse">
                                <i class="fas fa-bell"></i>
                            </a>
                            <div class="ml-3 text-truncate">New Version just arrived.</div>
                            <div class="justify-content-end text-truncate ml-auto">
                                <span class="text-muted font-12">27 May</span>
                            </div>
                        </li>
                        <li class="feed-item d-flex p-2 align-items-center">
                            <a href="javascript:void(0)" class="btn btn-circle d-flex align-items-center justify-content-center bg-light-info">
                                <i class="fas fa-bell"></i>
                            </a>
                            <div class="ml-3 text-truncate">You have 4 pending tasks. </div>
                            <div class="justify-content-end text-truncate ml-auto">
                                <span class="text-muted font-12">Just Now</span>
                            </div>
                        </li>
                        <li class="feed-item d-flex p-2 align-items-center">
                            <a href="javascript:void(0)" class="btn btn-circle d-flex align-items-center justify-content-center bg-light-danger">
                                <i class="ti-user"></i>
                            </a>
                            <div class="ml-3 text-truncate">New user registered.</div>
                            <div class="justify-content-end text-truncate ml-auto">
                                <span class="text-muted font-12">30 May</span>
                            </div>
                        </li>
                        <li class="feed-item d-flex p-2 align-items-center">
                            <a href="javascript:void(0)" class="btn btn-circle d-flex align-items-center justify-content-center bg-light-inverse">
                                <i class="fas fa-bell"></i>
                            </a>
                            <div class="ml-3 text-truncate">New Version just arrived. </div>
                            <div class="justify-content-end text-truncate ml-auto">
                                <span class="text-muted font-12">27 May</span>
                            </div>
                        </li>
                        <li class="feed-item d-flex p-2 align-items-center">
                            <a href="javascript:void(0)" class="btn btn-circle d-flex align-items-center justify-content-center bg-light-primary">
                                <i class="ti-settings"></i>
                            </a>
                            <div class="ml-3 text-truncate">You have 4 pending tasks.</div>
                            <div class="justify-content-end text-truncate ml-auto">
                                <span class="text-muted font-12">27 May</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div> -->
</div>
@endsection

@section('js')
<script src="{{ asset('assets/libs/chartist/dist/chartist.min.js') }}"></script>
<script src="{{ asset('assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/dashboards/dashboard2.js') }}"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawStuff);

    function drawStuff() {
    var data = new google.visualization.arrayToDataTable([
        ['Mes', 'Ganancia'],
        ["Enero", 4400],
        ["Febrero", 3100],
        ["Marzo", 1200],
        ["Abril", 4400],
        ["Mayo", 3100],
        ["Junio", 1200],
        ["Julio", 4400],
        ["Agosto", 3100],
        ["Septiembre", 1200],
        ["Octubre", 4400],
        ["Noviembre", 3100],
        ['Diciembre', 300]
    ]);

    var options = {
        width: 800,
        legend: { position: 'none' },
        chart: {
        title: '',
        subtitle: '' },
        axes: {
        x: {
            0: { side: 'top', label: ''} // Top x-axis.
        }
        },
        bar: { groupWidth: "90%" }
    };

    var chart = new google.charts.Bar(document.getElementById('top_x_div'));
    // Convert the Classic options to Material options.
    chart.draw(data, google.charts.Bar.convertOptions(options));
    };
</script>
<script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['Carrera', 'Cantidad por Carrera'],
        @foreach($cantidadEstudiantesCarrera as $registro)
            ['{{ $registro->carrera->nombre }}', {{ $registro->total }}],
        @endforeach
        ]);

        var options = {
          title: '',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
@endsection
