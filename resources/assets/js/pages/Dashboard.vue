<template>
    <div class="container-flex">
        <div class="row flex-xl justify-content-lg-center justify-content-md-center">
            <div class="col-lg-6">
                <div class="card m-3" v-for="datasource in datasources">
                    <div class="card-body">
                        <router-link :to="{ name: 'datasources.show', params: { datasource: datasource.id }}" >
                            <span v-text="datasource.title"></span>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import DataSourceServices from "../services/DataSourceServices";

    export default {
        data() {
            return {
                datasources: []
            }
        },
        created() {
            DataSourceServices.index()
                .then(({data}) => this.datasources = data);
        }
    }
</script>