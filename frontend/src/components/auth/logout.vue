<template>
  <button @click="logout">Logout</button>
</template>

<script setup>
import { useRouter } from "vue-router"; // Import useRouter outside of script setup
const router = useRouter();
import axios from "redaxios";
import { useToast } from "vue-toastification";
const toast = useToast();
const token = localStorage.getItem("token");
// Check if the token exists
if (!token) {
  console.error("Token not found in localStorage");
}
const logout = async () => {
  // Retrieve the token from localStorage
  try {
    // Clear token from localStorage
    localStorage.removeItem("token");
    // Display a success message to the user
    toast.success("Logged out successfully.");
    router.push("/login");
    // Redirect the user to the login page or wherever appropriate
    // router.push("/login");
  } catch (error) {
    // Log any errors that occur during the logout process
    console.error("Logout Error:", error);
    // Display an error message to the user
    toast.error("Failed to logout.");
  }
};
</script>
