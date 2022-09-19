@extends('layouts.app')

@section('content')
    <div class="container" style="padding: 2rem 0rem">


        <div class="row">
            <div class="col-6">
                <a type="button" class="btn btn-info" href={{ route('admin.categories.create') }}>Create New</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <a href={{ route('admin.categories.edit', ['category' => $category->id]) }}
                                        type="button" class="btn btn-primary">Edit</a>
                                    {{-- <button type="button" class="btn btn-success">View</button> --}}

                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {!! $categories->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection('content')
