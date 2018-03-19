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
    import UserService from '../services/UserService';

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
            if (UserService.isLoggedIn()) {
                console.log("User is logged in");
            }

            this.target = this.$route.query.target ? this.$route.query.target : '/dashboard';
        },

        methods: {
            login () {
                let that = this;
                UserService.login(this.form.email, this.form.password)
                    .then(() => that.$router.push(that.target));
            }
        }

    }
</script>