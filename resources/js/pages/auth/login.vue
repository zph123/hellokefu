<template>
    <div class="login-container">
        <el-form ref="loginForm" :model="loginForm" :rules="loginRules" class="login-form" auto-complete="on" label-position="left">

            <div class="title-container">
                <h3 class="title">管理员登录</h3>
            </div>

            <el-form-item prop="email">
            <span class="svg-container">
              <i class="el-icon-user-solid"></i>
            </span>
            <el-input
                    ref="email"
                    v-model="loginForm.email"
                    placeholder="Email"
                    name="email"
                    type="text"
                    tabindex="1"
                    auto-complete="on"
            />
            </el-form-item>

            <el-form-item prop="password">
                <span class="svg-container">
                  <i class="el-icon-lock"></i>
                </span>
                <el-input
                        :key="passwordType"
                        ref="password"
                        v-model="loginForm.password"
                        :type="passwordType"
                        placeholder="Password"
                        name="password"
                        tabindex="2"
                        auto-complete="on"
                        @keyup.enter.native="handleLogin"
                />
                <span class="show-pwd" @click="showPwd">
                    <i :class="passwordType === 'password' ? 'el-icon-view' : 'el-icon-sunny'" ></i>
                </span>
            </el-form-item>
            <el-button :loading="loading" type="primary" style="width:100%;margin-bottom:30px;" @click.native.prevent="handleLogin">登录</el-button>
            <div class="tips">
                <span><a href="/#/register">去注册</a></span>
            </div>
        </el-form>
    </div>
</template>

<script>
    import { checkEmail } from '../../utils/validate'
    import { login } from '../../api/auth'
    import { setToken } from '../../utils/auth'

    export default {
        name: 'Login',
        data() {
            const validateEmail = (rule, value, callback) => {
                if (!checkEmail(value)) {
                    callback(new Error('Please enter the correct email'))
                } else {
                    callback()
                }
            }
            const validatePassword = (rule, value, callback) => {
                if (value.length < 6) {
                    callback(new Error('The password can not be less than 6 digits'))
                } else {
                    callback()
                }
            }
            return {
                loginForm: {
                    email: '',
                    password: ''
                },
                loginRules: {
                    email: [{ required: true, trigger: 'blur', validator: validateEmail }],
                    password: [{ required: true, trigger: 'blur', validator: validatePassword }]
                },
                loading: false,
                passwordType: 'password',
                redirect: undefined
            }
        },
        watch: {
            $route: {
                handler: function(route) {
                    this.redirect = route.query && route.query.redirect
                },
                immediate: true
            }
        },
        methods: {
            showPwd() {
                if (this.passwordType === 'password') {
                    this.passwordType = ''
                } else {
                    this.passwordType = 'password'
                }
                this.$nextTick(() => {
                    this.$refs.password.focus()
                })
            },
            handleLogin() {
                this.$refs.loginForm.validate(valid => {
                    if (valid) {
                        this.loading = true
                        login(this.loginForm).then(response => {
                            const { token } = response
                            this.$store.commit('SET_TOKEN', token);
                            this.$router.push({ path: this.redirect || '/' })
                            this.loading = false
                        }).catch(error => {
                            this.loading = false
                            console.log('error submit!!',error)
                            return false
                        })
                    } else {
                        console.log('error submit!!')
                        return false
                    }
                })
            }
        }
    }
</script>

<style lang="scss">
    /* 修复input 背景不协调 和光标变色 */
    $bg:#283443;
    $light_gray:#606266;
    $cursor: #000;

    @supports (-webkit-mask: none) and (not (cater-color: $cursor)) {
        .login-container .el-input input {
            color: $cursor;
        }
    }

    /* reset element-ui css */
    .login-container {
        .el-input {
            display: inline-block;
            height: 47px;
            width: 80%;

            input {
                background: transparent;
                border: 0px;
                -webkit-appearance: none;
                border-radius: 0px;
                padding: 12px 5px 12px 15px;
                color: $light_gray;
                height: 47px;
                caret-color: $cursor;

                &:-webkit-autofill {
                    box-shadow: 0 0 0px 1000px $bg inset !important;
                    -webkit-text-fill-color: $cursor !important;
                }
            }
        }

        .el-form-item {
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            /*background: rgba(0, 0, 0, 0.1);*/
            border-radius: 5px;
            /*color: #454545;*/
            color: $light_gray;
        }
    }
</style>

<style lang="scss" scoped>
    $bg:#fff;
    $dark_gray:#889aa4;
    $light_gray:#eee;

    .login-container {
        min-height: 100%;
        width: 100%;
        background-color: $bg;
        overflow: hidden;

        .login-form {
            position: relative;
            width: 380px;
            max-width: 100%;
            padding: 100px 45px 40px;
            margin: 200px auto;
            overflow: hidden;
            -webkit-box-shadow: 0 0 60px #ddd;
            box-shadow: 0 0 60px #ddd;
        }
        .tips {
            font-size: 14px;
            color: #409EFF;
            margin-bottom: 10px;
            span {
                &:first-of-type {
                    margin-right: 16px;
                }
            }
        }
        .svg-container {
            padding: 6px 5px 6px 15px;
            color: $dark_gray;
            vertical-align: middle;
            width: 30px;
            display: inline-block;
        }

        .title-container {
            position: relative;

            .title {
                font-size: 22px;
                /*<!--color: $light_gray;-->*/
                color: #808080;
                margin: 0px auto 40px auto;
                text-align: center;
                font-weight: bold;
            }
        }

        .show-pwd {
            position: absolute;
            right: 10px;
            top: 7px;
            font-size: 16px;
            color: $dark_gray;
            cursor: pointer;
            user-select: none;
        }
    }
</style>
