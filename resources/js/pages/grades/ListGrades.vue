<script setup>
import { ref, onMounted} from 'vue';
import { Form, Field, useResetForm } from 'vee-validate';
import Swal from 'sweetalert2';
import { debounce } from 'lodash';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';
import * as yup from 'yup';
import axios from 'axios';
import { useToastr } from '../../toastr.js';

const toastr = useToastr();
const grades =  ref({'data': []});
const formValues = ref();
const form = ref(null);
const editing = ref(false);


const getGrades = (page = 1) => {
    axios.get(`/api/grades/?page=${page}`)
        .then((response) => {
            grades.value = response.data;
        })
};

//Craeteting

const createGradesSchema = yup.object({
    name: yup.string().required(),
    notes: yup.string().required(),
});

const createGrades = (values, { resetForm, setErrors }) => {
    axios.post('/api/createGrades', values)
        .then((response) => {
            grades.value.data.unshift(response.data);
            $('#gradesFormModal').modal('hide');
            resetForm();
            toastr.success('Grades created successfully!');
        })
        .catch((error) => {
            if (error.response.data.errors) {
                setErrors(error.response.data.errors);
            }
        })
};
const addGrades = () => {
    editing.value = false;
    $('#gradesFormModal').modal('show');
};





//editing

const editGraesSchema = yup.object({
    name: yup.string().required(),
    notes: yup.string().required(),
});

const editGgrad = (grade) => {
    editing.value = true;
    form.value.resetForm();
    $('#gradesFormModal').modal('show');
    formValues.value = {
        id: grade.id,
        name: grade.name,
        notes: grade.notes,
    };
};
const updateGrades = (values, { setErrors }) => {
    axios.put('/api/grades/'+ formValues.value.id, values)
        .then((response) => {
            const index = grades.value.data.findIndex(grade => grade.id === response.data.id);
            grades.value.data[index] = response.data;
            $('#gradesFormModal').modal('hide');
            toastr.success('grades updated successfully!');
        }).catch((error) => {
        setErrors(error.response.data.errors);
        console.log(error);
    });
}
const handleSubmit = (values, actions) => {
    // console.log(actions);
    if (editing.value) {
        updateGrades(values, actions);
    } else {
        createGrades(values, actions);
    }
}

const deletegrades = (id) => {
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
            axios.delete(`/api/grades/${id}`)
                .then((response) => {
                    grades.value.data = grades.value.data.filter(grade => grade.id !== id);
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
    getGrades();
    // getGradestatus();
});
</script>
<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Grades</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Grades</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <div class="d-flex">
                                <button @click="addGrades" type="button" class="mb-2 btn btn-primary">
                                    <i class="fa fa-plus-circle mr-1"></i>
                                    Add New Grades
                                </button>
                        </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Grades Name</th>
                                    <th scope="col">Grades Notes</th>
                                    <th scope="col">Options</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(grade, index) in grades.data" :key="grade.id">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ grade.name }}</td>
                                    <td>{{ grade.notes }}</td>

                                    <td>
                                        <a  href="#" @click.prevent="editGgrad(grade)"><i class="fa fa-edit mr-1"></i></a>

                                        <a  href="#" @click.prevent="deletegrades(grade.id)">
                                            <i class="fa fa-trash text-danger ml-1"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <Bootstrap4Pagination :data="grades" @pagination-change-page="getGrades" />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="gradesFormModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span v-if="editing">Edit User</span>
                        <span v-else>Add New Grades</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <Form ref="form" @submit="handleSubmit" :validation-schema="editing ? editGraesSchema : createGradesSchema"
                      v-slot="{ errors }" :initial-values="formValues">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <Field name="name" type="text" class="form-control" :class="{ 'is-invalid': errors.name }"
                                   id="name" aria-describedby="nameHelp" placeholder="Enter full name" />
                            <span class="invalid-feedback">{{ errors.name }}</span>
                        </div>

                        <div class="form-group">
                            <label for="email">Notes</label>
                            <textarea name="notes" type="text" class="form-control "
                                   :class="{ 'is-invalid': errors.notes }" id="email" aria-describedby="nameHelp"
                                   placeholder="Enter notes "></textarea>
                            <span class="invalid-feedback">{{ errors.notes }}</span>

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
