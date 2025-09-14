@extends('defaultLayout')
@section("titel", "BeWo-Paiva | Aktuelles")
@section("beschreibung", " Aktuelle Termine, Newsletter")
@section("main-content")

  <h1 class="headline" >Aktuelles</h1>

  @foreach( $data as $value => $item)

      <div class="aktuellesContainer">
          <p class="date">{{ \Carbon\Carbon::parse($item['datum'])->format('d.m.y') }}</p>

          <h2>{{$item["veranstaltung"]}}</h2>
          @if($item["bildUrl"])
              <img src="{{$item["bildUrl"]}}" alt="Logo">
          @endif
          @if(!$item["bildUrl"])
              <img src="{{asset('MediumSquareLogo.jpg')}}" alt="Logo">
          @endif
          <p>{!! nl2br(($item["text"])) !!}</p>
      </div>

  @endforeach
  <script>
      document.addEventListener("DOMContentLoaded", () => {
          const containers = document.querySelectorAll(".aktuellesContainer");

          const observer = new IntersectionObserver((entries, observer) => {
              entries.forEach(entry => {
                  if (entry.isIntersecting) {
                      entry.target.classList.add("show");
                      observer.unobserve(entry.target); // nur einmal animieren
                  }
              });
          }, { threshold: 0.2 }); // 20% im Viewport sichtbar

          containers.forEach(container => {
              observer.observe(container);
          });
      });
  </script>

@endsection
