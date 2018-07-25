@if($errors->any())
    <script>
        swal({
            type: 'error',
            title: 'Please correct the following issues',
            html: '<ul style="list-style: none;padding-left: 0;">@foreach($errors->all() as $error)<li>{{$error}}</li>@endforeach</ul>'
        })
    </script>
@endif
@if(session('success'))
    <script>
        swal({
            position: 'top-end',
            type: 'success',
            title: '{{session('success')}}',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
@endif
@if(session('error'))
    <script>
        swal({
            position: 'top-end',
            type: 'error',
            title: '{{session('error')}}',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
@endif