<template>
    <div class="conference">
        <friends-list :list="onlineFriends" key="online-friends" :conference-slug="conferenceSlug" descriptor="Online"></friends-list>

        <friends-list :list="newFriends" key="new-friends" :conference-slug="conferenceSlug" descriptor="New"></friends-list>
    </div>
</template>

<script>
    import FriendsList from './FriendsList.vue';

    export default {
        data: function() {
            return {
                currentUserId: Confomo.userId,
                conferenceSlug: Confomo.conferenceSlug,

                newFriends: [],
                onlineFriends: []
            };
        },

        components: { FriendsList }
    }
</script>
