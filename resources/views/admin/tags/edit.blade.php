@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-5">
            <ul style="color: red">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <form class="form" action={{ route('admin.tags.update', $tag) }} method="POST">
                @csrf
                @method('PUT')
                <div class="col-sm-10">
                    <input class="form-control" name="name" placeholder="Name" value="{{ old('name', $tag->name) }}"
                        required>
                    <button type="submit" class="btn btn-primary mb-2">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection('content')
