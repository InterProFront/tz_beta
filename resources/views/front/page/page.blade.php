@extends('front.layout')
@section('content')
     <section id="app" data-page-id="{{$page->id}}" data-project-id="{{$page->project_id}}" >
        <h2 class="page-title">{{$page->title}}</h2>
        <p class="page-description">{{$page->description}}</p>

        <ul class="change-view">
            <li class="view-item">Макет</li>
            <li class="view-item">Текст</li>
        </ul>


        <div class="miniature-wrap" v-on:click="addThread($event)">
            <img src="{{$page->picture}}" class="miniature-img" alt="">
            <buffer v-for="item in buffer" v-bind:thread_data="item"></buffer>
            <thread v-for="item in threads" v-bind:thread_data="item"></thread>
        </div>
        <div class="text-wrap">

        </div>



    </section>
     @include('front.threads.thread')
@endsection

@section('scripts')
    <script src="/js/components/buffer.js"></script>
    <script src="/js/components/thread.js"></script>
    <script src="/js/main.js"></script>
@endsection
