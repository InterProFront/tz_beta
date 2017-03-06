Vue.component('buffer', {
    template: '#thread',
    props   : ['thread_data'],
    methods : {
        complete: function () {
            var _this = this;
            this.thread_data.description = this.thread_data.description.replace(/<br\s*[\/]?>/gi,"\n");
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
                        _this.$parent.fetchUpdate();
                        _this.$parent.clearBuffer();
                    }
                },
                function (response) {

                })
        }
    }
});