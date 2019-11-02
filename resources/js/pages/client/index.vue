<template>
    <div class="app-container">
        <div id="container">
            <div class="main">
                <client></client>
            </div>
        </div>
    </div>
</template>

<script>

    import Client from '../../components/Client';

    export default {
        components: { Client },
        created () {
//            this.initData();
        }
    }
</script>

<style lang="less" scoped>

    #container {
        margin: 20px auto;
        width: 800px;
        height: 550px;
        /*overflow: hidden;*/
        background-color: #0066A9;
        box-shadow: 0 0 60px #ddd;

        .main {
            border-radius: 3px;
            /*position: relative;*/
            /*overflow: hidden;*/
            background-color: #FDFDFD;
        }
    }
</style>
