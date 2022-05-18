<template>
    <div class="content-wrapper">
        <div class="form-wrapper">
            <h1>Registration</h1>
            <p>Silahkan mengisi formulir berikut dengan sebenar-benarnya. Bantu kami mengenali anda dengan mudah</p>

            <form class="form-content">
                <div class="step-header">
                    <div class="step-icon" v-bind:class="{ active: step >= 1 }"><span>1</span></div>
                    <div class="step-bar" v-bind:class="{ hover: step == 1, active: step > 1 }"><div></div></div>
                    <div class="step-icon" v-bind:class="{ active: step >= 2 }"><span>2</span></div>
                    <div class="step-bar" v-bind:class="{ hover: step == 2, active: step > 2 }"><div></div></div>
                    <div class="step-icon" v-bind:class="{ active: step >= 3 }"><span>3</span></div>
                </div>

               <div class="line"></div>

                <section v-show="step === 1">
                    <h2>Contact</h2>
                    <h3>Masukkan Informasi</h3>
                    <div class="input-group">
                        <div class="input-wrapper">
                            <label for="name-input">Name</label>
                            <div for="name-input" class="input-box" v-bind:class="{ error: invalidInput.name }">
                                <input id="name-input" type="text" placeholder="John Carter" v-model="form.name">
                                <UserIcon class="icon" />
                            </div>
                        </div>
                        <div class="input-wrapper">
                            <label for="email-input">Email</label>
                            <div class="input-box" v-bind:class="{ error: invalidInput.email }">
                                <input id="email-input" type="email" placeholder="Email address" v-model="form.email">
                                <MailIcon class="icon" />
                            </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-wrapper">
                            <label for="phone-input">Phone Number</label>
                            <div class="input-box" v-bind:class="{ error: invalidInput.phone }">
                                <input id="phone-input" type="tel" placeholder="0888-456-7890" v-model="form.phone">
                                <PhoneIcon class="icon" />
                            </div>
                        </div>
                        <div class="input-wrapper">
                            <label>University</label>
                            <div v-click-outside="() => {dropdown.isUniversityOpen = false}">
                                <div class="input-box" v-bind:class="{ error: invalidInput.university }" v-on:click="dropdown.isUniversityOpen = !dropdown.isUniversityOpen">
                                    <span :style="{opacity: form.university === null ? '0.6' : '1'}">{{ form.university === null ? 'University name' : universities[form.university].name }}</span>
                                    <BuildingIcon class="icon" />
                                </div>
                                <transition name="fade">
                                    <div class="dropdown-box" v-show="dropdown.isUniversityOpen">
                                        <ul class="dropdown-list">
                                            <li class="dropdown-item" v-for="(university, i) in universities" :key="i" v-on:click="pickUniversity(i)">{{ university.name }}</li>
                                        </ul>
                                    </div>
                                </transition>
                            </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-wrapper">
                            <label for="password-input">Password</label>
                            <div class="input-box" v-bind:class="{ error: invalidInput.password }">
                                <input id="password-input" type="password" placeholder="Password" v-model="form.password">
                                <KeyIcon class="icon" />
                            </div>
                        </div>
                        <div class="input-wrapper">
                            <label for="confirmpassword-input">Password Confirmation</label>
                            <div class="input-box" v-bind:class="{ error: invalidInput.passwordConfirm }">
                                <input id="confirmpassword-input" type="password" placeholder="Password Confirmation" v-model="form.passwordConfirm">
                                <KeyIcon class="icon" />
                            </div>
                        </div>
                    </div>
                </section>

                <section v-show="step === 2">
                    <h2>File</h2>
                    <h3>Upload Berkas yang diperlukan</h3>

                    <div class="file-buttons">
                        <label class="file-button" v-for="(category, i) in fileCategories" :key="i" :for="'file.' + category.id" v-bind:class="{ active: category.file !== null, error: category.file === null && category.filledError }">
                            <div class="file-button-wrapper">
                                <div class="icon-circle">
                                    <img :src="category.image_url">
                                </div>
                                <span>{{category.name}}</span>
                            </div>
                            <input type="file" :id="'file.' + category.id" style="visibility: hidden;" v-on:change="fileUpdate($event, category)"/>
                        </label>
                    </div>
                </section>

                <section v-show="step === 3">
                    <div class="success-content">
                        <div class="success-content-wrapper">
                            <CheckCircle class="icon"/>
                            <h1>Permintaan Akun Berhasil dikirim</h1>
                            <h3>Permintaan Anda akan kami verifikasi dalam waktu maksimal 2 x 24 jam. Hasil verifikasi akan kami informasikan melalui email yang anda daftarkan.</h3>
                            <a class="step-button step-button-next" href="/">Close</a>
                        </div>
                    </div>
                </section>
            </form>

            <div class="step-buttons">
                <button class="step-button-prev" v-if="step == 2" v-on:click="step--">Previous step</button>
                <button class="step-button-next" v-if="step == 1" v-on:click="checkFirstStep()">Next step</button>
                <button class="step-button-next" v-if="step == 2" v-on:click="checkSecondStep()">Create account</button>
            </div>
        </div>
    </div>
