@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="mx-auto" style="width: 200px;">
                        <div class="card-header">{{ __('Articles') }}</div>
                        <div class="card-body">
                            <a type="button" class="btn btn-primary" href={{ route('admin.posts.create') }}>Create</a>
                            <a type="button" class="btn btn-secondary" href={{ route('admin.posts.index') }}>List</a>
                        </div>

                        <div class="card-header">{{ __('Categories') }}</div>
                        <div class="card-body">
                            <a type="button" class="btn btn-primary" href={{ route('admin.categories.create') }}>Create</a>
                            <a type="button" class="btn btn-secondary" href={{ route('admin.categories.index') }}>List</a>
                        </div>

                        <div class="card-header">{{ __('Tags') }}</div>
                        <div class="card-body">
                            <a type="button" class="btn btn-primary" href={{ route('admin.tags.create') }}>Create</a>
                            <a type="button" class="btn btn-secondary" href={{ route('admin.tags.index') }}>List</a>
                        </div>
                        <div class="mx-auto" style="width: 200px;">

                        </div>
                    </div>
                </div>
            </div>
        @endsection
