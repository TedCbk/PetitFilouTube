@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Channel Settings') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="/channel/{{ $channel->slug }}/edit" method="POST">

                    <div class="form-group{{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $channel->name}}">

                        @if ($errors->has('name'))
                            <div class="help-block">
                                {{ $errors->first('name') }}
                            </div>
                        @endif    
                    </div>

                    <div class="form-group{{ $errors->has('slug') ? 'has-error' : '' }}">
                        <label for="slug">Unique URL</label>

                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text" id="basic-addon3">{{ config('app.url')}}/channel/</span></div>
                            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') ? old('slug') : $channel->slug}}">
                        </div>
                        

                        @if ($errors->has('slug'))
                            <div class="help-block">
                                {{ $errors->first('slug') }}
                            </div>
                        @endif    
                    </div>

                    <div class="form-group{{ $errors->has('description') ? 'has-error' : '' }}">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control">{{ old('description') ? old('description') : $channel->description}}</textarea>                        

                        @if ($errors->has('description'))
                            <div class="help-block">
                                {{ $errors->first('description') }}
                            </div>
                        @endif    
                    </div>

                    <button class="btn btn-primary" type="submit">Update</button>

                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    

                </form>    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
