# AutoHub LK — Uploads Directory
This directory stores user-uploaded images (vehicles, parts, services).
PHP execution is blocked via .htaccess.
🔐 Admin Dashboard Login
URL: http://localhost/autohub/public/admin/login

Field	Value
Email	admin@autohub.lk
Password	Admin@1234
TIP

Demo user accounts (for testing the public dashboard) are also available — password for all: password

kamal@autohub.lk — has vehicle listings
parts@autohub.lk — has parts listings
motors@autohub.lk — has service providers
NOTE

The demo data SQL (sql/demo_data.sql) still needs to be imported to populate the site with test listings. Run it from phpMyAdmin → select autohub_lk → Import → choose the file, or approve the terminal command when prompted.