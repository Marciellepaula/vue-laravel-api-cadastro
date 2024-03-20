<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import axios from "redaxios";
import Card from '../components/Card.vue';

const result = ref([]);
const router = useRouter();



const cadastroLoad = () => {
  const token = localStorage.getItem("token");
  if (!token) {
    console.error("Token not found in localStorage");
    return router.push("/login");
  }
  axios
    .get("http://localhost/api/cadastro", {
      headers: {
        Authorization: `Bearer ${token}`, // Include the token in the Authorization header
      },
    })
    .then(({ data }) => {
      result.value = data[0];
      console.log(data[0]);
    })
    .catch((error) => {
      console.error("Error loading cadastro:", error);
    });
};



onMounted(() => {
  console.log("mounted() called....");
  cadastroLoad();
});

</script>


<template>
  <div class="max-w-2xl mx-auto">
    <div class="flex flex-wrap justify-center items-start">
        <Card v-for="(item, index) in result" :key="index" :cadastro="item"/>
    </div>
   </div>
</template>


