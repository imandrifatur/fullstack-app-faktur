<template>
  <div class="login-page">
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
    <div class="container">
      <form @submit.prevent="login" class="login-form">
        <h2>Login</h2>
        <div class="mb-3">
          <label for="loginEmail" class="form-label">Email</label>
          <input
            v-model="email"
            type="email"
            class="form-control"
            id="loginEmail"
            required
          />
        </div>
        <div class="mb-3">
          <label for="loginPassword" class="form-label">Password</label>
          <input
            v-model="password"
            type="password"
            class="form-control"
            id="loginPassword"
            required
          />
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <p class="text-danger mt-2" v-if="errorMessage">{{ errorMessage }}</p>
        <p class="text-success mt-2" v-if="successMessage">
          {{ successMessage }}
        </p>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: "",
      password: "",
      errorMessage: "",
      successMessage: "",
    };
  },
  methods: {
    async login() {
      this.errorMessage = "";
      this.successMessage = "";

      try {
        const response = await fetch("http://127.0.0.1:8000/api/login", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password,
          }),
          credentials: "include", // Include credentials (cookies)
        });

        if (response.ok) {
          // Login successful, redirect to dashboard
          const data = await response.json();
          localStorage.setItem("token", data.token); // Save the token
          this.successMessage = "Login successful! Redirecting to dashboard...";
          this.$router.push("/dashboard");
        } else {
          // Login failed, show error message
          this.errorMessage = "Login failed. Please check your credentials.";
        }
      } catch (error) {
        console.error("Error:", error);
      }
    },
  },
};
</script>

<style>
.login-page {
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

.login-form {
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
  box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.1);
}

.login-form h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
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

.btn-primary {
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  border: none;
  color: white;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.text-danger {
  color: #dc3545;
}

.text-success {
  color: #28a745;
}
</style>
