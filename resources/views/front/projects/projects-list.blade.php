@extends('front.layout')
@section('content')
    <section>
        <h2 class="page-title">Список проектов</h2>
        <ul class="projects-list">
            @foreach($projects as $item)
                <li class="projects-list__item project-item">
                    <a href="/project/{{$item->slug}}">
                        <div class="project-item__image-wrap">
                            <img src="/img/place.jpg" alt="">
                        </div>
                        <div class="project-item__text-wrap">
                            <p class="project-item__project-name">{{$item->title}}</p>
                            <p class="project-item__project-description">{{$item->description}}</p>
                        </div>
                    </a>
                </li>
            @endforeach
                <li class="projects-list__item project-item">
                    <a href="/projects/add">
                        <div class="project-item__image-wrap">
                            <img src="/img/plus.jpg" alt="">
                        </div>
                        <div class="project-item__text-wrap">
                            <p class="project-item__project-name">Добавить проект</p>
                        </div>
                    </a>
                </li>
        </ul>
    </section>
@endsection    