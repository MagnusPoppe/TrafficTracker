-- GET ALL VISITS WITH A GIVEN SITE ID
SELECT * FROM traffic_sites WHERE siteID=2;

-- GET VISITOR WITH SPESIFIC IP
SELECT * FROM traffic_visitors WHERE ip="128.39.132.140";

-- GET COUNT OF VISITS FOR THIS MONTH:
SELECT COUNT(date) as 'count'
FROM traffic_visits
WHERE (MONTH(date) = MONTH(NOW())) AND (YEAR(date) = YEAR(NOW()));

-- GET COUNT OF VISITS ON A MONTHLY BASIS:
SELECT COUNT(date) as 'count'
FROM traffic_visits
WHERE (DATEDIFF(date, NOW()) <= 31);

-- Insert new visitor
INSERT INTO Visitor(ip, hostname, organisation, city, country, latitude, longitude)
VALUES(?,?,?,?,?,?,?);

UPDATE Visitor SET 
	hostname = ?,
    organisation = ?,
    city = ?, 
    country = ?, 
    latitude = ?, 
    longitude = ?
WHERE
	id = ?;


-- UNKNOWN
SELECT 
	traffic_visitors.ip AS 'IP', 
	traffic_visits.date AS 'date', 
	traffic_sites.siteID AS 'siteID', 
	traffic_sites.description AS 'description'
FROM  
	traffic_visitors, 
	traffic_visits, 
	traffic_sites
WHERE (traffic_visitors.id = traffic_visits.VisitorID)
AND   (traffic_visits.siteID = traffic_sites.siteID);

-- GET ALL VISITS FOR A GIVEN SITE
SELECT 
	traffic_visitors.ip AS 'IP', 
	traffic_visits.date AS 'date', 
	traffic_sites.siteID AS 'siteID', 
	traffic_sites.description AS 'description'
FROM  
	traffic_visitors, 
	traffic_visits, 
	traffic_sites
WHERE (traffic_visitors.id = traffic_visits.VisitorID)
AND   (traffic_visits.siteID = traffic_sites.siteID) 
AND    traffic_sites.siteID = 1;

SELECT * FROM traffic_visitors;

SELECT id, ip FROM traffic_visitors;

SELECT visitorID, COUNT(date) 
FROM traffic_visits
GROUP BY visitorID
ORDER BY visitorID;
