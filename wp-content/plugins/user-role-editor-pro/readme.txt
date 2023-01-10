=== User Role Editor Pro ===
Contributors: Vladimir Garagulya (https://www.role-editor.com)
Tags: user, role, editor, security, access, permission, capability
Requires at least: 4.4
Tested up to: 5.6
Stable tag: 4.58.2
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

User Role Editor Pro WordPress plugin makes user roles and capabilities changing easy. Edit/add/delete WordPress user roles and capabilities.

== Description ==

User Role Editor Pro WordPress plugin allows you to change user roles and capabilities easy.
Just turn on check boxes of capabilities you wish to add to the selected role and click "Update" button to save your changes. That's done. 
Add new roles and customize its capabilities according to your needs, from scratch of as a copy of other existing role. 
Unnecessary self-made role can be deleted if there are no users whom such role is assigned.
Role assigned every new created user by default may be changed too.
Capabilities could be assigned on per user basis. Multiple roles could be assigned to user simultaneously.
You can add new capabilities and remove unnecessary capabilities which could be left from uninstalled plugins.
Multi-site support is provided.

== Installation ==

Installation procedure:

1. Deactivate plugin if you have the previous version installed.
2. Extract "user-role-editor-pro.zip" archive content to the "/wp-content/plugins/user-role-editor-pro" directory.
3. Activate "User Role Editor Pro" plugin via 'Plugins' menu in WordPress admin menu. 
4. Go to the "Settings"-"User Role Editor" and adjust plugin options according to your needs. For WordPress multisite URE options page is located under Network Admin Settings menu.
5. Go to the "Users"-"User Role Editor" menu item and change WordPress roles and capabilities according to your needs.

In case you have a free version of User Role Editor installed: 
Pro version includes its own copy of a free version (or the core of a User Role Editor). So you should deactivate free version and can remove it before installing of a Pro version. 
The only thing that you should remember is that both versions (free and Pro) use the same place to store their settings data. 
So if you delete free version via WordPress Plugins Delete link, plugin will delete automatically its settings data. Changes made to the roles will stay unchanged.
You will have to configure lost part of the settings at the User Role Editor Pro Settings page again after that.
Right decision in this case is to delete free version folder (user-role-editor) after deactivation via FTP, not via WordPress.

== Changelog ==

= [4.58.2] 14.12.2020 =
* Core version 4.57.1
* New: Admin menu access add-on: 'ure_admin_menu_get_hashes' custom filter was added (pro/includes/classes/admin_menu.php, line #105). URE uses internally the full list of the links included into admin menu. Use this filter to modify it, in case you know what you do.
* New: German Formal (de_DE_formal) translation was added.
* Fix: PHP Warning:  The magic method __wakeup() must have public visibility. __wakeup() method was defined as private as a part of the Singleton design partern. Method was redefined as public but with exception inside to prevent its usage.
* Update: jQuery [MultiSelect](http://multiple-select.wenzhixin.net.cn/) plugin was updated to version 1.5.2
* Core version was updated to 4.57.1
* Fix: Nextgen Gallery's user capabilities were not shown as granted after current role change via roles selection dropdown list.

= [4.58.1] 30.11.2020 =
* Core version 4.57
* Fix: Error message was fixed: Uncaught Error: Object of class stdClass could not be converted to string in /wp-content/plugins/user-role-editor-pro/pro/includes/classes/posts-edit-access-user.php:653

= [4.58] 23.11.2020 =
* Core version 4.57
* Update: Marked as compatible with WordPress 5.6.
* Update: " jQuery( document ).ready( handler ) " was replaced globally with " jQuery( handler ) " for compatibility with [jQuery 3.0](https://api.jquery.com/ready/) and WordPress 5.6.
* Update: Post edit access add-on: 
* - Special support was added for the [FooGallery plugin](https://wordpress.org/plugins/foogallery/). Earlier new album, edit album pages showed full list of galleries in spite of the edit restrictions set by URE Pro. URE Pro uses 'foogallery_album_exlcuded_galleries' filter to fix this.
* - SQL queries are restricted by post type (if known) instead of scan full posts database table.
* Core version was updated to 4.57:
* Fix: "Grant Roles" button produced JavaScript error, if single user without any role granted (None) was selected.


Full list of changes is available in changelog.txt file.
