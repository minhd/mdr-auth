<template>
    <header class="navbar navbar-expand navbar-dark flex-column flex-md-row mdr-navbar">
        <a class="navbar-brand mr-0 mr-md-2" href="/" aria-label="Bootstrap">
            Metadata Registry
        </a>

        <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">

            <li class="nav-item" v-show="!isLoggedIn">
                <router-link class="nav-item nav-link" :to="{ name: 'login' }" >Login</router-link>
            </li>

            <li class="nav-item" v-show="!isLoggedIn">
                <router-link class="nav-item nav-link" :to="{ name: 'register' }">Register</router-link>
            </li>

            <li class="nav-item" v-show="isLoggedIn">
                <a href="" class="nav-item nav-link" @click.prevent="logout">Logout</a>
            </li>

            <!--<li class="nav-item dropdown">-->
                <!--<a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" data-toggle="dropdown"-->
                   <!--aria-haspopup="true" aria-expanded="false">-->
                    <!--Notification-->
                <!--</a>-->
                <!--<div class="dropdown-menu dropdown-menu-right">-->
                    <!--<a class="dropdown-item" href="#">First</a>-->
                <!--</div>-->
            <!--</li>-->
        </ul>

    </header>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        computed: {
            ...mapGetters([
                'isLoggedIn'
            ])
        }
    }
</script>