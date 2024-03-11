<script setup>
import { ref, onMounted} from 'vue';
import { Form, Field } from 'vee-validate';
import Swal from 'sweetalert2';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';
import * as yup from 'yup';
const formValues = ref();
import axios from 'axios';
import { useToastr } from '../../toastr.js';
const toastr = useToastr();
const form = ref(null);
const editing = ref(false);
const grades = ref();
const class_rooms = ref();
const Teachers = ref();
const explanations =  ref({'data': []});


const getExplanation = (page = 1) => {
    axios.get(`/api/explanations/?page=${page}`)
        .then((response) => {
            explanations.value = response.data;
        })
};



const addExplanations = () => {
    editing.value = false;
    $('#ExplanationFormModal').modal('show');
};

const getGradeName = (gradeId) => {
    const grade = grades.value.find(grade => grade.id === gradeId);
    return grade ? grade.name : 'gradeNmae';
}
const getclassRoomsNmae = (classRoomId) => {
    const classRoom = class_rooms.value.find(classRoom => classRoom.id === classRoomId);
    return classRoom ? classRoom.name_class : 'classRoomNmae';
}

const getTeacherNmae = (TeacherId) => {
    // التحقق من أن المتغير Teachers معرف وليس فارغاً
    if (Teachers && Teachers.value && Teachers.value.length > 0) {
        const Teacher = Teachers.value.find(Teacher => Teacher.id === TeacherId);
        return Teacher ? Teacher.name : 'TeacherIdNmae';
    } else {
        // في حالة عدم تعريف Teachers أو كونه فارغاً
        return 'Teachers list is empty or undefined';
    }
}





// Craeteting
const createSchema = yup.object({
    name: yup.string().required(),
    grade_id: yup.string().required(),
    class_room_id: yup.string().required(),
    teacher_id: yup.string().required(),
    notes: yup.string()
});
const editSchema = yup.object({
    name: yup.string().required(),
    grade_id: yup.string().required(),
    class_room_id: yup.string().required(),
    teacher_id: yup.string().required(),
    notes: yup.string()
});

const create = (values, { resetForm, setErrors }) => {
    const formData = new FormData();
    formData.append('name', values.name);
    formData.append('notes', values.notes);
    formData.append('grade_id', values.grade_id);
    formData.append('class_room_id', values.class_room_id);
    formData.append('teacher_id', values.teacher_id);
    axios.post('/api/explanations', formData, {
        headers: {
            'Content-Type': 'multipart/form-data', // تحديد نوع المحتوى كـ multipart/form-data
        },
    })


        .then((response) => {
            toastr.success('Explanation created successfully!');
            $('#ExplanationFormModal').modal('hide');
            resetForm();

            // إعادة جلب البيانات بعد الإنشاء لتحديث الجدول
            getExplanation();
        })


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
const handleSubmit = (values, actions) => {
    // console.log(actions);
    const formData = new FormData();
    if (editing.value) {
        updateExplanation(values, actions);
    } else {
        create(values, actions);
    }
}

const editExplanation = (explanation) => {
    editing.value = true;
    form.value.resetForm();
    $('#ExplanationFormModal').modal('show');
    formValues.value = {
        id: explanation.id,
        name: explanation.name,
        notes: explanation.notes,
        grade_id: explanation.grade_id,
        class_room_id: explanation.class_room_id,
        teacher_id: explanation.teacher_id,
    };
};

const updateExplanation = (values, { setErrors }) => {
    const formData = new FormData();
    // إضافة البيانات إلى النموذج
    formData.append('_method', 'PUT'); // تحديد HTTP Method كـ PUT
    formData.append('name', values.name);
    formData.append('notes', values.notes);
    formData.append('teacher_id', values.teacher_id);
    formData.append('class_room_id', values.class_room_id);
    formData.append('grade_id', values.grade_id);


    axios.post('/api/explanations/' + formValues.value.id, formData, {
        headers: {
            'Content-Type': 'multipart/form-data', // تحديد نوع المحتوى كـ multipart/form-data
        },
    })
        .then((response) => {
            const index = explanations.value.data.findIndex(explanation => explanation.id === response.data.id);
            explanations.value.data[index] = response.data;
            $('#ExplanationFormModal').modal('hide');
            toastr.success('ExplanationFormModal updated successfully!');
        })
        .catch((error) => {
            setErrors(error.response.data.errors);
            console.log(error);
        });
};
const deleteExplanation= (id) => {
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
            axios.delete(`/api/explanations/${id}`)
                .then((response) => {
                    explanations.value.data = explanations.value.data.filter(explanation => explanation.id !== id);
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
    getGrade();
    getClass_room();
    getExplanation();
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
                                    <th scope="col">Notes</th>
                                    <th scope="col">Options</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(explanation, index) in explanations.data" :key="explanation.id">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ explanation.name }}</td>
                                    <td>{{ getGradeName(explanation.grade_id) }}</td>
                                    <td>{{ getclassRoomsNmae(explanation.class_room_id) }}</td>
                                    <td>{{ getTeacherNmae(explanation.teacher_id) }}</td>
                                    <td>{{ explanation.notes }}</td>

                                    <td>
                                        <a  href="#" @click.prevent="editExplanation(explanation)"><i class="fa fa-edit mr-1"></i></a>

                                        <a  href="#" @click.prevent="deleteExplanation(explanation.id)">
                                            <i class="fa fa-trash text-danger ml-1"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <Bootstrap4Pagination :data="explanations" @pagination-change-page="getExplanation" />
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
                <Form ref="form"  enctype="multipart/form-data" @submit="handleSubmit" :validation-schema="editing ? editSchema : createSchema"
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
                                    <label for="grade_id">Grade Name</label>
                                    <Field name="grade_id" as="select" class="form-control" :class="{ 'is-invalid': errors.grade_id }"
                                           id="grade_id">
                                        <option v-for="grade in grades" :value="grade.id" :key="grade.id">{{grade.name}}</option>
                                    </Field>
                                    <span class="invalid-feedback">{{ errors.grade_id }}</span>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="class_room_id">classRoom Name</label>
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

