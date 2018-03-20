<template>
    <div class="container-flex mt-5">
        <div class="row flex-xl justify-content-lg-center justify-content-md-center">
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Login</h3>
                        <form accept-charset="UTF-8" role="form" v-on:submit.prevent="login">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="yourmail@example.com" name="email" type="text"
                                           v-model="form.email">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password"
                                           v-model="form.password">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me"> Remember Me
                                    </label>
                                </div>
                                <input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
                            </fieldset>
                        </form>
                        <hr/>
                        <div class="text-center"><h4>OR</h4></div>
                        <input class="btn btn-dark btn-block" type="submit" value="Register">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                form: {
                    email: 'admin@localhost', password: 'secret'
                },
                target: ''
            }
        },

        created() {
            this.target = this.$route.query.target ? this.$route.query.target : '/dashboard';
        },

        methods: {
            login() {
                this.$store.dispatch("login", {
                    email: this.form.email, password: this.form.password
                }).then(() => this.$router.push(this.target));
            }
        }

    }
</script>