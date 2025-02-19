-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 19 fév. 2025 à 10:33
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `clsky_location`
--

-- --------------------------------------------------------

--
-- Structure de la table `amenities`
--

CREATE TABLE `amenities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `depenses`
--

CREATE TABLE `depenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `date_depense` date NOT NULL,
  `categorie` varchar(255) NOT NULL,
  `mode_paiement` varchar(255) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `type` enum('contract','invoice','other') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `maintenances`
--

CREATE TABLE `maintenances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `reported_by` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `priority` enum('low','medium','high','urgent') NOT NULL,
  `status` enum('pending','in_progress','completed','cancelled') NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0,
  `archived_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message_attachments`
--

CREATE TABLE `message_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_size` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_10_24_092651_create_properties_table', 1),
(5, '2024_10_24_092652_create_property_images_table', 1),
(6, '2024_10_24_092653_create_amenities_table', 1),
(7, '2024_10_24_092654_create_property_amenities_table', 1),
(8, '2024_10_24_092655_create_reservations_table', 1),
(9, '2024_10_24_092656_create_payments_table', 1),
(10, '2024_10_24_092657_create_reviews_table', 1),
(11, '2024_10_24_092658_create_messages_table', 1),
(12, '2024_10_24_092659_create_notifications_table', 1),
(13, '2024_10_24_092700_create_maintenances_table', 1),
(14, '2024_10_24_092701_create_documents_table', 1),
(15, '2024_10_27_033148_create_message_attachments_table', 1),
(16, '2024_11_02_133722_create_depenses_table', 1),
(17, '2024_11_05_153442_add_proof_document_to_payments_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `data` timestamp NULL DEFAULT NULL,
  `notifiable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notifiable_type` varchar(255) DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` enum('card','bank_transfer','cash') NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `proof_document_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','completed','failed','refunded') NOT NULL DEFAULT 'pending',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `properties`
--

CREATE TABLE `properties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `bedrooms` int(11) NOT NULL,
  `bathrooms` int(11) NOT NULL,
  `area` decimal(8,2) NOT NULL,
  `floor` int(11) DEFAULT NULL,
  `furnished` tinyint(1) NOT NULL DEFAULT 0,
  `available` tinyint(1) NOT NULL DEFAULT 1,
  `type` enum('apartment','studio','duplex') NOT NULL,
  `status` enum('available','rented','maintenance') NOT NULL DEFAULT 'available',
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `properties`
--

