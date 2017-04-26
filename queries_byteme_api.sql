
-- QUERIES FOR NEW VISITORS SYSTEM:

-- GET ALL VISITS FOR A GIVEN IP:
SELECT MySite_visitors.ip, MySite_visits.date
FROM MySite_visitors inner join MySite_visits on MySite_visitors.id=MySite_visits.visitorID
WHERE MySite_visitors.ip = '212.251.168.60'

