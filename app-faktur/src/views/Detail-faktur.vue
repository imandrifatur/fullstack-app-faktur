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
    <h2>Daftar Item Faktur</h2>
    <table class="table table-bordered" ref="dataTable">
      <thead>
        <tr>
          <th>No</th>
          <th>Faktur ID</th>
          <th>Nama Barang</th>
          <th>Jumlah</th>
          <th>Diskon</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(data, index) in dataList" :key="data.id">
          <td>{{ index + 1 }}</td>
          <td>{{ data.faktur_id }}</td>
          <td>{{ data.barang.nama_barang }}</td>
          <td>{{ data.jumlah }}</td>
          <td>{{ data.diskon }}</td>
        </tr>
      </tbody>
    </table>
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
      dataList: [],
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    async fetchData() {
      try {
        const response = await fetch("http://127.0.0.1:8000/api/item-faktur", {
          method: "GET",
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
            "Content-Type": "application/json",
          },
          credentials: "include",
        });

        if (response.ok) {
          const data = await response.json();

          // Fetch barang data for each item
          const promises = data.map(async (item) => {
            const barangResponse = await fetch(
              `http://127.0.0.1:8000/api/barang/${item.barang_id}`,
              {
                method: "GET",
                headers: {
                  Authorization: `Bearer ${localStorage.getItem("token")}`,
                  "Content-Type": "application/json",
                },
                credentials: "include",
              }
            );

            if (barangResponse.ok) {
              const barangData = await barangResponse.json();
              item.barang = barangData; // Add barang data to the item
            } else {
              console.error("Error fetching barang data");
            }
          });

          // Wait for all barang data to be fetched
          await Promise.all(promises);

          this.dataList = data;
          this.initDataTable(); // Initialize DataTable after data is fetched
        } else {
          console.error("Error fetching data");
        }
      } catch (error) {
        console.error("Error:", error);
      }
    },
    initDataTable() {
      // Use a setTimeout to ensure that the table element is in the DOM
      this.$nextTick(() => {
        $(this.$refs.dataTable).DataTable();
      });
    },
  },
};
</script>
