<div align="center">

# 🎓 Project Vault & Collaboration Hub

**A Next-Generation Academic Management & Collaboration Platform Built for Regional Maritime University (RMU).**

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/Vanilla_JS-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![CSS3](https://img.shields.io/badge/CSS3_Glassmorphism-1572B6?style=for-the-badge&logo=css3&logoColor=white)

<p align="center">
  <a href="#features">Key Features</a> •
  <a href="#architecture">Architecture</a> •
  <a href="#installation">Installation</a> •
  <a href="#modules">System Modules</a>
</p>

</div>

---

## 📖 Overview

The **Project Vault & Collaboration Hub** is a dynamic, multi-tenant portal designed to streamline the final-year project lifecycle between students, academic supervisors, and Heads of Departments (HOD). Built from the ground up utilizing a custom vanilla PHP MVC framework, it prioritizes a gorgeous **responsive, glassmorphic UI design**, real-time collaboration tools, and built-in educational scaffolds.

## 🚀 Key Features

- **Role-Based Access Control (RBAC):** Distinct specialized dashboard environments for `Students`, `Supervisors`, `HODs`, and `System Admins`.
- **Workspace Labs (Code Playground):** A fully embedded browser-based IDE powered by CodeMirror, allowing students to test HTML/CSS/JS snippets in real-time.
- **Academic Resource Gallery:** "Department-aware" video learning paths and visual cheat-sheet grids tailored intelligently to each student.
- **Dynamic User Settings:** Granular configuration systems for account preferences, notification toggles, and UI modes, orchestrated by an efficient SQL Upsert tracking architecture.
- **Bank-Grade Authentication:** CSRF token verification, Bcrypt password hashing, forced MIME-type checking on file uploads, and native `PHPMailer` integrated verification flows.
- **Fluid Responsiveness:** Adaptive layouts that flex beautifully onto mobile browsers without compromising UX.

## ⚙️ Architecture & Tech Stack

This project was built deliberately **without heavy framework clutter**, strictly adhering to native performance standards:

*   **Backend:** Pure Vanilla PHP 8+ oriented around a custom-built MVC (Model-View-Controller) routing engine.
*   **Frontend Design:** Semantic HTML5 and modular vanilla CSS3 leveraging CSS Variables, Flexbox, CSS Grid, and sophisticated Glassmorphism aesthetic tokens.
*   **Database Engine:** `MySQL` utilizing secure `PDO` prepared statements exclusively.
*   **Dependencies:** `PHPMailer` (for robust SMTP communication).

---

## 🛠 Installation & Local Setup

If you are cloning this repository to a local server like `WAMP`, `XAMPP`, or `MAMP`, follow these steps:

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/EvansAnguah/Vault-Collab.git
   cd Vault-Collab
   ```

2. **Database Initialization:**
   - Create a new MySQL database named `vault_collab`.
   - Import the schema by executing the provided database seed: `database/schema.sql`.

3. **Install Dependencies:**
   Ensure you have Composer installed globally.
   ```bash
   composer install
   ```

4. **Environment Configuration:**
   - Navigate to `config/app.php` and `config/database.php`.
   - Ensure the database credentials match your local host parameters (default: user `root`, no password).
   - Adjust the `APP_URL` constant in `config/app.php`. If deploying on InfinityFree, set this to the base URL of your domain.

5. **Start Serving:**
   Ensure WAMP Apache is running, and navigate to the project root inside your browser *(e.g. `http://localhost/Vault&Collab`)*.

---

## 🗃️ System Modules

### 👤 Profile & Settings Identity
Users retain tight control over their university identity. Secure capabilities map uploading strict `<5MB` encrypted profile picture uploads, modifying active contact phone numbers (while rigorously restricting hardcoded university data fields like `Index Number`), and flipping system state notification preferences dynamically.

### 📚 The Academic Scaffold
A dedicated *Learning Space* integrated deeply into the portal. Students can experiment inside the bespoke **Workspace Playground**, allowing persistent code snippet executions directly inside a secure sandboxed `iframe`.

### 🛡️ Core MVC Routing
The `Router.php` and base `Controller.php` govern all traffic traversing the application, intelligently managing Auth middleware interventions, auto-injecting hydrated user session parameters into global visual components (`topbar.php` / `app.php`), and executing rigid flash messaging UI overlays.

---

<div align="center">
<p>Developed to revolutionize digital academia at RMU.</p>
</div>
