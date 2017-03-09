Vue.component('add_project',{
    template: '#addproject',
    data: function(){
        return {
            title: this.title,
            description: this.description
        }
    },
    methods: {
        newProject: function(){
            if( this.title  != '' || this.description != '') {
                this.$http.post('/update_project', {
                    title: this.title,
                    description: this.description
                }, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).then(
                    function(response){
                        if(response.body.error){
                            alert(response.body.error_message);
                        }else{
                            window.location.href = '/project/'+response.body.content.slug;
                        }
                    },
                    function(response){

                    }
                )

            }
        }
    }
});

Vue.component('add_page',{
    template: '#add_page',
    data: function(){
        return {
            title: this.title,
            description: this.description,
            file: this.file
        }
    },
    methods: {
        newPage: function($id){
            if( this.title  != '' || this.description != '' || typeof this.file != 'undefined') {
                var _this = this;
                var data = new FormData();
                data.append('picture', _this.file);
                data.append('title', _this.title);
                data.append('description', _this.description);
                data.append('project_id', $id);


                this.$http.post('/update_page', data , {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).then(
                    function(response){
                        if(response.body.error){
                            alert(response.body.error_message);
                        }else{
                            //window.location.href = '/project/'+response.body.content.slug;
                            alert('success');
                        }
                    },
                    function(response){

                    }
                )
            }
        },
        onFileChange: function(e){
            var files = e.target.files || e.dataTransfer.files;
            if (files.length > 0){
                this.file = files[0];
            }
        }
    }
});


Vue.component('add_user',{
    template: '#add_user',
    data: function(){
        return {
            email: this.email
        }
    },
    methods: {
        addUser: function( project_id ){
            if( this.email  != '' ) {
                var _this = this;

                data = {
                  email: this.email,
                  project_id : project_id

                };


                this.$http.post('/add_member', data , {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).then(
                    function(response){
                        if(response.body.error){
                            alert(response.body.error_message);
                        }else{
                            //window.location.href = '/project/'+response.body.content.slug;
                            alert('success');
                        }
                    },
                    function(response){

                    }
                )
            }
        }
    }
});



var app = new Vue({
    el : '#app',
    data: {

    }
});