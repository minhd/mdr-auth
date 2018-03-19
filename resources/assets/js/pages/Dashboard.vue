<template>
    <div>Dashboard</div>
</template>

<script>
    import DataSourceServices from "../services/DataSourceServices";

    export default {
        created() {
            DataSourceServices.index();
        }
    }
</script>