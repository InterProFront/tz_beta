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
            this.$parent.thread_data.active = true;
        },
        saveThis: function(){
            _this = this;
            this.$parent.thread_data.active = false;
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
            _this = this;
            this.$http.post('/update_comment', {
                page_id    : this.$parent.$parent.page_id,
                project_id : this.$parent.$parent.project_id,
                thread_number: this.$parent.thread_data.number,
                in_page_number: this.comment_data.in_page_number,
                deleted   : true
            }, {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            }).then(
                function (response) {
                    if (response.body.error) {

                    } else {
                        _this.$parent.$parent.fetchUpdate();
                    }
                },
                function (response) {

                });
        },

        setHover: function( status ){
            this.$parent.thread_data.active = status;
        },
        goToText: function(){
            this.$parent.$parent.setTabState('text');
            window.location.hash = '#text_'+this.comment_data.slug;
            _this = this;
            setTimeout(function(){
                $('body,html').animate({
                    scrollTop: $('.text-thread--comment[id=#text_'+_this.comment_data.slug+']').offset().top
                }, 600);
            },200);
        },
        addHash: function(){
            window.location.hash = '#thread_'+this.thread_data.slug;
        },
        checkRule: function(){
            return this.$parent.$parent.currentUser.id == this.comment_data.athor_id;
        }

    }
});