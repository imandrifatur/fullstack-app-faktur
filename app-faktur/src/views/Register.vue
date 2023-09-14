<template>
  <div class="register-page">
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
      <a class="navbar-brand" href="#">E-Faktur Pembelian</a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <router-link to="/login" class="nav-link">Login</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/register" class="nav-link">Register</router-link>
          </li>
          <!-- ... Other navbar items ... -->
        </ul>
      </div>
    </nav>
    <br />
    <br />
    <br />
    <br />
    <div class="container">
      <form @submit.prevent="register" class="register-form">
        <h2>Form Register</h2>
        <div class="mb-3">
          <label for="registerName" class="form-label">Name</label>
          <input
            v-model="name"
            type="text"
            class="form-control"
            id="registerName"
            required
          />
        </div>
        <div class="mb-3">
          <label for="registerEmail" class="form-label">Email</label>
          <input
            v-model="email"
            type="email"
            class="form-control"
            id="registerEmail"
            required
          />
        </div>
        <div class="mb-3">
          <label for="registerPassword" class="form-label">Password</label>
          <input
            v-model="password"
            type="password"
            class="form-control"
            id="registerPassword"
            required
          />
        </div>
        <div class="mb-3">
          <label for="registerPasswordConfirm" class="form-label"
            >Confirm Password</label
          >
          <input
            v-model="confirmPassword"
            type="password"
            class="form-control"
            id="registerPasswordConfirm"
            required
          />
        </div>
        <button type="submit" class="btn btn-success">Register</button>
      </form>
      <div v-if="registrationSuccess" class="alert alert-success mt-3">
        {{ registrationSuccess }}
      </div>
      <div v-if="registrationError" class="alert alert-danger mt-3">
        {{ registrationError }}
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
      confirmPassword: "",
      registrationError: "",
      registrationSuccess: "",
    };
  },
  methods: {
    async register() {
      try {
        const response = await fetch("http://127.0.0.1:8000/api/register", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.confirmPassword,
          }),
        });
        if (response.status === 200) {
          this.registrationSuccess =
            "Registration successful. Redirecting to login page...";
          setTimeout(() => {
            this.$router.push("/login");
          }, 2000);
        }
      } catch (error) {
        if (error.response) {
          this.registrationError =
            error.response.data.message || "Registration failed.";
        } else {
          this.registrationError = "An error occurred during registration.";
        }
      }
    },
  },
};
</script>

<style scoped>
.register-page {
  background-image: url("https://source.unsplash.com/random"); /* Ganti dengan URL gambar latar belakang Anda */
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
  padding: 40px 0;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.register-form {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  background-color: rgba(
    255,
    255,
    255,
    0.9
  ); /* Latar belakang transparan dengan warna putih */
  border-radius: 5px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.form-label {
  font-weight: bold;
  color: #555;
}

.form-control {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #d1d1d1;
  border-radius: 5px;
}

.btn-success {
  width: 100%;
  padding: 10px;
  background-color: #28a745;
  border: none;
  color: white;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-success:hover {
  background-color: #1e7e34;
}

.alert {
  margin-top: 15px;
  padding: 10px;
  border-radius: 5px;
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.alert-danger {
  background-color: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}
</style>
