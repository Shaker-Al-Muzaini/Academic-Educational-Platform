<script setup>
import { FormWizard, TabContent } from "vue3-form-wizard";
import "vue3-form-wizard/dist/style.css";
import { ref, onMounted } from 'vue';
import { Form, Field } from 'vee-validate';
import axios from 'axios';
import * as yup from 'yup';

import { useToastr } from '../../toastr.js';

const toastr = useToastr();
const createSchema = yup.object({
    email_Father: yup.string().required(),
    password_Father: yup.string().required(),
    Name_Father: yup.string().required(),
    National_ID_Father: yup.string().required(),
    Phone_Father: yup.string().required(),
    Job_Father: yup.string().required(),
    Nationality_Father_id: yup.string().required(),
    Address_Father: yup.string().required(),
    password_mother: yup.string().required(),
    email_mother: yup.string().required(),
    Name_Mother: yup.string().required(),
    National_ID_Mother: yup.string().required(),
    Phone_Mother: yup.string().required(),
    Job_Mother: yup.string().required(),
    Nationality_Mother_id: yup.string().required(),
    Address_Mother: yup.string().required(),
});
const form = ref({
    email_Father: '',
    password_Father: '',
    Name_Father: '',
    National_ID_Father: '',
    Phone_Father: '',
    Job_Father: '',
    Nationality_Father_id: '',
    Address_Father: '',
    password_mother: '',
    email_mother: '',
    Name_Mother: '',
    National_ID_Mother: '',
    Phone_Mother: '',
    Job_Mother: '',
    Nationality_Mother_id: '',
    Address_Mother: '',
});

const createAppointment = (values, actions) => {
    axios.post('/api/createParentStudent', form.value)
        .then((response) => {
            toastr.success('ParentStudent created successfully!');
            window.location.reload();
        })
        .catch((error) => {
            actions.setErrors(error.response.errors);
        })
};

onMounted(() => {

});

