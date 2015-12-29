@extends('app')

@section('page-title')
    {{Config::get('app.name')}}
@endsection

@section('navbar')
    @include('partials.fixedNav')
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="content-background">
                    <h1 class="form-title">Reset Password</h1>

                    @include('partials.display-input-error')

                    {!! Form::open(array('url' => '/password/reset', 'class'=>'form-horizontal')) !!}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group">
                            {!! Form::label('email', 'Email', ['class' => 'col-sm-3 control-label form-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('password', 'password', ['class' => 'col-sm-3 control-label form-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'col-sm-3 control-label form-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-offset-4 col-sm-4">
                                <button type="submit" id="reset-password-link" class="btn btn-primary btn-block">Reset Password</button>
                            </div>
                        </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <div class="col-md-8 col-md-offset-2">
        @include('partials.footer')
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\StoreGameRequest') !!}
@endsection