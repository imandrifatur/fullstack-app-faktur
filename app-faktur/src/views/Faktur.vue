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
    <h2>Faktur</h2>
    <button class="btn btn-primary" @click="openTambahFakturModal">
      <i class="fas fa-plus"></i>Tambah Faktur
    </button>
    <br />
    <br />

    <!-- Tabel daftar faktur -->
    <table
      id="fakturTable"
      class="table table-bordered table-striped"
      ref="FakturTable"
    >
      <thead>
        <tr>
          <th>NO</th>
          <th>Tanggal Faktur</th>
          <th>Pelanggan Id</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(faktur, index) in fakturList" :key="faktur.id">
          <td>{{ index + 1 }}</td>
          <td>{{ faktur.tanggal }}</td>
          <td>{{ faktur.pelanggan_id }}</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="modal" tabindex="-1" role="dialog" ref="tambahFakturModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Faktur</h5>
          <button
            type="button"
            class="close"
            @click="closeModal('tambahFakturModal')"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="submitTambahFakturForm">
            <div class="form-group">
              <label for="nomorFaktur">Nomor Faktur</label>
              <input
                type="text"
                class="form-control"
                v-model="newFaktur.nomor_faktur"
                required
              />
            </div>
            <div class="form-group">
              <label for="tanggalFaktur">Tanggal Faktur</label>
              <input
                type="date"
                class="form-control"
                v-model="newFaktur.tanggal_faktur"
                required
              />
            </div>
            <div class="form-group">
              <label for="pelangganId">ID Pelanggan</label>
              <select
                class="form-control"
                v-model="newFaktur.pelanggan_id"
                required
              >
                <option value="" disabled selected>Pilih ID Pelanggan</option>
                <option
                  v-for="pelanggan in pelangganList"
                  :key="pelanggan.id"
                  :value="pelanggan.id"
                >
                  {{ pelanggan.nama }}
                </option>
              </select>
            </div>

            <div
              class="form-group"
              v-for="(item, index) in newFaktur.items"
              :key="index"
            >
              <label for="barangId">ID Barang</label>
              <select class="form-control" v-model="item.barang_id" required>
                <option value="" disabled selected>Pilih ID Barang</option>
                <option
                  v-for="barang in barangList"
                  :key="barang.id"
                  :value="barang.id"
                >
                  {{ barang.nama_barang }}
                </option>
              </select>
              <label for="jumlah">Jumlah</label>
              <input
                type="number"
                class="form-control"
                v-model="item.jumlah"
                required
              />
              <label for="diskon">Diskon</label>
              <input
                type="number"
                class="form-control"
                v-model="item.diskon"
                required
              />
            </div>
            <button type="button" class="btn btn-primary" @click="addNewItem">
              Tambah Item
            </button>
            <button type="submit" class="btn btn-primary">Tambah Faktur</button>
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

export default {
  data() {
    return {
      fakturList: [],
      pelangganList: [], // Menyimpan data pelanggan dari endpoint
      barangList: [], // Menyimpan data barang dari endpoint
      newFaktur: {
        nomor_faktur: "",
        tanggal_faktur: "",
        pelanggan_id: 0,
        items: [
          {
            barang_id: 0,
            jumlah: 0,
            diskon: 0,
          },
        ],
      },
    };
  },
  created() {
    this.fetchFakturData();
    this.fetchPelangganData();
    this.fetchBarangData();
  },
  methods: {
    async fetchFakturData() {
      try {
        const response = await fetch("http://127.0.0.1:8000/api/faktur", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
            "Content-Type": "application/json",
          },
          credentials: "include",
        });

        if (response.ok) {
          const data = await response.json();
          this.fakturList = data;
          this.initDataTable();
        } else {
          console.error("Error fetching faktur data");
        }
      } catch (error) {
        console.error("Error:", error);
      }
    },
    initDataTable() {
      // Use a setTimeout to ensure that the table element is in the DOM
      setTimeout(() => {
        $(this.$refs.FakturTable).DataTable();
      }, 0);
    },
    openModal(modalRef) {
      this.$refs[modalRef].classList.add("show");
      this.$refs[modalRef].style.display = "block";
      document.body.classList.add("modal-open");
    },
    openTambahFakturModal() {
      this.openModal("tambahFakturModal");
    },
    closeModal(modalRef) {
      this.$refs[modalRef].classList.remove("show");
      this.$refs[modalRef].style.display = "none";
      document.body.classList.remove("modal-open");
      this.resetNewFaktur();
    },
    resetNewFaktur() {
      this.newFaktur = {
        nomor_faktur: "",
        tanggal_faktur: "",
        pelanggan_id: 0,
        items: [
          {
            barang_id: 0,
            jumlah: 0,
            diskon: 0,
          },
        ],
      };
    },
    addNewItem() {
      this.newFaktur.items.push({
        barang_id: 0,
        jumlah: 0,
        diskon: 0,
      });
    },
    async submitTambahFakturForm() {
      if (!this.validateForm()) {
        return;
      }
      try {
        const response = await fetch("http://127.0.0.1:8000/api/faktur", {
          method: "POST",
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            tanggal: this.newFaktur.tanggal_faktur,
            pelanggan_id: this.newFaktur.pelanggan_id,
            items: this.newFaktur.items.map((item) => ({
              barang_id: item.barang_id,
              jumlah: item.jumlah,
              diskon: item.diskon,
            })),
          }),
          credentials: "include",
        });

        if (response.ok) {
          this.closeModal("tambahFakturModal");
          this.fetchFakturData();
        } else {
          console.error("Error adding faktur");
          const responseData = await response.json();
          console.error("Response:", responseData);
        }
      } catch (error) {
        console.error("Error:", error);
      }
    },
    validateForm() {
      if (
        this.newFaktur.nomor_faktur === "" ||
        this.newFaktur.tanggal_faktur === "" ||
        this.newFaktur.pelanggan_id <= 0
      ) {
        alert("Mohon isi semua field yang dibutuhkan.");
        return false;
      }

      for (const item of this.newFaktur.items) {
        if (
          item.barang_id <= 0 ||
          item.jumlah <= 0 ||
          item.diskon < 0 ||
          item.diskon > 100
        ) {
          alert("Mohon isi semua field yang dibutuhkan dengan benar.");
          return false;
        }
      }
      return true; // Mengembalikan true jika validasi berhasil
    },
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
        } else {
          console.error("Error adding faktur");
          console.error("Response:", response); // Menampilkan detail respon dari server
        }
      } catch (error) {
        console.error("Error:", error);
      }
    },
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
        } else {
          console.error("Error fetching barang data");
        }
      } catch (error) {
        console.error("Error:", error);
      }
    },
  },
};
</script>
