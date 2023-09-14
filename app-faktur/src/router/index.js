import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/Home.vue";
import LoginForm from "../views/Login.vue";
import RegisterForm from "../views/Register.vue";
import Dashboard from "../views/Dashboard.vue"; // Import Dashboard component
import Pelanggan from "../views/Pelanggan.vue";
import Barang from "../views/Barang.vue";
import Faktur from "../views/Faktur.vue";
import DetailFaktur from "../views/Detail-faktur.vue";

const routes = [
  {
    path: "/",
    redirect: "/home",
  },
  {
    path: "/home",
    component: Home,
    meta: { requiresAuth: true }, // Memerlukan autentikasi (sudah login)
  },
  {
    path: "/dashboard",
    name: "Dashboard",
    component: Dashboard,
    meta: { requiresAuth: true }, // Menandakan bahwa halaman ini memerlukan autentikasi
  },
  {
    path: "/pelanggan",
    name: "Pelanggan",
    component: Pelanggan,
    meta: { requiresAuth: true }, // Tambahkan meta jika perlu autentikasi
  },
  {
    path: "/barang",
    name: "Barang",
    component: Barang,
    meta: { requiresAuth: true }, // Tambahkan meta jika perlu autentikasi
  },
  {
    path: "/faktur",
    name: "Faktur",
    component: Faktur,
    meta: { requiresAuth: true }, // Tambahkan meta jika perlu autentikasi
  },
  {
    path: "/detail",
    name: "Detail",
    component: DetailFaktur,
    meta: { requiresAuth: true }, // Tambahkan meta jika perlu autentikasi
  },
  {
    path: "/login",
    name: "Login",
    component: LoginForm,
    meta: { requiresGuest: true }, // Menandakan bahwa halaman ini hanya boleh diakses jika belum login
  },
  {
    path: "/register",
    name: "Register",
    component: RegisterForm,
    meta: { requiresGuest: true }, // Menandakan bahwa halaman ini hanya boleh diakses jika belum login
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem("token");

  if (to.matched.some((record) => record.meta.requiresAuth)) {
    // Jika halaman memerlukan autentikasi dan pengguna belum login
    if (!isAuthenticated) {
      next({ name: "Login" });
    } else {
      next();
    }
  } else if (to.matched.some((record) => record.meta.requiresGuest)) {
    // Jika halaman hanya boleh diakses jika belum login dan pengguna sudah login
    if (isAuthenticated) {
      next({ name: "Dashboard" });
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router;
