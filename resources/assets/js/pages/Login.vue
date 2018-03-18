<template>
    <div>
        <form action="" v-on:submit.prevent="login">
            <input type="text" name="email" v-model="form.email">
            <input type="password" name="password" v-model="form.password">
            <input type="submit" value="Login">
        </form>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                form : {
                    email: 'admin@localhost', password: 'secret'
                }
            }
        },

        methods: {
            login () {
                axios.post('/auth/login', this.form)
            }
        }

    }
</script>