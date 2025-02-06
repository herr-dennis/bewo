@extends("defaultLayout")

@section("main-content")




    <h3>Übersicht</h3>



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




     <form class="formContainer" action="{{route("Delete")}}" method="post" >
         @csrf
         <p>Geben Sie zum Löschen die ID ein:</p>
         <input type="text" name="id"  placeholder="ID eingeben" required >
         <input type="submit" value="Löschen">
         <input type="hidden" id="formDelete" name="formDelete" value="delete" >
     </form>






@endsection
