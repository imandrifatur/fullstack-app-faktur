<template>
  <div class="background-container">
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
          <li class="nav-item" v-if="isAuthenticated">
            <span class="nav-link">Welcome, {{ username }}!</span>
          </li>
          <li class="nav-item" v-if="isAuthenticated">
            <router-link @click="logout" to="/" class="nav-link"
              >Logout</router-link
            >
          </li>
        </ul>
      </div>
    </nav>
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <p>Pelanggan</p>
              </div>
              <div class="icon" v-if="isAuthenticated">
                <i class="ion ion-bag"></i>
              </div>
              <router-link to="/pelanggan" class="small-box-footer">
                Daftar Pelanggan <i class="fas fa-arrow-circle-right"></i>
              </router-link>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <p>Daftar Barang</p>
              </div>
              <div class="icon" v-if="isAuthenticated">
                <i class="ion ion-stats-bars"></i>
              </div>
              <router-link to="/barang" class="small-box-footer">
                Daftar Barang <i class="fas fa-arrow-circle-right"></i>
              </router-link>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <p>Faktur</p>
              </div>
              <div class="icon" v-if="isAuthenticated">
                <i class="ion ion-person-add"></i>
              </div>
              <router-link to="/faktur" class="small-box-footer">
                Faktur <i class="fas fa-arrow-circle-right"></i>
              </router-link>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <p>Detail Faktur</p>
              </div>
              <div class="icon" v-if="isAuthenticated">
                <i class="ion ion-person-add"></i>
              </div>
              <router-link to="/detail" class="small-box-footer">
                Faktur <i class="fas fa-arrow-circle-right"></i>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  data() {
    return {
      username: "", // Tambahkan variabel username
    };
  },
  computed: {
    isAuthenticated() {
      return !!localStorage.getItem("token");
    },
  },
  created() {
    this.loadUserInfo();
  },
  methods: {
    async loadUserInfo() {
      if (this.isAuthenticated) {
        try {
          const response = await fetch("http://127.0.0.1:8000/api/user", {
            method: "GET",
            headers: {
              "Content-Type": "application/json",
              Authorization: "Bearer " + localStorage.getItem("token"),
            },
          });

          if (response.ok) {
            const userData = await response.json();
            this.username = userData.name; // Simpan nama pengguna
          } else {
            // Handle error
          }
        } catch (error) {
          console.error("Error:", error);
        }
      }
    },
    logout() {
      localStorage.removeItem("token");
      this.$router.push("/login");
    },
  },
};
</script>

<style>
/* Styling for the section */
.content {
  background-color: #f4f6f9; /* Adjust the color as needed */
  padding: 30px 0;
}
.background-container {
  background-image: url("https://source.unsplash.com/random");
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}
/* Rest of the CSS from the previous response */
.container-fluid {
  padding: 20px;
}

.row {
  margin: 0 -15px;
}

.col-lg-3 {
  padding: 0 15px;
}

.small-box {
  background: #a3a3a3;
  border-radius: 4px;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
  padding: 20px;
  position: relative;
}

.small-box .inner {
  padding: 10px;
}

.small-box h3 {
  font-size: 30px;
  font-weight: bold;
  margin: 0;
}

.small-box p {
  margin: 0;
}

.small-box .icon {
  color: #fff;
  font-size: 50px;
  position: absolute;
  right: 15px;
  top: 15px;
}

.small-box a.small-box-footer {
  display: block;
  background: rgba(0, 0, 0, 0.1);
  padding: 3px 0;
  text-align: center;
  color: #333;
  font-weight: bold;
}

.small-box a.small-box-footer:hover {
  background: rgba(0, 0, 0, 0.15);
  text-decoration: none;
}

/* Customize the background colors for different box types */
.bg-info {
  background-color: #17a2b8;
}

.bg-success {
  background-color: #28a745;
}

.bg-warning {
  background-color: #ffc107;
}

.bg-danger {
  background-color: #dc3545;
}
</style>
