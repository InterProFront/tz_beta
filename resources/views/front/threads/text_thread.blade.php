<script type="text/x-template" id="text_thread">
    <li class="text-thread" v-bind:id="'#text_'+thread_data.slug">
        <div class="text-thread__options" v-if="thread_data.state == 'idle'">
            <div class="text-thread__icon">
            </div>
            <ul class="text-thread__options-list">
                <li class="text-thread__option-item" v-on:click="editThis()">Редактировать</li>
                <li class="text-thread__option-item" v-on:click="removeThis()">Удалить</li>
                <li class="text-thread__option-item">Готово</li>
                <li class="text-thread__option-item" v-on:click.stop.prevent="goToMaket()">Посмотреть на макете</li>
                <li class="text-thread__option-item"><a v-bind:href="'#text_'+thread_data.slug">Ссылка на тред</a></li>
            </ul>
        </div>
        <div class="text-thread__wrap">
            <div class="text-thread__column-content" v-if="thread_data.state == 'idle' ">
                <div class="text-thread__title">@{{ thread_data.index_number }}. @{{ thread_data.title }}</div>
                <div class="text-thread__content" v-html="thread_data.description"></div>
            </div>
            <div class="text-thread__column-content" v-if="thread_data.state == 'edit' ">
                <div class="text-thread__row">
                    <label class="text-thread__title">Заголовок</label>
                    <span class="text-thread__number">@{{ thread_data.index_number }}.</span>
                    <input type="text" class="text-thread__input" v-model="thread_data.title">
                </div>
                <div class="text-thread__row">
                    <label class="text-thread__title">Описание</label>
                    <textarea class="text-thread__input text-thread__input--text"
                              v-model="thread_data.description"></textarea>
                </div>
                <div class="text-thread__row text-thread__row--reverse">
                    <button class="button" v-on:click="saveThis()">Сохранить</button>
                </div>
            </div>


            <div class="text-thread__column-author">
                <div class="text-thread__author author">
                    <div class="author__name-and-time">
                        <p class="author__name">@{{ thread_data.user.fio }}</p>
                        <p class="author__time">@{{ thread_data.updated_at_formated }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-thread__answer" v-if="(thread_data.comments.length == 0 && thread_data.state == 'idle')">
                <textarea class="thread__input thread__answer--input"
                          placeholder="Комментарий"
                          v-model="comment_text"
                          v-on:focus="thread_data.active = true"
                          v-on:focusout="thread_data.active = false"


                          v-on:keydown.ctrl.13="addComment('')"
                          required="required"></textarea>
        </div>

        <ul class="answers">
            <text_comment v-for="(item, index) in thread_data.comments" :comment_data="item" :comment_number="index"></text_comment>
        </ul>
    </li>

</script>
