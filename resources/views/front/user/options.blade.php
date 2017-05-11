@extends('front.layout')
@section('content')

    <section id="app">
        <h2 class="page-title">Профиль</h2>
        <profile v-bind:user="user"></profile>
    </section>



    <script type="text/x-template" id="profile">
        <div class="profile">
            <div class="profile__user-info">
                <label class="profile__avatar-block">
                    <img v-bind:src="user.avatar" alt="" class="profile__avatar">
                    <input type="file" class="form-control" v-on:change="onFileChange($event)">
                </label>
                <div class="profile__info form-group">
                    <div class="form-group__row">
                        <label class="form-group__title">ФИО</label>
                        <input type="text" class="form-control" v-model="user.fio">
                    </div>
                    <div class="form-group__row">
                        <label class="form-group__title">Пароль</label>
                        <input type="password" class="form-control" v-model="password">
                    </div>
                    <div class="form-group__row form-group__row--reverse">
                        <label class="form-group__title"></label>
                        <button type="text" class="button" v-on:click="save()">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
    </script>



@endsection
@section('scripts')
    <script src="/js/profile.js"></script>
@endsection