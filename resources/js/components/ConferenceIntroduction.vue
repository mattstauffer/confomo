<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Introduce Yourself</div>

                <div class="panel-body">
                    <form-errors :form="addIntroductionForm"></form-errors>

                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Name</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">@</span>
                                    <input type="text" class="form-control" name="username" v-model="addIntroductionForm.username">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button @click.prevent="addIntroduction"
                                        :disabled="addIntroductionForm.adding"
                                        type="submit"
                                        class="btn btn-primary"
                                >
                                    <span v-if="addIntroductionForm.adding">
                                        <i class="fa fa-btn fa-spinner fa-spin"></i>Making Introduction
                                    </span>

                                    <span v-else>
                                        <i class="fa fa-btn fa-plus"></i>Add Introduction
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['data-user'],

        data: function () {
            return {
                addIntroductionForm: {
                    errors: [],
                    adding: false,
                    username: this.dataUser ? this.dataUser.username : ''
                }
            };
        },

        methods: {
            addIntroduction: function () {
                if (this.addIntroductionForm.username == '') {
                    this.addIntroductionForm.errors = [
                        'You need to actually type something for the name.'
                    ];
                    this.addIntroductionForm.adding = false;

                    return;
                }

                this.addIntroductionForm.errors = [];
                this.addIntroductionForm.adding = true;

                this.$http.post('/api/conferences/' + Confomo.conferenceSlug + '/introduction', this.addIntroductionForm)
                    .then(friend => {
                        swal('Success', 'Your introduction has been sent!', 'success');

                        this.addIntroductionForm.username = '';
                        this.addIntroductionForm.adding = false;
                    }, response => {
                        this.setErrorsOnForm(this.addIntroductionForm, response.data);
                        this.addIntroductionForm.adding = false;
                    });
            }
        }
    };

</script>
