@extends('front.layout')
@section('content')
    <section>
        <h2 class="page-title">{{$project->title}}</h2>
        <p class="page-description">{{$project->description}}</p>
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
@endsection