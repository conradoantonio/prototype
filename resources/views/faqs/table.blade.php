<table class="table table-hover" id="example3">
    <thead class="centered">    
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
                    <td>{{$faq->id}}</td>
                    <td>{{$faq->question}}</td>
                    <td class="text"> <span>{{$faq->answer}}</span></td>
                    <td>
                        <a class="document-read" href="{{url($faq->img)}}" data-lightbox='preview' data-title='Imágen'>Ver foto actual <i class="fa fa-file-image-o" aria-hidden="true"></i></a>
                    </td>
                    <td>
                        <button type="button" class="btn btn-info edit-row">Editar</button>
                        <button type="button" class="btn btn-danger delete-row" change-to="0">Borrar</button>
                    </td>
                </tr>
            @endforeach
        @endif  
    </tbody>
</table>