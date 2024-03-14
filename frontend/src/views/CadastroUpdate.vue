<template>
    <div>
      <h1>Edit Course</h1>
      <form @submit.prevent="updatecadastro" class="mt-3" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="name" class="form-label">Name:</label>
          <input v-model="cadastro.nome" class="form-control" required />
        </div>
        <div class="mb-3">
          <label for="name" class="form-label">Email:</label>
          <input v-model="cadastro.email" class="form-control" required />
        </div>
        <div class="mb-3">
          <label for="name" class="form-label">Cpf:</label>
          <input v-model="cadastro.cpf" class="form-control" required />
        </div>
        <div class="mb-3">
          <label for="photo" class="form-label">Photo:</label>
          <input type="file" name="photo" :class="{ 'is-invalid': cadastro.errors.has('photo') }" class="form-control"
            @change="handleImageChange" />
          <has-error :cadastro="cadastro" field="image" />
          <img :key="cadastro.id" :src="cadastro.photo" style="width: 200px; height: 200px; object-fit: cover"
            class="img-thumbnail" />
        </div>
        <div class="mb-3">
          <label for="photo" class="form-label">File:</label>
          <input type="file" name="photo" :class="{ 'is-invalid': cadastro.errors.has('path') }" class="form-control"
            @change="handleFileChange" />
          <has-error :cadastro="cadastro" field="image" />
          <a :key="cadastro.id" :src="cadastro.path" style="width: 200px; height: 200px; object-fit: cover"
            class="img-thumbnail" />
        </div>
        <button type="submit" class="btn btn-success">Update</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref, defineProps } from "vue";
  import axios from "redaxios";
  import { useRouter } from "vue-router";
  const router = useRouter();
  const props = defineProps(["id"]);
  
  const cadastro = ref({
    nome: "",
    email: "",
    errors: new Map(), 
    cpf: "",
    photo: null,
  });

  const upload = ref({
    path: [],
  });
  
  const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = () => {
        cadastro.value.photo = reader.result;
      };
      reader.readAsDataURL(file);
    }
  };

  const handleFileChange = (event) => {
    upload.value.path = Array.from(event.target.files);
  };

  const updatecadastro = () => {
    const formData = new FormData();
    formData.append("name", cadastro.value.name);
    formData.append("photo", cadastro.value.photo);
    formData.append("name", cadastro.value.name);
    formData.append("photo", cadastro.value.photo);

    if (upload.value.path.length > 0) {
    upload.value.path.forEach((file) => {
      formData.append("path[]", file);
    });
  }
    const editUrl = `http://localhost/api/cadastro/${props.id}`;
    axios
      .put(editUrl, formData, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`, // Include the token in the Authorization header
          "Content-Type": "multipart/form-data", // Ensure proper content type for FormData
        },
      })
      .then((response) => {
        alert(" updated successfully!");
      })
      .catch((error) => {
        console.error("Error updating cadastro:", error);
        alert("Failed to update cadastro. Please try again.");
      });
  };
  
  const fetchCourse = async () => {
    try {
      const response = await axios.get(`http://localhost/api/cadastro/${props.id}`);
      const data = response.data.data; 
  
    course.value.id = data.id; 
    course.value.name = data.name; 
    course.value.photo = data.photo;
    course.value.cpf = data.name; 
    course.value.email = data.photo;
    course.value.email = data.photo;
    } catch (error) {
      console.error("Error fetching course:", error);
      alert("Failed to fetch course data. Please try again.");
    }
  };
  
  fetchCourse();
  
  // Expose reactive variables to the template
  defineExpose({ cadastro, handleImageChange });
  </script>
  