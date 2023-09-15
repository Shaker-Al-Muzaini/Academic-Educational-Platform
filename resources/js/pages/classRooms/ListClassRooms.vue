<script setup>
import { ref, onMounted} from 'vue';
import { Form, Field } from 'vee-validate';
import Swal from 'sweetalert2';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';
import * as yup from 'yup';
import axios from 'axios';
import { useToastr } from '../../toastr.js';

const toastr = useToastr();
const classRooms =  ref({'data': []});
const formValues = ref();
const form = ref(null);
const editing = ref(false);


const getClassRooms = (page = 1) => {
    axios.get(`/api/classRooms/?page=${page}`)
        .then((response) => {
            classRooms.value = response.data;
        })
};

//Craeteting

const createClassRoomSchema = yup.object({
    name_class: yup.string().required(),
    grade_id: yup.string().required(),
});

const createClassRooms = (values, { resetForm, setErrors }) => {
    axios.post('/api/createClassRooms', values)
        .then((response) => {
            grades.value.data.unshift(response.data);
            $('#classRoomsFormModal').modal('hide');
            resetForm();
            toastr.success('ClassRooms created successfully!');
        })
        .catch((error) => {
            if (error.response.data.errors) {
                setErrors(error.response.data.errors);
            }
        })
};
const addClassRooms = () => {
    editing.value = false;
    $('#classRoomsFormModal').modal('show');
};

const grades = ref();
const getGrade = () => {
    axios.get('/api/grade')
        .then((response) => {
            grades.value = response.data;
        })
};



//editing

const editClassRoomsSchema = yup.object({
    name_class: yup.string().required(),
    grade_id: yup.string().required(),
});

const editClassRooms = (classRoom) => {
    editing.value = true;
    form.value.resetForm();
    $('#classRoomsFormModal').modal('show');
    formValues.value = {
        id: classRoom.id,
        name_class: classRoom.name_class,
        grade_id: classRoom.grade_id,
    };
};
const updateClassRooms = (values, { setErrors }) => {
    axios.put('/api/classRooms/'+ formValues.value.id, values)
        .then((response) => {
            const index = classRooms.value.data.findIndex(classRoom => classRoom.id === response.data.id);
            classRooms.value.data[index] = response.data;
            $('#classRoomsFormModal').modal('hide');
            toastr.success('ClassRoom updated successfully!');
        }).catch((error) => {
        setErrors(error.response.data.errors);
        console.log(error);
    });
}
const handleSubmit = (values, actions) => {
    // console.log(actions);
    if (editing.value) {
        updateClassRooms(values, actions);
    } else {
        createClassRooms(values, actions);
    }
}

const deleteclassRoom = (id) => {
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
            axios.delete(`/api/classRooms/${id}`)
                .then((response) => {
                    classRooms.value.data = classRooms.value.data.filter(classRoom => classRoom.id !== id);
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
    getClassRooms();
    getGrade();
});
</script>
<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Class Room</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">class Room</li>
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
                                <button @click="addClassRooms" type="button" class="mb-2 btn btn-primary">
                                    <i class="fa fa-plus-circle mr-1"></i>
                                    Add New ClassRoom
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
                                    <th scope="col">Class Room Name</th>
                                    <th scope="col">Grade Name</th>
                                    <th scope="col">Options</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(classRoom, index) in classRooms.data" :key="classRoom.id">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ classRoom.name_class }}</td>
                                    <td>{{ classRoom.grade.name }}</td>

                                    <td>
                                        <a  href="#" @click.prevent="editClassRooms(classRoom)"><i class="fa fa-edit mr-1"></i></a>

                                        <a  href="#" @click.prevent="deleteclassRoom(classRoom.id)">
                                            <i class="fa fa-trash text-danger ml-1"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <Bootstrap4Pagination :data="classRooms" @pagination-change-page="getClassRooms" />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="classRoomsFormModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span v-if="editing">Edit ClassRoom</span>
                        <span v-else>Add New ClassRoom</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <Form ref="form" @submit="handleSubmit" :validation-schema="editing ? editClassRoomsSchema : createClassRoomSchema"
                      v-slot="{ errors }" :initial-values="formValues">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name_class">ClassRoom Name </label>
                            <Field name="name_class" type="text" class="form-control" :class="{ 'is-invalid': errors.name_class }"
                                   id="name_class" aria-describedby="name_classHelp" placeholder="Enter full ClassRoom Name" />
                            <span class="invalid-feedback">{{ errors.name_class }}</span>
                        </div>


                        <div class="form-group">
                            <label for="email">Grade Name</label>
                            <Field name="grade_id" as="select" class="form-control" :class="{ 'is-invalid': errors.grade_id }"
                                   id="grade_id">
                                <option v-for="grade in grades" :value="grade.id" :key="grade.id">{{grade.name}}</option>
                            </Field>
                            <span class="invalid-feedback">{{ errors.grade_id }}</span>

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
