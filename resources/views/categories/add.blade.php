@extends('layouts.app')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
    <h1 class="h2">Adding new category</h1>
    <a class="btn btn-outline-secondary" href="{{route('categories.index')}}">Back to list</a>
</div>
<div class="pb-2 mb-3">
    <form id="addform" action="{{route('categories.store')}}" method="post">
        {!! csrf_field() !!}
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputTitle">Title</label>
                <input type="text" class="form-control" id="inputTitle" name="title" placeholder="The Category's Title" value="{{old('title')}}">
            </div>
            <div class="form-group col-md-6">
                <label for="inputSlug">Slug</label>
                <input type="text" class="form-control" id="inputSlug" name="slug" placeholder="A SEO friendly slug" value="{{old('slug')}}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary float-right">Add!</button>
    </form>
</div>
@endsection