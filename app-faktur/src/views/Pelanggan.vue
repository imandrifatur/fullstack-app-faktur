<template>
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
          <router-link class="nav-link" to="/dashboard">Kembali</router-link>
        </li>
      </ul>
    </div>
  </nav>
  <br />
  <br />
  <br />
  <div class="container">
    <h2>Daftar Pelanggan</h2>
    <br />
    <button @click="addModal" class="btn btn-primary">
      <i class="fas fa-plus"></i> Tambah Pelanggan
    </button>
    <br />
    <br />
    <!-- Tabel daftar pelanggan -->
    <table
      id="pelangganTable"
      class="table table-bordered table-striped"
      ref="pelangganTable"
    >
      <thead>
        <tr>
          <th>NO</th>
          <th>Nama</th>
          <th>Alamat</th>
          <th>Telepon</th>
          <th>Pilihan</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(pelanggan, index) in pelangganList" :key="pelanggan.id">
          <td>{{ index + 1 }}</td>
          <td>{{ pelanggan.nama }}</td>
          <td>{{ pelanggan.alamat }}</td>
          <td>{{ pelanggan.telepon }}</td>
          <td>
            <i class="fas fa-edit" @click="editModal(pelanggan)"></i>
            <!-- ... your other buttons ... -->
            <i class="fas fa-trash-alt" @click="confirmDelete(pelanggan)"></i>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <!-- Modal tambah pelanggan -->
  <div class="modal" tabindex="-1" role="dialog" ref="addModal">
    <div class="modal-dialog" role="document">
      <!-- Konten form modal tambah pelanggan -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Pelanggan</h5>
          <button type="button" class="close" @click="closeModal('addModal')">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="submitForm">
            <div class="form-group">
              <label for="nama">Nama</label>
              <input
                v-model="newPelanggan.nama"
                type="text"
                class="form-control"
                id="nama"
                required
              />
            </div>
            <div class="form-group">
              <label for="alamat">Alamat</label>
              <input
                v-model="newPelanggan.alamat"
                type="text"
                class="form-control"
                id="alamat"
                required
              />
            </div>
            <div class="form-group">
              <label for="telepon">Telepon</label>
              <input
                v-model="newPelanggan.telepon"
                type="text"
                class="form-control"
                id="telepon"
                required
              />
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal edit pelanggan -->
  <div class="modal" tabindex="-1" role="dialog" ref="editModal">
    <div class="modal-dialog" role="document">
      <!-- Konten form modal edit pelanggan -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Pelanggan</h5>
          <button type="button" class="close" @click="closeModal('editModal')">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="submitEditForm">
            <div class="form-group">
              <label for="editNama">Nama</label>
              <input
                v-model="editedPelanggan.nama"
                type="text"
                class="form-control"
                id="editNama"
                required
              />
            </div>
            <div class="form-group">
              <label for="editAlamat">Alamat</label>
              <input
                v-model="editedPelanggan.alamat"
                type="text"
                class="form-control"
                id="editAlamat"
                required
              />
            </div>
            <div class="form-group">
              <label for="editTelepon">Telepon</label>
              <input
                v-model="editedPelanggan.telepon"
                type="text"
                class="form-control"
                id="editTelepon"
                required
              />
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import $ from "jquery";
import "datatables.net-bs4/css/dataTables.bootstrap4.min.css";
import "datatables.net";
import "datatables.net-bs4";
import "@fortawesome/fontawesome-free/css/all.css"; // Mengimpor stylesheet FontAwesome

