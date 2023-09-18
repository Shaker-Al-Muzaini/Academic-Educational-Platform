<script setup>
import { FormWizard, TabContent } from "vue3-form-wizard";
import "vue3-form-wizard/dist/style.css";

function onComplete() {
    alert("Yay. Done!");
}
</script>
<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Parent</h1>
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
                            <FormWizard @on-complete="onComplete" color="#007bff">
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
                                                <label for="title">Password</label>
                                                <input type="password" class="form-control" id="Password">
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
                                            <button class="btn btn-danger
                                            btn-me nextBtn btn-lg m-1" type="button">NO</button>

                                            <button class="btn btn-success btn-lg btn-lg m-1"
                                                    type="button">Yes</button>
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
