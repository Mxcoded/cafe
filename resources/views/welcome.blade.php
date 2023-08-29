<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
         
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Restulator Home</title>
    @include('assets.css')
    <style>
        .badge{
            font-size: 20px!important;
        }
        .dish{
            padding-bottom: 25px;
            border: 1px solid orangered;
            margin-bottom: 25px;
            /*margin-right: 1px;*/
        }
    </style>
     <link rel="apple-touch-icon" sizes="180x180" href="uploads/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="uploads/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="uploads/favicon-16x16.png">
</head>
<body>
<!-- Top Bar Start -->
<div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
            <a href="{{url('/')}}" class="logo">
                <i class="icon-c-logo my-logo">B</i>
                <span class="my-logo">BricksCafe</span>
            </a>

        </div>
    </div>

    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="">


                @if (Route::has('login'))
                <ul class="nav navbar-nav hidden-xs pull-right">
                    @if (Auth::check())
                        <li><a href="{{url('/home')}}" class="waves-effect waves-light">Home</a></li>
                    @else
                    <li><a href="{{route('login')}}" class="waves-effect waves-light">Login</a></li>
                    <li><a href="{{route('register')}}" class="waves-effect waves-light">Join</a></li>
                    @endif

                </ul>
                @endif
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>
<!-- Top Bar End -->

    <?php $dishes = \App\Model\Dish::where('status',1)->get(); ?>

    <div style="margin-top: 70px">
        <div class="card-box">
            <center>
                <h1>Menus</h1>

            </center>
            <div class="dishes">
                <div class="row">
                    @foreach($dishes as $dish)
                    <div class="col-sm-6 col-lg-4">
                <div class="card-box">
                    <div class="contact-card">
                        <a class="pull-left" href="#">
                            <img class="" src="{{$dish->thumbnail}}" alt="">
                        </a>
                        
                        <div class="member-info">
                            <h4 class="m-t-0 m-b-5 header-title"><b>{{$dish->dish}}</b></h4>
                            <ul class="list-group">
                                @foreach($dish->dishPrices as $price)
                                <li class="list-group-item">
                                    <span class="badge">{{config('restaurant.currency.symbol')}}{{number_format($price->price,2)}}</span>
                                    {{$price->dish_type}}
                                </li>
                                    @endforeach
                            </ul>
                        </div>
                        <!--<div class="col-sm-3">
                           @foreach($dish->dishImages as $image)
                                <div class="col-md-3">
                                    <img src="{{url($image->image)}}" class="img-responsive img-thumbnail" alt="">
                                </div>
                           @endforeach
                        </div>-->
                        </div>
                    </div></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</body>
</html>