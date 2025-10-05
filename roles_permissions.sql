# Host: localhost  (Version 5.5.5-10.4.8-MariaDB)
# Date: 2020-03-18 17:13:16
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Data for table "permissions"
#

INSERT INTO `permissions` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (1,'roles create','web',NULL,NULL),(2,'roles show','web',NULL,NULL),(3,'roles edit','web',NULL,NULL),(4,'roles assign or revoke','web',NULL,NULL),(5,'booking show','web',NULL,NULL),(6,'booking cancel','web',NULL,NULL),(7,'booking delete','web',NULL,NULL),(8,'booking emergency','web',NULL,NULL),(9,'booking change date','web',NULL,NULL),(10,'user show','web',NULL,NULL),(11,'user create','web',NULL,NULL),(12,'user edit','web',NULL,NULL),(13,'user verify','web',NULL,NULL),(14,'user delete','web',NULL,NULL);

#
# Data for table "roles"
#

INSERT INTO `roles` (`id`,`name`,`guard_name`,`created_at`,`updated_at`) VALUES (1,'Roles Full Rights','web',NULL,NULL),(2,'User Full Rights','web','2020-03-18 11:20:33','2020-03-18 11:20:33'),(3,'User Basics','web','2020-03-18 11:31:51','2020-03-18 11:31:51'),(4,'Booking Full Rights','web','2020-03-18 11:41:06','2020-03-18 11:41:06'),(5,'Booking Basic','web','2020-03-18 11:49:06','2020-03-18 11:49:06');

#
# Data for table "role_has_permissions"
#

INSERT INTO `role_has_permissions` (`permission_id`,`role_id`) VALUES (1,1),(2,1),(3,1),(4,1),(5,4),(5,5),(6,4),(7,4),(8,4),(9,4),(9,5),(10,2),(10,3),(11,2),(12,2),(13,2),(13,3),(14,2);

#
# Data for table "model_has_roles"
#

INSERT INTO `model_has_roles` (`role_id`,`model_type`,`model_id`) VALUES (1,'App\\User',1),(1,'App\\User',1568),(1,'App\\User',1575),(2,'App\\User',1568),(3,'App\\User',1610),(4,'App\\User',1568),(5,'App\\User',1610);