</template>

<style>

.fade-enter-active, .fade-leave-active {
    transition: opacity .1s
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
    opacity: 0
}

* {
    color: #170F49;
}

.content-wrapper {
    display: flex;
    justify-content: center;
    padding: 50px 0;
}

.form-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 700px;
}

.form-wrapper > h1 {
    font-weight: 700;
    font-size: 38px;
    margin: 0;
}

.form-wrapper > p {
    width: 600px;
    font-size: 18px;
    color: #6F6C90;
    text-align: center;
}

.form-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    width: 100%;
    padding: 30px 0;
    border: 1px solid #d5d5d8;
    border-radius: 35px;
}

.form-content > .step-header {
    display: flex;
    align-items: center;
}

.form-content > .step-header > .step-icon {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background-color: #cfd1dd;
}

.form-content > .step-header > .step-icon > span {
    color: #6F6C90;
    font-weight: 700;
    font-size: 18px;
}

.form-content > .step-header > .step-icon.active {
    background-color: #4A3AFF;
}

.form-content > .step-header > .step-icon.active > span {
    color: #fff;
}

.form-content > .step-header > .step-bar {
    display: flex;
    justify-content: flex-start;
    width: 100px;
    height: 8px;
    margin: 0 10px;
    border-radius: 10px;
    background-color: #cfd1dd;
}

.form-content > .step-header > .step-bar > div {
    height: 100%;
    border-radius: 10px;
    background-color: #4A3AFF;
}

.form-content > .step-header > .step-bar.hover > div {
    width: 50%;
}

.form-content > .step-header > .step-bar.active > div {
    width: 100%;
}

.form-content > .line {
    width: 80%;
    height: 1px;
    margin: 30px 0;
    background-color: #d5d5d8;
}

