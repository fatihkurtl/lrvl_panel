import "./bootstrap";

import "flowbite";

import Alpine from "alpinejs";

import { createApp } from "vue";
import app from "./components/app.vue";
import "../css/app.css";
import router from "./router";

window.Alpine = Alpine;

Alpine.start();

createApp(app).use(router).mount("#app");
