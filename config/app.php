<?php
/**
 * Application Configuration
 */

// Application
define('APP_NAME', 'Project Vault & Collaboration Hub');
define('APP_SHORT_NAME', 'ProjectVault');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost/Vault&Collab'); // Change to production URL when deploying

// University
define('UNIVERSITY_NAME', 'Regional Maritime University');
define('UNIVERSITY_SHORT', 'RMU');
define('STUDENT_EMAIL_DOMAIN', 'st.rmu.edu.gh');

// File Upload Limits
define('MAX_UPLOAD_SIZE', 50 * 1024 * 1024); // 50MB
define('MAX_PROFILE_PHOTO_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
define('ALLOWED_DOC_TYPES', ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']);

// Upload directories (relative to BASE_PATH)
define('UPLOAD_DIR', '/public/uploads');
define('PROFILE_UPLOAD_DIR', UPLOAD_DIR . '/profiles');
define('CHAT_UPLOAD_DIR', UPLOAD_DIR . '/chat');
define('DOCUMENT_UPLOAD_DIR', UPLOAD_DIR . '/documents');
define('REPO_STORAGE_DIR', '/storage/repos');

// Session
define('SESSION_LIFETIME', 7200); // 2 hours
define('REMEMBER_ME_LIFETIME', 2592000); // 30 days

// SMTP Configuration (PHPMailer)
define('SMTP_HOST', 'smtp.gmail.com'); // Change to your SMTP provider
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your-email@gmail.com'); // Change to your email
define('SMTP_PASSWORD', 'your-app-password'); // Change to your app password
define('SMTP_ENCRYPTION', 'tls');
define('SMTP_FROM_EMAIL', 'noreply@rmu.edu.gh');
define('SMTP_FROM_NAME', APP_NAME);

// Pagination
define('ITEMS_PER_PAGE', 15);

// Notice expiry (in hours)
define('NOTICE_EXPIRY_HOURS', 48);

// Password Policy
define('MIN_PASSWORD_LENGTH', 8);

// CSRF Token name
define('CSRF_TOKEN_NAME', '_csrf_token');

// Timezone
date_default_timezone_set('Africa/Accra');
