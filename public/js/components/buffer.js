Vue.component('buffer', {
    template: '#thread',
    props   : ['thread_data'],
    methods : {
        complete: function () {
            this.$parent.fetchUpdate();
            var _this = this;
            this.$http.post('/update_thread', {
                page_id   : this.$parent.page_id,
                project_id: this.$parent.project_id,
                top       : this.thread_data.top,
                left      : this.thread_data.left,
                title     : this.thread_data.title,
                description   : this.thread_data.description
            }, {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            }).then(
                function (response) {
                    if( response.body.error ){

                    }else{
                        _this.thread_data.id = response.body.content['id'];
                        _this.thread_data.number = response.body.content['number'];
                        _this.thread_data.index_number = response.body.content['index_number'];

                        _this.$parent.appendThread( _this.thread_data );
                        _this.$parent.clearBuffer();
                    }
                },
                function (response) {

                })
        }
    }
});