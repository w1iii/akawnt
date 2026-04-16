# Quick Start Guide

## 1️⃣ Migrations Already Run

```
Database setup complete Tables created:
✓ job_applications
✓ admin_whitelists (pre-seeded with 2 emails)
```

## 2️⃣ Configure Email (.env)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="Akawnt"
```

## 3️⃣ Test the System

### Admin Registration

1. Go to: `http://localhost:8000/admin/register`
2. Register with one of these emails:
    - `lui@akawnt.com`
    - `admin@akawnt.com`
3. Set a password

### Job Application (Applicant)

1. Go to: `http://localhost:8000/home#contact`
2. Fill in the job application form
3. Submit (application created with "pending" status)

### Admin Dashboard

1. Login at: `http://localhost:8000/admin/login`
2. View `/admin/dashboard`
3. Find the application you just submitted
4. Click "View" to see details
5. Click "Accept" to create applicant account

### Applicant Login

1. Check your email for acceptance message
2. Copy the temporary password
3. Login at: `http://localhost:8000/login`
4. Your dashboard is at: `http://localhost:8000/dashboard`

---

## 📧 Email Testing (Local Development)

If you want to test without Gmail:

1. Update `.env`:
    ```
    MAIL_MAILER=log
    ```
2. Emails will be logged to `storage/logs/laravel.log`
3. Or use mailpit: `MAIL_HOST=mailpit` + `MAIL_PORT=1025`

---

## 🔑 Default Whitelisted Admin Emails

- `lui@akawnt.com`
- `admin@akawnt.com`

To add more, edit the migration file and re-run migrations, or use:

```php
AdminWhitelist::create(['email' => 'newemail@example.com']);
```

---

## 📂 Key File Locations

| Feature         | Files                                                                                             |
| --------------- | ------------------------------------------------------------------------------------------------- |
| Job Application | `app/Models/JobApplication.php`, `app/Http/Controllers/ApplicationController.php`                 |
| Admin Auth      | `app/Http/Controllers/AuthController.php`, `app/Http/Middleware/AdminMiddleware.php`              |
| Admin Dashboard | `app/Http/Controllers/Admin/DashboardController.php`, `resources/views/admin/dashboard.blade.php` |
| Emails          | `app/Mail/ApplicationAccepted.php`, `app/Mail/ApplicationDeclined.php`                            |
| Routes          | `routes/web.php`                                                                                  |

---

## 🆘 Troubleshooting

**Problem:** Admin registration says email not whitelisted

- **Solution:** Email must match exactly (case-sensitive). Check migration and database.

**Problem:** Emails not sending

- **Solution:** Check `.env` mail configuration. Test with `MAIL_MAILER=log` first.

**Problem:** Resume upload fails

- **Solution:** Ensure `storage/app/private` directory exists and is writable. Run `chmod -R 775 storage`.

**Problem:** "Application status cannot be accepted" error

- **Solution:** Application must be in "pending" or "reviewing" status to accept. Cannot accept already accepted/declined.

**Problem:** Login redirects to home page

- **Solution:** Make sure you're using correct role. Applicants = accountant role, Admins = admin role.

---

## 📞 Support

For full documentation, see: `IMPLEMENTATION_GUIDE.md`
