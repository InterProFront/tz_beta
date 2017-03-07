Vue.component('text_thread', {
    template: '#text_thread',
    props   : ['thread_data'],
    data    : function () {
        return {
            comment_text: this.comment_text
        }
    },
    methods : {

        removeThis: function () {
            _this = this;
            this.$http.post('/update_thread', {
                page_id   : this.$parent.page_id,
                project_id: this.$parent.project_id,
                top       : this.thread_data.top,
                left      : this.thread_data.left,
                number    : this.thread_data.number,
                deleted   : true
            }, {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            }).then(
                function (response) {
                    if (response.body.error) {

                    } else {
                        _this.$parent.fetchUpdate();
                    }
                },
                function (response) {

                });
        },

        editThis: function () {
            this.thread_data.active = true;
            this.thread_data.description = this.thread_data.description.replace(/<br\s*[\/]?>/gi,"\n");
            this.thread_data.state = 'edit';
        },

        saveThis  : function () {
            _this = this;
            this.thread_data.active = false;


            this.thread_data.description = this.thread_data.description.replace(/(?:\r\n|\r|\n)/g, '<br>');
            this.$http.post('/update_thread', {
                page_id    : this.$parent.page_id,
                project_id : this.$parent.project_id,
                top        : this.thread_data.top,
                left       : this.thread_data.left,
                number     : this.thread_data.number,
                title      : this.thread_data.title,
                description: this.thread_data.description
            }, {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            }).then(
                function (response) {
                    if (response.body.error) {

                    } else {
                        _this.thread_data.state = 'idle';
                        _this.$parent.fetchUpdate();
                    }
                },
                function (response) {

                });
        },
        addComment: function (item) {
            var comment;
            _this = this;
            if (item == '') {
                comment = this.comment_text;
            } else {
                comment = item;
            }
            this.$http.post('/update_comment', {
                page_id    : this.$parent.page_id,
                project_id : this.$parent.project_id,
                thread_number: this.thread_data.number,
                description: comment
            }, {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            }).then(
                function (response) {
                    if (response.body.error) {

                    } else {
                        _this.$parent.fetchUpdate();
                    }
                },
                function (response) {

                });

            this.comment_text = '';

        }
    }
});