<!-- Alertas de acciones realizadas -->
@if(session()->has('message')) 
<div id="alert-session" class="alert alert-{{ session()->get('type') }} alert-dismissible fade show" role="alert">
    {{ session()->get('message') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<script type="text/javascript">
    setTimeout(function(){
        $("#alert-session").remove();
    }, 5000);
</script>
@endif