<script setup>
import { ref, onMounted,} from 'vue';
import { formatDate } from '../../helper.js';


const appointments = ref([]);

const getAppointments = () => {
    axios.get(`/api/appointments`)
        .then((response) => {
            appointments.value = response.data;
        })
}

onMounted(() => {
    getAppointments();
});

</script>


<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Appointments</li>
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
                            <router-link to="#">
                                <button class="btn btn-primary"><i class="fa fa-plus-circle mr-1"></i> Add New
                                    Appointment</button>
                            </router-link>
                        </div>
                        <div class="btn-group">
                            <button  type="button" class="btn btn-secondary" >
                                <span class="mr-1">All</span>
                                <span class="badge badge-pill badge-info">10</span>
                            </button>

                            <button  type="button"
                                    class="btn btn-default">
                                <span class="mr-1">Scheduled</span>
                                <span class="badge badge-pill badge-primary">0</span>
                            </button>

                            <button  type="button"
                                     class="btn btn-default">
                                <span class="mr-1">Closed</span>
                                <span class="badge badge-pill badge-success">1</span>
                            </button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Client Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Options</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(appointment, index) in appointments.data" :key="appointment.id">
                                    <td>{{index+1}}</td>
                                    <td>{{appointment.client.first_name}} {{appointment.client.last_name}}</td>
                                    <td>{{formatDate(appointment.start_time)}}</td>
                                    <td>{{formatDate(appointment.end_time)}}</td>
                                    <td>
                                        <span class="badge" :class="'badge-'+appointment.status.color">
                                            {{appointment.status.name}}
                                                </span>
                                    </td>
                                    <td>
                                        <router-link :to="'#'">
                                            <i class="fa fa-edit mr-2"></i>
                                        </router-link>

                                        <a href="#">
                                            <i class="fa fa-trash text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div></template>
