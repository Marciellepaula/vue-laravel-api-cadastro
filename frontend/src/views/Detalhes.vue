<script setup>
import { ref, onMounted, defineProps } from 'vue';
import { useRouter } from 'vue-router';
import axios from "redaxios";// Import axios for HTTP requests

// Define a reactive variable to store the cadastro details

const cadastro = ref({});

// Get the router instance
const router = useRouter();

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

// Fetch the cadastro details when the component is mounted

const editCadastro = (selectedCadastro) => {
  try {
    // Copying values to avoid reactivity issues
    cadastro.value = { ...selectedCadastro };
    // Navigate to the edit student page
    router.push({ name: "CadastroUpdate", params: { id: selectedCadastro.id } });
  } catch (error) {
    console.error("Error navigating to edit course page:", error);
  }
};


const cadastroLoad = () => {
  const token = localStorage.getItem("token");
  if (!token) {
    console.error("Token not found in localStorage");
    return router.push("/login");
  }
  // Get the id parameter from the route
  const id = router.currentRoute.value.params.id;
  axios
    .get(`http://localhost/api/cadastro/${id}`, {
      headers: {
        Authorization: `Bearer ${token}`, // Include the token in the Authorization header
      },
    })
    .then(({ data }) => {
      cadastro.value = data.data;
      console.log(cadastro.value, 'zsgv');
    })
    .catch(error => {
      console.error('Error fetching cadastro details:', error);
    });
};
 


onMounted(() => {
  console.log("mounted() called....");
  cadastroLoad();
});

</script>



<template>
  <div class="flex justify-center items-center h-full">
    <div class="max-w-xl p-6 bg-white border rounded-lg">
      <div class="font-bold text-lg mb-2">Name</div>
      <div class="text-lg">{{ cadastro.nome }}</div>
      
      <div class="font-bold text-lg mt-4">Email</div>
      <div class="text-lg">{{ cadastro.email }}</div>
      
      <div class="font-bold text-lg mt-4">Files</div>
      <ul class="list-disc ml-6 mt-2">
    <template v-if="cadastro.upload">
    <div v-for="(upload, uploadIndex) in cadastro.upload" :key="uploadIndex" class="mb-2">
    <div class="flex">
      <a :href="upload.filepath" target="_blank" class="text-blue-500 hover:none">{{ upload.filename }}<i class="far fa-file-pdf fa-3x"></i></a>
    </div>
  </div>
</template>
<template v-else>
  <li class="text-gray-500">No files uploaded</li>
</template>
</ul>
      <div class="font-bold text-lg mt-4">Photo</div>
      <img :src="cadastro.image" alt="User Photo" class="w-32 h-32 object-cover rounded-full mt-2">
      <button @click = "editCadastro(cadastro)" class="block w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded mt-6 focus:outline-none focus:shadow-outline">
        Editar
      </button>
      <button @click="sendcadastro(cadastro.id)" class="block w-full bg-blue-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded mt-6 focus:outline-none focus:shadow-outline">
        Send Email for Login
      </button>
    </div>
  </div>
</template>


