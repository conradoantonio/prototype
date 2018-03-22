<table class="table table-hover" id="example3">
    <thead class="centered">  
        <th></th>  
        <th>ID</th>
        <th>Título</th>
        <th>Contenido</th>
        <th>Foto</th>
        <th>Acciones</th>
    </thead>
    <tbody>
        @if($news)                    
            @foreach($news as $new)
                <tr>
                    <td class="small-cell v-align-middle">
                        <div class="checkbox check-success">
                            <input id="checkbox{{$new->id}}" type="checkbox" class="checkDelete" value="1">
                            <label for="checkbox{{$new->id}}"></label>
                        </div>
                    </td>
                    <td>{{$new->id}}</td>
                    <td>{{$new->title}}</td>
                    <td class="text"> <span>{{$new->content}}</span></td>
                    <td>
                        <a class="document-read" href="{{url($new->img)}}" data-lightbox='preview' data-title="Imágen">Ver foto actual <i class="fa fa-file-image-o" aria-hidden="true"></i></a>
                    </td>
                    <td>
                        <a href="{{url("admin/noticias/form/$new->id")}}"><button type="button" class="btn btn-info edit-row">Editar</button></a>
                        <button type="button" class="btn btn-danger delete-row" change-to="0">Borrar</button>
                    </td>
                </tr>
            @endforeach
        @endif  
    </tbody>
</table>