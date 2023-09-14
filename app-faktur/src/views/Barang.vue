<template>
  <div>
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
      <h2>Daftar Barang</h2>
      <br />
      <button @click="openAddModal" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Barang
      </button>
      <br />
      <br />
      <table class="table table-bordered" ref="barangTable">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Pilihan</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(barang, index) in barangList" :key="barang.id">
            <td>{{ index + 1 }}</td>
            <td>{{ barang.nama_barang }}</td>
            <td>{{ barang.satuan }}</td>
            <td>{{ barang.harga_satuan }}</td>
            <td>
              <i
                @click="editModal(barang)"
                class="fas fa-edit text-primary cursor-pointer"
              ></i>
              <i
                @click="deleteBarang(barang.id)"
                class="fas fa-trash-alt text-danger cursor-pointer"
              ></i>
              <i
                @click="showDetailModal(barang.id)"
                class="fas fa-eye text-info cursor-pointer"
              ></i>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Modal tambah barang -->
      <div class="modal" tabindex="-1" role="dialog" ref="addModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Tambah Barang</h5>
              <button
                type="button"
                class="close"
                @click="closeModal('addModal')"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="submitForm">
                <div class="form-group">
                  <label for="namaBarang">Nama Barang</label>
                  <input
                    v-model="newBarang.nama_barang"
                    type="text"
                    class="form-control"
                    id="namaBarang"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="satuan">Satuan</label>
                  <input
                    v-model="newBarang.satuan"
                    type="text"
                    class="form-control"
                    id="satuan"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="hargaSatuan">Harga Satuan</label>
                  <input
                    v-model="newBarang.harga_satuan"
                    type="number"
                    class="form-control"
                    id="hargaSatuan"
                    required
                  />
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal edit barang -->
    <div class="modal" tabindex="-1" role="dialog" ref="editModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Barang</h5>
            <button
              type="button"
              class="close"
              @click="closeModal('editModal')"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitEditForm">
              <div class="form-group">
                <label for="editNamaBarang">Nama Barang</label>
                <input
                  v-model="editedBarang.nama_barang"
                  type="text"
                  class="form-control"
                  id="editNamaBarang"
                  required
                />
              </div>
              <div class="form-group">
                <label for="editSatuan">Satuan</label>
                <input
                  v-model="editedBarang.satuan"
                  type="text"
                  class="form-control"
                  id="editSatuan"
                  required
                />
              </div>
              <div class="form-group">
                <label for="editHargaSatuan">Harga Satuan</label>
                <input
                  v-model="editedBarang.harga_satuan"
                  type="number"
                  class="form-control"
                  id="editHargaSatuan"
                  required
                />
              </div>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal detail barang -->
  <div class="modal" tabindex="-1" role="dialog" ref="detailModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Barang</h5>
          <button
            type="button"
            class="close"
            @click="closeModal('detailModal')"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p><strong>Nama:</strong> {{ detailBarang.nama_barang }}</p>
          <p><strong>Satuan:</strong> {{ detailBarang.satuan }}</p>
          <p><strong>Harga:</strong> {{ detailBarang.harga_satuan }}</p>
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
      barangList: [],
      newBarang: {
        nama_barang: "",
        satuan: "",
        harga_satuan: 0,
      },
      editedBarang: {
        id: null,
        nama_barang: "",
        satuan: "",
        harga_satuan: 0,
      },
      detailBarang: {},
    };
  },
  created() {
    this.fetchBarangData();
  },
  methods: {
    async fetchBarangData() {
      try {
        const response = await fetch("http://127.0.0.1:8000/api/barang", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
            "Content-Type": "application/json",
          },
          credentials: "include",
        });

        if (response.ok) {
          const data = await response.json();
          this.barangList = data;
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
        $(this.$refs.barangTable).DataTable();
      }, 0);
    },
    openAddModal() {
      this.$refs.addModal.classList.add("show");
      this.$refs.addModal.style.display = "block";
      document.body.classList.add("modal-open");
    },
    closeModal(modalRef) {
      this.$refs[modalRef].classList.remove("show");
      this.$refs[modalRef].style.display = "none";
      document.body.classList.remove("modal-open");
      this.resetNewBarang();
    },
    resetNewBarang() {
      this.newBarang = {
        nama_barang: "",
        satuan: "",
        harga_satuan: 0,
      };
    },
    async submitForm() {
      try {
        const response = await fetch("http://127.0.0.1:8000/api/barang", {
          method: "POST",
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
            "Content-Type": "application/json",
          },
          body: JSON.stringify(this.newBarang),
          credentials: "include",
        });

        if (response.ok) {
          this.closeModal("addModal");
          this.fetchBarangData();
        } else {
          console.error("Error adding barang");
        }
      } catch (error) {
        console.error("Error:", error);
      }
    },
    openEditModal() {
      this.$refs.editModal.classList.add("show");
      this.$refs.editModal.style.display = "block";
      document.body.classList.add("modal-open");
    },
    closeModal(modalRef) {
      this.$refs[modalRef].classList.remove("show");
      this.$refs[modalRef].style.display = "none";
      document.body.classList.remove("modal-open");
      this.resetEditedBarang();
    },
    resetEditedBarang() {
      this.editedBarang = {
        id: null,
        nama_barang: "",
        satuan: "",
        harga_satuan: 0,
      };
    },
    editModal(barang) {
      this.editedBarang = { ...barang };
      this.openEditModal();
    },
    async submitEditForm() {
      try {
        const response = await fetch(
          `http://127.0.0.1:8000/api/barang/${this.editedBarang.id}`,
          {
            method: "PUT",
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
              "Content-Type": "application/json",
            },
            body: JSON.stringify(this.editedBarang),
            credentials: "include",
          }
        );

        if (response.ok) {
          this.closeModal("editModal");
          this.fetchBarangData();
        } else {
          console.error("Error editing barang");
        }
      } catch (error) {
        console.error("Error:", error);
      }
    },
    async deleteBarang(barangId) {
      if (confirm("Apakah Anda yakin ingin menghapus barang ini?")) {
        try {
          const response = await fetch(
            `http://127.0.0.1:8000/api/barang/${barangId}`,
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
            this.fetchBarangData();
          } else {
            console.error("Error deleting barang");
          }
        } catch (error) {
          console.error("Error:", error);
        }
      }
    },
    showDetailModal(barangId) {
      this.fetchDetailBarang(barangId);
      this.isDetailModalVisible = true; // Show the modal
    },
    openModal(modalRef) {
      this.$refs[modalRef].classList.add("show");
      this.$refs[modalRef].style.display = "block";
      document.body.classList.add("modal-open");
    },
    closeModal(modalRef) {
      this.$refs[modalRef].classList.remove("show");
      this.$refs[modalRef].style.display = "none";
      document.body.classList.remove("modal-open");
      this.isDetailModalVisible = false;
      this.detailBarang = {}; // Reset detailBarang
    },
    async fetchDetailBarang(barangId) {
      try {
        const response = await fetch(
          `http://127.0.0.1:8000/api/barang/${barangId}`,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
              "Content-Type": "application/json",
            },
            credentials: "include",
          }
        );

        if (response.ok) {
          const data = await response.json();
          this.detailBarang = data;
          this.openModal("detailModal");
        } else {
          console.error("Error fetching data");
        }
      } catch (error) {
        console.error("Error:", error);
      }
    },
  },
};
</script>
