@extends('layouts.app')

@section('content')

    <div class="wrap">
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
                            <div>
                                <p>
                                    <?php foreach($v['img'] as $img): ?>
                                        <img class="card_item_img" src="/item/{{ $img }}" style="height: 50px; width: 50px;">
                                    <?php endforeach; ?>
                                    {{ $v['id'] }}
                                        <!-- show -->
                                        <button type="button" class="btn btn-default">
                                            <a href="/content/{{ $v['id'] }}">show</a>
                                        </button>
                                        <!-- edit -->
                                        <button type="button" class="btn btn-default">
                                            <a href="/content/{{ $v['id'] }}/edit">edit</a>
                                        </button>
                                        <!-- delete -->
                                        <button type="button" class="btn btn-default" id="content_delete">
                                            {!! Form::open(['url' => '/content/'.$v['id'], 'method' => 'delete', 'onSubmit' => 'return check()']) !!}

                                                {!! Form::hidden('id',$v['id']) !!}
                                                {!! Form::submit('delete',['class' => 'btn btn-default', 'name' => 'btn']) !!}

                                            {!! Form::close() !!}
                                        </button>
                                </p>
                            </div>
                        <?php endforeach; ?>
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
