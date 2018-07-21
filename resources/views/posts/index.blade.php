@extends('layouts.app')

@section('head')
<script src="{{ asset('js/sweetalert2.js') }}"></script>
{{-- <script src="{{ asset('js/promise-polyfill.js') }}"></script> --}}
@endsection

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
    <h1 class="h2">Post List</h1>
    <div class="btn btn-primary">Add Post</div>
</div>
<div class="pb-2 mb-3">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Published At</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if(count($posts) > 0)
                @foreach($posts as $index => $post)
                <tr>
                    <th scope="row">{{$index+1+(($posts->currentPage()-1)*$posts->perPage())}}</th>
                    <td>{{$post->title}}</td>
                    <td>{{$post->created_at}}</td>
                    <td>@if($post->published) {{$post->published_at}} @else <em class="text-danger">Unpublished</em> @endif</td>
                    <td>
                        @if($post->published)
                        <span class="text-primary clickable-custom" data-toggle="tooltip" data-placement="top" title="Unpublish Post {{$post->id}}" onclick="togglePublished({{$post->id}}, 0)">
                            <span data-feather="eye"></span>
                        </span>
                        @else
                        <span class="text-secondary clickable-custom" data-toggle="tooltip" data-placement="top" title="Publish Post {{$post->id}}" onclick="togglePublished({{$post->id}}, 1)">
                            <span data-feather="eye-off"></span>
                        </span>
                        @endif
                        <span class="text-success ml-2 clickable-custom" data-toggle="tooltip" data-placement="top" title="Edit Post {{$post->id}}">
                            <span data-feather="edit"></span>
                        </span>
                        <span class="text-danger ml-2 clickable-custom" data-toggle="tooltip" data-placement="top" title="Delete Post {{$post->id}}" onclick="deletePost({{$post->id}})">
                            <span data-feather="delete"></span>
                        </span>
                    </td>
                </tr>
                @endforeach
                @else
                <tr class="table-warning">
                    <td colspan="5" class="text-center"><em>No posts found. Why don't you add some?</em></td>
                </tr>
                @endif
            </tbody>
            @if(count($posts) > 0)
            <tfoot>
                <tr class="text-center">
                    <td colspan="5">{{$posts->links()}}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection

@section('bot')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
    function deletePost(id) {
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#fdfdfe',
            confirmButtonText: 'Yes, delete it!',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                headers = new Headers({ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') });
                return fetch(`/posts/${id}`, { method: 'delete', headers, credentials: "same-origin" })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    swal.showValidationError(
                        `Request failed: ${error}`
                    )
                })
            },
            allowOutsideClick: () => !swal.isLoading()
        }).then((result) => {
            if (result.value.type === 'success') {
                swal({
                    title: `Successfully Deleted`,
                    type: 'success'
                }).then((result) => {
                    window.location.reload();
                })
            } else {
                swal({
                    title: `Something went wrong...`,
                    type: 'error'
                })
            }
        });
    }
</script>
@endsection