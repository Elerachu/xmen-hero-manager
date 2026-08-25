## Group members and contribution

| Member | Email | Contribution |
| --- | --- | --- |
| Tako Nellyvine Mizero | n.mizero@alustudent.com | Shared equally across planning, interface design, PHP development, database work, testing, documentation, and presentation. |
| Hanif Olayiwola | h.olayiwola@alustudent.com | Shared equally across planning, interface design, PHP development, database work, testing, documentation, and presentation. |
| Elera-Obari Josiah-Chu | e.josiah-ch@alustudent.com | Shared equally across planning, interface design, PHP development, database work, testing, documentation, and presentation. |

# X-Men Hero Manager

A PHP and MySQL CRUD web application for managing an X-Men hero roster. Visitors can browse heroes; registered users can create, update, and delete records.

## Run with XAMPP

1. Start **Apache** and **MySQL** in the XAMPP Control Panel.
2. Copy this `xmen-hero-manager` folder into `C:\xampp\htdocs\`.
3. Open [http://localhost/phpmyadmin](http://localhost/phpmyadmin), choose **Import**, and import `database.sql`.
4. Visit [http://localhost/xmen-hero-manager/](http://localhost/xmen-hero-manager/).
5. Select **Register** to create your own test account, then log in to add, edit, or delete heroes.

## Features

- Public hero directory and individual detail pages (Read)
- Authenticated add, edit, and delete actions (Create, Update, Delete)
- Registration, login, logout, PHP sessions, password hashing, protected routes, CSRF tokens, prepared SQL statements
- Browser-side form validation and responsive styling

## Project structure

- `config.php` — MySQL connection settings
- `functions.php` — authentication, session, CSRF, and helper functions
- `index.php`, `details.php` — public pages
- `add.php`, `edit.php`, `delete.php` — protected CRUD pages
- `login.php`, `register.php`, `logout.php` — authentication
- `database.sql` — database schema and starter data
- `assets/` — CSS and JavaScript

## Demo checklist

1. Open the hero directory and one hero profile while logged out.
2. Register a new account, then log in.
3. Add a hero using **Add hero**.
4. Edit that hero and save the change.
5. Delete the test hero and confirm the dialog.
6. Log out and show that **Add hero** is unavailable.
