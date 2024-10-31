=== osTicket WP Bridge ===

Contributors: michaelbo
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WVQF2N43FBHDN
Tags: helpdesk, support, tickets, contact, osticket, bridge, email
Requires at least: 3.1
Tested up to: 3.8.1
Stable tag: 1.9.2
License: GPLv3

Integrate osTicket into your wordpress site with our easy to use osTicket WP Bridge plugin.

== Description ==

This is a new plugin, designed from the ground up to bridge osTicket & Wordpress. 

I needed a support ticket system plugin for a site i was building and try most of the plugins on wordpress, I just couldn't get them to work, so i decided to create a bridge for my clients current ticket system. After doing this I thought maybe someone else could use it also.

Old -> osTicket-WP-Bridge will email you and the client when new tickets and post replies are created, answer the tickets in the osTicket admin area as you normally would.

New -> In osTicket-WP-Bridge v1.9.2 you can now view tickets and post a reply in wordpress dashboard, no need to login to the admin area of osTicket to answer tickets.

I received a lot of emails on creating these functions in the wordpress admin area, so i did and some features that osTicket didn't have, just to make it easier.

I will be adding more functions & features down the line to make it better for all, as you can see in my change log versions.

If there is something you would like to see in the next version, please let me know.

For Support/Qustions: http://a1-9.com/forums/
osTicket Bridge Demo: http://osticket-wp-bridge.a1-9.com/

== Installation ==

1. Install osticket-wp-bridge folder to the /wp-content/plugins/ directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Plugin settings are located in Dashboard-->osTicket-->osT-Config
4. Plugin settings are located in Dashboard-->osTicket-->osT-Settings
5. Plugin settings are located in Dashboard-->osTicket-->Email Templates

== Frequently Asked Questions ==

= Where does the osTicket need to be Installed? =
Create any folder in your wordpress directory & upload osTicket: (example: wordpress/osticket)

= What version of osTicket can i use? =
osTicket (v1.8.1) (Stable Release Only)
osTicket (v1.7.0) (v1.7.1.4) (v1.7.4) (Stable Releases)

= Where can I download the tested osTicket versions? =
Stable Release - (v1.8.1)
http://osticket.com/download

Stable Releases - (v1.7.0) (v1.7.1.4) (v1.7.4)
https://github.com/osTicket/osTicket-1.7/releases

= Why does the welcome page not displaying right? =
Each theme is differant, you can open the (page.php) file in the theme folder and copy the header/footer part (not the content statement) into the header and footer files located in the (osticket-wp-bridge/templates/) folder. These two files will have instructions.

You can also adjust the (style.css) file located in (osticket-wp-bridge/css/) folder. At the top look for (#ost_container) set the margin: 20px 20px 20px 20px; to your needs. 

== Upgrade Notice ==

I will only upgrade to stable released versions of osTicket!
I will be adding more functions & features to osTicket WP Bridge!

== Screenshots ==

1. Wordpress Dashboard-->osTicket-->osT-Config
2. Opening page for the support/helpdeck page
3. Opening page for submitting a ticket
4. Open tickets page
5. Telling the client they have the maximum amount open (if set)
6. Login, Register & Forgot password page (new)

== Changelog ==

= 1.9.2 =
* Added: GPLv3 License, now in plugin folder
* Added: Dashboard osTicket
* Added: Dashboard osT-Settings, Online/Offline/Helptitle/Max Open Tickets/Email
* Added: Dashboard Email Templates, New Ticket Confirmation/Post Reply
* Added: Dashboard Support Tickets, View Tickets/Post Reply/Open/Close
* Added: Seperate version data files for 1.7+ & 1.8.1
* Added: New Database tables for email templates
* Updated: Login/Register/Forgot Password Page - Contributor: (artthompson) Thanks for all your help!

= 1.8.9 =
* Added: 1 new file for osTicket (v1.8.0.2)
* Updated: Admin settings to switch from (1.7) to (1.8) version of osTicket
* Updated: All core files & template files for osTicket (v1.8.0.2) 

= 1.8.7 =
* Fixed: osticket-wp.php file with sql error
* Fixed: Online/Offline status
* Updated: Search template page

= 1.8.4 =
* Added: New admin menu with more features to update osTicket database


= 1.8.2 =
* Updated: Database error when communicating with osTicket in wordpress admin
* Updated: Readme text file
* Updated: Main osticket-wp.php file for new changes in the version 

= 1.8.0 =
* Updated: Wordpress approved & added to plugin repository for public use
* Added: New version number list in changelog to be more accurate for furture updates
* Added: Screenshots to the wordpress plugin page
* Updated: FAQ on wordpress plugin page
* Updated: Minor updates to style.css file
* Added: Font style to password input to work with IE8

= 1.7.0 =
* Added: Separate titles to page templates
* Added: Login/registration & forgot password page
* Added: Logout to nav bar
* Updated: Minor cosmetic updates to style.css file

= 1.6.0 =
* Updated: To work with Wordpress 3.8.1 (re-styled buttons)
* Updated: Minor cosmetic updates to style.css file for Chrome & Firefox

= 1.5.0 =
* Added: Includes/folder to make it easier for more features & functions
* Updated: Welcome/home page to include osTicket "Helpdesk Name/Title" in the Welcome statement

= 1.4.0 =
* Added: Page templates/folder to make it easier for more features & functions
* Added: New form fields empty validation script

= 1.3.0 =
* Added: Data function for (Maximum Open Tickets)
* Added: Class Format function stripslashes from text area in tickets

= 1.2.0 =
* Added: Open & close check field to ticket thread so the client can reopen/close a ticket
* Fixed: database error when communicating with osTicket v1.7.4 data for user information

= 1.1.0 =
* Added: Email function for new tickets & post replies

= 1.0.1 =
* Created: Initial Release on my site (osticket-wp-bridge.a1-9.com)