<script setup>
  import { ref } from "vue";
  import axios from "redaxios";
  import { useRouter } from "vue-router";

  const router = useRouter();
  const cadastro = ref({
    id: "",
    nome: "",
    email: "",
    cpf: "",
    photo: null,
  });

  const upload = ref({
    path: [],
  });

  const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
      cadastro.value.photo = file;
    }
  };

  const handleFileChange = (event) => {
    upload.value.path = Array.from(event.target.files);
  };

  const saveData =  () => {
  const token = localStorage.getItem("token");
  if (!token) {
    console.error("Token not found in localStorage");
    return router.push("/login");
  }
  const formData = new FormData();

  formData.append("nome", cadastro.value.nome);
  formData.append("email", cadastro.value.email);
  formData.append("cpf", cadastro.value.cpf);
  formData.append("photo", cadastro.value.photo);

  if (upload.value.path.length > 0) {
    upload.value.path.forEach((file) => {
      formData.append("path[]", file);
    });
  }

  try {
    const response =  axios.post("http://localhost/api/cadastro", formData, {
      headers: {
        Authorization: `Bearer ${token}`,
        "Accept": "application/json"
      }
    });
    router.push('/');
  } catch (error) {
    console.error("Error saving data:", error);
    // Display error message to the user if needed
  }
};

  
</script>

<template>
  <div class="max-w-md mx-auto">
    <h1 class="text-3xl font-bold mb-4">Cadastro de Pessoas</h1>
    <form @submit.prevent="saveData" enctype="multipart/form-data">
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input v-model="cadastro.nome" id="nome" name="nome" type="text" required class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="janesmith">
      </div>
      <div class="mb-4">
        <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
        <input id="photo" name="photo" type="file" accept="image/png, image/jpeg, image/jpg" @change="handleImageChange" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        <span v-if="cadastro.photo">Selected: {{ cadastro.photo.name }}</span>
      </div>
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input v-model="cadastro.email" id="email" name="email" type="email" required class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="maef06@rf.com">
      </div>
      <div class="mb-4">
        <label for="cpf" class="block text-sm font-medium text-gray-700">CPF</label>
        <input v-model="cadastro.cpf" id="cpf" name="cpf" type="text" required class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="000.000-00">
      </div>
      <div class="mb-4">
        <label for="path" class="block text-sm font-medium text-gray-700">Uploads</label>
        <input id="path" name="path" type="file" accept="application/pdf" @change="handleFileChange" required multiple class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        <span v-if="upload.path.length > 0">Selected: {{ upload.path.length }} file(s)</span>
      </div>
      <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
        Save
      </button>
    </form>
  </div>
</template>
