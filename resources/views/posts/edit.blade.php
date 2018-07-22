@extends('layouts.app')

@section('head')
<script src="{{ asset('js/sweetalert2.js') }}"></script>
{{-- <script src="{{ asset('js/promise-polyfill.js') }}"></script> --}}
@endsection

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
    <h1 class="h2">@if(isset($post)) Editing "{{$post->title}}" @else Post not found... @endif</h1>
    <a class="btn btn-outline-secondary" href="{{route('posts.index')}}">Back to list</a>
</div>
<div class="pb-2 mb-3">
    {{-- @if(isset($post))
    <pre>{{print_r($post)}}</pre>
    @endif --}}
    <form action="{{route('posts.update')}}">
        {!! csrf_field() !!}
    </form>
</div>
@endsection

@section('bot')
<script>

</script>
@endsection