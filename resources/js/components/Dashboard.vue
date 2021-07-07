<template>
    <div class="dashboard">
        <!-- Conference Listing -->
        <h2>Conferences</h2>
        <div v-if="conferences.length > 0">
            <div class="row" v-for="conference in conferences">
                <div class="col-md-8 col-md-offset-2">
                    <button class="btn btn-danger pull-right conference-delete-button"
                            style="font-size: 18px; margin-right: 10px;"
                            @click.prevent="deleteConference(conference)"
                    >
                        <i class="fa fa-times"></i>
                    </button>
                    <h3 class="conference-button" @click="viewConference(conference)">
                        {{ conference.name }}
                    </h3>
                </div>
            </div>
        </div>
        <div v-if="conferences.length == 0" style="max-width: 600px; margin: 2em auto; font-size: 1.5em">
            <p><strong>Just getting started?</strong> Add the name of the next conference you're planning to attend. You can then add your "online friends"&mdash;friends you know online and plan to meet at the conference. Then, at the conference, you can take a look at that list, and mark them when they're met&mdash;like a todo list for friends.</p>
            <p>These conferences aren't connected to anyone else in this system. It's just for you, to track your friends.</p>
            <p>So get started! Add your next conference below.</p>
        </div>

        <hr v-show="conferences.length > 0">

        <!-- Add Conference Form -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div v-bind:class="[ 'panel', conferences.length > 0 ? 'panel-default' : 'panel-primary' ]">
                    <div class="panel-heading">Add Conference</div>

                    <div class="panel-body">
                        <form-errors :form="addConferenceForm"></form-errors>

                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" v-model="addConferenceForm.name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Start Date</label>

                                <div class="col-md-6">
                                    <datepicker
                                        :value.sync="addConferenceForm.start_date"
                                        format="yyyy-MM-dd">
                                    </datepicker>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">End Date</label>

                                <div class="col-md-6">
                                    <datepicker
                                        :value.sync="addConferenceForm.end_date"
                                        format="yyyy-MM-dd">
                                    </datepicker>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary"
                                        @click.prevent="addConference"
                                        :disabled="addConferenceForm.adding">

                                        <span v-if="addConferenceForm.adding">
                                            <i class="fa fa-btn fa-spinner fa-spin"></i>Adding
                                        </span>

                                        <span v-else>
                                            <i class="fa fa-btn fa-plus"></i>Add Conference
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Datepicker from './Datepicker.vue';

    export default {
        data: function() {
            return {
                conferences: [],

                addConferenceForm: {
                    name: '',
                    start_date: '',
                    end_date: '',
                    errors: [],
                    adding: false
                },
            };
        },

        ready: function () {
            this.getAllConferences();
        },

        components: {
            Datepicker
        },

        methods: {
            getAllConferences: function () {
                this.$http.get('/api/conferences')
                    .then(function (response) {
                        this.conferences = response.data;
                    });
            },

            addConference: function () {
                // @todo: Do validation in a more VueJS-y way?
                if (! this.validInput()) {
                    this.addConferenceForm.adding = false;

                    return;
                }

                this.addConferenceForm.errors = [];
                this.addConferenceForm.adding = true;

                this.$http.post('/api/conferences', this.addConferenceForm)
                    .then(function (response) {
                        this.addConferenceForm.name = '';
                        this.addConferenceForm.start_date = '';
                        this.addConferenceForm.end_date = '';
                        this.addConferenceForm.adding = false;
                        this.conferences.push(response.data);
                    }, function (response) {
                        this.setErrorsOnForm(this.addConferenceForm, response.data);
                        this.addConferenceForm.adding = false;
                    });
            },

            deleteConference: function (conference, $e) {
                var vm = this;

                swal({
                    title: 'Are you sure?',
                    text: 'This will delete ' + conference.name + ' and any associated friends',
                    type: 'warning',
                    showCancelButton: true
                }, function () {
                    vm.$http.delete('/api/conferences/' + conference.slug)
                        .then(function () {
                            vm.conferences.$remove(conference);
                        });
                });
            },

            viewConference: function (conference) {
                document.location.href = '/conferences/' + conference.slug;
            },

            validInput: function () {
                this.addConferenceForm.errors = [];

                if (this.addConferenceForm.name == '') {
                    this.addConferenceForm.errors.push('You need to actually type something for the name.');
                }

                if (this.addConferenceForm.start_date == '') {
                    this.addConferenceForm.errors.push('You need to actually type something for the start date.');
                }

                if (this.addConferenceForm.end_date == '') {
                    this.addConferenceForm.errors.push('You need to actually type something for the end date.');
                }

                // @todo: Validate the dates! For Safari users.

                if (this.addConferenceForm.errors.length > 0) {
                    this.addConferenceForm.adding = false;

                    return;
                }

                return true;
            },
        }
    }
</script>
