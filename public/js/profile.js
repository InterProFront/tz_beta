var profile = Vue.component('profile',{
    template: '#profile',
    props: ['user'],
    data: function(){
        return {
            password: this.password,
            avatar_file : this.avatar_file
        }
    },
    methods: {
        save: function(){
            _this = this;
            data = new FormData();
            data.append('fio', this.user.fio);
            data.append('name', this.user.name);
            data.append('avatar', this.avatar_file);
            if( this.password != ''){
                data.append('password', this.password);
                data.append('password_confirmation', this.password);
            }

            this.$http.post('/update_user', data, {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                })
                .then(
                    function (response) {
                        if (response.body.error) {
                            console.log(response.body.error_message)
                        } else {
                            console.log(response);
                        }
                    },
                    function (response) {
                        // error response
                    }
                );
        },
        onFileChange: function(e){
            var vm = this;
            var files = e.target.files || e.dataTransfer.files;
            if (files.length > 0){
                this.avatar_file = files[0];
                this.avatar = files[0];
                var reader = new FileReader();

                reader.onload = (e) => {
                    vm.user.avatar = e.target.result;
                };
                reader.readAsDataURL(this.avatar);
            }
        }
    }
});


var app = new Vue({
    el : '#app',
    data: {
        user: {}
    },
    methods:{
        init: function(){
            _this = this;
            this.$http.post('/get_current_user', {}, {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                })
                .then(
                    function (response) {
                        if (response.body.error) {
                            console.log(response.body.error_message)
                        } else {
                            _this.user = response.body.content;
                        }
                    },
                    function (response) {
                        // error response
                    }
                );
        }
    }
});
app.init();