@extends('front.layout')
@section('content')
    <section id="app" data-page-id="{{$page->id}}" data-project-id="{{$page->project_id}}">
        <h2 class="page-title">{{$page->title}}</h2>
        <p class="page-description">{{$page->description}}</p>
        <ul class="change-view">
            <li class="change-view__item" v-bind:class="{active: tab == 'maket'}" v-on:click="setTabState('maket')">Макет</li>
            <li class="change-view__item" v-bind:class="{active: tab == 'text'}" v-on:click="setTabState('text')">Текст</li>
        </ul>


        <div class="miniature-wrap"
             v-on:click="addThread($event)"
             v-if="tab == 'maket'"
        >
            <img src="{{$page->picture}}" class="miniature-img" alt="">
            <buffer v-for="item in buffer" v-bind:thread_data="item"></buffer>
            <thread v-for="item in threads" v-bind:thread_data="item"></thread>
        </div>
        <div class="text-wrap" v-if="tab == 'text'">
            <ul class="thread__list">
                <text_thread v-for="item in threads" v-bind:thread_data="item"></text_thread>
            </ul>
        </div>


    </section>
    @include('front.threads.thread')
    @include('front.threads.comment')

    @include('front.threads.text_thread')
    @include('front.threads.text_comment')
@endsection

@section('scripts')
    <script src="/js/components/buffer.js"></script>
    <script src="/js/components/comment.js"></script>
    <script src="/js/components/thread.js"></script>
    <script src="/js/components/text_thread.js"></script>
    <script src="/js/components/text_comment.js"></script>
    <script src="/js/main.js"></script>
@endsection
