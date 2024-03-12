<style></style>

<template>
  <div>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-md w-full space-y-8">
        <div>
          <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Login
          </h2>
        </div>
        <form class="mt-8 space-y-6" @submit.prevent="login">
          <div class="rounded-md shadow-sm -space-y-px">
            <div>
              <label for="email-address" class="sr-only">Email address</label>
              <input
                id="email-address"
                name="email"
                type="email"
                autocomplete="email"
                required
                v-model="form.email"
                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                placeholder="Email address"
              />
            </div>
            <div>
              <label for="password" class="sr-only">Password</label>
              <input
                id="password"
                name="password"
                type="password"
                autocomplete="current-password"
                required
                v-model="form.password"
                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                placeholder="Password"
              />
            </div>
          </div>

          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input
                id="remember_me"
                name="remember_me"
                type="checkbox"
                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
              />
              <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                Remember me
              </label>
            </div>

            <div class="text-sm">
              <router-link to="/forget" class="font-medium text-indigo-600 hover:text-indigo-500">
                Forgot your password?
              </router-link>
            </div>
          </div>

          <div>
            <button
              type="submit"
              class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                <!-- Heroicon name: solid/lock-closed -->
                <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                  <path fill-rule="evenodd" d="M4 8V7a4 4 0 014-4h4a4 4 0 014 4v1a4 4 0 01-4 4h-1v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2H4a4 4 0 01-4-4zM6 7a2 2 0 012-2h4a2 2 0 012 2v1H6V7z" />
                </svg>
              </span>
              Login
            </button>
          </div>
        </form>
        <div>
          <router-link to="/register" class="font-medium text-indigo-600 hover:text-indigo-500">
            Need an account? Sign up!
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref } from "vue";
import axios from "redaxios"; // Using regular Axios
import { useRouter } from "vue-router";
import { createWebHistory } from "vue-router";
// Import your Home component

const router = useRouter();

const form = ref({
  email: "",
  password: "",
});

const login = () => {
  axios
    .post("http://localhost/api/login", form.value)
    .then((response) => {
      if (response.data && response.data.success) {
        const token = response.data.token;
        localStorage.setItem("token", token);
        router.push("/");
      } else {
        console.error("Login Error:", response.data.message);
      }
    })
    .catch((error) => {
      // Handle network errors or other issues that may occur during the request
      console.error("Login Error:", error);
    });
};
</script>
