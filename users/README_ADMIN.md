# CollegeFinder - Admin Panel

## Overview
The admin panel provides a simple and intuitive interface for managing college applications submitted by users and maintaining the college and scholarship databases. As an administrator, you can view all applications, update their status, provide rejection reasons when necessary, and manage the lists of colleges and scholarships in the system.

## Features
- **Dashboard Overview**: View at-a-glance statistics of all applications and their statuses
- **Application Management**: See all applications in a sortable and searchable table
- **Detailed View**: Click on any application to view complete details
- **Status Updates**: Change application status (Pending, Under Review, Accepted, Waitlisted, or Rejected)
- **Rejection Reasons**: Provide explanations when rejecting applications
- **College Management**: Add, edit, and delete colleges in the database
- **Scholarship Management**: Add, edit, and delete scholarships in the database

## Getting Started
1. Log in with an admin account (role must be set to 'admin' in the users table)
2. You will be automatically redirected to the admin panel
3. The admin panel is located at: `/users/admin-panel.php`
4. The college management page is at: `/users/college-management.php`
5. The scholarship management page is at: `/users/scholarship-management.php`

## Accessing Admin Panel
To access the admin panel, you need:
1. A user account with 'admin' role in the database
2. Run the `schema/add_role_to_users.sql` script to add the role column if it doesn't exist
3. The first user (ID = 1) will automatically be set as an admin

## Using the Admin Panel
1. **Viewing Applications**: All applications are displayed in the table
2. **Filtering**: Use the search box to filter by applicant name
3. **Status Filter**: Use the dropdown to filter applications by status
4. **View Details**: Click the eye icon to view complete application details
5. **Update Status**: Select the new status from the dropdown and submit the form
6. **Rejection Reasons**: When selecting "Rejected" status, provide a reason that will be visible to the applicant

## Managing Colleges
1. **Access College Management**: Click on "Manage Colleges" in the user dropdown
2. **View All Colleges**: See all colleges in a searchable table
3. **Add New College**: Click "Add New College" and fill out the form
4. **Edit College**: Click the edit icon next to any college to modify its details
5. **Delete College**: Click the delete icon to remove a college (only possible if no applications exist for that college)
6. **Search Colleges**: Use the search box to find specific colleges by name, location, or category

## Managing Scholarships
1. **Access Scholarship Management**: Click on "Manage Scholarships" in the user dropdown
2. **View All Scholarships**: See all scholarships in a searchable table with deadlines highlighted
3. **Add New Scholarship**: Click "Add New Scholarship" and fill out the form
4. **Edit Scholarship**: Click the edit icon next to any scholarship to modify its details
5. **Delete Scholarship**: Click the delete icon to remove a scholarship (only possible if no applications exist)
6. **Search Scholarships**: Use the search box to find specific scholarships by name, organization, or category
7. **Deadline Monitoring**: Scholarships are color-coded by deadline status (expired, near deadline, upcoming)

## Database Updates
The admin panel requires the following database updates:
1. The `role` column in the `users` table
2. The `rejection_reason` column in the `college_applications` table

SQL scripts are included in the schema directory:
- `add_role_to_users.sql`
- `add_rejection_reason.sql`

Import these scripts through phpMyAdmin or run them directly against your MySQL database.

## Security Note
This is a simple implementation focused on functionality. For production use, you should:
1. Implement proper authentication and authorization
2. Add CSRF protection for forms
3. Validate and sanitize all input data
4. Consider implementing activity logging 