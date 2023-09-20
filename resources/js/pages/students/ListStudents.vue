<script setup>
import { ref, onMounted} from 'vue';
import { Form, Field } from 'vee-validate';
import Swal from 'sweetalert2';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';
import * as yup from 'yup';
import axios from 'axios';
import { useToastr } from '../../toastr.js';
const toastr = useToastr();
const students =  ref({'data': []});
const formValues = ref();
const form = ref(null);
const editing = ref(false);
const genders = ref();
const classRooms = ref();
const grades = ref();
const sections = ref();
const ParentStudents = ref();

const getStudents = (page = 1) => {
    axios.get(`/api/students/?page=${page}`)
        .then((response) => {
            students.value = response.data;
        })
};

const getGender = () => {
    axios.get('/api/genders')
        .then((response) => {
            genders.value = response.data;
        })
};

const getclassRooms = () => {
    axios.get('/api/classRoom')
        .then((response) => {
            classRooms.value = response.data;
        })
};
const getsections = () => {
    axios.get('/api/sections')
        .then((response) => {
            sections.value = response.data;
        })
};

const getParentStudent = () => {
    axios.get('/api/ParentStudent')
        .then((response) => {
            ParentStudents.value = response.data;
        })
};

const getgrade = () => {
    axios.get('/api/grade')
        .then((response) => {
            grades.value = response.data;
        })
};

//Craeteting

const createStudentSchema = yup.object({
    email: yup.string().required().email(),
    Gender_id: yup.string().required(),
    parent_student_id: yup.string().required(),
    name: yup.string().required(),
    password: yup.string().required().min(8),
    address: yup.string().required(),
    class_room_id: yup.string().required(),
    section_id: yup.string().required(),
    grade_id: yup.string().required(),
});

const createStudent = (values, { resetForm, setErrors }) => {
    axios.post('/api/students', values)
        .then((response) => {
            students.value.data.unshift(response.data);
            $('#StudentsFormModal').modal('hide');
            resetForm();
            toastr.success('Student created successfully!');
        })
        .catch((error) => {
            setErrors(error.response.data.errors);
            console.log(error);
        })
};
const addStudents = () => {
    editing.value = false;
    $('#StudentsFormModal').modal('show');
};






//editing

const editStudentSchema = yup.object({
    email: yup.string().required().email(),
    Gender_id: yup.string().required(),
    parent_student_id: yup.string().required(),
    name: yup.string().required(),
    password: yup.string().required().min(8),
    address: yup.string().required(),
    class_room_id: yup.string().required(),
    section_id: yup.string().required(),
    grade_id: yup.string().required(),
});

const editStudent = (student) => {
    editing.value = true;
    form.value.resetForm();
    $('#StudentsFormModal').modal('show');
    formValues.value = {
        id: student.id,
        email: student.email,
        name: student.name,
        Gender_id: student.Gender_id,
        parent_student_id: student.parent_student_id,
        grade_id: student.grade_id,
        password: student.password,
        address: student.address,
        section_id: student.section_id,
        class_room_id: student.class_room_id,

    };
};
const updateStudent = (values, { setErrors }) => {
    axios.put('/api/students/'+ formValues.value.id, values)
        .then((response) => {
            const index = students.value.data.findIndex(student => student.id === response.data.id);
            students.value.data[index] = response.data;
            $('#StudentsFormModal').modal('hide');
            toastr.success('student updated successfully!');
        }).catch((error) => {
        setErrors(error.response.data.errors);
        console.log(error);
    });
}
const handleSubmit = (values, actions) => {
    // console.log(actions);
    if (editing.value) {
        updateStudent(values, actions);
    } else {
        createStudent(values, actions);
    }
}
//  حل مشكلة تحديث الجداول  تلقائي بسب العِلاقة
const getGenderName = (genderId) => {
    const gender = genders.value.find(gender => gender.id === genderId);
    return gender ? gender.Name : 'genderNmae';
}
const getParentStudentNmae = (ParentStudentId) => {
    const ParentStudent = ParentStudents.value.find(ParentStudent => ParentStudent.id === ParentStudentId);
    return ParentStudent ? ParentStudent.Name_Father : 'ParentStudentNmae';
}

