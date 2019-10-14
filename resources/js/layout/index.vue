<template>
    <div class="main-app">
        <el-container>
            <el-header>
                <Header></Header>
            </el-header>
            <el-container>
                <Aside></Aside>
                <el-main>
                    <router-view/>
                </el-main>
            </el-container>
        </el-container>
    </div>
</template>
<script>
    import Header from './components/Header.vue'
    import Aside from './components/Aside.vue'

    export default {
        name: 'Layout',
        data() {
            return {
                visible: false,
            }
        },
        components: {
            Header,
            Aside
        }
    };
</script>
<style scoped>
    /* Add scoped styles */

    .main-app{
        background-color: #EFF3F8;
    }

    .el-header, .el-footer {
        background-color: #B3C0D1;
        /*color: #333;*/
        /*text-align: center;*/
        /*line-height: 60px;*/
    }

    .el-aside {
        /*background-color: #D3DCE6;*/
        /*color: #333;*/
        /*text-align: center;*/
        /*line-height: 200px;*/
        /*height: 100%;*/
    }

    .el-main {

        /*color: #333;*/
        /*text-align: center;*/
        /*height: 100%;*/
        /*line-height: 160px;*/
    }

    body > .el-container {
        /*margin-bottom: 40px;*/
    }

    /*.el-container:nth-child(5) .el-aside,*/
    /*.el-container:nth-child(6) .el-aside {*/
    /*line-height: 260px;*/
    /*}*/

    /*.el-container:nth-child(7) .el-aside {*/
    /*line-height: 320px;*/
    /*}*/
</style>
