<table class="table table-hover" id="example3">
    <thead class="centered">  
        <th></th>  
        <th>ID</th>
        <th>Pregunta</th>
        <th>Respuesta</th>
        <th>Foto</th>
        <th>Acciones</th>
    </thead>
    <tbody id="" class="">
        @if(count($faqs) > 0)                    
            @foreach($faqs as $faq)
                <tr id="{{$faq->id}}">
                    <td class="small-cell v-align-middle">
                        <div class="checkbox check-success">
                            <input id="checkbox{{$faq->id}}" type="checkbox" class="checkDelete" value="1">
                            <label for="checkbox{{$faq->id}}"></label>
                        </div>
                    </td>
                    <td>{{$faq->id}}</td>
                    <td>{{$faq->question}}</td>
                    <td class="text"> <span>{{$faq->answer}}</span></td>
                    <td>
                        <a class="document-read" href="{{url($faq->img)}}" data-lightbox='preview' data-title='Imágen'>Ver foto actual <i class="fa fa-file-image-o" aria-hidden="true"></i></a>
                    </td>
                    <td>
                        <a href="{{url("admin/faqs/form/$faq->id")}}"><button type="button" class="btn btn-info edit-row">Editar</button></a>
                        <button type="button" class="btn btn-danger delete-row" change-to="0">Borrar</button>
                    </td>
                </tr>
            @endforeach
        @endif  
    </tbody>
</table>