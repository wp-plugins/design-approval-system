=== Design Approval System ===
Contributors: slickremix
Tags: designer email, project, project board, login, user login, client login, password, username, SMTP, sendmail, authenticate, authenticate username, authenticate password, approval, design approval system, posts, Post, admin, image, images, imaging, page, comments, plugin, designers, designs, design, clients, client, slick remix, slick, remix, freelancer, graphic artists, freelancers, graphic designers, graphics, video, flash, show off, organize designs, organize, logo designers, photography,  wordpress plugin, proof, proofing, proofing software, system, wordpress, wordpress code, workflow, online, virtual, configurable, customizable, settings, email confirmation, links, stars, save comments, database, save digital signature, work flow, multi language, woocommerce, shopping cart, woo, commerce
Requires at least: 3.5.0
Tested up to: 4.2.1
Stable tag: 4.0.6
License: GPLv2 or later

A system to streamline the process of getting designs, photos, documents, videos, or music approved by clients quickly.

== Description ==
See [Live Example](http://www.slickremix.com/testblog/designs/idriveeurope-about-page-v1/) and Approve the design.

Now works on MultiSite Installs! See [full documentation](http://www.slickremix.com/design-approval-system-docs/). Approved designs get a STAR on the Project Board, and Clients signature is recorded to the database. Check out the [Project Board](http://www.slickremix.com/docs/how-to-setup-the-project-board). Clients, projects, & designs are organized on one page + Clients can login to see there designs! View [Project Board](http://www.slickremix.com/project-board/). 

NOTE: We realize the videos show outdated wordpress admin areas and we will be making updates soon. But rest assured our plugin still works and is even better now than the videos portray, however they are still informative to see quickly how our system works. That is the reason they are still here. Even better we do have a nice walkthrough when you activate our plugin to help you get setup quickly.

Here's a quick look at our [Design Approval System](http://youtu.be/1CtzTrPuc1A): 
[youtube http://www.youtube.com/watch?v=1CtzTrPuc1A]

View the full tutorial about our [DAS plugin and Client Changes Extension](http://youtu.be/pYdF2OJCOv4): 
[youtube http://www.youtube.com/watch?v=pYdF2OJCOv4]

Here is what you, the clients, and the plugin can do:

= YOU (THE DESIGNER) CAN… =
  * With the click of a button you can send the design’s review link to a client for approval. (An automatic confirmation email will be sent to both parties.)
  * Change the text in all automatic confirmation emails.
  * Display your company logo.
  * Display “Designer” notes for the client to read.
  * Display project start and end date.
  * Display ”Client” notes to assure the client you have completed all the things they have requested.
  * …and more.

 = THE CLIENT CAN… =
  * Approve designs. (An automatic email confirmation will be sent to both parties.)
  * See project start and end date.
  * See “Designer” notes.
  * See “Client” notes to double check the designer has completed all the things they have requested.
  * …and more.

= THE PLUGIN CAN… =
  * Send automatic confirmation emails.
  * Shows a STAR on approved Designs on the Project Board.
  * Adds clients approved signature to the database and can be view in the details area of design on the Project Board.
  * Display a versions menu to show previous versions of a design.
  * Hide notes to show just the design on the design review page. (Especially nice for web designers wanting to show what a design will look like on a page.)
  * Show you a list of all of your clients and projects! (Project Board page) 
  * …and more.
  
= SUPPORT FORUM =
  * Having problems, or possibly looking to extend our plugin to fit your needs? You can find answers to your questions or drop us a line at our [Support Forum](http://www.slickremix.com/support-forum/). 

= THEMES AND EXTENSIONS =
  [Click here to view them all.](http://www.slickremix.com/downloads/category/design-approval-system/)
  
  If you would like to contribute in translating please [visit us here](http://glotpress.slickremix.com/projects).
   
== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

== Change-log ==
= Version 4.0.6 / Wednesday February 4th, 2015 =
 * FIXED: Edit and Send Email link from showing when Das Client is logged in. Now only admin and Das Designers will be able to see those links. 
 * ADDED: CSS adjustments for design approval template.
 
= Version 4.0.5 / January 20th, 2015 =
 * FIXED: Major php bug for users who did not have magic quotes turned on in a php.ini file. Now templates, project board and forms all work as they should.

= Version 4.0.4 / December 30th, 2014 =
 * FIXED: CSS bug in default template. Now looks proper on mobile and tablet devices. [Example](http://www.slickremix.com/testblog/designs/idriveeurope-about-page-v1/)

= Version 4.0.3 / December 20th, 2014 =
 * NEW: DAS Now works with Multisite Installs. IMPORTANT! Do not network active. To make this work you must activate each install you want on each subsite you create for your multisite install.
 * FIXED DEFAULT TEMPLATE: Edit and Send Email links showing when DAS Clients are logged in, they now do not.
 * FIXED: CSS bug on the default template for design notes.
 * Happy Holidays from all of us at SlickRemix!

= Version 4.0.2 / December 12th, 2014 =
 * FIXED: Faster wp-admin loading now

= Version 4.0.1 / December 3rd, 2014 =
 * NEW: Admin menu icon
 * FIXED: Shorthand php tag in das-meta-box.php on line 386
 * REMOVED: Stray testing submit button at the bottom of settings page
 
= Version 4.0.0 / September 11th, 2014 =
 * ADDED: SSL/TLS select option on the settings page. Users with Client Changes plugin will want to upgrade that too in order for the new option to take effect. Visit your My Account page or if you have entered you license key you should get an update notice.
 * ADDED: es_ES Spanish mo and po files added. Translation Courtesy: Andrew Kurtis. [WebHostingHub](http://www.webhostinghub.com/)
 
= Version 3.8.9 / August 25th, 2014 =
 * ADDED BACK: By popular demand clients do not have to login to approve or make changes. You can view these new options on the das settings page. If you have the client changes extension an option for not requiring login will appear as well.
 * ADDED: Additional notes on first tour pointer about using the free duplicate post plugin to make the task of creating version easier for clients.
 * FIXED: Removed general function name from wp pointer that was causing a conflict with another theme using the same function name.
 * EDITS: Admins and Designers can see the Private Project Board on the front end.
 * EDITS: Additional front end Project Board CSS fixes to override themes h1, p, ul tags etc.
 * EDITS: Default template CSS.
 
= Version 3.8.8 / August 13th, 2014 =
 * IMPORTANT: Make sure you have all the most recent updates for your premium plugins before updating. You can find your plugins in the my account area of slickremix.com [http://slickremix.com/my-account](http://slickremix.com/my-account)
 * EDITS: Front end Project Board CSS fixes.
 * EDITS: New custom string for login on the Default Template.
 * EDITS: Only allow Admins to view or restart the tutorial.

= Version 3.8.7 / Saturday August 9th, 2014 =
 * IMPORTANT: Make sure you have all the most recent updates for your premium plugins before updating. You can find your plugins in the my account area of slickremix.com [http://slickremix.com/my-account](http://slickremix.com/my-account)
 * NEW PREMIUM PLUGINS: Today marks the day we launch the GQ Theme/Template for DAS and the Woocommerce for DAS plugins. See our shop at slickremix.com.
 * ADDED: Additional functionality for the new WooCommerce for DAS plugin.
 * FIXED: Register settings options correctly.
 * FIXED: When deactivating or removing the plugin the user roles will be removed.
 * FIXED: Register settings options correctly.
 * EDITS: All php Notices when wp debug mode is on have been corrected.
 * EDITS: CSS tweaks to the Project Board.

= Version 3.8.6 / Wednesday July 30th, 2014 =
 * NEW: Language files for German and Portuguese. Add de_DE for German or pt_BR for Portuguese in your wp-config.php
 * NEW: Brand new walkthrough using wordpress pointers. You can retake the tour at any time by visiting the Help page in our DAS menu.
 * NEW: php5.3 check on the Help page. If you are not at least running php5.3 a notice will warn that you need to update.
 * FIXED: Plugin update notices
 * FIXED: flushrewrite for custom post type and taxonomy. Using proper method on activation now.
 * UPDATED: Removed the news, videos and re-take tour menu items and pages.
 * UPDATED: Project Board is now fully responsive, so it looks and works great on desktops, tablets and mobile devices and with different languages.
 * UPDATED: Previous users of the premium project board will need to update to our new plugin that combines both the public and private project board. Existing users will not have to pay for this upgrade.
 
= Version 3.8.5 / Thursday June 12th, 2014 =
 * FIXED: Single Template override wrong.
 * FIXED: Single Template path fixed.

= Version 3.8.4 / Wednesday June 11th, 2014 =
 * MUST READ: All premium plugin users must de-activate your das extensions before updating to this next version.
 * MUST HAVE: PHP 5.3 or above to run DAS and any extensions.
 * FIXED: Fatal Error on some installs.
 * FIXED: If you have the Premium Client Changes plugin the option for Paid or Not paid is now available under the 'Client Info' tab on a design post.
 * FIXED: wp-admin Project Board will now show all design posts to the DAS Client no matter what the amount of blog posts to be shown is set to in the reading settings wordpress menu. And breath :)
 * FIXED: Get more extensions links.
 * FIXED: CSS overhaul on the default template that fixes many elements to work with bootstrap or other themes using box-border.
 * FIXED: Default Template: we changed the logo db call in the settings page so you will have to resave the DAS settings page for your logo to appear again.
 * THANKS: Big up to Gordon and a few others for brining the fatal error to light and helping us debug for DAS and the Private Project Board premium plugin, which is set for a new update in the next day as well. Check out Gordon's site here. [http://www.webdesignperth.com.au/](http://www.webdesignperth.com.au/)

= Version 3.8.3 / Thursday June 5th, 2014 =
 * FIXED: Project Board update on update 3.8.1

= Version 3.8.2 / Thursday June 5th, 2014 =
 * FIXED: Default template update on update 3.8.1

= Version 3.8.1 / Thursday June 5th, 2014 =
 * REQUIRED: If you update this version of DAS you will also need to update any premium plugins you've purchased as every DAS plugin except the User Roles, Public and Private Project Board plugin have been updated. We will be updatin the Public and Private Project Board shortly after as well.
 * FIXED: Logo upload now uses the latest media frame.
 * FIXED: No Longer will you have to copy our template files into your child theme.
 * FIXED: If you do not enter a date in the 'When the project will start and end' option in a design post the option will not display on the template now. The Clean Theme has also been edited to work this way.
 * NEW: You can now create a folder called das in your theme if you want to customize any of our templates. This way if you do an update to DAS the changes will not effect your custom template. Existing das users template customization will not be effected and will still be used if already in place.
 * NEW: DAS does not require the use of the plugin 'custom post template' anymore. We have finally created our own template selection option in the tabs are of our design edit options.
 * NEW: DAS is now multi-language ready. We are currently working on a German version. If you would like to contribute we are willing to pay for your help. [See more here](http://glotpress.slickremix.com/projects).
 * NEW: The Design Approval System Fields on the design edit pages have been completely re-designed with tabs.
 * NEW: The Default Template is now WooCommerce ready, meaning if you have installed our new 'WooCommerce for the Design Approval System' plugin an option to create this design into a product and price option will be a tab on the design edit area. Then your price and add to cart button will appear next to the main logo. The Clean Theme has been updated with this feature too and the GQ theme also comes with this feature built in.
 * NEW: [Premium QG Theme](http://www.slickremix.com/product/gq-theme-das-extension/). WooComerce ready, uses wordpress comments, and allows for media uploads. A must see!
 * NEW: If you have the ['WooCommerce for Design Approval System'](http://www.slickremix.com/product/woocommerce-for-design-approval-system/) plugin installed and a customer purchases a product an icon will appear next to the approved icon on that design.
 
= Version 3.8 / January 11th, 2014 =
 * UPDATED: UI overhaul for 3.8 wordpress update and all premium extensions. If you don't care about the 3.8 version update then don't worry about updating just yet.
 * FIXED: Replaced depreciated function for WP Max Upload Size on the help/system info page.
 
= Version 3.7 / September 7th, 2013 =
 * Big thanks to all those who have been helping on the forum or sending emails in regards to suggestions and security issues, we could not do it without you all! 
 * FIXED: Security issue with walkthrough in WP admin, leaving it open to XSS attack. Needed to sanatize the step process, all good now. Thanks to [http://www.ibliss.com.br/](http://www.ibliss.com.br/) for pointing this out.
 * FIXED: Issue with posts being limited on the Project Board because of the number of posts set in wp settings page.
 * FIXED: Depreciated call 'caller_get_posts' changed to 'ignore_sticky_posts' on the admin Project Board.
 
= Version 3.6 / August 25th, 2013 =
 * FIXED: Additional security check added to the das-header.php so clients can't view other clients projects. Thanks to JetDingo for bringing this to our attention in our [support fourm](http://www.slickremix.com/support-forum/wordpress-plugins-group3/design-login-extension-forum6/possible-security-issue-login-work-around-public-can-view-all-designs-without-logging-in-thread122.0/#postid-564).
 * FIXED: Additional security check added to das-functions.php to redirect all users that try to access the site url on front end to view active projects coming from the content loop. (*ie. http://www.slickremix.com/testblog/?post_type=designapprovalsystem&page=design-approval-system-projects-page). So anything containing the word ?post_type=designapprovalsystem in the URL will get redirected to the home page. Additional Thanks to JetDingo for pointing this out. If you want to be able to view projects on the front end we do have the Public Project Board available ($5.00). See [more details here](http://www.slickremix.com/product/public-project-board-das-extension/).
 
= Version 3.5 / August 18th, 2013 =
 * FIXED: Possible fatal error on some installs regarding the function st4_columns_head() in our functions.php file. This function has been removed now. Thanks to 'aspirenetwork' for pointing this out. [Link to original post](http://wordpress.org/support/topic/error-in-activatiing-the-plugin?replies=8)
 * REMOVED: Tags from column for the designs list page in the wp-admin.

= Version 3.4 / June 30st, 2013 =
 * FIXED ADMIN: Misc CSS Fixes for Firefox
 * FIXED ADMIN: Enqued scripts only on DAS admin pages
 * NOTE: You must update to DAS 3.4 if you are going to update to the new Clean Theme Version: 2.1 (This version allows you to fully customize the theme to fit your company looks).

= Version 3.3 / June 21st, 2013 =
 * FIXED: Project Board for clients, title correction.
 * FIXED: Firefox CSS fixes on default theme and project board. 
 
= Version 3.2 / June 16th, 2013 =
 * SPECIAL CHANGE & ADDITION: We have updated the menu to a more comprehesive flow. In addition we have added a Special Walk-Through of the menu and a more easy to understand way to work the Design Approval System. We have spent hundreds of hours on this new update between only 2 people. Justin and Spencer Labadie and of course the countless others input to help further this project! Thanks to Everyone who have helped progress this plugin, and to all our premium extension buyers… You help motivate us beyond belief!
 * ADDED: Wordpress header and footer are now in the the default and clean theme, this allows for the Wordpress menu bar to be visible and more. 
 * ADDED: Now when projects are approved the signature is submitted to the database and will show up on the project board details. And once a client submits there signature they will not be able to approve that design again, unless you change the approved select option on the design edit page. You will also see the clients signature on the design edit page too.
 * ADDED: A STAR will appear on the row of the Project Name and the version in that project on the Project Board. FYI. For existing users of the DAS we added a meta field so you can manually approve designs if you want.
 * ADDED: DAS Client and DAS Designer are now default user roles. This means when signing up Clients and Designers you can specify that role and they will only be able to access certain areas when logging in. For instance if you sign up a client as a DAS Client they will only be able to view the project board, change password for themselves and Approve a design on the front end. They will not be able to edit posts or anything else. DAS Designers on the other hand will see the DAS and be able to post designs.
* CHANGES/ADDITIONS: Default Theme, modifications to forms to allow for new forced login to approve designs. And ajax submit on Approval Signature. If you use the Design Login premium extension you will get a login screen before the client see's the design. Plus this keeps the general public from stumbling upon your designs.

= IMPORTANT NOTES FOR OUR PREMIUM EXTENSION USERS, You must update all your purchased DAS premium plugins when upgrading to 3.2 =
 * CHANGES/ADDITIONS:  Client Changes, you'll now notice the client requests on the front end submit to database and automatically update on the page via ajax. We also added TinyMCE to the form so your clients can comment with style.
 * CHANGES/ADDITIONS: Clean Theme, modifications to forms to allow for new forced login to approve designs. And ajax submit on Approval Signature.
 * CHANGES/ADDITIONS: The Design Login now looks for existing wordpress users, and logs them in via ajax. This means you'll need to create a user for your client. Make sure you choose DAS Client as the role when setting them up, so when a DAS Client user logs in they'll only see the project board, and there user info. Required update if you are running DAS 3.2
 * REMOVED FROM DESIGN LOGIN: Custom username and password on post pages. Sorry for the inconvenience, but this new method is much more secure. 
 * CHANGES: Roles extension, misc edits to work with DAS 3.2.  


= Version 3.1 / March 31, 2013 =
 * ADDED: Designers can now add there email address to a design post, or just leave it blank and the settings page email will still receive the email notifications. This was added so larger companies with more than one designer, photographer, video editor, etc. on board can also receive email notifications for a particular design post.
 * ADDED: Newly styled UI for the design post fields area.
 * IMPORTANT: You MUST update your Client Changes premium plugin if you have purchased it. Updated version should be 1.5. The Clean Theme should also be updated if you have purchased that. Updated version should be 1.9

= Version 3.0 / March 23, 2013 =
 * MAJOR FIX! Missing SMTP Files. Please Upgrade to 3.0 and your sendmail and SMTP will work.

= Version 2.9 / March 22, 2013 =
 * MAJOR UPDATE!
 * NEW: Clients can login to view there designs. Simply make a Wordpress user for them. Once they login they will see the DAS menu with Project Board.
 * NEW: SMTP options are now available on the settings page. Hopefully this will solve a lot of email problems on servers that don't like sendmail. We have updated to the newest versions of class.phpmailer.php and jquery.forms.js for more flexibility and security.
 * FIX: Misc. CSS fixes for desktop and mobile on project board and default template.
 * FIX: Clean Theme now shows Version number in subject for the Approval option.
 * IMPORTANT: You MUST update your Client Changes premium plugin as well if you have purchased it. Updated version should be 1.4
 * NOTE: We are still looking into child theme issues and themes that don't follow general theme structures. If you are having problems please reffer to our forum for help. Quite of few people have figured out work arounds.
 
= Version 2.8 / January 22, 2013 =
 * NEW: Project Board Page. Now your design posts are all organized.
 * FIX: Default Template now has the_content instead of get_the_content. Now shortcodes will work.  
 
= Version 2.7 / January 4, 2013 =
 * Settings Page Fix: MESSAGE TO CLIENT (OPTIONAL) text area field has been fixed.
 * NOTE: This also effects the Clean Theme premium extension too, so make sure and update that plugin as well.  
 
= Version 2.6 / January 2, 2013 =
 * Revised: How the subject field of emails are displayed. This was changed to help people be able to search or sort emails more efficiently. This is the new way the subject is displayed, Name of Design First, Design Version 2nd and the Company or Client name 3rd. EXAMPLE. Subject: Redbull Flyer - Version 1 - SlickRemix
 * MUST: You must also update the client changes premium extension and clean theme premium extension for the changes noted above to take effect.
 * NOTE: If you have made custom changes to either the default template or the clean theme template you may want to save a copy of them before updating or those files will be overwritten.
 
= Version 2.5 =
 * Added: New admin DAS logo for left-side menu, with added Retina support.
 * Added: Additional admin CSS improvements.
 
= Version 2.4 =
 * Fixed: Show Design Option. We removed an extra comma causing error when using jQuery 1.8.0+
 
= Version 2.3 =
 * NEW: DAS Videos page to admin menu!
 * NEW: DAS News & Updates page to admin menu!
 * NEW: Help page added to admin menu!
 * Added: Animated links and buttons through-out.
 * Fixed: "Upload Image" jQuery duplication.

= Version 2.2 =
 * Added: Fixed "Upload Image" jQuery confliction with themes.

= Version 2.1 =
 * Added: Additional CSS for default template.
 
= Version 2.0 =
 * Important: Back up any file that you may have customized before doing update.
 * Revised: How DAS Framework works.
 * Added: New Framework
 * Added: Added features for 2 new plugins.
 
= Version 1.9 =
 * Revised: CSS and jQuery for versions drop down menu. Now works in Firefox.
 * Fixed: Select user and email bugs. 
 
= Version 1.8 =
 * Added: Settings Page is now set up for new Roles Extenstion options.
 * Added: Options to DAS Meta Box for new Roles Extenstion switching "Designer Name", "Client Name" to drop downs and "Client email" to auto fill input to email of the client selected.
 * Tested: The DAS Plugin, Themes, and extenstions for any bugs against the new (Beta) version of WordPress 3.5  
 
= Version 1.7 =
 * Fixed: Settings Page is now set up for new theme options.
 * Fixed: jQuery on Settings Page now compatible with new themes.

= Version 1.6 =
 * Fixed: No more auto selection of post template. (We are now offering more themes) [If you purchase one of our themes you may select which theme you would like to use for each individual post.]
 * Added: Size for "Clean Theme" to settings page.

= Version 1.5 =
 * Fixed: Duplicated page in template file.

= Version 1.4 =
 * MAJOR FIX - Fixed: Javascript on design post page NOW working. (ATTENTION EVERYONE - THIS UPDATE is NEEDED for DAS plugin to work PROPERLY! ALL Previous versions have NOT been working!)
 * MAJOR FIX - Fixed: Versions menu to work.
 * Added: "Designer's Name" field back into post backend.
 * Fixed: updated screen shots on settings page to match correct text.

= Version 1.3 =
 * MAJOR FIX - Fixed: Post Paged getting "404 Page Not Found error".  

= Version 1.2 =
 * Fixed: Screen shot #8 (Thank You message)
 * Added: Paypal Donate Button to settings page.
 * Added: Facebook "Like" Button to settings page.
 * Added: A new FAQ.
 
= Version 1.1 =
 * Fixed: Custom Post Type auto selection.
 * Removed: Two fields from DAS post page that were not needed.
 * Fixed: Duplicated jQuery files now using WordPress's included jQuery.
 * Fixed: Relative URLS to have dynamic paths. (For WordPress users who do not have WordPress installed on the root of their server)

= Version 1.0 =
 * Initial Release

== Frequently Asked Questions ==

= My client and I are not getting the emails? =

IMPORTANT: Please be sure to let your clients know that usually the first design email you send will most likely end up in their Spam/Trash! After they find have your client mark it as "not spam".

= Do you offer support? = 

Yes, if you are having problems, or possibly looking to extend our plugin to customize your needs? You can find answers to your questions or drop us a line at our [Support Forum](http://www.slickremix.com/support-forum/).

= Are there Extensions for this plugin? =

Yes. You can view them [here](http://www.slickremix.com/downloads/category/design-approval-system/)

== Screenshots ==

1. This is the settings area for the Design Approval System. Many options to customize the emails that go to your client and you!
2. Example of what making a new design page looks like for your client to see on the Design Approval System.
3. Here is an example of the theme page that will showcase your design examples. This is a theme so you can feel free to edit the CSS/HTML to your liking too.
4. Here you can see your notes, client notes... Client can approve the design, and if you have purchased our Changes Extension, the client will be able to make notes on the same page... When submitted you and your client will get the changes. You can buy that extension here. http://www.slickremix.com/product/client-changes-extension/
5. Example of the drop down showing the different design versions.
6. Example of header when you click the hide notes button.
7. This will fade-in when your client clicks the approve button. Also once the client approves the design a STAR will appear for that design on the project board, and will record there signature for you to view on the details of the design on the project board.
8. This message will fade in and out once your client types in their name and clicks submit.
9. Example of our Project Board Page. This organizes your client projects and designs. At the end of each project row is the number of versions for that project. The STARS mean a client has approved that design. See the [Full Project Board Tutorial](http://www.slickremix.com/2013/01/22/das-project-board-tutorial/) Here.
10. Simply click on one of the project rows and watch your version(s) slide into view. You can also hover your mouse over the thumbnail to reveal more options.
11. Clicking the details link on the thumbnail will show you the design details. If your client has added comments then they will be appear as well.
12. Create a Das-Client user for your clients in wordpress, and add your clients email on the designs you make and they'll appear for your client once they login as depicted in the photo.
13. This is an example of the client changes extension. If you need the option for your client to be able to make comments on your designs, this extension is what you need. It automatically makes an update to the page for the client to see his/her comments without refreshing the page too, once the client has submitted the form. And it also sends an email to you, the designer and the client letting them know about the design comments.