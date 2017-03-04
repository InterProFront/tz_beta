@extends('front.layout')
@section('content')
    <section id="app">
        <h2 class="page-title">Новый проект</h2>
        <add_project></add_project>
    </section>

    <script type="text/x-template" id="addproject">
        <div class="form-group">
            <div class="form-group__row">
                <label class="form-group__title">Название проекта</label>
                <input class="form-control" v-model="title" type="text">
            </div>
            <div class="form-group__row">
                <label class="form-group__title" >Описание проекта</label>
                <textarea class="form-control" v-model="description"></textarea>
            </div>
            <div class="form-group__row--reverse">
                <button class="button" v-on:click="newProject()">Создать проект</button>
            </div>
        </div>
    </script>
@endsection
@section('scripts')
    <script src="/js/addproject.js"></script>
@endsection