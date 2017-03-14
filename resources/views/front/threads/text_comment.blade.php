<script type="text/x-template" id="text_comment">

    <li class="text-thread text-thread--comment" v-bind:id="'#text_'+comment_data.slug">
        <div class="text-thread__options" v-if="comment_data.state == 'idle'">
            <div class="text-thread__icon">
            </div>
            <ul class="text-thread__options-list">
                <li class="text-thread__option-item" v-if="checkRule()" v-on:click="editThis()">Редактировать</li>
                <li class="text-thread__option-item" v-if="checkRule()" v-on:click="removeThis()">Удалить</li>
                <li class="text-thread__option-item">Готово</li>
                <li class="text-thread__option-item" v-on:click.stop.prevent="goToMaket()">Посмотреть на макете</li>
                <li class="text-thread__option-item"><a v-bind:href="'#text_'+comment_data.slug">Ссылка на комментарий</a></li>
            </ul>
        </div>
        <div class="text-thread__wrap">
            <div class="text-thread__column-content text-thread__column-content--comment" v-if="comment_data.state == 'idle' ">
                <div class="text-thread__content" v-html="comment_data.description"></div>
            </div>
            <div class="text-thread__column-content text-thread__column-content--comment " v-if="comment_data.state == 'edit' ">
                <div class="text-thread__row">
                    <label class="text-thread__title">Описание</label>
                    <textarea class="text-thread__input text-thread__input--text"
                              v-model="comment_data.description"></textarea>
                </div>
                <div class="text-thread__row text-thread__row--reverse">
                    <button class="button" v-on:click="saveThis()">Сохранить</button>
                </div>
            </div>


            <div class="text-thread__column-author">
                <div class="text-thread__author author">
                    <div class="author__name-and-time">
                        <p class="author__name">@{{ comment_data.user.fio }}</p>
                        <p class="author__time">@{{ comment_data.updated_at_formated }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-thread__answer" v-if="isLast()">
                <textarea class="thread__input thread__answer--input"
                          placeholder="Комментарий"
                          v-model="comment_text"
                          v-on:focus="comment_data.active = true"
                          v-on:focusout="comment_data.active = false"


                          v-on:keydown.ctrl.13="addComment('')"
                          required="required"></textarea>
        </div>
    </li>
</script>