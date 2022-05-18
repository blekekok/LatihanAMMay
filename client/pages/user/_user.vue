<template>
    <div class="content" v-if="userData !== null">
        <div class="user-data">
            <h1>Member Profile</h1>
            <div class="line"></div>
            <img :src="userData.user.image_url" alt="" />
            <div class="user-data-fields">
                <div class="user-data-field">
                    <span>Name</span>
                    <div class="user-data-box">
                        <span>{{userData.user.name}}</span>
                        <UserIcon class="icon" />
                    </div>
                </div>
                <div class="user-data-field">
                    <span>Email</span>
                    <div class="user-data-box">
                        <span>{{userData.user.email}}</span>
                        <MailIcon class="icon" />
                    </div>
                </div>
                <div class="user-data-field">
                    <span>Phone Number</span>
                    <div class="user-data-box">
                        <span>{{userData.user.phone}}</span>
                        <PhoneIcon class="icon" />
                    </div>
                </div>
                <div class="user-data-field">
                    <span>University</span>
                    <div class="user-data-box">
                        <span>{{userData.user.university_name}}</span>
                        <BuildingIcon class="icon" />
                    </div>
                </div>
            </div>
        </div>
        <div class="user-file">
            <h1>File</h1>
            <div class="line"></div>
            <div class="file-list">
                <ul>
                    <li v-for="(file, i) in userData.files" v-bind:key="i">
                        <a :href="file.file_url" target="_blank">
                            <div class="icon">
                                <img :src="file.image_url" alt="" />
                            </div>
                            <span>{{file.name}}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<style>
    * {
        color: #170F49;
    }

    h1 {
        font-weight: 700;
    }

    .content {
        display: flex;
        justify-content: center;
        width: 100%;
        height: 100%;
        box-sizing: border-box;
        padding: 100px 100px;
    }

    .content > div {
        display: flex;
        flex-direction: column;
        align-items: center;
        border: solid 1px #D9DBE9;
        height: auto;
        margin: 0 20px;
        border-radius: 25px;
    }

    .content .user-data {
        width: 800px;
    }

    .content .user-data > img {
        width: 128px;
        height: 128px;
        margin: 12px;
    }

    .content .user-data .user-data-fields {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        margin: 10px 0;
    }

    .content .user-data .user-data-field {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin: 10px 16px;
    }

    .content .user-data .user-data-field > span {
        margin: 8px 0;
    }

    .content .user-data .user-data-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 250px;
        height: 50px;
        border: solid 1px #D9DBE9;
        border-radius: 25px;
        padding: 0 16px;
    }

    .content .user-data .user-data-box > span {
        color: #6F6C90;
    }

    .content > div .line {
        width: 90%;
        height: 2px;
        background-color: #D9DBE9;
        box-sizing: border-box;
    }

    .content .user-file {
        width: 300px;
    }

    .content .user-file .file-list ul {
        padding: 0;
        margin: 0;
    }

    .content .user-file .file-list li {
        list-style: none;
        margin: 16px 0;
    }

    .content .user-file .file-list a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 225px;
        height: 64px;
        border-radius: 20px;
        border: solid 2px #4A3AFF;
        padding: 0 16px;
        text-decoration: none;
    }

    .content .user-file .file-list .icon {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #4a3aff3b;
        width: 48px;
        height: 48px;
        border-radius: 50%;
    }

    .content .user-file .file-list .icon > img {
        width: 32px;
        height: 32px;
    }

    .content .user-file .file-list span {
        font-weight: 700;
        font-size: 16px;
    }
</style>

<script>
import MailIcon from '~/components/MailIcon.vue';
import PhoneIcon from '~/components/PhoneIcon.vue';
import BuildingIcon from '~/components/BuildingIcon.vue';
    export default {
        async asyncData({ $axios, params, redirect }) {
            const id = params.user;
            let userData = null;
            await $axios.$get("/user/userprofile", {
                params: {
                    id
                }
            }).then((response) => {
                userData = response;
            }).catch((err) => {
                redirect("/");
            });
            return { userData };
        },
        components: { MailIcon, PhoneIcon, BuildingIcon }
    }
</script>
