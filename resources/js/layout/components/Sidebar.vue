<template>
    <div :class="{'has-logo':false}">
        <el-scrollbar wrap-class="scrollbar-wrapper">
            <el-menu
                    default-active="2"
                    :router="true"
                    class="el-menu-vertical-demo"
                    @open="handleOpen"
                    @close="handleClose"
                    background-color="#545c64"
                    text-color="#fff"
                    active-text-color="#ffd04b"
                    :collapse-transition="false"
                    mode="vertical">
                <el-menu-item index="1" route="/">
                    <i class="el-icon-menu"></i>
                    <span slot="title">主页</span>
                </el-menu-item>
                <el-menu-item index="3" route="conversation">
                    <i class="el-icon-menu"></i>
                    <span slot="title">会话</span>
                </el-menu-item>
                <el-menu-item index="4" route="visit">
                    <i class="el-icon-setting"></i>
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
    import variables from '../../../sass/_variables.scss'

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
