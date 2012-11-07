Inchoo-Unicache
=====================

Inchoo Unicache is an extremely simple and useful little extension that you can use to cache any kind of text/string based data in Magento. It uses helpers to make it accessible from anywhere; from template files to your own custom code.

While making the Inchoo Flicker Gallery extension I needed an easy way of caching the Flickr API responses because the Flickr API servers were somewhat slow and there was no need to make the API request every time user opens the gallery. There were several different API responses that I needed to cache in one database table so I needed a universal solution to cache all of them and that’s how Inchoo Unicache extension was born. 

If you ever need to use some third-part REST or any other type of API that requires you to wait for the response, this extension is a must have. Please share your thoughts about other use cases in the comments section below.

Features
---------------
  * Uses helpers to be more accessible
  * Add, edit or remove cached items at any time with one line of code
  * Check if there is cached data for a specified item name
  * Check if the cached content for a specific item name should be used
  * Get or set only the cached item timeout
  * Intuitive and easy to use
  * NEW! Admin grid listing all the cached data
  * NEW! "Clear Cache" button in admin grid
  * NEW! "Delete Expired" button in admin grid and helper function
  * NEW! Cron job for deleting expired cache data (turned on by default!)


How to install?
---------------
Download Inchoo Unicache extension files to your Magento root directory.

If you are logged in to your Magento back-end you have to log out and then log in again. Clearing the cache would also be a good idea.


How does it work?
-----------------
Inchoo Unicache uses one database table to store all the cached data in a simple name - content structure. Every cached item has:
  * Name
  * Content
  * Date and time of the last update
  * Timeout (in hours)

Item name is a unique identifier that you can use to create, edit or remove the cached item using only one line of code.

To create a cached item all you need to do is call helper function like this:
Mage::helper('unicache')->writeCache([ITEM-NAME], [ITEM-CONTENT], [TIMEOUT]);

Where [ITEM-NAME] is the name of the cached item, [ITEM-CONTENT] is the content you want to cache and [TIMEOUT] is the time in hours that specifies how long should the item be cached (this argument is optional with a default value of 24).

To read the cached data all you need to do is call another helper function like this:
$cachedData = Mage::helper('unicache')->readCache([ITEM-NAME]);

Where [ITEM-NAME] is the same item name you used when creating the cached item.

To make it even easier to display the cached data anywhere on the site I added the support for layout XML updates. This means that you can include any cached data by adding a block element to your XML update file like this:
````` XML
<block type="core/template" name="cached" template="inchoo/unicache/data.phtml">
        <action method="setCacheName"><cache_name>[ITEM-NAME]</cache_name></action>
</block>
`````

Check out the "inchoo/unicache/data.phtml" file to customize how you want to display the cached data.

Available functions
-------------------
There are several useful functions included in the extension that you can use to manage your cached data.

<b>Mage::helper('unicache')->hasCache([ITEM-NAME]);</b><br/>
Check if there is a cached item with the specified [ITEM-NAME]. This function only checks if the cached item exists it does not check if it has expired. Function returns true if there is a cached item with the specified [ITEM-NAME] and false otherwise.

<b>Mage::helper('unicache')->getCacheItem([ITEM-NAME]);</b><br/>
This function will return the collection item for the cached item with the specified [ITEM-NAME]. If there is no cached with the specified name function will return NULL.

<b>Mage::helper('unicache')->cacheExpired([ITEM-NAME]);</b><br/>
Check if cached item with the specified [ITEM-NAME] has expired. Expired time is calculated by adding item timeout to the last updated time. If the expired time is greater than current time the function will return true, otherwise it will return true. If there is no cached item with the specified [ITEM-NAME] the function will return true.

<b>Mage::helper('unicache')->shouldUseCache([ITEM-NAME]);</b><br/>
Check if you should use the cached content for the specified [ITEM-NAME]. This function checks if the cached item exists and is not expired.

<b>Mage::helper('unicache')->writeCache([ITEM-NAME], [ITEM-CONTENT], [TIMEOUT]);</b><br/>
This function writes the cached item with the specified [ITEM-NAME]. If there is no item with the specified name function will create a new item, if there is an item with the specified name function will update the content and timeout (if specified) values. [TIMEOUT] argument is optional and has a default value of 24. This function does not return any value.

<b>Mage::helper('unicache')->readCache([ITEM-NAME]);</b><br/>
This function returns the cached content data for the specified [ITEM-NAME]. If the cached item with the specified name exists and is not expired it returns its cached content data, otherwise it returns false.

<b>Mage::helper('unicache')->deleteCache([ITEM-NAME]);</b><br/>
This function deletes the cached item with the specified [ITEM-NAME]. In this case [ITEM-NAME] is optional and if left unspecified all the cached items would be deleted (this will effectively clear the entire cache).

<b>Mage::helper('unicache')->cacheTimeout([ITEM-NAME]);</b><br/>
This function returns the cache timeout from the cached item specified with [ITEM-NAME]. If there is no cached item with the specified name function will return false.

<b>Mage::helper('unicache')->updateCacheTimeout([ITEM-NAME], [TIMEOUT]);</b><br/>
This function will update only the cache timeout for the cached item with the specified [ITEM-NAME].

<b>Mage::helper('unicache')->deleteExpired();</b><br/>
NEW! This function will delete all the expired cached data (if any) and return a string status message: "Expired cache data deleted." or "There was no expired cache data."

NEW! Cron job for deleting expired cache data
-------------------
I added a cron job that deletes expired cache data every day at midnight. You can disable or change this option in config.xml