@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
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
                        <?php foreach($content as $v): ?>
                            @if($v->icon_name)
                            <div>
                                <a href="/content/<?php echo $v->id; ?>">
                                    <img src="{{ asset('storage/avatar/' . $v->icon_name) }}" alt="avatar" style="object-fit: cover;height: 150px;width: 150px;">

                                </a>
                                <p>spot_name: {{ $v->spot_name }}</p>
                            </div>
                            @endif
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
