<script setup>
import { FormWizard, TabContent } from "vue3-form-wizard";
import "vue3-form-wizard/dist/style.css";
import { ref, onMounted} from 'vue';
import { Form, Field } from 'vee-validate';
import Swal from 'sweetalert2';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';
import * as yup from 'yup';
import axios from 'axios';
import { useToastr } from '../../toastr.js';
import flatpickr from "flatpickr";

const toastr = useToastr();
const formValues = ref();
const form = ref(null);

const createAppointment = (values, actions) => {
    alert("Yay. Done!");
    // axios.post('/api/appointments/create', form)
    //     .then((response) => {
    //         router.push('/admin/appointments');
    //         toastr.success('Appointment created successfully!');
    //     })
    //     .catch((error) => {
    //         actions.setErrors(error.response.data.errors);
    //     })
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
                            <FormWizard @on-complete="createAppointment" color="#007bff">
                                <TabContent title="Father details" icon="fa fa-user ">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nameFather">Name_Father</label>
                                                <input type="text" class="form-control" id="nameFather">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="jobFather">Job_Father</label>
                                                <input type="text" class="form-control" id="jobFather">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nationalityFather">Nationality_Father</label>
                                                <select class="custom-select" id="nationalityFather">
                                                    <option selected>اختر الجنسية</option>
                                                    <option value="فلسطين">فلسطين</option>
                                                </select>                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <div class="col">
                                                <label for="Phone_Father">Phone_Father</label>
                                                <input type="text" class="form-control">
                                            </div>
                                            </div>
                                        </div> <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col">
                                                <label for="National_ID_Father">National_ID_Father</label>
                                                <input type="text"  class="form-control">
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="addressFather">Address_Father</label>
                                        <textarea class="form-control" id="addressFather" rows="4"></textarea>
                                    </div>
                                </TabContent>
                                <TabContent title="Mother details" icon="fa fa-gear">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="title">Password</label>
                                                <input type="password" class="form-control" id="title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nameMother">Name_Mother</label>
                                                <input type="text" class="form-control" id="nameMother">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="jobMother">Job_Mother</label>
                                                <input type="text" class="form-control" id="jobMother">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nationalityMother">Nationality_Mother</label>
                                                <select class="custom-select" id="nationalityMother">
                                                    <option selected>اختر الجنسية</option>
                                                    <option value="فلسطين">فلسطين</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col">
                                                    <label for="Phone_Mother">Phone_Mother</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div> <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col">
                                                <label for="National_ID_Mother">National_ID_Mother</label>
                                                <input type="text"  class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="addressFather">Address_Mother</label>
                                        <textarea class="form-control" id="addressFather" rows="4"></textarea>
                                    </div>
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
