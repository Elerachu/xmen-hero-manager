## Group members and contribution

| Member | Email |
| --- | --- |
| Tako Nellyvine Mizero | n.mizero@alustudent.com | 
| Hanif Olayiwola | h.olayiwola@alustudent.com | 
| Elera-Obari Josiah-Chu | e.josiah-ch@alustudent.com | 

# X-Men Archive

A PHP and MySQL CRUD web application for managing an X-Men hero roster.
Visitors can browse and search heroes; registered users can create, update, and delete records.

## Run with XAMPP

1. Start **Apache** and **MySQL** in the XAMPP Control Panel.
2. Copy this `xmen-hero-manager` folder into `C:\xampp\htdocs\`.
3. Open [http://localhost/phpmyadmin](http://localhost/phpmyadmin), choose **Import**, and import `database.sql`.
4. Visit [http://localhost/xmen-hero-manager/](http://localhost/xmen-hero-manager/).
5. Select **Register** to create your own test account, then log in to add, edit, or delete heroes.

> If MySQL runs on a non-default port, adjust `DB_PORT` in `config.php` (default XAMPP port is `3306`).

Alternative quick start without Apache (MySQL still required):

```
C:\xampp\php\php.exe -S localhost:8000
```

then open [http://localhost:8000](http://localhost:8000).

## Features

- Public hero directory with live search, team filters, and empty states (Read)
- Authenticated add, edit, and delete actions (Create, Update, Delete)
- Delete confirmation modal with focus trapping (keyboard and Escape friendly)
- Locked "Log in to edit" affordances for visitors, and login redirects back to the page you came from
- Registration, login, logout, PHP sessions, password hashing, protected routes, CSRF tokens, prepared SQL statements
- Client-side validation with inline error messages, character counter, image URL preview, password strength hints
- Responsive layout for desktop and mobile

## Project structure

- `config.php` — MySQL connection settings
- `functions.php` — authentication, session, CSRF, redirect, and formatting helpers
- `header.php`, `footer.php` — shared navigation, alerts, and footer
- `index.php` — public roster with search and filters
- `details.php` — public hero profile and delete modal
- `add.php`, `edit.php`, `delete.php` — protected CRUD pages
- `hero_form.php` — shared create/edit form
- `login.php`, `register.php`, `logout.php` — authentication
- `database.sql` — database schema and starter data
- `assets/` — stylesheet, client-side JavaScript, and images
