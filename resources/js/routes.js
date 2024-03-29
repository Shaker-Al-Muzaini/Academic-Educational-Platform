import Das from './components/Das.vue';
import ListAppointments from './pages/appointments/ListAppointments.vue';
import UserList from './pages/users/UserList.vue';
import AppointmentForm from './pages/appointments/AppointmentForm.vue';
import UpdateSetting from './pages/settings/UpdateSetting.vue';
import UpdateProfile from './pages/profile/UpdateProfile.vue';
import Login from './pages/auth/Login.vue'
import Grades from './pages/grades/ListGrades.vue'
import ClassRooms from './pages/classRooms/ListClassRooms.vue'
import Sections from './pages/sections/listSections.vue'
import Parents from './pages/parents/ListParents.vue'
import Teacher from './pages/teachers/teacher.vue'
import Student from './pages/students/ListStudents.vue'
import ShowStudent from './pages/students/ShowStudent.vue'
import Explanations from './pages/explanations/ts.vue'
export default[
    {
        path: '/admin/dashboard',
        name: 'Das',
        component: Das,
    },

    {
        path: '/login',
        name: 'admin.login',
        component: Login,
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
    },

    {
        path: '/admin/appointments/create',
        name: 'admin.appointments.create',
        component: AppointmentForm,
    },
    {
        path: '/admin/appointments/:id/edit',
        name: 'admin.appointments.edit',
        component: AppointmentForm,
    },
    {
        path: '/admin/grades',
        name: 'admin.grades',
        component: Grades,
    },

    {
        path: '/admin/classRooms',
        name: 'admin.classRooms',
        component: ClassRooms,
    },

    {
        path: '/admin/sections',
        name: 'admin.sections',
        component: Sections,
    },
    {
        path: '/admin/parents',
        name: 'admin.parents',
        component: Parents,
    },
    {
        path: '/admin/teacher',
        name: 'admin.teacher',
        component: Teacher,
    },
    {
        path: '/admin/student',
        name: 'admin.student',
        component: Student,
    },
    {
        path: '/admin/student/show/:id',
        name: 'admin.showStudent',
        component: ShowStudent,
        props: true,
    },
    {
        path: '/admin/explanations',
        name: 'admin.explanations',
        component:Explanations,

    },



]
