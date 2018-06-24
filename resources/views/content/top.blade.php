@extends('layouts.app')

@section('content')

<div class="container">

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
                div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group clearfix">
                <h2>#new</h2>
                <?php ContentList($content); ?>
            </div>
            <div class="form-group clearfix">
                <h2>#popular</h2>
                <?php ContentList($popular); ?>
            </div>
            <div class="form-group clearfix">
                <h2>#area</h2>
            </div>
            <div class="form-group clearfix">
                <h2>#area 現在地周辺のスポット</h2>

            </div>

        </div>
    </div>
</div>

<?php

function ContentList($content)
{
    $content = array_reverse($content);
    foreach($content as $v):
    ?>
        <a href="/content/<?php echo $v['id']; ?>">
            <div class="card_item">
                <?php
                    $i = 0;
                    $num = 1;
                    foreach ($v['img'] as $img) {
                        if($i >= $num){
                            break;
                        }else{
                            echo "<img class='card_item_img' src='/item/$img'>";
                                $i++;
                            }
                        }
                ?>
                <div class="card_item_detail">
                    <p class="card_item_name">spot_name: {{ $v['spot_name'] }}</p>
                    <p class="rating-number">{{ $v['rating'] }}</p>
                    <span class="star-rating">
                        <?php for($i = 1; $i <= $v['rating']; $i++): ?>
                            <i class="star"></i>
                        <?php endfor; ?>
                    </span>
                </div>
            </div>
        </a>
    <?php endforeach;
} ?>

@endsection
