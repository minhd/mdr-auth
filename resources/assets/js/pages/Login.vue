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
                },
                target: ''
            }
        },

        created () {
            this.target = this.$route.query.target ? this.$route.query.target : '/dashboard';
        },

        methods: {
            login () {
                this.$store.dispatch("login", {
                    email: this.form.email, password:this.form.password
                }).then(() => this.$router.push(this.target));
            }
        }

    }
</script>