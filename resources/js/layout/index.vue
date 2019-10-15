<template>
    <div class="app-wrapper openSidebar">
        <div @click="handleClickOutside" />
        <sidebar class="sidebar-container" />
        <div class="main-container">
            <div>
                <navbar />
            </div>
            <app-main />
        </div>
    </div>
</template>
<script>
    import { Navbar, Sidebar, AppMain } from './components'

    export default {
        name: 'Layout',
        data() {
            return {
                visible: false,
            }
        },
        components: {
            Navbar,
            Sidebar,
            AppMain
        },
        methods: {
            handleClickOutside() {
            }
        }
    };
</script>

<style lang="scss" scoped>

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
