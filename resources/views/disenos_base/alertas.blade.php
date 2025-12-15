<!-- Mensajes de validación -->
@if(@$errors && $errors->any()) 
<div id="mensajeAlerta" class="alert alert-warning alert-dismissible fade show" role="alert">
    <ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<script type="text/javascript">
    setTimeout(function(){
        $("#mensajeAlerta").remove();
    }, 8000);
</script>
@endif

