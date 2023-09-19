<script setup>
import { ref, onMounted} from 'vue';
import { Form, Field } from 'vee-validate';
import Swal from 'sweetalert2';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';
import * as yup from 'yup';
import axios from 'axios';
import { useToastr } from '../../toastr.js';

const toastr = useToastr();
const teachers =  ref({'data': []});
const formValues = ref();
const form = ref(null);
const editing = ref(false);
const genders = ref();
const specializations = ref();
const selectedUsers = ref([]);
const selectAll = ref(false);

const getTeachers = (page = 1) => {
    axios.get(`/api/teachers/?page=${page}`)
        .then((response) => {
            teachers.value = response.data;
            selectedUsers.value = [];
            selectAll.value = false;
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

const createClassRoomSchema = yup.object({
    name_class: yup.string().required(),
    grade_id: yup.string().required(),
});

const createClassRooms = (values, { resetForm, setErrors }) => {
    axios.post('/api/createClassRooms', values)
        .then((response) => {
            classRooms.value.data.unshift(response.data);
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
//  حل مشكلة تحديث الجداول  تلقائي بسب العِلاقة
const getGenderName = (genderId) => {
    const gender = genders.value.find(gender => gender.id === genderId);
    return gender ? gender.Name : 'genderNmae';
}
const getSpecializationName = (specializationId) => {
    const specialization = specializations.value.find(specialization => specialization.id === specializationId);
    return specialization ? specialization.Name : 'specializationNmae';
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
const toggleSelection = (classRoom) => {
    const index = selectedUsers.value.indexOf(classRoom.id);
    if (index === -1) {
        selectedUsers.value.push(classRoom.id);
    } else {
        selectedUsers.value.splice(index, 1);
    }
    console.log(selectedUsers.value);
};

const bulkDelete = () => {
    axios.delete('/api/classRooms', {
        data: {
            ids: selectedUsers.value
        }
    })
        .then(response => {
            classRooms.value.data = classRooms.value.data.filter(classRoom => !selectedUsers.value.includes(classRoom.id));
            selectedUsers.value = [];
            selectAll.value = false;
            toastr.success(response.data.message);
        });
};
//selectAllUsers
const selectAllUsers = () => {
    if (selectAll.value) {
        selectedUsers.value = classRooms.value.data.map(classRoom => classRoom.id);
    } else {
        selectedUsers.value = [];
    }
    console.log(selectedUsers.value);
}

onMounted(() => {
    getTeachers();
    getGender();
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
                    <button @click="addClassRooms" type="button" class="mb-2 btn btn-primary">
                        <i class="fa fa-plus-circle mr-1"></i>
                        Add New ClassRoom
                    </button>


                    <div  v-if="selectedUsers.length > 0">
                        <button @click="bulkDelete" type="button" class="ml-2 mb-2 btn btn-danger">
                            <i class="fa fa-trash mr-1"></i>
                            Delete Selected
                        </button>
                        <span class="ml-2">Selected {{ selectedUsers.length }} users</span>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>

                            <th><input type="checkbox" v-model="selectAll" @change="selectAllUsers" /></th>
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
                            <td style="width: 0px"></td>
                            <td>{{ index + 1 }}</td>
                            <td>{{ teacher.name }}</td>
                            <td>{{ getGenderName(teacher.Gender_id) }}</td>
                            <td>{{ getSpecializationName(teacher.specialization_id) }}</td>
                            <td>{{teacher.joining_Date}}</td>
                            <td>
                                <a  href="#" @click.prevent="editClassRooms(teacher)"><i class="fa fa-edit mr-1"></i></a>

                                <a  href="#" @click.prevent="deleteclassRoom(teacher.id)">
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
                                   id="name_class"  placeholder="Enter full ClassRoom Name" />
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