export default {
  data() {
    return {
      pelangganList: [],
      newPelanggan: {
        nama: "",
        alamat: "",
        telepon: "",
      },
      editedPelanggan: {
        id: null,
        nama: "",
        alamat: "",
        telepon: "",
      },
      deletedPelanggan: null,
    };
  },
  created() {
    this.fetchPelangganData();
  },
  methods: {
    async fetchPelangganData() {
      try {
        const response = await fetch("http://127.0.0.1:8000/api/pelanggan", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
            "Content-Type": "application/json",
          },
          credentials: "include",
        });

        if (response.ok) {
          const data = await response.json();
          this.pelangganList = data;
          this.initDataTable(); // Move the initDataTable call here
        } else {
          console.error("Error fetching data");
        }
      } catch (error) {
        console.error("Error:", error);
      }
    },
    initDataTable() {
      // Use a setTimeout to ensure that the table element is in the DOM
      setTimeout(() => {
        $(this.$refs.pelangganTable).DataTable();
      }, 0);
    },
    addModal() {
      this.$refs.addModal.classList.add("show");
      this.$refs.addModal.style.display = "block";
      document.body.classList.add("modal-open");
    },

    closeModal(modalRef) {
      this.$refs[modalRef].classList.remove("show");
      this.$refs[modalRef].style.display = "none";
      document.body.classList.remove("modal-open");
      this.resetNewPelanggan();
    },

    resetNewPelanggan() {
      this.newPelanggan = {
        nama: "",
        alamat: "",
        telepon: "",
      };
    },

    async submitForm() {
      try {
        const response = await fetch("http://127.0.0.1:8000/api/pelanggan", {
          method: "POST",
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
            "Content-Type": "application/json",
          },
          body: JSON.stringify(this.newPelanggan),
          credentials: "include",
        });

        if (response.ok) {
          this.newPelanggan = {
            nama: "",
            alamat: "",
            telepon: "",
          };
          this.closeModal("addModal");
          this.fetchPelangganData();
        } else {
          console.error("Error adding pelanggan");
        }
      } catch (error) {
        console.error("Error:", error);
      }
    },
    editModal(pelanggan) {
      this.editedPelanggan = { ...pelanggan };
      this.openEditModal("editModal");
    },
    openEditModal(modalRef) {
      this.$refs[modalRef].classList.add("show");
      this.$refs[modalRef].style.display = "block";
      document.body.classList.add("modal-open");
    },
    closeModal(modalRef) {
      this.$refs[modalRef].classList.remove("show");
      this.$refs[modalRef].style.display = "none";
      document.body.classList.remove("modal-open");
      this.resetEditedPelanggan(); // Panggil fungsi resetEditedPelanggan di sini
    },
    resetEditedPelanggan() {
      this.editedPelanggan = {
        // Atur ulang nilai objek editedPelanggan sesuai kebutuhan Anda
        // Contoh:
        id: null,
        nama: "",
        alamat: "",
        telepon: "",
      };
    },
    async submitEditForm() {
      try {
        const response = await fetch(
          `http://127.0.0.1:8000/api/pelanggan/${this.editedPelanggan.id}`,
          {
            method: "PUT",
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
              "Content-Type": "application/json",
            },
            body: JSON.stringify(this.editedPelanggan),
            credentials: "include",
          }
        );

        if (response.ok) {
          this.closeModal("editModal");
          this.fetchPelangganData();
        } else {
          console.error("Error editing pelanggan");
        }
      } catch (error) {
        console.error("Error:", error);
      }
    },
    async confirmDelete(pelanggan) {
      const userConfirmed = window.confirm(
        "Apakah Anda yakin ingin menghapus pelanggan ini?"
      );

      if (userConfirmed) {
        await this.deletePelanggan(pelanggan);
      }
    },
    async deletePelanggan(pelanggan) {
      try {
        const response = await fetch(
          `http://127.0.0.1:8000/api/pelanggan/${pelanggan.id}`,
          {
            method: "DELETE",
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
              "Content-Type": "application/json",
            },
            credentials: "include",
          }
        );

        if (response.ok) {
          this.fetchPelangganData();
        } else {
          console.error("Error deleting pelanggan");
        }
      } catch (error) {
        console.error("Error:", error);
      }
    },
  },
};
</script>
