# Hireflix Clone - One-Way Video Interview Application

## Overview
A Laravel-based video interview platform that allows admins to create interviews, candidates to record video responses, and reviewers to evaluate submissions.

## Features
- **Multi-role authentication** (Admin, Reviewer, Candidate)
- **Interview Management**: Create interviews with multiple questions
- **Video Recording**: In-browser video recording using WebRTC
- **File Upload**: Alternative option to upload pre-recorded videos
- **Review System**: Score submissions and leave comments
- **Dashboard**: Role-based dashboards with relevant information

## Requirements
- PHP 8.0+
- MySQL 5.7+
- Composer
- Node.js & NPM

## Installation

1. Clone the repository
```bash
git clone <repository-url>
cd hireflix-clone
```

2. Install PHP dependencies
```bash
composer install
```

3. Install JavaScript dependencies
```bash
npm install
npm run build
```

4. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure database in `.env`
```
DB_DATABASE=hireflix_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run migrations and seed data
```bash
php artisan migrate
php artisan db:seed
```

7. Create storage link
```bash
php artisan storage:link
```

8. Start the server
```bash
php artisan serve
```

Access the application at `http://localhost:8000`

## Test Accounts

### Admin Account
- Email: admin@test.com
- Password: password123

### Reviewer Account
- Email: reviewer@test.com
- Password: password123

### Candidate Account
- Email: candidate@test.com
- Password: password123

## Usage Guide

### Admin/Reviewer Flow
1. Login with admin credentials
2. Create new interview with questions
3. View submissions from candidates
4. Review and score submissions

### Candidate Flow
1. Login with candidate credentials
2. Browse available interviews
3. Start interview and record video answers
4. Submit completed interview
5. View feedback from reviewers

## Project Structure
```
hireflix-clone/
├── app/
│   ├── Http/Controllers/
│   │   ├── InterviewController.php
│   │   ├── SubmissionController.php
│   │   ├── ReviewController.php
│   │   └── DashboardController.php
│   └── Models/
│       ├── Interview.php
│       ├── Question.php
│       ├── Submission.php
│       ├── Answer.php
│       └── Review.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/
│       ├── interviews/
│       ├── submissions/
│       └── dashboard/
└── routes/
    └── web.php
```

## Known Limitations
- Video recording requires HTTPS in production
- Browser compatibility: Works best in Chrome/Firefox
- File size limit: 100MB per video
- Video format: WebM (recorded) or common formats (uploaded)

## Security Notes
- All routes are protected with authentication
- Role-based access control implemented
- File uploads validated and stored securely
- CSRF protection enabled

## Future Enhancements
- Email notifications
- Video transcription
- Advanced analytics
- Bulk interview management
- Mobile app support

## Troubleshooting

### Camera/Microphone Access
- Ensure browser has permission to access camera/microphone
- HTTPS required for production deployment

### Storage Issues
- Run `php artisan storage:link` if videos are not displaying
- Check storage/app/public permissions

### Database Errors
- Verify MySQL is running
- Check database credentials in .env
- Run `php artisan migrate:fresh --seed` to reset

## License
This project is created for demonstration purposes.
EOF

echo "Setup complete! Follow these steps:"
echo "1. cd hireflix-clone"
echo "2. composer install"
echo "3. npm install && npm run build"
echo "4. cp .env.example .env"
echo "5. php artisan key:generate"
echo "6. Configure your database in .env"
echo "7. php artisan migrate"
echo "8. php artisan db:seed"
echo "9. php artisan storage:link"
echo "10. php artisan serve"