<script setup>
import { ref, onMounted} from 'vue';
import { Form, Field } from 'vee-validate';
import Swal from 'sweetalert2';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';
import * as yup from 'yup';
import axios from 'axios';
import { useToastr } from '../../toastr.js';
const toastr = useToastr();
const grades = ref();
const gradeing = ref();
const class_rooms = ref();
const formValues = ref();
const form = ref(null);
const editing = ref(false);



const getSections = () => {
    axios.get('/api/grade_sections')
        .then((response) => {
            grades.value = response.data;
        })
};
const getGrade = () => {
    axios.get('/api/grade')
        .then((response) => {
            gradeing.value = response.data;
        })
};
const getClass_room = () => {
    axios.get('/api/classRoom')
        .then((response) => {
            class_rooms.value = response.data;
        })
};


const getClassRoomByName = (className) => {
    const classRoom = class_rooms.value.find(classRoom => classRoom.name_class === className);
    return classRoom ? classRoom.name_class : 'gradeName';
}





//Craeteting

const createSchema = yup.object({
    name: yup.string().required(),
    grade_id: yup.string().required(),
    class_room_id: yup.string().required(),
});

const create = (values, { resetForm, setErrors }) => {
    axios.post('/api/createSections', values)
        .then((response) => {
            // تحديث القائمة بعد الإضافة
            const gradeIndex = grades.value.findIndex(grade => grade.id === response.grade_id);
            if (gradeIndex !== -1) {
                grades.value[gradeIndex].sections.unshift(response);
            }
            $('#FormModal').modal('hide');
            resetForm();
            toastr.success('Sections created successfully!');
        })
        .catch((error) => {
            if (error.response.errors) {
                setErrors(error.response.errors);
            }
        })
};



const add = () => {
    editing.value = false;
    $('#FormModal').modal('show');
};





//editing

const editSchema = yup.object({
    name: yup.string().required(),
    grade_id: yup.string().required(),
    class_room_id: yup.string().required(),
});

const edit = (section) => {
    editing.value = true;
    form.value.resetForm();
    $('#FormModal').modal('show');
    formValues.value = {
        id: section.id,
        name: section.name,
        grade_id: section.grade_id,
        class_room_id: section.class_room_id,
    };
};
const update = (values, { setErrors }) => {
    axios.put('/api/sections/'+ formValues.value.id, values)
        .then((response) => {
            // تحديث القائمة بعد التعديل
            const gradeIndex = grades.value.findIndex(grade => grade.id === response.data.grade_id);
            if (gradeIndex !== -1) {
                const sectionIndex = grades.value[gradeIndex].sections.findIndex(section => section.id === response.data.id);
                if (sectionIndex !== -1) {
                    Vue.set(grades.value[gradeIndex].sections, sectionIndex, response.data);
                }
            }
            $('#FormModal').modal('hide');
            toastr.success('Sections updated successfully!');
        }).catch((error) => {
        setErrors(error.response.errors);
        console.log(error);
    });
};
const handleSubmit = (values, actions) => {
    // console.log(actions);
    if (editing.value) {
        update(values, actions);
    } else {
        create(values, actions);
    }
}

const deletes = (id) => {
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
    getSections();
    getGrade();
    getClass_room();
});
</script>

<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Sections</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Sections</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <div class="d-flex">
                    <button @click="add" type="button" class="mb-2 btn btn-primary">
                        <i class="fa fa-plus-circle mr-1"></i>
                        Add New Sections
                    </button>
                </div>
            </div>
        </div>
        <div class="card" v-for="grade in grades" :key="grade.id">
            <div class="card-header" data-card-widget="collapse" style="cursor: pointer">
                <h3 class="card-title">{{ grade.name }}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th style="width: 1%">#</th>
                        <th style="width: 20%">Sections Name</th>
                        <th style="width: 20%">ClassRoom Name</th>
                        <th style="width: 8%" class="text-center">Status</th>
                        <th style="width: 20%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(section, index) in grade.sections" :key="section.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ section.name }}</td>
                        <td>{{ getClassRoomByName(section.my_class.name_class) }}</td>

                        <td class="project-state">
                            <span class="badge badge-success">Success</span>
                        </td>
                        <td class="project-actions text-right">
                            <a   @click.prevent="edit(section)">
                                <i class="fa fa-edit text-info mr-1"></i>
                            </a>
                            <a  @click.prevent="deletes(classRoom.id)">
                                <i class="fa fa-trash text-danger ml-1"></i>
                            </a>
                        </td>
                    </tr>
<!--                    <tr v-if="grade.sections.length === 0">-->
<!--                        <td colspan="5">لا توجد أقسام</td>-->
<!--                    </tr>-->
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="modal fade" id="FormModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span v-if="editing">Edit Sections</span>
                        <span v-else>Add New Sections</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <Form ref="form" @submit="handleSubmit" :validation-schema="editing ? editSchema : createSchema"
                      v-slot="{ errors }" :initial-values="formValues">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Section Name </label>
                            <Field name="name" type="text" class="form-control" :class="{ 'is-invalid': errors.name }"
                                   id="name"  placeholder="Enter full ClassRoom Name" />
                            <span class="invalid-feedback">{{ errors.name }}</span>
                        </div>


                        <div class="form-group">
                            <label for="email">Grade Name</label>
                            <Field name="grade_id" as="select" class="form-control" :class="{ 'is-invalid': errors.grade_id }"
                                   id="grade_id">
                                <option v-for="grade in gradeing" :value="grade.id" :key="grade.id">{{grade.name}}</option>
                            </Field>
                            <span class="invalid-feedback">{{ errors.grade_id }}</span>

                        </div>
                        <div class="form-group">
                            <label for="email">classRoom Name</label>
                            <Field name="class_room_id" as="select" class="form-control" :class="{ 'is-invalid': errors.class_room_id }"
                                   id="class_room_id">
                                <option v-for="class_room in class_rooms" :value="class_room.id" :key="class_room.id">{{class_room.name_class}}</option>
                            </Field>
                            <span class="invalid-feedback">{{ errors.class_room_id }}</span>

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
