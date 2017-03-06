<script type="text/x-template" id="thread">

    <div class="thread"  v-bind:style="{left: thread_data.left+'px', top: thread_data.top+'px'}">
        <div class="thread__mark" v-on:click.stop.prevent="">
            <span class="thread__number">@{{ thread_data.index_number }}</span>
        </div>

        <div class="thread__body" v-on:click.stop.prevent="">
            <div class="thread__options" v-if="thread_data.state == 'idle'">
                <div class="thread__icon">
                </div>
                <ul class="thread__options-list">
                    <li class="thread__option-item" v-on:click="editThis()">Редактировать</li>
                    <li class="thread__option-item" v-on:click="removeThis()">Удалить</li>
                    <li class="thread__option-item">Готово</li>
                </ul>
            </div>


            <div class="thread__author author">
                <div class="author__avatar">
                    <img v-bind:src="thread_data.user.avatar" alt="">
                </div>
                <div class="author__name-and-time">
                    <p class="author__name">@{{ thread_data.user.fio }}</p>
                    <p class="author__time">12 марта, 20:30</p>
                </div>
            </div>

            <div class="thread__box" v-if="thread_data.state == 'add' ">
                <div class="thread__row">
                    <label class="thread__input-title">Заголовок</label>
                    <input type="text" class="thread__input" v-model="thread_data.title">
                </div>
                <div class="thread__row">
                    <label class="thread__input-title">Описание</label>
                        <textarea  class="thread__input thread__input--text" v-model="thread_data.description"></textarea>
                </div>
                <div class="thread__row thread__row--right">
                    <button class="button" v-on:click="complete()">Добавить</button>
                </div>
            </div>

            <div class="thread__box" v-if="thread_data.state == 'idle' ">
                <p class="thread__title">@{{ thread_data.title }}</p>
                <p class="thread__content" v-html="thread_data.description"></p>
            </div>

            <div class="thread__box" v-if="thread_data.state == 'edit' ">
                <div class="thread__row">
                    <label class="thread__input-title">Заголовок</label>
                    <input type="text" class="thread__input" v-model="thread_data.title">
                </div>
                <div class="thread__row">
                    <label class="thread__input-title">Описание</label>
                    <textarea  class="thread__input thread__input--text" v-model="thread_data.description"></textarea>
                </div>
                <div class="thread__row thread__row--right">
                    <button class="button" v-on:click="saveThis()">Сохранить</button>
                </div>
            </div>


            <div class="thread__answer" v-if="(thread_data.comments.length == 0 && thread_data.state == 'idle')">
                <textarea class="thread__input thread__answer--input"
                          placeholder="Комментарий"
                          v-model="comment_text"
                          v-on:keydown.ctrl.13="addComment('')"
                          required="required"></textarea>
            </div>

        </div>
        <comment v-for="(item, index) in thread_data.comments" :comment_data="item" :comment_number="index"></comment>
    </div>

</script>