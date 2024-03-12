<script setup>
  import { ref } from "vue";
  import axios from "redaxios";
  import { useRouter } from "vue-router";

  const router = useRouter();
  const cadastro = ref({
    name: "",
    photo: null,
    email: "",
    cpf: "",
  });

  const upload = ref({
    path: "",
  });

  const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = () => {
        cadastro.value.photo = file;
      };
      reader.readAsDataURL(file);
    }
  }
  ;


  const handleFileChange = (event) => {
    // Handle file change event
    const files = event.target.files;
    for (let i = 0; i < files.length; i++) {
      upload.value.path.push(files[i]);
    }
  };


  const saveData = (event) => {
    const token = localStorage.getItem("token");
   if (!token) {
    console.error("Token not found in localStorage");
    return router.push("/login");
   }
    // Create a new FormData object
    let formData = new FormData();
    // Append form data
    formData.append('name', cadastro.value.name);
    formData.append('email', cadastro.value.email);
    formData.append('photo', cadastro.value.photo); 
    formData.append('cpf', cadastro.value.cpf);
    // Assuming you have photo data in this.cadastro.photo


    if (cadastro.value.uploads && cadastro.value.uploads.length > 0) {
    cadastro.value.uploads.forEach(file => {
      formData.append('uploads[]', file);
    });
  };

    try {
      // Send a POST request with axios
      let response = axios.post('http://localhost/api/cadastro', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      });
    } catch (error) {
      console.error('Error saving data:', error);
    }
  };

  
</script>

<template>
  <div class="max-w-md mx-auto">
    <h1 class="text-3xl font-bold mb-4">Cadastro de Pessoas</h1>
    <form @submit.prevent="saveData" enctype="multipart/form-data">
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input v-model="cadastro.name" id="name" name="name" type="text" required
        class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="janesmith">
      </div>
      <div class="mb-4">
        <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
        <input id="photo" name="photo" type="file" accept="image/png, image/jpeg, image/jpj" @change="handleImageChange" required
               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
      </div>
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input v-model="cadastro.email" id="email" name="email" type="email" required
        class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="maef06@rf.com">
      </div>
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">CPF</label>
        <input v-model="cadastro.cpf" id="cpf" name="cpf" type="cpf" required
        class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="000.000-00">
      </div>
      <div class="mb-4">
        <label for="path" class="block text-sm font-medium text-gray-700">Uploads</label>
        <input id="path" name="path" type="file" accept="file/pdf" @change="handleFileChange" required multiple
       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
      </div>
      <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
        Save
      </button>
    </form>
  </div>
</template>
