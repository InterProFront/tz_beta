Vue.component('comment',{
    template: '#comment',
    props   : ['comment_data','comment_number'],
    data: function(){
        return {
            comment_text: this.comment_text
        }
    },
    methods: {
        addComment: function(){
            this.$parent.addComment( this.comment_text );
        },
        isLast: function(){
            return (this.comment_number == this.$parent.thread_data.comments.length-1)
        },
        editThis: function(){
            this.comment_data.description = this.comment_data.description.replace(/<br\s*[\/]?>/gi,"\n");
            this.comment_data.state = 'edit';
        },
        saveThis: function(){
            _this = this;
            str = this.comment_data.description;
            str = str.replace(/(?:\r\n|\r|\n)/g, '<br>');
            this.comment_data.description = str;


            this.$http.post('/update_comment',{
                page_id    : this.$parent.$parent.page_id,
                project_id : this.$parent.$parent.project_id,
                thread_number: this.$parent.thread_data.number,
                in_page_number: this.comment_data.in_page_number,
                description: this.comment_data.description

            },{
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            }).then(
                function(response){
                    if(response.body.error){

                    }else{
                        _this.comment_data.state = 'idle';
                        _this.$parent.$parent.fetchUpdate();
                    }
                },
                function(response){

                });
        },
        removeThis: function(){

        },

    }
});