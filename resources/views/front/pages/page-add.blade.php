@extends('front.layout')
@section('content')
    <section id="app">
        <h2 class="page-title">Новая страница</h2>
        <add_page></add_page>
    </section>



    <script type="text/x-template" id="add_page">
        <div class="form-group">
            <div class="form-group__row">
                <label class="form-group__title" >Название Страницы</label>
                <input class="form-control" v-model="title" type="text">
            </div>
            <div class="form-group__row">
                <label class="form-group__title">Описание Страницы</label>
                <textarea class="form-control" v-model="description"></textarea>
            </div>
            <div class="form-group__row">
                <label class="form-group__title">Макет</label>
                <input type="file" class="form-control" v-on:change="onFileChange($event)">
            </div>
            <div class="form-group__row form-group__row--reverse">
                <button class="button" v-on:click="newPage({{$project->id}})">Создать проект</button>
            </div>
        </div>
    </script>
@endsection
@section('scripts')
    <script src="/js/addproject.js"></script>
@endsection