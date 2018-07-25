@extends('layouts.app')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
    <h1 class="h2">Categories List</h1>
    <a class="btn btn-primary" href="{{route('categories.create')}}">Add Category</a>
</div>
<div class="pb-2 mb-3">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if(count($categories) > 0)
                @foreach($categories as $index => $category)
                <tr>
                    <th scope="row">{{$index+1+(($categories->currentPage()-1)*$categories->perPage())}}</th>
                    <td>{{$category->title}}</td>
                    <td>{{$category->slug}}</td>
                    <td>{{$category->created_at}}</td>
                    <td>
                        <span class="text-success ml-2 clickable-custom" data-toggle="tooltip" data-placement="top" title="Edit Category (ID:{{$category->id}})">
                            <a class="text-success no-decoration" href="{{route('categories.edit', [$category->id])}}">
                                <span data-feather="edit"></span>
                            </a>
                        </span>
                        <span class="text-danger ml-2 clickable-custom" data-toggle="tooltip" data-placement="top" title="Delete Category (ID:{{$category->id}})" onclick="deleteCategory({{$category->id}})">
                            <span data-feather="delete"></span>
                        </span>
                    </td>
                </tr>
                @endforeach
                @else
                <tr class="table-warning">
                    <td colspan="5" class="text-center"><em>No categories found. Why don't you add some?</em></td>
                </tr>
                @endif
            </tbody>
            @if(count($categories) > 0)
            <tfoot>
                <tr class="text-center">
                    <td colspan="5">{{$categories->links()}}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection

@section('bot')
<script>
    /* Enable tooltips for actions */
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
    /* Function to confirm and delete a category */
    function deleteCategory(id) {
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                headers = new Headers({ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') });
                return fetch(`/categories/${id}`, { method: 'delete', headers, credentials: "same-origin" })
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