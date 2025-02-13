@extends("defaultLayout")

@section("main-content")

    <h1 class="headline">Übersicht</h1>

    <div class="übersicht">
        <table class="mitarbeiter-tabelle">
            <thead>
            <tr>
                <th>Name</th>
                <th>ID</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item["name"] }}</td>
                    <td>{{ $item["id"] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

     <form class="formContainer" action="{{route("Delete")}}" id="formDelete"  method="post" >
         @csrf
         <p>Geben Sie zum Löschen die ID ein:</p>
         <input type="text" name="id"  placeholder="ID eingeben" required >
         <input type="submit" value="Löschen">
     </form>

    @if(\Illuminate\Support\Facades\Session::has("error"))
        <label class="errorMsg">{{ \Illuminate\Support\Facades\Session::get('error') }}</label>
    @endif


    <h1 class="headline">Abonnierte Newsletter</h1>

    <div class="übersicht">
        <table class="mitarbeiter-tabelle">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Zustimmen</th>

            </tr>
            </thead>
            <tbody>
            @foreach($data_2 as $item)
                <tr>
                    <td>{{ $item["name"] }}</td>
                    <td>{{$item["email"]}}</td>
                    <td>{{$item["consent_given_at"]}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>





@endsection
