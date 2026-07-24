# Project Documentary: Role-Based URL Shortener and Invitation System

## 1. Project Overview

This project is a Laravel-based web application designed to manage organizations, users, invitations, and short URL generation in a role-based environment.

The application supports three main roles:

- **SuperAdmin**
- **Admin**
- **Member**

Each role has a different level of access and responsibility. The system is structured so that:

- SuperAdmin can create new companies and invite an Admin for them.
- Admin can invite team members inside the same company.
- Member can create and view their own short URLs.
- Every short URL redirects publicly through a generated short code.

This makes the project suitable for a multi-tenant workflow where multiple client companies can be managed inside one platform.

## 2. Main Objective

The main purpose of the project is to provide:

- Company onboarding through invitations
- Role-based user access
- Short URL creation and tracking
- Public redirection using short links
- Dashboard views based on user role

In simple terms, the application allows an organization to create a company, invite users, and generate short URLs while keeping data separated by company and user ownership.

## 3. Technology Stack

The project is built with the following stack:

- **Backend:** Laravel 13
- **Language:** PHP 8.3
- **Frontend:** Blade templates, Alpine.js, custom CSS, Vite
- **Database layer:** Laravel migrations, Eloquent models, and query builder
- **Testing:** Pest / Laravel Feature tests

This combination gives the project a clean MVC structure and keeps the code easy to maintain.

## 4. Application Architecture

The application follows the standard Laravel MVC pattern:

- **Models** represent the database entities.
- **Controllers** contain the business logic.
- **Views** display the UI.
- **Routes** define the application endpoints.
- **Migrations** define the database structure.
- **Tests** verify important behavior.

### Key Models

- `User`
- `Company`
- `Url`

### Key Controllers

- `DashboardController`
- `InvitationController`
- `UrlController`
- `ProfileController`

### Supporting Middleware

- `RoleMiddleware`

## 5. Database Design

The project uses four main tables:

### `companies`

Stores company records.

Fields:

- `id`
- `name`
- `created_at`
- `updated_at`

### `users`

Stores application users.

Custom fields added to the default Laravel user table:

- `company_id`
- `role`

This allows each user to belong to a company and have a specific access level.

### `urls`

Stores shortened links.

Fields:

- `id`
- `company_id`
- `user_id`
- `original_url`
- `short_code`
- `created_at`
- `updated_at`

### `invitations`

Stores invitation records for onboarding users or clients.

Fields:

- `id`
- `company_id`
- `email`
- `role`
- `token`
- `status`
- `created_by`
- `created_at`
- `updated_at`

## 6. Role-Based Flow

### SuperAdmin Flow

The SuperAdmin is the highest-level user in the system.

What SuperAdmin can do:

- View all companies
- View all short URLs across the platform
- Create a new company
- Send an invitation to an Admin for that company
- View all invitations

What SuperAdmin cannot do:

- Create a short URL directly, because URL generation is restricted to company-level users

### Admin Flow

Admin belongs to a company and manages users inside that company.

What Admin can do:

- View team members of the same company
- View short URLs created in the same company
- Invite a new Admin or Member within the same company
- Generate short URLs

### Member Flow

Member is a regular company user.

What Member can do:

- View only their own short URLs
- Generate a short URL
- Use the public redirect link

## 7. Authentication and Invitation Process

The application uses Laravel authentication for login and registration.

### Invitation Creation

When a SuperAdmin or Admin sends an invitation:

- A unique token is generated using `uniqid()`
- The invitation is stored in the `invitations` table
- The status is set to `Pending`
- A shareable invite link is produced in the form:

`/invite/accept/{token}`

### Invitation Acceptance

When the invited user opens the invite link:

- The system checks whether the token exists and is still pending
- The registration form is displayed with the invited email pre-filled
- The user must register using the same email address
- After successful registration:
  - A new `User` record is created
  - The invitation status changes to `Accepted`
  - The user is logged in automatically
  - The user is redirected to the dashboard

This ensures invitation integrity and prevents someone else from using the invitation email.

## 8. URL Shortening Flow

The URL module is the core feature of the application.

### Short URL Creation

When a permitted user creates a short URL:

- A random 6-character code is generated using `Str::random(6)`
- The system checks for collisions to ensure the code is unique
- A URL record is inserted into the database
- The original URL is currently set to `https://example.com`
- The generated short URL is returned in the form:

`/u/{short_code}`

### URL Redirection

