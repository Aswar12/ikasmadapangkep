# Database Design for Alumni Information System

## Tables and Descriptions

### 1. users
- Stores user account information for authentication and identification.
- Fields: id, ip_address, username, password, salt, email, activation_code, forgotten_password_code, forgotten_password_time, remember_code, created_on, last_login, active, first_name, last_name.

### 2. groups
- Defines user roles/groups such as admin and members.
- Fields: id, name, description.

### 3. users_groups
- Many-to-many relationship between users and groups.
- Fields: id, user_id, group_id.

### 4. profile
- Stores detailed profile information for each user.
- Fields: id, user_id, gender, birth_place, birth_date, national_student_number, address, phone_number, father_name, father_occupation, mother_name, mother_occupation, entry_year, graduation_year, diploma_number, certificate_number.

### 5. alumni_status
- Tracks the status of alumni with descriptions.
- Fields: id, user_id, status, description.

### 6. event
- Stores events related to alumni activities.
- Fields: id, event_name, event_title, event_slug, description, posting_date.

### 7. job_vacancy
- Stores job vacancy postings.
- Fields: id, company_name, job_title, job_slug, description, posting_date.

### 8. feedback
- Stores feedback and suggestions from users.
- Fields: id, user_id, criticism, suggestion, posting_date.

### 9. testimonial
- Stores testimonials from users.
- Fields: id, user_id, testimonial, is_displayed.

### 10. profession_reference
- Reference table for professions.
- Fields: id, profession_name.

### 11. year_reference
- Reference table for years.
- Fields: id, reference_year.

### 12. login_attempts
- Tracks login attempts for security monitoring.
- Fields: id, ip_address, login, time.

### 13. departments
- Stores department information.
- Fields: id, name, description, coordinator_id (foreign key to users.id), timestamps.

### 14. program_kerja
- Stores program kerja details per department.
- Fields: id, department_id (foreign key), name, description, start_date, end_date, location, budget, status (planned/in_progress/completed), progress_percentage, current_progress, timestamps.

### 15. program_kerja_updates
- Stores progress updates for program kerja.
- Fields: id, program_kerja_id (foreign key), update_description, percentage_complete, document_path, update_date, timestamps.

### 16. user_department
- Many-to-many relationship between users and departments.
- Fields: id, user_id, department_id, role_in_department (coordinator/member), timestamps.

## Relationships
- users to profile: One-to-one (user_id foreign key).
- users to alumni_status: One-to-many (user_id foreign key).
- users to feedback: One-to-many (user_id foreign key).
- users to testimonial: One-to-many (user_id foreign key).
- users to users_groups: One-to-many (user_id foreign key).
- groups to users_groups: One-to-many (group_id foreign key).
- departments to program_kerja: One-to-many (department_id foreign key).
- program_kerja to program_kerja_updates: One-to-many (program_kerja_id foreign key).
- users to departments: Many-to-many via user_department table.

## Notes
- Primary keys are defined for all tables.
- Foreign key constraints enforce referential integrity.
- Auto-increment is used for primary keys where applicable.
- Charset and collation settings are set appropriately for text fields.

This design supports user management, alumni tracking, event and job vacancy management, feedback and testimonials, security features, department management, program kerja tracking, and progress reporting.
