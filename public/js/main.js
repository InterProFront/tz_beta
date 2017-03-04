var app = new Vue({
    el     : '#app',
    data   : {


        tab       : 'maket',
        state     : 'add',
        project_id: 0,
        page_id   : 0,


        currentUser: {},

        users: [],

        threads: [],

        lastUpdate: 0,


        buffer        : []
    },
    methods: {
        init          : function (project_id, page_id) {
            this.project_id = project_id;
            this.page_id    = page_id;

            this.getCurrentUser();
            this.fetchUpdate();

            //setInterval(function () {
            //    this.fetchUpdate();
            //}.bind(this), 15000);
        },
        //==============================================================================================================
        getCurrentUser: function () {
            this.$http.post('/get_current_user', {}, {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                })
                .then(
                    function (response) {
                        if (response.body.error) {
                            console.log(response.body.error_message)
                        } else {
                            this.currentUser = response.body.content;
                        }
                    },
                    function (response) {
                        // error response
                    }
                );
        },

        getUser: function( id ) {
            var haveUser = false;
            var user;
            var _this = this;
            var data = {
                id: id
            };

            $.each(this.users, function (key, value) {
                if (value['id'] == id) { // Если юзер есть у нас в данных то возвращаем его
                    user     = value;
                    haveUser = true;
                    return false;
                } else {
                    haveUser = false;
                }
            });

            if (!haveUser) {
                user = {fio: '', id: id, avatar: ''};
                this.users.push(user);

                this.$http.post('/get_user', data, {
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                    }).then(
                        function (response) {
                            if (response.body.error) {
                                console.log(id);
                                console.log(response.body.error_message)
                            } else {
                                $.each(_this.users, function (key, value) {

                                    if (value['id'] == id) { // Если юзер есть у нас в данных то возвращаем его
                                        value['fio'] = response.body.content.fio;
                                        value['avatar']    = response.body.content.avatar;
                                        value['created_at']    = response.body.content.created_at;
                                        value['name']    = response.body.content.name;
                                        value['updated_at']    = response.body.content.update_at;
                                        value['email']    = response.body.content.email;
                                    }
                                })
                            }

                        },
                        function (response) {
                            // error response
                        }
                    );
            }
            return user; // возвращаем какого-нибудь юзера
        },
        //===============================================================================================================
        addThread: function( event ){

            var left = event.pageX - $(event.currentTarget).offset().left -15;
            var top = event.pageY - $(event.currentTarget).offset().top - 15;


            if( this.buffer.length <= 0 ){
                this.buffer.push({
                    title: '',
                    content: '',
                    project_id: this.project_id,
                    page_id: this.page_id,
                    author_id: this.currentUser.id,
                    state: 'add',
                    top: top,
                    left: left,
                    user: this.currentUser
                });
            }else{
                if( this.buffer[0].title == '' && this.buffer[0].content == '' ){
                    this.buffer.splice(0,1);
                }else{
                    this.buffer[0].top = top;
                    this.buffer[0].left = left;
                }
            }
        },
        clearBuffer: function(){
          this.buffer = [];
        },
        appendThread: function( item ){
            item.state = 'idle';
            if( item.author_id == this.currentUser.id){
                item.user = this.currentUser;
            }else{
                if (typeof item.user == 'undefined'){
                    this.getUser( item.ownerID );
                }
            }
            item.comment = [];
            this.lastThread = item.number;

            this.threads.push( item );
        },
        //==============================================================================================================
        fetchUpdate: function () {
            var _this = this;

            var data = {
                project_id  : this.project_id,
                page_id     : this.page_id,
                last_update : this.lastUpdate
            };


            this.$http.post('/pull_changes', data, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).then(
                function (response) {
                    if (response.body.error) {

                    } else {
                        if (typeof response.body.content == 'string') {
                            console.log(response.body.content)
                        } else {
                            _this.lastUpdate = response.body.last_update;

                            $.each(response.body.content.threads, function (key, value) {
                                _this.appendThread(value);
                            });
                            //$.each(response.body.content.comments, function (key, value) {
                            //    $.each(_this.threads, function (t_key, t_value) {
                            //        if (value['threadID'] == t_value['id']) {
                            //            value['number_in_thread'] = t_value['comments'].length + 1;
                            //            value['user']             = _this.checkUser(value['ownerID']);
                            //
                            //            _this.lastComment = value['number_in_page'];
                            //            t_value['comments'].push(value);
                            //        }
                            //    });
                            //});

                        }
                    }
                },
                function (response) {

                }
            );
        },
        //==============================================================================================================
        setTabState: function (state) {
            this.tab = state;
        }
    }
});
app.init( $('#app').data('project-id'), $('#app').data('page-id') );