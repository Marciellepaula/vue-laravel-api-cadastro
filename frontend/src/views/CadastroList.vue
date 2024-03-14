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
  <div class="flex justify-center items-center h-full">
    <ul class="w-full max-w-xl">
      <li v-for="(item, index) in result" :key="index" class="border border-gray-200 p-4 mb-4">
        <div class="font-bold text-lg mb-2">Name</div>
        <div class="text-lg">{{ item.nome }}</div>
        <div class="font-bold text-lg mt-2">Email</div>
        <div class="text-lg">{{ item.email }}</div>
        <div class="font-bold text-lg mt-2">Files</div>
        <ul class="list-disc ml-6">
          <li v-for="(upload, uploadIndex) in item.upload" :key="uploadIndex">
            <a :href="upload.path" target="_blank" class="text-blue-500">View File</a>
          </li>
        </ul>
        <div class="font-bold text-lg mt-2">Photo</div>
        <img :src="item.image" alt="User Photo" class="w-32 h-32 object-cover rounded-full">
        <button @click="sendcadastro(item.id)" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded mt-4">Send Email for Login</button>
      </li>
    </ul>
  </div>
</template>



