# Traffic Tracker
A basic traffic tracking REST API for tracking data coming into your server. This app uses a third party api for IPLookup, and will store among other things, ISP, Latitude/Longitude of visitor, hostname and organisation if there is one and more. This does then not need premission from a user to track them. 


### Data model: 
![alt text](http://byteme.no/image/trafficTrackerDataModel.png)

The datamodel is very light weight and can easily be added to. For a given visitor, we log all of the datafields at first visit, then on the next visit, we recognize that the IP has been here before. The visit will then only be datestamped and marked with the visitorID and siteID

### Example: 
All incomming requests to this api needs to go through the api.php file. This uses slashes to route the api. 
		
	// Get all traffic data: 
	http://yourdomain.com/api.php/traffic/
		
	// Get traffic for a spesific IP address: 
	http://yourdomain.com/api.php/traffic/192.168.0.1
		
	// Post data about a spesific visitor: 
	http://yourdomain.com/api.php/visitor/
		
The api is in use with the [Android application DashboardAndroid found here](https://github.com/MagnusPoppe/DashboardAndroid "Dashboard GitHub page"). 

[![alt text](http://byteme.no/image/Dashboard-all.png)](https://github.com/MagnusPoppe/DashboardAndroid "Screenshot of DashbaordAndroid app")


### How to use
All incomming data must be logged. This is done by first requiring the api.php file into the php file you will be logging visits to. 
```php 
require_once ___DIR___ . "/api.php";
```
You can then use the method "log()". Log takes a single IP address and a "page visited" ID, and fills in the rest. It will use the [http://ipinfo.io API](http://ipinfo.io) to get addidtional information about the IP address in question. Every other field in the table "traffic_visitors" except id and ip will be filled out with data from here. 
```php 
log("192.168.0.1", 1); // Where the second parameter is the page visited from. i.e. HOMEPAGE = 1
```
