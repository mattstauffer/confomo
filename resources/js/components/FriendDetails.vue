<template>
    <button type="button" class="btn btn-primary btn-xs" @click="showDetails(friend)">Details</button>

    <div id="{{ friend.username }}" class="hide">
        <div class="friend-details-modal">
            <img v-bind:src="friend.avatar_url" class="img-circle" height="160">
            <p><strong>Name:</strong> {{ friend.name }}</p>
            <span v-show="friend.location && friend.location.length > 0">
                <p><strong>Location: </strong> {{ friend.location }}</p>
            </span>
            <span v-show="friend.url && friend.url.length > 0">
                <p><strong>Url: </strong><a href="{{ friend.url }}">{{ friend.url_display }}</a></p>
            </span>
            <span v-show="friend.description && friend.description.length > 0">
                <p>{{ friend.description }}</p>
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['friend'],

        methods: {
            showDetails: function(friend) {
                var $html = document.getElementById(friend.username).innerHTML;

                swal({
                    title: '',
                    text: $html,
                    type: '',
                    html: true,
                    confirmButtonText: 'Close'
                });
            },
        }
    }
</script>
