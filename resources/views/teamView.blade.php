@extends('defaultLayout')



@section("main-content")


<h1>Team</h1>



@foreach($data as $value => $item)

<div class="profile-card">
    <h2>{{$item["name"]}}</h2>
    <h3>{{$item["position"]}}</h3>

    @if(!empty($item["bildUrl"]))
    <img src="https://via.placeholder.com/100" alt="">
     @endif

        <p>{{$item["text"]}}</p>

    <div class="contact-info">


           @if($item["email"])
           <div>
               <a href="tel:024054067133">
                   <i class="fa fa-phone"></i> <!-- Telefon-Symbol -->
               </a>
               <span>{{$item["email"]}}</span>
           </div>
         @endif
               @if($item["telefon"])
               <div>

               <a href="mailto: c.paiva@bewo-walz-paiva.de">
                   <i class="fa fa-comment"></i> <!-- Telefon-Symbol -->
               </a>
               <span> {{$item["telefon"]}}</span>
           </div>
               @endif
    </div>
</div>

@endforeach

@endsection

