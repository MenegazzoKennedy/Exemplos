@if (session('success'))
    <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <strong>Sucesso - </strong> {{ session('success') }}
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning alert-dismissible bg-warning text-white border-0 fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <strong>Atenção - </strong> {{ session('warning') }}
    </div>
@endif

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
</script>

@if (session('sweet-success'))
    <script>
        Toast.fire({
            type: 'success',
            title: "Sucesso - {{ session('sweet-success') }}"
        })
    </script>    
@endif

@if (session('sweet-info'))
    <script>
        Toast.fire({
            type: 'info',
            title: "Info - {{ session('sweet-info') }}"
        })
    </script>    
@endif

@if (session('sweet-error'))
    <script>
        Toast.fire({
            type: 'error',
            title: "Erro - {{ session('sweet-error') }}"
        })
    </script>    
@endif

@if (session('sweet-warning'))
    <script>
        Toast.fire({
            type: 'warning',
            title: "Atenção - {{ session('sweet-warning') }}"
        })
    </script>    
@endif

@if (session('sweet-question'))
    <script>
        Toast.fire({
            type: 'question',
            title: "Ops - {{ session('sweet-question') }}"
        })
    </script>    
@endif

@if ($errors->any())                 
    @foreach ($errors->all() as $error)
        <script>
            Toast.fire({
                type: 'warning',
                title: "{{ $error }}"
            })
        </script>
    @endforeach
@endif