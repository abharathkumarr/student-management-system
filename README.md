# Student Management System

A complete PHP/MySQL web application for managing student records, built for Web Programming coursework.

## 🚀 Features

- **Student Registration** - Add new students with comprehensive information
- **Student Directory** - Browse and search all registered students  
- **Record Management** - Update student information with validation
- **Database Operations** - Full CRUD functionality with MySQL
- **Responsive Design** - Mobile-friendly interface
- **Professional UI** - Modern, clean design with CSS Grid/Flexbox

## 🛠️ Technology Stack

- **Backend**: PHP 7.4+, PDO, MySQL
- **Frontend**: HTML5, CSS3, Responsive Design
- **Hosting**: InfinityFree (Free hosting with PHP/MySQL support)
- **Database**: MySQL with phpMyAdmin

## 📁 Project Structure

```
php-student-app/
├── index.php              # Homepage
├── students.php           # View all students
├── add_student.php        # Add new student
├── edit_student.php       # Edit student information
├── view_student.php       # View student details
├── setup.php             # Database setup page
├── about.php             # About page
├── includes/
│   └── config.php        # Database configuration
├── css/
│   └── style.css         # Application styling
├── sql/
│   └── setup.sql         # Database schema and sample data
├── DEPLOYMENT_GUIDE.md   # Detailed deployment instructions
└── README.md             # This file
```

## 🎯 Course Requirements Met

✅ Custom domain name  
✅ PHP programming support  
✅ MySQL database integration  
✅ Publicly accessible on Internet  
✅ Professional web environment  

## 🔧 Local Development Setup

1. **Install XAMPP/WAMP** (for local PHP/MySQL environment)
2. **Clone/Download** this project to your web directory
3. **Create Database** named `studentdb`
4. **Import SQL** from `sql/setup.sql`
5. **Update Config** in `includes/config.php` for local settings:

```php
// For local development
define('DB_HOST', 'localhost');
define('DB_NAME', 'studentdb');
define('DB_USER', 'root');
define('DB_PASS', '');
```

6. **Access Application** at `http://localhost/php-student-app`

## 🌐 Deployment

See `DEPLOYMENT_GUIDE.md` for complete deployment instructions to InfinityFree hosting.

## 💾 Database Schema

### Students Table
- `id` - Primary key (auto-increment)
- `first_name`, `last_name` - Student name (required)
- `email` - Unique email address (required)
- `phone` - Contact number (optional)
- `date_of_birth` - Birth date (optional)
- `address` - Physical address (optional)
- `major` - Field of study (optional)
- `gpa` - Grade point average (0.00-4.00)
- `status` - Enrollment status (active/inactive/graduated)
- `enrollment_date` - Date of enrollment (auto-set)
- `created_at`, `updated_at` - Timestamp tracking

## 🔒 Security Features

- **SQL Injection Prevention** - Prepared statements with PDO
- **XSS Protection** - HTML escaping for outputs
- **Input Validation** - Server-side form validation
- **Error Handling** - Proper exception handling
- **Data Sanitization** - Input cleaning and validation

## 📱 Responsive Design

The application is fully responsive and works on:
- Desktop computers
- Tablets
- Mobile phones
- Various screen sizes and orientations

## 🎨 UI/UX Features

- Clean, modern interface
- Intuitive navigation
- Form validation with user feedback
- Search and filtering capabilities
- Professional color scheme
- Hover effects and transitions
- Mobile-optimized layout

## 🚀 Future Enhancements

- User authentication and authorization
- Course enrollment management
- Grade tracking system
- Report generation
- Email notifications
- File upload capabilities
- RESTful API endpoints
- Advanced search filters

## 📞 Support

For questions about this project or deployment:
- Review the `DEPLOYMENT_GUIDE.md`
- Check InfinityFree documentation
- Consult PHP/MySQL documentation

## 📄 License

This project is created for educational purposes as part of a Web Programming course assignment.

---

