<script setup>
import { ref, onMounted} from 'vue';
import { Form, Field } from 'vee-validate';
import Swal from 'sweetalert2';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';
import * as yup from 'yup';
import axios from 'axios';
import { useToastr } from '../../toastr.js';
const toastr = useToastr();
const form = ref(null);
const editing = ref(false);
const grades = ref();
const class_rooms = ref();
const Teachers = ref();


const addExplanations = () => {
    editing.value = false;
    $('#ExplanationFormModal').modal('show');
};
// Craeteting
const createSchema = yup.object({
    name: yup.string().required(),
    grade_id: yup.string().required(),
    class_room_id: yup.string().required(),
    teacher_id: yup.string().required(),
});

const create = (values, { resetForm, setErrors }) => {
    axios.post('/api/createSections', values)
        .then((response) => {
            const gradeId = response.data.grade_id;
            const sectionToAdd = response.data;


            const gradeIndex = grades.value.data.findIndex(grade => grade.id === gradeId);

            if (gradeIndex !== -1) {
                grades.value.data[gradeIndex].sections.unshift(sectionToAdd);
            }
            $('#FormModal').modal('hide');
            resetForm();
            toastr.success('Sections created successfully!');
        })
        .catch((error) => {
            if (error.response.errors) {
                setErrors(error.response.errors);
            }
        });
};


const getGrade = () => {
    axios.get('/api/grade')
        .then((response) => {
            grades.value = response.data;
        })
};

const getClass_room = () => {
    axios.get('/api/classRoom')
        .then((response) => {
            class_rooms.value = response.data;
        })
};
const getTeacher = () => {
    axios.get('/api/Teacher')
        .then((response) => {
            Teachers.value = response.data;
        })
};


const editExplanation = (classRoom) => {
    editing.value = true;
    form.value.resetForm();
    $('#ExplanationFormModal').modal('show');
    formValues.value = {
        id: classRoom.id,
        name_class: classRoom.name_class,
        grade_id: classRoom.grade_id,
    };
};
const updateExplanation = (values, { setErrors }) => {
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






onMounted(() => {
    getGrade();
    getClass_room();
    getTeacher();
});
</script>
<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Explanations</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Explanations</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-form-label-sm">
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <div class="d-flex">

                                <button   @click="addExplanations"  type="button" class="mb-2 btn btn-primary">
                                    <i class="fa fa-plus-circle mr-1"></i>
                                    Add New explanations
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
                                    <th scope="col">Explanations Name</th>
                                    <th scope="col">Grade</th>
                                    <th scope="col">ClassRoom</th>
                                    <th scope="col">Teacher</th>
                                    <th scope="col">Class time</th>
                                    <th scope="col">Notes</th>
                                    <th scope="col">Options</th>
                                </tr>
                                </thead>
                                <tbody>
<!--                                v-for="(grade, index) in grades.data" :key="grade.id"-->
                                <tr>
<!--                                    <td>{{ index + 1 }}</td>-->
<!--                                    <td>{{ grade.name }}</td>-->
<!--                                    <td>{{ grade.notes }}</td>-->
                                    <td>1</td>
                                    <td>حصه  عربي </td>
                                    <td>المرحلة آلإعدادية</td>
                                    <td>الصف الاول</td>
                                    <td>محمد احمد </td>
                                    <td>36 دقية </td>
                                    <td>لا  يوجد  اي ملحوظات </td>
                                    <td>
<!--                                        @click.prevent="editGgrad(grade)"-->
                                        <a  href="#" ><i class="fa fa-edit mr-1"></i></a>
<!--                                        @click.prevent="deletegrades(grade.id)"-->

                                        <a  href="#" >
                                            <i class="fa fa-trash text-danger ml-1"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
<!--                            <Bootstrap4Pagination :data="grades" @pagination-change-page="getGrades" />-->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ExplanationFormModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span v-if="editing">Edit User</span>
                        <span v-else>Add New Explanations</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <Form ref="form" @submit="handleSubmit" :validation-schema="editing ? editExplanation : createClassRoomSchema"
                      v-slot="{ errors }" :initial-values="formValues">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name Explanations</label>
                            <Field name="name" type="text" class="form-control" :class="{ 'is-invalid': errors.name }"
                                   id="name" aria-describedby="nameHelp" placeholder="Enter full name" />
                            <span class="invalid-feedback">{{ errors.name }}</span>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Grade Name</label>
                                    <Field name="grade_id" as="select" class="form-control" :class="{ 'is-invalid': errors.grade_id }"
                                           id="grade_id">
                                        <option v-for="grade in grades" :value="grade.id" :key="grade.id">{{grade.name}}</option>
                                    </Field>
                                    <span class="invalid-feedback">{{ errors.grade_id }}</span>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">classRoom Name</label>
                                    <Field name="class_room_id" as="select" class="form-control" :class="{ 'is-invalid': errors.class_room_id }"
                                           id="class_room_id">
                                        <option v-for="class_room in class_rooms" :value="class_room.id" :key="class_room.id">{{class_room.name_class}}</option>
                                    </Field>
                                    <span class="invalid-feedback">{{ errors.class_room_id }}</span>
                                </div>
                            </div>
                            <div  class="col-md-4">
                                <div class="form-group">
                                    <label for="teacher_id">Teacher Name</label>
                                    <Field name="teacher_id" as="select" class="form-control" :class="{ 'is-invalid': errors.teacher_id }"
                                           id="teacher_id">
                                        <option v-for="Teacher in Teachers" :value="Teacher.id" :key="Teacher.id">{{Teacher.name}}</option>
                                    </Field>
                                    <span class="invalid-feedback">{{ errors.teacher_id }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Notes</label>
                            <Field as="textarea" name="notes"  class="form-control"
                                   :class="{ 'is-invalid': errors.notes }" id="notes" placeholder="Enter notes"/>
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

