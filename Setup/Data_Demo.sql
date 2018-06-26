CREATE DATABASE Company;
USE Company;
CREATE TABLE staff(
	Id int AUTO_INCREMENT primary key,
	Name nvarchar (50)
	);
INSERT INTO `staff` VALUES (1,'test1'),(2,'test2'),(3,'test3'),(10,'test10'),(5,'test5'),(6,'test6'),(7,'test7'),(8,'test8'),(9,'test9'),(11,'test11'),(4,'test4'),(12,'test12'),(13,'test13'),(14,'test14'),(15,'test15'),(16,'test16'),(17,NULL),(18,NULL),(19,'test1'),(20,'test1'),(21,'test21'),(22,'test22'),(23,'test23'),(24,'test24'),(25,'test25'),(26,'test26'),(27,'test27'),(28,'test28'),(29,'test29'),(30,'test30'),(33,'31');
CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `auth_name` char(5) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `auth_name`) VALUES
(1, 'prince.kuhic', 'rice.mertie@daniel.com', '$2y$10$HirYYQyqLgdfF5ZI0HQ7C.hhCyqx/D.uifPHsaC1KLkuQ44jMI8Iy', NULL, '2017-04-25 22:02:31', '2017-04-25 22:02:31', ''),
(2, 'cziemann', 'kariane.nitzsche@gmail.com', '$2y$10$I.JW9R4Y9Hg4UqrC4J4dW.Tmuw8G0w8xvJqbYIOyBHrdO/60tnxDa', NULL, '2017-04-25 22:02:31', '2017-04-25 22:02:31', ''),
(3, 'smith.lauryn', 'heidenreich.darby@gmail.com', '$2y$10$WHBjiKqWdkN1Dxd3VCwiQO26f/JWNoC5Y9cX7TwSWSnnM8psHgPfu', NULL, '2017-04-25 22:02:31', '2017-04-25 22:02:31', ''),
(4, 'dean.monahan', 'elinor.hamill@cruickshank.biz', '$2y$10$VmkwXoVgZdIWXOHfCWXSFOzFdSpoi3ywN5DZ.SxzjljDN.8bvnV7S', NULL, '2017-04-25 22:02:31', '2017-04-25 22:02:31', ''),
(5, 'qabshire', 'ncarroll@crona.com', '$2y$10$WWs4VRBPMRc2cs8GL4QC6OvUpY.OFiL7DFnZ1arZAV.9I0yMCFxTO', NULL, '2017-04-25 22:02:31', '2017-04-25 22:02:31', ''),
(6, 'test', 'test@gmail.com', '$2y$10$jRKqkl1aIEOIfp7Nv7RhVOkIeow.5Q9RLbUDMSd4KBFdtMnLwWU6m', NULL, NULL, NULL, 'a'),
(7, 'test2', 'test2@gmail.com', '', NULL, NULL, NULL, 'b'),
(8, 'test3', 'test3@gmail.com', '$2y$10$jRKqkl1aIEOIfp7Nv7RhVOkIeow.5Q9RLbUDMSd4KBFdtMnLwWU6m', NULL, NULL, NULL, 'c');