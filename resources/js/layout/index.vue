<template>
    <div class="app-wrapper openSidebar">
        <div class="drawer-bg" @click="handleClickOutside" />
        <sidebar class="sidebar-container" />
        <div class="main-container">
            <div>
                <navbar />
            </div>
            <app-main />
        </div>
    </div>

    <!--<div class="main-app">-->
        <!--<el-container>-->
            <!--<el-header>-->
                <!--<Header></Header>-->
            <!--</el-header>-->
            <!--<el-container>-->
                <!--<Aside></Aside>-->
                <!--<el-main>-->
                    <!--<router-view/>-->
                <!--</el-main>-->
            <!--</el-container>-->
        <!--</el-container>-->
    <!--</div>-->
</template>
<script>
//    import Header from './components/Header.vue'
//    import Aside from './components/Aside.vue'
    import { Navbar, Sidebar, AppMain } from './components'

    export default {
        name: 'Layout',
        data() {
            return {
                visible: false,
            }
        },
        components: {
//            Header,
//            Aside
            Navbar,
            Sidebar,
            AppMain
        },
        methods: {
            handleClickOutside() {
                this.$store.dispatch('app/closeSideBar', { withoutAnimation: false })
            }
        }
    };
</script>

<style lang="scss" scoped>
    @import "../../sass/mixin.scss";
    @import "../../sass/_variables.scss";

    .app-wrapper {
        position: relative;
        height: 100%;
        width: 100%;
        &.mobile.openSidebar{
            position: fixed;
            top: 0;
        }
    }
    .drawer-bg {
        /*background: #000;*/
        opacity: 0.3;
        width: 100%;
        top: 0;
        height: 100%;
        position: absolute;
        z-index: 999;
    }

    .fixed-header {
        position: fixed;
        top: 0;
        right: 0;
        z-index: 9;
        width: calc(100% - 210px);
        transition: width 0.28s;
    }

    .hideSidebar .fixed-header {
        width: calc(100% - 54px)
    }

    .mobile .fixed-header {
        width: 100%;
    }
</style>
