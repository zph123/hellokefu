<template>
    <div class="navbar">
        <hamburger :is-active="true" class="hamburger-container" @toggleClick="toggleSideBar" />

        <breadcrumb class="breadcrumb-container" />

        <div class="right-menu">
            <el-dropdown class="avatar-container" trigger="click">
                <div class="avatar-wrapper">
                    <el-avatar src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png"></el-avatar>
                    <i class="el-icon-caret-bottom" />
                </div>
                <el-dropdown-menu slot="dropdown" class="user-dropdown">
                    <router-link to="/">
                        <el-dropdown-item>
                            Home
                        </el-dropdown-item>
                    </router-link>
                    <a target="_blank" href="https://github.com/zph123/hellokefu">
                        <el-dropdown-item>Github</el-dropdown-item>
                    </a>
                    <a target="_blank" href="#">
                        <el-dropdown-item>Docs</el-dropdown-item>
                    </a>
                    <el-dropdown-item divided>
                        <span style="display:block;" @click="logout">退出</span>
                    </el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </div>
    </div>
</template>

<script>
    import { logout } from '../../api/auth'
    import { destroyToken } from '../../utils/auth'
    import Breadcrumb from './Breadcrumb'
    import Hamburger from './Hamburger'
    export default {
        components: {
            Breadcrumb,
            Hamburger
        },
        computed: {
        },
        methods: {
            toggleSideBar() {
                console.log('toggle side bar')
            },
            logout() {
                logout().then(() => {
                    this.$store.commit('SET_TOKEN', null)
                    destroyToken()
                    this.$router.push(`/login?redirect=${this.$route.fullPath}`)
                }).catch(error => {
                    console.log('error',error)
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
.navbar {
    height: 50px;
    overflow: hidden;
    position: relative;
    background: #fff;
    box-shadow: 0 1px 4px rgba(0,21,41,.08);

    .hamburger-container {
        line-height: 46px;
        height: 100%;
        float: left;
        cursor: pointer;
        transition: background .3s;
        -webkit-tap-highlight-color:transparent;

        &:hover {
            background: rgba(0, 0, 0, .025)
        }
    }

    .breadcrumb-container {
        float: left;
    }

    .right-menu {
        float: right;
        height: 100%;
        line-height: 50px;

        &:focus {
            outline: none;
        }

        .right-menu-item {
            display: inline-block;
            padding: 0 8px;
            height: 100%;
            font-size: 18px;
            color: #5a5e66;
            vertical-align: text-bottom;

            &.hover-effect {
                cursor: pointer;
                transition: background .3s;

                &:hover {
                    background: rgba(0, 0, 0, .025)
                }
            }
        }

        .avatar-container {
            margin-right: 30px;

            .avatar-wrapper {
                margin-top: 5px;
                position: relative;

                .user-avatar {
                    cursor: pointer;
                    width: 30px;
                    height: 30px;
                    border-radius: 15px;
                }

                .el-icon-caret-bottom {
                    cursor: pointer;
                    position: absolute;
                    right: -20px;
                    top: 14px;
                    font-size: 12px;
                }
            }
        }
    }
}
</style>
