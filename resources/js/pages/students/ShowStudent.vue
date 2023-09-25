<script setup>
import axios from "axios";
import { ref, onMounted} from 'vue';
const showStudent = ref();


const  ShowStudent=(id)=>{
    axios.get(`/api/showStudent/${id}`)
        .then((response) => {
            showStudent.value = response.data;
            console.log(showStudent);
        })

}
onMounted(() => {
    ShowStudent($route.params.id);
});
</script>


<template>
    <h1 class="bg-center bg-info text-bold text-white m-4">{{$route.params.id}}</h1>
    <h1 class="bg-center bg-info text-bold text-white m-4">{{$route.params.id}}</h1>
    <h1 class="bg-center bg-info text-bold text-white m-4">{{$route.params.id}}</h1>
</template>

