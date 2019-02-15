# October WordPress Plugin Class

A PHP class designed to speed up the development of WordPress plugins 
by providing all the base functionality required for a plugin.
Plugins can then be built from a class that extends this class.

See source code for documentation.

Change log:

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
