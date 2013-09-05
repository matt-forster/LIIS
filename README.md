## Laboratory Information Indexing System

- **JORS DOI**: (unassigned)
- **Figshare DOI**: [10.6084/m9.figshare.780836](http://dx.doi.org/10.6084/m9.figshare.780836)


#### About

A Mini-LIMS for Culture Collection and Sample Annotations.
LIIS is an open source, web based, metadata database for storage and archival use.

Created at the **Lethbridge Research Center** in cooperation with the **Lethbridge College** and the **University of Lethbridge**, this is a student designed project.


#### Installation

LIIS requires a webserver with rewrite capability. The application was created on an Apache2 webserver and has .htaccess files included in the directories.

**Dependencies**:
- Not Included:
	* Apache 2.2+ (or equivalent) 	([Apache](http://httpd.apache.org/)) 
	* PHP 5.3+ 			([PHP](http://php.net/))
	* MySQL 5.5 			([MySQL](http://www.mysql.com/))
- Included:
	* CodeIgniter 2.1.4 		([EllisLab](https://github.com/EllisLab/CodeIgniter))
	* Parsedown 0.1.3 		([Emanuil Rusev](https://github.com/erusev/parsedown))
	* Twitter Bootstrap 2.3.2 	([Twitter](https://github.com/twbs/bootstrap))
	* jQuery 1.8.3 			([jQuery](https://github.com/jquery/jquery))

Once a proper server has been setup with a webserver, MySQL, PHP:

1. Ensure .htaccess is allowed in the appropriate directory (AllowOverride)
2. Ensure the rewrite module is enabled in your webserver preferences
3. Download and move the website files into the hosted directory
4. **Special Write permissions** are required for the `resources/download` and `resources/upload` directories, to ensure that the export and picture functions operate properly. Popular permissions for these folders are 775 for the appropriate Apache and PHP/FTP users.
5. Open `install.php` and `application/config/database.php`. Change the appropriate settings to allow codeigniter to connect to MySQL. Make sure to change both the data and user database settings in database.php.
6. Browse to `(website_root)/install.php` to install the database. If an error is shown, look over your MySQL settings to ensure connectivity.
7. Log in to the user management with the user and password provided after successful database installation.

#### Contributors

* **Current Developers:**

	**Matt Forster ([@forstermatth][1])**

	* (under supervision of Tim McAllister, Bob Forster)
	* Lethbridge Research Center, University of Lethbridge Co-Op, 2013.
	
* **Alpha Development:**

	**Align Systems Design**

	* (Matt Forster, David Sinclaire, Andrew Sanders, Graham Fluet)
	* Computer Information Technology, Lethbridge College, 2013.

[1]: https://twitter.com/forstermatth
