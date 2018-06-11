@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    <!-- {!! Form::open(['url' => '/upload', 'method' => 'post', 'files' => true]) !!} -->

                    <!-- success message -->
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- error message -->
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <?php echo $user->avatar_name; ?>
                        @if($user->avatar_name)
                            <p>
                                <img src="{{ asset('storage/avatar/' . $user->avatar_name) }}" alt="avatar" style="object-fit: cover;height: 150px;width: 150px;">
                            </p>
                        @endif
                        <!-- {!! Form::label('file', 'upload img', ['class' => 'control-label']) !!}
                        {!! Form::file('file') !!} -->
                    </div>
                    <div class="form-group">
                        <!-- {!! Form::submit('upload', ['class' => 'btn btn-default']) !!} -->
                    </div>
                    <!-- {!! Form::close() !!} -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
