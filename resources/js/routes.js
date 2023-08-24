import Das from './components/Das.vue';
import ListAppointments from './pages/appointments/ListAppointments.vue';
import UserList from './pages/users/UserList.vue';
import UpdateSetting from './pages/settings/UpdateSetting.vue';
import UpdateProfile from './pages/profile/UpdateProfile.vue';
export default[
    {
        path: '/admin/dashboard',
        name: 'Das',
        component: Das,
    },

    {
        path: '/admin/appointments',
        name: 'admin.appointments',
        component: ListAppointments,
    },


    {
        path: '/admin/users',
        name: 'admin.users',
        component: ListAppointments,
    },
    {
        path: '/admin/users',
        name: 'admin.users',
        component: UserList,
    },
    {
        path: '/admin/settings',
        name: 'admin.settings',
        component: UpdateSetting,
    },

    {
        path: '/admin/profile',
        name: 'admin.profile',
        component: UpdateProfile,
    }
]