When someone visits the short link:

- The application looks up the matching `short_code`
- If found, it redirects the browser to the stored `original_url`
- If not found, it returns a 404 error

This makes the short link publicly accessible without requiring login.

## 9. Dashboard Logic

The dashboard is role-aware and changes based on the logged-in user.

### SuperAdmin Dashboard

Shows:

- Total client companies
- Total short URLs
- List of companies with user counts
- All URLs from every company

### Admin Dashboard

Shows:

- Total short URLs in the company
- Team members in the company
- URLs created by company users

### Member Dashboard

Shows:

- Their own short URLs
- Their role

The dashboard gives each role a focused view of the data they are allowed to see.

## 10. Security and Access Control

The project uses a combination of route middleware and manual role checks.

### Auth Middleware

Most sensitive routes are protected with `auth`, which means only logged-in users can access them.

### Role Checks

Controllers check the logged-in user's role to determine:

- Whether a page can be accessed
- Which records can be viewed
- Whether a short URL can be created
- Whether an invitation form should show a company field

### RoleMiddleware

There is also a `RoleMiddleware` that blocks access unless the user is a SuperAdmin.

## 11. Views and UI Structure

The front end is built with Blade templates and follows a simple dashboard-oriented layout.

### Important Pages

- `dashboard.blade.php`
- `url.blade.php`
- `invite.blade.php`
- `auth/register.blade.php`

### User Experience

The UI is organized into panels and tables:

- Summary cards for counts
- Tables for URLs, invitations, clients, and team members
- Forms for invite and URL generation
- A responsive Blade-based layout

The interface is intentionally straightforward so users can understand the workflow quickly.

## 12. Testing Strategy

The project includes feature tests to validate the most important rules.

### Invitation Tests

The tests confirm that:

- SuperAdmin can create a company and invite an Admin
- Admin can invite a Member inside the same company

### URL Permission Tests

The tests confirm that:

- Admin can create short URLs
- Member can create short URLs
- SuperAdmin cannot create short URLs
- SuperAdmin can see all URLs
- Admin can only see company URLs
- Member can only see their own URLs
- Public short URLs redirect correctly

These tests are important because the business rules depend heavily on role-based access.

## 13. Project Workflow Summary

The overall workflow of the application is:

1. A SuperAdmin creates a company invitation.
2. The invited Admin accepts the invitation and registers.
3. The Admin logs in and manages company members.
4. Team members create short URLs.
5. Users and admins view URLs from their permitted scope.
6. Anyone can use the generated short link to reach the original URL.

## 14. What I Built and Why

If I were explaining this project to a senior, I would describe it like this:

> I built a Laravel application that supports company-based user management and role-based access control. The system lets a SuperAdmin onboard new companies, lets Admins manage their own company users, and lets Members generate short URLs. I structured the app with clear MVC separation, database migrations for company isolation, invitation tokens for secure onboarding, and feature tests to protect the permission rules.

## 15. Strengths of the Project

- Clean Laravel structure
- Role-based separation of access
- Invitation-based onboarding
- Public short-link redirection
- Company-wise and user-wise data ownership
- Automated tests for critical behavior

## 16. Limitations / Current Notes

There are a few implementation details worth mentioning honestly if asked in review:

- The original URL is currently hardcoded to `https://example.com` in `UrlController`.
- The project uses manual role checks in controllers instead of centralized policies everywhere.
- Some migrations define foreign IDs without explicit foreign key constraints.

These are not blockers, but they are good improvement points for future refinement.

## 17. Future Improvements

Possible future enhancements:

- Allow users to enter the original URL manually
- Add validation for URL format
- Add foreign key constraints for stronger database integrity
- Add edit/delete functionality for URLs
- Add invitation expiry
- Add email notifications for invitation links
- Add analytics for short URL clicks
- Replace hardcoded role strings with constants or enums

## 18. Conclusion

This project is a role-based Laravel application that combines company management, invitation handling, and URL shortening into one system. It demonstrates authentication, authorization, relational data modeling, public redirection, and test-driven validation of business rules.

For a senior-level explanation, the strongest points to emphasize are:

- the company-user-role hierarchy
- the invitation-based onboarding flow
- the separation of URL visibility by role
- the public short-code redirect mechanism
- the tests that protect access rules

If needed, this documentary can also be turned into:

- a presentation script
- a project viva explanation
- a README-style summary
- a resume/project portfolio description
