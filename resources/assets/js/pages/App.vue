<template>
    <div>
        <div class="container-flex">
            <div class="row flex-xl-nowrap no-gutters">
                <div class="col-12 col-md-3 col-xl-2 bd-sidebar" v-if="showSidebar">
                    <Sidebar></Sidebar>
                </div>
                <div class="col-12 col-md-12 col-xl-12" v-bind:class="mainAreaClass">
                    <Header></Header>
                    <!--<a href="" @click.prevent="showSidebar = !showSidebar">Toggle</a>-->
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Header from '../components/layout/Header.vue';
    import Sidebar from '../components/layout/Sidebar.vue';

    export default {
        components: { Header, Sidebar },
        data () {
            return {
                showSidebar: false
            }
        },
        created() {
//            axios.post('/logout');
//            axios.get('/api/user');
        },
        computed: {
            mainAreaClass () {
                if (this.showSidebar) {
                    return ["col-md-9",  "col-xl-10"];
                } else {
                    return ["col-xl-12"];
                }
            }
        }
    }
</script>