.form-content > section {
    width: 90%;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.form-content > section > h2 {
    font-weight: 700;
    font-size: 28px;
    margin: 6px 0;
}

.form-content > section > h3 {
    color: #6F6C90;
    margin: 6px 0;
}

.form-content .input-group {
    display: flex;
    justify-content: space-between;
    width: 100%;
    margin: 12px 0;
    gap: 24px;
}

.form-content .input-group > .input-wrapper {
    position: relative;
    display: flex;
    flex-direction: column;
    width: 100%;
}

.form-content .input-group > .input-wrapper > label {
    font-size: 18px;
    font-weight: 500;
    margin: 10px 0;
}

.form-content .input-group > .input-wrapper .input-box {
    display: flex;
    align-items: center;
    width: 100%;
    padding: 6px 16px;
    box-sizing: border-box;
    border-radius: 25px;
    border: 1px solid #D9DBE9;
    cursor: pointer;
}

.form-content .input-group > .input-wrapper .input-box.error {
    transition: all 100ms ease-in;
    border: 1px solid #d33f3f;
    box-shadow: 0 0 6px #d33f3f;
}

.form-content .input-group > .input-wrapper .input-box > input {
    width: 100%;
    height: 36px;
    box-sizing: border-box;
    border: none;
    font-size: 16px;
}

.form-content .input-group > .input-wrapper .input-box > input:focus {
    border: none;
    outline: none;
}

.form-content .input-group > .input-wrapper .input-box > span {
    margin: 8px 4px;
    width: 100%;
    font-size: 16px;
    user-select: none;
}

.form-content .input-group > .input-wrapper .input-box > .icon {
    margin: 2px;
}

.form-content .input-group > .input-wrapper .dropdown-box {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    position: absolute;
    width: 100%;
    z-index: 10;
    margin-top: 10px;
    border-radius: 25px;
    background-color: #fff;
    border: 1px solid #d5d5d8;
}

.form-content .input-group > .input-wrapper .dropdown-box > .dropdown-list {
    list-style-type: none;
    display: flex;
    flex-direction: column;
    margin: 4px 0;
    padding: 0;
}

.form-content .input-group > .input-wrapper .dropdown-box > .dropdown-list > .dropdown-item {
    cursor: pointer;
    list-style-type: none;
    padding: 12px 0;
    margin: 4px 0;
    text-align: center;
}

.form-content .input-group > .input-wrapper .dropdown-box > .dropdown-list > .dropdown-item:hover {
    filter:brightness(4);
    transition: all 50ms ease-in-out;
}

.step-buttons {
    display: flex;
    width: 100%;
    margin: 24px 0;
}

.step-buttons > button, .step-button {
    padding: 16px 36px;
    border-radius: 30px;
    background-color: #4A3AFF;
    border: solid 1px #4A3AFF;
    color: #fff;
    font-size: 18px;
    font-weight: 500;
    cursor: pointer;
}

.step-button-prev {
    background-color: transparent !important;
    color: #4A3AFF !important;
}

.step-button-prev:hover {
    transition: all 50ms ease-in-out;
    background-color: #4A3AFF;
    color: #fff;
}

.step-button-next {
    margin-left: auto;
}

.step-button-next:hover {
    transition: all 50ms ease-in-out;
    filter: brightness(160%)
}

/* .step-buttons > button:active {
    transition: all 50ms ease-in-out;
    filter: brightness(180%);
} */

.file-buttons {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    width: 100%;
    margin: 15px 0;
}

.file-buttons > .file-button {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    margin: 10px;
    padding-left: 25px;
    box-sizing: border-box;
    width: 290px;
    height: 130px;
    border: 1px solid #D9DBE9;
    border-radius: 25px;
    box-shadow: 10px 10px 22px -12px rgba(79,79,79,0.33);
    cursor: pointer;
}

.file-buttons > .file-button.active {
    transition: all 50ms ease-in;
    border: 2px solid #4A3AFF;
}

.file-buttons > .file-button.error {
    transition: all 100ms ease-in;
    border: 2px solid #d33f3f;
    box-shadow: 0 0 6px #d33f3f;
}

.file-buttons > .file-button > .file-button-wrapper {
    display: flex;
    align-items: center;
}

.file-buttons > .file-button > .file-button-wrapper > .icon-circle {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 72px;
    height: 72px;
    background-color: #4a3aff28;
    border-radius: 50%;
}

.file-buttons > .file-button > .file-button-wrapper > .icon-circle > img {
    width: 48px;
    height: 48px;
    filter: brightness(120%);
}

.file-buttons > .file-button > .file-button-wrapper > span {
    margin-left: 12px;
    font-weight: 500;
    font-size: 20px;
}

.success-content {
    display: flex;
    justify-content: center;
    width: 100%;
}

.success-content-wrapper {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 450px;
}

.success-content-wrapper > .icon {
    width: 128px;
    height: 128px;
}

.success-content-wrapper > h1 {
    margin: 12px;
    font-weight: 600;
}

.success-content-wrapper > h3 {
    margin: 0;
    font-size: 18px;
    text-align: center;
    color: #6F6C90;
}

.success-content-wrapper > a {
    text-decoration: none;
    margin: 26px 0 !important;
}
</style>

<script>
    import Vue from 'vue';
    import vClickOutside from 'v-click-outside';
    import CheckCircle from '../components/CheckCircle';

    Vue.use(vClickOutside);

    export default {
        async asyncData({ $axios }) {
            const universities = await $axios.$get("/universities");
            const fileCategories = await $axios.$get("/file/categories");
            fileCategories.data.forEach(category => {
                category.file = null;
                category.filledError = false;
            });
            return {
                universities: universities.data,
                fileCategories: fileCategories.data
            };
        },
        head() {
            return {
                title: "Register"
            };
        },
        data() {
            return {
                maxStep: 3,
                step: 1,
                universities: [],
                dropdown: {
                    isUniversityOpen: false
                },
                form: {
                    name: null,
                    email: null,
                    phone: null,
                    university: null,
                    password: null,
                    passwordConfirm: null,
                },
                invalidInput: {
                    name: false,
                    email: false,
                    phone: false,
                    university: false,
                    password: false,
                    passwordConfirm: false
                }
            };
        },
        methods: {
            pickUniversity(index) {
                this.form.university = index;
                this.dropdown.isUniversityOpen = false;
            },
            async emailExist(email) {
                const { exist: response } = await this.$axios.$get("/user/emailexist", {
                    params: {
                        email
                    }
                });
                return response;
            },
            validateEmail(email) {
                return !!email.match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
            },
            async checkFields() {
                const name = this.form.name;
                const email = this.form.email;
                const emailValid = !!email ? this.validateEmail(email) : false;
                const emailExist = !!email ? await this.emailExist(email) : false;
                const phone = this.form.phone;
                const university = this.form.university;
                const password = this.form.password;
                const passwordConfirm = this.form.passwordConfirm;
                this.invalidInput = {
                    name: name == null,
                    email: email == null || !emailValid || emailExist,
                    phone: phone == null,
                    university: university == null,
                    password: password == null,
                    passwordConfirm: passwordConfirm == null || password != passwordConfirm,
                };
                if (name == null ||
                    email == null ||
                    !emailValid ||
                    emailExist ||
                    phone == null ||
                    university == null ||
                    password == null ||
                    passwordConfirm == null ||
                    password != passwordConfirm)
                    return false;
                return true;
            },
            async checkFirstStep() {
                const response = await this.checkFields();
                if (response)
                    this.step++;
            },
            fileUpdate(e, category) {
                category.file = e.target.files[0];
            },
            checkSecondStep() {
                let allowToProceed = true;
                this.fileCategories.forEach((category) => {
                    if (category.file === null) {
                        category.filledError = true;
                        allowToProceed = false;
                    }
                });
                if (allowToProceed)
                    this.submitForm();
            },
            async submitForm() {
                const formData = new FormData();

                formData.append('name', this.form.name);
                formData.append('email', this.form.email);
                formData.append('phone', this.form.phone);
                formData.append('university_id', this.universities[this.form.university].id);
                formData.append('password', this.form.password);

                this.fileCategories.forEach((category) => {
                    formData.append(`file_${category.id}`, category.file)
                });

                await this.$axios.post('/auth/create', formData)
                    .then(() => {
                        this.step++;
                    });
            }
        },
    components: { CheckCircle }
}
</script>
