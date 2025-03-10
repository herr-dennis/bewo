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
              <img src="{{$item["bildUrl"]}}" alt="Aktuelles Bild von Noah">
          @endif
          @if(!$item["bildUrl"])
              <img src="{{asset('MediumSquareLogo.jpg')}}" alt="Aktuelles Bild von Noah">
          @endif
          <p>{!! nl2br(($item["text"])) !!}</p>
      </div>

  @endforeach
@endsection
