@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-5">
            <ul style="color: red">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <form class="form" action={{ route('admin.tags.store') }} method="POST">
                @csrf
                <div class="col-sm-10">
                    <input class="form-control" name="name" placeholder="Name">
                    <button type="submit" class="btn btn-primary mb-2">Add</button>
                </div>
            </form>
        </div>
    </div>
@endsection('content')
