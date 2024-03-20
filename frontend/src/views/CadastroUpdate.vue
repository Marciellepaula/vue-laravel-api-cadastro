<template>
  <div>
    <div class="flex justify-center items-center h-full">
      <div class="max-w-xl p-6 bg-white border rounded-lg">
        <h1>Edit</h1>
        
        <form @submit.prevent="updatecadastro" class="mt-3" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input v-model="cadastro.nome" required class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="janesmith">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input v-model="cadastro.email" required class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="janesmith@example.com">
          </div>
          <div class="mb-3">
            <label for="cpf" class="form-label">CPF:</label>
            <input v-model="cadastro.cpf" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="photo" class="form-label">Photo:</label>
            <input type="file" name="photo" @change="handleImageChange" class="appearance-none border border-gray-300 rounded-lg p-2 focus:outline-none focus:border-blue-500">
            <img v-if="cadastro.photo" :src="cadastro.photo" class="h-40 w-40 rounded-md" />
          </div>
          <label class="form-label">File:</label><br>
          <div class="mb-3" v-for="(upload, index) in uploads" :key="index">
            <input type="file" :name="'file-' + index" @change="handleFileChange($event, index)" />
            <a v-if="upload.filepath" :href="upload.filepath" target="_blank" class="text-blue-500 hover:none">
              <i class="far fa-file-pdf fa-3x"></i>
            </a>
          </div>
          <button type="submit" class="btn btn-success">Update</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
  import { ref, defineProps, defineExpose, onMounted } from "vue";
  import axios from "redaxios";
  import { useRouter } from "vue-router";

  const router = useRouter();
  const props = defineProps(["id"]);
  const cadastro = ref({
    id: "",
    nome: "",
    email: "",
    errors: new Map(), 
    cpf: "",
    image: null,
  });
  const uploads = ref([]);

  const fetchcadastro = async () => {
    const token = localStorage.getItem("token");
    if (!token) {
      console.error("Token not found in localStorage");
      return router.push("/login");
    }
    try {
      const response = await axios.get(`http://localhost/api/cadastro/${props.id}`, {
        headers: {
          Authorization: `Bearer ${token}`,
          "Content-Type": "multipart/form-data",
          "Accept": "application/json"
        }
      });
      const data = response.data.data; 
      cadastro.value.id = data.id; 
      cadastro.value.nome = data.nome;
      cadastro.value.cpf = data.cpf; 
      cadastro.value.photo = data.image;
      cadastro.value.email = data.email;
      uploads.value = data.upload;
    } catch (error) {
      console.error("Error fetching cadastro:", error);
      alert("Failed to fetch cadastro data. Please try again.");
    }
  };

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

  const handleFileChange = (event, index) => {
    const file = event.target.files[0];
    if (file) {
      uploads.value[index].file = file;
      uploads.value[index].filepath = URL.createObjectURL(file);
    }
  };

  const updatecadastro = () => {
    const token = localStorage.getItem("token");
    if (!token) {
        console.error("Token not found in localStorage");
        return router.push("/login");
    }
   
    const data = {
        nome: cadastro.value.nome,
        email: cadastro.value.email,
        cpf: cadastro.value.cpf,
        photo: cadastro.value.photo,
        uploads: uploads.value.map(upload => ({ path: upload.filepath }))
    };

 
    const editUrl = `http://localhost/api/cadastro/${props.id}`;
    axios.put(editUrl, data, {
        headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
            "Content-Type": "multipart/form-data", // Set Content-Type to application/json
        },
        body: JSON.stringify(data),
    })
    .then((response) => {
        alert("Updated successfully!");
    })
    .catch((error) => {
        console.error("Error updating cadastro:", error);
        alert("Failed to update cadastro. Please try again.");
    });
};


  onMounted(() => {
    fetchcadastro();
  });

  defineExpose({ cadastro, handleImageChange });
</script>
