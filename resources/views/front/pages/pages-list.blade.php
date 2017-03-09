@extends('front.layout')
@section('content')
    <section id="app">
        <h2 class="page-title">{{$project->title}}</h2>
        <p class="page-description">{{$project->description}}</p>
        <add_user></add_user>
        <ul class="projects-list">
            @foreach($pages as $item)
                <li class="projects-list__item project-item">
                    <a href="/project/{{$project->slug}}/page/{{$item->slug}}">
                        <div class="project-item__image-wrap">
                            <img src="{{$item->picture}}" alt="">
                        </div>
                        <div class="project-item__text-wrap">
                            <p class="project-item__project-name">{{$item->title}}</p>
                            <p class="project-item__project-description">{{$item->description}}</p>
                        </div>
                    </a>
                </li>
            @endforeach
            <li class="projects-list__item project-item">
                <a href="/project/{{$project->slug}}/add">
                    <div class="project-item__image-wrap">
                        <img src="/img/plus.jpg" alt="">
                    </div>
                    <div class="project-item__text-wrap">
                        <p class="project-item__project-name">Добавить страницу</p>
                    </div>
                </a>
            </li>
        </ul>
    </section>
    <script type="text/x-template" id="add_user">
        <div class="form-group">
            <div class="form-group__row">
                <label class="form-group__title" >Эл. почта</label>
                <input class="form-control" v-model="email" type="text">
            </div>
            <div class="form-group__row form-group__row--reverse">
                <button class="button" v-on:click="addUser({{$project->id}})">Добавить пользователя</button>
            </div>
        </div>
    </script>
@endsection
@section('scripts')
    <script src="/js/addproject.js"></script>
@endsection