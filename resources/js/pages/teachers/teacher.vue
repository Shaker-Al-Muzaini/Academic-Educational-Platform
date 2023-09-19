<script setup>
import { ref, onMounted} from 'vue';
import { Form, Field } from 'vee-validate';
import Swal from 'sweetalert2';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';
import * as yup from 'yup';
import axios from 'axios';
import { useToastr } from '../../toastr.js';
import flatpickr from "flatpickr";
import 'flatpickr/dist/themes/light.css';

const toastr = useToastr();
const teachers =  ref({'data': []});
const formValues = ref();
const form = ref(null);
const editing = ref(false);
const genders = ref();
const specializations = ref();

const getTeachers = (page = 1) => {
    axios.get(`/api/teachers/?page=${page}`)
        .then((response) => {
            teachers.value = response.data;
        })
};

const getGender = () => {
    axios.get('/api/genders')
        .then((response) => {
            genders.value = response.data;
        })
};

const getSpecialization = () => {
    axios.get('/api/specializations')
        .then((response) => {
            specializations.value = response.data;
        })
};

//Craeteting

const createTeacherSchema = yup.object({
    email: yup.string().required().email(),
    Gender_id: yup.string().required(),
    specialization_id: yup.string().required(),
    name: yup.string().required(),
    password: yup.string().required().min(8),
    address: yup.string().required(),
    joining_Date: yup.string().required(),
});

const createTeacher = (values, { resetForm, setErrors }) => {
    axios.post('/api/teachers', values)
        .then((response) => {
            teachers.value.data.unshift(response.data);
            $('#teacherFormModal').modal('hide');
            resetForm();
            toastr.success('teacher created successfully!');
        })
        .catch((error) => {
            setErrors(error.response.data.errors);
            console.log(error);
        })
};
const addTeacher = () => {
    editing.value = false;
    $('#teacherFormModal').modal('show');
};






//editing

const editTeacherSchema = yup.object({
    email: yup.string().required().email(),
    Gender_id: yup.string().required(),
    specialization_id: yup.string().required(),
    name: yup.string().required(),
    password: yup.string().required().min(8),
    address: yup.string().required(),
    joining_Date: yup.string().required(),
});

const editTeacher = (teacher) => {
    editing.value = true;
    form.value.resetForm();
    $('#teacherFormModal').modal('show');
    formValues.value = {
        id: teacher.id,
        email: teacher.email,
        name: teacher.name,
        Gender_id: teacher.Gender_id,
        specialization_id: teacher.specialization_id,
        password: teacher.password,
        address: teacher.address,
        joining_Date: teacher.joining_Date,

    };
};
const updateTeacher = (values, { setErrors }) => {
    axios.put('/api/teachers/'+ formValues.value.id, values)
        .then((response) => {
            const index = teachers.value.data.findIndex(teacher => teacher.id === response.data.id);
            teachers.value.data[index] = response.data;
            $('#teacherFormModal').modal('hide');
            toastr.success('teachers updated successfully!');
        }).catch((error) => {
        setErrors(error.response.data.errors);
        console.log(error);
    });
}
const handleSubmit = (values, actions) => {
    // console.log(actions);
    if (editing.value) {
        updateTeacher(values, actions);
    } else {
        createTeacher(values, actions);
    }
}
//  حل مشكلة تحديث الجداول  تلقائي بسب العِلاقة
const getGenderName = (genderId) => {
    const gender = genders.value.find(gender => gender.id === genderId);
    return gender ? gender.Name : 'genderNmae';
}
const getSpecializationName = (specializationId) => {
    const specialization = specializations.value.find(specialization => specialization.id === specializationId);
    return specialization ? specialization.Name : 'specializationNmae';
}
const deleteTeacher = (id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/api/teachers/${id}`)
                .then((response) => {
                    teachers.value.data = teachers.value.data.filter(teacher => teacher.id !== id);
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                });
        }
    })
};



onMounted(() => {
    getTeachers();
    getGender();
    flatpickr(".flatpickr", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        defaultHour: 10,
        time_24hr: false,
    });
    getSpecialization();


});
</script>
<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Teachers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Teachers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">

                <div class="d-flex">
                    <button @click="addTeacher" type="button" class="mb-2 btn btn-primary">
                        <i class="fa fa-plus-circle mr-1"></i>
                        Add New ClassRoom
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th scope="col">Teacher Name</th>
                            <th scope="col">Gender Type</th>
                            <th scope="col">Specialization</th>
                            <th scope="col">joining Date</th>
                            <th scope="col">Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(teacher, index) in teachers.data" :key="teacher.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ teacher.name }}</td>
                            <td>{{ getGenderName(teacher.Gender_id) }}</td>
                            <td>{{ getSpecializationName(teacher.specialization_id) }}</td>
                            <td>{{teacher.joining_Date}}</td>
                            <td>
                                <a  href="#" @click.prevent="editTeacher(teacher)"><i class="fa fa-edit mr-1"></i></a>

                                <a  href="#" @click.prevent="deleteTeacher(teacher.id)">
                                    <i class="fa fa-trash text-danger ml-1"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <Bootstrap4Pagination :data="teachers" @pagination-change-page="getTeachers" />
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="teacherFormModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span v-if="editing">Edit Teacher</span>
                        <span v-else>Add New Teacher</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <Form ref="form" @submit="handleSubmit" :validation-schema="editing ? editTeacherSchema : createTeacherSchema"
                      v-slot="{ errors }" :initial-values="formValues">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Teacher email </label>
                                    <Field name="email" type="email" class="form-control" :class="{ 'is-invalid': errors.email }"
                                           id="email"  placeholder="Enter full Teacher email" />
                                    <span class="invalid-feedback">{{ errors.email }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="password">Teacher password </label>
                                <Field name="password" type="password" class="form-control" :class="{ 'is-invalid': errors.password }"
                                       id="password"  placeholder="Enter full Teacher password" />
                                <span class="invalid-feedback">{{ errors.password }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Teacher Name </label>
                                    <Field name="name" type="text" class="form-control" :class="{ 'is-invalid': errors.name }"
                                           id="name"  placeholder="Enter full Teacher Name" />
                                    <span class="invalid-feedback">{{ errors.Name }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="address">Teacher Address </label>
                                <Field name="address" type="text" class="form-control" :class="{ 'is-invalid': errors.address }"
                                       id="address"  placeholder="Enter full Teacher Address" />
                                <span class="invalid-feedback">{{ errors.address }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Gender_id">Gender Name</label>
                                    <Field name="Gender_id" as="select" class="form-control" :class="{ 'is-invalid': errors.Gender_id }"
                                           id="Gender_id">
                                        <option v-for="gender in genders" :value="gender.id" :key="gender.id">{{gender.Name}}</option>
                                    </Field>
                                    <span class="invalid-feedback">{{ errors.Gender_id }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="specialization_id">Specialization Name</label>
                                <Field name="specialization_id" as="select" class="form-control" :class="{ 'is-invalid': errors.specialization_id }"
                                       id="specialization_id">
                                    <option v-for="specialization in specializations" :value="specialization.id" :key="specialization.id">{{specialization.Name}}</option>
                                </Field>
                                <span class="invalid-feedback">{{ errors.specialization_id }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="joining Date">joining Date</label>
                            <Field  name="joining_Date"  type="date"  class="form-control flatpickr" :class="{ 'is-invalid': errors.joining_Date }"
                                   id="joining_Date" />
                            <span class="invalid-feedback">{{ errors.joining_Date }}</span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </Form>
            </div>
        </div>
    </div>
</template>
