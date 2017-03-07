<script type="text/x-template" id="comment">

    <li class="text-thread">
        <div class="thread__options" v-if="thread_data.state == 'idle'">
            <div class="thread__icon">
            </div>
            <ul class="thread__options-list">
                <li class="thread__option-item" v-on:click="editThis()">Редактировать</li>
                <li class="thread__option-item" v-on:click="removeThis()">Удалить</li>
                <li class="thread__option-item">Готово</li>
            </ul>
        </div>
        <div class="text-thread__wrap text-thread__wrap--comment">
            <div class="text-thread__column">
                <div class="text-thread__title">@{{ thread_data.index_number }}. @{{ thread_data.title }}</div>
                <div class="text-thread__content" v-html="thread_data.description"></div>
            </div>
            <div class="text-thread__column">
                <div class="text-thread__author author">
                    <div class="author__name-and-time">
                        <p class="author__name">@{{ thread_data.user.fio }}</p>
                        <p class="author__time">@{{ thread_data.updated_at_formated }}</p>
                    </div>
                </div>
            </div>
        </div>
    </li>
</script>