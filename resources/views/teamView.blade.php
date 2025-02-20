@extends('defaultLayout')


 @section("titel", "Bewo-Paiva Team")
@section("main-content")


<h1>Team</h1>

<div class="defaultContainer">
    <p>Wir unterstützen durch unsere Leistungsangebote mehr als 100 Menschen in der Städteregion, die in unterschiedlichen Lebenssituationen und mit vielfältigen Bedürfnissen zu uns kommen. Mit einem multiprofessionellen Team aus erfahrenen Fachkräften aus den verschiedensten Berufsgruppen stellen wir sicher, dass jeder individuell und umfassend begleitet wird.</p>

    <p>Unsere Expertise reicht von der psychischen Gesundheitsförderung bis hin zu praktischen Alltagsfragen. Durch unsere vielseitigen Qualifikationen können wir gezielt auf die unterschiedlichen Anforderungen eingehen und jedem Menschen die Unterstützung bieten, die er benötigt.</p>



</div>



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
           <div class="contact-email" >
               <a href="{{"mailto:".$item["email"]}}">
                   <i class="fa fa-comment-alt"></i> <!-- Telefon-Symbol -->
               </a>
               <div>{{$item["email"]}}</div>
           </div>
         @endif
               @if($item["telefon"])
               <div class="contact-telefon" >
               <a href="{{"tel:".$item['telefon']}}">
                   <i class="fa fa-phone"></i> <!-- Telefon-Symbol -->
               </a>
               <div> {{$item["telefon"]}}</div>
           </div>
               @endif
    </div>
</div>

@endforeach

@endsection

