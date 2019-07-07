# October WordPress Plugin Class

A PHP class designed to speed up the development of WordPress plugins 
by providing all the base functionality required for a plugin.
Plugins can then be built from a class that extends this class.

See source code for documentation.

Change log:

v0.05
Released: 7 Jul 2019
- Added cleaning to imported CSV file field names to improve compatibility with MySQL
- Added support to display and save WP Settings on the admin pages
- Added support to easily create custom widgets
- Added display_modified key/value pair to provide custom display of the list table modified field
- Added sendEmail() to send an email to any user. Requires user id, subject and text
- Added sendAdminEmail() to send an email to the site admin. Requires subject and text
- Added sendLoginEmail() to send an email to site admin when any user logs in.
- Added custom_drop rendering to custom fields of custom posts on the admin screen
- Added custom type to custom fields of custom posts, to allow users to define their own render and save functions
- Added ability to define a list of options to database fields displayed as a drop box in Edit and Add New screen
- Fixed various bugs when displaying List Tables
- Added pagination to List Tables. Override $perPage property to change number of items per page.
- Added ability to link record in one table to one or more records in another table (relation)
- Added ability to include a field description to be show on Custom Database Edit and Add New screens
- Changed db_get to define fields, Added ability to define specific fields to return with db_get()
- Fixed bug with display list table filters (line ~1182)
- Added ability to include user capabilities restrictions to database menu and submenu items 
  (line ~1599,~1603, ~1631, ~1637)
- Fixed a bug where meta box ids weren't always unique (line ~2049)
- Added ability to include a 'save' callback on custom fields (lines ~2070-2077)
- Fixed a bug with custom meta box element labels (line ~2110)

v0.04
Released: 15 Feb 2019
- Added documentation and examples to better explain admin menus
- Fixed a bug where the list table would not filter on a column
- Added support to import CSV file data into custom db
- Added to edit/new screen: separators, prefix, suffix, DECIMAL field type
- Added support for hidden columns in List Tables
- A system to retrieve Critical Data from another url for security reasons
- Hides the admin toolbar on the front end, either for all users or just non-admins
- Added initial and limited support to ease the use of WP_List_Table class
- Added support to create custom MySQL tables with support for writing and reading data (Dec 2018)
- Fixed bug where checkbox (boolean) meta data was not being saved if checkbox was not selected

v0.03
Released: 29 Nov 2018
- Fixed a bug when rendering Admin meta boxes for custom fields
- Streamlined shortcodes and added extra debugging and error checking
- Added boolean field type to custom post admin menu page; shows as checkbox
- Added add_bp_member_submenu() which adds a submenu to the Buddypress user profile page
- Updated in-file documentation

v0.02
Released: 21 Sep 2018
- Added support for creating Custom Post Types
- Added support for creating Custom Taxonomies
- Added support for creating Custom Field Types
- Updated in-file documentation

v0.01
Released: 17 Aug 2018
Initial release
