<template>
    <div class="content">
        <div class="content-wrapper">
            <img class="content-image" src="@/static/home-image.png">
            <div class="form-wrapper">
                <form class="auth-form" @submit="processLogin">
                    <h1>Login</h1>
                    <div class="line"></div>
                    <div class="form-content">
                        <div class="text-input">
                            <label>Email</label>
                            <input v-bind:class="{ error: error.email }" type="email" placeholder="Email address" v-model="login.email">
                        </div>
                        <div class="text-input">
                            <label>Password</label>
                            <input v-bind:class="{ error: error.password }" type="password" placeholder="Password" v-model="login.password">
                        </div>
                        <span class="error-message">{{errorMessage}}</span>
                        <div class="form-buttons">
                            <a href="/register" style="background-color: #962DFF;">Register</a>
                            <label>OR</label>
                            <input type="submit" value="Login" style="background-color: #4A3AFF;">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<style>
    .content {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100vw;
        height: 100vh;
    }

    .content-wrapper {
        display: flex;
        width: 100%;
        height: 100%;
        /* height: 750px; */
    }

    .content-image {
        min-width: 0;
        min-height: 0;
        width: 100%;
        object-fit: cover;
    }

    .form-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .auth-form {
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 600px;
        width: 600px;
        max-width: 600px;
        flex: 1;
        color: #170F49;
        margin: 0 10px;
        /* border-radius: 34px;
        box-shadow: 0px 5px 15px 0px rgba(8, 15, 52, 0.06);
        border: 1px solid #EFF0F6; */
    }

    .auth-form > h1 {
        font-weight: 700;
        font-size: 36px;
    }

    .auth-form > .line {
        width: 80%;
        height: 1px;
        background-color: #D9DBE9;
    }

    .auth-form > .form-content {
        display: flex;
        flex-direction: column;
        margin: 10px 0;
    }

    .auth-form > .form-content > .text-input {
        display: flex;
        flex-direction: column;
    }

    .auth-form > .form-content > .text-input > label {
        margin: 10px 0;
        font-weight: 500;
        font-size: 16;
    }

    .auth-form > .form-content > .text-input > input {
        width: 400px;
        padding: 16px 18px;
        border: 1px solid #D9DBE9;
        border-radius: 25px;
        font-size: 14px;
    }

    .auth-form > .form-content > .text-input > input:focus {
        outline: none !important;
    }

    .auth-form > .form-content > .text-input > input.error {
        transition: all 100ms ease-in;
        border: 1px solid #d33f3f;
        box-shadow: 0 0 6px #d33f3f;
    }

    .auth-form > .form-content > .form-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .auth-form > .form-content > .form-buttons > button, a, .form-buttons > input {
        /* width: 140px;
        height: 50px; */
        text-decoration: none;
        padding: 14px 32px;
        border: none;
        border-radius: 25px;
        color: #fff;
        font-size: 18px;
        font-weight: 500;
    }

    .auth-form > .form-content > .form-buttons > button:hover, a:hover, .form-buttons > input:hover {
        filter: brightness(80%);
        transition: all 30ms ease-in-out;
        cursor: pointer;
    }

    .auth-form > .form-content > .form-buttons > button:active, a:active, .form-buttons > input:active {
        filter: brightness(80%);
        transition: all 30ms ease-in-out;
    }

    .auth-form > .form-content > .form-buttons > label {
        font-size: 22px;
        font-weight: 500;
    }

    .auth-form > .form-content > .error-message {
        color: #df1313;
        margin: 6px 10px;
    }
</style>

<script>
    export default {
        head() {
            return {
                title: 'Home'
            }
        },

        data() {
            return {
                errorMessage: '',

                login: {
                    email: null,
                    password: null,
                },

                error: {
                    email: false,
                    password: false,
                }
            }
        },

        methods: {
            async processLogin(e) {
                e.preventDefault();

                let process = true;

                this.error = {
                    email: false,
                    password: false
                }

                if (!this.login.email) {
                    this.error.email = true;
                    process = false;
                }

                if (!this.login.password) {
                    this.error.password = true;
                    process = false;
                }

                if (!process) return;

                await this.$axios.$post('/auth/login', {
                    email: this.login.email,
                    password: this.login.password
                }).then(() => {
                    this.$router.push('/dashboard');
                }).catch((err) => {
                    const response = err.response;
                    if (response.status === 400) {
                        const { message } = response.data;
                        this.errorMessage = message;
                        return;
                    }

                    this.errorMessage = 'An error occurred';
                });
            }
        }
    }
</script>
