Vue.component('thread', {
    template: '#thread',
    props   : ['thread_data'],
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
                    if(response.body.error){

                    }else{
                        _this.$parent.removeThread(_this.thread_data.id);
                        _this.$parent.fetchUpdate();
                    }
                },
                function (response) {

                });
        },

        editThis: function () {

        }

    }
});