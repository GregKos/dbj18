@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('css/fa.css') }}">
<link rel="stylesheet" href="{{ asset('css/tempusdominus.css') }}">
<link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
<script src="{{ asset('js/moment.js') }}"></script>
<script src="{{ asset('js/tempusdominus.js') }}"></script>
<script src="{{ asset('js/dropzone.js') }}"></script>
@endsection

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
    <h1 class="h2">Adding new post</h1>
    <a class="btn btn-outline-secondary" href="{{route('posts.index')}}">Back to list</a>
</div>
<div class="pb-2 mb-3">
    <form id="addform" action="{{route('posts.store')}}" method="post">
        {!! csrf_field() !!}
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputTitle">Title</label>
                <input type="text" class="form-control" id="inputTitle" name="title" placeholder="The Post's Title" value="{{old('title')}}">
            </div>
            <div class="form-group col-md-6">
                <label for="inputSubtitle">Subtitle</label>
                <input type="text" class="form-control" id="inputSubtitle" name="subtitle" placeholder="A short, descriptive subtitle" value="{{old('subtitle')}}">
            </div>
        </div>
        <div class="form-group">
            <label for="inputContent">Content</label>
            <textarea class="form-control" id="inputContent" rows="3" name="content" placeholder="The full post body. This could be a WYSIWYG editor.">{{old('content')}}</textarea>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Categories</label>
                <div class="form-group">
                    @foreach($categories as $category)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCategory{{$category->id}}" name="category_id[]" value="{{$category->id}}">
                        <label class="form-check-label" for="inlineCategory{{$category->id}}">{{$category->title}}</label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group col-md-6">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputState">Post Published?</label>
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="published" id="inlinePublished" value="1" @if(null === old('published') || old('published'))checked="checked"@endif>
                                <label class="form-check-label" for="inlinePublished">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="published" id="inlineUnpublished" value="0" @if(null !== old('published') && intval(old('published')) === 0)checked="checked"@endif>
                                <label class="form-check-label" for="inlineUnpublished">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6" id="published_at_container">
                        <label for="inputDate">Published At</label>
                        <div class="input-group date" id="inputDate" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" name="published_at" data-toggle="datetimepicker" data-target="#inputDate"/>
                            <div class="input-group-append" data-target="#inputDate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="far fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="filename" value="{{old('filename')}}" id="filefield">
        <button type="submit" class="btn btn-primary float-right">Add!</button>
    </form>
    <div class="row">
        <div class="col-12">
            <form action="{{route('posts.upload')}}" class="dropzone" id="my-awesome-dropzone"></form>
        </div>
    </div>
</div>
@endsection

@section('bot')
<script>
    $(function () {
        $('#inputDate').datetimepicker({
            defaultDate: "{{old('published_at')}}",
            format: 'YYYY-MM-DD HH:mm'
        });
    });
    Dropzone.autoDiscover = false;
    var myAwesomeDropzone = new Dropzone("#my-awesome-dropzone", {
        withCredentials: true,
        maxFiles: 1,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        dictDefaultMessage: 'Drop a file here to upload and add it to the post.',
        addRemoveLinks: true,
        init: function() {
            this.on('success', function(file, resp) {
                $('#filefield').val(resp.path.split('/')[2]);
            });
            this.on('removedfile', function(file) {
                if(file.name == $('#filefield').val()) {
                    $.ajax({
                        url: "/posts/upload/" + $('#filefield').val(),
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        dataType: 'json',
                        method: 'DELETE',
                        success: function(resp) {
                            if(resp.del == 'yes') $('#filefield').val('');
                        }
                    });
                }
            });
        }
    });
    @if(old('filename'))
    var mockFile = { name: "{{old('filename')}}", size: 0 };
    myAwesomeDropzone.emit("addedfile", mockFile);
    myAwesomeDropzone.emit("thumbnail", mockFile, "{{Storage::url('public/postfiles/'.old('filename'))}}");
    myAwesomeDropzone.emit("complete", mockFile);
    myAwesomeDropzone.options.maxFiles = myAwesomeDropzone.options.maxFiles - 1;
    @endif
    $('body').on('change', 'input[name=published]', function() {
        if($('input[name=published]:checked').val() == 1) {
            $('#published_at_container').show();
        } else {
            $('#published_at_container').hide();
        }
    });
    $('input[name=published]').change();
</script>
@endsection