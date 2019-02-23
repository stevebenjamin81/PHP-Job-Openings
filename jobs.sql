-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2018 at 04:30 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jobs`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Information Technology', 'Jobs in our IT department.'),
(2, 'Warehouse', 'Shipping and receiving.'),
(3, 'Delivery Drivers', 'Drive for our company!');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `category`, `name`, `description`) VALUES
(1, 1, 'Jr. Systems Engineer', 'Are you interested in accelerating your technical experience and industry exposure while working with a small, high-octane team of A-players? If so, please send us your resume, cover letter and complete a short, timed assessment test: http://www.ondemandassessment.com/verify/apply/SqSyyAD/DTTbhnEw\r\n\r\nSemaphore Co provides top notch VMware, Microsoft and Network consulting services across multiple industries. We\'re looking for a hard-working candidate who takes ownership of their work and wants to grow with us. Someone who prefers a fun, entrepreneurial environment and loves learning new technologies. We also want someone who understands that process is important, enjoys working closely with a team and is willing to travel up to 30%. If you like to half ass things and struggle driving projects to completion, this is not the right place for you. If you hold yourself to impeccable standards and thrive working with the latest and greatest gear, you\'ll love being on our team.\r\n\r\nThe successful candidate will have 3+ years\' experience, be great with people, and be good with technology. We\'re looking for someone enjoys building and strengthening client relationships, embraces flexibility, keeps calm under pressure, and, most importantly, always delivers. Our loft style office is in the FloatAway Community near Emory University. Our company culture is fun and progressive, and we offer competitive salary and benefits, and a real opportunity for growth.\r\n\r\nEssential Duties & Responsibilities\r\n\r\nLead and support client engagements in partnership with the Systems Architect\r\nEffectively utilize Semaphore Co methodology of Discover, Plan, Implement, and Document\r\nProvide consistent communication to customer inquiries via phone, email, and our internal ticket system, meeting or exceeding SLA response times\r\nCreate detailed and thorough project documentation and Visio diagrams that even the higher-ups will love\r\nEnable clients to get the most out of their technology; help them work smarter not harder * Internally identify areas in which we can help clients on future opportunities\r\nWork after business hours and weekends, depending on client needs\r\nPerform on-call support duties on a rotating weekly basis\r\nProvide guidance and direction to Support Engineers\r\nBusiness Qualifications\r\n\r\nExcellent communication skills and business acumen\r\nAbility to manage multiple tickets at once and determine priorities effectively\r\nAffinity for developing strong business relationships across multiple levels of an organization\r\nTechnical Qualifications\r\n\r\nKnows VMware, vSphere, and vCenter inside and out\r\nGreat with Microsoft Windows Server\r\nGood with Microsoft Active Directory and Group Policy\r\nKnows a thing or two about Microsoft Exchange\r\nKnows a thing or two about firewalls and VLANs\r\nKnows there is always an answer to a problem\r\nJob Type: Full-time\r\n\r\nSalary: $50,000.00 to $60,000.00 /year\r\n\r\nJob Location:\r\n\r\nAtlanta, GA 30306'),
(2, 2, 'Shipping and Receiving', 'PLEASE READ ENTIRE DESCRIPTION BEFORE APPLYING!\n\n***Must be able to use UPS WORLDSHIP and FEDEX SHIP MANAGER. If you do not know how to use these programs do not apply (experience required). You will be responsible for shipping each package out on small package along with receiving in our morning deliveries via UPS and FEDEX GROUND in a warehouse setting. Must be able to type 40+ words per minute with accuracy ***\n\n***This position may require you to demonstrate your abilities on UPS WORLD SHIP and FED EX SHIP MANAGER SOFTWARE during the interview process.\n\nSCOPE OF JOB:\n\n% subject to change based on daily operations\n\n50% INBOUND RECEIVING - inbound receiving which includes checking in merchandise by the purchase order (opening the boxes and counting merchandise), sorting inbound ground shipments, signing for ground package shipments\n\n30% OUTBOUND SHIPPING - small package UPS & FEDEX GROUND AND AIR SHIPMENTS. Working with both UPS WORLD SHIP and FED EX SHIP MANAGER software to key in customer address information along with package weight in order to create the shipping label and affix to the carton.\n\n20% GENERAL WAREHOUSE/ORDER PULLING - general warehouse including order pulling and setup, cleaning, organizing, sweeping floors, breaking down boxes, cleaning shelving, throwing out trash, counting inventory\n\nPay is weekly\n\nHours are 7am to 3:30pm with some Saturday work\n\nJob Type: Full-time\n\nSalary: $10.00 /hour\n\nJob Type: Full-time\n\nSalary: $9.50 to $10.00 /hour\n\nRequired experience:\n\nShipping and Receiving: 1 year\nRequired education:\n\nHigh school or equivalent'),
(13, 3, 'Supply Chain Tech/Courier', 'Requisition #: 23636\nName of Location: Hughes Spalding\nWork Schedule: Variable\nEmployment Type: Part-Time\nWork Days: Monday - Friday\n\nJOB SUMMARY\n\nProvides receiving, delivery, restocking, tracking, and documentation for all patient care supplies at assigned facility. Proactively supports efforts that ensure delivery of prompt, safe services for patient care. Ensures that daily activities support and promote a safe work environment at Children&#39;s Healthcare of Atlanta.\n\nEDUCATION\n\nHigh school diploma or equivalent\nCERTIFICATION SUMMARY\n\nValid Georgia driverâ€™s license (Warehouse Technicians only)\n\nEXPERIENCE*\n\nExperience with software applications (e.g., Microsoft Outlook, Lawson, and Omnicell)\nPREFERRED QUALIFICATIONS*\n\n1 year of experience in hospital healthcare distribution\nKNOWLEDGE SKILLS & ABILITIES*\n\nMust possess good communication skills\nAvailable to work rotating shifts and overtime on short notice\nMust be eligible for coverage by Childrenâ€™s Healthcare of Atlanta&#39;s motor vehicle insurance provider\nJOB RESPONSIBILITIES*\n\n1. Selects supply chain orders (DeKalb Industrial Warehouse) timely and accurately.\n2. Receives deliveries (e.g., UPS, FedEx, Airborne) accurately, ensures packages have correct documentation and delivery location, and maintains documentation/delivery files.\n3. Delivers products to campus and satellite locations via Childrenâ€™s Healthcare of Atlanta motor vehicle (DeKalb Industrial Warehouse/mailroom).\n4. Assists in maintaining the location inventory, monitoring for expired product, keeping assigned areas organized and clean, and entering replenishment orders as needed.\n5. Responds to all requests in a timely, courteous, and friendly manner.\n6. Charges all Supply Chain disbursements accurately and timely.\n7. Processes returns/credits as required.\n8. Re-stocks Omnicells in patient care area, monitors cells for expired product, and performs routine cycle counts (hospitals only).\n9. Supports and participates in the continuous assessment and improvement of the quality of services provided by Supply Chain at assigned facility.\n10. Adheres to Childrenâ€™s Healthcare of Atlanta&#39;s time and attendance policy.\n11. Picks up, sorts, and delivers mail (mailroom only).\n12. Timely and accurately meters mail and ensures that all unidentified mail is properly investigated (mailroom only).\n\nSYSTEM RESPONSIBILITIES*\n\nSafety: Practices proper safety techniques in accordance with hospital and departmental policies and procedures. Responsible for the reporting of employee/patient/visitor injuries or accidents, or other safety issues to the supervisor and in the occurrence notification system.\n\nCompliance: Monitors and ensures compliance with all regulatory requirements, organizational standards, and policies and procedures related to area of responsibility. Identifies potential risk areas within area of responsibility and supports problem resolution process. Maintains records of compliance activities and reports compliance activities to the Compliance Office.\n\nThe above statements are intended to describe the general nature and level of work performed by people assigned to this classification. They are not intended to be an exhaustive list of all job duties performed by the personnel so classified.\n\nPHYSICAL DEMANDS*\n\nBending/Stooping - Frequently (activity or condition exists from 1/3 to 2/3 of time)\n\nClimbing - Occasionally (activity or condition exists up to 1/3 of time)\n\nLifting - Frequently (activity or condition exists from 1/3 to 2/3 of time)\n\nPushing/Pulling - Frequently (activity or condition exists from 1/3 to 2/3 of time)\n\nSitting - Occasionally (activity or condition exists up to 1/3 of time)\n\nStanding - Frequently (activity or condition exists from 1/3 to 2/3 of time)\n\nWalking - Frequently (activity or condition exists from 1/3 to 2/3 of time)\n\nAbility to lift up to 15 lbs independently not to exceed 50 lbs without assistance\n\nHearing/Speaking - Effective communication with employees, supervisors/managers and staff. Effective communications with patients and visitors, as required.\n\nWORKING CONDITIONS*\n\nSome potential for exposure to blood and body fluids\n\nLocation Address: 35 Jesse Hill Jr. Drive, SE, Atlanta, GA 30303\nFunction: Supply Chain - Supply chain\n\nOverview:\n\nChildrenâ€™s Healthcare of Atlanta has been 100 percent dedicated to kids for more than 100 years. A not-for-profit organization, Childrenâ€™s is dedicated to making kids better today and healthier tomorrow.\n\nWith 3 hospitals, 27 neighborhood locations and a total of 622 beds, Childrenâ€™s is the largest healthcare provider for children in Georgia and one of the largest pediatric clinical care providers in the country. Childrenâ€™s offers access to more than 60 pediatric specialties and programs and is ranked among the top childrenâ€™s hospitals in the country by U.S. News & World Report.\n\nChildrenâ€™s has been ranked on Fortune magazineâ€™s list of â€œ100 Best Companies to Work Forâ€ for twelve consecutive years and named one of the â€œ100 Best Companiesâ€ by Working Mother magazine. We offer a comprehensive compensation and benefit package that supports our mission, vision and values. We are proud to offer an array of programs and services to our employees that have distinguished us as a best place to work in the country. Connect to our mission of being Dedicated to All Better and impact the lives of hundreds of thousands of patients and their families each year.'),
(14, 1, 'Information Technology Specialis', 'Information Technology Specialist (25B)\n\nOverview\n\nInformation technology specialists are responsible for maintaining, processing and troubleshooting military computer systems/operations.\n\nJob Duties\n\nMaintenance of networks, hardware and software\nProvide customer and network administration services\nConstruct, edit and test computer programs\nThose who want to serve must first take the Armed Services Vocational Aptitude Battery, a series of tests that helps you better understand your strengths and identify which Army jobs are best for you.\n\nTraining\n\nJob training for an information technology specialist requires 10 weeks of Basic Combat Training and 20 weeks of Advanced Individual Training with on-the-job instruction. Some of the skills youâ€™ll learn are:\n\nUse of computer consoles and peripheral equipment\nComputer systems concepts\nPlanning, designing and testing computer systems\nHelpful Skills\n\nInterest in computer science\nAttention to detail\nAbility to communicate effectively\nExperience in installation of computers\nRequired ASVAB Score(s)Skilled Technical (ST): 95\n\nAge: 18-34 years old\n\nJob Types: Full-time, Part-time\n\nSalary: $50,000.00 to $60,000.00 /year\n\nEducation:\n\nHigh school (Required)\nLicense or certification:\n\nCurrent Drivers License (Preferred)\nJob Types: Full-time, Part-time\n\nJob Types: Full-time, Part-time');

-- --------------------------------------------------------

--
-- Table structure for table `resumes`
--

CREATE TABLE `resumes` (
  `id` int(11) NOT NULL,
  `jobs_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `resume` varchar(200) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resumes`
--

INSERT INTO `resumes` (`id`, `jobs_id`, `users_id`, `resume`, `date`) VALUES
(1, 1, 1, '/resumes/9e28f41f8dc8d9a1a030de846cca9e69574dfe2e_test2.docx', '2018-04-03'),
(2, 1, 1, '/resumes/6d3eaefed4b7574826eaff120f68a7aad27e7c95_test2.docx', '2018-04-03'),
(3, 2, 1, '/resumes/54615e4ca205ea3720ccb88dd312658677252ec8_test2.docx', '2018-04-04'),
(4, 1, 7, '/resumes/6480b4699db84bb18fb443252357990baaa19f27_test2.docx', '2018-04-05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `is_admin` tinyint(4) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `is_admin`, `name`, `email`, `password`) VALUES
(1, 2, 'Steven Benjamin', '', ''),
(2, 1, 'Admin', '', ''),

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resumes`
--
ALTER TABLE `resumes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `resumes`
--
ALTER TABLE `resumes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
