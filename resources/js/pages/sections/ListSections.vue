<script setup>
import { ref, onMounted} from 'vue';
import { Form, Field } from 'vee-validate';
import Swal from 'sweetalert2';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';
import * as yup from 'yup';
import axios from 'axios';
import { useToastr } from '../../toastr.js';
const toastr = useToastr();
const grades = ref({'data': []});
const gradeing = ref();
const class_rooms = ref();
const formValues = ref();
const form = ref(null);
const editing = ref(false);
const Teachers = ref();

const getSections = (page = 1) => {
    axios.get(`/api/grade_sections/?page=${page}`)
        .then((response) => {
            grades.value = response.data[0];
        })
};

const getGrade = () => {
    axios.get('/api/grade')
        .then((response) => {
            gradeing.value = response.data;
        })
};

const getTeacher = () => {
    axios.get('/api/Teacher')
        .then((response) => {
            Teachers.value = response.data;
        })
};
const getTeacherName = (TeacherId) => {
    const Teacher = Teachers.value.find(Teacher => Teacher.id === TeacherId);
    return Teacher ? Teacher.Name : 'TeacherNmae';
}

const getClass_room = () => {
    axios.get('/api/classRoom')
        .then((response) => {
            class_rooms.value = response.data;
        })
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

const add = () => {
    editing.value = false;
    $('#FormModal').modal('show');
};

// Editing
const editSchema = yup.object({
    name: yup.string().required(),
    grade_id: yup.string().required(),
    class_room_id: yup.string().required(),
    teacher_id: yup.string().required(),
});

const edit = (section ) => {
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
const moveSectionToAnotherGrade = (sectionId, sourceGradeId, destinationGradeId) => {
    // البحث عن المرحلة المصدر
    const sourceGrade = grades.value.data.find(grade => grade.id === sourceGradeId);

    // البحث عن القسم المطلوب في المرحلة المصدر
    const sectionIndex = sourceGrade.sections.findIndex(section => section.id === sectionId);

    if (sectionIndex !== -1) {
        // استخراج القسم من المرحلة المصدر
        const movedSection = sourceGrade.sections.splice(sectionIndex, 1)[0];

        // البحث عن المرحلة الهدف
        const destinationGrade = grades.value.data.find(grade => grade.id === destinationGradeId);

        if (destinationGrade) {
            // إضافة القسم إلى المرحلة الهدف
            destinationGrade.sections.push(movedSection);
        }
    }
};

const update = (values, { setErrors }) => {
    const destinationGrade = grades.value.data.find(grade => grade.id === values.grade_id);

    axios.put('/api/grade_sections/' + formValues.value.id, values)
        .then((response) => {
            const updatedSection = response.data;
            const sourceGradeId = formValues.value.grade_id;
            const destinationGradeId = values.grade_id;

            moveSectionToAnotherGrade(updatedSection.id, sourceGradeId, destinationGradeId);

            updateGradeName(destinationGradeId, destinationGrade.name);

            updateSectionName(updatedSection.id, updatedSection.name);

            $('#FormModal').modal('hide');
            toastr.success('Sections updated successfully!');
        }).catch((error) => {
        if (error.response && error.response.data && error.response.data.errors) {
            setErrors(error.response.data.errors);
        } else {
            console.error(error);
        }
    });
};




const updateGrade = (gradeId, newName) => {
    axios.put(`/api/grade/${gradeId}`, { name: newName })
        .then(() => {
            // تحديث اسم المرحلة في الواجهة المستخدم بعد نجاح الطلب
            updateGradeName(gradeId, newName);
        })
        .catch((error) => {
            console.error(error);
        });
};

const updateGradeName = (gradeId, newName) => {
    for (const grade of grades.value.data) {
        if (grade.id === gradeId) {
            grade.name = newName;
            return;
        }
    }
};


const updateSectionName = (sectionId, newName) => {
    for (const grade of grades.value.data) {
        const section = grade.sections.find(section => section.id === sectionId);
        if (section) {
            section.name = newName;
            return;
        }
    }
};






const handleSubmit = (values, actions) => {
    if (editing.value) {
        update(values, actions);
    } else {
        create(values, actions);
    }
};

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
            axios.delete(`/api/grade_sections/${id}`)
                .then(() => {
                    // حذف العنصر من القائمة بعد الحذف
                    const gradeIndex = grades.value.data.findIndex(grade => grade.sections.some(section => section.id === id));
                    if (gradeIndex !== -1) {
                        const sectionIndex = grades.value.data[gradeIndex].sections.findIndex(section => section.id === id);
                        if (sectionIndex !== -1) {
                            grades.value.data[gradeIndex].sections.splice(sectionIndex, 1);
                        }
                    }
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    );
                })
                .catch((error) => {
                    console.error(error);
                });
        }
    });
};

const colors = [
    'bg-primary ',
    'bg-success ',
    'bg-danger ',
    'bg-warning',
    'bg-info ',
];

const getRandomColor = () => {
    if (colors.length === 0) {
        colors.push(
            'bg-primary ',
            'bg-success ',
            'bg-danger ',
            'bg-warning',
            'bg-info ',
        );
    }
    // اختيار لون عشوائي وإزالته من القائمة
    const randomIndex = Math.floor(Math.random() * colors.length);
    return colors.splice(randomIndex, 1)[0];
};

onMounted(() => {
    getSections();
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
        <div class="card" v-for="(grade, index) in grades.data" :key="grade.id">
            <div :class="getRandomColor() + ' card-header'" data-card-widget="collapse" style="cursor: pointer">
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
                        <td>{{ section.my_class && section.my_class.name_class ? section.my_class.name_class : 'قيد التحميل' }}</td>
                        <td v-if="section && section.id" class="project-state">
                            <span class="badge badge-success">Success</span>
                        </td>
                        <td class="project-actions text-right">
                            <a @click.prevent="edit(section)">
                                <i class="fa fa-edit text-info mr-1"></i>
                            </a>
                            <a @click.prevent="deletes(section.id)">
                                <i class="fa fa-trash text-danger ml-1"></i>
                            </a>
                        </td>
                    </tr>

                    </tbody>
                </table>
                <Bootstrap4Pagination :data="grades" @pagination-change-page="getSections" />

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
                        <div class="form-group">
                            <label for="teacher_id">Teacher Name</label>
                            <Field  name="teacher_id" as="select" class="form-control" :class="{ 'is-invalid': errors.teacher_id }"
                                   id="teacher_id">
                                <option v-for="Teacher in Teachers" :value="Teacher.id" :key="Teacher.id">{{Teacher.name}}</option>
                            </Field>
                            <span class="invalid-feedback">{{ errors.teacher_id }}</span>
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
