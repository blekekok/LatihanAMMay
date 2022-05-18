<template>
    <div class="content">
        <div class="sidebar">
            <ul>
                <li><a href="/dashboard"><HomeIcon class="icon"/><span>Dashboard</span></a></li>
            </ul>
            <a href="/logout"><logoutIcon class="icon"/><span>Logout</span></a>
        </div>
        <div class="content-wrapper">
            <div class="dashboard-content" v-if="dashboardData !== null">
                <div class="dashboard-status">
                    <div class="status-box">
                        <div class="icon-wrapper green">
                            <FilledUserIcon class="icon"/>
                        </div>
                        <div class="status-box-wrapper">
                            <span>Active</span>
                            <span>{{dashboardData.totalApproved}}</span>
                        </div>
                    </div>
                    <div class="status-box">
                        <div class="icon-wrapper orange">
                            <FilledUserIcon class="icon"/>
                        </div>
                        <div class="status-box-wrapper">
                            <span>Waiting Approval</span>
                            <span>{{dashboardData.totalPending}}</span>
                        </div>
                    </div>
                </div>
                <div class="dashboard-users">
                    <ul class="dashboard-users-list">
                        <li v-for="(user, i) in dashboardData.users" v-bind:key="i">
                            <div class="user-content">
                                <span class="user-number">{{i + 1}}</span>
                                <img :src="user.image_url" alt="" />
                                <a class="user-name" :href="`/user/${user.id}`">{{user.name}}</a>
                            </div>
                            <div class="user-buttons">
                                <button class="approve" @click="approveUser(user.id)">Approve</button>
                                <button class="reject" @click="rejectUser(user.id)">Reject</button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .content {
        display: flex;
        justify-content: flex-start !important;
        align-items: flex-start !important;
        width: 100vw;
        height: 100vh;
    }

    .sidebar {
        position: fixed;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        width: 300px;
        height: 100%;
        background-color: #F2F8FF;
    }

    .sidebar ul {
        padding: 0;
        margin: 0;
        width: 100%;
    }

    .sidebar li {
        display: flex;
        justify-content: center;
        list-style: none;
        width: 100%;
    }

   .sidebar a {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        width: 80%;
        height: 50px;
        margin: 12px 0;
        text-decoration: none;
        color: white;
        border-radius: 15px;
        font-size: 20px;
        padding: 0 !important;
    }

    .sidebar li > a {
        background-color: #4062FF;
    }

    .sidebar > a {
        color: #e02a2a;
    }

    .sidebar a:hover {
        transition: all 50ms ease-in-out;
        filter: brightness(80%);
    }

    .sidebar .icon {
        margin: 0 16px;
    }

    .content-wrapper {
        display: flex;
        width: 100%;
        justify-content: center;
    }

    .dashboard-content {
        width: 800px;
        height: 100px;
        margin: 24px 0;
    }

    .dashboard-status {
        display: flex;
        justify-content: space-between;
        width: 100%;
        margin: 16px 0;
    }

    .status-box {
        width: 300px;
        display: flex;
        align-items: center;
    }

    .status-box-wrapper {
        display: flex;
        margin: 0 10px;
        width: 100%;
        flex: 1;
        justify-content: space-between;
    }

    .status-box-wrapper > span {
        font-weight: 500;
        font-size: 20px;
    }

    .status-box > .icon-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 64px;
        height: 64px;
        border-radius: 50%;
    }

    .status-box > .icon-wrapper.green {
        background-color: rgb(132, 224, 11);
    }

    .status-box > .icon-wrapper.orange {
        background-color: #f3ba3f;
    }

    .status-box > .icon-wrapper > .icon {
        width: 36px;
        height: 36px;
    }

    .dashboard-users {
        display: flex;
        border: solid 1px #4062FF;
        border-radius: 15px;
        min-height: 400px;
        margin: 16px 0;
    }

    .dashboard-users-list {
        margin: 0;
        padding: 0;
        width: 100%;
    }

    .dashboard-users-list li {
        display: flex;
        justify-content: space-between;
        list-style: none;
        margin: 10px 0;
        width: 100%;
    }

    .dashboard-users-list .user-content {
        display: flex;
        align-items: center;
    }

    .dashboard-users-list .user-content .user-number {
        display: flex;
        justify-content: center;
        width: 48px;
        margin: 4px;
        font-size: 18px;
        font-weight: 600;
    }

    .dashboard-users-list .user-content .user-name {
        text-decoration: none;
        font-size: 18px;
        font-weight: 600;
        margin: 0 10px;
        color: #252525;
    }

    .dashboard-users-list .user-content img {
        width: 64px;
        height: 64px;
    }

    .dashboard-users-list .user-buttons {
        display: flex;
        align-items: center;
    }

    .dashboard-users-list .user-buttons button {
        margin: 0 10px;
        border: none;
        width: 120px;
        height: 40px;
        border-radius: 25px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
    }

    .dashboard-users-list .user-buttons button.approve {
        background-color: #4062FF;
        color: #fff;
    }

    .dashboard-users-list .user-buttons button.reject {
        border: solid 2px #4062FF;
        background-color: transparent;
    }

    .dashboard-users-list .user-buttons button.approve:hover {
        transition: all 50px ease-in-out;
        filter: brightness(80%);
    }

    .dashboard-users-list .user-buttons button.reject:hover {
        transition: all 50px ease-in-out;
        background-color: #ec3123;
        border: solid 1px #ec3123;
        color: #fff;
    }
</style>

<script>
import HomeIcon from "../components/HomeIcon.vue";
import FilledUserIcon from "../components/FilledUserIcon.vue";
export default {
    head() {
        return {
            title: "Dashboard",
        };
    },

    fetchOnServer: false,

    async fetch() {
        await this.$axios.$get("/admin/dashboard")
            .then((response) => {
                this.dashboardData = response;
            }).catch((err) => {
                const response = err.response;
                if (response.status === 401) {
                    const { message } = response.data;

                    alert(message)
                }
                this.$router.push("/");
            });
    },

    data() {
        return {
            dashboardData: null,
        };
    },

    methods: {
        async approveUser(id) {
            try {
                this.$axios.$post('/admin/approveuser', {
                    id
                });
            } catch (err) {
                console.error(err);
            }

            await this.$fetch();
        },

        async rejectUser(id) {
            try {
                this.$axios.$post('/admin/rejectuser', {
                    id
                });
            } catch (err) {
                console.error(err);
            }

            await this.$fetch();
        }
    },

    components: { HomeIcon, FilledUserIcon }
}
</script>
