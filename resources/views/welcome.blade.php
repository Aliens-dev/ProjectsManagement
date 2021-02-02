


@extends('layouts.app')

    @section('content')
        <div class="home-page">
            <div class="container">
                <div class="desc">
                    <h1>Work Perfectly with Us</h1>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusantium amet, aut consequuntur cum dolores,
                        enim magni necessitatibus nesciunt perspiciatis quasi ratione similique voluptates.
                        A aliquid dignissimos earum rem sequi?
                    </p>
                    <div class="controls">
                        <a href="{{ route('login') }}" class="get-started">Get Started</a>
                        <a class="watch">Watch a Video</a>
                    </div>
                </div>
                <div class="image">
                    <img src="/img/home.svg" alt="home-image" />
                </div>
            </div>
        </div>
        @endsection
