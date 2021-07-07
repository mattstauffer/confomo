<template>
    <div class="alert alert-danger" v-show="form.errors.length > 0">
        <strong>Whoops!</strong> Looks like something went wrong!

        <br><br>

        <ul>
            <li v-for="error in form.errors">
                {{ error }}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {

        props: ['form']

    };
</script>