const getgradesNmae = (gradeId) => {
    const grade = grades.value.find(grade => grade.id === gradeId);
    return grade ? grade.name : 'gradeNmae';
}
const getsectionsNmae = (sectionId) => {
    const section = sections.value.find(section => section.id === sectionId);
    return section ? section.name : 'sectionNmae';
}
const getclassRoomsNmae = (classRoomId) => {
    const classRoom = classRooms.value.find(classRoom => classRoom.id === classRoomId);
    return classRoom ? classRoom.name_class : 'classRoomNmae';
}
const deleteStudent = (id) => {
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
            axios.delete(`/api/students/${id}`)
                .then((response) => {
                    students.value.data = students.value.data.filter(student => student.id !== id);
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
    getStudents();
    getGender();
    getclassRooms();
    getsections();
    getParentStudent();
    getgrade();

});
</script>
<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Students</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Students</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">

                <div class="d-flex">
                    <button @click="addStudents" type="button" class="mb-2 btn btn-primary">
                        <i class="fa fa-plus-circle mr-1"></i>
                        Add New Students
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Gender Type</th>
                            <th scope="col">Grade Name </th>
                            <th scope="col">ClassRoom Name </th>
                            <th scope="col">Section Name </th>
                            <th scope="col">ParentStudent Name </th>
                            <th scope="col">Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(student, index) in students.data" :key="student.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ student.name }}</td>
                            <td>{{ getGenderName(student.Gender_id) }}</td>
                            <td>{{ getgradesNmae(student.grade_id) }}</td>
                            <td>{{ getclassRoomsNmae(student.class_room_id) }}</td>
                            <td>{{ getsectionsNmae(student.section_id) }}</td>
                            <td>{{ getParentStudentNmae(student.parent_student_id) }}</td>
                            <td>
                                <a  href="#" @click.prevent="editStudent(student)"><i class="fa fa-edit mr-1"></i></a>

                                <a  href="#" @click.prevent="deleteStudent(student.id)">
                                    <i class="fa fa-trash text-danger ml-1"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <Bootstrap4Pagination :data="students" @pagination-change-page="getStudents" />
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="StudentsFormModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span v-if="editing">Edit Student</span>
                        <span v-else>Add New Student</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <Form ref="form" @submit="handleSubmit" :validation-schema="editing ? editStudentSchema : createStudentSchema"
                      v-slot="{ errors }" :initial-values="formValues">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Student email </label>
                                    <Field name="email" type="email" class="form-control" :class="{ 'is-invalid': errors.email }"
                                           id="email"  placeholder="Enter full Student email" />
                                    <span class="invalid-feedback">{{ errors.email }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="password">Student password </label>
                                <Field name="password" type="password" class="form-control" :class="{ 'is-invalid': errors.password }"
                                       id="password"  placeholder="Enter full Student password" />
                                <span class="invalid-feedback">{{ errors.password }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Student Name </label>
                                    <Field name="name" type="text" class="form-control" :class="{ 'is-invalid': errors.name }"
                                           id="name"  placeholder="Enter full Student Name" />
                                    <span class="invalid-feedback">{{ errors.Name }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="address">Student Address </label>
                                <Field name="address" type="text" class="form-control" :class="{ 'is-invalid': errors.address }"
                                       id="address"  placeholder="Enter full Student Address" />
                                <span class="invalid-feedback">{{ errors.address }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                    <label for="parent_student_id">ParentStudent Name</label>
                                    <Field name="parent_student_id" as="select" class="form-control" :class="{ 'is-invalid': errors.parent_student_id }"
                                           id="parent_student_id">
                                        <option v-for="ParentStudent in ParentStudents" :value="ParentStudent.id" :key="ParentStudent.id">{{ParentStudent.Name_Father}}</option>
                                    </Field>
                                    <span class="invalid-feedback">{{ errors.parent_student_id }}</span>
                            </div>
                            <div class="col-md-6">
                                <label for="grade_id">grade Name</label>
                                <Field name="grade_id" as="select" class="form-control" :class="{ 'is-invalid': errors.grade_id }"
                                       id="grade_id">
                                    <option v-for="grade in grades" :value="grade.id" :key="grade.id">{{grade.name}}</option>
                                </Field>
                                <span class="invalid-feedback">{{ errors.grade_id }}</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="class_room">ClassRoom Name</label>
                                     <Field name="class_room_id" as="select" class="form-control" :class="{ 'is-invalid': errors.class_room_id }"
                                             id="class_room_id">
                                    <option v-for="classRoom in classRooms" :value="classRoom.id" :key="classRoom.id">{{classRoom.name_class}}</option>
                                </Field>
                                    <span class="invalid-feedback">{{ errors.class_room_id }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="section_id">Section Name</label>
                                <Field name="section_id" as="select" class="form-control" :class="{ 'is-invalid': errors.section_id }"
                                       id="section_id">
                                    <option v-for="section in sections" :value="section.id" :key="section.id">{{section.name}}</option>
                                </Field>
                                <span class="invalid-feedback">{{ errors.section_id }}</span>
                            </div>
                            <div class="col-md-4">
                                <label for="Gender_id">Gender</label>
                                <Field name="Gender_id" as="select" class="form-control" :class="{ 'is-invalid': errors.Gender_id }"
                                       id="Gender_id">
                                    <option v-for="gender in genders" :value="gender.id" :key="gender.id">{{gender.Name}}</option>
                                </Field>
                                <span class="invalid-feedback">{{ errors.Gender_id }}</span>
                            </div>

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
