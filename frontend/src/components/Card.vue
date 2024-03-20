<script setup>
import { defineProps } from "vue";
import { useRouter } from "vue-router";

const cadastro = defineProps(["cadastro"]);
const router = useRouter();

const verDetalhes = (selectedCadastro) => {
  try {
    // Copying values to avoid reactivity issues
    cadastro.value = { ...selectedCadastro };
    // Navigate to the edit student page
    router.push({ name: "detalhes", params: { id: selectedCadastro.id } });
  } catch (error) {
    console.error("Error navigating to page:", error);
  }
};

</script>

<template>
    <div class="sm:w-1/2 md:w-1/3 px-2 mb-4">
      <div class="bg-white border rounded-lg overflow-hidden">
        <img :src="cadastro.cadastro.image" :alt="cadastro.cadastro.image" class="w-full h-48 object-cover">
        <div class="p-6">
          <h4 class="font-semibold text-lg leading-tight truncate">{{ cadastro.cadastro.nome }}</h4>
        </div>
        <button @click="verDetalhes(cadastro.cadastro)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-2 mx-6">Ver detalhes</button>
      </div>
    </div>
</template>





