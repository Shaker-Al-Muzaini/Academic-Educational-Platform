<script setup>
import { useAuthUserStore } from '../stores/AuthUserStore';
import { useSettingStore } from '../stores/SettingStore';
import {useRouter} from "vue-router";






const router=useRouter();
const authUserStore = useAuthUserStore();
const settingStore = useSettingStore();


const logout = () => {
    axios.post('/logout')
        .then((response) => {
            authUserStore.user.name='';
            router.push('/login');
        });
};
</script>
<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <a href="" class="brand-link">
            <img :src="authUserStore.user.avatar" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{settingStore.setting.app_name}}</span>
        </a>

        <div class="sidebar">

            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img :src="authUserStore.user.avatar" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <router-link to="#" class="d-block">{{authUserStore.user.name }}</router-link>
                </div>
            </div>


            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview"  data-accordion="false">

                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard Pages

                            </p>
                        </a>
                        <ul class="nav  nav-tabs-right ">
                            <li class="nav-item">
                                <router-link to="/admin/dashboard" active-class="active" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Home
                                    </p>
                                </router-link>

                            </li>
                            <li class="nav-item">
                                <router-link to="/admin/appointments"
                                             :class="$route.path.startsWith('/admin/appointments') ? 'active' : ''" class="nav-link">
                                    <i class="nav-icon fas fa-calendar-alt"></i>
                                    <p>
                                        Appointments
                                    </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/admin/users" active-class="active" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Users
                                    </p>
                                </router-link>
                            </li>

                            <li class="nav-item">
                                <router-link to="/admin/grades" active-class="active" class="nav-link">
                                    <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                    <p>
                                        Grades
                                    </p>
                                </router-link>
                            </li>

                            <li class="nav-item">
                                <router-link to="/admin/classRooms" active-class="active" class="nav-link">
                                    <i class="nav-icon  fas fa-chalkboard"></i>
                                    <p>
                                        ClassRoom
                                    </p>
                                </router-link>
                            </li>

                            <li class="nav-item">
                                <router-link to="/admin/sections" active-class="active" class="nav-link">
                                    <i class="nav-icon  fas fa-chalkboard"></i>
                                    <p>
                                        Sections
                                    </p>
                                </router-link>
                            </li>

                            <li class="nav-item">
                                <router-link to ="/admin/settings" active-class="active" class="nav-link">
                                    <i class="nav-icon fas fa-cog"></i>
                                    <p>
                                        Settings
                                    </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link to="/admin/profile" active-class="active" class="nav-link">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        Profile
                                    </p>
                                </router-link >
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <form class="nav-link">
                            <a href="#" @click.prevent="logout">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </form>

                    </li>
                </ul>
            </nav>
        </div>

    </aside>
</template>




