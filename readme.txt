=== Plugin Name ===
Contributors: christopherross
Plugin URI: http://thisismyurl.com/plugins/get-image-from-post/
Tags: get,image,posts,thumbnail,preview, plugin, post, posts,images,links
Donate link:  http://thisismyurl.com/
Requires at least: 2.0.0
Tested up to: 3.5.1
Stable tag: 2.1.0

Allows users to fetch an image from a post within the Loop.

== Description ==

This is a simple plugin which allows users to return an image from the related post.

This plugin is maintained by Christopher Ross, http://thisismyurl.com or you can find him on Twitter at http://twitter.com/thisismyurl/

== Installation ==

To install the plugin, please upload the folder to your plugins folder and active the plugin.

== Screenshots ==

== Updates ==
Updates to the plugin will be posted here, to [thisismyurl.com](http://thisismyurl.com/)

== Frequently Asked Questions ==

= How do I display the results? =

Insert the following code into your WordPress theme files:

= General results =
Without passing any parameters, the plugin will return ten results or fewer depending on how many posts you have.

 thisismyurl_get_image_from_post();


= Altering the before and after values =
By default the plugin wraps your code in list item (&lt;li&gt;) tags but you can specify how to format the results using the following code:

 thisismyurl_get_image_from_post('before=&lt;p&gt;&amp;after=&lt;/p&gt;');

= Adding a Link =
If you'd like to link to the post (remember it's not live yet) you can do so by calling:

 thisismyurl_get_image_from_post('link=true');


= Which image? =
You can specify which image is returned using the code:

 thisismyurl_get_image_from_post('image=2');

= Strip Attributes =
If you would like to strip the attributes such as width and height from the returned value:

 thisismyurl_get_image_from_post('strip=true');

= Echo vs. Return =
Finally, if you'd like to copy the results into a variable you can return the results as follows:

 thisismyurl_get_image_from_post('show=false');

== Donations ==
If you would like to donate to help support future development of this tool, please visit http://thisismyurl.com/


== Change Log ==

= 2.0.0 =

* renamed function to be more compatible.
* tested and optimized in WordPress 3.2
* added test to determine in images existed

= 1.0.0 =

* official release
* added strip attribute

= 1.1.0 =

* minor fixes for wordpress new admin
