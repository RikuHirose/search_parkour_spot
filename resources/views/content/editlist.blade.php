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
                        <?php foreach($content as $v): ?>
                            @if($v->icon_name)
                            <div>
                                <p>
                                    <img src="{{ asset('storage/avatar/' . $v->icon_name) }}" alt="avatar" style="object-fit: cover;height: 150px;width: 150px;">
                                    {{ $v->id }}
                                        <!-- show -->
                                        <button type="button" class="btn btn-default">
                                            <a href="/content/<?php echo $v->id; ?>">show</a>
                                        </button>
                                        <!-- edit -->
                                        <button type="button" class="btn btn-default">
                                            <a href="/content/<?php echo $v->id; ?>/edit">edit</a>
                                        </button>
                                        <!-- delete -->
                                        <button type="button" class="btn btn-default" id="content_delete">
                                            {!! Form::open(['url' => '/content/'.$v->id, 'method' => 'delete', 'onSubmit' => 'return check()']) !!}

                                                {!! Form::hidden('id',$v->id) !!}
                                                {!! Form::submit('delete',['class' => 'btn btn-default', 'name' => 'btn']) !!}

                                            {!! Form::close() !!}
                                        </button>
                                </p>
                            </div>
                            @endif
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>

function check(){

if(window.confirm('削除しますか？')){
        return true;
    }
    else{
        window.alert('キャンセルされました');
        return false;
    }
}

</script>
@endsection
