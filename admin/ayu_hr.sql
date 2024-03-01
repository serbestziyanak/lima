/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100427 (10.4.27-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : ayu_hr

 Target Server Type    : MySQL
 Target Server Version : 100427 (10.4.27-MariaDB)
 File Encoding         : 65001

 Date: 18/09/2023 01:21:38
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bolumler
-- ----------------------------
DROP TABLE IF EXISTS `bolumler`;
CREATE TABLE `bolumler`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `birim_id` int NULL DEFAULT NULL,
  `bolum_adi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `duzey` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fakulte` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 159 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bolumler
-- ----------------------------
INSERT INTO `bolumler` VALUES (80, 62, 'Педагогика және психология', 'Бакалавриат', 'Sosyal ve Beşeri bilimler Fakültesi');
INSERT INTO `bolumler` VALUES (81, 63, 'Мектепке дейінгі және бастауышта білім беру', 'Бакалавриат', 'Sosyal ve Beşeri bilimler Fakültesi');
INSERT INTO `bolumler` VALUES (82, 64, 'Тарих', 'Бакалавриат', 'Sosyal ve Beşeri bilimler Fakültesi');
INSERT INTO `bolumler` VALUES (83, 65, 'Журналистика', 'Бакалавриат', 'Sosyal ve Beşeri bilimler Fakültesi');
INSERT INTO `bolumler` VALUES (84, 66, 'Педагогика және психология', 'Магистратура', 'Sosyal ve Beşeri bilimler Fakültesi');
INSERT INTO `bolumler` VALUES (85, 67, 'Мектепке дейінгі және бастауышта білім беру', 'Магистратура', 'Sosyal ve Beşeri bilimler Fakültesi');
INSERT INTO `bolumler` VALUES (86, 68, 'Тарих', 'Магистратура', 'Sosyal ve Beşeri bilimler Fakültesi');
INSERT INTO `bolumler` VALUES (87, 69, 'Дене мәдениеті', 'Бакалавриат', 'Spor ve Sanat Fakültesi');
INSERT INTO `bolumler` VALUES (88, 70, 'Орындаушылық өнер', 'Бакалавриат', 'Spor ve Sanat Fakültesi');
INSERT INTO `bolumler` VALUES (89, 71, 'Бейнелеу өнері', 'Бакалавриат', 'Spor ve Sanat Fakültesi');
INSERT INTO `bolumler` VALUES (90, 72, 'Дене мәдениеті', 'Магистратура', 'Spor ve Sanat Fakültesi');
INSERT INTO `bolumler` VALUES (91, 73, 'Орындаушылық өнер', 'Магистратура', 'Spor ve Sanat Fakültesi');
INSERT INTO `bolumler` VALUES (92, 74, 'Бейнелеу өнері', 'Магистратура', 'Spor ve Sanat Fakültesi');
INSERT INTO `bolumler` VALUES (93, 75, 'Математика', 'Бакалавриат', 'Fen Fakültesi');
INSERT INTO `bolumler` VALUES (94, 76, 'Физика', 'Бакалавриат', 'Fen Fakültesi');
INSERT INTO `bolumler` VALUES (95, 77, 'Экология және химия', 'Бакалавриат', 'Fen Fakültesi');
INSERT INTO `bolumler` VALUES (96, 78, 'Биология', 'Бакалавриат', 'Fen Fakültesi');
INSERT INTO `bolumler` VALUES (97, 79, 'Физика', 'Магистратура', 'Fen Fakültesi');
INSERT INTO `bolumler` VALUES (98, 80, 'Математика', 'Магистратура', 'Fen Fakültesi');
INSERT INTO `bolumler` VALUES (99, 81, 'Экология және химия', 'Магистратура', 'Fen Fakültesi');
INSERT INTO `bolumler` VALUES (100, 82, 'Биология', 'Магистратура', 'Fen Fakültesi');
INSERT INTO `bolumler` VALUES (101, 83, 'Компьютерлік ғылымдар', 'Бакалавриат', 'Mühendislik Fakültesi');
INSERT INTO `bolumler` VALUES (102, 84, 'Компьютерлік инженерия', 'Бакалавриат', 'Mühendislik Fakültesi');
INSERT INTO `bolumler` VALUES (103, 85, 'Электр инженериясы', 'Бакалавриат', 'Mühendislik Fakültesi');
INSERT INTO `bolumler` VALUES (104, 86, 'Компьютерлік ғылымдар', 'Магистратура', 'Mühendislik Fakültesi');
INSERT INTO `bolumler` VALUES (105, 87, 'Компьютерлік инженерия', 'Магистратура', 'Mühendislik Fakültesi');
INSERT INTO `bolumler` VALUES (106, 88, 'Электр инженериясы', 'Магистратура', 'Mühendislik Fakültesi');
INSERT INTO `bolumler` VALUES (107, 89, 'Компьютерлік ғылымдар', 'Докторантура', 'Mühendislik Fakültesi');
INSERT INTO `bolumler` VALUES (108, 90, 'Компьютерлік инженерия', 'Докторантура', 'Mühendislik Fakültesi');
INSERT INTO `bolumler` VALUES (109, 92, 'Қазақ филологиясы ', 'Бакалавриат', 'Filoloji Fakültesi');
INSERT INTO `bolumler` VALUES (110, 93, 'Орыс тілі және әдебиеті', 'Бакалавриат', 'Filoloji Fakültesi');
INSERT INTO `bolumler` VALUES (111, 94, 'Педагогикалық шетел тілдері', 'Бакалавриат', 'Filoloji Fakültesi');
INSERT INTO `bolumler` VALUES (112, 95, 'Түрік филологиясы', 'Бакалавриат', 'Filoloji Fakültesi');
INSERT INTO `bolumler` VALUES (113, 96, 'Ағылшын филологиясы және аударма ісі', 'Бакалавриат', 'Filoloji Fakültesi');
INSERT INTO `bolumler` VALUES (114, 98, 'Педагогикалық шетел тілдері', 'Магистратура', 'Filoloji Fakültesi');
INSERT INTO `bolumler` VALUES (115, 99, 'Қазақ филологиясы ', 'Магистратура', 'Filoloji Fakültesi');
INSERT INTO `bolumler` VALUES (116, 100, 'Орыс тілі және әдебиеті', 'Магистратура', 'Filoloji Fakültesi');
INSERT INTO `bolumler` VALUES (117, 101, 'Түрік филологиясы', 'Магистратура', 'Filoloji Fakültesi');
INSERT INTO `bolumler` VALUES (118, 102, 'Ағылшын филологиясы және аударма ісі', 'Магистратура', 'Filoloji Fakültesi');
INSERT INTO `bolumler` VALUES (119, 105, 'Қазақ филологиясы ', 'Докторантура', 'Filoloji Fakültesi');
INSERT INTO `bolumler` VALUES (120, 106, 'Педагогикалық шетел тілдері', 'Докторантура', 'Filoloji Fakültesi');
INSERT INTO `bolumler` VALUES (121, 110, 'Дінтану', 'Бакалавриат', 'Teoloji Fakültesi');
INSERT INTO `bolumler` VALUES (122, 111, 'Теология', 'Бакалавриат', 'Teoloji Fakültesi');
INSERT INTO `bolumler` VALUES (123, 112, 'Дінтану', 'Магистратура', 'Teoloji Fakültesi');
INSERT INTO `bolumler` VALUES (124, 113, 'Теология', 'Магистратура', 'Teoloji Fakültesi');
INSERT INTO `bolumler` VALUES (125, 114, 'Мемлекеттік басқару және халықаралық қатынастар', 'Бакалавриат', 'İktisadi ve İdari Bilimler Fakültesi');
INSERT INTO `bolumler` VALUES (126, 115, 'Менеджмент және туризм ', 'Бакалавриат', 'İktisadi ve İdari Bilimler Fakültesi');
INSERT INTO `bolumler` VALUES (127, 116, 'Экономика, қаржы және есеп', 'Бакалавриат', 'İktisadi ve İdari Bilimler Fakültesi');
INSERT INTO `bolumler` VALUES (128, 117, 'Құқықтану', 'Бакалавриат', 'İktisadi ve İdari Bilimler Fakültesi');
INSERT INTO `bolumler` VALUES (129, 118, 'Мемлекеттік басқару және халықаралық қатынастар', 'Магистратура', 'İktisadi ve İdari Bilimler Fakültesi');
INSERT INTO `bolumler` VALUES (130, 119, 'Экономика, қаржы және есеп', 'Магистратура', 'İktisadi ve İdari Bilimler Fakültesi');
INSERT INTO `bolumler` VALUES (131, 120, 'Менеджмент және туризм', 'Магистратура', 'İktisadi ve İdari Bilimler Fakültesi');
INSERT INTO `bolumler` VALUES (132, 121, 'Құқықтану', 'Магистратура', 'İktisadi ve İdari Bilimler Fakültesi');
INSERT INTO `bolumler` VALUES (133, 122, 'Экономика, қаржы және есеп', 'Докторантура', 'İktisadi ve İdari Bilimler Fakültesi');
INSERT INTO `bolumler` VALUES (134, 123, 'Менеджмент және туризм ', 'Докторантура', 'İktisadi ve İdari Bilimler Fakültesi');
INSERT INTO `bolumler` VALUES (135, 124, 'Мемлекеттік басқару және халықаралық қатынастар', 'Докторантура', 'İktisadi ve İdari Bilimler Fakültesi');
INSERT INTO `bolumler` VALUES (136, 125, 'Құқықтану', 'Докторантура', 'İktisadi ve İdari Bilimler Fakültesi');
INSERT INTO `bolumler` VALUES (137, 126, '', 'Бакалавриат', 'Tıp Fakültesi');
INSERT INTO `bolumler` VALUES (138, 127, '', 'Магистратура', 'Tıp Fakültesi');
INSERT INTO `bolumler` VALUES (139, 128, '', 'Докторантура', 'Tıp Fakültesi');
INSERT INTO `bolumler` VALUES (141, 130, 'Экология және химия', 'Магистратура', 'Fen Bilimleri Fakültesi');
INSERT INTO `bolumler` VALUES (142, 131, 'Физика', 'Магистратура', 'Fen Bilimleri Fakültesi');
INSERT INTO `bolumler` VALUES (143, 132, 'Математика', 'Магистратура', 'Fen Bilimleri Fakültesi');
INSERT INTO `bolumler` VALUES (144, 133, 'Математика', 'Докторантура', 'Fen Bilimleri Fakültesi');
INSERT INTO `bolumler` VALUES (145, 134, 'Физика', 'Докторантура', 'Fen Bilimleri Fakültesi');
INSERT INTO `bolumler` VALUES (146, 135, 'Педагогика және психология', 'Докторантура', 'İnsan Ve Toplum Bilimleri Fakültesi');
INSERT INTO `bolumler` VALUES (147, 136, 'Тарих', 'Докторантура', 'İnsan Ve Toplum Bilimleri Fakültesi');
INSERT INTO `bolumler` VALUES (148, 137, 'Акушерлік гинекология', 'Резидентура ', 'Lisansüstü Tıp Eğitimi  Fakültesi');
INSERT INTO `bolumler` VALUES (149, 138, 'Арнайы хирургиялық пәндер', 'Резидентура ', 'Lisansüstü Tıp Eğitimi  Fakültesi');
INSERT INTO `bolumler` VALUES (150, 139, 'Жалпы дәрігерлік практика № 1', 'Резидентура ', 'Lisansüstü Tıp Eğitimi  Fakültesi');
INSERT INTO `bolumler` VALUES (151, 140, 'Жалпы дәрігерлік практика № 2', 'Резидентура ', 'Lisansüstü Tıp Eğitimi  Fakültesi');
INSERT INTO `bolumler` VALUES (152, 141, 'Жұқпалы аурулар және фтизиатрия', 'Резидентура ', 'Lisansüstü Tıp Eğitimi  Fakültesi');
INSERT INTO `bolumler` VALUES (153, 142, 'Ішкі аурулар', 'Резидентура ', 'Lisansüstü Tıp Eğitimi  Fakültesi');
INSERT INTO `bolumler` VALUES (154, 143, 'Неврология, психиатрия, наркология', 'Резидентура ', 'Lisansüstü Tıp Eğitimi  Fakültesi');
INSERT INTO `bolumler` VALUES (155, 144, 'Педиатрия', 'Резидентура ', 'Lisansüstü Tıp Eğitimi  Fakültesi');
INSERT INTO `bolumler` VALUES (156, 145, 'Профилактикалық медицина және стоматологиялық пәндер', 'Резидентура ', 'Lisansüstü Tıp Eğitimi  Fakültesi');
INSERT INTO `bolumler` VALUES (157, 146, 'Хирургия және анестезиология-реанимация', 'Резидентура ', 'Lisansüstü Tıp Eğitimi  Fakültesi');
INSERT INTO `bolumler` VALUES (158, 147, 'Стоматология', 'Бакалавриат', 'Diş Hekimliği Fakültesi');

-- ----------------------------
-- Table structure for deneme
-- ----------------------------
DROP TABLE IF EXISTS `deneme`;
CREATE TABLE `deneme`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `a1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `a2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `a3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `a4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `a5` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `a6` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `a7` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `a8` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `a9` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `a10` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `a11` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `a12` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ust_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 175 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of deneme
-- ----------------------------
INSERT INTO `deneme` VALUES (1, 'Sosyal ve Beşeri bilimler Fakültesi', 'Педагогика және психология', 'Педагогики и психологии', 'Pedagogy and psychology', 'Pedagoji ve psikoloji', 'Бакалавриат', '6B01101', 'Педагогика и психология', 'Педагогика және психология', 'Рedagogy and psychology', 'Pedagoji ve Psikoloji', NULL, 62);
INSERT INTO `deneme` VALUES (2, 'Sosyal ve Beşeri bilimler Fakültesi', 'Мектепке дейінгі және бастауышта білім беру', 'Дошкольного и начального образования', 'Preschool and primary education', 'Okul öncesi ve ilkokul eğitimi', 'Бакалавриат', '6B01202', 'Дошкольное обучение и воспитание', 'Мектепке дейінгі оқыту және тәрбиелеу', 'Pre-school education and upbringing', 'Okul Öncesi Eğitim ve Öğretim', NULL, 63);
INSERT INTO `deneme` VALUES (3, 'Sosyal ve Beşeri bilimler Fakültesi', 'Мектепке дейінгі және бастауышта білім беру', 'Дошкольного и начального образования', 'Preschool and primary education', 'Okul öncesi ve ilkokul eğitimi', 'Бакалавриат', '6B01303', 'Педагогика и методика начального обучения', 'Бастауышта оқыту педагогикасы мен әдістемесі', 'Pedagogy and methods of primary education ', 'İlköğretim Pedagojisi ve Metodolojisi', NULL, 63);
INSERT INTO `deneme` VALUES (4, 'Spor ve Sanat Fakültesi', 'Дене мәдениеті', 'Физической культуры', 'Physical education', 'Beden eğitimi', 'Бакалавриат', '6B01404', 'Начальная военная подготовка', 'Бастапқы әскери дайындық', 'Basic Military Training', 'İlk Askeri Hazırlık', NULL, 69);
INSERT INTO `deneme` VALUES (5, 'Spor ve Sanat Fakültesi', 'Дене мәдениеті', 'Физической культуры', 'Physical education', 'Beden eğitimi', 'Бакалавриат', '6B01405', 'Физическая культура и спорт', 'Денешынықтыру және спорт', 'Physical education and sports', 'Beden Eğitimi ve Spor', NULL, 69);
INSERT INTO `deneme` VALUES (6, 'Spor ve Sanat Fakültesi', 'Дене мәдениеті', 'Физической культуры', 'Physical education', 'Beden eğitimi', 'Бакалавриат', '6B01485', 'Физическая культура и начальная военная подготовка', 'Дене шынықтыру және бастапқы әскери дайындық', 'Physical education and initial military training', 'Beden Eğitimi ve Spor', NULL, 69);
INSERT INTO `deneme` VALUES (7, 'Spor ve Sanat Fakültesi', 'Орындаушылық өнер', 'Исполнительского искусства', 'Executive search', 'Sahne sanatları', 'Бакалавриат', '6B01406', 'Музыкальное образование', 'Музыкалық білім', 'Music Education', 'Müzik Eğitimi', NULL, 70);
INSERT INTO `deneme` VALUES (8, 'Spor ve Sanat Fakültesi', 'Бейнелеу өнері', 'Изобразительного искусство', 'Fine arts', 'Güzel sanatlar', 'Бакалавриат', '6B01408', 'Изобразительное искусство и черчение', 'Бейнелеу өнері және сызу', 'Fine Art and Drawing', 'Güzel Sanatlar ve Çizim', NULL, 71);
INSERT INTO `deneme` VALUES (9, 'Spor ve Sanat Fakültesi', 'Бейнелеу өнері', 'Изобразительного искусство', 'Fine arts', 'Güzel sanatlar', 'Бакалавриат', '6B01407', 'Профессиональное обучение', 'Кәсіптік оқыту', 'Professional Training', 'Meslekî Eğitim', NULL, 71);
INSERT INTO `deneme` VALUES (10, 'Spor ve Sanat Fakültesi', 'Бейнелеу өнері', 'Изобразительного искусство', 'Fine arts', 'Güzel sanatlar', 'Бакалавриат', '6B01478', 'Художественный труд и графическое проектирование ', 'Көркем еңбек және графикалық жобалау ', 'Artistic work and graphic design', 'Sanatsal Çalışma ve Grafik Çizim', NULL, 71);
INSERT INTO `deneme` VALUES (11, 'Fen Fakültesi', 'Математика', 'Математики', 'Mathematicians', 'Matematikler', 'Бакалавриат', '6B01509', 'Математика', 'Математика', 'Mathematics', 'Matematik Öğretmenliği', NULL, 75);
INSERT INTO `deneme` VALUES (12, 'Fen Fakültesi', 'Физика', 'Физики', 'Physicists', 'Fizikler', 'Бакалавриат', '6B01510', 'Физика', 'Физика', 'Physics', 'Fizik Öğretmenliği', NULL, 76);
INSERT INTO `deneme` VALUES (13, 'Mühendislik Fakültesi', 'Компьютерлік ғылымдар', 'Компьютерных наук', 'Computer Science', 'Bilgisayar Bilimi', 'Бакалавриат', '6B01511', 'Информатика', 'Информатика', 'Computer Science ', 'Bilgi İşlem', NULL, 83);
INSERT INTO `deneme` VALUES (14, 'Mühendislik Fakültesi', 'Компьютерлік ғылымдар', 'Компьютерных наук', 'Computer Science', 'Bilgisayar Bilimi', 'Бакалавриат', '6B01573', 'Информатика, ИКТ и робототехника ', 'Информатика, АКТ және робототехника ', 'Computer Science, ICT and robotic', 'Bilgi İşlem, Bilişim Teknolojileri ve Robototeknik ', NULL, 83);
INSERT INTO `deneme` VALUES (15, 'Fen Fakültesi', 'Экология және химия', 'Экологии и химии', 'Ecology and Chemistry', 'Ekoloji ve Kimya', 'Бакалавриат', '6B01512', 'Химия', 'Химия', 'Chemistry', 'Kimya Öğetmenliği', NULL, 77);
INSERT INTO `deneme` VALUES (16, 'Fen Fakültesi', 'Экология және химия', 'Экологии и химии', 'Ecology and Chemistry', 'Ekoloji ve Kimya', 'Бакалавриат', '6B01562 ', 'Химия-Биология ', 'Химия-Биология ', 'Chemistry-Biology ', 'Kimya-Biyoloji Öğretmenliği', NULL, 77);
INSERT INTO `deneme` VALUES (17, 'Fen Fakültesi', 'Биология', 'Биологии', 'Biology', 'Biyolojiler', 'Бакалавриат', '6B01513', 'Биология', 'Биология', 'Biology', 'Biyoloji Öğretmenliği', NULL, 78);
INSERT INTO `deneme` VALUES (18, 'Fen Fakültesi', 'Экология және химия', 'Экологии и химии', 'Ecology and Chemistry', 'Ekoloji ve Kimya', 'Бакалавриат', '6B01514', 'География', 'География', 'Geography', 'Coğrafya Öğretmenliği', NULL, 77);
INSERT INTO `deneme` VALUES (19, 'Sosyal ve Beşeri bilimler Fakültesi', 'Тарих', 'Истории', 'Historii', 'Tarih', 'Бакалавриат', '6B01615', 'История', 'Тарих', 'History', 'Tarih Öğretmenliği', NULL, 64);
INSERT INTO `deneme` VALUES (20, 'Filoloji Fakültesi', 'Қазақ филологиясы ', 'Казахской филологии ', 'Kazakh Philology', 'Kazak Filolojisi', 'Бакалавриат', '6B01716', 'Казахский язык и литература', 'Қазақ тілі мен әдебиеті', 'Kazakh language and literature', 'Kazak Dili ve Edebiyatı', NULL, 92);
INSERT INTO `deneme` VALUES (21, 'Filoloji Fakültesi', 'Орыс тілі және әдебиеті', 'Русского языка и литература', 'Russian language and literature', 'Rus dili ve edebiyatı', 'Бакалавриат', '6B01717', 'Русский язык и литература', 'Орыс тілі мен әдебиеті', 'Russian language and literature ', 'Rus Dili ve Edebiyatı', NULL, 93);
INSERT INTO `deneme` VALUES (22, 'Filoloji Fakültesi', 'Орыс тілі және әдебиеті', 'Русского языка и литература', 'Russian language and literature', 'Rus dili ve edebiyatı', 'Бакалавриат', '6B01764', 'Русский язык и литература с нерусским языком обучения ', 'Орыс тілінде оқытпайтын мектептердегі орыс тілі мен әдебиеті  ', 'Russian Language and Literature in International  Schools ', 'Rusçada Eğitim Vermeyen Okullarda Rus Dili ve Edebiyatı', NULL, 93);
INSERT INTO `deneme` VALUES (23, 'Filoloji Fakültesi', 'Педагогикалық шетел тілдері', 'Педагогических иностранных языков', 'Pedagogical foreign languages', 'Pedagojik yabancı diller', 'Бакалавриат', '6B01718  ', 'Иностранный язык: два иностранных языка (английский-китайский)', 'Шетел тілі: екі шетел тілі (ағылшын-қытай)', 'Foreign language: two foreign languages (English - Chinese )', 'İngilizce Çince Öğretmenliği', NULL, 94);
INSERT INTO `deneme` VALUES (24, 'Filoloji Fakültesi', 'Педагогикалық шетел тілдері', 'Педагогических иностранных языков', 'Pedagogical foreign languages', 'Pedagojik yabancı diller', 'Бакалавриат', '6B01719 ', 'Иностранный язык: два иностранных языка (английский-турецский)', 'Шетел тілі: екі шетел тілі (ағылшын-түрік)', 'Foreign Language: Two Foreign Languages(English -Turkish )', 'İngilizce Türkçe Öğretmenliği', NULL, 94);
INSERT INTO `deneme` VALUES (25, 'Spor ve Sanat Fakültesi', 'Орындаушылық өнер', 'Исполнительского искусства', 'Executive search', 'Sahne sanatları', 'Бакалавриат', '6B02121', 'Вокальное искусство', 'Вокалдық өнер', 'Vocal art', 'Vokal Sanatı', NULL, 70);
INSERT INTO `deneme` VALUES (26, 'Spor ve Sanat Fakültesi', 'Орындаушылық өнер', 'Исполнительского искусства', 'Executive search', 'Sahne sanatları', 'Бакалавриат', '6B02165', 'Искусство эстрады', 'Эстрада өнері', 'Pop art ', 'Pop Müzik Sanatı ', NULL, 70);
INSERT INTO `deneme` VALUES (27, 'Spor ve Sanat Fakültesi', 'Орындаушылық өнер', 'Исполнительского искусства', 'Executive search', 'Sahne sanatları', 'Бакалавриат', '6B02122', 'Традиционное музыкальное искусство(Народное пение)', 'Дәстүрлі музыка өнері (Халық әні)', 'Traditional Music Art (Folk singing)', 'Geleneksel müzik sanatı', NULL, 70);
INSERT INTO `deneme` VALUES (28, 'Spor ve Sanat Fakültesi', 'Орындаушылық өнер', 'Исполнительского искусства', 'Executive search', 'Sahne sanatları', 'Бакалавриат', '6B02123', 'Актерское искусство', 'Актерлік өнер', 'Acting art', 'Oyunculuk Sanatı', NULL, 70);
INSERT INTO `deneme` VALUES (29, 'Spor ve Sanat Fakültesi', 'Орындаушылық өнер', 'Исполнительского искусства', 'Executive search', 'Sahne sanatları', 'Бакалавриат', '6B02124', 'Хореография', 'Хореография', 'Choreography', 'Koreografi', NULL, 70);
INSERT INTO `deneme` VALUES (30, 'Spor ve Sanat Fakültesi', 'Бейнелеу өнері', 'Изобразительного искусство', 'Fine arts', 'Güzel sanatlar', 'Бакалавриат', '6B02125', 'Декоративное искусство', 'Сән өнері', 'Decorative Art', 'Dekoratif Sanatı', NULL, 71);
INSERT INTO `deneme` VALUES (31, 'Spor ve Sanat Fakültesi', 'Бейнелеу өнері', 'Изобразительного искусство', 'Fine arts', 'Güzel sanatlar', 'Бакалавриат', '6B02126', 'Дизайн', 'Дизайн', 'Design', 'Tasarım', NULL, 71);
INSERT INTO `deneme` VALUES (32, 'Spor ve Sanat Fakültesi', 'Бейнелеу өнері', 'Изобразительного искусство', 'Fine arts', 'Güzel sanatlar', 'Бакалавриат', '6B02184', 'Декоративно-прикладное искусство', 'Сәндік-қолданбалы өнері', 'Decorative and applied art', 'Dekoratif Sanatlar', NULL, 71);
INSERT INTO `deneme` VALUES (33, 'Teoloji Fakültesi', 'Дінтану', 'Религиоведения', 'Religious studies', 'Din Bilimi', 'Бакалавриат', '6В02286', 'Философия -Религиоведение ', 'Философия-Дінтану', 'Philosophy-Religious Studies', 'Din Felsefesi', NULL, 110);
INSERT INTO `deneme` VALUES (34, 'Teoloji Fakültesi', 'Дінтану', 'Религиоведения', 'Religious studies', 'Din Bilimi', 'Бакалавриат', '6B02228', 'Религиоведение', 'Дінтану', 'Religious Studies', 'Din Bilimleri', NULL, 110);
INSERT INTO `deneme` VALUES (35, 'Teoloji Fakültesi', 'Теология', 'Теологии', 'Theology', 'Teoloji', 'Бакалавриат', '6B02229', 'Теология', 'Теология', 'Theology', 'İlahiyat', NULL, 111);
INSERT INTO `deneme` VALUES (36, 'Teoloji Fakültesi', 'Теология', 'Теологии', 'Theology', 'Teoloji', 'Бакалавриат', '6B02266', 'Исламоведение', 'Исламтану', 'Islamic Studies', 'İslam Bilimleri', NULL, 111);
INSERT INTO `deneme` VALUES (37, 'Teoloji Fakültesi', 'Дінтану', 'Религиоведения', 'Religious studies', 'Din Bilimi', 'Бакалавриат', '6B01683', 'Религиоведение', 'Дінтану', 'Religious Studies', 'Din Bilimleri', NULL, 110);
INSERT INTO `deneme` VALUES (38, 'Sosyal ve Beşeri bilimler Fakültesi', 'Тарих', 'Истории', 'Historii', 'Tarih', 'Бакалавриат', '6B02231', 'История', 'Тарих', 'History', 'Tarih', NULL, 64);
INSERT INTO `deneme` VALUES (39, 'Filoloji Fakültesi', 'Түрік филологиясы', 'Турецкой филологии', 'Turkish Philology', 'Türk Filolojisi', 'Бакалавриат', '6B02267', 'Тюркология ', 'Түркітану ', 'Turkology', 'Türkoloji', NULL, 95);
INSERT INTO `deneme` VALUES (40, 'Filoloji Fakültesi', 'Ағылшын филологиясы және аударма ісі', 'Английской филологии и переводческого дела', 'English Philology and Translation', 'İngiliz Filolojisi ve çeviri işleri', 'Бакалавриат', '6B02332  ', 'Иностранная филология (английский язык)', 'Шетел филологиясы (ағылшын тілі)', 'Foreign Philology:  (english language)', 'İngiliz Dili ve Edebiyatı', NULL, 96);
INSERT INTO `deneme` VALUES (41, 'Filoloji Fakültesi', 'Түрік филологиясы', 'Турецкой филологии', 'Turkish Philology', 'Türk Filolojisi', 'Бакалавриат', '6B02333', 'Иностранная филология (турецский язык)', 'Шетел филологиясы  (түрік тілі)', 'Foreign Philology:(тurkish language)', '\"Türk Dili Ve Edebiyatı', NULL, 95);
INSERT INTO `deneme` VALUES (43, 'Filoloji Fakültesi', 'Ағылшын филологиясы және аударма ісі', 'Английской филологии и переводческого дела', 'English Philology and Translation', 'İngiliz Filolojisi ve çeviri işleri', 'Бакалавриат', '6B02335', '\"Переводческое дело:английский язык', NULL, NULL, NULL, NULL, 96);
INSERT INTO `deneme` VALUES (46, 'Filoloji Fakültesi', 'Қазақ филологиясы ', 'Казахской филологии', 'Kazakh Philology', 'Kazak Filolojisi', 'Бакалавриат', '6B02336', 'Филология: казахская филология', 'Филология: қазақ филологиясы', 'Philology: Kazakh Philology', 'Kazak Dili ve Edebiyatı', NULL, 92);
INSERT INTO `deneme` VALUES (47, 'İktisadi ve İdari Bilimler Fakültesi', 'Мемлекеттік басқару және халықаралық қатынастар', 'Государственного управления и международных отношений', 'Public administration and international relations', 'Kamu yönetimi ve uluslararası ilişkiler', 'Бакалавриат', '6B03138', 'Международные отношения', 'Халықаралық қатынастар', 'International Relations', 'Uluslararası İlişkiler', NULL, 114);
INSERT INTO `deneme` VALUES (48, 'Teoloji Fakültesi', 'Дінтану', 'Религиоведения', 'Religious studies', 'Din Bilimi', 'Бакалавриат', '6В03187', 'Психология-Религиоведение', 'Психология-Дінтану', 'Psychology-Religious Studies', 'Din Psikolojisi', NULL, 110);
INSERT INTO `deneme` VALUES (49, 'Sosyal ve Beşeri bilimler Fakültesi', 'Журналистика', 'Журналистики', 'Journalism', 'Gazetecilikler', 'Бакалавриат', '6B03239', 'Журналистика', 'Журналистика', 'Journalism', 'Gazetecilik', NULL, 65);
INSERT INTO `deneme` VALUES (50, 'Sosyal ve Beşeri bilimler Fakültesi', 'Журналистика', 'Журналистики', 'Journalism', 'Gazetecilikler', 'Бакалавриат', '6B03279', 'Цифровая медиа и телерадиожурналистика', 'Сандық медия және телерадиожурналистика', 'Digital media and TV, radio journalism', 'Dijital medya ve televizyon ve radyo gazeteciliği', NULL, 65);
INSERT INTO `deneme` VALUES (51, 'İktisadi ve İdari Bilimler Fakültesi', 'Менеджмент және туризм ', 'Менеджмента и туризма', 'Management and Tourism', 'Yönetim ve Turizm', 'Бакалавриат', '6B04140', 'Менеджмент', 'Менеджмент ', 'Management', 'İşletme', NULL, 115);
INSERT INTO `deneme` VALUES (52, 'İktisadi ve İdari Bilimler Fakültesi', 'Мемлекеттік басқару және халықаралық қатынастар', 'Государственного управления и международных отношений', 'Public administration and international relations', 'Kamu yönetimi ve uluslararası ilişkiler', 'Бакалавриат', '6B04141', 'Государственное и местное управление', 'Мемлекеттік және жергілікті басқару', 'Public and Local administration', 'Kamu ve Yerel Yönetimi', NULL, 114);
INSERT INTO `deneme` VALUES (53, 'İktisadi ve İdari Bilimler Fakültesi', 'Экономика, қаржы және есеп', 'Экономика, финансы и учет', 'Economics, Finance and Accounting', 'Ekonomi, Finans ve Muhasebe', 'Бакалавриат', '6B04143', 'Учет и аудит', 'Есеп және аудит', 'Accounting and Audit', 'Muhasebe ve Denetim', NULL, 116);
INSERT INTO `deneme` VALUES (54, 'İktisadi ve İdari Bilimler Fakültesi', 'Экономика, қаржы және есеп', 'Экономика, финансы и учет', 'Economics, Finance and Accounting', 'Ekonomi, Finans ve Muhasebe', 'Бакалавриат', '6B04144', 'Финансы', 'Қаржы', 'Finance', 'Finans', NULL, 116);
INSERT INTO `deneme` VALUES (55, 'İktisadi ve İdari Bilimler Fakültesi', 'Экономика, қаржы және есеп', 'Экономика, финансы и учет', 'Economics, Finance and Accounting', 'Ekonomi, Finans ve Muhasebe', 'Бакалавриат', '6B04142', 'Экономика', 'Экономика', 'Economics', 'Ekonomi ', NULL, 116);
INSERT INTO `deneme` VALUES (56, 'İktisadi ve İdari Bilimler Fakültesi', 'Құқықтану', 'Юриспруденции', 'Law', 'Hukuk', 'Бакалавриат', '6B04245', 'Юриспруденция', 'Құқықтану', 'Jurisprudence', 'Hukuk', NULL, 117);
INSERT INTO `deneme` VALUES (57, 'İktisadi ve İdari Bilimler Fakültesi', 'Құқықтану', 'Юриспруденции', 'Law', 'Hukuk', 'Бакалавриат', '6B04282 ', 'Правоохранительная деятельность', 'Құқыққорғау қызметі', 'Law enforcement ', 'Hukuk Hizmetleri', NULL, 117);
INSERT INTO `deneme` VALUES (58, 'İktisadi ve İdari Bilimler Fakültesi', 'Құқықтану', 'Юриспруденции', 'Law', 'Hukuk', 'Бакалавриат', '6B04281', 'Международное право', 'Халықаралық құқық', '\"International Law', NULL, NULL, 117);
INSERT INTO `deneme` VALUES (60, 'Fen Fakültesi', 'Биология', 'Биологии', 'Biology', 'Biyolojiler', 'Бакалавриат', '6B05146', 'Биология', 'Биология', 'Biology', 'Biyoloji', NULL, 78);
INSERT INTO `deneme` VALUES (61, 'Fen Fakültesi', 'Биология', 'Биологии', 'Biology', 'Biyolojiler', 'Бакалавриат', '6B05169', 'Биотехнология ', 'Биотехнология ', 'Biotechnology ', 'Biyoteknoloji (yeni)', NULL, 78);
INSERT INTO `deneme` VALUES (62, 'Fen Fakültesi', 'Экология және химия', 'Экологии и химии', 'Ecology and Chemistry', 'Ekoloji ve Kimya', 'Бакалавриат', '6B05247', 'Экология ', 'Экология', 'Ecology', 'Ekoloji', NULL, 77);
INSERT INTO `deneme` VALUES (63, 'Fen Fakültesi', 'Физика', 'Физики', 'Physicists', 'Fizikler', 'Бакалавриат', '6B05348', 'Физика ', 'Физика', 'Physics', 'Fizik', NULL, 76);
INSERT INTO `deneme` VALUES (64, 'Fen Fakültesi', 'Математика', 'Математики', 'Mathematicians', 'Matematikler', 'Бакалавриат', '6B05449', 'Математика ', 'Математика', 'Mathematics', 'Matematik', NULL, 75);
INSERT INTO `deneme` VALUES (65, 'Mühendislik Fakültesi', 'Компьютерлік инженерия', 'Компьютерной инженерии', 'Computer Engineering', 'Bilgisayar Mühendisliği', 'Бакалавриат', '6B06151', 'Информационные системы', 'Ақпараттық жүйелер', 'Information Systems', 'Bilişim Sistemleri', NULL, 84);
INSERT INTO `deneme` VALUES (66, 'Mühendislik Fakültesi', 'Компьютерлік инженерия', 'Компьютерной инженерии', 'Computer Engineering', 'Bilgisayar Mühendisliği', 'Бакалавриат', '6B06152', 'Вычислительная техника и программное обеспечение', 'Есептеу техникасы және бағдарламалық қамтамасыз ету', 'Computing and Software', 'Hesaplama Teknikleri ve Programlama', NULL, 84);
INSERT INTO `deneme` VALUES (67, 'Mühendislik Fakültesi', 'Компьютерлік инженерия', 'Компьютерной инженерии', 'Computer Engineering', 'Bilgisayar Mühendisliği', 'Бакалавриат', '6B06182', 'Компьютерная инженерия ', 'Компьютерлік инженерия  ', 'Computer Enginering', 'Bilgisayar Mühendisliği ', NULL, 84);
INSERT INTO `deneme` VALUES (68, 'Mühendislik Fakültesi', 'Компьютерлік инженерия', 'Компьютерной инженерии', 'Computer Engineering', 'Bilgisayar Mühendisliği', 'Бакалавриат', '6B06181', 'Обработка информации и визуализация данных ', 'Ақпаратты өңдеу және деректерді визуализациялау ', 'Information Processing and Data Visualization ', 'Bilgi İşlem ve Verilerin Görselleştirilmesi', NULL, 84);
INSERT INTO `deneme` VALUES (69, 'Mühendislik Fakültesi', 'Электр инженериясы', 'Электроинженерии', 'Electrical Engineering', 'Elektrik Mühendisliği', 'Бакалавриат', '6B07153', 'Электроэнергетика', 'Электр энергетика', 'Electrical power engineering', '\"Elektrik Enerjisi', NULL, 85);
INSERT INTO `deneme` VALUES (71, 'Mühendislik Fakültesi', 'Электр инженериясы', 'Электроинженерии', 'Electrical Engineering', 'Elektrik Mühendisliği', 'Бакалавриат', '6B07154', 'Автоматизация и управление', 'Автоматтандыру және басқару', '\"Automation and Control', NULL, NULL, 85);
INSERT INTO `deneme` VALUES (74, 'Mühendislik Fakültesi', 'Электр инженериясы', 'Электроинженерии', 'Electrical Engineering', 'Elektrik Mühendisliği', 'Бакалавриат', '6B07189', 'Машиностроение', 'Машина жасау', '6B07189 Mechanical engineering', 'Makine Mühendisliği', NULL, 85);
INSERT INTO `deneme` VALUES (75, 'Tıp Fakültesi', 'деканат', '', '', '', 'Бакалавриат', '6B10155', 'Общая медицина', 'Жалпы медицина', 'General Medicine', 'Genel Tıp', NULL, NULL);
INSERT INTO `deneme` VALUES (76, 'Tıp Fakültesi', 'деканат', '', '', '', 'Бакалавриат', '6B10173', 'Сестринское дело', 'Мейіргер ісі', 'Nursing', 'Hemşirelik', NULL, NULL);
INSERT INTO `deneme` VALUES (77, 'Diş Hekimliği Fakültesi', 'деканат', '', '', '', 'Бакалавриат', '6B10156', 'Стоматология', 'Стоматология', 'Stomatology', 'Diş Hekimliği', NULL, NULL);
INSERT INTO `deneme` VALUES (78, 'İktisadi ve İdari Bilimler Fakültesi', 'Менеджмент және туризм ', 'Менеджмента и туризма', 'Management and Tourism', 'Yönetim ve Turizm', 'Бакалавриат', '6B11157', 'Туризм', 'Туризм', 'Tourism', 'Turizm', NULL, 115);
INSERT INTO `deneme` VALUES (79, 'İktisadi ve İdari Bilimler Fakültesi', 'Менеджмент және туризм ', 'Менеджмента и туризма', 'Management and Tourism', 'Yönetim ve Turizm', 'Бакалавриат', '6B11180', '\" Ресторанное дело и гостиничный ', NULL, NULL, NULL, NULL, 115);
INSERT INTO `deneme` VALUES (81, 'Tıp Fakültesi', 'деканат', '', '', '', 'Бакалавриат', '6B10188', 'Медицина', 'Медицина', 'Medicine', 'Tıp', NULL, NULL);
INSERT INTO `deneme` VALUES (82, 'Diş Hekimliği Fakültesi', 'деканат', '', '', '', 'Бакалавриат', '6B10189', 'Стоматология', 'Стоматология', 'Dentistry', 'Diş Hekimliği', NULL, NULL);
INSERT INTO `deneme` VALUES (83, 'Sosyal ve Beşeri bilimler Fakültesi', 'Педагогика және психология', 'Педагогики и психологии', 'Pedagogy and psychology', 'Pedagoji ve psikoloji', 'Магистратура', '7M01101', 'Педагогика и психология', 'Педагогика және психология', 'Pedagogy and psychology', 'Pedagoji ve Psikoloji', NULL, 66);
INSERT INTO `deneme` VALUES (84, 'Sosyal ve Beşeri bilimler Fakültesi', 'Мектепке дейінгі және бастауышта білім беру', 'Дошкольного и начального образования', 'Preschool and primary education', 'Okul öncesi ve ilkokul eğitimi', 'Магистратура', '7M01202', 'Педагогика дошкольного воспитания и обучения', 'Мектепке дейінгі тәрбиелеу және оқыту педагогикасы', 'Pedagogy of the pre-school education and upbringing', 'Okul Öğrenci Öğretmenliği', NULL, 67);
INSERT INTO `deneme` VALUES (85, 'Sosyal ve Beşeri bilimler Fakültesi', 'Мектепке дейінгі және бастауышта білім беру', 'Дошкольного и начального образования', 'Preschool and primary education', 'Okul öncesi ve ilkokul eğitimi', 'Магистратура', '7M01303', 'Педагогика и методика начального обучения', 'Бастауышта оқыту педагогикасы мен әдістемесі', 'Pedagogy and methods of primary education', 'Sınıf Öğretmenliği', NULL, 67);
INSERT INTO `deneme` VALUES (86, 'Spor ve Sanat Fakültesi', 'Дене мәдениеті', 'Физической культуры', 'Physical education', 'Beden eğitimi', 'Магистратура', '7M01404', 'Физическая культура и спорт', 'Дене шынықтыру және спорт', 'Physical Culture and Sport', 'Fiziksel Kültür ve Spor', NULL, 72);
INSERT INTO `deneme` VALUES (87, 'Spor ve Sanat Fakültesi', 'Орындаушылық өнер', 'Исполнительского искусства', 'Executive search', 'Sahne sanatları', 'Магистратура', '7M01434', 'Музыкальное образование', 'Музыкалық білім', 'Music Education', 'Müzik Eğitimi', NULL, 73);
INSERT INTO `deneme` VALUES (88, 'Spor ve Sanat Fakültesi', 'Бейнелеу өнері', 'Изобразительного искусство', 'Fine arts', 'Güzel sanatlar', 'Магистратура', '7M01405', 'Изобразительное искусство и черчение', 'Бейнелеу өнері және сызу', 'Fine Art and Drawing', 'Güzel Sanatlar ve Çizim', NULL, 74);
INSERT INTO `deneme` VALUES (89, 'Fen Fakültesi', 'Физика', 'Физики', 'Physicists', 'Fizikler', 'Магистратура', '7M01506', 'Физика', 'Физика', 'Physics', 'Fizik Öğretmenliği', NULL, 79);
INSERT INTO `deneme` VALUES (90, 'Fen Fakültesi', 'Математика', 'Математики', 'Mathematicians', 'Matematikler', 'Магистратура', '7M01547', 'Математика', 'Математика', 'Mathematics', 'Matematik Öğretmenliği', NULL, 80);
INSERT INTO `deneme` VALUES (91, 'Mühendislik Fakültesi', 'Компьютерлік ғылымдар', 'Компьютерных наук', 'Computer Science', 'Bilgisayar Bilimi', 'Магистратура', '7M01557', 'Информатика ', 'Информатика', 'Computer Science', 'Bilgi İşlem', NULL, 86);
INSERT INTO `deneme` VALUES (92, 'Fen Fakültesi', 'Экология және химия', 'Экологии и химии', 'Ecology and Chemistry', 'Ekoloji ve Kimya', 'Магистратура', '7M01535', 'Химия', 'Химия', 'Chemistry', 'Kimya Öğetmenliği', NULL, 81);
INSERT INTO `deneme` VALUES (93, 'Fen Fakültesi', 'Биология', 'Биологии', 'Biology', 'Biyolojiler', 'Магистратура', '7M01507', 'Биология', 'Биология', 'Biology', 'Biyoloji Öğretmenliği', NULL, 82);
INSERT INTO `deneme` VALUES (94, 'Filoloji Fakültesi', 'Педагогикалық шетел тілдері', 'Педагогических иностранных языков', 'Pedagogical foreign languages', 'Pedagojik yabancı diller', 'Магистратура', '7M01708', 'Иностранный язык: два иностранных языка', 'Шетел тілі: екі шетел тілі', 'Foreign Language: Two Foreign Languages', 'Yabancı Dil: İki Yabancı Dil ', NULL, 98);
INSERT INTO `deneme` VALUES (95, 'Filoloji Fakültesi', 'Қазақ филологиясы ', 'Казахской филологии', 'Kazakh Philology', 'Kazak Filolojisi', 'Магистратура', '7M01737', 'Казахский язык и литература', 'Қазақ тілі мен әдебиеті', 'Kazakh Language and Literature ', 'Kazak Dili ve Edebiyatı Öğretmenliği', NULL, 99);
INSERT INTO `deneme` VALUES (96, 'Filoloji Fakültesi', 'Орыс тілі және әдебиеті', 'Русского языка и литература', 'Russian language and literature', 'Rus dili ve edebiyatı', 'Магистратура', '7M01738', 'Русский язык и литература ', 'Орыс тілі мен әдебиеті', 'Russian language and literature', 'Rus Dili ve Edebiyatı Öğretmenliği', NULL, 100);
INSERT INTO `deneme` VALUES (97, 'Sosyal ve Beşeri bilimler Fakültesi', 'Тарих', 'Истории', 'Historii', 'Tarih', 'Магистратура', '7M02210', 'История', 'Тарих', 'History', 'Tarih', NULL, 68);
INSERT INTO `deneme` VALUES (98, 'Teoloji Fakültesi', 'Дінтану', 'Религиоведения', 'Religious studies', 'Din Bilimi', 'Магистратура', '7M02211', 'Религиоведение', 'Дінтану', 'Religious Studies', 'Din Bilimleri', NULL, 112);
INSERT INTO `deneme` VALUES (99, 'Teoloji Fakültesi', 'Теология', 'Теологии', 'Theology', 'Teoloji', 'Магистратура', '7M02262', 'Теология', 'Теология', 'Theology', 'İlahiyat', NULL, 113);
INSERT INTO `deneme` VALUES (100, 'Filoloji Fakültesi', 'Түрік филологиясы', 'Турецкой филологии', 'Turkish Philology', 'Türk Filolojisi', 'Магистратура', '7M02212', 'Тюркология', 'Түркітану', 'Turkology', 'Türkoloji', NULL, 101);
INSERT INTO `deneme` VALUES (101, 'Filoloji Fakültesi', 'Ағылшын филологиясы және аударма ісі', 'Английской филологии и переводческого дела', 'English Philology and Translation', 'İngiliz Filolojisi ve çeviri işleri', 'Магистратура', '7M02313', 'Иностранная филология (английский язык)', 'Шетел филологиясы:  Ағылшын тілі', 'Foreign Philology(English)', 'İngiliz Dili ve Edebiyatı', NULL, 102);
INSERT INTO `deneme` VALUES (102, 'Filoloji Fakültesi', 'Түрік филологиясы', 'Турецкой филологии', 'Turkish Philology', 'Türk Filolojisi', 'Магистратура', '7M02314', 'Иностранная филология (турецкий язык)', 'Шетел филологиясы: Түрік тілі', 'Foreign Philology (Turkish)', '\"Türk Dili ve Edebiyatı', NULL, 101);
INSERT INTO `deneme` VALUES (104, 'Filoloji Fakültesi', 'Қазақ филологиясы ', 'Казахской филологии', 'Kazakh Philology', 'Kazak Filolojisi', 'Магистратура', '7M02315', 'Филология', 'Филология', 'Philology', 'Dil Bilimi', NULL, 99);
INSERT INTO `deneme` VALUES (105, 'İktisadi ve İdari Bilimler Fakültesi', 'Мемлекеттік басқару және халықаралық қатынастар', 'Государственного управления и международных отношений', 'Public administration and international relations', 'Kamu yönetimi ve uluslararası ilişkiler', 'Магистратура', '7M03117', 'Политология', 'Саясаттану', 'Political Science ', 'Siyaset Bilimi', NULL, 118);
INSERT INTO `deneme` VALUES (106, 'İktisadi ve İdari Bilimler Fakültesi', 'Мемлекеттік басқару және халықаралық қатынастар', 'Государственного управления и международных отношений', 'Public administration and international relations', 'Kamu yönetimi ve uluslararası ilişkiler', 'Магистратура', '7M03140', 'Международные отношения', 'Халықаралық қатынастар', 'International Relations', 'Uluslararası İlişkiler', NULL, 118);
INSERT INTO `deneme` VALUES (107, 'İktisadi ve İdari Bilimler Fakültesi', 'Экономика, қаржы және есеп', 'Экономика, финансы и учет', 'Economics, Finance and Accounting', 'Ekonomi, Finans ve Muhasebe', 'Магистратура', '7M04118', 'Экономика', 'Экономика', 'Economics', 'Ekonomi', NULL, 119);
INSERT INTO `deneme` VALUES (108, 'İktisadi ve İdari Bilimler Fakültesi', 'Менеджмент және туризм', 'Менеджмента и туризма', 'Management and Tourism', 'Yönetim ve Turizm', 'Магистратура', '7M04119', 'Менеджмент', 'Менеджмент', 'Management', 'İşletme', NULL, 120);
INSERT INTO `deneme` VALUES (109, 'İktisadi ve İdari Bilimler Fakültesi', 'Менеджмент және туризм', 'Менеджмента и туризма', 'Management and Tourism', 'Yönetim ve Turizm', 'Магистратура', '7M04160', 'Менеджмент в сфере здравоохранения 1', 'Денсаулық сақтау саласындағы менеджмент 1ж', '7M04160 Health Management 1', 'Sağlık İşletmeciliği', NULL, 120);
INSERT INTO `deneme` VALUES (110, 'İktisadi ve İdari Bilimler Fakültesi', 'Менеджмент және туризм', 'Менеджмента и туризма', 'Management and Tourism', 'Yönetim ve Turizm', 'Магистратура', '7M04150', 'Менеджмент в сфере образования 1', 'Білім беру саласындағы менеджмент 1ж', '7M04150 Education Management 1', 'Eğitim Yönetimi', NULL, 120);
INSERT INTO `deneme` VALUES (111, 'İktisadi ve İdari Bilimler Fakültesi', 'Экономика, қаржы және есеп', 'Экономика, финансы и учет', 'Economics, Finance and Accounting', 'Ekonomi, Finans ve Muhasebe', 'Магистратура', '7M04120', 'Учет и аудит', 'Есеп және аудит', 'Accounting and Audit', 'Muhasebe ve Denetim', NULL, 119);
INSERT INTO `deneme` VALUES (112, 'İktisadi ve İdari Bilimler Fakültesi', 'Мемлекеттік басқару және халықаралық қатынастар', 'Государственного управления и международных отношений', 'Public administration and international relations', 'Kamu yönetimi ve uluslararası ilişkiler', 'Магистратура', '7M04121', 'Государственное и местное управление', 'Мемлекеттік және жергілікті басқару', 'State and local government ', 'Kamu Yönetimi', NULL, 118);
INSERT INTO `deneme` VALUES (113, 'İktisadi ve İdari Bilimler Fakültesi', 'Мемлекеттік басқару және халықаралық қатынастар', 'Государственного управления и международных отношений', 'Public administration and international relations', 'Kamu yönetimi ve uluslararası ilişkiler', 'Магистратура', '7M04143', 'Управление человеческими ресурсами  ', 'Адам ресурстарын басқару', 'Human resource management', 'Insan kaynakları yönetimi', NULL, 118);
INSERT INTO `deneme` VALUES (114, 'İktisadi ve İdari Bilimler Fakültesi', 'Экономика, қаржы және есеп', 'Экономика, финансы и учет', 'Economics, Finance and Accounting', 'Ekonomi, Finans ve Muhasebe', 'Магистратура', '7M04141', 'Финансы ', 'Қаржы ', 'Finance', 'Finans', NULL, 119);
INSERT INTO `deneme` VALUES (115, 'İktisadi ve İdari Bilimler Fakültesi', 'Құқықтану', 'Юриспруденции', 'Law', 'Hukuk', 'Магистратура', '7M04222', 'Право', 'Құқық', 'Law', 'Hukuk', NULL, 121);
INSERT INTO `deneme` VALUES (116, 'Fen Bilimleri Fakültesi', 'Экология және химия', 'Экологии и химии', 'Ecology and Chemistry', 'Ekoloji ve Kimya', 'Магистратура', '7M05223', 'Экология', 'Экология', 'Ecology', 'Ekoloji', NULL, 130);
INSERT INTO `deneme` VALUES (117, 'Fen Bilimleri Fakültesi', 'Экология және химия', 'Экологии и химии', 'Ecology and Chemistry', 'Ekoloji ve Kimya', 'Магистратура', '7M05324', 'Химия', 'Химия', 'Chemistry', 'Kimya', NULL, 130);
INSERT INTO `deneme` VALUES (118, 'Fen Bilimleri Fakültesi', 'Физика', 'Физики', 'Physicists', 'Fizikler', 'Магистратура', '7M05325', 'Физика', 'Физика', 'Physics', 'Fizik', NULL, 131);
INSERT INTO `deneme` VALUES (119, 'Fen Bilimleri Fakültesi', 'Математика', 'Математики', 'Mathematicians', 'Matematikler', 'Магистратура', '7M05426', 'Математика', 'Математика', 'Mathematics', 'Matematik', NULL, 132);
INSERT INTO `deneme` VALUES (120, 'Mühendislik Fakültesi', 'Компьютерлік инженерия', 'Компьютерной инженерии', 'Computer Engineering', 'Bilgisayar Mühendisliği', 'Магистратура', '7M06127', 'Информатика', 'Информатика', 'Computer Science', 'Bilgi İşlem', NULL, 87);
INSERT INTO `deneme` VALUES (121, 'Mühendislik Fakültesi', 'Компьютерлік инженерия', 'Компьютерной инженерии', 'Computer Engineering', 'Bilgisayar Mühendisliği', 'Магистратура', '7M06128', 'Информационные системы', 'Ақпараттық жүйелер', 'Information Systems', 'Bilişim Sistemleri', NULL, 87);
INSERT INTO `deneme` VALUES (122, 'Mühendislik Fakültesi', 'Компьютерлік инженерия', 'Компьютерной инженерии', 'Computer Engineering', 'Bilgisayar Mühendisliği', 'Магистратура', '7M06146', 'Компьютерная инженерия ', 'Компьютерлік инженерия  ', 'Computer Enginering', 'Bilgisayar Mühendisliği ', NULL, 87);
INSERT INTO `deneme` VALUES (123, 'Fen Bilimleri Fakültesi', 'Математика', 'Математики', 'Mathematicians', 'Matematikler', 'Магистратура', '7M06129', 'Математическое и компьютерное моделирование', 'Математикалық және компьютерлік модельдеу', 'Mathematical and Computer Modeling', 'Matematiksel ve Bilgisayarda Modelleme', NULL, 132);
INSERT INTO `deneme` VALUES (124, 'Mühendislik Fakültesi', 'Электр инженериясы', 'Электроинженерии', 'Electrical Engineering', 'Elektrik Mühendisliği', 'Магистратура', '7M07130', 'Электроэнергетика', 'Электр энергетикасы', 'Electrical power engineering', 'Electricity', NULL, 88);
INSERT INTO `deneme` VALUES (125, 'Mühendislik Fakültesi', 'Электр инженериясы', 'Электроинженерии', 'Electrical Engineering', 'Elektrik Mühendisliği', 'Магистратура', '7M07158', 'Автоматизация и управление', 'Автоматтандыру және басқару', 'Automation and Management', 'Automation and Management', NULL, 88);
INSERT INTO `deneme` VALUES (126, 'Tıp Fakültesi', 'деканат', '', '', '', 'Магистратура', '7M10131', 'Медицина ', 'Медицина', 'Medicine', 'Tıp', NULL, NULL);
INSERT INTO `deneme` VALUES (127, 'Tıp Fakültesi', 'деканат', '', '', '', 'Магистратура', '7M10144', 'Общественное здравоохранение ', 'Қоғамдық денсаулық сақтау ', 'Public Health', 'Halk sağlığı', NULL, NULL);
INSERT INTO `deneme` VALUES (128, 'İnsan Ve Toplum Bilimleri Fakültesi', 'Педагогика және психология', 'Педагогики и психологии', 'Pedagogy and psychology', 'Pedagoji ve psikoloji', 'Докторантура', '8D01101', 'Педагогика и психология', 'Педагогика және психология', 'Рedagogy and Psychology', 'Pedagoji ve Psikoloji', NULL, 135);
INSERT INTO `deneme` VALUES (129, 'Fen Bilimleri Fakültesi', 'Математика', 'Математики', 'Mathematicians', 'Matematikler', 'Докторантура', '8D01502', 'Математика', 'Математика', 'Mathematics', 'Matematik Öğretmenliği', NULL, 133);
INSERT INTO `deneme` VALUES (130, 'Fen Bilimleri Fakültesi', 'Физика', 'Физики', 'Physicists', 'Fizikler', 'Докторантура', '8D01503', 'Физика', 'Физика', 'Physics', 'Fizik Öğretmenliği', NULL, 134);
INSERT INTO `deneme` VALUES (131, 'Mühendislik Fakültesi', 'Компьютерлік ғылымдар', 'Компьютерных наук', 'Computer Science', 'Bilgisayar Bilimi', 'Докторантура', '8D01516 ', 'Информатика', 'Информатика', 'Computer Science', 'Bilgi İşlem', NULL, 89);
INSERT INTO `deneme` VALUES (132, 'İnsan Ve Toplum Bilimleri Fakültesi', 'Тарих', 'Истории', 'Historii', 'Tarih', 'Докторантура', '8D01604', 'История', 'Тарих', 'History', 'Tarih Öğretmenliği', NULL, 136);
INSERT INTO `deneme` VALUES (133, 'Filoloji Fakültesi', 'Қазақ филологиясы ', 'Казахской филологии', 'Kazakh Philology', 'Kazak Filolojisi', 'Докторантура', '8D01705', 'Казахский язык и литература', 'Қазақ тілі мен әдебиеті', 'Kazakh language and literature ', 'Kazak Dili ve Edebiyatı', NULL, 105);
INSERT INTO `deneme` VALUES (134, 'Filoloji Fakültesi', 'Педагогикалық шетел тілдері', 'Педагогических иностранных языков', 'Pedagogical foreign languages', 'Pedagojik yabancı diller', 'Докторантура', '8D01713', 'Иностранный язык: два иностранных языка', 'Шетел тілі: екі шетел тілі ', 'Foreign Language: Two Foreign Languages', 'Yabancı Dil: İki Yabancı Dil Öğretmenliği', NULL, 106);
INSERT INTO `deneme` VALUES (135, 'İktisadi ve İdari Bilimler Fakültesi', 'Экономика, қаржы және есеп', 'Экономика, финансы и учет', 'Economics, Finance and Accounting', 'Ekonomi, Finans ve Muhasebe', 'Докторантура', '8D04106', 'Экономика', 'Экономика', 'Economics', 'Ekonomi', NULL, 122);
INSERT INTO `deneme` VALUES (136, 'İktisadi ve İdari Bilimler Fakültesi', 'Менеджмент және туризм ', 'Менеджмента и туризма', 'Management and Tourism', 'Yönetim ve Turizm', 'Докторантура', '8D04107', 'Менеджмент', 'Менеджмент', 'Management', 'İşletme', NULL, 123);
INSERT INTO `deneme` VALUES (137, 'İktisadi ve İdari Bilimler Fakültesi', 'Мемлекеттік басқару және халықаралық қатынастар', 'Государственного управления и международных отношений', 'Public administration and international relations', 'Kamu yönetimi ve uluslararası ilişkiler', 'Докторантура', '8D04114', 'Государственное и местное управление', 'Мемлекеттік және жергілікті басқару ', 'State and local government ', 'Kamu ve Yerel Yönetimi', NULL, 124);
INSERT INTO `deneme` VALUES (138, 'İktisadi ve İdari Bilimler Fakültesi', 'Экономика, қаржы және есеп', 'Экономика, финансы и учет', 'Economics, Finance and Accounting', 'Ekonomi, Finans ve Muhasebe', 'Докторантура', '8D04117', 'Финансы', 'Қаржы', 'Finance', 'Finans', NULL, 122);
INSERT INTO `deneme` VALUES (139, 'İktisadi ve İdari Bilimler Fakültesi', 'Құқықтану', 'Юриспруденции', 'Law', 'Hukuk', 'Докторантура', '8D04208', 'Право', 'Құқық', 'Law', 'Hukuk', NULL, 125);
INSERT INTO `deneme` VALUES (140, 'Mühendislik Fakültesi', 'Компьютерлік инженерия', 'Компьютерной инженерии', 'Computer Engineering', 'Bilgisayar Mühendisliği', 'Докторантура', '8D06115', 'Информационные системы', 'Ақпараттық жүйелер ', 'Information Systems', 'Bilişim Sistemleri', NULL, 90);
INSERT INTO `deneme` VALUES (141, 'Fen Bilimleri Fakültesi', 'Математика', 'Математики', 'Mathematicians', 'Matematikler', 'Докторантура', '8D06109', 'Математическое и компьютерное моделирование', 'Математикалық және компьютерлік модельдеу', 'Mathematical and computer modeling', 'Matematiksel ve Bilgisayarda Modelleme', NULL, 133);
INSERT INTO `deneme` VALUES (142, 'Tıp Fakültesi', 'деканат', '', '', '', 'Докторантура', '8D10110', 'Медицина ', 'Медицина', 'Medicine', 'Tıp', NULL, NULL);
INSERT INTO `deneme` VALUES (143, 'Tıp Fakültesi', 'деканат', '', '', '', 'Докторантура', '8D10111', 'Общественное здравоохранение', 'Қоғамдық денсаулық сақтау', 'Public Health', 'Halk sağlığı', NULL, NULL);
INSERT INTO `deneme` VALUES (144, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Акушерлік  гинекология', 'Акушерская гинекология', 'Obstetric gynecology', 'Obstetrik Jinekoloji', 'Резидентура', '7R01102', 'Акушерство и гинекология взрослая, детская', 'Ересектердің, балалардың акушерия және гинекологиясы', 'Obstetrics and gynecology for adults, children', 'Kadın Hastalıkları ve Doğum, Çocuk Kadın Hastalıkları ve Doğumu Dahil', NULL, NULL);
INSERT INTO `deneme` VALUES (145, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Арнайы  хирургиялық  пәндер', 'Специальные хирургические дисциплины', 'Special surgical disciplines', 'Özel cerrahi disiplinler', 'Резидентура', '7R01120', 'Травматология-ортопедия взрослая, детская', 'Ересектердің, балалардың травматология-ортопедиясы', 'Traumatology-orthopedics adults, children', 'Yetişkinler ve çocuklar için travmatoloji ve ortopedi', NULL, NULL);
INSERT INTO `deneme` VALUES (146, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Арнайы  хирургиялық  пәндер', 'Специальные хирургические дисциплины', 'Special surgical disciplines', 'Özel cerrahi disiplinler', 'Резидентура', '7R01115', 'Кардиохирургия взрослая, детская', 'Ересектердің, балалардың кардиохирургиясы', 'Cardiac surgery adults, children', 'Kalp cerrahisi, yetişkinler, çocuklar', NULL, NULL);
INSERT INTO `deneme` VALUES (147, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Арнайы  хирургиялық  пәндер', 'Специальные хирургические дисциплины', 'Special surgical disciplines', 'Özel cerrahi disiplinler', 'Резидентура', '7R01121', 'Урология и андрология взрослая, детская', 'Ересектердің, балалардың урология және андрологиясы', 'Urology and andrology adults, children', 'Yetişkinlerin ve çocukların ürolojisi ve androlojisi', NULL, NULL);
INSERT INTO `deneme` VALUES (148, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Арнайы  хирургиялық  пәндер', 'Специальные хирургические дисциплины', 'Special surgical disciplines', 'Özel cerrahi disiplinler', 'Резидентура', '7R01119', 'Оториноларингология взрослая, детская', 'Ересектердің, балалардың оториноларингологиясы', 'Otorhinolaryngology adults, children', 'Yetişkinlerde ve çocuklarda kulak burun boğaz', NULL, NULL);
INSERT INTO `deneme` VALUES (149, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Арнайы  хирургиялық  пәндер', 'Специальные хирургические дисциплины', 'Special surgical disciplines', 'Özel cerrahi disiplinler', 'Резидентура', '7R01124', 'Онкология взрослая', 'Ересектердің онкологиясы', 'Adult oncology ', 'Onkoloji', NULL, NULL);
INSERT INTO `deneme` VALUES (150, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Жалпы  дәрігерлік  практика № 1', 'Общей врачебной практики  № 1', 'General medical practice  № 1', 'Genel Tıbbi uygulamalar  № 1', 'Резидентура', '7R01114', 'Радиология ', 'Радиология ', 'Radiology', 'Radyoloji Teşhisi', NULL, NULL);
INSERT INTO `deneme` VALUES (151, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Жалпы  дәрігерлік  практика № 2', 'Общей врачебной практики  № 2', 'General medical practice  № 2', 'Genel Tıbbi uygulamalar  № 2', 'Резидентура', '7R01106', 'Семейная медицина', 'Отбасылық медицина', 'Family doctor', 'Aile Hekimliği ', NULL, NULL);
INSERT INTO `deneme` VALUES (152, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Жалпы  дәрігерлік  практика № 2', 'Общей врачебной практики  № 2', 'General medical practice  № 2', 'Genel Tıbbi uygulamalar  № 2', 'Резидентура', '7R01129', 'Патологическая анатомия', 'Патологиялық анатомия', 'Pathological anatomy', 'Patolojik anatomi', NULL, NULL);
INSERT INTO `deneme` VALUES (153, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Жалпы  дәрігерлік  практика № 2', 'Общей врачебной практики  № 2', 'General medical practice  № 2', 'Genel Tıbbi uygulamalar  № 2', 'Резидентура', '7R01116', 'Клиническая фармакология', 'Клиникалық фармакология', 'Clinical pharmacology', 'Klinik Farmakoloji', NULL, NULL);
INSERT INTO `deneme` VALUES (154, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Жұқпалы  аурулар  және  фтизиатрия', 'Инфекционных заболеваний и фтизиатрии', 'Infectious diseases and phthisiology', 'Bulaşıcı hastalıklar ve Phthysiatrics', 'Резидентура', '7R01122', 'Дерматовенерология взрослая, детская', 'Ересектердің, балалардың дерматовенерологиясы', 'Dermatovenerology adults, children', 'Yetişkinlerin ve çocukların dermatovenerolojisi', NULL, NULL);
INSERT INTO `deneme` VALUES (155, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Жұқпалы  аурулар  және  фтизиатрия', 'Инфекционных заболеваний и фтизиатрии', 'Infectious diseases and phthisiology', 'Bulaşıcı hastalıklar ve Phthysiatrics', 'Резидентура', '7R01123', 'Инфекционные болезни взрослые, детские', 'Ересектердің, балалардың инфекциялық аурулары', 'Infectious diseases adults, children', 'Yetişkinlerin ve çocukların bulaşıcı hastalıkları', NULL, NULL);
INSERT INTO `deneme` VALUES (156, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Ішкі  аурулар', 'Внутренних болезней', 'Internal diseases', 'Dahiliye', 'Резидентура', '7R01105', 'Терапия', 'Терапия', 'Therapy', 'Terapi', NULL, NULL);
INSERT INTO `deneme` VALUES (157, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Ішкі  аурулар', 'Внутренних болезней', 'Internal diseases', 'Dahiliye', 'Резидентура', '7R01107', 'Кардиология взрослая, детская', 'Ересектердің, балалардың кардиологиясы', 'Cardiology adult, children', 'Kardiyoloji, Çocuk Kardiyolojisi ', NULL, NULL);
INSERT INTO `deneme` VALUES (158, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Ішкі  аурулар', 'Внутренних болезней', 'Internal diseases', 'Dahiliye', 'Резидентура', '7R01108', 'Эндокринология взрослая, детская', 'Ересектердің, балалардың эндокринологиясы', 'Endocrinology adult, children', 'Endokrinoloji, Çocuk Endokrinolojisi ', NULL, NULL);
INSERT INTO `deneme` VALUES (159, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Ішкі  аурулар', 'Внутренних болезней', 'Internal diseases', 'Dahiliye', 'Резидентура', '7R01126', 'Аллергология и иммунология взрослая, детская', 'Ересектердің, балалардың аллергология және иммунологиясы', 'Allergology and immunology adult, children', 'Yetişkinlerin ve çocukların alerjisi ve immünolojisi', NULL, NULL);
INSERT INTO `deneme` VALUES (160, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Ішкі  аурулар', 'Внутренних болезней', 'Internal diseases', 'Dahiliye', 'Резидентура', '7R01127', 'Пульмонология взрослая, детская', 'Ересектердің, балалардың пульмонологиясы  ', 'Pulmonology adult, children', 'Yetişkinlerin ve çocukların göğüs hastalıkları', NULL, NULL);
INSERT INTO `deneme` VALUES (161, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Ішкі  аурулар', 'Внутренних болезней', 'Internal diseases', 'Dahiliye', 'Резидентура', '7R01110', 'Гастроэнтерология взрослая, детская', 'Ересектердің, балалардың гастроэнтерологиясы', 'Gastroenterology adults, children', 'Gastroenteroloji, Çocuk Gastroenterolojisi ', NULL, NULL);
INSERT INTO `deneme` VALUES (162, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Неврология, психиатрия, наркология', 'Неврологии, психиатрии, наркологии', 'Neurology, psychiatry, narcology', 'Nöroloji, psikiyatri, uyuşturucu bilimi', 'Резидентура', '7R01104', 'Неврология взрослая, детская', 'Ересектердің, балалардың неврологиясы', 'Neurology adults, children ', 'Pediatrik Nöroloji , Çocuk Nörolojisi', NULL, 143);
INSERT INTO `deneme` VALUES (163, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Неврология, психиатрия, наркология', 'Неврологии, психиатрии, наркологии', 'Neurology, psychiatry, narcology', 'Nöroloji, psikiyatri, uyuşturucu bilimi', 'Резидентура', '7R01117', 'Физическая медицина и реабилитация взрослая, детская', 'Ересектердің, балалардың физикалық медицина және реабилитациясы', 'Physical medicine and rehabilitation adults, children', 'Yetişkinlerde ve çocuklarda fiziksel tıp ve rehabilitasyon', NULL, 143);
INSERT INTO `deneme` VALUES (164, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Неврология, психиатрия, наркология', 'Неврологии, психиатрии, наркологии', 'Neurology, psychiatry, narcology', 'Nöroloji, psikiyatri, uyuşturucu bilimi', 'Резидентура', '7R01113', 'Психиатрия взрослая, детская', 'Ересектер мен балалар психиатриясы', 'Psychiatry  adults, children ', 'Psikiyatri', NULL, 143);
INSERT INTO `deneme` VALUES (165, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Педиатрия', 'Педиатрии', 'Pediatrics', 'Pediatri', 'Резидентура', '7R01101', 'Педиатрия', 'Педиатрия', 'Pediatrics', 'Pediatri', NULL, 144);
INSERT INTO `deneme` VALUES (166, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Педиатрия', 'Педиатрии', 'Pediatrics', 'Pediatri', 'Резидентура', '7R01125', 'Неонатология', 'Неонатология', 'Neonatology', 'Neonatoloji', NULL, 144);
INSERT INTO `deneme` VALUES (167, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Профилактикалық медицина және стоматологиялық пәндер', 'Профилактической медицины и стоматологических дисциплин', 'Preventive medicine and dental disciplines', 'Önleyici tıp ve diş disiplinleri', 'Резидентура', '7R01130', 'Терапевтическая стоматология', 'Терапиялық стоматология', 'Therapeutic dentistry', 'Terapötik diş hekimliği', NULL, 145);
INSERT INTO `deneme` VALUES (168, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Хирургия  және анестезиология-реанимация', 'Хирургия и анестезиология-реанимация', 'Surgery and Anesthesiology-Intensive care', 'Cerrahi ve Anesteziyoloji-Resüsitasyon', 'Резидентура', '7R01103', 'Общая хирургия ', 'Жалпы хирургия', 'General surgery', 'Genel Cerrahi', NULL, NULL);
INSERT INTO `deneme` VALUES (169, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Хирургия  және анестезиология-реанимация', 'Хирургия и анестезиология-реанимация', 'Surgery and Anesthesiology-Intensive care', 'Cerrahi ve Anesteziyoloji-Resüsitasyon', 'Резидентура', '7R01111', 'Офтальмология взрослая, детская', 'Ересектердің, балалардың офтальмологиясы', 'Ophthalmology  adults, children', 'Oftalmoloji, Çocuk Oftalmolojisi ', NULL, NULL);
INSERT INTO `deneme` VALUES (170, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Хирургия  және анестезиология-реанимация', 'Хирургия и анестезиология-реанимация', 'Surgery and Anesthesiology-Intensive care', 'Cerrahi ve Anesteziyoloji-Resüsitasyon', 'Резидентура', '7R01112', 'Анестезиология и реаниматология взрослая, детская', 'Ересектердің, балалардың анестезиология және реаниматологиясы', 'Anesthesiology and resuscitation adults, children', 'Anesteziyoloji ve Resüsitasyon, Çocuk Anesteziyoloji ve Resüsitasyonu Dahil', NULL, NULL);
INSERT INTO `deneme` VALUES (171, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Хирургия  және анестезиология-реанимация', 'Хирургия и анестезиология-реанимация', 'Surgery and Anesthesiology-Intensive care', 'Cerrahi ve Anesteziyoloji-Resüsitasyon', 'Резидентура', '7R01109', 'Нейрохирургия взрослая, детская.', 'Ересектердің, балалардың нейрохирургиясы', 'Neurosurgery  adults, children', 'Sinir Cerrahisi, Çocuk Sinir Cerrahisi ', NULL, NULL);
INSERT INTO `deneme` VALUES (172, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Хирургия  және анестезиология-реанимация', 'Хирургия и анестезиология-реанимация', 'Surgery and Anesthesiology-Intensive care', 'Cerrahi ve Anesteziyoloji-Resüsitasyon', 'Резидентура', '7R01118', 'Детская хирургия', 'Балалар хирургиясы', 'Pediatric surgery', 'Çocuk Cerrahisi', NULL, NULL);
INSERT INTO `deneme` VALUES (173, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Хирургия  және анестезиология-реанимация', 'Хирургия и анестезиология-реанимация', 'Surgery and Anesthesiology-Intensive care', 'Cerrahi ve Anesteziyoloji-Resüsitasyon', 'Резидентура', '7R01128', 'Ангиохирургия взрослая, детская', 'Ересектердің, балалардың ангиохирургиясы', 'Angiosurgery adults, children', 'Çocuk ve Yetişkin Anjiyo Cerrahi', NULL, NULL);
INSERT INTO `deneme` VALUES (174, 'Lisansüstü Tıp Eğitimi  Fakültesi', 'Хирургия  және анестезиология-реанимация', 'Хирургия и анестезиология-реанимация', 'Surgery and Anesthesiology-Intensive care', 'Cerrahi ve Anesteziyoloji-Resüsitasyon', 'Резидентура', '7R01131', 'Челюстно-лицевая хирургия взрослая, детская', 'Ересектердің, балалардың бет-жақ хирургиясы', 'Maxillofacial surgery for adults, children', 'Çocuk ve Yetişkin Çene-Yüz cerrahisi', NULL, NULL);

-- ----------------------------
-- Table structure for tb_anabilim_dallari
-- ----------------------------
DROP TABLE IF EXISTS `tb_anabilim_dallari`;
CREATE TABLE `tb_anabilim_dallari`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `fakulte_id` int NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `aktif` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 45 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_anabilim_dallari
-- ----------------------------
INSERT INTO `tb_anabilim_dallari` VALUES (1, 1, 'Anesteziyoloji ve Reanimasyon Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (2, 1, 'Çocuk Cerrahisi Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (3, 1, 'Genel Cerrahi Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (4, 1, 'Göğüs Cerrahisi Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (5, 1, 'Göz Hastalıkları Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (6, 1, 'Kadın Hastalıkları ve Doğum Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (7, 1, 'Kalp ve Damar Cerrahisi Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (8, 1, 'Kulak Burun Boğaz Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (9, 1, 'Nöroşirürji Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (10, 1, 'Ortopedi ve Travmatoloji Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (11, 1, 'Plastik ve Rekonstrüktif Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (12, 1, 'Üroloji Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (13, 1, 'Anatomi Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (14, 1, 'Biyofizik Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (15, 1, 'Biyoistatistik Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (16, 1, 'Biyokimya Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (17, 1, 'Fizyoloji Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (18, 1, 'Histoloji ve Embriyoloji Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (19, 1, 'Mikrobiyoloji Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (20, 1, 'Patoloji Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (21, 1, 'Tıbbi Biyoloji Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (22, 1, 'Tıbbi Parazitoloji Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (23, 1, 'Tıp Eğitimi ve Bilişimi Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (24, 1, 'Tıp Tarihi ve Etik Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (25, 1, 'Acil Tıp Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (26, 1, 'Adli Tıp Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (27, 1, 'Aile Hekimliği Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (28, 1, 'Çocuk Sağlığı ve Hastalıkları Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (29, 1, 'Dermatoloji Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (30, 1, 'Farmakoloji Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (31, 1, 'Fiziksel Tıp ve Rehabilitasyon Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (32, 1, 'Göğüs Hastalıkları Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (33, 1, 'Halk Sağlığı Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (34, 1, 'İç Hastalıkları Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (35, 1, 'Kardiyoloji Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (36, 1, 'Klinik Bakteriyoloji ve Enfeksiyon Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (37, 1, 'Nöroloji Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (38, 1, 'Nükleer Tıp Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (39, 1, 'Psikiyatri Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (40, 1, 'Radyasyon Onkolojisi Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (41, 1, 'Radyodiagnostik Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (42, 1, 'Spor Hekimliği Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (43, 1, 'Tıbbi Genetik Anabilim Dalı', 1);
INSERT INTO `tb_anabilim_dallari` VALUES (44, 1, 'Diğer', 1);

-- ----------------------------
-- Table structure for tb_anket_cevaplari
-- ----------------------------
DROP TABLE IF EXISTS `tb_anket_cevaplari`;
CREATE TABLE `tb_anket_cevaplari`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `anket_id` int NULL DEFAULT NULL,
  `soru_id` int NULL DEFAULT NULL,
  `ogrenci_id` int NULL DEFAULT NULL,
  `cevap` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 37 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_anket_cevaplari
-- ----------------------------
INSERT INTO `tb_anket_cevaplari` VALUES (1, 1, 1, 131, 2);
INSERT INTO `tb_anket_cevaplari` VALUES (2, 1, 2, 131, 3);
INSERT INTO `tb_anket_cevaplari` VALUES (3, 1, 3, 131, 4);
INSERT INTO `tb_anket_cevaplari` VALUES (4, 1, 4, 131, 5);
INSERT INTO `tb_anket_cevaplari` VALUES (5, 1, 1, 129, 1);
INSERT INTO `tb_anket_cevaplari` VALUES (6, 1, 2, 129, 1);
INSERT INTO `tb_anket_cevaplari` VALUES (7, 1, 3, 129, 1);
INSERT INTO `tb_anket_cevaplari` VALUES (8, 1, 4, 129, 1);
INSERT INTO `tb_anket_cevaplari` VALUES (9, 2, 1, 129, 1);
INSERT INTO `tb_anket_cevaplari` VALUES (10, 2, 2, 129, 2);
INSERT INTO `tb_anket_cevaplari` VALUES (11, 2, 3, 129, 2);
INSERT INTO `tb_anket_cevaplari` VALUES (12, 2, 4, 129, 1);
INSERT INTO `tb_anket_cevaplari` VALUES (13, 1, 1, 2, 3);
INSERT INTO `tb_anket_cevaplari` VALUES (14, 1, 2, 2, 3);
INSERT INTO `tb_anket_cevaplari` VALUES (15, 1, 3, 2, 3);
INSERT INTO `tb_anket_cevaplari` VALUES (16, 1, 4, 2, 3);
INSERT INTO `tb_anket_cevaplari` VALUES (17, 2, 1, 2, 3);
INSERT INTO `tb_anket_cevaplari` VALUES (18, 2, 2, 2, 3);
INSERT INTO `tb_anket_cevaplari` VALUES (19, 2, 3, 2, 3);
INSERT INTO `tb_anket_cevaplari` VALUES (20, 2, 4, 2, 3);
INSERT INTO `tb_anket_cevaplari` VALUES (21, 1, 1, 1, 2);
INSERT INTO `tb_anket_cevaplari` VALUES (22, 1, 2, 1, 2);
INSERT INTO `tb_anket_cevaplari` VALUES (23, 1, 3, 1, 2);
INSERT INTO `tb_anket_cevaplari` VALUES (24, 1, 4, 1, 2);
INSERT INTO `tb_anket_cevaplari` VALUES (25, 2, 1, 1, 2);
INSERT INTO `tb_anket_cevaplari` VALUES (26, 2, 2, 1, 2);
INSERT INTO `tb_anket_cevaplari` VALUES (27, 2, 3, 1, 2);
INSERT INTO `tb_anket_cevaplari` VALUES (28, 2, 4, 1, 2);
INSERT INTO `tb_anket_cevaplari` VALUES (29, 2, 1, 131, 4);
INSERT INTO `tb_anket_cevaplari` VALUES (30, 2, 2, 131, 3);
INSERT INTO `tb_anket_cevaplari` VALUES (31, 2, 3, 131, 3);
INSERT INTO `tb_anket_cevaplari` VALUES (32, 2, 4, 131, 2);
INSERT INTO `tb_anket_cevaplari` VALUES (33, 3, 1, 1, 4);
INSERT INTO `tb_anket_cevaplari` VALUES (34, 3, 2, 1, 4);
INSERT INTO `tb_anket_cevaplari` VALUES (35, 3, 1, 2, 2);
INSERT INTO `tb_anket_cevaplari` VALUES (36, 3, 2, 2, 1);

-- ----------------------------
-- Table structure for tb_anket_ogrencileri
-- ----------------------------
DROP TABLE IF EXISTS `tb_anket_ogrencileri`;
CREATE TABLE `tb_anket_ogrencileri`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `anket_id` int NULL DEFAULT NULL,
  `ogrenci_id` int NULL DEFAULT NULL,
  `anket_bitti` tinyint UNSIGNED NULL DEFAULT 0 COMMENT '1 Olması Bitti anlamında 0 Olması Katılmadığı anlamında',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_anket_ogrencileri
-- ----------------------------
INSERT INTO `tb_anket_ogrencileri` VALUES (1, 1, 3, 0);
INSERT INTO `tb_anket_ogrencileri` VALUES (2, 1, 9, 0);
INSERT INTO `tb_anket_ogrencileri` VALUES (3, 1, 4, 0);
INSERT INTO `tb_anket_ogrencileri` VALUES (4, 1, 129, 1);
INSERT INTO `tb_anket_ogrencileri` VALUES (5, 1, 131, 1);
INSERT INTO `tb_anket_ogrencileri` VALUES (6, 1, 2, 1);
INSERT INTO `tb_anket_ogrencileri` VALUES (7, 1, 1, 1);
INSERT INTO `tb_anket_ogrencileri` VALUES (8, 2, 3, 0);
INSERT INTO `tb_anket_ogrencileri` VALUES (9, 2, 9, 0);
INSERT INTO `tb_anket_ogrencileri` VALUES (10, 2, 4, 0);
INSERT INTO `tb_anket_ogrencileri` VALUES (11, 2, 129, 1);
INSERT INTO `tb_anket_ogrencileri` VALUES (12, 2, 130, 0);
INSERT INTO `tb_anket_ogrencileri` VALUES (13, 2, 2, 1);
INSERT INTO `tb_anket_ogrencileri` VALUES (14, 2, 1, 1);
INSERT INTO `tb_anket_ogrencileri` VALUES (15, 2, 131, 1);
INSERT INTO `tb_anket_ogrencileri` VALUES (16, 3, 3, 0);
INSERT INTO `tb_anket_ogrencileri` VALUES (17, 3, 9, 0);
INSERT INTO `tb_anket_ogrencileri` VALUES (18, 3, 4, 0);
INSERT INTO `tb_anket_ogrencileri` VALUES (19, 3, 129, 0);
INSERT INTO `tb_anket_ogrencileri` VALUES (20, 3, 130, 0);
INSERT INTO `tb_anket_ogrencileri` VALUES (21, 3, 2, 1);
INSERT INTO `tb_anket_ogrencileri` VALUES (22, 3, 1, 1);
INSERT INTO `tb_anket_ogrencileri` VALUES (23, 3, 131, 0);

-- ----------------------------
-- Table structure for tb_anket_sablon
-- ----------------------------
DROP TABLE IF EXISTS `tb_anket_sablon`;
CREATE TABLE `tb_anket_sablon`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `universite_id` int NULL DEFAULT NULL,
  `fakulte_id` int NULL DEFAULT NULL,
  `program_id` int NULL DEFAULT NULL,
  `donem_id` int NULL DEFAULT NULL,
  `adi` varchar(100) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `aktif` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_anket_sablon
-- ----------------------------
INSERT INTO `tb_anket_sablon` VALUES (1, 1, NULL, NULL, NULL, 'Anket Değerlendirme Formu', 0);
INSERT INTO `tb_anket_sablon` VALUES (2, 1, NULL, NULL, NULL, 'Öğretim Görevlisi Değerlendirme', 1);

-- ----------------------------
-- Table structure for tb_anket_sablon_sorulari
-- ----------------------------
DROP TABLE IF EXISTS `tb_anket_sablon_sorulari`;
CREATE TABLE `tb_anket_sablon_sorulari`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `sablon_id` int NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `aktif` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_anket_sablon_sorulari
-- ----------------------------
INSERT INTO `tb_anket_sablon_sorulari` VALUES (1, 2, 'Öğretim Görevlisi bilgisi yeterli mi?', 1);
INSERT INTO `tb_anket_sablon_sorulari` VALUES (2, 2, 'Öğretim görevlisi zamanında geliyor', 1);
INSERT INTO `tb_anket_sablon_sorulari` VALUES (3, 2, 'Öğretim görevlisi tertipli mi?', 0);
INSERT INTO `tb_anket_sablon_sorulari` VALUES (4, 2, 'Öğrencilere kaba davranıyor mu?', 0);

-- ----------------------------
-- Table structure for tb_anket_sorulari
-- ----------------------------
DROP TABLE IF EXISTS `tb_anket_sorulari`;
CREATE TABLE `tb_anket_sorulari`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `anket_id` int NULL DEFAULT NULL,
  `soru_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_anket_sorulari
-- ----------------------------
INSERT INTO `tb_anket_sorulari` VALUES (1, 1, 1);
INSERT INTO `tb_anket_sorulari` VALUES (2, 1, 2);
INSERT INTO `tb_anket_sorulari` VALUES (3, 1, 3);
INSERT INTO `tb_anket_sorulari` VALUES (4, 1, 4);
INSERT INTO `tb_anket_sorulari` VALUES (5, 2, 1);
INSERT INTO `tb_anket_sorulari` VALUES (6, 2, 2);
INSERT INTO `tb_anket_sorulari` VALUES (7, 2, 3);
INSERT INTO `tb_anket_sorulari` VALUES (8, 2, 4);
INSERT INTO `tb_anket_sorulari` VALUES (9, 3, 1);
INSERT INTO `tb_anket_sorulari` VALUES (10, 3, 2);
INSERT INTO `tb_anket_sorulari` VALUES (11, 3, 3);
INSERT INTO `tb_anket_sorulari` VALUES (12, 3, 4);
INSERT INTO `tb_anket_sorulari` VALUES (13, 4, 1);
INSERT INTO `tb_anket_sorulari` VALUES (14, 4, 2);
INSERT INTO `tb_anket_sorulari` VALUES (15, 4, 3);
INSERT INTO `tb_anket_sorulari` VALUES (16, 4, 4);

-- ----------------------------
-- Table structure for tb_anketler
-- ----------------------------
DROP TABLE IF EXISTS `tb_anketler`;
CREATE TABLE `tb_anketler`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `universite_id` int NULL DEFAULT NULL,
  `fakulte_id` int NULL DEFAULT NULL,
  `donem_id` int NULL DEFAULT NULL,
  `kategori` int NULL DEFAULT NULL,
  `kategori_id` int NULL DEFAULT NULL,
  `sablon_id` int NULL DEFAULT NULL,
  `adi` varchar(100) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `aktif` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_anketler
-- ----------------------------
INSERT INTO `tb_anketler` VALUES (1, 1, NULL, 1, 1, 1, 2, 'Dönem Personel  Degerlendirmesi', 1);
INSERT INTO `tb_anketler` VALUES (2, 1, NULL, 1, 1, 1, 2, 'Sınav Sonrası Anket', 1);
INSERT INTO `tb_anketler` VALUES (3, 1, NULL, 1, 1, 1, 2, 'asdasd', 1);
INSERT INTO `tb_anketler` VALUES (4, 1, NULL, 1, 1, 3, 2, 'Şablon Adı', 1);

-- ----------------------------
-- Table structure for tb_birim_agaci
-- ----------------------------
DROP TABLE IF EXISTS `tb_birim_agaci`;
CREATE TABLE `tb_birim_agaci`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ust_id` int NULL DEFAULT NULL,
  `adi_kz` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `adi_ru` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `adi_en` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `kisa_ad` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL,
  `kategori` tinyint NULL DEFAULT NULL,
  `grup` tinyint NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 279 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_birim_agaci
-- ----------------------------
INSERT INTO `tb_birim_agaci` VALUES (1, 0, 'Ahmet Yesevi Üniversitesi', 'Ahmet Yesevi Üniversitesi', 'Ahmet Yesevi Üniversitesi', 'Ahmet Yesevi Üniversitesi', 'ahmet-yesevi-universitesi', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (2, 1, 'Академиялық бөлім', 'Академическая единица', 'Academic Unit', 'Akademik Birimler', 'akademik-birimler', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (3, 1, NULL, NULL, 'Administrative Units', 'İdari Birimler', 'idari-birimler', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (4, 2, 'Факультет\r\n', 'Факультет', 'Faculty', 'Fakülteler', 'fakulteler', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (5, 2, NULL, NULL, NULL, 'Enstitüler', 'enstituler', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (6, 2, NULL, NULL, NULL, 'Merkezler', 'merkezler', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (7, 2, NULL, NULL, NULL, 'Meslek Yüksekokulları', 'meslek-yuksekokullari', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (8, 4, 'Әлеуметтік - Гуманитарлық  ғылымдар', 'Социально-гуманитарных наук', 'Social and Humanitarian Sciences', 'Sosyal ve Beşeri bilimler Fakültesi', 'sosyal-ve-beseri-bilimler-fakultesi', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (9, 4, 'Спорт және өнер ', 'Спорта и искусства', 'Sports and Art', 'Spor ve Sanat Fakültesi', 'spor-ve-sanat-fakultesi', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (10, 4, 'Жаратылыстану ғылымдар', 'Естестенных наук', 'Natural Sciences', 'Fen Fakültesi', 'fen-fakultesi', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (11, 4, 'Инженерия', 'Инженерии', 'Engineering', 'Mühendislik Fakültesi', 'muhendislik-fakultesi', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (12, 4, 'Филология', 'Филологический', 'Philological', 'Filoloji Fakültesi', 'filoloji-fakultesi', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (14, 4, 'Теология', 'Теологический', 'Theological', 'Teoloji Fakültesi', 'teoloji-fakultesi', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (15, 4, 'Экономика, басқару және құқық', 'Экономики, управления и права', 'Economics, Management and Law', 'İktisadi ve İdari Bilimler Fakültesi', 'iktisadi-ve-idari-bilimler-fakultesi', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (16, 4, 'Медицина', 'Медицинский', 'Medical', 'Tıp Fakültesi', 'tip-fakultesi', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (17, 4, 'Стоматология', 'Стоматологический', 'Dental', 'Diş Hekimliği Fakültesi', 'dis-hekimligi-fakultesi', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (19, 4, 'Жаратылыстану ғылымдар', 'Естестенных наук', 'Natural Sciences', 'Fen Bilimleri Fakültesi', 'fen-bilimleri-fakultesi', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (20, 4, 'Әлеуметтік - Гуманитарлық  ғылымдар', 'Социально-гуманитарных наук', 'Social and Humanitarian Sciences', 'İnsan Ve Toplum Bilimleri Fakültesi', 'insan-ve-toplum-bilimleri-fakultesi', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (21, 4, 'Жоғары медициналық білімнен кейінгі білім беру', 'Послевузовского высшего медицинское образования', 'Postgraduate higher medical education', 'Lisansüstü Tıp Eğitimi  Fakültesi', 'lisansustu-tip-egitimi-fakultesi', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (22, 8, 'Бакалавриат', 'Бакалавриат', 'Undergraduate', 'Lisans', 'lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (23, 8, 'Магистратура', 'Магистратура', 'Master', 'Yüksek Lisans', 'yuksek-lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (25, 9, 'Бакалавриат', 'Бакалавриат', 'Undergraduate', 'Lisans', 'lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (26, 9, 'Магистратура', 'Магистратура', 'Master', 'Yüksek Lisans', 'yuksek-lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (28, 10, 'Бакалавриат', 'Бакалавриат', 'Undergraduate', 'Lisans', 'lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (29, 10, 'Магистратура', 'Магистратура', 'Master', 'Yüksek Lisans', 'yuksek-lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (31, 11, 'Бакалавриат', 'Бакалавриат', 'Undergraduate', 'Lisans', 'lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (32, 11, 'Магистратура', 'Магистратура', 'Master', 'Yüksek Lisans', 'yuksek-lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (33, 11, 'Докторантура', 'Докторантура', 'PhD', 'Doktora', 'doktora', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (34, 12, 'Бакалавриат', 'Бакалавриат', 'Undergraduate', 'Lisans', 'lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (35, 12, 'Магистратура', 'Магистратура', 'Master', 'Yüksek Lisans', 'yuksek-lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (36, 12, 'Докторантура', 'Докторантура', 'PhD', 'Doktora', 'doktora', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (40, 14, 'Бакалавриат', 'Бакалавриат', 'Undergraduate', 'Lisans', 'lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (41, 14, 'Магистратура', 'Магистратура', 'Master', 'Yüksek Lisans', 'yuksek-lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (43, 15, 'Бакалавриат', 'Бакалавриат', 'Undergraduate', 'Lisans', 'lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (44, 15, 'Магистратура', 'Магистратура', 'Master', 'Yüksek Lisans', 'yuksek-lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (45, 15, 'Докторантура', 'Докторантура', 'PhD', 'Doktora', 'doktora', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (46, 16, 'Бакалавриат', 'Бакалавриат', 'Undergraduate', 'Lisans', 'lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (47, 16, 'Магистратура', 'Магистратура', 'Master', 'Yüksek Lisans', 'yuksek-lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (48, 16, 'Докторантура', 'Докторантура', 'PhD', 'Doktora', 'doktora', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (49, 17, 'Бакалавриат', 'Бакалавриат', 'Undergraduate', 'Lisans', 'lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (50, 17, 'Магистратура', 'Магистратура', 'Master', 'Yüksek Lisans', 'yuksek-lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (51, 17, 'Докторантура', 'Докторантура', 'PhD', 'Doktora', 'doktora', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (55, 19, 'Бакалавриат', 'Бакалавриат', 'Undergraduate', 'Lisans', 'lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (56, 19, 'Магистратура', 'Магистратура', 'Master', 'Yüksek Lisans', 'yuksek-lisans', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (57, 19, 'Докторантура', 'Докторантура', 'PhD', 'Doktora', 'doktora', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (60, 20, 'Докторантура', 'Докторантура', 'PhD', 'Doktora', 'doktora', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (61, 21, 'Резидентура\r\n', 'Резидентура\r\n', 'Specialization Training in Medicine', 'Tıpta Uzmanlık Eğitimi', 'tipta-uzmanlik-egitimi', 1, 1);
INSERT INTO `tb_birim_agaci` VALUES (62, 22, 'Педагогика және психология', 'Педагогики и психологии', 'Pedagogy and psychology', 'Pedagoji ve psikoloji Bölümü', 'pedagoji-ve-psikoloji-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (63, 22, 'Мектепке дейінгі және бастауышта білім беру', 'Дошкольного и начального образования', 'Preschool and primary education', 'Okul öncesi ve ilkokul eğitimi Bölümü', 'okul-oncesi-ve-ilkokul-egitimi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (64, 22, 'Тарих', 'Истории', 'Historii', 'Tarih Bölümü', 'tarih-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (65, 22, 'Журналистика', 'Журналистики', 'Journalism', 'Gazetecilik Bölümü', 'gazetecilik-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (66, 23, 'Педагогика және психология', 'Педагогики и психологии', 'Pedagogy and psychology', 'Pedagoji ve psikoloji Bölümü', 'pedagoji-ve-psikoloji-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (67, 23, 'Мектепке дейінгі және бастауышта білім беру', 'Дошкольного и начального образования', 'Preschool and primary education', 'Okul öncesi ve ilkokul eğitimi Bölümü', 'okul-oncesi-ve-ilkokul-egitimi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (68, 23, 'Тарих', 'Истории', 'Historii', 'Tarih Bölümü', 'tarih-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (69, 25, 'Дене мәдениеті', 'Физической культуры', 'Physical education', 'Beden eğitimi Bölümü', 'beden-egitimi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (70, 25, 'Орындаушылық өнер', 'Исполнительского искусства', 'Executive search', 'Sahne sanatları Bölümü', 'sahne-sanatlari-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (71, 25, 'Бейнелеу өнері', 'Изобразительного искусство', 'Fine arts', 'Güzel sanatlar Bölümü', 'guzel-sanatlar-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (72, 26, 'Дене мәдениеті', 'Физической культуры', 'Physical education', 'Beden eğitimi Bölümü', 'beden-egitimi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (73, 26, 'Орындаушылық өнер', 'Исполнительского искусства', 'Executive search', 'Sahne sanatları Bölümü', 'sahne-sanatlari-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (74, 26, 'Бейнелеу өнері', 'Изобразительного искусство', 'Fine arts', 'Güzel sanatlar Bölümü', 'guzel-sanatlar-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (75, 28, 'Математика', 'Математики', 'Mathematicians', 'Matematik Bölümü', 'matematik-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (76, 28, 'Физика', 'Физики', 'Physicists', 'Fizik Bölümü', 'fizik-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (77, 28, 'Экология және химия', 'Экологии и химии', 'Ecology and Chemistry', 'Ekoloji ve Kimya Bölümü', 'ekoloji-ve-kimya-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (78, 28, 'Биология', 'Биологии', 'Biology', 'Biyoloji Bölümü', 'biyoloji-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (79, 29, 'Физика', 'Физики', 'Physicists', 'Fizik Bölümü', 'fizik-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (80, 29, 'Математика', 'Математики', 'Mathematicians', 'Matematik Bölümü', 'matematik-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (81, 29, 'Экология және химия', 'Экологии и химии', 'Ecology and Chemistry', 'Ekoloji ve Kimya Bölümü', 'ekoloji-ve-kimya-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (82, 29, 'Биология', 'Биологии', 'Biology', 'Biyoloji Bölümü', 'biyoloji-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (83, 31, 'Компьютерлік ғылымдар', 'Компьютерных наук', 'Computer Science', 'Bilgisayar Bilimi Bölümü', 'bilgisayar-bilimi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (84, 31, 'Компьютерлік инженерия', 'Компьютерной инженерии', 'Computer Engineering', 'Bilgisayar Mühendisliği Bölümü', 'bilgisayar-muhendisligi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (85, 31, 'Электр инженериясы', 'Электроинженерии', 'Electrical Engineering', 'Elektrik Mühendisliği Bölümü', 'elektrik-muhendisligi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (86, 32, 'Компьютерлік ғылымдар', 'Компьютерных наук', 'Computer Science', 'Bilgisayar Bilimi Bölümü', 'bilgisayar-bilimi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (87, 32, 'Компьютерлік инженерия', 'Компьютерной инженерии', 'Computer Engineering', 'Bilgisayar Mühendisliği Bölümü', 'bilgisayar-muhendisligi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (88, 32, 'Электр инженериясы', 'Электроинженерии', 'Electrical Engineering', 'Elektrik Mühendisliği Bölümü', 'elektrik-muhendisligi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (89, 33, 'Компьютерлік ғылымдар', 'Компьютерных наук', 'Computer Science', 'Bilgisayar Bilimi Bölümü', 'bilgisayar-bilimi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (90, 33, 'Компьютерлік инженерия', 'Компьютерной инженерии', 'Computer Engineering', 'Bilgisayar Mühendisliği Bölümü', 'bilgisayar-muhendisligi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (92, 34, 'Қазақ филологиясы ', 'Казахской филологии ', 'Kazakh Philology', 'Kazak Filolojisi Bölümü', 'kazak-filolojisi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (93, 34, 'Орыс тілі және әдебиеті', 'Русского языка и литература', 'Russian language and literature', 'Rus dili ve edebiyatı Bölümü', 'rus-dili-ve-edebiyati-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (94, 34, 'Педагогикалық шетел тілдері', 'Педагогических иностранных языков', 'Pedagogical foreign languages', 'Pedagojik yabancı diller Bölümü', 'pedagojik-yabanci-diller-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (95, 34, 'Түрік филологиясы', 'Турецкой филологии', 'Turkish Philology', 'Türk Filolojisi Bölümü', 'turk-filolojisi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (96, 34, 'Ағылшын филологиясы және аударма ісі', 'Английской филологии и переводческого дела', 'English Philology and Translation', 'İngiliz Filolojisi ve çeviri işleri Bölümü', 'ingiliz-filolojisi-ve-ceviri-isleri-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (98, 35, 'Педагогикалық шетел тілдері', 'Педагогических иностранных языков', 'Pedagogical foreign languages', 'Pedagojik yabancı diller Bölümü', 'pedagojik-yabanci-diller-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (99, 35, 'Қазақ филологиясы ', 'Казахской филологии', 'Kazakh Philology', 'Kazak Filolojisi Bölümü', 'kazak-filolojisi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (100, 35, 'Орыс тілі және әдебиеті', 'Русского языка и литература', 'Russian language and literature', 'Rus dili ve edebiyatı Bölümü', 'rus-dili-ve-edebiyati-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (101, 35, 'Түрік филологиясы', 'Турецкой филологии', 'Turkish Philology', 'Türk Filolojisi Bölümü', 'turk-filolojisi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (102, 35, 'Ағылшын филологиясы және аударма ісі', 'Английской филологии и переводческого дела', 'English Philology and Translation', 'İngiliz Filolojisi ve çeviri işleri Bölümü', 'ingiliz-filolojisi-ve-ceviri-isleri-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (105, 36, 'Қазақ филологиясы ', 'Казахской филологии', 'Kazakh Philology', 'Kazak Filolojisi Bölümü', 'kazak-filolojisi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (106, 36, 'Педагогикалық шетел тілдері', 'Педагогических иностранных языков', 'Pedagogical foreign languages', 'Pedagojik yabancı diller Bölümü', 'pedagojik-yabanci-diller-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (110, 40, 'Дінтану', 'Религиоведения', 'Religious studies', 'Din Bilimi Bölümü', 'din-bilimi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (111, 40, 'Теология', 'Теологии', 'Theology', 'Teoloji Bölümü', 'teoloji-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (112, 41, 'Дінтану', 'Религиоведения', 'Religious studies', 'Din Bilimi Bölümü', 'din-bilimi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (113, 41, 'Теология', 'Теологии', 'Theology', 'Teoloji Bölümü', 'teoloji-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (114, 43, 'Мемлекеттік басқару және халықаралық қатынастар', 'Государственного управления и международных отношений', 'Public administration and international relations', 'Kamu yönetimi ve uluslararası ilişkiler Bölümü', 'kamu-yonetimi-ve-uluslararasi-iliskiler-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (115, 43, 'Менеджмент және туризм ', 'Менеджмента и туризма', 'Management and Tourism', 'Yönetim ve Turizm Bölümü', 'yonetim-ve-turizm-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (116, 43, 'Экономика, қаржы және есеп', 'Экономика, финансы и учет', 'Economics, Finance and Accounting', 'Ekonomi, Finans ve Muhasebe Bölümü', 'ekonomi-finans-ve-muhasebe-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (117, 43, 'Құқықтану', 'Юриспруденции', 'Law', 'Hukuk Bölümü', 'hukuk-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (118, 44, 'Мемлекеттік басқару және халықаралық қатынастар', 'Государственного управления и международных отношений', 'Public administration and international relations', 'Kamu yönetimi ve uluslararası ilişkiler Bölümü', 'kamu-yonetimi-ve-uluslararasi-iliskiler-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (119, 44, 'Экономика, қаржы және есеп', 'Экономика, финансы и учет', 'Economics, Finance and Accounting', 'Ekonomi, Finans ve Muhasebe Bölümü', 'ekonomi-finans-ve-muhasebe-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (120, 44, 'Менеджмент және туризм', 'Менеджмента и туризма', 'Management and Tourism', 'Yönetim ve Turizm Bölümü', 'yonetim-ve-turizm-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (121, 44, 'Құқықтану', 'Юриспруденции', 'Law', 'Hukuk Bölümü', 'hukuk-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (122, 45, 'Экономика, қаржы және есеп', 'Экономика, финансы и учет', 'Economics, Finance and Accounting', 'Ekonomi, Finans ve Muhasebe Bölümü', 'ekonomi-finans-ve-muhasebe-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (123, 45, 'Менеджмент және туризм ', 'Менеджмента и туризма', 'Management and Tourism', 'Yönetim ve Turizm Bölümü', 'yonetim-ve-turizm-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (124, 45, 'Мемлекеттік басқару және халықаралық қатынастар', 'Государственного управления и международных отношений', 'Public administration and international relations', 'Kamu yönetimi ve uluslararası ilişkiler Bölümü', 'kamu-yonetimi-ve-uluslararasi-iliskiler-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (125, 45, 'Құқықтану', 'Юриспруденции', 'Law', 'Hukuk Bölümü', 'hukuk-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (126, 46, 'деканат', NULL, 'Medicine', 'Tıp Bölümü', 'tip-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (127, 47, 'деканат', NULL, 'Medicine', 'Tıp Bölümü', 'tip-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (128, 48, 'деканат', NULL, 'Medicine', 'Tıp Bölümü', 'tip-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (129, 49, 'Стоматология', 'Стоматологический', 'Dentistry', 'Diş Hekimliği Bölümü', 'dis-hekimligi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (130, 56, 'Экология және химия', 'Экологии и химии', 'Ecology and Chemistry', 'Ekoloji ve Kimya Bölümü', 'ekoloji-ve-kimya-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (131, 56, 'Физика', 'Физики', 'Physicists', 'Fizik Bölümü', 'fizik-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (132, 56, 'Математика', 'Математики', 'Mathematicians', 'Matematik Bölümü', 'matematik-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (133, 57, 'Математика', 'Математики', 'Mathematicians', 'Matematikler Bölümü', 'matematikler-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (134, 57, 'Физика', 'Физики', 'Physicists', 'Fizikler Bölümü', 'fizikler-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (135, 60, 'Педагогика және психология', 'Педагогики и психологии', 'Pedagogy and psychology', 'Pedagoji ve psikoloji Bölümü', 'pedagoji-ve-psikoloji-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (136, 60, 'Тарих', 'Истории', 'History', 'Tarih Bölümü', 'tarih-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (137, 61, 'Акушерлік  гинекология', 'Акушерская гинекология', 'Obstetric gynecology', 'Obstetrik Jinekoloji Bölümü', 'obstetrik-jinekoloji-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (138, 61, 'Арнайы  хирургиялық  пәндер', 'Специальные хирургические дисциплины', 'Special surgical disciplines', 'Özel cerrahi disiplinler Bölümü', 'ozel-cerrahi-disiplinler-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (139, 61, 'Жалпы  дәрігерлік  практика 1', 'Общей врачебной практики 1', 'General medical practice 1', 'Genel Tıbbi uygulamalar 1 Bölümü', 'genel-tibbi-uygulamalar-1-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (140, 61, 'Жалпы  дәрігерлік  практика 2', 'Общей врачебной практики 2', 'General medical practice 2', 'Genel Tıbbi uygulamalar 2 Bölümü', 'genel-tibbi-uygulamalar-2-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (141, 61, 'Жұқпалы  аурулар  және  фтизиатрия', 'Инфекционных заболеваний и фтизиатрии', 'Infectious diseases and phthisiology', 'Bulaşıcı hastalıklar ve Phthysiatrics Bölümü', 'bulasici-hastaliklar-ve-phthysiatrics-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (142, 61, 'Ішкі  аурулар', 'Внутренних болезней', 'Internal diseases', 'Dahiliye Bölümü', 'dahiliye-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (143, 61, 'Неврология, психиатрия, наркология', 'Неврологии, психиатрии, наркологии', 'Neurology, psychiatry, narcology', 'Nöroloji, psikiyatri, uyuşturucu bilimi Bölümü', 'noroloji-psikiyatri-uyusturucu-bilimi-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (144, 61, 'Педиатрия', 'Педиатрии', 'Pediatrics', 'Pediatri Bölümü', 'pediatri-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (145, 61, 'Профилактикалық медицина және стоматологиялық пәндер', 'Профилактической медицины и стоматологических дисциплин', 'Preventive medicine and dental disciplines', 'Önleyici tıp ve diş disiplinleri Bölümü', 'onleyici-tip-ve-dis-disiplinleri-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (146, 61, 'Хирургия  және анестезиология-реанимация', 'Хирургия и анестезиология-реанимация', 'Surgery and Anesthesiology-Intensive care', 'Cerrahi ve Anesteziyoloji-Resüsitasyon Bölümü', 'cerrahi-ve-anesteziyoloji-resusitasyon-bolumu', 1, NULL);
INSERT INTO `tb_birim_agaci` VALUES (147, 49, 'Стоматология', 'Стоматология', 'Dentistry', 'Diş Hekimliği', 'dis-hekimligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (148, 62, 'Педагогика и психология', 'Педагогика және психология', 'Рedagogy and psychology', 'Pedagoji ve Psikoloji', 'pedagoji-ve-psikoloji', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (149, 63, 'Дошкольное обучение и воспитание', 'Мектепке дейінгі оқыту және тәрбиелеу', 'Pre-school education and upbringing', 'Okul Öncesi Eğitim ve Öğretim', 'okul-oncesi-egitim-ve-ogretim', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (150, 63, 'Педагогика и методика начального обучения', 'Бастауышта оқыту педагогикасы мен әдістемесі', 'Pedagogy and methods of primary education ', 'İlköğretim Pedagojisi ve Metodolojisi', 'ilkogretim-pedagojisi-ve-metodolojisi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (151, 64, 'История', 'Тарих', 'History', 'Tarih Öğretmenliği', 'tarih-ogretmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (152, 64, 'История', 'Тарих', 'History', 'Tarih', 'tarih', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (153, 65, 'Журналистика', 'Журналистика', 'Journalism', 'Gazetecilik', 'gazetecilik', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (154, 65, 'Цифровая медиа и телерадиожурналистика', 'Сандық медия және телерадиожурналистика', 'Digital media and TV, radio journalism', 'Dijital medya ve televizyon ve radyo gazeteciliği', 'dijital-medya-ve-televizyon-ve-radyo-gazeteciligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (155, 66, 'Педагогика и психология', 'Педагогика және психология', 'Pedagogy and psychology', 'Pedagoji ve Psikoloji', 'pedagoji-ve-psikoloji', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (156, 67, 'Педагогика дошкольного воспитания и обучения', 'Мектепке дейінгі тәрбиелеу және оқыту педагогикасы', 'Pedagogy of the pre-school education and upbringing', 'Okul Öğrenci Öğretmenliği', 'okul-ogrenci-ogretmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (157, 67, 'Педагогика и методика начального обучения', 'Бастауышта оқыту педагогикасы мен әдістемесі', 'Pedagogy and methods of primary education', 'Sınıf Öğretmenliği', 'sinif-ogretmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (158, 68, 'История', 'Тарих', 'History', 'Tarih', 'tarih', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (159, 69, 'Начальная военная подготовка', 'Бастапқы әскери дайындық', 'Basic Military Training', 'İlk Askeri Hazırlık', 'ilk-askeri-hazirlik', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (160, 69, 'Физическая культура и спорт', 'Денешынықтыру және спорт', 'Physical education and sports', 'Beden Eğitimi ve Spor', 'beden-egitimi-ve-spor', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (161, 69, 'Физическая культура и начальная военная подготовка', 'Дене шынықтыру және бастапқы әскери дайындық', 'Physical education and initial military training', 'Beden Eğitimi ve Spor', 'beden-egitimi-ve-spor', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (162, 70, 'Музыкальное образование', 'Музыкалық білім', 'Music Education', 'Müzik Eğitimi', 'muzik-egitimi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (163, 70, 'Вокальное искусство', 'Вокалдық өнер', 'Vocal art', 'Vokal Sanatı', 'vokal-sanati', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (164, 70, 'Искусство эстрады', 'Эстрада өнері', 'Pop art ', 'Pop Müzik Sanatı ', 'pop-muzik-sanati-', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (165, 70, 'Традиционное музыкальное искусство(Народное пение)', 'Дәстүрлі музыка өнері (Халық әні)', 'Traditional Music Art (Folk singing)', 'Geleneksel müzik sanatı', 'geleneksel-muzik-sanati', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (166, 70, 'Актерское искусство', 'Актерлік өнер', 'Acting art', 'Oyunculuk Sanatı', 'oyunculuk-sanati', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (167, 70, 'Хореография', 'Хореография', 'Choreography', 'Koreografi', 'koreografi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (168, 71, 'Изобразительное искусство и черчение', 'Бейнелеу өнері және сызу', 'Fine Art and Drawing', 'Güzel Sanatlar ve Çizim', 'guzel-sanatlar-ve-cizim', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (169, 71, 'Профессиональное обучение', 'Кәсіптік оқыту', 'Professional Training', 'Meslekî Eğitim', 'meslek-egitim', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (170, 71, 'Художественный труд и графическое проектирование ', 'Көркем еңбек және графикалық жобалау ', 'Artistic work and graphic design', 'Sanatsal Çalışma ve Grafik Çizim', 'sanatsal-calisma-ve-grafik-cizim', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (171, 71, 'Декоративное искусство', 'Сән өнері', 'Decorative Art', 'Dekoratif Sanatı', 'dekoratif-sanati', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (172, 71, 'Дизайн', 'Дизайн', 'Design', 'Tasarım', 'tasarim', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (173, 71, 'Декоративно-прикладное искусство', 'Сәндік-қолданбалы өнері', 'Decorative and applied art', 'Dekoratif Sanatlar', 'dekoratif-sanatlar', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (174, 72, 'Физическая культура и спорт', 'Дене шынықтыру және спорт', 'Physical Culture and Sport', 'Fiziksel Kültür ve Spor', 'fiziksel-kultur-ve-spor', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (175, 73, 'Музыкальное образование', 'Музыкалық білім', 'Music Education', 'Müzik Eğitimi', 'muzik-egitimi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (176, 74, 'Изобразительное искусство и черчение', 'Бейнелеу өнері және сызу', 'Fine Art and Drawing', 'Güzel Sanatlar ve Çizim', 'guzel-sanatlar-ve-cizim', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (177, 75, 'Математика', 'Математика', 'Mathematics', 'Matematik Öğretmenliği', 'matematik-ogretmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (178, 75, 'Математика ', 'Математика', 'Mathematics', 'Matematik', 'matematik', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (179, 76, 'Физика', 'Физика', 'Physics', 'Fizik Öğretmenliği', 'fizik-ogretmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (180, 76, 'Физика ', 'Физика', 'Physics', 'Fizik', 'fizik', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (181, 77, 'Химия', 'Химия', 'Chemistry', 'Kimya Öğetmenliği', 'kimya-ogetmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (182, 77, 'Химия-Биология ', 'Химия-Биология ', 'Chemistry-Biology ', 'Kimya-Biyoloji Öğretmenliği', 'kimya-biyoloji-ogretmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (183, 77, 'География', 'География', 'Geography', 'Coğrafya Öğretmenliği', 'cografya-ogretmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (184, 77, 'Экология ', 'Экология', 'Ecology', 'Ekoloji', 'ekoloji', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (185, 78, 'Биология', 'Биология', 'Biology', 'Biyoloji Öğretmenliği', 'biyoloji-ogretmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (186, 78, 'Биология', 'Биология', 'Biology', 'Biyoloji', 'biyoloji', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (187, 78, 'Биотехнология ', 'Биотехнология ', 'Biotechnology ', 'Biyoteknoloji', 'biyoteknoloji', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (188, 79, 'Физика', 'Физика', 'Physics', 'Fizik Öğretmenliği', 'fizik-ogretmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (189, 80, 'Математика', 'Математика', 'Mathematics', 'Matematik Öğretmenliği', 'matematik-ogretmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (190, 81, 'Химия', 'Химия', 'Chemistry', 'Kimya Öğetmenliği', 'kimya-ogetmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (191, 82, 'Биология', 'Биология', 'Biology', 'Biyoloji Öğretmenliği', 'biyoloji-ogretmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (192, 83, 'Информатика', 'Информатика', 'Computer Science ', 'Bilgi İşlem', 'bilgi-islem', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (193, 83, 'Информатика, ИКТ и робототехника ', 'Информатика, АКТ және робототехника ', 'Computer Science, ICT and robotic', 'Bilgi İşlem, Bilişim Teknolojileri ve Robototeknik ', 'bilgi-islem-bilisim-teknolojileri-ve-robototeknik-', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (194, 84, 'Информационные системы', 'Ақпараттық жүйелер', 'Information Systems', 'Bilişim Sistemleri', 'bilisim-sistemleri', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (195, 84, 'Вычислительная техника и программное обеспечение', 'Есептеу техникасы және бағдарламалық қамтамасыз ету', 'Computing and Software', 'Hesaplama Teknikleri ve Programlama', 'hesaplama-teknikleri-ve-programlama', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (196, 84, 'Компьютерная инженерия ', 'Компьютерлік инженерия  ', 'Computer Enginering', 'Bilgisayar Mühendisliği ', 'bilgisayar-muhendisligi-', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (197, 84, 'Обработка информации и визуализация данных ', 'Ақпаратты өңдеу және деректерді визуализациялау ', 'Information Processing and Data Visualization ', 'Bilgi İşlem ve Verilerin Görselleştirilmesi', 'bilgi-islem-ve-verilerin-gorsellestirilmesi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (198, 85, 'Электроэнергетика', 'Электр энергетика', 'Electrical power engineering', 'Elektrik Enerjisi', 'elektrik-enerjisi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (200, 85, 'Машиностроение', 'Машина жасау', 'Mechanical engineering', 'Makine Mühendisliği', 'makine-muhendisligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (201, 86, 'Информатика ', 'Информатика', 'Computer Science', 'Bilgi İşlem', 'bilgi-islem', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (202, 87, 'Информатика', 'Информатика', 'Computer Science', 'Bilgi İşlem', 'bilgi-islem', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (203, 87, 'Информационные системы', 'Ақпараттық жүйелер', 'Information Systems', 'Bilişim Sistemleri', 'bilisim-sistemleri', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (204, 87, 'Компьютерная инженерия ', 'Компьютерлік инженерия  ', 'Computer Enginering', 'Bilgisayar Mühendisliği ', 'bilgisayar-muhendisligi-', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (205, 88, 'Электроэнергетика', 'Электр энергетикасы', 'Electrical power engineering', 'Electricity', 'electricity', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (206, 88, 'Автоматизация и управление', 'Автоматтандыру және басқару', 'Automation and Management', 'Automation and Management', 'automation-and-management', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (207, 89, 'Информатика', 'Информатика', 'Computer Science', 'Bilgi İşlem', 'bilgi-islem', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (208, 90, 'Информационные системы', 'Ақпараттық жүйелер ', 'Information Systems', 'Bilişim Sistemleri', 'bilisim-sistemleri', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (209, 92, 'Казахский язык и литература', 'Қазақ тілі мен әдебиеті', 'Kazakh language and literature', 'Kazak Dili ve Edebiyatı', 'kazak-dili-ve-edebiyati', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (210, 92, 'Филология: казахская филология', 'Филология: қазақ филологиясы', 'Philology: Kazakh Philology', 'Kazak Dili ve Edebiyatı', 'kazak-dili-ve-edebiyati', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (211, 93, 'Русский язык и литература', 'Орыс тілі мен әдебиеті', 'Russian language and literature ', 'Rus Dili ve Edebiyatı', 'rus-dili-ve-edebiyati', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (212, 93, 'Русский язык и литература с нерусским языком обучения ', 'Орыс тілінде оқытпайтын мектептердегі орыс тілі мен әдебиеті  ', 'Russian Language and Literature in International  Schools ', 'Rusçada Eğitim Vermeyen Okullarda Rus Dili ve Edebiyatı', 'ruscada-egitim-vermeyen-okullarda-rus-dili-ve-edebiyati', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (213, 94, 'Иностранный язык: два иностранных языка (английский-китайский)', 'Шетел тілі: екі шетел тілі (ағылшын-қытай)', 'Foreign language: two foreign languages (English - Chinese )', 'İngilizce Çince Öğretmenliği', 'ingilizce-cince-ogretmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (214, 94, 'Иностранный язык: два иностранных языка (английский-турецский)', 'Шетел тілі: екі шетел тілі (ағылшын-түрік)', 'Foreign Language: Two Foreign Languages(English -Turkish )', 'İngilizce Türkçe Öğretmenliği', 'ingilizce-turkce-ogretmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (215, 95, 'Тюркология ', 'Түркітану ', 'Turkology', 'Türkoloji', 'turkoloji', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (216, 95, 'Иностранная филология (турецский язык)', 'Шетел филологиясы  (түрік тілі)', 'Foreign Philology:(тurkish language)', 'Türk Dili Ve Edebiyatı', 'turk-dili-ve-edebiyati', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (217, 96, 'Иностранная филология (английский язык)', 'Шетел филологиясы (ағылшын тілі)', 'Foreign Philology:  (english language)', 'İngiliz Dili ve Edebiyatı', 'ingiliz-dili-ve-edebiyati', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (219, 98, 'Иностранный язык: два иностранных языка', 'Шетел тілі: екі шетел тілі', 'Foreign Language: Two Foreign Languages', 'Yabancı Dil: İki Yabancı Dil ', 'yabanci-dil-iki-yabanci-dil-', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (220, 99, 'Казахский язык и литература', 'Қазақ тілі мен әдебиеті', 'Kazakh Language and Literature ', 'Kazak Dili ve Edebiyatı Öğretmenliği', 'kazak-dili-ve-edebiyati-ogretmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (221, 99, 'Филология', 'Филология', 'Philology', 'Dil Bilimi', 'dil-bilimi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (222, 100, 'Русский язык и литература ', 'Орыс тілі мен әдебиеті', 'Russian language and literature', 'Rus Dili ve Edebiyatı Öğretmenliği', 'rus-dili-ve-edebiyati-ogretmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (223, 101, 'Тюркология', 'Түркітану', 'Turkology', 'Türkoloji', 'turkoloji', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (224, 101, 'Иностранная филология (турецкий язык)', 'Шетел филологиясы: Түрік тілі', 'Foreign Philology (Turkish)', 'Türk Dili ve Edebiyatı', 'turk-dili-ve-edebiyati', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (225, 102, 'Иностранная филология (английский язык)', 'Шетел филологиясы:  Ағылшын тілі', 'Foreign Philology(English)', 'İngiliz Dili ve Edebiyatı', 'ingiliz-dili-ve-edebiyati', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (226, 105, 'Казахский язык и литература', 'Қазақ тілі мен әдебиеті', 'Kazakh language and literature ', 'Kazak Dili ve Edebiyatı', 'kazak-dili-ve-edebiyati', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (227, 106, 'Иностранный язык: два иностранных языка', 'Шетел тілі: екі шетел тілі ', 'Foreign Language: Two Foreign Languages', 'Yabancı Dil: İki Yabancı Dil Öğretmenliği', 'yabanci-dil-iki-yabanci-dil-ogretmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (228, 110, 'Философия -Религиоведение ', 'Философия-Дінтану', 'Philosophy-Religious Studies', 'Din Felsefesi', 'din-felsefesi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (229, 110, 'Религиоведение', 'Дінтану', 'Religious Studies', 'Din Bilimleri', 'din-bilimleri', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (230, 110, 'Религиоведение', 'Дінтану', 'Religious Studies', 'Din Bilimleri', 'din-bilimleri', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (231, 110, 'Психология-Религиоведение', 'Психология-Дінтану', 'Psychology-Religious Studies', 'Din Psikolojisi', 'din-psikolojisi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (232, 111, 'Теология', 'Теология', 'Theology', 'İlahiyat', 'ilahiyat', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (233, 111, 'Исламоведение', 'Исламтану', 'Islamic Studies', 'İslam Bilimleri', 'islam-bilimleri', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (234, 112, 'Религиоведение', 'Дінтану', 'Religious Studies', 'Din Bilimleri', 'din-bilimleri', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (235, 113, 'Теология', 'Теология', 'Theology', 'İlahiyat', 'ilahiyat', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (236, 114, 'Международные отношения', 'Халықаралық қатынастар', 'International Relations', 'Uluslararası İlişkiler', 'uluslararasi-iliskiler', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (237, 114, 'Государственное и местное управление', 'Мемлекеттік және жергілікті басқару', 'Public and Local administration', 'Kamu ve Yerel Yönetimi', 'kamu-ve-yerel-yonetimi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (238, 115, 'Менеджмент', 'Менеджмент ', 'Management', 'İşletme', 'isletme', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (239, 115, 'Туризм', 'Туризм', 'Tourism', 'Turizm', 'turizm', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (241, 116, 'Учет и аудит', 'Есеп және аудит', 'Accounting and Audit', 'Muhasebe ve Denetim', 'muhasebe-ve-denetim', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (242, 116, 'Финансы', 'Қаржы', 'Finance', 'Finans', 'finans', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (243, 116, 'Экономика', 'Экономика', 'Economics', 'Ekonomi ', 'ekonomi-', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (244, 117, 'Юриспруденция', 'Құқықтану', 'Jurisprudence', 'Hukuk', 'hukuk', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (245, 117, 'Правоохранительная деятельность', 'Құқыққорғау қызметі', 'Law enforcement ', 'Hukuk Hizmetleri', 'hukuk-hizmetleri', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (246, 117, 'Международное право', 'Халықаралық құқық', 'International Law', 'Uluslararası Hukuk', 'uluslararasi-hukuk', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (247, 118, 'Политология', 'Саясаттану', 'Political Science ', 'Siyaset Bilimi', 'siyaset-bilimi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (248, 118, 'Международные отношения', 'Халықаралық қатынастар', 'International Relations', 'Uluslararası İlişkiler', 'uluslararasi-iliskiler', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (249, 118, 'Государственное и местное управление', 'Мемлекеттік және жергілікті басқару', 'State and local government ', 'Kamu Yönetimi', 'kamu-yonetimi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (250, 118, 'Управление человеческими ресурсами  ', 'Адам ресурстарын басқару', 'Human resource management', 'Insan kaynakları yönetimi', 'insan-kaynaklari-yonetimi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (251, 119, 'Экономика', 'Экономика', 'Economics', 'Ekonomi', 'ekonomi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (252, 119, 'Учет и аудит', 'Есеп және аудит', 'Accounting and Audit', 'Muhasebe ve Denetim', 'muhasebe-ve-denetim', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (253, 119, 'Финансы ', 'Қаржы ', 'Finance', 'Finans', 'finans', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (254, 120, 'Менеджмент', 'Менеджмент', 'Management', 'İşletme', 'isletme', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (255, 120, 'Менеджмент в сфере здравоохранения 1', 'Денсаулық сақтау саласындағы менеджмент 1ж', '7M04160 Health Management 1', 'Sağlık İşletmeciliği', 'saglik-isletmeciligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (256, 120, 'Менеджмент в сфере образования 1', 'Білім беру саласындағы менеджмент 1ж', '7M04150 Education Management 1', 'Eğitim Yönetimi', 'egitim-yonetimi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (257, 121, 'Право', 'Құқық', 'Law', 'Hukuk', 'hukuk', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (258, 122, 'Экономика', 'Экономика', 'Economics', 'Ekonomi', 'ekonomi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (259, 122, 'Финансы', 'Қаржы', 'Finance', 'Finans', 'finans', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (260, 123, 'Менеджмент', 'Менеджмент', 'Management', 'İşletme', 'isletme', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (261, 124, 'Государственное и местное управление', 'Мемлекеттік және жергілікті басқару ', 'State and local government ', 'Kamu ve Yerel Yönetimi', 'kamu-ve-yerel-yonetimi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (262, 125, 'Право', 'Құқық', 'Law', 'Hukuk', 'hukuk', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (263, 130, 'Экология', 'Экология', 'Ecology', 'Ekoloji', 'ekoloji', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (264, 130, 'Химия', 'Химия', 'Chemistry', 'Kimya', 'kimya', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (265, 131, 'Физика', 'Физика', 'Physics', 'Fizik', 'fizik', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (266, 132, 'Математика', 'Математика', 'Mathematics', 'Matematik', 'matematik', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (267, 132, 'Математическое и компьютерное моделирование', 'Математикалық және компьютерлік модельдеу', 'Mathematical and Computer Modeling', 'Matematiksel ve Bilgisayarda Modelleme', 'matematiksel-ve-bilgisayarda-modelleme', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (268, 133, 'Математика', 'Математика', 'Mathematics', 'Matematik Öğretmenliği', 'matematik-ogretmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (269, 133, 'Математическое и компьютерное моделирование', 'Математикалық және компьютерлік модельдеу', 'Mathematical and computer modeling', 'Matematiksel ve Bilgisayarda Modelleme', 'matematiksel-ve-bilgisayarda-modelleme', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (270, 134, 'Физика', 'Физика', 'Physics', 'Fizik Öğretmenliği', 'fizik-ogretmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (271, 135, 'Педагогика и психология', 'Педагогика және психология', 'Рedagogy and Psychology', 'Pedagoji ve Psikoloji', 'pedagoji-ve-psikoloji', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (272, 136, 'История', 'Тарих', 'History', 'Tarih Öğretmenliği', 'tarih-ogretmenligi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (273, 143, 'Неврология взрослая, детская', 'Ересектердің, балалардың неврологиясы', 'Neurology adults, children ', 'Pediatrik Nöroloji , Çocuk Nörolojisi', 'pediatrik-noroloji-cocuk-norolojisi', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (274, 143, 'Физическая медицина и реабилитация взрослая, детская', 'Ересектердің, балалардың физикалық медицина және реабилитациясы', 'Physical medicine and rehabilitation adults, children', 'Yetişkinlerde ve çocuklarda fiziksel tıp ve rehabilitasyon', 'yetiskinlerde-ve-cocuklarda-fiziksel-tip-ve-rehabilitasyon', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (275, 143, 'Психиатрия взрослая, детская', 'Ересектер мен балалар психиатриясы', 'Psychiatry  adults, children ', 'Psikiyatri', 'psikiyatri', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (276, 144, 'Педиатрия', 'Педиатрия', 'Pediatrics', 'Pediatri', 'pediatri', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (277, 144, 'Неонатология', 'Неонатология', 'Neonatology', 'Neonatoloji', 'neonatoloji', NULL, NULL);
INSERT INTO `tb_birim_agaci` VALUES (278, 145, 'Терапевтическая стоматология', 'Терапиялық стоматология', 'Therapeutic dentistry', 'Terapötik diş hekimliği', 'terapotik-dis-hekimligi', NULL, NULL);

-- ----------------------------
-- Table structure for tb_birim_agaci_copy1
-- ----------------------------
DROP TABLE IF EXISTS `tb_birim_agaci_copy1`;
CREATE TABLE `tb_birim_agaci_copy1`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ust_id` int NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `kisa_ad` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL,
  `kategori` tinyint NULL DEFAULT NULL,
  `grup` tinyint NULL DEFAULT NULL,
  `adi_kz` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `adi_en` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `adi_ru` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 53 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_birim_agaci_copy1
-- ----------------------------
INSERT INTO `tb_birim_agaci_copy1` VALUES (1, 0, 'Akademik Birimler', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (2, 0, 'İdari Birimler', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (3, 1, 'Fakülteler', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (4, 1, 'Enstitüler', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (5, 1, 'Merkezler', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (7, 1, 'Meslek Yüksekokulları', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (8, 3, 'Hazırlık Okulu', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (9, 3, 'Mühendislik Fakültesi', 'muhendislik-fakultesi', 1, 0, 'deneme', 'Faculty of Engineering', 'Rusça Mühendislikkk');
INSERT INTO `tb_birim_agaci_copy1` VALUES (10, 3, 'Fen Bilimleri Fakültesi', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (11, 3, 'Filoloji Fakültesi', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (12, 3, 'İnsan ve Toplum Bilimleri Fakültesi', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (13, 3, 'İlahiyat Fakültesi', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (14, 3, 'Spor ve Sanat Fakültesi', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (15, 3, 'Sosyal Bilimler Fakültesi', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (16, 3, 'Diş Hekimliği Fakültesi', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (17, 3, 'Tıp Fakültesi', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (18, 3, 'Lisansüstü Tıp Eğitimi Fakültesi (Çimkent)', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (19, 4, 'Türkoloji Araştırma Enstitüsü', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (20, 4, 'Ekoloji Araştırma Enstitüsü', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (21, 4, 'Avrasya Araştırma Enstitüsü', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (22, 4, 'Arkeoloji Araştırma Enstitüsü', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (23, 4, 'Tıbbi Araştırma Enstitüsü', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (24, 4, 'Fen Bilimleri Araştırma Enstitüsü', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (25, 4, 'Yesevi Araştırma Enstitüsü', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (27, 8, 'Lisans Programları', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (29, 27, 'Türk Dili Bölümü', NULL, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (30, 27, 'Kazak ve Rus Dili Bölümü	', NULL, 0, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (31, 27, 'İngiliz Dili Bölümü', NULL, 0, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (32, 9, 'Lisans Programları', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (33, 9, 'Yüksek Lisans Programları', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (34, 9, 'Doktora Programları', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (37, 32, 'Bilgisayar Mühendisliği', NULL, 0, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (38, 7, 'Ahmet Yesevi Meslek Yüksekokulu', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (39, 2, 'Bilgi İşlem Daire Baişkanlığı', NULL, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (40, 2, 'Öğreci İşleri Daire Başkanlığı', NULL, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (41, 2, 'Personel İşleri Daire Başkanlığı', NULL, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (42, 2, 'Satınalma Müdürlüğü', NULL, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_birim_agaci_copy1` VALUES (43, 8, 'Yüksek Lisans Programları', NULL, 1, 1, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for tb_birim_sayfa_icerikleri
-- ----------------------------
DROP TABLE IF EXISTS `tb_birim_sayfa_icerikleri`;
CREATE TABLE `tb_birim_sayfa_icerikleri`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `birim_id` int NULL DEFAULT NULL,
  `sayfa_id` int UNSIGNED NULL DEFAULT NULL,
  `baslik` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `icerik` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `baslik_kz` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `baslik_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `baslik_ru` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `icerik_kz` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `icerik_en` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `icerik_ru` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `aktif` tinyint NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_birim_sayfa_icerikleri
-- ----------------------------
INSERT INTO `tb_birim_sayfa_icerikleri` VALUES (1, 9, 8, 'Hakkımızda', '<figure class=\"image\"><img src=\"/hr/ckeditor_files/files/muhendislik.jpg\" alt=\"\"></figure><p><span style=\"background-color:rgb(255,255,255);color:rgb(24,28,50);font-family:Poppins, Helvetica, sans-serif;font-size:14.95px;\"><span style=\"-webkit-text-stroke-width:0px;display:inline !important;float:none;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Mütevelli Heyetimizin kararıyla Ekim-2004 tarihinde “Bilişim Teknolojileri ve Mühendislik Fakültesi” olarak kurulan Fakültemizin ismi Üniversitemiz Senatosunun kararıyla 2014-2015 Eğitim-Öğretim döneminden başlayarak “Mühendislik Fakültesi” olarak değiştirildi. Fakültemiz, Lisans ve lisansüstü seviyede, çağdaş, kapsamlı ve güçlü mühendislik eğitimi vermek, nitelikli, özgün ve yenilikçi araştırmalar yaparak bilimsel ve teknolojik gelişmeye katkı sağlamak, sanayi ve paydaş kurum/kuruluşlar ile yakın işbirliği kurarak ulusal/uluslararası kalkınmaya katkı sağlamak misyonu ile eğitim hayatına devam etmektedir.</span></span></p>', 'sdfsdf', 'About Us', 'sdfsdf', 'fewrwerdfgdfg', '<p>About Us</p>', 'werwertert4356456', NULL);

-- ----------------------------
-- Table structure for tb_birim_sayfalari
-- ----------------------------
DROP TABLE IF EXISTS `tb_birim_sayfalari`;
CREATE TABLE `tb_birim_sayfalari`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `birim_id` int UNSIGNED NULL DEFAULT NULL,
  `ust_id` int NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `kisa_ad` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL,
  `kategori` tinyint NULL DEFAULT NULL,
  `link` tinyint NULL DEFAULT NULL,
  `link_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `harici` tinyint NULL DEFAULT NULL,
  `aktif` tinyint NULL DEFAULT NULL,
  `adi_kz` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `adi_en` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `adi_ru` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_birim_sayfalari
-- ----------------------------
INSERT INTO `tb_birim_sayfalari` VALUES (7, 11, 0, 'Fakülte', 'fakulte', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (8, 11, 7, 'Hakkımızda', 'hakkimizda', 0, 0, '', 0, 1, 'a', 'b', 'c');
INSERT INTO `tb_birim_sayfalari` VALUES (9, 11, 7, 'Tarihçe', 'tarihce', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (12, 11, 7, 'Dekanın Mesajı', 'dekaninmesaji', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (16, 11, 7, 'Misyon ve Vizyon', 'misyon-ve-vizyon', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (17, 11, 7, 'Değerlerimiz', 'degerlerimiz', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (18, 11, 7, 'Öğrenme Çıktıları', 'ogrenme-ciktilari', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (19, 11, 7, 'Dökümanlar ve Formlar', 'dokumanlar-ve-formlar', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (20, 11, 7, 'Tanıtım', 'tanitim', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (21, 11, 0, 'Yönetim', 'yonetim', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (22, 11, 21, 'Fakülte Yönetimi', 'fakulte-yonetimi', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (23, 11, 21, 'Fakülte Kurulları', 'fakulte-kurullari', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (24, 11, 21, 'Organizasyon Şeması', 'organizasyon-semasi', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (25, 11, 21, 'Öğrenci Temsilcileri', 'ogrenci-temsilcileri', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (26, 11, 0, 'Bölümler', 'bolumler', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (27, 11, 0, 'Öğrenci', 'ogrenci', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (28, 11, 27, 'Eğitim ve Öğretim', 'egitim-ve-ogretim', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (29, 11, 27, 'Önemli Bilgiler', 'onemli-bilgiler', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (30, 11, 27, 'Belge Sağlama', 'belge-saglama', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (31, 11, 27, 'Kariyer Gelişimi', 'kariyer-gelisimi', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (32, 11, 27, 'Staj', 'staj', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (33, 11, 27, 'Öğrenci İşleri Daire Başkanlığı', 'ogrenci-isleri-daire-baskanligi', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (34, 11, 27, 'Aday Öğrenci', 'aday-ogrenci', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (35, 11, 0, 'İletişim', 'iletisim', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari` VALUES (39, 11, 0, NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for tb_birim_sayfalari_2
-- ----------------------------
DROP TABLE IF EXISTS `tb_birim_sayfalari_2`;
CREATE TABLE `tb_birim_sayfalari_2`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ust_id` int NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `kisa_ad` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL,
  `kategori` tinyint NULL DEFAULT NULL,
  `grup` tinyint NULL DEFAULT NULL,
  `adi_kz` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `adi_en` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `adi_ru` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 53 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_birim_sayfalari_2
-- ----------------------------
INSERT INTO `tb_birim_sayfalari_2` VALUES (1, 0, 'Akademik Birimler', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (2, 0, 'İdari Birimler', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (3, 1, 'Fakülteler', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (4, 1, 'Enstitüler', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (5, 1, 'Merkezler', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (7, 1, 'Meslek Yüksekokulları', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (8, 3, 'Hazırlık Okulu', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (9, 3, 'Mühendislik Fakültesi', 'muhendislik-fakultesi', 1, 0, 'deneme', 'Faculty of Engineering', 'Rusça Mühendislikkk');
INSERT INTO `tb_birim_sayfalari_2` VALUES (10, 3, 'Fen Bilimleri Fakültesi', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (11, 3, 'Filoloji Fakültesi', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (12, 3, 'İnsan ve Toplum Bilimleri Fakültesi', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (13, 3, 'İlahiyat Fakültesi', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (14, 3, 'Spor ve Sanat Fakültesi', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (15, 3, 'Sosyal Bilimler Fakültesi', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (16, 3, 'Diş Hekimliği Fakültesi', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (17, 3, 'Tıp Fakültesi', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (18, 3, 'Lisansüstü Tıp Eğitimi Fakültesi (Çimkent)', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (19, 4, 'Türkoloji Araştırma Enstitüsü', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (20, 4, 'Ekoloji Araştırma Enstitüsü', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (21, 4, 'Avrasya Araştırma Enstitüsü', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (22, 4, 'Arkeoloji Araştırma Enstitüsü', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (23, 4, 'Tıbbi Araştırma Enstitüsü', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (24, 4, 'Fen Bilimleri Araştırma Enstitüsü', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (25, 4, 'Yesevi Araştırma Enstitüsü', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (27, 8, 'Lisans Programları', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (29, 27, 'Türk Dili Bölümü', NULL, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (30, 27, 'Kazak ve Rus Dili Bölümü	', NULL, 0, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (31, 27, 'İngiliz Dili Bölümü', NULL, 0, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (32, 9, 'Lisans Programları', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (33, 9, 'Yüksek Lisans Programları', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (34, 9, 'Doktora Programları', NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (37, 32, 'Bilgisayar Mühendisliği', NULL, 0, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (38, 7, 'Ahmet Yesevi Meslek Yüksekokulu', NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (39, 2, 'Bilgi İşlem Daire Baişkanlığı', NULL, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (40, 2, 'Öğreci İşleri Daire Başkanlığı', NULL, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (41, 2, 'Personel İşleri Daire Başkanlığı', NULL, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (42, 2, 'Satınalma Müdürlüğü', NULL, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_birim_sayfalari_2` VALUES (43, 8, 'Yüksek Lisans Programları', NULL, 1, 1, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for tb_bolumler
-- ----------------------------
DROP TABLE IF EXISTS `tb_bolumler`;
CREATE TABLE `tb_bolumler`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `universite_id` int NULL DEFAULT NULL,
  `fakulte_id` int NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT '',
  `aktif` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_bolumler
-- ----------------------------
INSERT INTO `tb_bolumler` VALUES (1, 1, 1, 'Cerrahi Tıp Bilimleri Bölümü', 1);
INSERT INTO `tb_bolumler` VALUES (2, 1, 1, 'Dahili Tıp Bilimleri Bölümü', 1);
INSERT INTO `tb_bolumler` VALUES (9, 1, 1, 'Temel T?p', 0);

-- ----------------------------
-- Table structure for tb_ceviriler
-- ----------------------------
DROP TABLE IF EXISTS `tb_ceviriler`;
CREATE TABLE `tb_ceviriler`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `turu` tinyint NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `adi_kz` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `adi_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `adi_ru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 249 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_ceviriler
-- ----------------------------
INSERT INTO `tb_ceviriler` VALUES (1, 1, 'Bizi takip et', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (2, 1, 'Öğrenci', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (3, 1, 'Daha Fazla', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (4, 1, 'Duyurular', 'Хабарландырулар', 'Announcements', '');
INSERT INTO `tb_ceviriler` VALUES (5, 1, 'Son Duyurular', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (6, 1, 'Tüm Duyurular', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (7, 1, 'Bölüm', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (8, 1, 'Eğitmen', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (9, 1, 'Akademik Yayın', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (10, 1, 'Güncel Etkinlikler', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (11, 1, 'Etkinlikler', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (12, 1, 'Etkinliği Gör', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (13, 1, 'Bizi ara', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (14, 1, 'Email', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (15, 1, 'Adres', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (16, 1, 'Türk dünyasının parlayan yıldızı.', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (17, 1, 'Hızlı Bağlantılar', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (18, 1, 'Lokasyon', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (19, 1, 'Gizlilik Politikası', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (20, 1, 'Paylaş', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (21, 1, 'Anasayfa', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (22, 1, 'Etkinlikler', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (23, 1, 'Yer', '', '', '');
INSERT INTO `tb_ceviriler` VALUES (114, 2, 'AYU İnsan Kaynakları', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (115, 2, 'MENÜ', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (116, 2, 'Anasayfa', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (117, 2, 'Panel Çevirileri', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (118, 2, 'Web Çevirileri', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (119, 2, 'Birim Ağacı', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (120, 2, 'Birim Sayfaları', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (121, 2, 'Duyurular', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (122, 2, 'Manşetler', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (123, 2, 'Etkinlikler', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (124, 2, 'Genel Ayarlar', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (125, 2, 'Personeller', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (126, 2, 'Öğrenim Bilgileri', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (127, 2, 'Sabit Tanımlar', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (128, 2, 'Görev Kategorileri', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (129, 2, 'Sistem Kullanıcıları', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (130, 2, 'Sistem İşlemleri', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (131, 2, 'Yetkiler', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (132, 2, 'Modul Yetkileri', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (133, 2, 'Birimler', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (134, 2, 'Birim Ekle / Düzenle', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (135, 2, 'Dil', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (136, 2, 'Üst Birim', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (137, 2, 'Birim Adı', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (138, 2, 'Alt birimleri olacak.', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (139, 2, 'asdasdasdasd', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (140, 2, 'Sadece gruplama için kullanılacak.', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (141, 2, 'Eğer bu bir birim değil, sadece gruplama yapmak için kullanılacaksa işaretleyiniz.', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (142, 2, 'Dikkat!', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (143, 2, 'Bu Kaydı silmeniz durumunda kategori Altında bulunan diğer kategoriler silinecektir.', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (144, 2, 'Bu kaydı Silmek istediğinize emin misiniz?', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (145, 2, 'İptal', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (146, 2, 'Evet', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (147, 2, 'Yeni Birim Ekle', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (148, 2, 'Bu birimin alt birimleri olacaksa işaretlenmelidir.', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (149, 2, 'Kaydet', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (150, 2, 'Birim Düzenle', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (151, 2, 'Güncelle', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (152, 2, 'Hayır', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (153, 2, 'Duyuru Ekle', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (154, 2, 'Lütfen Birim Seçiniz', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (155, 2, 'Lütfen Dikkat', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (156, 2, 'Manşet Ekle', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (157, 2, 'Başlık', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (158, 2, 'Düzenle', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (159, 2, 'Sil', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (160, 2, 'Foto', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (161, 2, 'Eklediğiniz görsel 555 x 320 boyutlarında olmalıdır.', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (162, 2, 'Tarih', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (163, 2, 'İçerik', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (164, 2, 'Etkinlik Ekle', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (165, 2, 'Genel Ayarlar Düzenle', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (166, 2, 'Logo', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (167, 2, 'Footer Logo', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (168, 2, 'Footer Sağ Alt Logo', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (169, 2, 'Footer Sağ Alt Logo Link', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (170, 2, 'Map', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (171, 2, 'Adres', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (172, 2, 'Tel', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (173, 2, 'Email', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (174, 2, 'Facebook', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (175, 2, 'Twitter', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (176, 2, 'Instagram', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (177, 2, 'Linkedin', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (178, 2, 'Youtube', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (179, 2, 'Slogan', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (180, 2, 'Anasayfa Başlık', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (181, 2, 'Anasayfa İçerik', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (182, 2, 'Öğrenci Sayısı', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (183, 2, 'Bölüm Sayısı', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (184, 2, 'Eğitmen Sayısı', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (185, 2, 'Yayın Sayısı', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (186, 2, 'Buton 1', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (187, 2, 'Buton 1 Url', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (188, 2, 'Buton 2', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (189, 2, 'Buton 2 Url', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (190, 2, 'Yeni Sayfa Ekle', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (191, 2, 'Üst Sayfa', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (192, 2, 'Adı', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (193, 2, 'Kategori Mi?', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (194, 2, 'Sayfa Düzenle', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (195, 2, 'Sayfalar', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (196, 2, 'Sayfa Ayarları', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (197, 2, 'Aktif', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (198, 2, 'İşaretlenmezse Sayfa Yayınlanmaz', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (199, 2, 'Harici Sayfa', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (200, 2, 'Menüde görünmeyecek sayfalar için işaretlenmelidir.', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (201, 2, 'Link', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (202, 2, 'Bu alana Link eklenirse menü bu linke yönlendirilecektir.', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (203, 2, 'Sayfa İçeriği', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (204, 2, 'In No', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (205, 2, 'Adı Soyadı', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (206, 2, 'Profil', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (207, 2, 'Personel Ekle', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (208, 2, 'Fotoğraf değiştirmek için fotoğrafa tıklayınız', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (209, 2, 'Birim', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (210, 2, 'Personel Niteliği', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (211, 2, 'Seçiniz', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (212, 2, 'Personel Türü', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (213, 2, 'Kişisel Bilgiler', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (214, 2, 'Uyruk', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (215, 2, 'In Numarası', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (216, 2, 'Vatandaşlık No', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (217, 2, 'Pasaport No', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (218, 2, 'Ünvan', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (219, 2, 'Soyadı', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (220, 2, 'Cinsiyet', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (221, 2, 'Kadın', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (222, 2, 'Erkek', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (223, 2, 'Doğum Tarihi', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (224, 2, 'Medeni Durumu', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (225, 2, 'Bekar', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (226, 2, 'Evli', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (227, 2, 'Kan Grubu', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (228, 2, 'Araç Plaka', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (229, 2, 'Engel Bilgileri', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (230, 2, 'Engel Durumu', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (231, 2, 'Yok', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (232, 2, 'Var', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (233, 2, 'Engel Türü', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (234, 2, 'Eğitim Bilgileri', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (235, 2, 'Eğitim Düzeyi', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (236, 2, 'İletişim Bilgileri', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (237, 2, 'GSM 1', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (238, 2, 'GSM 2', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (239, 2, 'İş Telefonu', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (240, 2, 'Ev Adresi', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (241, 2, 'İş Adresi', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (242, 2, 'Sözleşme Bilgileri', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (243, 2, 'İşe Başlama Tarihi', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (244, 2, 'Sözleşme Başlama Tarihi', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (245, 2, 'Sözleşme Bitiş Tarihi', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (246, 2, 'Şifre Değiştir', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (247, 2, 'Şifre', NULL, NULL, NULL);
INSERT INTO `tb_ceviriler` VALUES (248, 1, 'Fakülte Yönetimi', '', '', '');

-- ----------------------------
-- Table structure for tb_ders_kategorileri
-- ----------------------------
DROP TABLE IF EXISTS `tb_ders_kategorileri`;
CREATE TABLE `tb_ders_kategorileri`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `universite_id` int NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT '',
  `aktif` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_ders_kategorileri
-- ----------------------------
INSERT INTO `tb_ders_kategorileri` VALUES (1, 1, 'Zorunlu Ders', 1);
INSERT INTO `tb_ders_kategorileri` VALUES (2, 1, 'Seçmeli Ders', 1);
INSERT INTO `tb_ders_kategorileri` VALUES (3, 1, 'Alttan Ders', 0);

-- ----------------------------
-- Table structure for tb_ders_yili_donemleri
-- ----------------------------
DROP TABLE IF EXISTS `tb_ders_yili_donemleri`;
CREATE TABLE `tb_ders_yili_donemleri`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `program_id` int NULL DEFAULT NULL,
  `ders_yili_id` int NULL DEFAULT NULL,
  `donem_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_ders_yili_donemleri
-- ----------------------------
INSERT INTO `tb_ders_yili_donemleri` VALUES (1, 1, 1, 1);
INSERT INTO `tb_ders_yili_donemleri` VALUES (2, 1, 1, 2);
INSERT INTO `tb_ders_yili_donemleri` VALUES (3, 1, 1, 3);
INSERT INTO `tb_ders_yili_donemleri` VALUES (4, 1, 1, 4);
INSERT INTO `tb_ders_yili_donemleri` VALUES (5, 1, 1, 5);
INSERT INTO `tb_ders_yili_donemleri` VALUES (11, 1, 1, 6);
INSERT INTO `tb_ders_yili_donemleri` VALUES (12, 1, 3, 1);
INSERT INTO `tb_ders_yili_donemleri` VALUES (13, 1, 3, 2);

-- ----------------------------
-- Table structure for tb_ders_yillari
-- ----------------------------
DROP TABLE IF EXISTS `tb_ders_yillari`;
CREATE TABLE `tb_ders_yillari`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `universite_id` int NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT '',
  `baslangic_tarihi` date NULL DEFAULT NULL,
  `bitis_tarihi` date NULL DEFAULT NULL,
  `ilk_goruntulenecek` tinyint NULL DEFAULT NULL,
  `aktif` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_ders_yillari
-- ----------------------------
INSERT INTO `tb_ders_yillari` VALUES (1, 1, '2022 - 2023 Ders Yılı', '2022-09-19', '2023-06-19', 1, 1);
INSERT INTO `tb_ders_yillari` VALUES (3, 1, '2023 - 2024 Ders Yılı', '2023-09-17', '2024-06-20', 0, 1);

-- ----------------------------
-- Table structure for tb_dersler
-- ----------------------------
DROP TABLE IF EXISTS `tb_dersler`;
CREATE TABLE `tb_dersler`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `program_id` int NULL DEFAULT NULL,
  `anabilim_dali_id` int NULL DEFAULT NULL,
  `ders_kategori_id` int NULL DEFAULT NULL,
  `ders_kodu` varchar(50) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `aktif` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 70 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_dersler
-- ----------------------------
INSERT INTO `tb_dersler` VALUES (1, 1, 13, 1, 'TFANT101', 'Anatomi / Anatomy', 1);
INSERT INTO `tb_dersler` VALUES (2, 1, 14, 1, 'TFBFZ102', 'Biyofizik / Biophysics', 1);
INSERT INTO `tb_dersler` VALUES (3, 1, 15, 1, 'TFBIS103', 'Biyoistatistik / Biostatistics', 1);
INSERT INTO `tb_dersler` VALUES (4, 1, 16, 1, 'TFBIK104', 'Tıbbi Biyokimya / Biochemistry', 1);
INSERT INTO `tb_dersler` VALUES (5, 1, 44, 1, 'TFDAB105', 'Davranış Bilimleri / Behavioral Sciences', 1);
INSERT INTO `tb_dersler` VALUES (6, 1, 17, 1, 'TFFZY106', 'Fizyoloji / Physiology', 1);
INSERT INTO `tb_dersler` VALUES (7, 1, 33, 1, 'TFHSA107', 'Halk Sağlığı / Public Health', 1);
INSERT INTO `tb_dersler` VALUES (8, 1, 18, 1, 'TFHIE108', 'Histoloji-Embriyoloji / Histology and Embryology', 1);
INSERT INTO `tb_dersler` VALUES (9, 1, 19, 1, 'TFMIB109', 'Tıbbi Mikrobiyoloji / Microbiology', 1);
INSERT INTO `tb_dersler` VALUES (10, 1, 21, 1, 'TFTIB110', 'Tıbbi Biyoloji / Medical Biology', 1);
INSERT INTO `tb_dersler` VALUES (11, 1, 43, 1, 'TFTIG111', 'Tıbbi Genetik / Medical Genetics', 1);
INSERT INTO `tb_dersler` VALUES (12, 1, 44, 1, 'TFTIT111', 'Tıbbi Terminoloji / Medical Terminology', 1);
INSERT INTO `tb_dersler` VALUES (13, 1, 23, 1, 'TFTE112', 'Tıp Eğitimi ve Bilişimi / Medical Education', 1);
INSERT INTO `tb_dersler` VALUES (14, 1, 24, 1, 'TFTTE113', 'Tıp Tarihi ve Etik / Medical History and Ethics', 1);
INSERT INTO `tb_dersler` VALUES (15, 1, 44, 1, 'TFİLE114', 'İletişim Becerisi / CommunicationSkills', 1);
INSERT INTO `tb_dersler` VALUES (16, 1, 13, 1, 'TFANT201', 'Anatomi / Anatomy', 1);
INSERT INTO `tb_dersler` VALUES (17, 1, 14, 1, 'TFBFZ202', 'Biyofizik / Biophysics', 1);
INSERT INTO `tb_dersler` VALUES (18, 1, 16, 1, 'TFBIK204', 'Biyokimya / Biochemistry', 1);
INSERT INTO `tb_dersler` VALUES (19, 1, 30, 1, 'TFFAR205', 'Farmakoloji / Pharmacology', 1);
INSERT INTO `tb_dersler` VALUES (20, 1, 17, 1, 'TFFIZ206', 'Fizyoloji / Physiology', 1);
INSERT INTO `tb_dersler` VALUES (21, 1, 18, 1, 'TFHIE207', 'Histoloji-Embriyoloji / Histology and Embryology', 1);
INSERT INTO `tb_dersler` VALUES (23, 1, 19, 1, 'TFMIK208', 'Mikrobiyoloji / Microbiology', 1);
INSERT INTO `tb_dersler` VALUES (24, 1, 22, 1, 'TFPRZ209', 'Parazitoloji / Parasitology', 1);
INSERT INTO `tb_dersler` VALUES (25, 1, 20, 1, 'TFPAT210', 'Patoloji / Pathology', 1);
INSERT INTO `tb_dersler` VALUES (26, 1, 21, 1, 'TFTIB211', 'Tıbbi Biyoloji / Medical Biology', 1);
INSERT INTO `tb_dersler` VALUES (27, 1, 23, 1, 'TFTEG213', 'Tıp Eğitimi ve Bilişimi / Medical Education', 1);
INSERT INTO `tb_dersler` VALUES (28, 1, 24, 1, 'TFTTE214', 'Tıp Tarihi ve Etik / Medical History and Ethics', 1);
INSERT INTO `tb_dersler` VALUES (29, 1, 43, 1, 'TFTIG2015', 'Tıbbi Genetik / Medical Genetics', 1);
INSERT INTO `tb_dersler` VALUES (30, 1, 25, 1, 'TFACT301', 'Acil Tıp / Emergency Medicine', 1);
INSERT INTO `tb_dersler` VALUES (31, 1, 26, 1, 'TFADT302', 'Adli Tıp / Forensic Medicine', 1);
INSERT INTO `tb_dersler` VALUES (32, 1, 27, 1, 'TFAIH303', 'Aile Hekimliği / Family Medicine', 1);
INSERT INTO `tb_dersler` VALUES (33, 1, 37, 1, 'TFBSC305', 'Beyin Cerrahisi / Neurosurgery', 1);
INSERT INTO `tb_dersler` VALUES (34, 1, 16, 1, 'TFBIK307', 'Tıbbi Biyokimya / Clinical Biochemistry', 1);
INSERT INTO `tb_dersler` VALUES (35, 1, 14, 1, 'TFBIFZ307', 'Biyofizik/Biophisic', 1);
INSERT INTO `tb_dersler` VALUES (36, 1, 2, 1, 'TFCCE308', 'Çocuk Cerrahisi / Pediatric Surgery', 1);
INSERT INTO `tb_dersler` VALUES (37, 1, 39, 1, 'TFCPS309', 'Çocuk Psikiyatrisi / Child and Adolescent Psychiatry', 1);
INSERT INTO `tb_dersler` VALUES (38, 1, 28, 1, 'TFPED310', 'Çocuk Sağlığı ve Hastalıkları / Pediatrics', 1);
INSERT INTO `tb_dersler` VALUES (39, 1, 29, 1, 'TFDER311', 'Dermatoloji / Dermatology', 1);
INSERT INTO `tb_dersler` VALUES (40, 1, 36, 1, 'TFENF312', 'Enfeksiyon Hastalıkları / Infectious Diseases', 1);
INSERT INTO `tb_dersler` VALUES (41, 1, 30, 1, 'TFFAR313', 'Farmakoloji / Pharmacology', 1);
INSERT INTO `tb_dersler` VALUES (42, 1, 31, 1, 'TFFTR314', 'Fizik Tedavi ve Rehabilitasyon / Physical Medicine and Rehabilitation', 1);
INSERT INTO `tb_dersler` VALUES (43, 1, 3, 1, 'TFGEC315', 'Genel Cerrahi / General Surgery', 1);
INSERT INTO `tb_dersler` VALUES (44, 1, 4, 1, 'TFGOC316', 'Göğüs Cerrahisi / Chest Surgery', 1);
INSERT INTO `tb_dersler` VALUES (45, 1, 32, 1, 'TFGOH317', 'Göğüs Hastalıkları / Chest Diseases', 1);
INSERT INTO `tb_dersler` VALUES (46, 1, 5, 1, 'TFGOZ318', 'Göz Hastalıkları / Ophthalmology', 1);
INSERT INTO `tb_dersler` VALUES (47, 1, 33, 1, 'TFHSA319', 'Halk Sağlığı / Public Health', 1);
INSERT INTO `tb_dersler` VALUES (48, 1, 34, 1, 'TFDAH320', 'İç Hastalıkları / Internal Medicine', 1);
INSERT INTO `tb_dersler` VALUES (49, 1, 6, 1, 'TFKHD321', 'Kadın Hastalıkları ve Doğum / Obstetrics and Gynecology', 1);
INSERT INTO `tb_dersler` VALUES (50, 1, 35, 1, 'TFKAR322', 'Kardiyoloji / Cardiology', 1);
INSERT INTO `tb_dersler` VALUES (51, 1, 7, 1, 'TFKDC323', 'Kalp Damar Cerrahisi / Cardiovascular Surgery', 1);
INSERT INTO `tb_dersler` VALUES (52, 1, 8, 1, 'TFKBB324', 'Kulak Burun Boğaz / Otorhinolaryngology', 1);
INSERT INTO `tb_dersler` VALUES (53, 1, 37, 1, 'TFNOR325', 'Nöroloji / Neurology', 1);
INSERT INTO `tb_dersler` VALUES (54, 1, 10, 1, 'TFORT338', 'Ortopedi ve Travmatoloji / Orthopedic and Traumatology', 1);
INSERT INTO `tb_dersler` VALUES (55, 1, 20, 1, 'TFPAT337', 'Patoloji / Pathology', 1);
INSERT INTO `tb_dersler` VALUES (56, 1, 11, 1, 'TFPRC328', 'Plastik Cerrahi / PlasticReconstructive and Aesthetic Surgery', 1);
INSERT INTO `tb_dersler` VALUES (57, 1, 39, 1, 'TFPSK329', 'Psikiyatri / Psychiatry', 1);
INSERT INTO `tb_dersler` VALUES (58, 1, 42, 1, 'TFSHK330', 'Spor Hekimliği / Sports Medicine', 1);
INSERT INTO `tb_dersler` VALUES (59, 1, 22, 1, 'TFPRZ332', 'Parazitoloji / Parasitology', 1);
INSERT INTO `tb_dersler` VALUES (60, 1, 19, 1, 'TFMIC333', 'Tıbbi Mikrobiyoloji / Medical Microbiology', 1);
INSERT INTO `tb_dersler` VALUES (61, 1, 23, 1, 'TFTEG336', 'Tıp Eğitimi ve Bilişimi / Medical Education', 1);
INSERT INTO `tb_dersler` VALUES (62, 1, 24, 1, 'TFTTE333', 'Tıp Tarihi ve Etik / Medical History and Ethics', 1);
INSERT INTO `tb_dersler` VALUES (63, 1, 12, 1, 'TFURO334', 'Üroloji / Urology', 1);
INSERT INTO `tb_dersler` VALUES (64, 1, 44, 1, 'TFİSG336', 'İş Sağlığı ve Güvenliği', 1);
INSERT INTO `tb_dersler` VALUES (65, 1, 43, 1, 'TFTIG336', 'Tıbbi Genetik / Medical Genetic', 1);
INSERT INTO `tb_dersler` VALUES (66, 1, 38, 1, 'TFNUT336', 'Nükleer Tıp / Nuclear Medicine', 1);

-- ----------------------------
-- Table structure for tb_diller
-- ----------------------------
DROP TABLE IF EXISTS `tb_diller`;
CREATE TABLE `tb_diller`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `adi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kisa_ad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_diller
-- ----------------------------
INSERT INTO `tb_diller` VALUES (1, 'Türkçe', 'tr', NULL);
INSERT INTO `tb_diller` VALUES (2, 'қазақ', 'kz', NULL);
INSERT INTO `tb_diller` VALUES (3, 'English', 'en', NULL);
INSERT INTO `tb_diller` VALUES (4, 'Россия', 'ru', NULL);

-- ----------------------------
-- Table structure for tb_donem_dersleri
-- ----------------------------
DROP TABLE IF EXISTS `tb_donem_dersleri`;
CREATE TABLE `tb_donem_dersleri`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ders_yili_donem_id` int UNSIGNED NULL DEFAULT NULL,
  `ders_id` int NULL DEFAULT NULL,
  `teorik_ders_saati` int NULL DEFAULT NULL,
  `uygulama_ders_saati` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_donem_dersleri
-- ----------------------------
INSERT INTO `tb_donem_dersleri` VALUES (1, 1, 1, 72, 20);
INSERT INTO `tb_donem_dersleri` VALUES (2, 1, 2, 26, 0);
INSERT INTO `tb_donem_dersleri` VALUES (3, 1, 3, 47, 0);
INSERT INTO `tb_donem_dersleri` VALUES (4, 1, 4, 84, 10);
INSERT INTO `tb_donem_dersleri` VALUES (5, 1, 5, 11, 0);
INSERT INTO `tb_donem_dersleri` VALUES (6, 1, 6, 37, 1);
INSERT INTO `tb_donem_dersleri` VALUES (7, 1, 7, 12, 0);
INSERT INTO `tb_donem_dersleri` VALUES (8, 1, 8, 52, 17);
INSERT INTO `tb_donem_dersleri` VALUES (9, 1, 9, 9, 2);
INSERT INTO `tb_donem_dersleri` VALUES (10, 1, 10, 64, 10);
INSERT INTO `tb_donem_dersleri` VALUES (11, 1, 11, 7, 0);
INSERT INTO `tb_donem_dersleri` VALUES (13, 1, 13, 4, 0);
INSERT INTO `tb_donem_dersleri` VALUES (22, 1, 14, 16, 0);
INSERT INTO `tb_donem_dersleri` VALUES (24, 1, 15, 8, 0);

-- ----------------------------
-- Table structure for tb_donem_gorevlileri
-- ----------------------------
DROP TABLE IF EXISTS `tb_donem_gorevlileri`;
CREATE TABLE `tb_donem_gorevlileri`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ders_yili_donem_id` int NULL DEFAULT NULL,
  `gorev_kategori_id` int NULL DEFAULT NULL,
  `ogretim_elemani_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_donem_gorevlileri
-- ----------------------------
INSERT INTO `tb_donem_gorevlileri` VALUES (17, 1, 1, 1);
INSERT INTO `tb_donem_gorevlileri` VALUES (18, 1, 2, 3);

-- ----------------------------
-- Table structure for tb_donem_ogrencileri
-- ----------------------------
DROP TABLE IF EXISTS `tb_donem_ogrencileri`;
CREATE TABLE `tb_donem_ogrencileri`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ders_yili_donem_id` int NULL DEFAULT NULL,
  `program_id` int NULL DEFAULT NULL,
  `ogrenci_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 157 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_donem_ogrencileri
-- ----------------------------
INSERT INTO `tb_donem_ogrencileri` VALUES (7, 4, NULL, 1);
INSERT INTO `tb_donem_ogrencileri` VALUES (8, 4, NULL, 2);
INSERT INTO `tb_donem_ogrencileri` VALUES (9, 4, NULL, 3);
INSERT INTO `tb_donem_ogrencileri` VALUES (10, 4, NULL, 4);
INSERT INTO `tb_donem_ogrencileri` VALUES (11, 4, NULL, 5);
INSERT INTO `tb_donem_ogrencileri` VALUES (12, 4, NULL, 6);
INSERT INTO `tb_donem_ogrencileri` VALUES (13, 4, NULL, 7);
INSERT INTO `tb_donem_ogrencileri` VALUES (14, 4, NULL, 8);
INSERT INTO `tb_donem_ogrencileri` VALUES (15, 4, NULL, 9);
INSERT INTO `tb_donem_ogrencileri` VALUES (16, 4, NULL, 10);
INSERT INTO `tb_donem_ogrencileri` VALUES (17, 4, NULL, 11);
INSERT INTO `tb_donem_ogrencileri` VALUES (18, 4, NULL, 12);
INSERT INTO `tb_donem_ogrencileri` VALUES (19, 4, NULL, 13);
INSERT INTO `tb_donem_ogrencileri` VALUES (20, 4, NULL, 14);
INSERT INTO `tb_donem_ogrencileri` VALUES (21, 4, NULL, 15);
INSERT INTO `tb_donem_ogrencileri` VALUES (22, 4, NULL, 16);
INSERT INTO `tb_donem_ogrencileri` VALUES (23, 4, NULL, 17);
INSERT INTO `tb_donem_ogrencileri` VALUES (24, 4, NULL, 18);
INSERT INTO `tb_donem_ogrencileri` VALUES (25, 4, NULL, 19);
INSERT INTO `tb_donem_ogrencileri` VALUES (26, 4, NULL, 20);
INSERT INTO `tb_donem_ogrencileri` VALUES (27, 4, NULL, 21);
INSERT INTO `tb_donem_ogrencileri` VALUES (28, 4, NULL, 22);
INSERT INTO `tb_donem_ogrencileri` VALUES (29, 4, NULL, 23);
INSERT INTO `tb_donem_ogrencileri` VALUES (30, 4, NULL, 24);
INSERT INTO `tb_donem_ogrencileri` VALUES (31, 4, NULL, 25);
INSERT INTO `tb_donem_ogrencileri` VALUES (32, 4, NULL, 26);
INSERT INTO `tb_donem_ogrencileri` VALUES (33, 4, NULL, 27);
INSERT INTO `tb_donem_ogrencileri` VALUES (34, 4, NULL, 28);
INSERT INTO `tb_donem_ogrencileri` VALUES (35, 4, NULL, 29);
INSERT INTO `tb_donem_ogrencileri` VALUES (36, 4, NULL, 30);
INSERT INTO `tb_donem_ogrencileri` VALUES (37, 4, NULL, 31);
INSERT INTO `tb_donem_ogrencileri` VALUES (38, 4, NULL, 32);
INSERT INTO `tb_donem_ogrencileri` VALUES (39, 4, NULL, 33);
INSERT INTO `tb_donem_ogrencileri` VALUES (40, 4, NULL, 34);
INSERT INTO `tb_donem_ogrencileri` VALUES (41, 4, NULL, 35);
INSERT INTO `tb_donem_ogrencileri` VALUES (42, 4, NULL, 36);
INSERT INTO `tb_donem_ogrencileri` VALUES (43, 4, NULL, 37);
INSERT INTO `tb_donem_ogrencileri` VALUES (44, 4, NULL, 38);
INSERT INTO `tb_donem_ogrencileri` VALUES (45, 4, NULL, 39);
INSERT INTO `tb_donem_ogrencileri` VALUES (46, 4, NULL, 40);
INSERT INTO `tb_donem_ogrencileri` VALUES (47, 4, NULL, 41);
INSERT INTO `tb_donem_ogrencileri` VALUES (48, 4, NULL, 42);
INSERT INTO `tb_donem_ogrencileri` VALUES (49, 4, NULL, 43);
INSERT INTO `tb_donem_ogrencileri` VALUES (50, 4, NULL, 44);
INSERT INTO `tb_donem_ogrencileri` VALUES (51, 4, NULL, 45);
INSERT INTO `tb_donem_ogrencileri` VALUES (52, 4, NULL, 46);
INSERT INTO `tb_donem_ogrencileri` VALUES (53, 4, NULL, 47);
INSERT INTO `tb_donem_ogrencileri` VALUES (54, 4, NULL, 48);
INSERT INTO `tb_donem_ogrencileri` VALUES (55, 4, NULL, 49);
INSERT INTO `tb_donem_ogrencileri` VALUES (56, 4, NULL, 50);
INSERT INTO `tb_donem_ogrencileri` VALUES (57, 4, NULL, 51);
INSERT INTO `tb_donem_ogrencileri` VALUES (58, 4, NULL, 52);
INSERT INTO `tb_donem_ogrencileri` VALUES (59, 4, NULL, 53);
INSERT INTO `tb_donem_ogrencileri` VALUES (60, 4, NULL, 54);
INSERT INTO `tb_donem_ogrencileri` VALUES (61, 4, NULL, 55);
INSERT INTO `tb_donem_ogrencileri` VALUES (62, 4, NULL, 56);
INSERT INTO `tb_donem_ogrencileri` VALUES (63, 4, NULL, 57);
INSERT INTO `tb_donem_ogrencileri` VALUES (64, 4, NULL, 58);
INSERT INTO `tb_donem_ogrencileri` VALUES (65, 4, NULL, 59);
INSERT INTO `tb_donem_ogrencileri` VALUES (66, 4, NULL, 60);
INSERT INTO `tb_donem_ogrencileri` VALUES (67, 4, NULL, 61);
INSERT INTO `tb_donem_ogrencileri` VALUES (68, 4, NULL, 62);
INSERT INTO `tb_donem_ogrencileri` VALUES (69, 4, NULL, 63);
INSERT INTO `tb_donem_ogrencileri` VALUES (70, 4, NULL, 64);
INSERT INTO `tb_donem_ogrencileri` VALUES (71, 4, NULL, 65);
INSERT INTO `tb_donem_ogrencileri` VALUES (72, 4, NULL, 66);
INSERT INTO `tb_donem_ogrencileri` VALUES (73, 4, NULL, 67);
INSERT INTO `tb_donem_ogrencileri` VALUES (74, 4, NULL, 68);
INSERT INTO `tb_donem_ogrencileri` VALUES (75, 4, NULL, 69);
INSERT INTO `tb_donem_ogrencileri` VALUES (76, 4, NULL, 70);
INSERT INTO `tb_donem_ogrencileri` VALUES (77, 4, NULL, 71);
INSERT INTO `tb_donem_ogrencileri` VALUES (78, 4, NULL, 72);
INSERT INTO `tb_donem_ogrencileri` VALUES (79, 4, NULL, 73);
INSERT INTO `tb_donem_ogrencileri` VALUES (80, 4, NULL, 74);
INSERT INTO `tb_donem_ogrencileri` VALUES (81, 4, NULL, 75);
INSERT INTO `tb_donem_ogrencileri` VALUES (82, 4, NULL, 76);
INSERT INTO `tb_donem_ogrencileri` VALUES (83, 4, NULL, 77);
INSERT INTO `tb_donem_ogrencileri` VALUES (84, 4, NULL, 78);
INSERT INTO `tb_donem_ogrencileri` VALUES (85, 4, NULL, 79);
INSERT INTO `tb_donem_ogrencileri` VALUES (86, 4, NULL, 80);
INSERT INTO `tb_donem_ogrencileri` VALUES (87, 4, NULL, 81);
INSERT INTO `tb_donem_ogrencileri` VALUES (88, 4, NULL, 82);
INSERT INTO `tb_donem_ogrencileri` VALUES (89, 4, NULL, 83);
INSERT INTO `tb_donem_ogrencileri` VALUES (90, 4, NULL, 84);
INSERT INTO `tb_donem_ogrencileri` VALUES (91, 4, NULL, 85);
INSERT INTO `tb_donem_ogrencileri` VALUES (92, 4, NULL, 86);
INSERT INTO `tb_donem_ogrencileri` VALUES (93, 4, NULL, 87);
INSERT INTO `tb_donem_ogrencileri` VALUES (94, 4, NULL, 88);
INSERT INTO `tb_donem_ogrencileri` VALUES (95, 4, NULL, 89);
INSERT INTO `tb_donem_ogrencileri` VALUES (96, 4, NULL, 90);
INSERT INTO `tb_donem_ogrencileri` VALUES (97, 4, NULL, 91);
INSERT INTO `tb_donem_ogrencileri` VALUES (98, 4, NULL, 92);
INSERT INTO `tb_donem_ogrencileri` VALUES (99, 4, NULL, 93);
INSERT INTO `tb_donem_ogrencileri` VALUES (100, 4, NULL, 94);
INSERT INTO `tb_donem_ogrencileri` VALUES (101, 4, NULL, 95);
INSERT INTO `tb_donem_ogrencileri` VALUES (102, 4, NULL, 96);
INSERT INTO `tb_donem_ogrencileri` VALUES (103, 4, NULL, 97);
INSERT INTO `tb_donem_ogrencileri` VALUES (104, 4, NULL, 98);
INSERT INTO `tb_donem_ogrencileri` VALUES (105, 4, NULL, 99);
INSERT INTO `tb_donem_ogrencileri` VALUES (106, 4, NULL, 100);
INSERT INTO `tb_donem_ogrencileri` VALUES (107, 4, NULL, 101);
INSERT INTO `tb_donem_ogrencileri` VALUES (108, 4, NULL, 102);
INSERT INTO `tb_donem_ogrencileri` VALUES (109, 4, NULL, 103);
INSERT INTO `tb_donem_ogrencileri` VALUES (110, 4, NULL, 104);
INSERT INTO `tb_donem_ogrencileri` VALUES (111, 4, NULL, 105);
INSERT INTO `tb_donem_ogrencileri` VALUES (112, 4, NULL, 106);
INSERT INTO `tb_donem_ogrencileri` VALUES (113, 4, NULL, 107);
INSERT INTO `tb_donem_ogrencileri` VALUES (114, 4, NULL, 108);
INSERT INTO `tb_donem_ogrencileri` VALUES (115, 4, NULL, 109);
INSERT INTO `tb_donem_ogrencileri` VALUES (116, 4, NULL, 110);
INSERT INTO `tb_donem_ogrencileri` VALUES (117, 4, NULL, 111);
INSERT INTO `tb_donem_ogrencileri` VALUES (118, 4, NULL, 112);
INSERT INTO `tb_donem_ogrencileri` VALUES (119, 4, NULL, 113);
INSERT INTO `tb_donem_ogrencileri` VALUES (120, 4, NULL, 114);
INSERT INTO `tb_donem_ogrencileri` VALUES (121, 4, NULL, 115);
INSERT INTO `tb_donem_ogrencileri` VALUES (122, 4, NULL, 116);
INSERT INTO `tb_donem_ogrencileri` VALUES (123, 4, NULL, 117);
INSERT INTO `tb_donem_ogrencileri` VALUES (124, 4, NULL, 118);
INSERT INTO `tb_donem_ogrencileri` VALUES (125, 4, NULL, 119);
INSERT INTO `tb_donem_ogrencileri` VALUES (126, 4, NULL, 120);
INSERT INTO `tb_donem_ogrencileri` VALUES (127, 4, NULL, 121);
INSERT INTO `tb_donem_ogrencileri` VALUES (128, 4, NULL, 122);
INSERT INTO `tb_donem_ogrencileri` VALUES (129, 4, NULL, 123);
INSERT INTO `tb_donem_ogrencileri` VALUES (130, 4, NULL, 124);
INSERT INTO `tb_donem_ogrencileri` VALUES (131, 4, NULL, 125);
INSERT INTO `tb_donem_ogrencileri` VALUES (132, 4, NULL, 126);
INSERT INTO `tb_donem_ogrencileri` VALUES (133, 4, NULL, 127);
INSERT INTO `tb_donem_ogrencileri` VALUES (134, 4, NULL, 128);
INSERT INTO `tb_donem_ogrencileri` VALUES (135, 4, NULL, 129);
INSERT INTO `tb_donem_ogrencileri` VALUES (136, 4, NULL, 130);
INSERT INTO `tb_donem_ogrencileri` VALUES (156, 1, NULL, 131);

-- ----------------------------
-- Table structure for tb_donem_subeleri
-- ----------------------------
DROP TABLE IF EXISTS `tb_donem_subeleri`;
CREATE TABLE `tb_donem_subeleri`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ders_yili_donem_id` int NULL DEFAULT NULL,
  `program_id` int NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_donem_subeleri
-- ----------------------------

-- ----------------------------
-- Table structure for tb_donemler
-- ----------------------------
DROP TABLE IF EXISTS `tb_donemler`;
CREATE TABLE `tb_donemler`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `universite_id` int NULL DEFAULT NULL,
  `program_id` int NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT '',
  `aktif` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_donemler
-- ----------------------------
INSERT INTO `tb_donemler` VALUES (1, 1, 1, 'Mühendislik Fakültesi', 1);
INSERT INTO `tb_donemler` VALUES (2, 1, 1, 'Fen Bilimleri Fakültesi', 1);
INSERT INTO `tb_donemler` VALUES (3, 1, 1, 'Filoloji Fakültesi', 1);
INSERT INTO `tb_donemler` VALUES (4, 1, 1, 'İlahiyat Fakültesi', 1);
INSERT INTO `tb_donemler` VALUES (5, 1, 1, 'Diş Hekimliği Fakültesi', 1);
INSERT INTO `tb_donemler` VALUES (6, 1, 1, 'Tıp Fakültesi', 1);

-- ----------------------------
-- Table structure for tb_duyurular
-- ----------------------------
DROP TABLE IF EXISTS `tb_duyurular`;
CREATE TABLE `tb_duyurular`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `birim_id` int UNSIGNED NULL DEFAULT NULL,
  `tarih` datetime NULL DEFAULT NULL,
  `baslik` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT '',
  `icerik` longtext CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL,
  `foto` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `aktif` tinyint NULL DEFAULT 1,
  `baslik_kz` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `baslik_en` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `baslik_ru` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `icerik_kz` longtext CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL,
  `icerik_en` longtext CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL,
  `icerik_ru` longtext CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_duyurular
-- ----------------------------
INSERT INTO `tb_duyurular` VALUES (12, 11, '2015-04-17 00:00:00', 'Cumhurbaşkanımız Sayın Recep Tayyip Erdoğan', '<p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">T.C. Cumhurbaşkanı Sayın Recep Tayyip Erdoğan’ın Hoca Ahmet Yesevi Uluslararası Türk-Kazak Üniversitesi Tarafından Fahri Profesörlük Tevdii Töreni’nde Yaptıkları Konuşma</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">17.04.2015</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">&nbsp;</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Sayın Cumhurbaşkanı,</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Sayın Rektör,</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Değerli Öğretim Üyeleri ve Öğrenciler</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Kıymetli Hanımefendiler, Beyefendiler,</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Sizleri sevgiyle, saygıyla selamlıyorum. Cumhurbaşkanı olarak Kazakistan’a yaptığım bu ilk ziyaret vesilesiyle, Hoca Ahmet Yesevi Üniversitesi’nde bulunmaktan memnuniyet duyuyorum. &nbsp;Şahsıma layık görülen fahri profesörlük unvanı için, üniversite yönetimine ve tüm dostlarımıza teşekkür ediyorum. &nbsp;Üniversitemizi, Türkiye ile Kazakistan arasındaki işbirliğinin önemli sembollerinden biri olarak görüyorum.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Dilimizin ve kültürümüzün gelişmesine, zenginleşmesine çok önemli katkılarda bulunan büyük fikir adamı ve gönül eri Hoca Ahmet Yesevi’nin manevi feyzinin, ziyaretimizi daha da anlamlı kıldığına inanıyorum. &nbsp;Üniversiteye ismini veren Ahmet Yesevi, gerekten de Türkistan’dan Anadolu’ya ve Balkanlara kadar uzanan geniş bir coğrafyanın manevi kandillerinden biridir.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Ahmet Yesevi Hazretleri, Arslan Baba’dan ve Yusuf Hemedani’den devraldığı ihlas ve irfan bayrağını, Horasan Erenleri aracılığıyla yedi iklim dört kıtaya taşımıştır. Bu üniversitenin, bir eğitim kurumu olmanın ötesinde, Hoca Ahmet Yesevi okulunun günümüzdeki temsilcisi olarak da faaliyet gösterdiğine, göstermesi gerektiğine inanıyorum.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Üniversitemizin ilk ve en önemli öğretim üyesi olarak Hoca Ahmet Yesevi’yi kabul ediyorum. Öğrenci kardeşlerimden bu şuurla, bu anlayışla, bu misyonla eğitimlerini yürütmelerini, kendilerini yetiştirmelerini bekliyorum. Bu üniversite, hem taşıdığı isim, hem de bulunduğu coğrafya sebebiyle, herhangi bir yüksek eğitim kurumu olarak kalamaz, kalmamalıdır.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Türkistan, çağlar açıp çağlar kapatan gelişmelerin temellerinin atıldığı, tarihi bir ilim, irfan, kültür merkezidir. Tarihte “Türk Rönesansı” diye ifade edilen medeniyet hamlesinin harcı, işte burada, bu topraklarda karılmıştır. Bu harcın temelinde muhabbet vardır, saygı vardır, bilgi vardır, erdem vardır, hikmet vardır.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Hoca Ahmet Yesevi’nin bu donanımla Anadolu’ya, Balkanlara gönderdiği dervişler, sadece birer Eren değil, aynı zamanda birer Alp’ti. Bilgiyi ve mücadele ruhunu şahıslarında birleştiren bu Alperen’lerin izlerini, gittiğimiz her yerde görüyoruz. Kuzey Afrika’dan Ortadoğu’ya, Balkanlar’dan Avrupa’nın içlerine kadar her yerde, tekkelerini, türbelerini, camilerini, medreselerini ihya ettiğimiz bu Alperen geleneğinin ocağı, işte burasıdır, Türkistan’dır, Hoca Ahmet Yesevi’nin dergâhıdır.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Hoca Ahmet Yesevi Üniversitemiz de bu geleneğin günümüzdeki en önemli merkezi olmak durumundadır. Aksi halde üniversitemiz, isminin hakkını veremiyor demektir. Bu adı taşımak ne kadar ayrıcalıklı ise, bu misyonu yüklenmek de o derece fedakârlık ister.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Ben, üniversitemizin önümüzdeki dönemde, tüm coğrafyamıza yeni bir soluk, yeni bir nefes vererek, adına ve misyonuna yakışan bir gayret ortaya koyacağına yürekten inanıyorum. 1993 yılında ata yurdun kalbine dikilen bu fidan, sizlerin sayenizde bugün artık genç bir çınar haline geldi. Hoca Ahmet Yesevi meşalesini taşıma şerefine nail olmuş bilim insanları ve öğrenciler olarak, üniversitemizi uluslararası rekabet gücü yüksek bir kurum haline getirme konusundaki çabalarınızı takdir ediyorum. Bunun yanında Hoca Ahmet Yesevi Üniversitesi, Rektör’ünden öğrencisine kadar tüm mensuplarıyla, köklü geçmişimiz ile parlak geleceğimiz arasındaki köprü olma misyonunu da her faaliyetinde göstermelidir.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Değerli Arkadaşlar,</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Türkiye; tarihi, coğrafi ve kültürel bakımdan Kazakistan’ın da içinde yer aldığı Orta Asya coğrafyasının doğal ve vazgeçilmez bir parçasıdır. Orta Asya, tarihin her döneminde Anadolu insanı için ayrı bir önem taşıdı. 1991 yılından itibaren, 70 yıllık parantezin kapanmasını takiben, bölgeyle yeniden ilişki tesis edilmesi, Türk dış politikasının en önemli önceliklerinden biri oldu. Türkiye, başta Kazakistan olmak üzere, Orta Asya’daki kardeş cumhuriyetlerin bağımsızlığını ilk tanıyan ve buralarda ilk Büyükelçilik açan ülkedir.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Dün değerli Cumhurbaşkanı Nazarbayev’le dertleşirken bağımsızlığımızı ilan ettiğimizde 2 saat sonra merhum Turgut Özal’ın Kazakistan’ın bağımsızlığını tanıdıklarını ilan etmişti dedi. İşte bu denli anlamlıdır bizim kardeşliğimiz. Orta Asya ülkeleri, bağımsızlıklarından bu yana geçen 20 yılı aşkın sürede siyasi, ekonomik, sosyo-kültürel alanlarda önemli ilerlemeler sağladı. 1990’lı yılların zorlu şartlarına rağmen, bağımsızlıklarını ve egemenliklerini korumayı başaran bu ülkeler için, bugün gelinen nokta çok önemlidir. 23-24 yıl önce bazıları bu ülkelerin bağımsızlıklarını sürdürebilecekleri konusunda şüphe içerisindeydi. Gerçekten de bu yıllar, Türkiye için olduğu gibi, Türk Cumhuriyetleri için de kolay geçmedi, sıkıntılıydı. Dünyaca ünlü yazarımız Cengiz Aytmatov’un ifadesiyle “asra bedel günler” yaşandı. Ancak, bu ülkelerin başarısızlıklarını bekleyenler hüsrana uğradılar. Kardeş Cumhuriyetlerin hepsi, devlet hayatı bakımından çok kısa sayılabilecek bir sürede kendi ayakları üzerinde durmayı başardı.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Türk dünyası, Sovyetler Birliği’nin dağılmasından sonraki süreçte, bağımsızlık döneminin bu ilk sıkıntılı sınavlarını başarıyla verdi. Bu yıl, Kazakistan’ın bağımsızlığının ve Türkiye-Kazakistan ilişkilerinin 24’üncü yılını kutluyoruz. &nbsp;Bu sürede Kazakistan, değerli kardeşim, Cumhurbaşkanı Sayın Nazarbayev’in ehil yönetimi altında önemli başarılara imza attı. Sahip olduğu doğal kaynakları ve coğrafi konumunu etkin şekilde kullandı, ulaştırma ve enerji diplomasisi alanında görüşü aranan bir ülke haline geldi. Kazakistan’ın bundan sonra da çok daha büyük başarılara imza atacağına yürekten inanıyorum.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Türkiye’nin de bu yolda her zaman Kazakistan’ın ve kardeş Kazak halkının yanında olacağından şüpheniz olmasın. Geçen 24 yılda, iki kardeş ülke arasındaki ilişkilerde de büyük mesafeler kat edildi. Siyasi ilişkilerimiz, aramızdaki kardeşliğe yaraşır şekilde mükemmel bir seviyeye ulaştı. 2009 yılında imzaladığımız Stratejik Ortaklık Anlaşması ve 2012 yılında tesis ettiğimiz Yüksek Düzeyli Stratejik İşbirliği Konseyi, işte bu işbirliğin sembolleridir. Ekonomik, ticari ve kültürel alanlardaki işbirliğimiz her geçen gün daha da gelişiyor. Yükseköğrenim konusunda Kazakistanlı kardeşlerimizle çok müstesna bir işbirliği yürütüyoruz. 1992 yılından itibaren bu güne kadar, 3 bin 750 Kazak öğrenciye ülkemizde burs imkânı sunduk. “Türkiye Bursları” ile de her yıl 150 civarında öğrenciye lisans, yüksek lisans ve doktora seviyesinde burs veriyoruz.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">İkili ilişkilerimizin yanı sıra, Türk Konseyi başta olmak üzere, çok taraflı platformlardaki işbirliğimiz de mükemmel seviyededir. Büyük önem verdiğimiz Türk Konseyi’ni, Hoca Ahmet Yesevi Hazretleri’nin misyonunun önemli bir kilometre taşı olarak görüyoruz. Bizlere düşen görev, ortak kültürümüzden ve tarihimizden aldığımız bu mirası, gelecek nesillere, yani sizlere en güzel şekilde aktarmak ve onun daha ileriye götürülmesini teşvik etmektir. &nbsp;Sizlerin de aynı anlayışa, aynı bakışa açısına sahip olduğunuza inanıyorum.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Değerli Kardeşlerim,</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Dünyanın her alanda hızlı değişimler geçirdiği bir dönemdeyiz. Ortak güvenliğimizi ve geleceğimizi ilgilendiren konular, her geçen gün daha karmaşık bir nitelik kazanıyor. Yaşanan değişimi anlayabilmek için, uluslararası dinamiklerin doğru tahlil edilmesi gerekiyor. &nbsp;İstikrar ve refahın tesisi bakımından, karşılıklı çıkara dayalı ekonomik bağımlılıktan, farklılıkları bir arada yaşatma kabiliyetine kadar, pek çok önemli konu önümüzdeki dönemde gündemimizi meşgul edecektir.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Türkiye, içinden geçilen işte bu değişim sürecinin farklı dinamiklerinin kesişme noktasında olan bir ülke. Bu, her geçen gün artan imkân ve kabiliyetlerimizle, dış politikamızın çok boyutluluğunu sağlayan ve gerekli kılan bir unsur olarak karşımıza çıkıyor.&nbsp; Bunun yanında, kendimizle birlikte kardeşlerimizin de siyasi, sosyal ve ekonomik gelişmesini sağlamak için her türlü çabayı gösterme sorumluluğuyla karşı karşıyayız.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Dış politikamıza hakim olan çok yönlü, dinamik, vizyoner ve insan odaklı yaklaşımda, Hoca Ahmet Yesevi’nin “insanın kendisiyle olduğu kadar çevresiyle de barışık olması gerektiği” prensibinin izlerini görebilirsiniz. &nbsp;Bu prensibin tüm dünya tarafından da uygulanması halinde, halen yaşanan bunca acı ve sıkıntının sona ermemesi mümkün mü?</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Türkiye olarak, tarihimizin ve coğrafyamızın bize yüklediği sorumlulukların farkındayız. Dünyada yaşanan değişimin insani hakları temelinde, hukukun üstünlüğü, barış, refahın ve güvenlik ekseninde gelişmesi için üzerimize düşeni yapıyoruz, yapmaya devam edeceğiz. Tarih bize, doğru adımların atılması ve fırsatların değerlendirilmesi halinde, bölgemizde büyük medeniyetlerin yükseldiğini, buna karşılık yapılacak yanlışların bedelinin de çok ağır olduğunu gösteriyor.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Bakınız bugün çevremizde, bizi ve kardeşlerimizi ilgilendiren birçok sorun yaşanıyor. Ukrayna’da Kırım Tatarlarının durumunu biliyorsunuz. Suriye’deki zulüm, hem insani bakımdan, hem siyasi bakımdan giderek kötüleşiyor, vicdanları giderek daha çok yaralıyor. Aynı şekilde Irak’ta mezhepçilik fitnesi, hala tüm ateşiyle yanıyor. &nbsp;DEAŞ denilen terör örgütü, sadece ve sadece Müslüman kanı dökerek, İslam dünyasını ve bölgeyi zehirlemeye devam ediyor. Libya’da yaşanan fiili bölünmüşlük hali, ülkenin ve oradaki kardeşlerimizin geleceği bakımından bizi endişelendiriyor. Mısır’da darbeyle işbaşına gelen yönetim, demokrasiye dönüşü reddettiği gibi, verdiği idam kararlarıyla, halkın yüreğinde de kapanmayacak yaralar açma yolunda ilerliyor. Son olarak Yemen’de başlayan iç çatışmalar, bölgede yeni bir kamplaşmanın fitilini ateşleme aşamasına geldi. &nbsp;Filistinlilerin haklarına saygı göstermeme konusunda adeta yarış içinde olan İsrailli politikacılar yüzünden, bölgedeki huzursuzluk giderek tırmanıyor. Afganistan hala huzuru yakalayabilmiş değil. &nbsp;Afrika ülkelerinin pek çoğunda da benzer sıkıntılar var. Myanmar’dan, Doğu Türkistan’dan gelen haberler bizleri endişelendirmeye devam ediyor.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Türkiye, işte tüm bu manzara içinde, barışın, huzurun, refahın, güvenin temel alındığı bir uluslararası sistemin inşası için çalışıyor, bu yöndeki gayretlere destek veriyor. Bu çabaların başarıya ulaşması için, uluslararası toplumda etkinliği olan tarafların bir araya gelmesi ve birlikte hareket etmesi şarttır. Bunun için, bir yandan bölgesel işbirliği platformları güçlendirilirken, diğer yandan da Birleşmiş Milletler başta olmak üzere, küresel yapıların çözüm odaklı bir anlayışla yeniden yapılandırılması gerekiyor.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Suriye’de 300 bin insanın ölümüne seyirci kalan bir Birleşmiş Milletler Güvenlik Konseyi, dünya üzerinde yaşayan milyarlarca insana nasıl güvenli bir gelecek vaat edebilir ki? Seçimle işbaşına gelmiş siyasetçilerin değil, askeri darbeyle ülke yönetimini gasp etmiş diktatörlerin arkasında duran bir uluslararası düzen, insanlara nasıl daha özgür bir gelecek vaat edebilir ki? Batıda sadece israf edilen, çöpe atılan yiyeceğin, Afrika’daki tüm açları doyurabilecek miktara ulaşabildiği bir sistem, insanları nasıl daha müreffeh bir hayat için motive edebilir ki?</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Biz, işte bu sürdürülemez uluslararası düzenin değişmesi için her platformda sesimizi yükseltiyor, itirazlarımızı dile getiriyoruz. Küresel vicdanı uyandırana kadar da bunları söylemeye devam edeceğiz.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Amacımız asla bu dengesizlik içinde bir rol kapmak değildir. Biz, tesisini arzu ettiğimiz adil ve gerçekçi yeni düzenin eşit taraflarından biri olmaya talibiz. Yani ‘Birleşmiş Milletler Güvenlik Konseyi’nin 5 daimi üyesi dünyanın kaderini belirleyemez, belirlememelidir’ diyoruz. Çünkü dünya 5’ten büyüktür. Öyleyse tüm dünyanın kaderini niçin bu 5 tane üyeden bir tanesinin kararı belirlesin? Bu adil bir dünya olmaz. Onun için el ele vermeye mecburuz, dayanışma halinde olmaya mecburuz.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Bakınız 2013 yılında Türkiye en çok uluslararası yardım yapan ülkeler sıralamasında üçüncü sırada yer aldı. Biz 12 yıl önce yılda 45 milyon dolar yardımda bulunuyorduk, ama geçen yıl –burası çok ilginç- şimdi 4,5 milyar dolar yardım eder hale geldik. Bu bizim insani ve vicdani sorumluluğumuzdur, bunu yapmaya mecburuz. Onun için bunları yapıyoruz ve yapacağız.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Değerli kardeşlerim,</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Bununla kalamayız. Her geçen gün daha kararlı bir şekilde bunu devam ettirmemiz lazım. Afrika ülkelerini dolaştığım zaman, o acı manzaraları gördüğüm zaman diyorum ki; bizim sorumluluğumuz daha büyük. Yani biz ekonomik büyüklüğümüzün çok çok üzerinde bir insani yardım içindeyiz. Amerika, İngiltere ve Türkiye, düşünebiliyor musunuz? Halbuki dünyada bizden çok çok güçlü ülkeler var. Bakınız şu anda Suriye ve Irak’tan Türkiye’ye sığınan sığınmacıların sayısı ne biliyor musunuz? 2 milyon. Bunun 1 milyon 700 bini Suriye’den, 300 bini Irak’tan ölümden kaçarak geldiler, Türkiye’ye sığındılar. Kapınızı kapayabilir misiniz? Ne dedik? ‘Buyurun’. Ve şimdi onları biz yediriyoruz, giydiriyoruz, sağlığına, eğitimine, her şeyine A’dan Z’ye biz bakıyoruz. Peki, size Birleşmiş Milletler’den yardım gelmedi mi? Geldi, ne kadar biliyor musunuz? 250 milyon dolar. Peki, biz şu ana kadar ne kadar harcama yaptık, onu da sizlere söyleyeyim;, 5,5 milyar dolar, fark bu. Ama biz bundan da şeref duyuyoruz, gurur duyuyoruz.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">İnşallah, Türk Konseyi başta olmak üzere Orta Asya’daki dostlarımızla birlikte oluşturduğumuz ve güçlendirme kararı aldığımız işbirliği platformuyla bu gücümüzü daha da artıracağız. Hoca Ahmet Yesevi’nin hikmetlerinden aldığımız ilham, güç ve cesaretle bu doğrultuda yolumuza devam edeceğiz.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Ben bu düşüncelerle üniversitemizin yönetimine ve öğrencilerine başarılar diliyorum. Şahsıma tevdi ettiğiniz fahri profesörlük için şükranlarımı ifade ediyorum. Üniversitemize, öğrencilerimize layık olmanın gayreti içerisinde olacağımı da burada ifade etmek istiyorum.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);box-sizing:border-box;color:rgb(24, 28, 50);font-family:Poppins, Helvetica, sans-serif;font-size:15.6px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:1rem;margin-top:0px;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Size saygılarımı ve sevgilerimi sunuyorum.</p>', '6503fa0a2eecb030e65da2b1c944090548d36b244b28d.jpg', 1, 'Deneme', NULL, NULL, '<p>sdfsdfsdf</p>', NULL, NULL);
INSERT INTO `tb_duyurular` VALUES (13, 11, '2023-09-04 00:00:00', 'Ahmet Yesevi Üniversitesi Mütevelli Heyet Başkanı Prof. Dr. Muhittin Şimşek, T.C. Lefkoşa Büyükelçisi Prof. Dr. Metin Feyzioğlu’nu Ziyaret Etti', '<p>Deneme</p>', '64fe9d638abfdc0f971d8cd24364f2029fcb9ac7b71f5.jpeg', 1, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_duyurular` VALUES (14, 11, '2023-09-27 00:00:00', 'Ahmet Yesevi Üniversitesi\'nde 30 Ağustos Zafer Bayramı ve Kazakistan Cumhuriyeti Anayasa Günü Coşkuyla Kutlandı', '<p>sdafsf</p>', '64fe9d825e953227f6afd3b7f89b96c4bb91f95d50f6d.jpeg', 1, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_duyurular` VALUES (15, 11, '2022-10-12 00:00:00', 'Ahmet Yesevi Üniversitesi Mütevelli Heyet Başkanı Prof. Dr. Muhittin Şimşek, Üniversitemiz Senato Toplantısına Katıldı', '<p>asdfsdf</p>', '64fe9da504fa3f3b7e5d3eb074cde5b76e26bc0fb5776.jpeg', 1, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tb_duyurular` VALUES (28, 11, '2023-09-11 00:00:00', 'Ahmet Yesevi Üniversitesi Mütevell, Heyet Başkanı Prof. Dr. Muhittin Şimşek, Hizmet İçi Eğitim Almak Üzere Ankara’ya Gelen Personellerle Bir Araya Geldi', '<p>sadasd</p>', '64fe9dc0d4cd9d0010a6f34908640a4a6da2389772a78.jpeg', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for tb_egitim_duzeyleri
-- ----------------------------
DROP TABLE IF EXISTS `tb_egitim_duzeyleri`;
CREATE TABLE `tb_egitim_duzeyleri`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `sira` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_egitim_duzeyleri
-- ----------------------------
INSERT INTO `tb_egitim_duzeyleri` VALUES (1, 'Ortaöğretim', 1);
INSERT INTO `tb_egitim_duzeyleri` VALUES (2, 'Lise', 2);
INSERT INTO `tb_egitim_duzeyleri` VALUES (3, 'Lisans', 3);
INSERT INTO `tb_egitim_duzeyleri` VALUES (4, 'Yükseklisans', 4);
INSERT INTO `tb_egitim_duzeyleri` VALUES (5, 'Doktora', 5);

-- ----------------------------
-- Table structure for tb_etkinlikler
-- ----------------------------
DROP TABLE IF EXISTS `tb_etkinlikler`;
CREATE TABLE `tb_etkinlikler`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `birim_id` int UNSIGNED NULL DEFAULT NULL,
  `tarih` datetime NULL DEFAULT NULL,
  `baslik` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT '',
  `icerik` longtext CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL,
  `foto` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `baslik_kz` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `baslik_en` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `baslik_ru` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `icerik_kz` longtext CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL,
  `icerik_en` longtext CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL,
  `icerik_ru` longtext CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL,
  `aktif` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_etkinlikler
-- ----------------------------
INSERT INTO `tb_etkinlikler` VALUES (12, 11, '2015-04-17 00:00:00', 'Deneme deneme deneme', '', '6503fc3906c4c030e65da2b1c944090548d36b244b28d.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 1);
INSERT INTO `tb_etkinlikler` VALUES (13, 11, '2023-09-04 00:00:00', 'Ahmet Yesevi Üniversitesi Mütevelli Heyet Başkanı Prof. Dr. Muhittin Şimşek, T.C. Lefkoşa Büyükelçisi Prof. Dr. Metin Feyzioğlu’nu Ziyaret Etti', '<p>Deneme</p>', '64fe9d638abfdc0f971d8cd24364f2029fcb9ac7b71f5.jpeg', NULL, NULL, NULL, NULL, NULL, NULL, 1);
INSERT INTO `tb_etkinlikler` VALUES (14, 11, '2023-09-27 00:00:00', 'Ahmet Yesevi Üniversitesi\'nde 30 Ağustos Zafer Bayramı ve Kazakistan Cumhuriyeti Anayasa Günü Coşkuyla Kutlandı', '<p>sdafsf</p>', '64fe9d825e953227f6afd3b7f89b96c4bb91f95d50f6d.jpeg', NULL, NULL, NULL, NULL, NULL, NULL, 1);
INSERT INTO `tb_etkinlikler` VALUES (15, 11, '2022-10-12 00:00:00', 'Ahmet Yesevi Üniversitesi Mütevelli Heyet Başkanı Prof. Dr. Muhittin Şimşek, Üniversitemiz Senato Toplantısına Katıldı', '<p>asdfsdf</p>', '64fe9da504fa3f3b7e5d3eb074cde5b76e26bc0fb5776.jpeg', NULL, NULL, NULL, NULL, NULL, NULL, 1);
INSERT INTO `tb_etkinlikler` VALUES (28, 11, '2023-09-11 00:00:00', 'Ahmet Yesevi Üniversitesi Mütevell, Heyet Başkanı Prof. Dr. Muhittin Şimşek, Hizmet İçi Eğitim Almak Üzere Ankara’ya Gelen Personellerle Bir Araya Geldi', '<p>sadasd</p>', '64fe9dc0d4cd9d0010a6f34908640a4a6da2389772a78.jpeg', NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- ----------------------------
-- Table structure for tb_fakulteler
-- ----------------------------
DROP TABLE IF EXISTS `tb_fakulteler`;
CREATE TABLE `tb_fakulteler`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `universite_id` int NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT '',
  `ilk_goruntulenecek` tinyint NULL DEFAULT NULL,
  `aktif` tinyint NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_fakulteler
-- ----------------------------
INSERT INTO `tb_fakulteler` VALUES (1, 1, 'Tıp Fakültesi', 1, 1);
INSERT INTO `tb_fakulteler` VALUES (2, 1, 'Van Meslek', 0, 0);

-- ----------------------------
-- Table structure for tb_genel_ayarlar
-- ----------------------------
DROP TABLE IF EXISTS `tb_genel_ayarlar`;
CREATE TABLE `tb_genel_ayarlar`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `birim_id` int UNSIGNED NULL DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `slogan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `footer_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `footer_sag_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `footer_sag_logo_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `map` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `adres` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `facebook` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `twitter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `instagram` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `linkedin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `youtube` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `anasayfa_baslik` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `anasayfa_icerik` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `ogrenci_sayisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `bolum_sayisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `egitmen_sayisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `yayin_sayisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slogan2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `slogan3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `buton_deger1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `buton_url1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `buton_deger2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `buton_url2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `adres_kz` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `adres_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `adres_ru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `anasayfa_baslik_kz` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `anasayfa_baslik_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `anasayfa_baslik_ru` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `anasayfa_icerik_kz` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `anasayfa_icerik_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `anasayfa_icerik_ru` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `slogan_kz` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `slogan_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `slogan_ru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `slogan2_kz` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `slogan2_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `slogan2_ru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `slogan3_kz` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `slogan3_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `slogan3_ru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `buton_deger1_kz` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `buton_deger1_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `buton_deger1_ru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `buton_deger2_kz` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `buton_deger2_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `buton_deger2_ru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_genel_ayarlar
-- ----------------------------
INSERT INTO `tb_genel_ayarlar` VALUES (2, 11, 'logo_64feb065177d2ayu_logo2.png', 'Hoca Ahmet Yesevi Uluslararası Türk-Kazak Üniversitesi', 'footer_logo_64feb065179dcayu_logo_beyaz.png', '', 'cbdgfd', '', 'Түркістанқаласы,Бекзат Саттарханов даңғылы, 29', '+7(725) 336-36-36', 'info@ayu.edu.kz', 'https://www.facebook.com/yassawi.university/', '', '', '', '', 'Hakkımızda', '<p><span style=\"background-color:rgb(255,255,255);color:rgb(24,28,50);font-family:Poppins, Helvetica, sans-serif;font-size:14.95px;\"><span style=\"-webkit-text-stroke-width:0px;display:inline !important;float:none;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;orphans:2;text-align:justify;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Mütevelli Heyetimizin kararıyla Ekim-2004 tarihinde “Bilişim Teknolojileri ve Mühendislik Fakültesi” olarak kurulan Fakültemizin ismi Üniversitemiz Senatosunun kararıyla 2014-2015 Eğitim-Öğretim döneminden başlayarak “Mühendislik Fakültesi” olarak değiştirildi. Fakültemiz, Lisans ve lisansüstü seviyede, çağdaş, kapsamlı ve güçlü mühendislik eğitimi vermek, nitelikli, özgün ve yenilikçi araştırmalar yaparak bilimsel ve teknolojik gelişmeye katkı sağlamak, sanayi ve paydaş kurum/kuruluşlar ile yakın işbirliği kurarak ulusal/uluslararası kalkınmaya katkı sağlamak misyonu ile eğitim hayatına devam etmektedir.</span></span></p>', '1023', '11', '95', '125', 'Slogan 2', 'Slogan 3', 'Buton 1', 'https://ayu.edu.kz', 'Buton 1', 'https://ayu.edu.kz', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for tb_gorev_kategorileri
-- ----------------------------
DROP TABLE IF EXISTS `tb_gorev_kategorileri`;
CREATE TABLE `tb_gorev_kategorileri`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `universite_id` int NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_gorev_kategorileri
-- ----------------------------
INSERT INTO `tb_gorev_kategorileri` VALUES (1, 1, 'Dekan');
INSERT INTO `tb_gorev_kategorileri` VALUES (2, 1, 'Dekan Yardımcısı');
INSERT INTO `tb_gorev_kategorileri` VALUES (3, 1, 'Bölüm Başkanı');
INSERT INTO `tb_gorev_kategorileri` VALUES (4, 1, 'Bölüm Başkanı Yardımcısı');
INSERT INTO `tb_gorev_kategorileri` VALUES (5, 1, 'Anabilim Dalı Başkanı');
INSERT INTO `tb_gorev_kategorileri` VALUES (6, 1, 'Ders Kurulu Başkan');

-- ----------------------------
-- Table structure for tb_kan_gruplari
-- ----------------------------
DROP TABLE IF EXISTS `tb_kan_gruplari`;
CREATE TABLE `tb_kan_gruplari`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `sira` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_kan_gruplari
-- ----------------------------
INSERT INTO `tb_kan_gruplari` VALUES (1, '0 Rh (+)', 1);
INSERT INTO `tb_kan_gruplari` VALUES (2, '0 Rh (-)', 2);
INSERT INTO `tb_kan_gruplari` VALUES (3, 'A Rh (+)', 3);
INSERT INTO `tb_kan_gruplari` VALUES (4, 'A Rh (-)', 4);
INSERT INTO `tb_kan_gruplari` VALUES (5, 'B Rh (+)', 5);
INSERT INTO `tb_kan_gruplari` VALUES (6, 'B Rh (-)', 6);
INSERT INTO `tb_kan_gruplari` VALUES (7, 'AB Rh (+)', 7);
INSERT INTO `tb_kan_gruplari` VALUES (8, 'AB Rh (-)', 8);

-- ----------------------------
-- Table structure for tb_komite_dersleri
-- ----------------------------
DROP TABLE IF EXISTS `tb_komite_dersleri`;
CREATE TABLE `tb_komite_dersleri`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `komite_id` int NULL DEFAULT NULL,
  `donem_ders_id` int NULL DEFAULT NULL,
  `teorik_ders_saati` smallint NULL DEFAULT NULL,
  `uygulama_ders_saati` smallint NULL DEFAULT NULL,
  `soru_sayisi` smallint NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_komite_dersleri
-- ----------------------------
INSERT INTO `tb_komite_dersleri` VALUES (1, 1, 22, 5, 3, 1);
INSERT INTO `tb_komite_dersleri` VALUES (2, 1, 24, 10, 5, 1);
INSERT INTO `tb_komite_dersleri` VALUES (3, 1, 13, 10, 5, 3);
INSERT INTO `tb_komite_dersleri` VALUES (4, 1, 1, 30, 20, 15);

-- ----------------------------
-- Table structure for tb_komite_dersleri_ogretim_uyeleri
-- ----------------------------
DROP TABLE IF EXISTS `tb_komite_dersleri_ogretim_uyeleri`;
CREATE TABLE `tb_komite_dersleri_ogretim_uyeleri`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `komite_ders_id` int NULL DEFAULT NULL,
  `ogretim_uyesi_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_komite_dersleri_ogretim_uyeleri
-- ----------------------------
INSERT INTO `tb_komite_dersleri_ogretim_uyeleri` VALUES (5, 4, 1);
INSERT INTO `tb_komite_dersleri_ogretim_uyeleri` VALUES (9, 2, 1);
INSERT INTO `tb_komite_dersleri_ogretim_uyeleri` VALUES (10, 1, 1);
INSERT INTO `tb_komite_dersleri_ogretim_uyeleri` VALUES (11, 1, 21);
INSERT INTO `tb_komite_dersleri_ogretim_uyeleri` VALUES (12, 3, 21);

-- ----------------------------
-- Table structure for tb_komite_gorevlileri
-- ----------------------------
DROP TABLE IF EXISTS `tb_komite_gorevlileri`;
CREATE TABLE `tb_komite_gorevlileri`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `komite_id` int NULL DEFAULT NULL,
  `gorev_kategori_id` int NULL DEFAULT NULL,
  `ogretim_elemani_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_komite_gorevlileri
-- ----------------------------
INSERT INTO `tb_komite_gorevlileri` VALUES (1, 1, 1, 25);
INSERT INTO `tb_komite_gorevlileri` VALUES (3, 1, 2, 15);
INSERT INTO `tb_komite_gorevlileri` VALUES (4, 1, 7, 6);
INSERT INTO `tb_komite_gorevlileri` VALUES (5, 1, 7, 9);
INSERT INTO `tb_komite_gorevlileri` VALUES (6, 1, 7, 8);

-- ----------------------------
-- Table structure for tb_komite_ogrencileri
-- ----------------------------
DROP TABLE IF EXISTS `tb_komite_ogrencileri`;
CREATE TABLE `tb_komite_ogrencileri`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `komite_id` int NULL DEFAULT NULL,
  `ogrenci_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_komite_ogrencileri
-- ----------------------------
INSERT INTO `tb_komite_ogrencileri` VALUES (2, 1, 3);
INSERT INTO `tb_komite_ogrencileri` VALUES (3, 1, 9);
INSERT INTO `tb_komite_ogrencileri` VALUES (4, 1, 4);
INSERT INTO `tb_komite_ogrencileri` VALUES (5, 1, 129);
INSERT INTO `tb_komite_ogrencileri` VALUES (6, 1, 130);
INSERT INTO `tb_komite_ogrencileri` VALUES (8, 1, 2);
INSERT INTO `tb_komite_ogrencileri` VALUES (9, 1, 1);
INSERT INTO `tb_komite_ogrencileri` VALUES (13, 20, 1);
INSERT INTO `tb_komite_ogrencileri` VALUES (17, 1, 131);

-- ----------------------------
-- Table structure for tb_komiteler
-- ----------------------------
DROP TABLE IF EXISTS `tb_komiteler`;
CREATE TABLE `tb_komiteler`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ders_yili_donem_id` int NULL DEFAULT NULL,
  `ders_kodu` varchar(20) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `ders_kurulu_sira` varchar(10) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `baslangic_tarihi` date NULL DEFAULT NULL,
  `bitis_tarihi` date NULL DEFAULT NULL,
  `sinav_tarihi` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_komiteler
-- ----------------------------
INSERT INTO `tb_komiteler` VALUES (1, 1, 'TFTGI1001', 'Tıbba Giriş', '1', '2022-09-19', '2022-11-04', '2022-11-04');
INSERT INTO `tb_komiteler` VALUES (2, 1, 'TFHTY1001', 'Hücrenin Temel Yapısı', '2', '2022-11-07', '2022-12-30', '2022-12-30');
INSERT INTO `tb_komiteler` VALUES (3, 1, 'TFHUG1001', 'Hücre ve Genetik - I', '3', '2023-01-02', '2023-02-03', '2023-02-03');
INSERT INTO `tb_komiteler` VALUES (4, 1, 'TFHUG1002', 'Hücre ve Genetik - II', '4', '2023-02-20', '2023-03-30', '2023-03-31');
INSERT INTO `tb_komiteler` VALUES (5, 1, 'TFDKI1001', 'Doku ve Kas İskelet Sistemi - I', '5', '2023-04-03', '2023-05-11', '2023-05-12');
INSERT INTO `tb_komiteler` VALUES (6, 1, 'TFDKI1002', 'Doku ve Kas İskelet Sistemi - II', '6', '2023-05-15', '2023-06-22', '2023-06-23');
INSERT INTO `tb_komiteler` VALUES (15, 2, 'TFDKS2003', 'Dolaşım, Kan, Lenf ve Solunum Sistemi', NULL, '2022-09-12', '2022-10-27', '2022-10-28');
INSERT INTO `tb_komiteler` VALUES (16, 2, 'TFSME2003', 'Sindirim, Metabolizma ve Endokrin Sistem', NULL, '2022-10-31', '2022-12-15', '2022-12-16');
INSERT INTO `tb_komiteler` VALUES (17, 2, 'TFUGS2003', 'Ürogenital Sistem', NULL, '2022-12-19', '2023-01-26', '2023-01-27');
INSERT INTO `tb_komiteler` VALUES (18, 2, 'TFMSS2004', 'Merkezi Sinir Sistemi', NULL, '2023-01-30', '2023-04-20', '2023-04-21');
INSERT INTO `tb_komiteler` VALUES (19, 2, 'TFMSS2004', 'Hastalıkların Temelleri', NULL, '2023-04-24', '2023-06-23', '2023-06-23');
INSERT INTO `tb_komiteler` VALUES (20, 3, 'TFDKİ3005', 'Deri ve Kas-İskelet sistemi Hastalıkları', NULL, '2022-09-05', '2022-10-07', '2022-10-07');
INSERT INTO `tb_komiteler` VALUES (21, 3, 'TFMSS3005', 'Merkezi Sinir Sistemi ve Duyu Hastalıkları', NULL, '2022-10-10', '2022-11-18', '2022-11-18');
INSERT INTO `tb_komiteler` VALUES (22, 3, 'TFDSS3005', 'Dolaşım ve Solunum Sistemi Hastalıkları', NULL, '2022-11-21', '2022-12-30', '2022-12-30');
INSERT INTO `tb_komiteler` VALUES (23, 3, 'TFSİS3006', 'Sindirim Sistemi Hastalıkları', NULL, '2023-01-02', '2023-02-03', '2023-02-03');
INSERT INTO `tb_komiteler` VALUES (24, 3, 'TFEMK3006', 'Endokrin, Metabolizma, Kan ve Lenf Sistemi Hastalıkları', NULL, '2023-02-20', '2023-03-24', '2023-03-24');
INSERT INTO `tb_komiteler` VALUES (25, 3, 'TFUGS3006', 'Ürogenital Sistem Hastalıkları ', NULL, '2023-03-27', '2023-05-12', '2023-05-12');
INSERT INTO `tb_komiteler` VALUES (26, 3, 'TFBBS3006', 'Birinci Basamak Sağlık Hizmetleri ve Kliniğe Giriş', NULL, '2023-05-15', '2023-06-23', '2023-06-23');

-- ----------------------------
-- Table structure for tb_modul
-- ----------------------------
DROP TABLE IF EXISTS `tb_modul`;
CREATE TABLE `tb_modul`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `modul` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `klasor` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `simge` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `menude_goster` tinyint NULL DEFAULT 1,
  `ust_id` int NULL DEFAULT 0,
  `kategori` tinyint NULL DEFAULT 0,
  `sira` tinyint NULL DEFAULT 1,
  `harici_sayfa` tinyint NULL DEFAULT 0,
  `kategori_acik` tinyint NULL DEFAULT 0,
  `adi_kz` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `adi_en` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `adi_ru` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 158 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_modul
-- ----------------------------
INSERT INTO `tb_modul` VALUES (1, 'Anasayfa', 'anasayfa', 'anasayfa', 'fa fa-home', 1, 0, 0, 1, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (2, 'Sistem Kullanıcıları', 'sistemKullanicilari', 'sistemKullanicilari', 'fas fa-users-cog text-red', 1, 0, 0, 99, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (3, 'Yetkiler', 'yetkiler', 'yetkiler', 'far fa-circle text-green', 1, 68, 0, 7, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (32, 'Modul Yetkileri', 'modulYetkileri', 'modulYetkileri', 'far fa-circle text-yellow', 1, 68, 0, 8, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (68, 'Sistem İşlemleri', NULL, NULL, 'fas fa-sliders-h', 1, 0, 1, 100, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (90, 'Ön Tanım', NULL, NULL, 'fas fa-sitemap', 1, 0, 1, 12, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (109, 'Üniversiteler', 'universiteler', 'universiteler', 'fas fa-university text-green', 0, 125, 0, 1, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (110, 'Bölümler', 'bolumler', 'bolumler', 'fas fa-school text-yellow', 0, 125, 0, 3, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (111, 'Fakülteler', 'fakulteler', 'fakulteler', 'fas fa-building text-blue', 0, 125, 0, 2, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (112, 'Programlar', 'programlar', 'programlar', 'fas fa-book-reader text-purple', 0, 125, 0, 4, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (113, 'Ders Yılları', 'dersYillari', 'dersYillari', 'fas fa-calendar-alt text-blue', 0, 127, 0, 1, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (114, 'Ders Kategorileri', 'dersKategorileri', 'dersKategorileri', 'far fa-circle text-green', 0, 129, 0, 1, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (115, 'Dönem Tanımları', 'donemler', 'donemler', 'far fa-circle text-orange', 0, 129, 0, 2, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (116, 'Dersler', 'dersler', 'dersler', 'fas fa-book text-orange', 0, 0, 0, 20, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (117, 'Öğretim Elemanları', 'ogretimElemanlari', 'ogretimElemanlari', 'fas fa-user-md text-blue', 0, 0, 0, 25, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (118, 'Dönem Dersleri', 'donemDersleri', 'donemDersleri', 'fas fa-book text-orange', 0, 127, 0, 3, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (119, 'Komiteler', 'komiteler', 'komiteler', 'fas fa-calendar-plus text-blue', 0, 128, 0, 1, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (120, 'Komite Dersleri', 'komiteDersleri', 'komiteDersleri', 'fas fa-book text-green', 0, 128, 0, 2, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (121, 'Görev Kategorileri', 'gorevKategorileri', 'gorevKategorileri', 'far fa-circle text-blue', 1, 129, 0, 3, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (122, 'Dönem Görevlileri', 'donemGorevlileri', 'donemGorevlileri', 'fas fa-users text-purple', 0, 127, 0, 4, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (123, 'Komite Görevlileri', 'komiteGorevlileri', 'komiteGorevlileri', 'fas fa-user text-orange', 0, 128, 0, 4, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (124, 'Komite Öğretim Üyeleri', 'komiteDersOgretimUyeleri', 'komiteDersOgretimUyeleri', 'fas fa-users text-purple', 0, 128, 0, 3, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (125, 'Organizasyon Şeması', NULL, NULL, 'fas fa-sitemap text-green', 0, 0, 1, 5, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (126, 'Aktif Dönemler', 'dersYiliDonemler', 'dersYiliDonemler', 'fas fa-list-ol text-green', 0, 127, 0, 2, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (127, 'Ders Yılı Dönem İşlemleri', NULL, NULL, 'fas fa-calendar-alt text-yellow', 0, 0, 1, 10, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (128, 'Ders Kurulu İşlemleri', NULL, NULL, 'fas fa-calendar-plus text-purple', 0, 0, 1, 15, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (129, 'Sabit Tanımlar', NULL, NULL, 'fas fa-table', 1, 0, 1, 35, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (130, 'Öğrenci İşlemleri', NULL, NULL, 'fas fa-users text-danger', 0, 0, 1, 16, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (131, 'Öğrenciler', 'ogrenciler', 'ogrenciler', 'fas fa-users text-info', 0, 130, 0, 1, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (132, 'Dönem Öğrencileri', 'donemOgrencileri', 'donemOgrencileri', 'fas fa-users text-purple', 0, 130, 0, 2, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (133, 'Müfredat', 'mufredat', 'mufredat', 'fas fa-list-alt', 0, 0, 0, 40, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (134, 'Komite Öğrencileri', 'komiteOgrencileri', 'komiteOgrencileri', 'fas fa-users text-pink', 0, 130, 0, 3, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (135, 'Soru İşlemleri', NULL, NULL, 'fas fa-question-circle text-purple', 0, 0, 1, 40, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (136, 'Soru Türleri', 'soru_turleri', 'soru_turleri', 'fas fa-question text-warning', 0, 135, 0, 2, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (137, 'Soru Bankası', 'soruBankasi', 'soruBankasi', 'fas fa-question text-danger', 0, 135, 0, 1, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (138, 'Sınav İşlemleri', '', NULL, 'fas fa-file text-danger', 0, 0, 1, 41, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (139, 'Sınavlar', 'sinavlar', 'sinavlar', 'fas fa-file text-green', 0, 138, 0, 1, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (140, 'Sınav', 'sinav', 'sinav', 'fas fa-edit', 0, 138, 0, 1, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (141, 'Sınavlar Listesi', 'sinavlarListesi', 'sinavlar', 'fas fa-file text-orange', 0, 138, 0, 2, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (142, 'Anket İşlemleri', '', '', 'fas fa-edit text-green', 0, 0, 1, 42, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (143, 'Anketler', 'anketler', 'anketler', 'fas fa-question text-orange', 0, 142, 0, 2, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (144, 'Anket Şablonu', 'sablonlar', 'anketler', 'fas fa-copy text-warning', 0, 142, 0, 1, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (145, 'Anket Cevapla', 'anket', 'anketler', 'fas fa-edit', 0, 142, 0, 1, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (146, 'Birim Ağacı', 'birimAgaci', 'birimAgaci', 'fas fa-sitemap text-blue', 1, 0, 0, 5, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (147, 'Personeller', 'personeller', 'personeller', 'fas fa-users text-info', 1, 0, 0, 6, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (148, 'Öğrenim Bilgileri', 'ogrenimBilgileri', 'ogrenimBilgileri', 'fas fa-book text-orange', 1, 0, 0, 6, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (150, 'Birim Sayfaları', 'birimSayfalari', 'birimSayfalari', 'fas fa-file-alt text-green', 1, 153, 0, 5, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (151, 'Duyurular', 'duyurular', 'duyurular', 'fas fa-bullhorn text-yellow', 1, 153, 0, 1, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (152, 'Manşetler', 'slaytlar', 'slaytlar', 'fas fa-pager text-blue', 1, 153, 0, 1, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (153, 'Birim Sayfaları', NULL, NULL, 'fas fa-file-alt text-red', 1, 0, 1, 5, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (154, 'Genel Ayarlar', 'genelAyarlar', 'genelAyarlar', 'fas fa-cog', 1, 153, 0, 2, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (155, 'Etkinlikler', 'etkinlikler', 'etkinlikler', 'fas fa-calendar-alt text-blue', 1, 153, 0, 1, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (156, 'Panel Çevirileri', 'panelCevirileri', 'panelCevirileri', 'fas fa-language text-green', 1, 0, 0, 1, 0, 0, NULL, NULL, NULL);
INSERT INTO `tb_modul` VALUES (157, 'Web Çevirileri', 'webCevirileri', 'webCevirileri', 'fas fa-language text-orange', 1, 0, 0, 1, 0, 0, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for tb_modul_yetki_islemler
-- ----------------------------
DROP TABLE IF EXISTS `tb_modul_yetki_islemler`;
CREATE TABLE `tb_modul_yetki_islemler`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `modul_id` int NULL DEFAULT NULL,
  `yetki_islem_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 919 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_modul_yetki_islemler
-- ----------------------------
INSERT INTO `tb_modul_yetki_islemler` VALUES (7, 3, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (8, 3, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (9, 3, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (10, 3, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (11, 3, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (12, 3, 15);
INSERT INTO `tb_modul_yetki_islemler` VALUES (13, 32, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (14, 32, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (15, 32, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (16, 32, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (17, 32, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (46, 53, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (47, 53, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (48, 53, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (49, 53, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (50, 53, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (51, 54, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (52, 54, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (53, 54, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (54, 54, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (55, 54, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (56, 55, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (57, 55, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (58, 55, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (59, 55, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (60, 55, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (61, 56, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (62, 56, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (63, 56, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (64, 56, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (65, 56, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (66, 57, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (67, 57, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (68, 57, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (69, 57, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (70, 57, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (71, 58, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (72, 58, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (73, 58, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (74, 58, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (75, 58, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (76, 59, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (77, 59, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (78, 59, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (79, 59, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (80, 59, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (81, 60, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (82, 60, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (83, 60, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (84, 60, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (85, 60, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (86, 61, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (87, 61, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (88, 61, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (89, 61, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (90, 61, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (91, 62, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (92, 62, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (93, 62, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (94, 62, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (95, 62, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (114, 1, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (115, 1, 32);
INSERT INTO `tb_modul_yetki_islemler` VALUES (378, 70, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (379, 70, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (380, 70, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (381, 70, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (382, 70, 32);
INSERT INTO `tb_modul_yetki_islemler` VALUES (383, 70, 36);
INSERT INTO `tb_modul_yetki_islemler` VALUES (384, 2, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (385, 2, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (386, 2, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (387, 2, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (388, 2, 11);
INSERT INTO `tb_modul_yetki_islemler` VALUES (389, 2, 12);
INSERT INTO `tb_modul_yetki_islemler` VALUES (390, 2, 15);
INSERT INTO `tb_modul_yetki_islemler` VALUES (391, 49, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (392, 49, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (393, 49, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (394, 49, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (456, 63, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (457, 63, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (458, 63, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (459, 63, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (460, 63, 23);
INSERT INTO `tb_modul_yetki_islemler` VALUES (461, 63, 32);
INSERT INTO `tb_modul_yetki_islemler` VALUES (462, 63, 35);
INSERT INTO `tb_modul_yetki_islemler` VALUES (463, 63, 36);
INSERT INTO `tb_modul_yetki_islemler` VALUES (577, 65, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (578, 65, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (579, 65, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (580, 65, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (581, 65, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (582, 65, 6);
INSERT INTO `tb_modul_yetki_islemler` VALUES (583, 65, 32);
INSERT INTO `tb_modul_yetki_islemler` VALUES (584, 65, 36);
INSERT INTO `tb_modul_yetki_islemler` VALUES (585, 66, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (586, 66, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (587, 66, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (588, 66, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (589, 66, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (590, 66, 32);
INSERT INTO `tb_modul_yetki_islemler` VALUES (591, 66, 36);
INSERT INTO `tb_modul_yetki_islemler` VALUES (592, 51, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (593, 51, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (594, 51, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (595, 51, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (596, 51, 23);
INSERT INTO `tb_modul_yetki_islemler` VALUES (597, 51, 24);
INSERT INTO `tb_modul_yetki_islemler` VALUES (598, 51, 25);
INSERT INTO `tb_modul_yetki_islemler` VALUES (599, 51, 26);
INSERT INTO `tb_modul_yetki_islemler` VALUES (600, 51, 27);
INSERT INTO `tb_modul_yetki_islemler` VALUES (601, 51, 29);
INSERT INTO `tb_modul_yetki_islemler` VALUES (602, 51, 30);
INSERT INTO `tb_modul_yetki_islemler` VALUES (603, 51, 31);
INSERT INTO `tb_modul_yetki_islemler` VALUES (604, 51, 32);
INSERT INTO `tb_modul_yetki_islemler` VALUES (605, 51, 33);
INSERT INTO `tb_modul_yetki_islemler` VALUES (606, 51, 34);
INSERT INTO `tb_modul_yetki_islemler` VALUES (607, 51, 35);
INSERT INTO `tb_modul_yetki_islemler` VALUES (608, 51, 36);
INSERT INTO `tb_modul_yetki_islemler` VALUES (609, 51, 38);
INSERT INTO `tb_modul_yetki_islemler` VALUES (610, 51, 41);
INSERT INTO `tb_modul_yetki_islemler` VALUES (611, 52, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (612, 52, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (613, 52, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (614, 52, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (615, 52, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (616, 52, 26);
INSERT INTO `tb_modul_yetki_islemler` VALUES (617, 52, 29);
INSERT INTO `tb_modul_yetki_islemler` VALUES (618, 52, 41);
INSERT INTO `tb_modul_yetki_islemler` VALUES (619, 48, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (620, 48, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (621, 48, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (622, 48, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (623, 48, 6);
INSERT INTO `tb_modul_yetki_islemler` VALUES (624, 48, 23);
INSERT INTO `tb_modul_yetki_islemler` VALUES (625, 48, 24);
INSERT INTO `tb_modul_yetki_islemler` VALUES (626, 48, 26);
INSERT INTO `tb_modul_yetki_islemler` VALUES (627, 48, 27);
INSERT INTO `tb_modul_yetki_islemler` VALUES (628, 48, 28);
INSERT INTO `tb_modul_yetki_islemler` VALUES (629, 48, 29);
INSERT INTO `tb_modul_yetki_islemler` VALUES (630, 48, 30);
INSERT INTO `tb_modul_yetki_islemler` VALUES (631, 48, 31);
INSERT INTO `tb_modul_yetki_islemler` VALUES (632, 48, 32);
INSERT INTO `tb_modul_yetki_islemler` VALUES (633, 48, 33);
INSERT INTO `tb_modul_yetki_islemler` VALUES (634, 48, 34);
INSERT INTO `tb_modul_yetki_islemler` VALUES (635, 48, 35);
INSERT INTO `tb_modul_yetki_islemler` VALUES (636, 48, 36);
INSERT INTO `tb_modul_yetki_islemler` VALUES (637, 48, 38);
INSERT INTO `tb_modul_yetki_islemler` VALUES (638, 48, 39);
INSERT INTO `tb_modul_yetki_islemler` VALUES (639, 48, 40);
INSERT INTO `tb_modul_yetki_islemler` VALUES (640, 48, 41);
INSERT INTO `tb_modul_yetki_islemler` VALUES (641, 71, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (642, 71, 32);
INSERT INTO `tb_modul_yetki_islemler` VALUES (643, 72, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (644, 72, 32);
INSERT INTO `tb_modul_yetki_islemler` VALUES (647, 50, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (648, 50, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (649, 50, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (650, 50, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (651, 50, 23);
INSERT INTO `tb_modul_yetki_islemler` VALUES (652, 50, 24);
INSERT INTO `tb_modul_yetki_islemler` VALUES (653, 50, 25);
INSERT INTO `tb_modul_yetki_islemler` VALUES (654, 50, 26);
INSERT INTO `tb_modul_yetki_islemler` VALUES (655, 50, 27);
INSERT INTO `tb_modul_yetki_islemler` VALUES (656, 50, 29);
INSERT INTO `tb_modul_yetki_islemler` VALUES (657, 50, 30);
INSERT INTO `tb_modul_yetki_islemler` VALUES (658, 50, 31);
INSERT INTO `tb_modul_yetki_islemler` VALUES (659, 50, 32);
INSERT INTO `tb_modul_yetki_islemler` VALUES (660, 50, 33);
INSERT INTO `tb_modul_yetki_islemler` VALUES (661, 50, 34);
INSERT INTO `tb_modul_yetki_islemler` VALUES (662, 69, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (663, 69, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (664, 69, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (665, 69, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (666, 69, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (667, 69, 6);
INSERT INTO `tb_modul_yetki_islemler` VALUES (668, 69, 23);
INSERT INTO `tb_modul_yetki_islemler` VALUES (669, 69, 25);
INSERT INTO `tb_modul_yetki_islemler` VALUES (670, 69, 32);
INSERT INTO `tb_modul_yetki_islemler` VALUES (671, 69, 33);
INSERT INTO `tb_modul_yetki_islemler` VALUES (672, 69, 34);
INSERT INTO `tb_modul_yetki_islemler` VALUES (673, 69, 35);
INSERT INTO `tb_modul_yetki_islemler` VALUES (674, 69, 38);
INSERT INTO `tb_modul_yetki_islemler` VALUES (675, 69, 39);
INSERT INTO `tb_modul_yetki_islemler` VALUES (676, 69, 40);
INSERT INTO `tb_modul_yetki_islemler` VALUES (681, 73, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (682, 73, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (683, 73, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (684, 73, 23);
INSERT INTO `tb_modul_yetki_islemler` VALUES (685, 73, 26);
INSERT INTO `tb_modul_yetki_islemler` VALUES (686, 73, 32);
INSERT INTO `tb_modul_yetki_islemler` VALUES (687, 73, 41);
INSERT INTO `tb_modul_yetki_islemler` VALUES (708, 77, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (709, 77, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (710, 77, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (711, 77, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (712, 77, 32);
INSERT INTO `tb_modul_yetki_islemler` VALUES (713, 77, 34);
INSERT INTO `tb_modul_yetki_islemler` VALUES (714, 77, 35);
INSERT INTO `tb_modul_yetki_islemler` VALUES (715, 74, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (716, 74, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (717, 74, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (718, 74, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (719, 74, 32);
INSERT INTO `tb_modul_yetki_islemler` VALUES (720, 74, 35);
INSERT INTO `tb_modul_yetki_islemler` VALUES (721, 74, 36);
INSERT INTO `tb_modul_yetki_islemler` VALUES (722, 75, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (723, 75, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (724, 75, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (725, 75, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (726, 75, 23);
INSERT INTO `tb_modul_yetki_islemler` VALUES (727, 75, 32);
INSERT INTO `tb_modul_yetki_islemler` VALUES (728, 75, 35);
INSERT INTO `tb_modul_yetki_islemler` VALUES (729, 75, 36);
INSERT INTO `tb_modul_yetki_islemler` VALUES (730, 78, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (731, 78, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (732, 78, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (733, 78, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (734, 78, 23);
INSERT INTO `tb_modul_yetki_islemler` VALUES (735, 78, 32);
INSERT INTO `tb_modul_yetki_islemler` VALUES (736, 78, 35);
INSERT INTO `tb_modul_yetki_islemler` VALUES (737, 78, 36);
INSERT INTO `tb_modul_yetki_islemler` VALUES (738, 76, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (739, 76, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (740, 76, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (741, 76, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (742, 76, 23);
INSERT INTO `tb_modul_yetki_islemler` VALUES (743, 76, 32);
INSERT INTO `tb_modul_yetki_islemler` VALUES (744, 76, 35);
INSERT INTO `tb_modul_yetki_islemler` VALUES (745, 76, 36);
INSERT INTO `tb_modul_yetki_islemler` VALUES (746, 80, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (747, 80, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (748, 80, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (749, 80, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (750, 80, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (755, 92, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (756, 92, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (757, 92, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (758, 92, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (759, 92, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (760, 91, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (761, 91, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (762, 91, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (763, 91, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (764, 91, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (765, 86, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (766, 86, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (767, 86, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (768, 86, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (769, 86, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (770, 87, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (771, 87, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (772, 87, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (773, 87, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (774, 87, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (775, 98, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (776, 98, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (777, 98, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (778, 98, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (779, 98, 6);
INSERT INTO `tb_modul_yetki_islemler` VALUES (780, 98, 23);
INSERT INTO `tb_modul_yetki_islemler` VALUES (841, 139, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (842, 139, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (843, 139, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (844, 139, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (845, 139, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (846, 139, 47);
INSERT INTO `tb_modul_yetki_islemler` VALUES (847, 139, 48);
INSERT INTO `tb_modul_yetki_islemler` VALUES (848, 139, 50);
INSERT INTO `tb_modul_yetki_islemler` VALUES (849, 139, 51);
INSERT INTO `tb_modul_yetki_islemler` VALUES (850, 139, 52);
INSERT INTO `tb_modul_yetki_islemler` VALUES (851, 139, 53);
INSERT INTO `tb_modul_yetki_islemler` VALUES (852, 139, 54);
INSERT INTO `tb_modul_yetki_islemler` VALUES (853, 139, 55);
INSERT INTO `tb_modul_yetki_islemler` VALUES (854, 139, 56);
INSERT INTO `tb_modul_yetki_islemler` VALUES (855, 0, 54);
INSERT INTO `tb_modul_yetki_islemler` VALUES (856, 133, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (857, 133, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (858, 133, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (859, 133, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (860, 133, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (861, 133, 44);
INSERT INTO `tb_modul_yetki_islemler` VALUES (862, 133, 54);
INSERT INTO `tb_modul_yetki_islemler` VALUES (863, 137, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (864, 137, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (865, 137, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (866, 137, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (867, 137, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (868, 137, 47);
INSERT INTO `tb_modul_yetki_islemler` VALUES (869, 137, 48);
INSERT INTO `tb_modul_yetki_islemler` VALUES (870, 117, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (871, 117, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (872, 117, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (873, 117, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (874, 117, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (875, 141, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (876, 140, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (877, 145, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (878, 145, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (879, 147, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (880, 147, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (881, 147, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (882, 147, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (883, 147, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (884, 147, 6);
INSERT INTO `tb_modul_yetki_islemler` VALUES (885, 148, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (886, 148, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (887, 148, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (888, 148, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (889, 148, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (890, 149, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (891, 149, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (892, 149, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (893, 149, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (894, 149, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (895, 146, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (896, 146, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (897, 146, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (898, 146, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (899, 146, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (900, 144, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (901, 144, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (902, 144, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (903, 144, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (904, 144, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (905, 144, 49);
INSERT INTO `tb_modul_yetki_islemler` VALUES (906, 144, 53);
INSERT INTO `tb_modul_yetki_islemler` VALUES (907, 144, 54);
INSERT INTO `tb_modul_yetki_islemler` VALUES (908, 144, 55);
INSERT INTO `tb_modul_yetki_islemler` VALUES (909, 144, 56);
INSERT INTO `tb_modul_yetki_islemler` VALUES (910, 143, 1);
INSERT INTO `tb_modul_yetki_islemler` VALUES (911, 143, 2);
INSERT INTO `tb_modul_yetki_islemler` VALUES (912, 143, 3);
INSERT INTO `tb_modul_yetki_islemler` VALUES (913, 143, 4);
INSERT INTO `tb_modul_yetki_islemler` VALUES (914, 143, 5);
INSERT INTO `tb_modul_yetki_islemler` VALUES (915, 143, 53);
INSERT INTO `tb_modul_yetki_islemler` VALUES (916, 143, 54);
INSERT INTO `tb_modul_yetki_islemler` VALUES (917, 143, 55);
INSERT INTO `tb_modul_yetki_islemler` VALUES (918, 143, 56);

-- ----------------------------
-- Table structure for tb_mufredat
-- ----------------------------
DROP TABLE IF EXISTS `tb_mufredat`;
CREATE TABLE `tb_mufredat`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ust_id` int NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `ders_yili_donem_id` int NULL DEFAULT NULL,
  `program_id` int NULL DEFAULT NULL,
  `ders_id` int NULL DEFAULT NULL,
  `ogretim_elemani_id` int NULL DEFAULT NULL,
  `ogrenim_hedefi_mi` tinyint NULL DEFAULT NULL,
  `kategori` tinyint NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_mufredat
-- ----------------------------
INSERT INTO `tb_mufredat` VALUES (1, 0, 'Ders Kategori', 1, 1, 1, NULL, NULL, 1);
INSERT INTO `tb_mufredat` VALUES (2, 1, '1. Alt Kategori', 1, 1, 1, NULL, NULL, 1);
INSERT INTO `tb_mufredat` VALUES (3, 2, '1. Alt Alt Kategori', 1, 1, 1, NULL, NULL, 1);
INSERT INTO `tb_mufredat` VALUES (4, 3, '1. Alt Alt Alt Kategori', 1, 1, 1, NULL, NULL, 1);
INSERT INTO `tb_mufredat` VALUES (5, 4, 'Öğrenim Hedefi 1', 1, 1, 1, NULL, NULL, 0);
INSERT INTO `tb_mufredat` VALUES (7, 4, 'Öğrenim Hedefi 2', 1, 1, 1, NULL, NULL, 0);
INSERT INTO `tb_mufredat` VALUES (8, 4, 'Öğrenim Hedefi 3', 1, 1, 1, NULL, NULL, 0);
INSERT INTO `tb_mufredat` VALUES (9, 4, 'Öğrenim Hedefi 4', 1, 1, 1, NULL, NULL, 0);
INSERT INTO `tb_mufredat` VALUES (10, 3, '2. Alt Alt Alt Kategori', 1, 1, 1, NULL, NULL, 1);
INSERT INTO `tb_mufredat` VALUES (11, 3, '3. Alt Alt Alt Kategori', 1, 1, 1, NULL, NULL, 1);
INSERT INTO `tb_mufredat` VALUES (12, 10, 'Öğrenim Hedefi 1', 1, 1, 1, NULL, NULL, 0);
INSERT INTO `tb_mufredat` VALUES (13, 10, 'Öğrenim Hedefi 2', 1, 1, 1, NULL, NULL, 0);
INSERT INTO `tb_mufredat` VALUES (14, 10, 'Öğrenim Hedefi 3', 1, 1, 1, NULL, NULL, 0);
INSERT INTO `tb_mufredat` VALUES (15, 10, 'Öğrenim Hedefi 4', 1, 1, 1, NULL, NULL, 0);
INSERT INTO `tb_mufredat` VALUES (16, 10, 'Öğrenim Hedefi 5', 1, 1, 1, NULL, NULL, 0);
INSERT INTO `tb_mufredat` VALUES (17, 11, 'Öğrenim Hedefi 1', 1, 1, 1, NULL, NULL, 0);
INSERT INTO `tb_mufredat` VALUES (18, 11, 'Öğrenim Hedefi 2', 1, 1, 1, NULL, NULL, 0);
INSERT INTO `tb_mufredat` VALUES (19, 11, 'Öğrenim Hedefi 3', 1, 1, 1, NULL, NULL, 0);
INSERT INTO `tb_mufredat` VALUES (21, 0, 'Ders Kategori', 1, 1, 2, NULL, NULL, 1);
INSERT INTO `tb_mufredat` VALUES (22, 21, '1. Alt Kategori', 1, 1, 2, NULL, NULL, 1);
INSERT INTO `tb_mufredat` VALUES (23, 22, '1 Alt Alt Kategori', 1, 1, 2, NULL, NULL, 1);
INSERT INTO `tb_mufredat` VALUES (24, 23, '1. Alt Alt Alt Kategori', 1, 1, 2, NULL, NULL, 1);
INSERT INTO `tb_mufredat` VALUES (25, 24, 'Öğrenim Hedefi', 1, 1, 2, NULL, NULL, 0);
INSERT INTO `tb_mufredat` VALUES (26, 24, 'Öğrenim Hedefi', 1, 1, 2, NULL, NULL, 0);
INSERT INTO `tb_mufredat` VALUES (27, 24, 'Öğrenim Hedefi', 1, 1, 2, NULL, NULL, 0);
INSERT INTO `tb_mufredat` VALUES (28, 24, 'Öğrenim Hedefi', 1, 1, 2, NULL, NULL, 0);
INSERT INTO `tb_mufredat` VALUES (29, 1, '2. Alt Kategori', 1, 1, 1, NULL, NULL, 1);
INSERT INTO `tb_mufredat` VALUES (30, 0, '1. Ders Kategori', 1, 1, 14, NULL, NULL, 1);
INSERT INTO `tb_mufredat` VALUES (31, 29, '1. Alt Alt Kategori', 1, 1, 1, NULL, NULL, 1);
INSERT INTO `tb_mufredat` VALUES (32, 31, '1. Alt Alt Alt Kategori', 1, 1, 1, NULL, NULL, 1);
INSERT INTO `tb_mufredat` VALUES (33, 31, '2. Alt Alt Alt Kategori', 1, 1, 1, NULL, NULL, 1);
INSERT INTO `tb_mufredat` VALUES (34, 31, '3. Alt Alt Alt kategori', 1, 1, 1, NULL, NULL, 0);
INSERT INTO `tb_mufredat` VALUES (35, 1, '3. Alt Kategori', 1, 1, 1, NULL, NULL, 1);
INSERT INTO `tb_mufredat` VALUES (36, 2, '2. Alt Alt Kategori', 1, 1, 1, NULL, NULL, 1);
INSERT INTO `tb_mufredat` VALUES (37, 0, 'Kategori', 1, 1, 14, 21, NULL, 1);
INSERT INTO `tb_mufredat` VALUES (38, 37, 'Alt Kategori', 1, 1, 14, 21, NULL, 1);
INSERT INTO `tb_mufredat` VALUES (39, 0, 'sdfsdf', 1, 1, NULL, NULL, NULL, 1);

-- ----------------------------
-- Table structure for tb_ogrenciler
-- ----------------------------
DROP TABLE IF EXISTS `tb_ogrenciler`;
CREATE TABLE `tb_ogrenciler`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `universite_id` int NULL DEFAULT NULL,
  `fakulte_id` int NULL DEFAULT NULL,
  `bolum_id` int NULL DEFAULT NULL,
  `program_id` int NULL DEFAULT NULL,
  `tc_kimlik_no` varchar(11) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `ogrenci_no` varchar(50) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `adi` varchar(100) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `soyadi` varchar(100) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `sinif` tinyint NULL DEFAULT NULL,
  `kayit_yili` year NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `sifre` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `resim` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `rol_id` int UNSIGNED NULL DEFAULT 14,
  `super` tinyint NULL DEFAULT 0,
  `cep_tel` varchar(50) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `adres` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `kullanici_turu` varchar(25) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL DEFAULT 'ogrenci',
  `aktif` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 132 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_ogrenciler
-- ----------------------------
INSERT INTO `tb_ogrenciler` VALUES (1, 1, 1, 1, 1, '', '17060001008', 'Şeyma Nur', 'ERÇİN', NULL, NULL, '2@gmail.com', '4297f44b13955235245b2497399d7a93', NULL, 14, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (2, 1, 1, 1, 1, '', '17060001009', 'Oğulcan', 'AKÇAY', NULL, NULL, '3@gmail.com', '4297f44b13955235245b2497399d7a93', NULL, 14, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (3, 1, 1, 1, 1, '', '17060001010', 'Azad', 'ZENGİN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (4, 1, 1, 1, 1, '', '17060001011', 'Ferhat', 'BUCAĞA', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (5, 1, 1, 1, 1, '', '17060001012', 'Ayşenur', 'ALMA', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (6, 1, 1, 1, 1, '', '17060001013', 'Erkan', 'BAĞTAŞ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (7, 1, 1, 1, 1, '', '17060001014', 'Berçem Fatma', 'YILDIZ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (8, 1, 1, 1, 1, '', '17060001015', 'Musa', 'İNCEER', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (9, 1, 1, 1, 1, '', '17060001016', 'Fatma Betül', 'UĞURLU', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (10, 1, 1, 1, 1, '', '17060001017', 'Elif Sümeyya', 'AKSÖZ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (11, 1, 1, 1, 1, '', '17060001018', 'Hasan', 'SÖNMEZ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (12, 1, 1, 1, 1, '', '17060001019', 'Sözdar', 'CİHAN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (13, 1, 1, 1, 1, '', '17060001020', 'Muhammed', 'ERTAŞ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (14, 1, 1, 1, 1, '', '17060001022', 'Ömer', 'BEKİ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (15, 1, 1, 1, 1, '', '17060001023', 'Onur', 'DEMİR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (16, 1, 1, 1, 1, '', '17060001024', 'Neslihan', 'DİZMAN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (17, 1, 1, 1, 1, '', '17060001025', 'Taha Miraç', 'GÜNEŞ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (18, 1, 1, 1, 1, '', '17060001026', 'Cevdet', 'ŞEYLAN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (19, 1, 1, 1, 1, '', '17060001027', 'Tekin', 'TÜRKER', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (20, 1, 1, 1, 1, '', '17060001028', 'Meryem', 'ERŞEN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (21, 1, 1, 1, 1, '', '17060001029', 'Dudu', 'ÇEKİCİ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (22, 1, 1, 1, 1, '', '17060001031', 'Şehnaz', 'DOĞAN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (23, 1, 1, 1, 1, '', '17060001035', 'Mehmet', 'ALTUN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (24, 1, 1, 1, 1, '', '17060001036', 'Elif Berfin', 'KÖKLİ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (25, 1, 1, 1, 1, '', '17060001037', 'Kadir', 'KALAÇ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (26, 1, 1, 1, 1, '', '17060001038', 'Yunus', 'KAYA', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (27, 1, 1, 1, 1, '', '17060001039', 'Zelal', 'YAYLA', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (28, 1, 1, 1, 1, '', '17060001040', 'Veysel Karani', 'ŞAHİN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (29, 1, 1, 1, 1, '', '17060001041', 'Burhan', 'KIZILTAŞ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (30, 1, 1, 1, 1, '', '17060001043', 'İbrahim', 'ÇOBANOĞLU', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (31, 1, 1, 1, 1, '', '17060001047', 'Özcan', 'DAYAN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (32, 1, 1, 1, 1, '', '17060001048', 'Vedat', 'KAVAK', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (33, 1, 1, 1, 1, '', '17060001051', 'Mert', 'KARTAL', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (34, 1, 1, 1, 1, '', '17060001053', 'Evin', 'BÖLER', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (35, 1, 1, 1, 1, '', '17060001054', 'Beyza', 'TUR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (36, 1, 1, 1, 1, '', '17060001055', 'Mizgin', 'BOZKURT', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (37, 1, 1, 1, 1, '', '17060001057', 'Naz Neval', 'ERTAŞ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (38, 1, 1, 1, 1, '', '17060001058', 'Yasin', 'DENİZ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (39, 1, 1, 1, 1, '', '17060001060', 'Ahmet', 'KOÇAK', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (40, 1, 1, 1, 1, '', '17060001062', 'Emine', 'KIZILDEMİR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (41, 1, 1, 1, 1, '', '17060001063', 'Arif', 'GÖKDERE', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (42, 1, 1, 1, 1, '', '17060001065', 'Hüseyin Harun', 'KADIRHAN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (43, 1, 1, 1, 1, '', '17060001066', 'Diyar', 'VARIŞLI', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (44, 1, 1, 1, 1, '', '17060001067', 'Yüksel', 'METİN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (45, 1, 1, 1, 1, '', '17060001069', 'Fatma', 'YUTAR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (46, 1, 1, 1, 1, '', '17060001072', 'İbrahim Halil', 'ERZEN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (47, 1, 1, 1, 1, '', '17060001073', 'Mehmet Barsim', 'BOĞATEKİN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (48, 1, 1, 1, 1, '', '17060001074', 'Tuğba', 'ATLAM', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (49, 1, 1, 1, 1, '', '17060001075', 'Adem', 'KARAMAN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (50, 1, 1, 1, 1, '', '17060001078', 'Bedirhan', 'ERDAL', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (51, 1, 1, 1, 1, '', '17060001079', 'Cihat', 'SEVİNÇ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (52, 1, 1, 1, 1, '', '17060001080', 'Nurşen', 'CENGİZ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (53, 1, 1, 1, 1, '', '17060001081', 'Ahmet Alperen', 'BAYRAM', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (54, 1, 1, 1, 1, '', '17060001082', 'Yasemin', 'TUNÇAY', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (55, 1, 1, 1, 1, '', '17060001087', 'İsmail', 'ERDOĞAN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (56, 1, 1, 1, 1, '', '17060001088', 'Afşin', 'DUMAN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (57, 1, 1, 1, 1, '', '17060001090', 'Cennet', 'ÖZTÜRK', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (58, 1, 1, 1, 1, '', '17060001091', 'Mesut', 'GÜLER', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (59, 1, 1, 1, 1, '', '17060001093', 'Mustafa', 'GÜVEN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (60, 1, 1, 1, 1, '', '17060001094', 'Veysel', 'GÜR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (61, 1, 1, 1, 1, '', '17060001095', 'Zafer', 'KATAR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (62, 1, 1, 1, 1, '', '17060001096', 'Gamze', 'AĞCA', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (63, 1, 1, 1, 1, '', '17060001098', 'Saliha Nihan', 'ÜRKMEZ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (64, 1, 1, 1, 1, '', '17060001099', 'Eda', 'AYDIN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (65, 1, 1, 1, 1, '', '17060001101', 'Murat', 'AKSOY', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (66, 1, 1, 1, 1, '', '17060001102', 'Pelin', 'UNUL', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (67, 1, 1, 1, 1, '', '17060001109', 'Ezgi', 'CESUR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (68, 1, 1, 1, 1, '', '17060001111', 'Batuhan', 'BAYKUŞ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (69, 1, 1, 1, 1, '', '17060001112', 'Serhat', 'UYGUR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (70, 1, 1, 1, 1, '', '17060001113', 'Muhammed', 'AYDIN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (71, 1, 1, 1, 1, '', '17060001116', 'Nefise', 'AYDEMİR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (72, 1, 1, 1, 1, '', '17060001118', 'Fatmanur', 'MİRBEY', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (73, 1, 1, 1, 1, '', '17060001119', 'Gönül Aslı', 'CAN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (74, 1, 1, 1, 1, '', '17060001120', 'Ömer Faruk', 'YUNAR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (75, 1, 1, 1, 1, '', '17060001121', 'Zehra', 'HANBABA', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (76, 1, 1, 1, 1, '', '17060001124', 'Ümmügülsüm', 'GÜRAY', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (77, 1, 1, 1, 1, '', '17060001125', 'Betül', 'AYÇİÇEK', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (78, 1, 1, 1, 1, '', '17060001127', 'Çağdaş', 'DİLEKCİ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (79, 1, 1, 1, 1, '', '17060001130', 'Arzu', 'DEMİRTAŞ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (80, 1, 1, 1, 1, '', '17060001131', 'Sümeyye Nur', 'ÖNER', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (81, 1, 1, 1, 1, '', '17060001134', 'Hasret', 'BULUT', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (82, 1, 1, 1, 1, '', '17060001135', 'Esra', 'DEĞER', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (83, 1, 1, 1, 1, '', '17060001137', 'Melike', 'KARA', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (84, 1, 1, 1, 1, '', '17060001138', 'Mücahit', 'ÇALIŞKAN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (85, 1, 1, 1, 1, '', '17060001139', 'Fehime', 'KURT', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (86, 1, 1, 1, 1, '', '17060001143', 'Ümran', 'YAZAR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (87, 1, 1, 1, 1, '', '17060001144', 'Saruhan Fikri', 'AYDIN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (88, 1, 1, 1, 1, '', '17060001147', 'Nursena', 'KARABULUT', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (89, 1, 1, 1, 1, '', '17060001148', 'Gurbet', 'KARABAŞ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (90, 1, 1, 1, 1, '', '17060001149', 'Melek', 'DEMİR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (91, 1, 1, 1, 1, '', '17060001150', 'Beyza', 'ÖZDEMİR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (92, 1, 1, 1, 1, '', '17060001129', 'Beyzanur', 'EYVAZ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (93, 1, 1, 1, 1, '', '17060001151', 'Emine Şevval', 'YILMAZ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (94, 1, 1, 1, 1, '', '17060001153', 'Muhammed Hamza', 'YAZÇİÇEK', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (95, 1, 1, 1, 1, '', '17060001162', 'Ahmet Sait', 'AĞIRTAŞ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (96, 1, 1, 1, 1, '', '17060001165', 'Ahmed.M.Y.', 'SAIDAM', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (97, 1, 1, 1, 1, '', '17060001171', 'Serkan', 'CEYLAN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (98, 1, 1, 1, 1, '', '16060001006', 'Deniz', 'YAŞAR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (99, 1, 1, 1, 1, '', '16060001011', 'Şahin', 'YAŞAR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (100, 1, 1, 1, 1, '', '16060001021', 'Mehmet Emin', 'ÇAKIR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (101, 1, 1, 1, 1, '', '16060001024', 'Rojin', 'KIZILAY', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (102, 1, 1, 1, 1, '', '16060001028', 'Melek', 'KAYA', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (103, 1, 1, 1, 1, '', '16060001045', 'Baran', 'DAKMAN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (104, 1, 1, 1, 1, '', '16060001060', 'Mehmet Ali', 'SEÇMEN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (105, 1, 1, 1, 1, '', '16060001071', 'Berivan İdil', 'ABİ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (106, 1, 1, 1, 1, '', '16060001088', 'Dilek', 'AFERİN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (107, 1, 1, 1, 1, '', '16060001104', 'Ali', 'EROĞULLARI', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (108, 1, 1, 1, 1, '', '16060001129', 'Mevlüt Özgür', 'ACAR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (109, 1, 1, 1, 1, '', '16060001151', 'Mohamad', 'ALHAMDO', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (110, 1, 1, 1, 1, '', '15060001133', 'Abdulsamet', 'BEŞKARDEŞ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (111, 1, 1, 1, 1, '', '14060001069', 'İbrahim', 'GÜLTEKİN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (112, 1, 1, 1, 1, '', '14060001135', 'Nail', 'BEYAZIT', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (113, 1, 1, 1, 1, '', '19060001152', 'Elif', 'AVA', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (114, 1, 1, 1, 1, '', '19060001153', 'Barış', 'TUNÇ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (115, 1, 1, 1, 1, '', '19060001162', 'Neslihan', 'ARSLAN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (116, 1, 1, 1, 1, '', '20060001152', 'Yasemin', 'ÖZMEN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (117, 1, 1, 1, 1, '', '20060001153', 'Abdullah Harun', 'YILMAZ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (118, 1, 1, 1, 1, '', '21060001170', 'Hakan', 'BAYRAM', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (119, 1, 1, 1, 1, '', '16060001061', 'Fulya', 'ŞAHİN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (120, 1, 1, 1, 1, '', '16060001080', 'Ramazan', 'YALMAÇ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (121, 1, 1, 1, 1, '', '15060001059', 'Dıjvar', 'DENLİ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (122, 1, 1, 1, 1, '', '14060001130', 'Gülezgi', 'KAYAR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (123, 1, 1, 1, 1, '', '13060001135', 'Muhammed', 'FATİH', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (124, 1, 1, 1, 1, '', '16060001121', 'Furkan Kağan', 'DALDABAN', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (125, 1, 1, 1, 1, '', '20060001007', 'Muhammed Enes', 'UÇAR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (126, 1, 1, 1, 1, '', '20060001002', 'Dilara', 'AVCI', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (127, 1, 1, 1, 1, '', '16060001119', 'Ömer', 'KUTLU', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (128, 1, 1, 1, 1, '', '16060001013', 'Abdullah', 'SEVAL', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (129, 1, 1, 1, 1, '', '14060001140', 'M.Kasım', 'ÇAKILLIKOYAK', NULL, NULL, '1@gmail.com', '4297f44b13955235245b2497399d7a93', NULL, 14, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (130, 1, 1, 1, 1, '', '15060001168', 'Mehmet', 'YAZAR', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'ogrenci', 1);
INSERT INTO `tb_ogrenciler` VALUES (131, 1, 1, 1, 1, '13337993570', '16060001081', 'Öğrenci', 'Profili', 11, 2021, 'resul.evis@gmail.com', '4297f44b13955235245b2497399d7a93', NULL, 14, 0, '5366373523', 'Seyrantepe Mah. Van', 'ogrenci', 1);

-- ----------------------------
-- Table structure for tb_ogretim_elemanlari
-- ----------------------------
DROP TABLE IF EXISTS `tb_ogretim_elemanlari`;
CREATE TABLE `tb_ogretim_elemanlari`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `universite_id` int NULL DEFAULT NULL,
  `fakulte_id` int NULL DEFAULT NULL,
  `anabilim_dali_id` int NULL DEFAULT NULL,
  `tc_kimlik_no` varchar(11) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `unvan_id` int NULL DEFAULT NULL,
  `adi` varchar(100) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `soyadi` varchar(100) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `cep_tel` varchar(50) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `sifre` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `resim` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `rol_id` int NULL DEFAULT 15,
  `super` tinyint NULL DEFAULT 0,
  `kullanici_turu` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT 'ogretmen',
  `aktif` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_ogretim_elemanlari
-- ----------------------------
INSERT INTO `tb_ogretim_elemanlari` VALUES (1, 1, 1, 1, NULL, 1, 'Naci', 'GENÇ', NULL, NULL, NULL, NULL, NULL, 0, NULL, 1);
INSERT INTO `tb_ogretim_elemanlari` VALUES (2, 1, 1, 1, NULL, 1, 'H. Eray', 'ÇELİK', NULL, NULL, NULL, NULL, NULL, 0, NULL, 1);
INSERT INTO `tb_ogretim_elemanlari` VALUES (3, 1, 1, 1, NULL, 3, 'Serbest', 'ZİYANAK', NULL, NULL, NULL, NULL, NULL, 0, NULL, 1);

-- ----------------------------
-- Table structure for tb_personel_nitelikleri
-- ----------------------------
DROP TABLE IF EXISTS `tb_personel_nitelikleri`;
CREATE TABLE `tb_personel_nitelikleri`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `sira` int NULL DEFAULT NULL,
  `adi_kz` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `adi_en` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `adi_ru` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_personel_nitelikleri
-- ----------------------------
INSERT INTO `tb_personel_nitelikleri` VALUES (1, 'Akademik Personel', NULL, NULL, NULL, NULL);
INSERT INTO `tb_personel_nitelikleri` VALUES (2, 'İdari Personel', NULL, NULL, NULL, NULL);
INSERT INTO `tb_personel_nitelikleri` VALUES (3, 'Diğer', NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for tb_personel_ogrenim_bilgileri
-- ----------------------------
DROP TABLE IF EXISTS `tb_personel_ogrenim_bilgileri`;
CREATE TABLE `tb_personel_ogrenim_bilgileri`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `personel_id` int NULL DEFAULT NULL,
  `egitim_duzeyi_id` int NULL DEFAULT NULL,
  `universite` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fakulte` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `bolum` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `mezuniyet_yili` year NULL DEFAULT NULL,
  `diploma` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_personel_ogrenim_bilgileri
-- ----------------------------

-- ----------------------------
-- Table structure for tb_personel_turleri
-- ----------------------------
DROP TABLE IF EXISTS `tb_personel_turleri`;
CREATE TABLE `tb_personel_turleri`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `sira` int NULL DEFAULT NULL,
  `adi_kz` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `adi_en` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `adi_ru` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_personel_turleri
-- ----------------------------
INSERT INTO `tb_personel_turleri` VALUES (1, 'Sözleşmeli Personel', NULL, NULL, NULL, NULL);
INSERT INTO `tb_personel_turleri` VALUES (2, 'Kadrolu Personel', NULL, NULL, NULL, NULL);
INSERT INTO `tb_personel_turleri` VALUES (3, 'Kısmi Zamanlı Personel', NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for tb_personeller
-- ----------------------------
DROP TABLE IF EXISTS `tb_personeller`;
CREATE TABLE `tb_personeller`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `in_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `vatandaslik_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `pasaport_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `birim_id` int NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `soyadi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `uyruk_id` int NULL DEFAULT NULL,
  `cinsiyet` tinyint NULL DEFAULT NULL,
  `dogum_tarihi` datetime NULL DEFAULT NULL,
  `kan_grubu_id` int NULL DEFAULT NULL,
  `engel_durumu` tinyint NULL DEFAULT NULL,
  `engel_turu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `personel_turu_id` int NULL DEFAULT NULL COMMENT 'Sözleşmeli,kadrolu,kısmi zamanlı vs.',
  `personel_nitelik_id` int NULL DEFAULT NULL COMMENT 'Akademik-İdari',
  `egitim_duzeyi_id` int NULL DEFAULT NULL,
  `unvan_id` int NULL DEFAULT NULL,
  `ise_baslama_tarihi` datetime NULL DEFAULT NULL,
  `sozlesme_baslama_tarihi` datetime NULL DEFAULT NULL,
  `sozlesme_bitis_tarihi` datetime NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `gsm1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `gsm2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ev_adresi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `is_adresi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `is_telefonu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `arac_plaka` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `medeni_durumu` tinyint NULL DEFAULT NULL,
  `kullanici_turu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'personel',
  `sifre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `aktif` tinyint NULL DEFAULT 1,
  `adi_kz` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `adi_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `adi_ru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `soyadi_kz` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `soyadi_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `soyadi_ru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `engel_turu_kz` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `engel_turu_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `engel_turu_ru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ev_adresi_kz` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `ev_adresi_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `ev_adresi_ru` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `is_adresi_kz` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `is_adresi_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `is_adresi_ru` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_personeller
-- ----------------------------
INSERT INTO `tb_personeller` VALUES (3, '45982964018', '456982964018', '456412222', 192, 'Serbest', 'Ziyanak', 223, 2, '0000-00-00 00:00:00', 1, 1, 'yok', NULL, 1, 5, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'serbest.ziyanak@gmail.com', '5444961144', '5444961144', 'Mağjan 4', 'Ayu kampüs', '5444961144', 'personel_3_64eddb6da478c.jpg', '21HB001', 2, 'personel', NULL, 1, 'Kazakça Serbest', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for tb_programlar
-- ----------------------------
DROP TABLE IF EXISTS `tb_programlar`;
CREATE TABLE `tb_programlar`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `universite_id` int NULL DEFAULT NULL,
  `bolum_id` int NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT '',
  `varsayilan` tinyint NULL DEFAULT 0,
  `aktif` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_programlar
-- ----------------------------
INSERT INTO `tb_programlar` VALUES (1, 1, 1, 'Tıp Lisans', 1, 1);

-- ----------------------------
-- Table structure for tb_rol_yetkiler
-- ----------------------------
DROP TABLE IF EXISTS `tb_rol_yetkiler`;
CREATE TABLE `tb_rol_yetkiler`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `rol_id` int NULL DEFAULT NULL,
  `modul_id` int NULL DEFAULT NULL,
  `islem_turu_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 91 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_rol_yetkiler
-- ----------------------------
INSERT INTO `tb_rol_yetkiler` VALUES (1, 20, 133, 1);
INSERT INTO `tb_rol_yetkiler` VALUES (2, 20, 1, 1);
INSERT INTO `tb_rol_yetkiler` VALUES (4, 20, 2, 1);
INSERT INTO `tb_rol_yetkiler` VALUES (5, 20, 2, 2);
INSERT INTO `tb_rol_yetkiler` VALUES (6, 20, 2, 4);
INSERT INTO `tb_rol_yetkiler` VALUES (7, 20, 2, 5);
INSERT INTO `tb_rol_yetkiler` VALUES (8, 20, 2, 11);
INSERT INTO `tb_rol_yetkiler` VALUES (9, 20, 32, 1);
INSERT INTO `tb_rol_yetkiler` VALUES (10, 20, 32, 2);
INSERT INTO `tb_rol_yetkiler` VALUES (11, 20, 32, 3);
INSERT INTO `tb_rol_yetkiler` VALUES (12, 20, 32, 4);
INSERT INTO `tb_rol_yetkiler` VALUES (13, 20, 32, 5);
INSERT INTO `tb_rol_yetkiler` VALUES (24, 20, 3, 1);
INSERT INTO `tb_rol_yetkiler` VALUES (25, 20, 3, 2);
INSERT INTO `tb_rol_yetkiler` VALUES (26, 20, 3, 3);
INSERT INTO `tb_rol_yetkiler` VALUES (27, 20, 3, 4);
INSERT INTO `tb_rol_yetkiler` VALUES (28, 20, 3, 5);
INSERT INTO `tb_rol_yetkiler` VALUES (58, 15, 139, 1);
INSERT INTO `tb_rol_yetkiler` VALUES (59, 15, 139, 47);
INSERT INTO `tb_rol_yetkiler` VALUES (60, 15, 139, 50);
INSERT INTO `tb_rol_yetkiler` VALUES (61, 15, 139, 53);
INSERT INTO `tb_rol_yetkiler` VALUES (62, 15, 139, 54);
INSERT INTO `tb_rol_yetkiler` VALUES (63, 15, 139, 55);
INSERT INTO `tb_rol_yetkiler` VALUES (64, 15, 139, 56);
INSERT INTO `tb_rol_yetkiler` VALUES (71, 15, 133, 1);
INSERT INTO `tb_rol_yetkiler` VALUES (72, 15, 133, 2);
INSERT INTO `tb_rol_yetkiler` VALUES (73, 15, 133, 3);
INSERT INTO `tb_rol_yetkiler` VALUES (74, 15, 133, 4);
INSERT INTO `tb_rol_yetkiler` VALUES (75, 15, 133, 5);
INSERT INTO `tb_rol_yetkiler` VALUES (76, 15, 133, 44);
INSERT INTO `tb_rol_yetkiler` VALUES (77, 15, 133, 54);
INSERT INTO `tb_rol_yetkiler` VALUES (78, 15, 137, 1);
INSERT INTO `tb_rol_yetkiler` VALUES (79, 15, 137, 3);
INSERT INTO `tb_rol_yetkiler` VALUES (80, 15, 137, 47);
INSERT INTO `tb_rol_yetkiler` VALUES (81, 15, 137, 48);
INSERT INTO `tb_rol_yetkiler` VALUES (82, 15, 117, 1);
INSERT INTO `tb_rol_yetkiler` VALUES (83, 15, 117, 4);
INSERT INTO `tb_rol_yetkiler` VALUES (84, 15, 117, 5);
INSERT INTO `tb_rol_yetkiler` VALUES (85, 14, 141, 1);
INSERT INTO `tb_rol_yetkiler` VALUES (86, 14, 140, 1);
INSERT INTO `tb_rol_yetkiler` VALUES (87, 14, 1, 1);
INSERT INTO `tb_rol_yetkiler` VALUES (88, 14, 145, 1);
INSERT INTO `tb_rol_yetkiler` VALUES (89, 14, 145, 5);
INSERT INTO `tb_rol_yetkiler` VALUES (90, 21, 1, 1);

-- ----------------------------
-- Table structure for tb_rol_yetkili_firmalar
-- ----------------------------
DROP TABLE IF EXISTS `tb_rol_yetkili_firmalar`;
CREATE TABLE `tb_rol_yetkili_firmalar`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `rol_id` int NULL DEFAULT NULL,
  `firma_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = FIXED;

-- ----------------------------
-- Records of tb_rol_yetkili_firmalar
-- ----------------------------
INSERT INTO `tb_rol_yetkili_firmalar` VALUES (18, 2, 4);
INSERT INTO `tb_rol_yetkili_firmalar` VALUES (17, 2, 3);
INSERT INTO `tb_rol_yetkili_firmalar` VALUES (16, 2, 2);
INSERT INTO `tb_rol_yetkili_firmalar` VALUES (8, 8, 1);
INSERT INTO `tb_rol_yetkili_firmalar` VALUES (9, 8, 32);
INSERT INTO `tb_rol_yetkili_firmalar` VALUES (15, 2, 1);

-- ----------------------------
-- Table structure for tb_rol_yetkili_subeler
-- ----------------------------
DROP TABLE IF EXISTS `tb_rol_yetkili_subeler`;
CREATE TABLE `tb_rol_yetkili_subeler`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `rol_id` int NULL DEFAULT NULL,
  `sube_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = FIXED;

-- ----------------------------
-- Records of tb_rol_yetkili_subeler
-- ----------------------------
INSERT INTO `tb_rol_yetkili_subeler` VALUES (11, 14, 2);
INSERT INTO `tb_rol_yetkili_subeler` VALUES (9, 14, 3);

-- ----------------------------
-- Table structure for tb_roller
-- ----------------------------
DROP TABLE IF EXISTS `tb_roller`;
CREATE TABLE `tb_roller`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `varsayilan` tinyint NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_roller
-- ----------------------------
INSERT INTO `tb_roller` VALUES (1, 'Varsayılan', 1);
INSERT INTO `tb_roller` VALUES (14, 'Öğrenci', 1);
INSERT INTO `tb_roller` VALUES (15, 'Öğretmen', 1);
INSERT INTO `tb_roller` VALUES (20, 'Admin', 0);
INSERT INTO `tb_roller` VALUES (21, 'Personel', 0);
INSERT INTO `tb_roller` VALUES (22, 'Öğretim Elemanı', 0);
INSERT INTO `tb_roller` VALUES (23, 'Rektör', 0);

-- ----------------------------
-- Table structure for tb_sinav_bitirenler
-- ----------------------------
DROP TABLE IF EXISTS `tb_sinav_bitirenler`;
CREATE TABLE `tb_sinav_bitirenler`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `sinav_id` int NULL DEFAULT NULL,
  `ogrenci_id` int NULL DEFAULT NULL,
  `iptal_eden_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_sinav_bitirenler
-- ----------------------------

-- ----------------------------
-- Table structure for tb_sinav_cevaplari
-- ----------------------------
DROP TABLE IF EXISTS `tb_sinav_cevaplari`;
CREATE TABLE `tb_sinav_cevaplari`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `ogrenci_id` int NULL DEFAULT NULL,
  `sinav_id` int NULL DEFAULT NULL,
  `soru_id` int NULL DEFAULT NULL,
  `cevap_id` int NULL DEFAULT NULL,
  `cevap_metin` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL,
  `puan` double(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 64 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_sinav_cevaplari
-- ----------------------------
INSERT INTO `tb_sinav_cevaplari` VALUES (50, 2, 19, 10, 50, '', 0.00);
INSERT INTO `tb_sinav_cevaplari` VALUES (51, 2, 19, 14, 68, '', 0.00);
INSERT INTO `tb_sinav_cevaplari` VALUES (53, 2, 19, 9, 44, '', 0.00);
INSERT INTO `tb_sinav_cevaplari` VALUES (54, 2, 19, 6, 29, '', 10.00);
INSERT INTO `tb_sinav_cevaplari` VALUES (55, 2, 19, 1, 5, '', 0.00);
INSERT INTO `tb_sinav_cevaplari` VALUES (56, 2, 19, 7, 34, '', 10.00);
INSERT INTO `tb_sinav_cevaplari` VALUES (57, 2, 19, 3, 15, '', 0.00);
INSERT INTO `tb_sinav_cevaplari` VALUES (58, 2, 19, 2, 9, '', 10.00);
INSERT INTO `tb_sinav_cevaplari` VALUES (59, 2, 19, 13, 64, '', 0.00);
INSERT INTO `tb_sinav_cevaplari` VALUES (60, 2, 19, 13, 63, '', 0.00);
INSERT INTO `tb_sinav_cevaplari` VALUES (61, 2, 19, 11, 52, '', 0.00);
INSERT INTO `tb_sinav_cevaplari` VALUES (62, 2, 19, 8, 40, '', 15.00);
INSERT INTO `tb_sinav_cevaplari` VALUES (63, 2, 19, 12, 58, '', 20.00);

-- ----------------------------
-- Table structure for tb_sinav_ogrencileri
-- ----------------------------
DROP TABLE IF EXISTS `tb_sinav_ogrencileri`;
CREATE TABLE `tb_sinav_ogrencileri`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `sinav_id` int NULL DEFAULT NULL,
  `ogrenci_id` int NULL DEFAULT NULL,
  `sinav_bitti_mi` tinyint UNSIGNED NULL DEFAULT 0,
  `okudum_anladim` tinyint NULL DEFAULT 0,
  `sinav_puani` int NULL DEFAULT NULL,
  `sinav_bitiren_ip_adresi` varchar(50) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `sinavi_aktif_eden` int NULL DEFAULT NULL,
  `sinav_baslatma` timestamp NULL DEFAULT NULL,
  `son_gorulme` timestamp NULL DEFAULT NULL,
  `ek_sure` int NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 157 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_sinav_ogrencileri
-- ----------------------------
INSERT INTO `tb_sinav_ogrencileri` VALUES (125, 18, 3, 0, 0, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `tb_sinav_ogrencileri` VALUES (126, 18, 9, 0, 0, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `tb_sinav_ogrencileri` VALUES (127, 18, 4, 0, 0, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `tb_sinav_ogrencileri` VALUES (128, 18, 129, 0, 0, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `tb_sinav_ogrencileri` VALUES (129, 18, 130, 0, 0, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `tb_sinav_ogrencileri` VALUES (130, 18, 2, 0, 0, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `tb_sinav_ogrencileri` VALUES (131, 18, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `tb_sinav_ogrencileri` VALUES (132, 18, 131, 0, 0, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `tb_sinav_ogrencileri` VALUES (149, 19, 3, 0, 0, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `tb_sinav_ogrencileri` VALUES (150, 19, 9, 0, 0, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `tb_sinav_ogrencileri` VALUES (151, 19, 4, 0, 0, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `tb_sinav_ogrencileri` VALUES (152, 19, 129, 0, 0, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `tb_sinav_ogrencileri` VALUES (153, 19, 130, 0, 0, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `tb_sinav_ogrencileri` VALUES (154, 19, 2, 1, 0, NULL, '::1', NULL, NULL, '2023-02-13 15:51:40', 0);
INSERT INTO `tb_sinav_ogrencileri` VALUES (155, 19, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO `tb_sinav_ogrencileri` VALUES (156, 19, 131, 0, 0, NULL, NULL, NULL, NULL, NULL, 0);

-- ----------------------------
-- Table structure for tb_sinav_sorulari
-- ----------------------------
DROP TABLE IF EXISTS `tb_sinav_sorulari`;
CREATE TABLE `tb_sinav_sorulari`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `sinav_id` int NULL DEFAULT NULL,
  `ogretim_elemani_id` int NULL DEFAULT NULL,
  `soru_id` int NULL DEFAULT NULL,
  `ders_id` int NULL DEFAULT NULL,
  `ekleyen` int NULL DEFAULT NULL,
  `puan` int NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 57 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_sinav_sorulari
-- ----------------------------
INSERT INTO `tb_sinav_sorulari` VALUES (29, 17, 1, 6, 1, 31, 0);
INSERT INTO `tb_sinav_sorulari` VALUES (30, 17, 1, 7, 1, 31, 0);
INSERT INTO `tb_sinav_sorulari` VALUES (31, 17, 1, 9, 1, 31, 0);
INSERT INTO `tb_sinav_sorulari` VALUES (32, 17, 1, 11, 1, 31, 0);
INSERT INTO `tb_sinav_sorulari` VALUES (33, 17, 1, 3, 1, 31, 0);
INSERT INTO `tb_sinav_sorulari` VALUES (34, 17, 1, 10, 1, 31, 0);
INSERT INTO `tb_sinav_sorulari` VALUES (35, 18, 1, 6, 1, 31, 0);
INSERT INTO `tb_sinav_sorulari` VALUES (36, 18, 1, 7, 1, 31, 0);
INSERT INTO `tb_sinav_sorulari` VALUES (37, 18, 1, 9, 1, 31, 11);
INSERT INTO `tb_sinav_sorulari` VALUES (38, 18, 1, 11, 1, 31, 0);
INSERT INTO `tb_sinav_sorulari` VALUES (39, 18, 1, 10, 1, 31, 10);
INSERT INTO `tb_sinav_sorulari` VALUES (40, 18, 1, 3, 1, 31, 0);
INSERT INTO `tb_sinav_sorulari` VALUES (41, 18, 21, 13, 14, 31, 0);
INSERT INTO `tb_sinav_sorulari` VALUES (43, 19, 1, 11, 1, 31, 15);
INSERT INTO `tb_sinav_sorulari` VALUES (44, 19, 1, 10, 1, 31, 10);
INSERT INTO `tb_sinav_sorulari` VALUES (45, 19, 1, 9, 1, 31, 10);
INSERT INTO `tb_sinav_sorulari` VALUES (46, 19, 1, 6, 1, 31, 10);
INSERT INTO `tb_sinav_sorulari` VALUES (47, 19, 1, 3, 1, 31, 10);
INSERT INTO `tb_sinav_sorulari` VALUES (48, 19, 1, 12, 1, 31, 5);
INSERT INTO `tb_sinav_sorulari` VALUES (49, 19, 1, 2, 1, 31, 10);
INSERT INTO `tb_sinav_sorulari` VALUES (50, 19, 1, 1, 1, 31, 10);
INSERT INTO `tb_sinav_sorulari` VALUES (51, 19, 1, 8, 1, 31, 5);
INSERT INTO `tb_sinav_sorulari` VALUES (52, 19, 21, 13, 14, 31, 5);
INSERT INTO `tb_sinav_sorulari` VALUES (53, 19, 1, 14, 14, 31, 5);
INSERT INTO `tb_sinav_sorulari` VALUES (54, 19, 1, 7, 1, 31, 0);
INSERT INTO `tb_sinav_sorulari` VALUES (55, 19, 1, 17, 1, 31, 5);
INSERT INTO `tb_sinav_sorulari` VALUES (56, 18, 1, 14, 14, 31, 0);

-- ----------------------------
-- Table structure for tb_sinavlar
-- ----------------------------
DROP TABLE IF EXISTS `tb_sinavlar`;
CREATE TABLE `tb_sinavlar`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `universite_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `donem_id` int NULL DEFAULT NULL,
  `komite_id` int NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `aciklama` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `sinav_oncesi_aciklama` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `sinav_sonrasi_aciklama` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `sinav_suresi` int NULL DEFAULT NULL,
  `sinav_baslangic_tarihi` date NOT NULL,
  `sinav_baslangic_saati` time NULL DEFAULT NULL,
  `sinav_bitis_tarihi` date NULL DEFAULT NULL,
  `sinav_bitis_saati` time NULL DEFAULT NULL,
  `sinava_giris_tarihi` date NULL DEFAULT NULL,
  `sinava_giris_saati` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sorulari_karistir` tinyint NULL DEFAULT NULL,
  `secenekleri_karistir` tinyint NULL DEFAULT NULL,
  `ip_adresi` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `soru_sayisi` int NULL DEFAULT NULL,
  `aktif` tinyint NULL DEFAULT 1,
  `sinav_sonuc_acikla` tinyint NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_sinavlar
-- ----------------------------
INSERT INTO `tb_sinavlar` VALUES (18, '1', 1, 1, 'Tıbba Giriş Sınav', '<p>Açıklama</p>', 'açıklama', '<p>Sınav Sonrası Açıklama</p>', 120, '2022-12-30', '09:00:00', '2022-12-30', '12:00:00', NULL, NULL, 1, 1, '192.168.1.30/40', 20, 1, 0);
INSERT INTO `tb_sinavlar` VALUES (19, '1', 1, 1, 'Tıbba Giriş Sınav', 'Açıklama Kısmı', 'Sınav Öncesi Açıklama Kısmı Güncellendi Artık burda yer alacak asdasdas', 'Sınav Sonrası Açıklama Kısmı', 120, '2023-01-23', '10:00:00', '2023-02-13', '16:00:00', NULL, '', 1, 1, '192.168.1.30/40', 12, 1, 0);

-- ----------------------------
-- Table structure for tb_sistem_kullanici
-- ----------------------------
DROP TABLE IF EXISTS `tb_sistem_kullanici`;
CREATE TABLE `tb_sistem_kullanici`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `soyadi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `telefon` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `sifre` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `rol_id` int NOT NULL DEFAULT 1,
  `super` tinyint NULL DEFAULT 0,
  `resim` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT 'resim_yok.jpg',
  `tc_no` varchar(11) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `dogum_tarihi` datetime NULL DEFAULT NULL,
  `universiteler` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT '',
  `kullanici_turu` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT 'admin',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_sistem_kullanici
-- ----------------------------
INSERT INTO `tb_sistem_kullanici` VALUES (19, 'Serbest', 'ZİYANAK', 'serbest.ziyanak@gmail.com', '0(544) 496-1144', 'bc000ebca4a5687a014d9c9f94da86e8', 1, 1, '19.jpg', '45982964018', '1989-01-20 00:00:00', '1', 'admin');
INSERT INTO `tb_sistem_kullanici` VALUES (35, 'H. Eray', 'ÇELİK', 'heraycelik@gmail.com', '0(544) 496-1144', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, 'resim_yok.jpg', '11111111111', '1970-01-01 00:00:00', '1', 'admin');

-- ----------------------------
-- Table structure for tb_sistem_kullanici_yetkili_birimler
-- ----------------------------
DROP TABLE IF EXISTS `tb_sistem_kullanici_yetkili_birimler`;
CREATE TABLE `tb_sistem_kullanici_yetkili_birimler`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `birim_id` int NULL DEFAULT NULL,
  `kullanici_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_sistem_kullanici_yetkili_birimler
-- ----------------------------
INSERT INTO `tb_sistem_kullanici_yetkili_birimler` VALUES (1, 1, 1);
INSERT INTO `tb_sistem_kullanici_yetkili_birimler` VALUES (2, 2, 1);
INSERT INTO `tb_sistem_kullanici_yetkili_birimler` VALUES (3, 1, 2);
INSERT INTO `tb_sistem_kullanici_yetkili_birimler` VALUES (4, 1, 4);
INSERT INTO `tb_sistem_kullanici_yetkili_birimler` VALUES (5, 1, 7);

-- ----------------------------
-- Table structure for tb_slaytlar
-- ----------------------------
DROP TABLE IF EXISTS `tb_slaytlar`;
CREATE TABLE `tb_slaytlar`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `birim_id` int UNSIGNED NULL DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sira` tinyint NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_slaytlar
-- ----------------------------
INSERT INTO `tb_slaytlar` VALUES (4, 11, '64fdfdd731776slide-1.jpg', NULL);
INSERT INTO `tb_slaytlar` VALUES (5, 11, '64fdfdde3dabaslide-2.jpg', NULL);
INSERT INTO `tb_slaytlar` VALUES (6, 11, '64fdfded4d896slide-3.jpg', NULL);
INSERT INTO `tb_slaytlar` VALUES (9, 11, '64fe23351c51cslide-1.jpg', NULL);

-- ----------------------------
-- Table structure for tb_soru_bankasi
-- ----------------------------
DROP TABLE IF EXISTS `tb_soru_bankasi`;
CREATE TABLE `tb_soru_bankasi`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `soru` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL,
  `soru_turu_id` int NULL DEFAULT NULL,
  `soru_dosyasi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `mufredat_id` int NULL DEFAULT NULL,
  `ders_yili_donem_id` int NULL DEFAULT NULL,
  `program_id` int NULL DEFAULT NULL,
  `ders_id` int NULL DEFAULT NULL,
  `ogretim_elemani_id` int NULL DEFAULT NULL,
  `zorluk_derecesi` tinyint NULL DEFAULT NULL,
  `puan` int NULL DEFAULT NULL,
  `etiket` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `editor` tinyint NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_soru_bankasi
-- ----------------------------
INSERT INTO `tb_soru_bankasi` VALUES (1, '<p>En hareketli sinovial eklem tipini işaretleyiniz.<br></p>', 1, '', 1, 1, 1, 1, 1, 3, 10, 'sinovial eklem', 0);
INSERT INTO `tb_soru_bankasi` VALUES (2, '<p>Üst ekstremitenin orta hatta yaklaşması hareketine ne ad verilir?<br></p>', 1, '', 1, 1, 1, 1, 1, 3, 10, '', 0);
INSERT INTO `tb_soru_bankasi` VALUES (3, '<p>Vertebra cisimleri ile kaburga başları arasındaki eklemlere ne ad verilir?<br></p>', 1, '', 1, 1, 1, 1, 1, 3, 10, '', 0);
INSERT INTO `tb_soru_bankasi` VALUES (4, '<p>Art. radio-ulnaris proximalis’in eklem tipini işaretleyiniz.<br></p>', 1, '', 1, 1, 1, 1, 1, 3, 10, '', 0);
INSERT INTO `tb_soru_bankasi` VALUES (5, '<p>Ayak tabanının dışa doğru döndürülmesine ne ad verilir?<br></p>', 1, '', 1, 1, 1, 1, 1, 3, 5, '', 0);
INSERT INTO `tb_soru_bankasi` VALUES (6, '<p>.Hangi kas ağız açıklığı (yarığı) ile ilgili<b> <u>değildir?</u></b></p>', 1, '', 1, 1, 1, 1, 1, 2, 10, '', 0);
INSERT INTO `tb_soru_bankasi` VALUES (7, '<p>Hangisi yüzeyel sırt kası <b><u>değildir?</u></b></p>', 1, '', 1, 1, 1, 1, 1, 2, 10, '', 0);
INSERT INTO `tb_soru_bankasi` VALUES (8, '<p>M. pectoralis major’un insertio ve origo’ları ile ilgili <b><u>olmayan</u></b> şıkkı işaretleyiniz.<br></p>', 1, '', 1, 1, 1, 1, 1, 3, 15, '', 0);
INSERT INTO `tb_soru_bankasi` VALUES (9, '<p>Hangi kas, ön-kola ekstansiyon yaptırır?</p>', 1, '', 1, 1, 1, 1, 1, 1, 20, '', 0);
INSERT INTO `tb_soru_bankasi` VALUES (10, '<p>Hangisi ayağa dorsifleksiyon <b><u>yaptırmaz?</u></b></p>', 1, '', 1, 1, 1, 1, 1, 1, 10, '', 0);
INSERT INTO `tb_soru_bankasi` VALUES (11, '<p><b>(I)</b> Omur cisimleri ile kaburga başları arasında plan tipi eklem bulunur.</p><p><b>(II) </b>Bir omurun transvers çıkıntısı ile bir kaburganın tuberculum costae’si arasında plan tipi eklem bulunur.</p><p>Aşağıdakilerden hangisi doğrudur.</p>', 1, '', 1, 1, 1, 1, 1, 4, 15, '', 0);
INSERT INTO `tb_soru_bankasi` VALUES (12, '<p>Fibröz eklemler için doğru olan şıkkı işaretleyiniz.</p><p><b>(I) </b>Syndesmosis<br></p><p><b>(II) </b>Gomphosis</p><p><b>(IV)</b> Synchondrosis</p><p><b>(III)</b> Sutura<br></p>', 1, '', 1, 1, 1, 1, 1, 5, 20, 'Fibröz eklemler', 0);
INSERT INTO `tb_soru_bankasi` VALUES (13, '<p>Soru Bankası Deneme Amaçlı&nbsp;</p><p>Asağıdakilerden hangileri <b><u>doğrudur?</u></b></p>', 2, '', 38, 1, 1, 14, 21, 5, 10, 'ABCDE', 0);
INSERT INTO `tb_soru_bankasi` VALUES (14, '<p>ASDASDASD</p>', 2, '63637d9e7165c.jpg', 37, 1, 1, 14, 1, 5, 10, 'ABCD', 0);
INSERT INTO `tb_soru_bankasi` VALUES (15, '<p>Sorudur</p>', 1, '636cd0e45ab13.jpg', 1, 1, 1, 1, 21, 1, 10, 'etiketsorusu', 0);
INSERT INTO `tb_soru_bankasi` VALUES (17, '<p>Klasik soru türdür öğrenci metin girişi yapacaktır. BUndan dolayı metin alanı öğrenci için açılacaktır</p>', 3, '63c64aec56dc0.jpg', 1, 1, 1, 1, 1, 5, 30, 'açık uclu klasik soru', 0);

-- ----------------------------
-- Table structure for tb_soru_secenekleri
-- ----------------------------
DROP TABLE IF EXISTS `tb_soru_secenekleri`;
CREATE TABLE `tb_soru_secenekleri`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `soru_id` int NULL DEFAULT NULL,
  `secenek` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL,
  `dogru_secenek` tinyint NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 77 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_soru_secenekleri
-- ----------------------------
INSERT INTO `tb_soru_secenekleri` VALUES (1, 1, 'a', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (2, 1, 'b', 1);
INSERT INTO `tb_soru_secenekleri` VALUES (3, 1, 'c', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (4, 1, 'd', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (5, 1, 'e', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (6, 2, 'a', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (7, 2, 'b', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (8, 2, 'c', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (9, 2, 'd', 1);
INSERT INTO `tb_soru_secenekleri` VALUES (10, 2, 'e', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (11, 3, 'a', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (12, 3, 'b', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (13, 3, 'c', 1);
INSERT INTO `tb_soru_secenekleri` VALUES (14, 3, 'd', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (15, 3, 'e', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (16, 4, 'a', 1);
INSERT INTO `tb_soru_secenekleri` VALUES (17, 4, 'b', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (18, 4, 'c', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (19, 4, 'd', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (20, 4, 'e', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (21, 5, 'a', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (22, 5, 'b', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (23, 5, 'c', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (24, 5, 'd', 1);
INSERT INTO `tb_soru_secenekleri` VALUES (25, 5, 'e', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (26, 6, 'a', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (27, 6, 'b', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (28, 6, 'c', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (29, 6, 'd', 1);
INSERT INTO `tb_soru_secenekleri` VALUES (30, 6, 'e', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (31, 7, 'a', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (32, 7, 'b', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (33, 7, 'c', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (34, 7, 'd', 1);
INSERT INTO `tb_soru_secenekleri` VALUES (35, 7, 'e', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (36, 8, 'a', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (37, 8, 'b', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (38, 8, 'c', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (39, 8, 'd', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (40, 8, 'e', 1);
INSERT INTO `tb_soru_secenekleri` VALUES (41, 9, 'a', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (42, 9, 'b', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (43, 9, 'c', 1);
INSERT INTO `tb_soru_secenekleri` VALUES (44, 9, 'd', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (45, 9, 'e', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (46, 10, 'a', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (47, 10, 'b', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (48, 10, 'c', 1);
INSERT INTO `tb_soru_secenekleri` VALUES (49, 10, 'd', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (50, 10, 'e', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (51, 11, 'a', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (52, 11, 'b', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (53, 11, 'c', 1);
INSERT INTO `tb_soru_secenekleri` VALUES (54, 11, 'd', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (55, 11, 'e', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (56, 12, 'a', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (57, 12, 'b', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (58, 12, 'c', 1);
INSERT INTO `tb_soru_secenekleri` VALUES (59, 12, 'd', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (60, 12, 'e', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (61, 13, 'f', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (62, 13, 'a', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (63, 13, 'b', 1);
INSERT INTO `tb_soru_secenekleri` VALUES (64, 13, 'c', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (65, 13, 'd', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (66, 13, 'e', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (67, 14, 'a', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (68, 14, 'b', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (69, 14, 'c', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (70, 14, 'd', 1);
INSERT INTO `tb_soru_secenekleri` VALUES (71, 14, 'e', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (72, 15, 'a', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (73, 15, 'b', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (74, 15, 'c', NULL);
INSERT INTO `tb_soru_secenekleri` VALUES (75, 15, 'd', 1);
INSERT INTO `tb_soru_secenekleri` VALUES (76, 15, 'e', NULL);

-- ----------------------------
-- Table structure for tb_soru_turleri
-- ----------------------------
DROP TABLE IF EXISTS `tb_soru_turleri`;
CREATE TABLE `tb_soru_turleri`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `universite_id` int NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `coklu_secenek` tinyint NULL DEFAULT 0,
  `metin` tinyint NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_soru_turleri
-- ----------------------------
INSERT INTO `tb_soru_turleri` VALUES (1, 1, 'Çoktan Tek Seçmeli', 0, 0);
INSERT INTO `tb_soru_turleri` VALUES (2, 1, 'Çoktan Çok Seçmeli', 1, 0);
INSERT INTO `tb_soru_turleri` VALUES (3, 1, 'Açık Uçlu', 0, 1);

-- ----------------------------
-- Table structure for tb_universiteler
-- ----------------------------
DROP TABLE IF EXISTS `tb_universiteler`;
CREATE TABLE `tb_universiteler`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `aktif` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_universiteler
-- ----------------------------
INSERT INTO `tb_universiteler` VALUES (1, 'Ahmet Yesevi Üniversitesi', 1);
INSERT INTO `tb_universiteler` VALUES (2, 'İstanbul Teknik Üniversitesi', 0);
INSERT INTO `tb_universiteler` VALUES (3, 'Hacattepe Üniversitesi', 0);
INSERT INTO `tb_universiteler` VALUES (4, 'Yıldız Teknik Üniversitesi', 0);

-- ----------------------------
-- Table structure for tb_unvanlar
-- ----------------------------
DROP TABLE IF EXISTS `tb_unvanlar`;
CREATE TABLE `tb_unvanlar`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `personel_nitelik_id` int NULL DEFAULT NULL,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `sira` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_unvanlar
-- ----------------------------
INSERT INTO `tb_unvanlar` VALUES (1, 1, 'Prof. Dr.', 1);
INSERT INTO `tb_unvanlar` VALUES (2, 1, 'Doc. Dr.', 2);
INSERT INTO `tb_unvanlar` VALUES (3, 1, 'Dr. Öğr. Üyesi', 3);
INSERT INTO `tb_unvanlar` VALUES (4, 1, 'Öğr. Gör. Dr.', 4);
INSERT INTO `tb_unvanlar` VALUES (5, 1, 'Arş. Gör. Dr.', 5);
INSERT INTO `tb_unvanlar` VALUES (6, 1, 'Öğr. Gör.', 6);
INSERT INTO `tb_unvanlar` VALUES (7, 1, 'Arş. Gör.', 7);

-- ----------------------------
-- Table structure for tb_uyruklar
-- ----------------------------
DROP TABLE IF EXISTS `tb_uyruklar`;
CREATE TABLE `tb_uyruklar`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `kisa_ad` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `adi` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tel_kodu` int NULL DEFAULT NULL,
  `sira` int NULL DEFAULT 9999,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 247 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_uyruklar
-- ----------------------------
INSERT INTO `tb_uyruklar` VALUES (1, 'AF', 'Afghanistan', 93, 9999);
INSERT INTO `tb_uyruklar` VALUES (2, 'AL', 'Albania', 355, 9999);
INSERT INTO `tb_uyruklar` VALUES (3, 'DZ', 'Algeria', 213, 9999);
INSERT INTO `tb_uyruklar` VALUES (4, 'AS', 'American Samoa', 1684, 9999);
INSERT INTO `tb_uyruklar` VALUES (5, 'AD', 'Andorra', 376, 9999);
INSERT INTO `tb_uyruklar` VALUES (6, 'AO', 'Angola', 244, 9999);
INSERT INTO `tb_uyruklar` VALUES (7, 'AI', 'Anguilla', 1264, 9999);
INSERT INTO `tb_uyruklar` VALUES (8, 'AQ', 'Antarctica', 0, 9999);
INSERT INTO `tb_uyruklar` VALUES (9, 'AG', 'Antigua And Barbuda', 1268, 9999);
INSERT INTO `tb_uyruklar` VALUES (10, 'AR', 'Argentina', 54, 9999);
INSERT INTO `tb_uyruklar` VALUES (11, 'AM', 'Armenia', 374, 9999);
INSERT INTO `tb_uyruklar` VALUES (12, 'AW', 'Aruba', 297, 9999);
INSERT INTO `tb_uyruklar` VALUES (13, 'AU', 'Australia', 61, 9999);
INSERT INTO `tb_uyruklar` VALUES (14, 'AT', 'Austria', 43, 9999);
INSERT INTO `tb_uyruklar` VALUES (15, 'AZ', 'Azerbaijan', 994, 9999);
INSERT INTO `tb_uyruklar` VALUES (16, 'BS', 'Bahamas The', 1242, 9999);
INSERT INTO `tb_uyruklar` VALUES (17, 'BH', 'Bahrain', 973, 9999);
INSERT INTO `tb_uyruklar` VALUES (18, 'BD', 'Bangladesh', 880, 9999);
INSERT INTO `tb_uyruklar` VALUES (19, 'BB', 'Barbados', 1246, 9999);
INSERT INTO `tb_uyruklar` VALUES (20, 'BY', 'Belarus', 375, 9999);
INSERT INTO `tb_uyruklar` VALUES (21, 'BE', 'Belgium', 32, 9999);
INSERT INTO `tb_uyruklar` VALUES (22, 'BZ', 'Belize', 501, 9999);
INSERT INTO `tb_uyruklar` VALUES (23, 'BJ', 'Benin', 229, 9999);
INSERT INTO `tb_uyruklar` VALUES (24, 'BM', 'Bermuda', 1441, 9999);
INSERT INTO `tb_uyruklar` VALUES (25, 'BT', 'Bhutan', 975, 9999);
INSERT INTO `tb_uyruklar` VALUES (26, 'BO', 'Bolivia', 591, 9999);
INSERT INTO `tb_uyruklar` VALUES (27, 'BA', 'Bosnia and Herzegovina', 387, 9999);
INSERT INTO `tb_uyruklar` VALUES (28, 'BW', 'Botswana', 267, 9999);
INSERT INTO `tb_uyruklar` VALUES (29, 'BV', 'Bouvet Island', 0, 9999);
INSERT INTO `tb_uyruklar` VALUES (30, 'BR', 'Brazil', 55, 9999);
INSERT INTO `tb_uyruklar` VALUES (31, 'IO', 'British Indian Ocean Territory', 246, 9999);
INSERT INTO `tb_uyruklar` VALUES (32, 'BN', 'Brunei', 673, 9999);
INSERT INTO `tb_uyruklar` VALUES (33, 'BG', 'Bulgaria', 359, 9999);
INSERT INTO `tb_uyruklar` VALUES (34, 'BF', 'Burkina Faso', 226, 9999);
INSERT INTO `tb_uyruklar` VALUES (35, 'BI', 'Burundi', 257, 9999);
INSERT INTO `tb_uyruklar` VALUES (36, 'KH', 'Cambodia', 855, 9999);
INSERT INTO `tb_uyruklar` VALUES (37, 'CM', 'Cameroon', 237, 9999);
INSERT INTO `tb_uyruklar` VALUES (38, 'CA', 'Canada', 1, 9999);
INSERT INTO `tb_uyruklar` VALUES (39, 'CV', 'Cape Verde', 238, 9999);
INSERT INTO `tb_uyruklar` VALUES (40, 'KY', 'Cayman Islands', 1345, 9999);
INSERT INTO `tb_uyruklar` VALUES (41, 'CF', 'Central African Republic', 236, 9999);
INSERT INTO `tb_uyruklar` VALUES (42, 'TD', 'Chad', 235, 9999);
INSERT INTO `tb_uyruklar` VALUES (43, 'CL', 'Chile', 56, 9999);
INSERT INTO `tb_uyruklar` VALUES (44, 'CN', 'China', 86, 9999);
INSERT INTO `tb_uyruklar` VALUES (45, 'CX', 'Christmas Island', 61, 9999);
INSERT INTO `tb_uyruklar` VALUES (46, 'CC', 'Cocos (Keeling) Islands', 672, 9999);
INSERT INTO `tb_uyruklar` VALUES (47, 'CO', 'Colombia', 57, 9999);
INSERT INTO `tb_uyruklar` VALUES (48, 'KM', 'Comoros', 269, 9999);
INSERT INTO `tb_uyruklar` VALUES (49, 'CG', 'Republic Of The Congo', 242, 9999);
INSERT INTO `tb_uyruklar` VALUES (50, 'CD', 'Democratic Republic Of The Congo', 242, 9999);
INSERT INTO `tb_uyruklar` VALUES (51, 'CK', 'Cook Islands', 682, 9999);
INSERT INTO `tb_uyruklar` VALUES (52, 'CR', 'Costa Rica', 506, 9999);
INSERT INTO `tb_uyruklar` VALUES (53, 'CI', 'Cote D\'Ivoire (Ivory Coast)', 225, 9999);
INSERT INTO `tb_uyruklar` VALUES (54, 'HR', 'Croatia (Hrvatska)', 385, 9999);
INSERT INTO `tb_uyruklar` VALUES (55, 'CU', 'Cuba', 53, 9999);
INSERT INTO `tb_uyruklar` VALUES (56, 'CY', 'Cyprus', 357, 9999);
INSERT INTO `tb_uyruklar` VALUES (57, 'CZ', 'Czech Republic', 420, 9999);
INSERT INTO `tb_uyruklar` VALUES (58, 'DK', 'Denmark', 45, 9999);
INSERT INTO `tb_uyruklar` VALUES (59, 'DJ', 'Djibouti', 253, 9999);
INSERT INTO `tb_uyruklar` VALUES (60, 'DM', 'Dominica', 1767, 9999);
INSERT INTO `tb_uyruklar` VALUES (61, 'DO', 'Dominican Republic', 1809, 9999);
INSERT INTO `tb_uyruklar` VALUES (62, 'TP', 'East Timor', 670, 9999);
INSERT INTO `tb_uyruklar` VALUES (63, 'EC', 'Ecuador', 593, 9999);
INSERT INTO `tb_uyruklar` VALUES (64, 'EG', 'Egypt', 20, 9999);
INSERT INTO `tb_uyruklar` VALUES (65, 'SV', 'El Salvador', 503, 9999);
INSERT INTO `tb_uyruklar` VALUES (66, 'GQ', 'Equatorial Guinea', 240, 9999);
INSERT INTO `tb_uyruklar` VALUES (67, 'ER', 'Eritrea', 291, 9999);
INSERT INTO `tb_uyruklar` VALUES (68, 'EE', 'Estonia', 372, 9999);
INSERT INTO `tb_uyruklar` VALUES (69, 'ET', 'Ethiopia', 251, 9999);
INSERT INTO `tb_uyruklar` VALUES (70, 'XA', 'External Territories of Australia', 61, 9999);
INSERT INTO `tb_uyruklar` VALUES (71, 'FK', 'Falkland Islands', 500, 9999);
INSERT INTO `tb_uyruklar` VALUES (72, 'FO', 'Faroe Islands', 298, 9999);
INSERT INTO `tb_uyruklar` VALUES (73, 'FJ', 'Fiji Islands', 679, 9999);
INSERT INTO `tb_uyruklar` VALUES (74, 'FI', 'Finland', 358, 9999);
INSERT INTO `tb_uyruklar` VALUES (75, 'FR', 'France', 33, 9999);
INSERT INTO `tb_uyruklar` VALUES (76, 'GF', 'French Guiana', 594, 9999);
INSERT INTO `tb_uyruklar` VALUES (77, 'PF', 'French Polynesia', 689, 9999);
INSERT INTO `tb_uyruklar` VALUES (78, 'TF', 'French Southern Territories', 0, 9999);
INSERT INTO `tb_uyruklar` VALUES (79, 'GA', 'Gabon', 241, 9999);
INSERT INTO `tb_uyruklar` VALUES (80, 'GM', 'Gambia The', 220, 9999);
INSERT INTO `tb_uyruklar` VALUES (81, 'GE', 'Georgia', 995, 9999);
INSERT INTO `tb_uyruklar` VALUES (82, 'DE', 'Germany', 49, 9999);
INSERT INTO `tb_uyruklar` VALUES (83, 'GH', 'Ghana', 233, 9999);
INSERT INTO `tb_uyruklar` VALUES (84, 'GI', 'Gibraltar', 350, 9999);
INSERT INTO `tb_uyruklar` VALUES (85, 'GR', 'Greece', 30, 9999);
INSERT INTO `tb_uyruklar` VALUES (86, 'GL', 'Greenland', 299, 9999);
INSERT INTO `tb_uyruklar` VALUES (87, 'GD', 'Grenada', 1473, 9999);
INSERT INTO `tb_uyruklar` VALUES (88, 'GP', 'Guadeloupe', 590, 9999);
INSERT INTO `tb_uyruklar` VALUES (89, 'GU', 'Guam', 1671, 9999);
INSERT INTO `tb_uyruklar` VALUES (90, 'GT', 'Guatemala', 502, 9999);
INSERT INTO `tb_uyruklar` VALUES (91, 'XU', 'Guernsey and Alderney', 44, 9999);
INSERT INTO `tb_uyruklar` VALUES (92, 'GN', 'Guinea', 224, 9999);
INSERT INTO `tb_uyruklar` VALUES (93, 'GW', 'Guinea-Bissau', 245, 9999);
INSERT INTO `tb_uyruklar` VALUES (94, 'GY', 'Guyana', 592, 9999);
INSERT INTO `tb_uyruklar` VALUES (95, 'HT', 'Haiti', 509, 9999);
INSERT INTO `tb_uyruklar` VALUES (96, 'HM', 'Heard and McDonald Islands', 0, 9999);
INSERT INTO `tb_uyruklar` VALUES (97, 'HN', 'Honduras', 504, 9999);
INSERT INTO `tb_uyruklar` VALUES (98, 'HK', 'Hong Kong S.A.R.', 852, 9999);
INSERT INTO `tb_uyruklar` VALUES (99, 'HU', 'Hungary', 36, 9999);
INSERT INTO `tb_uyruklar` VALUES (100, 'IS', 'Iceland', 354, 9999);
INSERT INTO `tb_uyruklar` VALUES (101, 'IN', 'India', 91, 9999);
INSERT INTO `tb_uyruklar` VALUES (102, 'ID', 'Indonesia', 62, 9999);
INSERT INTO `tb_uyruklar` VALUES (103, 'IR', 'Iran', 98, 9999);
INSERT INTO `tb_uyruklar` VALUES (104, 'IQ', 'Iraq', 964, 9999);
INSERT INTO `tb_uyruklar` VALUES (105, 'IE', 'Ireland', 353, 9999);
INSERT INTO `tb_uyruklar` VALUES (106, 'IL', 'Israel', 972, 9999);
INSERT INTO `tb_uyruklar` VALUES (107, 'IT', 'Italy', 39, 9999);
INSERT INTO `tb_uyruklar` VALUES (108, 'JM', 'Jamaica', 1876, 9999);
INSERT INTO `tb_uyruklar` VALUES (109, 'JP', 'Japan', 81, 9999);
INSERT INTO `tb_uyruklar` VALUES (110, 'XJ', 'Jersey', 44, 9999);
INSERT INTO `tb_uyruklar` VALUES (111, 'JO', 'Jordan', 962, 9999);
INSERT INTO `tb_uyruklar` VALUES (112, 'KZ', 'Kazakhstan', 7, 2);
INSERT INTO `tb_uyruklar` VALUES (113, 'KE', 'Kenya', 254, 9999);
INSERT INTO `tb_uyruklar` VALUES (114, 'KI', 'Kiribati', 686, 9999);
INSERT INTO `tb_uyruklar` VALUES (115, 'KP', 'Korea North', 850, 9999);
INSERT INTO `tb_uyruklar` VALUES (116, 'KR', 'Korea South', 82, 9999);
INSERT INTO `tb_uyruklar` VALUES (117, 'KW', 'Kuwait', 965, 9999);
INSERT INTO `tb_uyruklar` VALUES (118, 'KG', 'Kyrgyzstan', 996, 9999);
INSERT INTO `tb_uyruklar` VALUES (119, 'LA', 'Laos', 856, 9999);
INSERT INTO `tb_uyruklar` VALUES (120, 'LV', 'Latvia', 371, 9999);
INSERT INTO `tb_uyruklar` VALUES (121, 'LB', 'Lebanon', 961, 9999);
INSERT INTO `tb_uyruklar` VALUES (122, 'LS', 'Lesotho', 266, 9999);
INSERT INTO `tb_uyruklar` VALUES (123, 'LR', 'Liberia', 231, 9999);
INSERT INTO `tb_uyruklar` VALUES (124, 'LY', 'Libya', 218, 9999);
INSERT INTO `tb_uyruklar` VALUES (125, 'LI', 'Liechtenstein', 423, 9999);
INSERT INTO `tb_uyruklar` VALUES (126, 'LT', 'Lithuania', 370, 9999);
INSERT INTO `tb_uyruklar` VALUES (127, 'LU', 'Luxembourg', 352, 9999);
INSERT INTO `tb_uyruklar` VALUES (128, 'MO', 'Macau S.A.R.', 853, 9999);
INSERT INTO `tb_uyruklar` VALUES (129, 'MK', 'Macedonia', 389, 9999);
INSERT INTO `tb_uyruklar` VALUES (130, 'MG', 'Madagascar', 261, 9999);
INSERT INTO `tb_uyruklar` VALUES (131, 'MW', 'Malawi', 265, 9999);
INSERT INTO `tb_uyruklar` VALUES (132, 'MY', 'Malaysia', 60, 9999);
INSERT INTO `tb_uyruklar` VALUES (133, 'MV', 'Maldives', 960, 9999);
INSERT INTO `tb_uyruklar` VALUES (134, 'ML', 'Mali', 223, 9999);
INSERT INTO `tb_uyruklar` VALUES (135, 'MT', 'Malta', 356, 9999);
INSERT INTO `tb_uyruklar` VALUES (136, 'XM', 'Man (Isle of)', 44, 9999);
INSERT INTO `tb_uyruklar` VALUES (137, 'MH', 'Marshall Islands', 692, 9999);
INSERT INTO `tb_uyruklar` VALUES (138, 'MQ', 'Martinique', 596, 9999);
INSERT INTO `tb_uyruklar` VALUES (139, 'MR', 'Mauritania', 222, 9999);
INSERT INTO `tb_uyruklar` VALUES (140, 'MU', 'Mauritius', 230, 9999);
INSERT INTO `tb_uyruklar` VALUES (141, 'YT', 'Mayotte', 269, 9999);
INSERT INTO `tb_uyruklar` VALUES (142, 'MX', 'Mexico', 52, 9999);
INSERT INTO `tb_uyruklar` VALUES (143, 'FM', 'Micronesia', 691, 9999);
INSERT INTO `tb_uyruklar` VALUES (144, 'MD', 'Moldova', 373, 9999);
INSERT INTO `tb_uyruklar` VALUES (145, 'MC', 'Monaco', 377, 9999);
INSERT INTO `tb_uyruklar` VALUES (146, 'MN', 'Mongolia', 976, 9999);
INSERT INTO `tb_uyruklar` VALUES (147, 'MS', 'Montserrat', 1664, 9999);
INSERT INTO `tb_uyruklar` VALUES (148, 'MA', 'Morocco', 212, 9999);
INSERT INTO `tb_uyruklar` VALUES (149, 'MZ', 'Mozambique', 258, 9999);
INSERT INTO `tb_uyruklar` VALUES (150, 'MM', 'Myanmar', 95, 9999);
INSERT INTO `tb_uyruklar` VALUES (151, 'NA', 'Namibia', 264, 9999);
INSERT INTO `tb_uyruklar` VALUES (152, 'NR', 'Nauru', 674, 9999);
INSERT INTO `tb_uyruklar` VALUES (153, 'NP', 'Nepal', 977, 9999);
INSERT INTO `tb_uyruklar` VALUES (154, 'AN', 'Netherlands Antilles', 599, 9999);
INSERT INTO `tb_uyruklar` VALUES (155, 'NL', 'Netherlands The', 31, 9999);
INSERT INTO `tb_uyruklar` VALUES (156, 'NC', 'New Caledonia', 687, 9999);
INSERT INTO `tb_uyruklar` VALUES (157, 'NZ', 'New Zealand', 64, 9999);
INSERT INTO `tb_uyruklar` VALUES (158, 'NI', 'Nicaragua', 505, 9999);
INSERT INTO `tb_uyruklar` VALUES (159, 'NE', 'Niger', 227, 9999);
INSERT INTO `tb_uyruklar` VALUES (160, 'NG', 'Nigeria', 234, 9999);
INSERT INTO `tb_uyruklar` VALUES (161, 'NU', 'Niue', 683, 9999);
INSERT INTO `tb_uyruklar` VALUES (162, 'NF', 'Norfolk Island', 672, 9999);
INSERT INTO `tb_uyruklar` VALUES (163, 'MP', 'Northern Mariana Islands', 1670, 9999);
INSERT INTO `tb_uyruklar` VALUES (164, 'NO', 'Norway', 47, 9999);
INSERT INTO `tb_uyruklar` VALUES (165, 'OM', 'Oman', 968, 9999);
INSERT INTO `tb_uyruklar` VALUES (166, 'PK', 'Pakistan', 92, 9999);
INSERT INTO `tb_uyruklar` VALUES (167, 'PW', 'Palau', 680, 9999);
INSERT INTO `tb_uyruklar` VALUES (168, 'PS', 'Palestinian Territory Occupied', 970, 9999);
INSERT INTO `tb_uyruklar` VALUES (169, 'PA', 'Panama', 507, 9999);
INSERT INTO `tb_uyruklar` VALUES (170, 'PG', 'Papua new Guinea', 675, 9999);
INSERT INTO `tb_uyruklar` VALUES (171, 'PY', 'Paraguay', 595, 9999);
INSERT INTO `tb_uyruklar` VALUES (172, 'PE', 'Peru', 51, 9999);
INSERT INTO `tb_uyruklar` VALUES (173, 'PH', 'Philippines', 63, 9999);
INSERT INTO `tb_uyruklar` VALUES (174, 'PN', 'Pitcairn Island', 0, 9999);
INSERT INTO `tb_uyruklar` VALUES (175, 'PL', 'Poland', 48, 9999);
INSERT INTO `tb_uyruklar` VALUES (176, 'PT', 'Portugal', 351, 9999);
INSERT INTO `tb_uyruklar` VALUES (177, 'PR', 'Puerto Rico', 1787, 9999);
INSERT INTO `tb_uyruklar` VALUES (178, 'QA', 'Qatar', 974, 9999);
INSERT INTO `tb_uyruklar` VALUES (179, 'RE', 'Reunion', 262, 9999);
INSERT INTO `tb_uyruklar` VALUES (180, 'RO', 'Romania', 40, 9999);
INSERT INTO `tb_uyruklar` VALUES (181, 'RU', 'Russia', 70, 9999);
INSERT INTO `tb_uyruklar` VALUES (182, 'RW', 'Rwanda', 250, 9999);
INSERT INTO `tb_uyruklar` VALUES (183, 'SH', 'Saint Helena', 290, 9999);
INSERT INTO `tb_uyruklar` VALUES (184, 'KN', 'Saint Kitts And Nevis', 1869, 9999);
INSERT INTO `tb_uyruklar` VALUES (185, 'LC', 'Saint Lucia', 1758, 9999);
INSERT INTO `tb_uyruklar` VALUES (186, 'PM', 'Saint Pierre and Miquelon', 508, 9999);
INSERT INTO `tb_uyruklar` VALUES (187, 'VC', 'Saint Vincent And The Grenadines', 1784, 9999);
INSERT INTO `tb_uyruklar` VALUES (188, 'WS', 'Samoa', 684, 9999);
INSERT INTO `tb_uyruklar` VALUES (189, 'SM', 'San Marino', 378, 9999);
INSERT INTO `tb_uyruklar` VALUES (190, 'ST', 'Sao Tome and Principe', 239, 9999);
INSERT INTO `tb_uyruklar` VALUES (191, 'SA', 'Saudi Arabia', 966, 9999);
INSERT INTO `tb_uyruklar` VALUES (192, 'SN', 'Senegal', 221, 9999);
INSERT INTO `tb_uyruklar` VALUES (193, 'RS', 'Serbia', 381, 9999);
INSERT INTO `tb_uyruklar` VALUES (194, 'SC', 'Seychelles', 248, 9999);
INSERT INTO `tb_uyruklar` VALUES (195, 'SL', 'Sierra Leone', 232, 9999);
INSERT INTO `tb_uyruklar` VALUES (196, 'SG', 'Singapore', 65, 9999);
INSERT INTO `tb_uyruklar` VALUES (197, 'SK', 'Slovakia', 421, 9999);
INSERT INTO `tb_uyruklar` VALUES (198, 'SI', 'Slovenia', 386, 9999);
INSERT INTO `tb_uyruklar` VALUES (199, 'XG', 'Smaller Territories of the UK', 44, 9999);
INSERT INTO `tb_uyruklar` VALUES (200, 'SB', 'Solomon Islands', 677, 9999);
INSERT INTO `tb_uyruklar` VALUES (201, 'SO', 'Somalia', 252, 9999);
INSERT INTO `tb_uyruklar` VALUES (202, 'ZA', 'South Africa', 27, 9999);
INSERT INTO `tb_uyruklar` VALUES (203, 'GS', 'South Georgia', 0, 9999);
INSERT INTO `tb_uyruklar` VALUES (204, 'SS', 'South Sudan', 211, 9999);
INSERT INTO `tb_uyruklar` VALUES (205, 'ES', 'Spain', 34, 9999);
INSERT INTO `tb_uyruklar` VALUES (206, 'LK', 'Sri Lanka', 94, 9999);
INSERT INTO `tb_uyruklar` VALUES (207, 'SD', 'Sudan', 249, 9999);
INSERT INTO `tb_uyruklar` VALUES (208, 'SR', 'Suriname', 597, 9999);
INSERT INTO `tb_uyruklar` VALUES (209, 'SJ', 'Svalbard And Jan Mayen Islands', 47, 9999);
INSERT INTO `tb_uyruklar` VALUES (210, 'SZ', 'Swaziland', 268, 9999);
INSERT INTO `tb_uyruklar` VALUES (211, 'SE', 'Sweden', 46, 9999);
INSERT INTO `tb_uyruklar` VALUES (212, 'CH', 'Switzerland', 41, 9999);
INSERT INTO `tb_uyruklar` VALUES (213, 'SY', 'Syria', 963, 9999);
INSERT INTO `tb_uyruklar` VALUES (214, 'TW', 'Taiwan', 886, 9999);
INSERT INTO `tb_uyruklar` VALUES (215, 'TJ', 'Tajikistan', 992, 9999);
INSERT INTO `tb_uyruklar` VALUES (216, 'TZ', 'Tanzania', 255, 9999);
INSERT INTO `tb_uyruklar` VALUES (217, 'TH', 'Thailand', 66, 9999);
INSERT INTO `tb_uyruklar` VALUES (218, 'TG', 'Togo', 228, 9999);
INSERT INTO `tb_uyruklar` VALUES (219, 'TK', 'Tokelau', 690, 9999);
INSERT INTO `tb_uyruklar` VALUES (220, 'TO', 'Tonga', 676, 9999);
INSERT INTO `tb_uyruklar` VALUES (221, 'TT', 'Trinidad And Tobago', 1868, 9999);
INSERT INTO `tb_uyruklar` VALUES (222, 'TN', 'Tunisia', 216, 9999);
INSERT INTO `tb_uyruklar` VALUES (223, 'TR', 'Turkey', 90, 1);
INSERT INTO `tb_uyruklar` VALUES (224, 'TM', 'Turkmenistan', 7370, 9999);
INSERT INTO `tb_uyruklar` VALUES (225, 'TC', 'Turks And Caicos Islands', 1649, 9999);
INSERT INTO `tb_uyruklar` VALUES (226, 'TV', 'Tuvalu', 688, 9999);
INSERT INTO `tb_uyruklar` VALUES (227, 'UG', 'Uganda', 256, 9999);
INSERT INTO `tb_uyruklar` VALUES (228, 'UA', 'Ukraine', 380, 9999);
INSERT INTO `tb_uyruklar` VALUES (229, 'AE', 'United Arab Emirates', 971, 9999);
INSERT INTO `tb_uyruklar` VALUES (230, 'GB', 'United Kingdom', 44, 9999);
INSERT INTO `tb_uyruklar` VALUES (231, 'US', 'United States', 1, 9999);
INSERT INTO `tb_uyruklar` VALUES (232, 'UM', 'United States Minor Outlying Islands', 1, 9999);
INSERT INTO `tb_uyruklar` VALUES (233, 'UY', 'Uruguay', 598, 9999);
INSERT INTO `tb_uyruklar` VALUES (234, 'UZ', 'Uzbekistan', 998, 9999);
INSERT INTO `tb_uyruklar` VALUES (235, 'VU', 'Vanuatu', 678, 9999);
INSERT INTO `tb_uyruklar` VALUES (236, 'VA', 'Vatican City State (Holy See)', 39, 9999);
INSERT INTO `tb_uyruklar` VALUES (237, 'VE', 'Venezuela', 58, 9999);
INSERT INTO `tb_uyruklar` VALUES (238, 'VN', 'Vietnam', 84, 9999);
INSERT INTO `tb_uyruklar` VALUES (239, 'VG', 'Virgin Islands (British)', 1284, 9999);
INSERT INTO `tb_uyruklar` VALUES (240, 'VI', 'Virgin Islands (US)', 1340, 9999);
INSERT INTO `tb_uyruklar` VALUES (241, 'WF', 'Wallis And Futuna Islands', 681, 9999);
INSERT INTO `tb_uyruklar` VALUES (242, 'EH', 'Western Sahara', 212, 9999);
INSERT INTO `tb_uyruklar` VALUES (243, 'YE', 'Yemen', 967, 9999);
INSERT INTO `tb_uyruklar` VALUES (244, 'YU', 'Yugoslavia', 38, 9999);
INSERT INTO `tb_uyruklar` VALUES (245, 'ZM', 'Zambia', 260, 9999);
INSERT INTO `tb_uyruklar` VALUES (246, 'ZW', 'Zimbabwe', 263, 9999);

-- ----------------------------
-- Table structure for tb_yetki
-- ----------------------------
DROP TABLE IF EXISTS `tb_yetki`;
CREATE TABLE `tb_yetki`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kullanici_id` int NULL DEFAULT NULL,
  `modul_id` int NULL DEFAULT NULL,
  `yetki_islem_turu_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_yetki
-- ----------------------------

-- ----------------------------
-- Table structure for tb_yetki_islem_turleri
-- ----------------------------
DROP TABLE IF EXISTS `tb_yetki_islem_turleri`;
CREATE TABLE `tb_yetki_islem_turleri`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  `gorunen_adi` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 57 CHARACTER SET = utf8 COLLATE = utf8_turkish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tb_yetki_islem_turleri
-- ----------------------------
INSERT INTO `tb_yetki_islem_turleri` VALUES (1, 'goruntule', 'Görüntüle');
INSERT INTO `tb_yetki_islem_turleri` VALUES (2, 'ekle', 'Ekle');
INSERT INTO `tb_yetki_islem_turleri` VALUES (3, 'sil', 'Sil');
INSERT INTO `tb_yetki_islem_turleri` VALUES (4, 'duzenle', 'Düzenle');
INSERT INTO `tb_yetki_islem_turleri` VALUES (5, 'kaydet', 'Kaydet');
INSERT INTO `tb_yetki_islem_turleri` VALUES (6, 'rapor', 'Rapor Al');
INSERT INTO `tb_yetki_islem_turleri` VALUES (10, 'super', 'Super Yetki Ataması');
INSERT INTO `tb_yetki_islem_turleri` VALUES (11, 'rol-degistir', 'Kullanıcı Rol Değiştir');
INSERT INTO `tb_yetki_islem_turleri` VALUES (42, 'gorevli-ekle', 'Ders Öğretim  Görevlisi Ekle');
INSERT INTO `tb_yetki_islem_turleri` VALUES (43, 'gorevli-listesi', 'Ders Ogretim Gorevlisi ');
INSERT INTO `tb_yetki_islem_turleri` VALUES (44, 'kategori-ekle', 'Kategori Ekle');
INSERT INTO `tb_yetki_islem_turleri` VALUES (47, 'detaylar', 'Detaylar');
INSERT INTO `tb_yetki_islem_turleri` VALUES (48, 'guncelle', 'Guncelle');
INSERT INTO `tb_yetki_islem_turleri` VALUES (49, 'secenek-ekle', 'Seçenek Ekle');
INSERT INTO `tb_yetki_islem_turleri` VALUES (50, 'ogrenci-listesi', 'Öğrenci Listesi');
INSERT INTO `tb_yetki_islem_turleri` VALUES (51, 'ogrenci-ekle', 'Öğrenci Ekle');
INSERT INTO `tb_yetki_islem_turleri` VALUES (52, 'ogrenci-cikar', 'Öğrenci Çıkar');
INSERT INTO `tb_yetki_islem_turleri` VALUES (53, 'sorular', 'Soru Lisetesi');
INSERT INTO `tb_yetki_islem_turleri` VALUES (54, 'soru-ekle', 'Soru Ekle');
INSERT INTO `tb_yetki_islem_turleri` VALUES (55, 'soru-cikar', 'Soru Çıkar');
INSERT INTO `tb_yetki_islem_turleri` VALUES (56, 'sinav-soru-sil', 'Sınav Sorusu Sil');

-- ----------------------------
-- View structure for view_giris_kontrol
-- ----------------------------
DROP VIEW IF EXISTS `view_giris_kontrol`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `view_giris_kontrol` AS select `tb_sistem_kullanici`.`id` AS `id`,`tb_sistem_kullanici`.`adi` AS `adi`,`tb_sistem_kullanici`.`soyadi` AS `soyadi`,`tb_sistem_kullanici`.`email` AS `email`,`tb_sistem_kullanici`.`sifre` AS `sifre`,`tb_sistem_kullanici`.`resim` AS `resim`,`tb_sistem_kullanici`.`rol_id` AS `rol_id`,`tb_sistem_kullanici`.`super` AS `super`,`tb_sistem_kullanici`.`universiteler` AS `universite_id`,`tb_sistem_kullanici`.`kullanici_turu` AS `kullanici_turu` from `tb_sistem_kullanici` union select `o`.`id` AS `id`,`o`.`adi` AS `adi`,`o`.`soyadi` AS `soyadi`,`o`.`email` AS `email`,`o`.`sifre` AS `sifre`,`o`.`resim` AS `resim`,`o`.`rol_id` AS `rol_id`,`o`.`super` AS `super`,`o`.`universite_id` AS `universite_id`,`o`.`kullanici_turu` AS `kullanici_turu` from `tb_ogrenciler` `o` union select `tb_ogretim_elemanlari`.`id` AS `id`,`tb_ogretim_elemanlari`.`adi` AS `adi`,`tb_ogretim_elemanlari`.`soyadi` AS `soyadi`,`tb_ogretim_elemanlari`.`email` AS `email`,`tb_ogretim_elemanlari`.`sifre` AS `sifre`,`tb_ogretim_elemanlari`.`resim` AS `resim`,`tb_ogretim_elemanlari`.`rol_id` AS `rol_id`,`tb_ogretim_elemanlari`.`super` AS `super`,`tb_ogretim_elemanlari`.`universite_id` AS `universite_id`,`tb_ogretim_elemanlari`.`kullanici_turu` AS `kullanici_turu` from `tb_ogretim_elemanlari` ; ;

SET FOREIGN_KEY_CHECKS = 1;
