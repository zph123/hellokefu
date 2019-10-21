<template>
    <div :class="{'has-logo':false}">
        <div class="sidebar-logo-container">
            <a href="#/" class="sidebar-logo-link router-link-active">
                <img src="/logo.png" class="sidebar-logo"/>
                <h1 class="sidebar-title">哈啰客服</h1>
            </a>
        </div>
        <el-scrollbar wrap-class="scrollbar-wrapper">
            <el-menu
                    default-active="2"
                    :router="true"
                    class="el-menu-vertical-demo"
                    @open="handleOpen"
                    @close="handleClose"
                    :collapse-transition="false"
                    mode="vertical">
                <el-menu-item index="1" route="/">
                    <i class="el-icon-menu"></i>
                    <span slot="title">主页</span>
                </el-menu-item>
                <el-menu-item index="3" route="conversation">
                    <i class="el-icon-service"></i>
                    <span slot="title">会话</span>
                </el-menu-item>
                <el-menu-item index="4" route="visitor">
                    <i class="el-icon-tickets"></i>
                    <span slot="title">访客</span>
                </el-menu-item>
                <el-menu-item index="5" route="set">
                    <i class="el-icon-setting"></i>
                    <span slot="title">设置</span>
                </el-menu-item>
            </el-menu>

        </el-scrollbar>
    </div>
</template>


<script>
    export default {
        components: {},
        methods: {
            handleOpen(key, keyPath) {
                console.log(key, keyPath);
            },
            handleClose(key, keyPath) {
                console.log(key, keyPath);
            }
        },
        data() {
            return {}
        }
    }
</script>

<style lang="scss" scoped>
    .sidebar-logo-container {
        position: relative;
        width: 100%;
        height: 50px;
        line-height: 50px;
        /*background: #FFF;*/
        text-align: center;
        overflow: hidden;

        & .sidebar-logo-link {
            height: 100%;
            width: 100%;

            & .sidebar-logo {
                width: 38px;
                height: 38px;
                vertical-align: middle;
                margin-right: 12px;
            }

            & .sidebar-title {
                display: inline-block;
                margin: 0;
                color: #444444;
                font-weight: 600;
                line-height: 50px;
                font-size: 14px;
                font-family: Avenir, Helvetica Neue, Arial, Helvetica, sans-serif;
                vertical-align: middle;
            }
        }

        &.collapse {
            .sidebar-logo {
                margin-right: 0px;
            }
        }
    }
</style>