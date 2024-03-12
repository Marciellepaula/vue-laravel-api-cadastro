<script setup>
import { ref } from "vue";
import axios from "redaxios";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";

const toast = useToast();

const router = useRouter();


const form = ref({
  name: null,
  email: null,
  password: null,
  password_confirmation: null,
}); // Initialize as a ref



const signup = () => {
  // alert('done');   //--testing submit
  axios
    .post("http://localhost/api/register", form.value)
    .then((response) => {
      User.responseAfterLogin(response);
      toast.fire({
        icon: "success",
        title: "Signed in Successfully",
      });
      router.push("/login"); // or, router.push({name:'home})
    })
    .catch((error) => {
      // Handle errors
    });
};
</script>

<style></style>
<template>
  <div class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-lg mx-auto">
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-bold text-primary text-center mb-4">
              Register New Account
            </h3>
            <form @submit.prevent="signup">
              <div class="mb-4">
                <label for="inputFirstName" class="block text-sm font-medium text-gray-700">
                  Full Name
                </label>
                <input id="inputFirstName" type="text" v-model="form.name" autocomplete="name"
                  class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
              </div>
              <div class="mb-4">
                <label for="inputEmailAddress" class="block text-sm font-medium text-gray-700">
                  Email address
                </label>
                <input id="inputEmailAddress" type="email" v-model="form.email" autocomplete="email"
                  class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
              </div>
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="mb-4">
                  <label for="inputPassword" class="block text-sm font-medium text-gray-700">
                    Password
                  </label>
                  <input id="inputPassword" type="password" v-model="form.password" autocomplete="new-password"
                    class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                  <label for="inputConfirmPassword" class="block text-sm font-medium text-gray-700">
                    Confirm Password
                  </label>
                  <input id="inputConfirmPassword" type="password" v-model="form.password_confirmation"
                    autocomplete="new-password"
                    class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
              </div>
              <div class="mt-4">
                <button type="submit"
                  class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                  Sign up
                </button>
              </div>
            </form>
          </div>
          <div class="bg-gray-50 px-4 py-4 sm:px-6 text-center">
            <p class="text-sm">
              Already have an account?
              <router-link to="/" class="font-medium text-primary hover:text-primary-dark">Go to login</router-link>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
