CREATE TABLE `P01_tbl_company`(
	`id` bigint(20) NOT NULL auto_increment primary key,
    `name` varchar (50),
    `city` varchar (50),
    `zip` varchar (50),
    `country` varchar (50),
    `description` varchar (300)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT INTO `P01_tbl_company` VALUES (1,'Company-1','City-1','Zip1','Country-1','AngularJS version of Metronic gives an extremely fast browsing experience to users. It uses lazy loading'),(2,'Company-2','City-2','ZipCode11','Country-2','The text in the textarea is wrapped (contains newlines) when submitted in a form. When \"hard\" is used, the cols attribute must be specified'),(3,'Company16','City16','Zip16','Country16','It does not wrap properly, because browsers do not apply automatic hyphenation (which would be the way to cause proper wrapping) by default.'),(4,'Name-4','City-4','ZipCode-4','Country-4','Why doesnt word wrap property work properly in the example below? ... Use word-break: break-all'),(5,'Name-5','City-5','ZipCode-5','Country-5','The function checks if the element has more width then its parent, and if it has, it breaks all instead of words only. We don\'t want the children to grow bigger than it\'s parents'),(6,'Name-6','City-6','Zip Code6','Country-6','The text in the textarea is not wrapped when submitted in a form. This is default'),(7,'Name-7','City-7','Zip Code7','Country-7','If it will go to else, it changes to word-break and then check if it should change back, that\'s why there is so much code.. :\'/'),(8,'test-8','City-8','Zip Code8','Country-8','So I\'m trying to do the very last exercise in the More Text Properties videos and I notice something funny'),(9,'Name-9','City-9','Zip Code9','Country-9','I only needed it for tables, so if you want it in some other element, just change \"table\" to \"#yourId\" or \".yourClass\". Make sure there is a parent-div or change \"div\" to \"body\" or something?'),(10,'Name-10','City-10','ZipCode-1','test-10','When you are tightening up the compression ring fastening the timer to the faucet you may have to support the timer with your other hand'),(11,'test-11','test-11','test-11','test-11','test-11'),(12,'test-12','test-12','test-12','test-12','test-12'),(13,'test-13','test-13','test-13','test-13','test-13'),(14,'Name-14','City-14','ZipCode-1','test-14','When you are tightening up the compression ring fastening the timer to the faucet you may have to support the timer with your other hand'),(15,'Company15','City-15','ZipCode15','Country15','The text in the textarea is wrapped (contains newlines) when submitted in a form. When \"hard\" is used, the cols attribute must be specified'),(16,'Name-17','City-17','ZipCode17','Country17','Why doesnt word wrap property work properly in the example below? ... Use word-break: break-all'),(17,'Name-16','City-16','ZipCode16','Country-1','The text in the textarea is not wrapped when submitted in a form. This is default'),(18,'Company18','City-18','ZipCode18','Country18','AngularJS version of Metronic gives an extremely fast browsing experience to users. It uses lazy loading'),(19,'Name-19','City-19','ZipCode19','Country19','I only needed it for tables, so if you want it in some other element, just change \"table\" to \"#yourId\" or \".yourClass\". Make sure there is a parent-div or change \"div\" to \"body\" or something?'),(20,'Name-20','City-20','ZipCode20','test-20','When you are tightening up the compression ring fastening the timer to the faucet you may have to support the timer with your other hand'),(21,'Company21','City-21','ZipCode21','Country21','AngularJS version of Metronic gives an extremely fast browsing experience to users. It uses lazy loading'),(22,'Name-9','City-9','Zip Code9','Country-9','I only needed it for tables, so if you want it in some other element, just change \"table\" to \"#yourId\" or \".yourClass\". Make sure there is a parent-div or change \"div\" to \"body\" or something?'),(26,'Company-1','City-1','Zip1','Country-1','AngularJS version of Metronic gives an extremely fast browsing experience to users. It uses lazy loading'),(27,'Company-1','City-1','Zip1','Country-1','AngularJS version of Metronic gives an extremely fast browsing experience to users. It uses lazy loading'),(29,'Com-29','City-29','Zip-29','Country29','AngularJS version of Metronic gives an extremely fast browsing experience to users. It uses lazy loading');

CREATE TABLE `P01_tbl_staff`(
	`id` bigint(20) NOT NULL auto_increment primary key,
    `dateOfBirth` timestamp,
    `firstname` varchar(50),
    `lastName` varchar(50),
    `note` varchar(300),
    `companyId` bigint(20) DEFAULT NULL,
    `image` varchar(200) DEFAULT NULL,
    CONSTRAINT `FK_tbl_staff_company_companyId` FOREIGN KEY (`companyId`) REFERENCES `tbl_company` (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    
CREATE TABLE `P01_user` (
  `id` int(10) UNSIGNED NOT NULL primary key,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `auth_name` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `P01_user` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `auth_name`) VALUES
(1, 'prince.kuhic', 'rice.mertie@daniel.com', '$2y$10$HirYYQyqLgdfF5ZI0HQ7C.hhCyqx/D.uifPHsaC1KLkuQ44jMI8Iy', NULL, '2017-04-25 22:02:31', '2017-04-25 22:02:31', ''),
(2, 'cziemann', 'kariane.nitzsche@gmail.com', '$2y$10$I.JW9R4Y9Hg4UqrC4J4dW.Tmuw8G0w8xvJqbYIOyBHrdO/60tnxDa', NULL, '2017-04-25 22:02:31', '2017-04-25 22:02:31', ''),
(3, 'smith.lauryn', 'heidenreich.darby@gmail.com', '$2y$10$WHBjiKqWdkN1Dxd3VCwiQO26f/JWNoC5Y9cX7TwSWSnnM8psHgPfu', NULL, '2017-04-25 22:02:31', '2017-04-25 22:02:31', ''),
(4, 'dean.monahan', 'elinor.hamill@cruickshank.biz', '$2y$10$VmkwXoVgZdIWXOHfCWXSFOzFdSpoi3ywN5DZ.SxzjljDN.8bvnV7S', NULL, '2017-04-25 22:02:31', '2017-04-25 22:02:31', ''),
(5, 'qabshire', 'ncarroll@crona.com', '$2y$10$WWs4VRBPMRc2cs8GL4QC6OvUpY.OFiL7DFnZ1arZAV.9I0yMCFxTO', NULL, '2017-04-25 22:02:31', '2017-04-25 22:02:31', ''),
(6, 'test', 'test@gmail.com', '$2y$10$jRKqkl1aIEOIfp7Nv7RhVOkIeow.5Q9RLbUDMSd4KBFdtMnLwWU6m', NULL, NULL, NULL, 'a'),
(7, 'test2', 'test2@gmail.com', '', NULL, NULL, NULL, 'b'),
(8, 'test3', 'test3@gmail.com', '$2y$10$jRKqkl1aIEOIfp7Nv7RhVOkIeow.5Q9RLbUDMSd4KBFdtMnLwWU6m', NULL, NULL, NULL, 'c');

ALTER TABLE P01_tbl_company ADD FULLTEXT KEY ix_tbl_company_fts_01(name, city, zip, country, description);
ALTER TABLE P01_tbl_staff ADD FULLTEXT KEY ix__tbl_staff_fts_01(firstname, lastName, note);