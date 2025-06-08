
# 🧱 Hoggar - Laravel Inertia CRUD Generator

**Hoggar** is a full-featured CRUD generator package built with Laravel + Inertia.js + Vue 3. It comes with powerful tools such as Pinia for state management, Quill.js for rich text editing, and Chart.js for data visualization.

---

## 📋 Requirements

- PHP `^8.2`
- Node.js and npm
- Laravel `^12` with Breeze (Inertia.js stack)
- Vite properly configured

---

## 🚀 Installation

### 1. Install Front-End Dependencies

```bash
npm install quill@^2.0.3
npm install vue-chartjs chart.js
npm install pinia
```

---

### 2. Configure `resources/js/app.js`

```js
import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { createPinia } from 'pinia';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const pinia = createPinia();

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(pinia)
      .mount(el);
  },
  progress: {
    color: '#4B5563',
  },
});
```

---

### 3. Update Blade Template

Update your `resources/views/app.blade.php`:

```blade
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title inertia>{{ config('app.name', 'Laravel') }}</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
  <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

  @routes
  @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
  @inertiaHead
</head>
<body class="font-sans antialiased">
  @inertia
</body>
</html>
```

---

### 4. Add License Key to `.env`

```env
GUMROAD_LICENSE_KEY=your-key-here
```

---

### 5. Storage Configuration (example for `public` disk)

```env
HOGGAR_STORAGE_DISK=public
HOGGAR_STORAGE_URL=http://127.0.0.1:8000/storage/
```

---

### 6. Install Hoggar

```bash
composer require hoggarcrud/hoggar
php artisan migrate
php artisan hoggar:install
php artisan vendor:publish --tag=hoggar-config
php artisan storage:link
```

---

### 7. Create Admin User

```bash
php artisan make:hoggar-user
```

Access the admin panel at:

🔗 [http://127.0.0.1:8000/admin/login](http://127.0.0.1:8000/admin/login)

---

## 🧩 Features

- 🎨 Inertia Vue 3 interface
- 🧠 State management with **Pinia**
- 📝 Rich text editing with **Quill.js**
- 📊 Charts with **Chart.js**
- ⚡️ Full **CRUD Generator**
- 🔒 Wizard Form System

---

## 📘 License

This project is licensed under a commercial license via [Gumroad](https://gumroad.com/).

---

**Crafted with ❤️ by [Your Name or Brand]**