INSERT INTO `properties` (`id`, `title`, `slug`, `description`, `address`, `city`, `country`, `postal_code`, `price`, `bedrooms`, `bathrooms`, `area`, `floor`, `furnished`, `available`, `type`, `status`, `featured`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Chambre 101 - 1er étage : Chambre Spacieuse avec Lit King-Size', 'chambre-101-1er-etage-chambre-spacieuse-avec-lit-king-size', 'La chambre 101 est située au premier étage et dispose d’un lit king-size confortable, idéal pour se détendre après une longue journée. Elle est décorée avec des tons apaisants et offre une vue imprenable sur le jardin intérieur de l’immeuble. Elle est équipée d’une télévision à écran plat, d’une connexion Wi-Fi gratuite, et d’un bureau de travail pour vos besoins professionnels. La salle de bain privative comprend une douche moderne avec des produits de toilette de qualité. Parfait pour les couples ou les voyageurs d\'affaires recherchant confort et tranquillité.', 'Burundi , Bujumbura', 'Gihosha', 'Burundi', '505', 500.00, 2, 1, 6.00, 1, 0, 1, 'apartment', 'available', 0, 1, '2025-02-19 05:53:51', '2025-02-19 05:53:51', NULL),
(2, 'Chambre 102 - 1er étage : Chambre Double Moderne avec Balcon et Équipements Haut de Gamme', 'chambre-102-1er-etage-chambre-double-moderne-avec-balcon-et-equipements-haut-de-gamme', 'Située au premier étage, la chambre 102 propose un lit double avec des draps en coton de qualité supérieure. Cette chambre lumineuse dispose d’un balcon privé, offrant une vue magnifique sur la rue. Le mobilier moderne et élégant crée une atmosphère accueillante. Elle comprend également une télévision à écran plat, un mini-bar, et un coffre-fort. La salle de bain attenante est équipée d\'une baignoire et de serviettes moelleuses pour une expérience de relaxation optimale. Idéale pour ceux qui cherchent un cadre agréable et pratique.', 'Burundi , Bujumbura', 'Bujumbura', 'Bujumbura', '3202', 480.00, 1, 1, 5.00, 1, 0, 1, 'apartment', 'available', 0, 1, '2025-02-19 06:08:22', '2025-02-19 06:08:22', NULL),
(3, 'Chambre 103 - 1er étage :  Chambre Lits Jumeaux avec Bureau et Vue Panoramique', 'chambre-103-1er-etage-chambre-lits-jumeaux-avec-bureau-et-vue-panoramique', 'La chambre 201, située au deuxième étage, est équipée de deux lits jumeaux, parfaits pour les amis ou les collègues en voyage. L’espace est bien agencé avec un bureau spacieux pour le travail, une chaise ergonomique, et une prise électrique près du lit. La vue panoramique depuis la fenêtre permet de profiter des paysages environnants. La salle de bain privative est équipée d’une douche à l’italienne, de produits cosmétiques haut de gamme et de serviettes douces. Un choix parfait pour les séjours prolongés ou les voyageurs d\'affaires.', 'Burundi , Bujumbura', 'BUJUMBURA', 'Burundi', '505', 630.00, 2, 2, 7.00, 1, 0, 1, 'apartment', 'available', 0, 1, '2025-02-19 06:22:09', '2025-02-19 06:23:53', '2025-02-19 06:23:53'),
(4, 'Chambre 102 - 1er étage : Chambre Lits Jumeaux avec Bureau et Vue Panoramique', 'chambre-102-1er-etage-chambre-lits-jumeaux-avec-bureau-et-vue-panoramique', 'La chambre 201, située au deuxième étage, est équipée de deux lits jumeaux, parfaits pour les amis ou les collègues en voyage. L’espace est bien agencé avec un bureau spacieux pour le travail, une chaise ergonomique, et une prise électrique près du lit. La vue panoramique depuis la fenêtre permet de profiter des paysages environnants. La salle de bain privative est équipée d’une douche à l’italienne, de produits cosmétiques haut de gamme et de serviettes douces. Un choix parfait pour les séjours prolongés ou les voyageurs d\'affaires.', 'Burundi , Bujumbura', 'Bujumbura', 'Burundi', '505', 680.00, 2, 2, 7.00, 1, 0, 1, 'apartment', 'available', 0, 1, '2025-02-19 06:25:56', '2025-02-19 06:25:56', NULL),
(5, 'Cuisine – 1er étage : Cuisine Entièrement Équipée avec Îlot Central et Espace Détente', 'cuisine-1er-etage-cuisine-entierement-equipee-avec-ilot-central-et-espace-detente', 'La cuisine de l’appartement, située au premier étage, est un véritable espace de vie. Avec un design moderne et fonctionnel, elle comprend un îlot central avec des sièges hauts, idéal pour prendre un repas rapide ou discuter en préparant vos plats. La cuisine est entièrement équipée avec des appareils haut de gamme : réfrigérateur, four à convection, plaque de cuisson à induction, micro-ondes, lave-vaisselle, ainsi qu’une machine à café pour vos moments de détente. Les armoires de rangement offrent suffisamment d’espace pour vos courses, et le plan de travail en marbre permet une préparation facile et agréable des repas. La salle à manger attenante peut accueillir confortablement 6 personnes pour des repas conviviaux. Ce lieu est parfait pour les amateurs de cuisine ou les familles qui aiment cuisiner ensemble pendant leur séjour.', 'Burundi , Bujumbura', 'Bujumbura', 'Bujumbura', '322', 800.00, 3, 1, 8.00, 1, 0, 1, 'apartment', 'available', 0, 1, '2025-02-19 06:34:36', '2025-02-19 06:34:36', NULL),
(6, 'Salon – 1er étage :  Salon Lumineux et Confortable avec Canapé Modulable et Espace TV', 'salon-1er-etage-salon-lumineux-et-confortable-avec-canape-modulable-et-espace-tv', 'Le salon spacieux de l’appartement, situé également au premier étage, est un lieu convivial et confortable. L’espace est dominé par un grand canapé modulable en tissu doux, parfait pour se détendre après une journée de visites. Le mobilier moderne et élégant est complété par des éléments décoratifs raffinés et des luminaires contemporains, créant une atmosphère chaleureuse. Vous trouverez également une télévision à écran plat avec chaînes câblées et un lecteur Blu-ray pour vos moments de détente. La pièce est baignée de lumière naturelle grâce à ses grandes fenêtres, offrant une vue dégagée sur la rue. C’est l’endroit idéal pour se retrouver en famille ou entre amis, ou pour profiter d’une soirée tranquille en toute intimité.', 'Burundi , Bujumbura', 'Bujumbura', 'Bujumbura', '250', 700.00, 10, 0, 7.00, 1, 0, 1, 'apartment', 'available', 0, 1, '2025-02-19 06:46:58', '2025-02-19 06:46:58', NULL),
(7, 'Chambre 201 - 2e étage: Chambre Deluxe avec Lit Queen-Size et Coin Salon', 'chambre-201-2e-etage-chambre-deluxe-avec-lit-queen-size-et-coin-salon', 'La chambre 202, au deuxième étage, offre un confort optimal avec un lit queen-size, un coin salon avec fauteuils, et une ambiance élégante. Vous apprécierez l’espace de rangement ample, idéal pour un séjour de longue durée. Cette chambre est équipée de la climatisation, d’une télévision par satellite et d’une machine à café. Le balcon offre une vue dégagée sur les environs. La salle de bain moderne inclut une baignoire avec jets d\'hydromassage, pour un moment de détente après une journée bien remplie. Idéale pour les couples ou ceux qui recherchent un espace confortable et raffiné', 'Burundi , Bujumbura', 'Bujumbura', 'Bujumbura', '6221', 470.00, 1, 1, 6.00, 2, 0, 1, 'apartment', 'available', 0, 1, '2025-02-19 06:53:12', '2025-02-19 06:53:12', NULL),
(8, 'Chambre 202 - 2e étage : Chambre Supérieure avec Lit King-Size et Vue Imprenable sur la Ville', 'chambre-202-2e-etage-chambre-superieure-avec-lit-king-size-et-vue-imprenable-sur-la-ville', 'La chambre 202, au troisième étage, se distingue par sa grande terrasse privée, idéale pour se détendre en plein air. Elle offre un lit king-size, une télévision à écran plat, ainsi qu’un coin salon élégant. L’atmosphère est apaisante grâce à la décoration moderne et chaleureuse. L’espace de travail est bien aménagé pour les professionnels. La salle de bain dispose d’une baignoire avec vue, idéale pour un bain relaxant. Parfait pour les séjours romantiques ou les voyageurs exigeants à la recherche d’un espace raffiné.', 'Burundi , Bujumbura', 'Bujumbura', 'Bujumbura', '5125', 400.00, 1, 1, 0.00, 2, 1, 1, 'apartment', 'available', 0, 1, '2025-02-19 07:00:33', '2025-02-19 07:00:33', NULL),
(9, 'Cuisine – 2e étage : Cuisine Moderne et Spacieuse avec Bar à Petit-Déjeuner et Équipements Premium', 'cuisine-2e-etage-cuisine-moderne-et-spacieuse-avec-bar-a-petit-dejeuner-et-equipements-premium', 'La cuisine au deuxième étage est un espace fonctionnel et moderne, avec un bar à petit-déjeuner pratique et élégant. Elle est équipée de tous les appareils nécessaires pour un séjour agréable : réfrigérateur à double porte, four multifonction, plaque de cuisson à induction, hotte aspirante, et un lave-linge intégré pour plus de commodités. Des ustensiles de cuisine de qualité, des casseroles, et des couteaux tranchants sont également fournis pour répondre à tous vos besoins. Le plan de travail spacieux permet de cuisiner avec confort et facilité. L’ambiance est lumineuse grâce à l\'éclairage sous les armoires et les fenêtres offrant une vue sur le jardin. Idéale pour préparer des repas en famille ou pour des hôtes qui aiment cuisiner.', 'Bujumbura , Gihosha', 'Bujumbura', 'Bujumbura', '320', 480.00, 1, 1, 3.00, 2, 0, 1, 'apartment', 'available', 0, 1, '2025-02-19 07:07:30', '2025-02-19 07:07:30', NULL),
(10, 'Salon – 2e étage :  Cuisine Haut de Gamme avec Îlot Central et Espace Rangement Maximisé', 'salon-2e-etage-cuisine-haut-de-gamme-avec-ilot-central-et-espace-rangement-maximise', 'Le salon du troisième étage est un espace de luxe, où le confort rencontre le style. Avec une vue panoramique imprenable sur la ville, cet espace est parfait pour profiter des couchers de soleil ou des moments de détente. Le canapé modulable en velours est idéal pour se détendre devant la télévision ou discuter entre amis. Un coin bar élégant est aménagé pour vos soirées. Les grandes fenêtres offrent une luminosité naturelle toute la journée. La décoration contemporaine et raffinée donne à la pièce une atmosphère de sophistication et de calme. C’est un espace parfait pour se divertir, recevoir des invités ou simplement profiter d’un moment tranquille en toute sérénité.', 'Burundi , Bujumbura', 'Bujumbura', 'Bujumbura', '4569', 580.00, 1, 1, 4.00, 2, 0, 1, 'apartment', 'available', 0, 1, '2025-02-19 07:19:48', '2025-02-19 07:19:48', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `property_amenities`
--

CREATE TABLE `property_amenities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `amenity_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `property_images`
--

CREATE TABLE `property_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `property_images`
--

INSERT INTO `property_images` (`id`, `property_id`, `image_path`, `is_primary`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'properties/1/original/83a1a6c2-a3a6-4611-9bda-316343c5c0a3.jpg', 1, 0, '2025-02-19 05:53:52', '2025-02-19 05:53:52'),
(2, 1, 'properties/1/original/08f60802-ef79-47f2-954a-596c052ca9d1.jpg', 0, 0, '2025-02-19 05:53:52', '2025-02-19 05:53:52'),
(3, 1, 'properties/1/original/1a95dcf8-330b-4294-85b5-924eb0fc5fd6.jpg', 0, 0, '2025-02-19 05:53:53', '2025-02-19 05:53:53'),
(4, 1, 'properties/1/original/f1516534-2ab8-4c42-a1ce-67b961059b50.jpg', 0, 0, '2025-02-19 05:53:53', '2025-02-19 05:53:53'),
(5, 1, 'properties/1/original/318c93e5-0b9c-4562-9a1b-f3a3448a482d.jpg', 0, 0, '2025-02-19 05:53:54', '2025-02-19 05:53:54'),
(6, 1, 'properties/1/original/b2a40d0f-0f23-4c7c-bb7c-7ab533579c72.jpg', 0, 0, '2025-02-19 05:53:54', '2025-02-19 05:53:54'),
(7, 1, 'properties/1/original/6d30a37e-4f3c-44d2-897a-db2a36d17456.jpg', 0, 0, '2025-02-19 05:53:55', '2025-02-19 05:53:55'),
(8, 1, 'properties/1/original/36091c5a-f419-4909-91f8-22a3f3aa1418.jpg', 0, 0, '2025-02-19 05:53:55', '2025-02-19 05:53:55'),
(9, 1, 'properties/1/original/b8be9b8a-d5ce-448f-b8fc-73edae637272.jpg', 0, 0, '2025-02-19 05:53:56', '2025-02-19 05:53:56'),
(10, 1, 'properties/1/original/b8d0161e-23c0-40bf-aae2-ffd0da737397.jpg', 0, 0, '2025-02-19 05:53:56', '2025-02-19 05:53:56'),
(11, 1, 'properties/1/original/2f2d7bba-e0b8-4fee-b3d7-80ceacd5112f.jpg', 0, 0, '2025-02-19 05:53:57', '2025-02-19 05:53:57'),
(12, 1, 'properties/1/original/5bb49024-bcb9-4985-bef1-a27d84072fb0.jpg', 0, 0, '2025-02-19 05:53:57', '2025-02-19 05:53:57'),
(13, 2, 'properties/2/original/79ef5dd5-023b-499c-8201-6f775292bf52.jpg', 1, 0, '2025-02-19 06:08:23', '2025-02-19 06:08:23'),
(14, 2, 'properties/2/original/f9374b95-63e0-4cc3-88ac-49b8bcbd0f0d.jpg', 0, 0, '2025-02-19 06:08:24', '2025-02-19 06:08:24'),
(15, 2, 'properties/2/original/a30b2695-ac1b-4dbd-9d1b-61a82425bfdb.jpg', 0, 0, '2025-02-19 06:08:26', '2025-02-19 06:08:26'),
(16, 4, 'properties/4/original/529c582e-5ad1-4bfb-aabe-7a149c42f26d.jpg', 1, 0, '2025-02-19 06:25:57', '2025-02-19 06:25:57'),
(17, 4, 'properties/4/original/e9dad519-ae63-4d95-93bf-a2badc6ba2f1.jpg', 0, 0, '2025-02-19 06:25:58', '2025-02-19 06:25:58'),
(18, 4, 'properties/4/original/6cef9ceb-2a56-4e08-b4c9-aa65fee48da0.jpg', 0, 0, '2025-02-19 06:26:00', '2025-02-19 06:26:00'),
(19, 4, 'properties/4/original/6282b23c-2b27-4ec8-8ef5-536257ecb051.jpg', 0, 0, '2025-02-19 06:26:02', '2025-02-19 06:26:02'),
(20, 4, 'properties/4/original/2fa391c2-bbfc-43f5-9124-b2807ac5901f.jpg', 0, 0, '2025-02-19 06:26:04', '2025-02-19 06:26:04'),
(21, 4, 'properties/4/original/94610597-57c3-4e39-87ab-1418c7d05b96.jpg', 0, 0, '2025-02-19 06:26:06', '2025-02-19 06:26:06'),
(22, 4, 'properties/4/original/0ae7af8c-3957-442e-876c-963e5e1af90e.jpg', 0, 0, '2025-02-19 06:26:09', '2025-02-19 06:26:09'),
(23, 4, 'properties/4/original/81ef2217-f4e5-4705-9802-21e56021518a.jpg', 0, 0, '2025-02-19 06:26:11', '2025-02-19 06:26:11'),
(24, 4, 'properties/4/original/61d5fb54-d21d-4f7a-b0e6-dbef25d7d985.jpg', 0, 0, '2025-02-19 06:26:13', '2025-02-19 06:26:13'),
(25, 5, 'properties/5/original/18ce45d5-0dbc-433c-bf92-715bf8a80f90.jpg', 1, 0, '2025-02-19 06:34:37', '2025-02-19 06:34:37'),
(26, 5, 'properties/5/original/507542c6-7e01-4ea8-907b-a613d19c7530.jpg', 0, 0, '2025-02-19 06:34:38', '2025-02-19 06:34:38'),
(27, 5, 'properties/5/original/388b2328-cedf-41f9-b992-2af171e36a5e.jpg', 0, 0, '2025-02-19 06:34:39', '2025-02-19 06:34:39'),
(28, 5, 'properties/5/original/14248094-adb8-46ee-82e3-3b40525bfceb.jpg', 0, 0, '2025-02-19 06:34:40', '2025-02-19 06:34:40'),
(29, 5, 'properties/5/original/06c03f81-823a-471a-b92e-94ab80b92c77.jpg', 0, 0, '2025-02-19 06:34:42', '2025-02-19 06:34:42'),
(30, 6, 'properties/6/original/94bfaadd-ff9d-446d-afb9-b4b37869bd83.jpg', 1, 0, '2025-02-19 06:46:59', '2025-02-19 06:46:59'),
(31, 6, 'properties/6/original/fc54f8e2-1eee-4062-b0f5-abdeef715323.jpg', 0, 0, '2025-02-19 06:47:00', '2025-02-19 06:47:00'),
(32, 6, 'properties/6/original/34a470aa-4385-402a-858a-1a9c55b457a9.jpg', 0, 0, '2025-02-19 06:47:01', '2025-02-19 06:47:01'),
(33, 6, 'properties/6/original/85ac137d-2d98-4463-bfb9-230d4efaa137.jpg', 0, 0, '2025-02-19 06:47:02', '2025-02-19 06:47:02'),
(34, 6, 'properties/6/original/afa21e21-d47e-42d5-aee6-35b0038c4cc6.jpg', 0, 0, '2025-02-19 06:47:04', '2025-02-19 06:47:04'),
(35, 6, 'properties/6/original/be286c53-bf61-47ad-bc41-48cb8cc26cb8.jpg', 0, 0, '2025-02-19 06:47:05', '2025-02-19 06:47:05'),
(36, 6, 'properties/6/original/d3dd340a-f188-4668-aecd-e0c3466af25b.jpg', 0, 0, '2025-02-19 06:47:06', '2025-02-19 06:47:06'),
(37, 6, 'properties/6/original/97a0942c-9c04-4d7b-82fc-bb83822088d6.jpg', 0, 0, '2025-02-19 06:47:08', '2025-02-19 06:47:08'),
(38, 7, 'properties/7/original/1fe16dda-9243-4c5f-a605-b8f3fde81ddb.jpg', 1, 0, '2025-02-19 06:53:13', '2025-02-19 06:53:13'),
(39, 7, 'properties/7/original/6c82c3f9-ed59-4114-84cc-b5e9d1aa3746.jpg', 0, 0, '2025-02-19 06:53:15', '2025-02-19 06:53:15'),
(40, 7, 'properties/7/original/5c165116-5c3a-4f0e-967b-abcc3445e0cc.jpg', 0, 0, '2025-02-19 06:53:16', '2025-02-19 06:53:16'),
(41, 7, 'properties/7/original/474df96e-cd9d-41d8-a842-3bedcb1419f2.jpg', 0, 0, '2025-02-19 06:53:17', '2025-02-19 06:53:17'),
(42, 7, 'properties/7/original/05327529-65bb-4ade-8eb2-8c16bfadc6fa.jpg', 0, 0, '2025-02-19 06:53:19', '2025-02-19 06:53:19'),
(43, 7, 'properties/7/original/b4620675-96cb-4ac1-8e4f-f51d037fc794.jpg', 0, 0, '2025-02-19 06:53:20', '2025-02-19 06:53:20'),
(44, 7, 'properties/7/original/5fcc0207-850a-467e-9014-02b5b332952e.jpg', 0, 0, '2025-02-19 06:53:21', '2025-02-19 06:53:21'),
(45, 8, 'properties/8/original/396ef196-27be-4b18-a10b-027054096f9c.jpg', 1, 0, '2025-02-19 07:00:34', '2025-02-19 07:00:34'),
(46, 8, 'properties/8/original/9f6139ee-373c-4aff-b4bc-54a6d2253c48.jpg', 0, 0, '2025-02-19 07:00:36', '2025-02-19 07:00:36'),
(47, 8, 'properties/8/original/a3354a6c-db3d-492a-9f1f-c5e43754f771.jpg', 0, 0, '2025-02-19 07:00:38', '2025-02-19 07:00:38'),
(48, 8, 'properties/8/original/ba75758c-1e1d-4134-a6f9-0481fb8c53e9.jpg', 0, 0, '2025-02-19 07:00:38', '2025-02-19 07:00:38'),
(49, 8, 'properties/8/original/d4894490-c92e-4a4b-bf4d-866ab595db73.jpg', 0, 0, '2025-02-19 07:00:40', '2025-02-19 07:00:40'),
(50, 8, 'properties/8/original/42ef868b-616a-4fdb-b8f6-4523d4ab2c8e.jpg', 0, 0, '2025-02-19 07:00:42', '2025-02-19 07:00:42'),
(51, 8, 'properties/8/original/d510f3fa-0e27-47ca-930f-a618f7897c93.jpg', 0, 0, '2025-02-19 07:00:44', '2025-02-19 07:00:44'),
(52, 8, 'properties/8/original/8765efb1-23f9-43d8-b40e-c885c1ece8f3.jpg', 0, 0, '2025-02-19 07:00:45', '2025-02-19 07:00:45'),
(53, 9, 'properties/9/original/e5d6f12b-1d77-4fa0-a4b7-41e763ab707a.jpg', 1, 0, '2025-02-19 07:07:33', '2025-02-19 07:07:33'),
(54, 9, 'properties/9/original/f874723f-e9b0-4f12-aeb0-825286e7ee44.jpg', 0, 0, '2025-02-19 07:07:36', '2025-02-19 07:07:36'),
(55, 9, 'properties/9/original/548c893f-d1d5-48f7-a184-b1ace4d59ffe.jpg', 0, 0, '2025-02-19 07:07:39', '2025-02-19 07:07:39'),
(56, 9, 'properties/9/original/a96136c0-ba93-4104-ad95-416a273af609.jpg', 0, 0, '2025-02-19 07:07:42', '2025-02-19 07:07:42'),
(57, 9, 'properties/9/original/8c00c7e3-a420-404c-ad8c-d472101f06f3.jpg', 0, 0, '2025-02-19 07:07:45', '2025-02-19 07:07:45'),
(58, 9, 'properties/9/original/f2706695-933f-485f-ac88-ba99db2960e3.jpg', 0, 0, '2025-02-19 07:07:48', '2025-02-19 07:07:48'),
(59, 9, 'properties/9/original/dc1a6603-275f-4d63-aa7c-c24f2120ab3d.jpg', 0, 0, '2025-02-19 07:07:51', '2025-02-19 07:07:51'),
(60, 10, 'properties/10/original/77156f94-6cf7-4ca9-b6d3-225c14370750.jpg', 1, 0, '2025-02-19 07:19:49', '2025-02-19 07:19:49'),
(61, 10, 'properties/10/original/a5ffd519-4acb-4524-9ec3-3086091b8653.jpg', 0, 0, '2025-02-19 07:19:50', '2025-02-19 07:19:50'),
(62, 10, 'properties/10/original/66111d9c-86c8-4e2c-81e8-9374ffe5f035.jpg', 0, 0, '2025-02-19 07:19:52', '2025-02-19 07:19:52'),
(63, 10, 'properties/10/original/daa15a50-6664-4d33-aa32-18144f1304fa.jpg', 0, 0, '2025-02-19 07:19:53', '2025-02-19 07:19:53'),
(64, 10, 'properties/10/original/e2ba0d10-d6b5-4195-bd5d-fbf2ca65de17.jpg', 0, 0, '2025-02-19 07:19:55', '2025-02-19 07:19:55'),
(65, 10, 'properties/10/original/c351b5be-2117-4be0-9075-9a0ea33aa147.jpg', 0, 0, '2025-02-19 07:19:56', '2025-02-19 07:19:56'),
(66, 10, 'properties/10/original/d5c9e189-8d09-4949-998f-699898ecbafe.jpg', 0, 0, '2025-02-19 07:19:57', '2025-02-19 07:19:57'),
(67, 10, 'properties/10/original/f650efcf-d0de-446a-8340-d2c0c16d533a.jpg', 0, 0, '2025-02-19 07:19:58', '2025-02-19 07:19:58');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `guests` int(11) NOT NULL,
  `status` enum('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending','paid','refunded') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `total_paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `motif_annulation` varchar(255) DEFAULT NULL,
  `date_annulation` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `property_id`, `user_id`, `check_in`, `check_out`, `total_price`, `guests`, `status`, `payment_status`, `notes`, `total_paid`, `motif_annulation`, `date_annulation`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 6, 1, '2025-02-21', '2025-02-23', 1400.00, 1, 'pending', 'pending', NULL, 0.00, NULL, NULL, '2025-02-19 07:17:08', '2025-02-19 07:17:08', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reservation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('fbFaxm96sRbuMENj48bJm0aLh9FkEQUlzw5nmsQb', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieXJjMXAyajluZWtwbHFsYWl3WkY0Q1E3eEZGaHJrbVNyU0h0c3BSMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jbGllbnQvcmVzZXJ2YXRpb25zIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1739957009);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','owner','tenant','agent','client') DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `address`, `role`, `avatar`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Jean Lionel', 'nijeanlionel@gmail.com', '2001-01-10 03:31:57', '$2y$12$H9EoryHts7.CjWkm/ktnE..8K0qTdLHQPm0pfkVm4pLeVn1tHr1tu', '(209) 792-9228', 'Itaque maiores tempora voluptate aut sit placeat. Alias et consequatur sed est. Maiores voluptatibus sint perferendis iste. Libero eos quaerat dicta et.', 'admin', 'avatars/jb26MxD50VuujLrG3zrPOGHzR0Z6ltbwaAo2mpDE.jpg', 'active', '845f2725-4873-3042-876c-9b4466ac19c3', '2025-02-19 05:30:28', '2025-02-19 05:32:55', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `depenses`
--
ALTER TABLE `depenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depenses_user_id_foreign` (`user_id`);

--
-- Index pour la table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_property_id_foreign` (`property_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `maintenances`
--
ALTER TABLE `maintenances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintenances_property_id_foreign` (`property_id`),
  ADD KEY `maintenances_reported_by_foreign` (`reported_by`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`),
  ADD KEY `messages_property_id_foreign` (`property_id`);

--
-- Index pour la table `message_attachments`
--
ALTER TABLE `message_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_attachments_message_id_foreign` (`message_id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`),
  ADD KEY `notifications_notifiable_id_foreign` (`notifiable_id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_reservation_id_foreign` (`reservation_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Index pour la table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `properties_slug_unique` (`slug`),
  ADD KEY `properties_user_id_foreign` (`user_id`);

--
-- Index pour la table `property_amenities`
--
ALTER TABLE `property_amenities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_amenities_property_id_foreign` (`property_id`),
  ADD KEY `property_amenities_amenity_id_foreign` (`amenity_id`);

--
-- Index pour la table `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_images_property_id_foreign` (`property_id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservations_property_id_foreign` (`property_id`),
  ADD KEY `reservations_user_id_foreign` (`user_id`);

--
-- Index pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_property_id_foreign` (`property_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_reservation_id_foreign` (`reservation_id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `depenses`
--
ALTER TABLE `depenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `maintenances`
--
ALTER TABLE `maintenances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `message_attachments`
--
ALTER TABLE `message_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `property_amenities`
--
ALTER TABLE `property_amenities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `depenses`
--
ALTER TABLE `depenses`
  ADD CONSTRAINT `depenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`);

--
-- Contraintes pour la table `maintenances`
--
ALTER TABLE `maintenances`
  ADD CONSTRAINT `maintenances_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`),
  ADD CONSTRAINT `maintenances_reported_by_foreign` FOREIGN KEY (`reported_by`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`),
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `message_attachments`
--
ALTER TABLE `message_attachments`
  ADD CONSTRAINT `message_attachments_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_notifiable_id_foreign` FOREIGN KEY (`notifiable_id`) REFERENCES `notifiables` (`id`),
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`),
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `property_amenities`
--
ALTER TABLE `property_amenities`
  ADD CONSTRAINT `property_amenities_amenity_id_foreign` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`),
  ADD CONSTRAINT `property_amenities_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`);

--
-- Contraintes pour la table `property_images`
--
ALTER TABLE `property_images`
  ADD CONSTRAINT `property_images_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`);

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`),
  ADD CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`),
  ADD CONSTRAINT `reviews_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`),
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
