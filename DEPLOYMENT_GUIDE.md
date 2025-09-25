# Student Management System - Deployment Guide

## InfinityFree Hosting Setup

This guide will walk you through deploying your PHP/MySQL Student Management System to InfinityFree hosting.

## Prerequisites

- A completed PHP/MySQL application (Student Management System)
- An InfinityFree account (free)
- A domain name (free from Freenom or purchased)
- FTP client (FileZilla recommended)

## Step 1: Sign Up for InfinityFree

1. Visit [InfinityFree.net](https://infinityfree.net)
2. Click "Create Account"
3. Fill out the registration form
4. Verify your email address
5. Log into your control panel

## Step 2: Get a Free Domain (Optional)

### Option A: Use Freenom (Free domains)
1. Visit [Freenom.com](https://freenom.com)
2. Search for available domains (.tk, .ml, .ga, .cf)
3. Select a domain and register for free (12 months)
4. Complete the registration process

### Option B: Use a subdomain from InfinityFree
- InfinityFree provides free subdomains like `yoursite.infinityfreeapp.com`

## Step 3: Create Hosting Account

1. In your InfinityFree control panel, click "Create Account"
2. Choose your domain (custom domain or subdomain)
3. Select a server location
4. Wait for account creation (usually takes a few minutes)

## Step 4: Configure Database

1. In your hosting control panel, find "MySQL Databases"
2. Click "Create Database"
3. Note down the database details:
   - Database Name: `if0_xxxxxxxx_studentdb`
   - Username: `if0_xxxxxxxx`
   - Password: (you'll set this)
   - Host: `sql200.infinityfree.com` (or similar)

## Step 5: Update Configuration Files

1. Open `includes/config.php` in your local project
2. Update the database credentials:

```php
// InfinityFree database settings
define('DB_HOST', 'sql200.infinityfree.com');  // Your MySQL server
define('DB_NAME', 'if0_12345678_studentdb');   // Your database name
define('DB_USER', 'if0_12345678');             // Your username
define('DB_PASS', 'your_actual_password');      // Your password
```

## Step 6: Upload Files via FTP

### Using FileZilla (Recommended)

1. Download and install [FileZilla](https://filezilla-project.org/download.php?type=client)
2. Get FTP credentials from InfinityFree control panel:
   - Host: `ftpupload.net`
   - Username: `if0_xxxxxxxx` 
   - Password: (your hosting password)
   - Port: 21

3. Connect to FTP server
4. Navigate to `/htdocs/` folder on the server
5. Upload all your PHP files:
   - `index.php`
   - `students.php`
   - `add_student.php`
   - `edit_student.php`
   - `view_student.php`
   - `setup.php`
   - `about.php`
   - `includes/config.php`
   - `css/style.css`
   - `sql/setup.sql`

### File Structure on Server
```
/htdocs/
├── index.php
├── students.php
├── add_student.php
├── edit_student.php
├── view_student.php
├── setup.php
├── about.php
├── includes/
│   └── config.php
├── css/
│   └── style.css
└── sql/
    └── setup.sql
```

## Step 7: Set Up Database Tables

### Method 1: Using the Setup Page
1. Visit `https://yourdomain.com/setup.php`
2. Click "Setup Database" button
3. Verify tables are created successfully

### Method 2: Using phpMyAdmin
1. In InfinityFree control panel, click "phpMyAdmin"
2. Select your database
3. Click "SQL" tab
4. Copy and paste contents of `sql/setup.sql`
5. Click "Go" to execute

## Step 8: Test Your Application

1. Visit your domain: `https://yourdomain.com`
2. Check database connection status on homepage
3. Test all functionality:
   - View students list
   - Add new student
   - Edit student information
   - View student details
   - Delete student (if needed)

## Step 9: Domain Configuration (If using custom domain)

### If you have a custom domain from Freenom:
1. In Freenom control panel, go to "Manage Domain"
2. Click "Management Tools" → "Nameservers"
3. Set nameservers to:
   - `ns1.byet.org`
   - `ns2.byet.org`
   - `ns3.byet.org`
   - `ns4.byet.org`
   - `ns5.byet.org`

### Wait for DNS propagation (24-48 hours)

## Troubleshooting

### Common Issues and Solutions

**Database Connection Failed:**
- Check database credentials in `config.php`
- Ensure database exists in InfinityFree panel
- Verify MySQL server hostname

**500 Internal Server Error:**
- Check file permissions (should be 644 for files, 755 for folders)
- Look at error logs in InfinityFree control panel
- Ensure PHP syntax is correct

**Files Not Uploading:**
- Check FTP credentials
- Ensure you're uploading to `/htdocs/` folder
- Verify file sizes (InfinityFree has limits)

**Database Tables Not Created:**
- Run SQL manually in phpMyAdmin
- Check for SQL syntax errors
- Ensure database user has proper permissions

### Performance Optimization

1. **Enable Gzip Compression** (add to `.htaccess`):
```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
</IfModule>
```

2. **Browser Caching** (add to `.htaccess`):
```apache
<IfModule mod_expires.c>
    ExpiresActive on
    ExpiresByType text/css "access plus 1 year"
    ExpiresByType application/javascript "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
</IfModule>
```

## Security Considerations

1. **Never commit database passwords** to version control
2. **Use environment variables** for sensitive data in production
3. **Keep PHP and dependencies updated**
4. **Regular database backups** via InfinityFree control panel
5. **Monitor error logs** regularly

## Maintenance

### Regular Tasks:
- **Weekly**: Check error logs
- **Monthly**: Backup database
- **Quarterly**: Update application if needed
- **As needed**: Monitor disk space usage

### Backup Strategy:
1. Export database via phpMyAdmin
2. Download files via FTP
3. Store backups securely (cloud storage, local backup, etc.)

## Submission Checklist

Before submitting your homework, verify:

- [ ] Domain is accessible and working
- [ ] All pages load without errors
- [ ] Database connection is successful
- [ ] CRUD operations work correctly
- [ ] Application is responsive on mobile
- [ ] No PHP errors or warnings
- [ ] Professional appearance and styling
- [ ] All navigation links work
- [ ] Form validation is working
- [ ] Error handling is implemented

## Support Resources

- **InfinityFree Documentation**: [https://infinityfree.net/support](https://infinityfree.net/support)
- **InfinityFree Community**: [https://forum.infinityfree.net](https://forum.infinityfree.net)
- **PHP Documentation**: [https://php.net/docs.php](https://php.net/docs.php)
- **MySQL Documentation**: [https://dev.mysql.com/doc/](https://dev.mysql.com/doc/)

## Homework Submission

Email your instructor at `coolprofsinn@gmail.com` with:

**Subject**: Web Programming Homework - Student Management System

**Content**:
```
Name: [Your Name]
Student ID: [Your ID]
Course: Web Programming

Domain URL: https://yourdomain.com
Application Type: Student Management System (PHP/MySQL)

Features Implemented:
- Student registration and management
- Database CRUD operations
- Search and filtering
- Responsive design
- Form validation
- Error handling

Technology Stack:
- PHP 7.4+
- MySQL Database
- HTML5/CSS3
- InfinityFree Hosting

Additional Notes:
[Any special features or challenges you faced]

The application meets all course requirements including custom domain, PHP support, MySQL database, and public accessibility.
```

---

**Congratulations!** 🎉 You've successfully deployed a professional web application that demonstrates real-world web development skills!