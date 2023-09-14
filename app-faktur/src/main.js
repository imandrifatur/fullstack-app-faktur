import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import $ from "jquery";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js"; // Include Bootstrap JS bundle
import "datatables.net-bs4/css/dataTables.bootstrap4.min.css";
import "datatables.net";
import "datatables.net-bs4";

createApp(App).use(router).mount("#app");
