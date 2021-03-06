<script type="text/x-template" id="comment">

    <div class="thread__body thread__body--comment"
         v-bind:id="'#thread_'+comment_data.slug"
         v-on:click.stop.prevent="">
        <div class="thread__options">
            <div class="thread__icon">
            </div>
            <ul class="thread__options-list">
                <li class="thread__option-item" v-if="checkRule()" v-on:click="editThis()">Редактировать</li>
                <li class="thread__option-item" v-if="checkRule()" v-on:click="removeThis()">Удалить</li>
                <li class="thread__option-item">Готово</li>
                <li class="thread__option-item" v-on:click="goToText()">Посмотреть на макете</li>
                <li class="thread__option-item"><a v-on:click="addHash()">Ссылка на тред</a></li>
            </ul>
        </div>


        <div class="thread__author author">
            <div class="author__avatar">
                <img v-bind:src="comment_data.user.avatar" alt="">
            </div>
            <div class="author__name-and-time">
                <p class="author__name">@{{ comment_data.user.fio }}</p>
                <p class="author__time">@{{ comment_data.updated_at_formated }}</p>
            </div>
        </div>

        <div class="thread__box" v-if="comment_data.state == 'idle' ">
            <p class="thread__content" v-html="comment_data.description">
            </p>
        </div>

        <div class="thread__box" v-if="comment_data.state == 'edit' ">
            <div class="thread__row">
                <label class="thread__input-title">Описание</label>
                        <textarea  class="thread__input thread__input--text"  v-model="comment_data.description"></textarea>
            </div>
            <div class="thread__row thread__row--right">
                <button class="button" v-on:click.stop.prevent="saveThis()">Сохранить</button>
            </div>
        </div>


        <div class="thread__answer" v-if="isLast()">
                <textarea class="thread__input thread__answer--input"
                          placeholder="Комментарий"
                          v-model="comment_text"
                          v-on:keydown.ctrl.13="addComment()"

                          v-on:focus="setHover(true)"
                          v-on:focusout="setHover(false)"

                          required="required"></textarea>
        </div>

    </div>

</script>