</script>
<template>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <FormWizard @on-complete="createAppointment"   color="#007bff">
                                <TabContent title="Father details" icon="fa fa-user ">
                                    <Form @submit="createAppointment"  :validation-schema="createSchema" v-slot:default="{ errors }">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email_Father">Email</label>
                                                    <Field name="email_Father" type="email" class="form-control" :class="{ 'is-invalid': errors.email_Father }"
                                                           id="email_Father" aria-describedby="nameHelp" placeholder="Enter full email Father" />
                                                    <span class="invalid-feedback">{{ errors.email_Father }}</span>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password_Father">Password</label>
                                                    <Field name="password_Father" type="password" class="form-control" :class="{ 'is-invalid': errors.password_Father }"
                                                           id="password_Father" aria-describedby="passwordHelp" placeholder="Enter full password Father" />
                                                    <span class="invalid-feedback">{{ errors.password_Father }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="nameFather">Name_Father</label>
                                                    <Field name="nameFather" type="text" class="form-control" :class="{ 'is-invalid': errors.nameFather }"
                                                           id="nameFather" aria-describedby="nameFatherHelp" placeholder="Enter full nameFather" />
                                                    <span class="invalid-feedback">{{ errors.Name_Father }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="jobFather">Job_Father</label>
                                                    <Field name="jobFather" type="text" class="form-control" :class="{ 'is-invalid': errors.jobFather }"
                                                           id="jobFather" aria-describedby="jobFatherHelp" placeholder="Enter job nameFather" />
                                                    <span class="invalid-feedback">{{ errors.Job_Father }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="nationalityFather">Nationality_Father</label>
                                                    <Field name="Nationality_Father_id" as="select" class="form-control" :class="{ 'is-invalid': errors.Nationality_Father_id }"
                                                           id="Nationality_Father_id">
                                                        <option selected disabled>اختر الجنسية</option>
                                                        <option value="1">فلسطين</option>
                                                    </Field>
                                                    <span class="invalid-feedback">{{ errors.Nationality_Father_id }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Phone_Father">Phone_Father</label>
                                                    <Field name="Phone_Father" type="text" class="form-control" :class="{ 'is-invalid': errors.Phone_Father }"
                                                           id="Phone_Father" aria-describedby="Phone_FatherHelp" placeholder="Enter full Phone_Father" />
                                                    <span class="invalid-feedback">{{ errors.Phone_Father }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="National_ID_Father">National_ID_Father</label>
                                                    <Field name="National_ID_Father" type="text" class="form-control" :class="{ 'is-invalid': errors.National_ID_Father }"
                                                           id="National_ID_Father" aria-describedby="National_ID_FatherHelp" placeholder="Enter full National_ID_Father" />
                                                    <span class="invalid-feedback">{{ errors.National_ID_Father }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="addressFather">Address_Father</label>
                                            <Field as="textarea" name="Address_Father"  class="form-control"
                                                   :class="{ 'is-invalid': errors.Address_Father }" id="Address_Father" placeholder="Enter Address_Father"/>
                                            <span class="invalid-feedback">{{ errors.Address_Father }}</span>
                                        </div>
                                    </Form>
                                </TabContent>
                                <TabContent title="Mother details" icon="fa fa-gear">
                                    <Form @submit="createAppointment" v-slot:default="{ errors }">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email_mother">Email</label>
                                                    <input id="email_mother" type="email" v-model="form.email_mother" class="form-control" :class="{ 'is-invalid': errors.email_mother }" placeholder="Enter email Mother">
                                                    <span class="invalid-feedback">{{ errors.email_mother }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password_mother">Password</label>
                                                    <input id="password_mother" type="password" v-model="form.password_mother" class="form-control" :class="{ 'is-invalid': errors.password_mother }">
                                                    <span class="invalid-feedback">{{ errors.password_mother }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="nameMother">Name_Mother</label>
                                                    <input id="nameMother" type="text" v-model="form.Name_Mother" class="form-control" :class="{ 'is-invalid': errors.Name_Mother }">
                                                    <span class="invalid-feedback">{{ errors.Name_Mother }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="jobMother">Job_Mother</label>
                                                    <input id="jobMother" type="text" v-model="form.Job_Mother" class="form-control" :class="{ 'is-invalid': errors.Job_Mother }">
                                                    <span class="invalid-feedback">{{ errors.Job_Mother }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="nationalityMother">Nationality_Mother</label>
                                                    <select id="nationalityMother" v-model="form.Nationality_Mother_id" class="custom-select" :class="{ 'is-invalid': errors.Nationality_Mother_id }">
                                                        <option selected disabled>اختر الجنسية</option>
                                                        <option value="2">فلسطين</option>
                                                    </select>
                                                    <span class="invalid-feedback">{{ errors.Nationality_Mother_id }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Phone_Mother">Phone_Mother</label>
                                                    <input id="Phone_Mother" type="text" v-model="form.Phone_Mother" class="form-control" :class="{ 'is-invalid': errors.Phone_Mother }">
                                                    <span class="invalid-feedback">{{ errors.Phone_Mother }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="National_ID_Mother">National_ID_Mother</label>
                                                    <input id="National_ID_Mother" type="text" v-model="form.National_ID_Mother" class="form-control" :class="{ 'is-invalid': errors.National_ID_Mother }">
                                                    <span class="invalid-feedback">{{ errors.National_ID_Mother }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="addressMother">Address_Mother</label>
                                            <textarea id="addressMother" v-model="form.Address_Mother" class="form-control" :class="{ 'is-invalid': errors.Address_Mother }" rows="4"></textarea>
                                            <span class="invalid-feedback">{{ errors.Address_Mother }}</span>
                                        </div>
                                    </Form>
                                </TabContent>
                                <TabContent title="Ending" icon="fa fa-city">
                                    <div class="col-xs-12 text-center">
                                        <div class="col-md-12">
                                            <h3 style="font-family:'Cairo', sans-serif;">هل انت متاكد من حفظ البيانات ؟</h3><br>
                                        </div>
                                    </div>
                                </TabContent>
                            </FormWizard>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
@import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css");
</style>
