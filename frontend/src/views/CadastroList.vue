<script setup>
import { ref, onMounted, defineProps } from "vue";
import { useRouter } from "vue-router";
import axios from "redaxios";


const { cadastro: cadastroProp } = defineProps(["cadastro"]); 
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

const sendcadastro = (cadastroId) => {
  axios
    .get(`http://localhost/api/sendemail/${cadastroId}`)
    .then((response) => {
       console.log('Email sent successfully:', response.data);
    })
    .catch((error) => {
      console.error("Error sending email:", error);
    });
};



</script>

<template>
  <div>
    <ul>
      <li v-for="(item, index) in result" :key="index" class="border border-gray-200 p-4 mb-2">
        <div class="font-bold mb-2">Nome</div>
        <div>{{ item.nome }}</div>
        <div class="font-bold mb-2">Email</div>
        <div>{{ item.email }}</div>
        <div class="font-bold mb-2">File</div>
        <ul>
        <li v-for="(upload, uploadIndex) in item.upload" :key="uploadIndex">
            <a :href="upload.path" target="_blank" class="text-blue-500">ver file</a>
        </li>
        </ul>
        <div class="font-bold mb-2">Photo</div>
        <img :src="item.image" alt="Cadastro foto" class="w-24 h-24 object-cover rounded-full">
        <button @click="sendcadastro(item.id)" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">Enviar email para Fazer Login</button>
      </li>
    </ul>
  </div>
</template>


