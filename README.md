## Laboratory Information Indexing System

- **JORS DOI**: [10.5334/jors.aj](http://dx.doi.org/10.5334/jors.aj)
- **Figshare DOI**: [10.6084/m9.figshare.780836](http://dx.doi.org/10.6084/m9.figshare.780836)


#### About

A Mini-LIMS for Culture Collection and Sample Annotations.
LIIS is an open source, web based, metadata database for storage and archival use.

Created at the **Lethbridge Research Center** in cooperation with the **Lethbridge College** and the **University of Lethbridge**, this is a student designed project.

For detailed* Doxygen class documentation, see the refman/ folder.

*Will be expanded in the future

#### Installation

LIIS requires a webserver with rewrite capability. The application was created on an Apache2 webserver and has .htaccess files included in the directories. Because many web servers have unique setups and security preferences, there is no wizard included to install the website. Editing some base options and files is required to have the LIIS work. If you have any questions, contact the developer.

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

1. Ensure .htaccess is allowed in the appropriate directory (Apache `AllowOverride` option). The .htaccess must be able to run in the root directory of the LIIS. This setting is typically found either in `httpd.conf` or `sites-available/default`.
2. Ensure the rewrite module is enabled in your webserver preferences (Apache `a2enmod rewrite`.)
3. Ensure MySQLi driver is enabled within the PHP settings. (Check your php.ini for `extension=mysqli.so` or similar.)
4. Download and move the website files into the hosted directory.
5. **Special Write permissions** are required for the `resources/download` and `resources/upload` directories, to ensure that the export and picture functions operate properly. Popular permissions for these folders are 775 for the appropriate Apache and PHP/FTP users. Changing the group of these folders to the webserver group (Apache `www-data`) may be necessary. 
6. Open `install.php` and `application/config/database.php` within a text editor. Change the appropriate settings (MySQL user/password) to allow codeigniter to connect to MySQL. Make sure to change both the data and user database settings in database.php.
7. **If installing in a subdirectory of the hosted folder:** Open `application/config/config.php` in a text editor. Edit the `base_url` setting to reflect the codeigniter root (ex. if installing the LIIS in `/var/www/LIIS`, then `base_url` should be '/LIIS/'). 
8. In your browser, open `(website_root)/install.php` to install the database. If an error is shown, look over your MySQL settings and the two files in step 5 to ensure connectivity.
9. Log in to the user management with the user and password provided after successful database installation.

#### Contributors

* **Current Developers:**

	**Matt Forster ([@forstermatth][1] [forster.matth@gmail.com][2])**
	
* **Past Development:**
	
	**Lethbridge Research Center, in cooperation with University of Lethbridge**
	* Matt Forster, Robert Forster, Lyn Paterson
	* Summer, 2013

	**Lethbridge College**
	* Matt Forster, David Sinclaire, Andrew Sanders, Graham Fluet
	* Computer Information Technology, Lethbridge College, 2013.

[1]: https://twitter.com/forstermatth
[2]: mailto:forster.matth@gmail.com
