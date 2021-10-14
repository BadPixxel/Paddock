DROP TABLE IF EXISTS `Table-A`;

CREATE TABLE `Table-A` (
                           `id` mediumint(8) unsigned NOT NULL auto_increment,
                           `phone` varchar(100) default NULL,
                           `name` varchar(255) default NULL,
                           `postalZip` varchar(10) default NULL,
                           `region` varchar(50) default NULL,
                           `country` varchar(100) default NULL,
                           `email` varchar(255) default NULL,
                           `address` varchar(255) default NULL,
                           `list` varchar(255) default NULL,
                           `alphanumeric` varchar(255),
                           `currency` varchar(100) default NULL,
                           `numberrange` mediumint default NULL,
                           `text` TEXT default NULL,
                           PRIMARY KEY (`id`)
) AUTO_INCREMENT=1;

INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-413-447-7643","Debra Gordon","97196","SK","New Zealand","urna.justo.faucibus@eratvolutpat.org","675-5565 Et Av.","3","DYS19SHA2QJ","$49.79",1,"est arcu ac orci. Ut semper pretium neque. Morbi quis"),
    ("(523) 346-6422","Gabriel Beard","38360","LA","Russian Federation","enim.sit@risusnulla.com","Ap #129-9349 Sit Rd.","3","OGE81YOS5VL","$55.81",2,"urna. Nunc quis arcu vel quam dignissim pharetra. Nam ac"),
    ("1-934-511-6797","Aidan Butler","34372","PI","Indonesia","duis.sit@duinectempus.edu","Ap #637-1654 Nunc. Street","9","VFW89ERD6NW","$58.08",2,"Curae Phasellus ornare. Fusce mollis. Duis sit amet diam eu"),
    ("(783) 995-7278","Malik Alvarez","44642","NU","Sweden","sociosqu@seddictumeleifend.ca","P.O. Box 372, 4104 Placerat, Rd.","7","TGB47KUD6QD","$81.13",1,"est. Mauris eu turpis. Nulla aliquet. Proin velit. Sed malesuada"),
    ("(691) 551-2254","Larissa Gamble","67608","BC","France","aliquam.erat.volutpat@elitfermentumrisus.org","211-8239 Sed Rd.","9","XOR85RBV6YP","$8.86",8,"sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus"),
    ("1-418-863-5556","Steven Mcintosh","77763","PI","United States","vel.faucibus.id@ac.net","Ap #274-5171 Metus Av.","3","FTS53PVH2FN","$52.81",1,"lorem, luctus ut, pellentesque eget, dictum placerat, augue. Sed molestie."),
    ("(326) 171-7042","William Marsh","40138","NS","Vietnam","aliquam.nisl@enim.net","912-3279 Ac, St.","5","MPR59OYC1EA","$20.25",9,"non enim. Mauris quis turpis vitae purus gravida sagittis. Duis"),
    ("1-865-851-6121","Todd Bentley","68651","PR","Nigeria","donec.tempor@velitjusto.ca","Ap #560-6704 Cras St.","1","QDH36JPD3RC","$15.72",4,"nonummy ipsum non arcu. Vivamus sit amet risus. Donec egestas."),
    ("1-736-382-2555","Meredith Mccoy","16448","PE","India","fames@arcuetpede.net","P.O. Box 403, 9512 Quis Av.","15","RKP15EPA7SC","$30.93",0,"tellus faucibus leo, in lobortis tellus justo sit amet nulla."),
    ("1-892-487-6796","Fleur Haney","68507","AL","Chile","nisl.maecenas@atsemmolestie.org","P.O. Box 602, 7393 Nascetur St.","9","OWZ94SSH5AD","$21.93",3,"Quisque varius. Nam porttitor scelerisque neque. Nullam nisl. Maecenas malesuada");
INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("(498) 889-0131","Daryl Osborne","33756","CO","France","enim.nec@gravida.com","280-8799 Mollis Ave","5","NPD61QHM4JW","$33.06",8,"eu metus. In lorem. Donec elementum, lorem ut aliquam iaculis,"),
    ("1-757-438-8630","Xenos Fletcher","83378","LI","Belgium","elementum.purus@sodalesnisi.net","Ap #801-3534 Praesent Ave","17","WQH22PQB7JN","$20.59",1,"elit sed consequat auctor, nunc nulla vulputate dui, nec tempus"),
    ("1-553-258-2714","Vanna Drake","31553","AB","Canada","libero.morbi@velitpellentesque.net","283-1090 Magna. Street","1","IYG61RSP5WQ","$35.58",4,"nascetur ridiculus mus. Proin vel arcu eu odio tristique pharetra."),
    ("1-172-288-7315","James Miller","85124","BR","Pakistan","dignissim.lacus.aliquam@nam.com","Ap #698-4187 Sit Rd.","11","EDP75OUU4NX","$30.10",2,"nostra, per inceptos hymenaeos. Mauris ut quam vel sapien imperdiet"),
    ("1-412-795-6555","Warren Mcgee","82637","NT","Canada","quisque.libero@eu.org","Ap #238-7556 Dui. Av.","7","ONI41MXY7WC","$78.07",3,"orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam eu,"),
    ("1-251-580-9484","Randall Mayo","76715","LA","United Kingdom","auctor.vitae@metusfacilisis.org","Ap #797-8904 Ornare. St.","3","ENY29FCW1SU","$25.80",8,"ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat"),
    ("(615) 240-4316","Macy Santana","60137","ON","United Kingdom","penatibus.et@inatpede.co.uk","1534 Vitae, Ave","13","WSG75AEB0UF","$67.36",5,"pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus"),
    ("(731) 183-2470","Adrian Wolf","62648","PR","Brazil","lorem.luctus.ut@augueid.net","4035 Suspendisse St.","5","IJO84PGR7RF","$32.31",4,"eu turpis. Nulla aliquet. Proin velit. Sed malesuada augue ut"),
    ("1-983-588-6021","Zahir Pugh","03437","NB","Australia","dis.parturient@pellentesque.com","3416 Cursus. St.","1","JMN18MZB0PL","$56.23",4,"neque sed dictum eleifend, nunc risus varius orci, in consequat"),
    ("1-512-597-7256","Wynter Travis","54282","AB","Brazil","duis.volutpat.nunc@primis.com","435-1789 Ultricies Road","1","XLJ39TOE8VJ","$58.09",0,"luctus. Curabitur egestas nunc sed libero. Proin sed turpis nec");
INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-402-430-8634","Xanthus Paul","50491","BR","United Kingdom","non.arcu@ipsumsodales.ca","960-9979 In Street","7","SKM29VHY5DN","$45.94",10,"aliquet, metus urna convallis erat, eget tincidunt dui augue eu"),
    ("1-148-678-7116","Jennifer Leblanc","37450","ON","Russian Federation","nulla.tempor.augue@ametorci.edu","702-1959 Metus. Av.","15","XAZ76TXF5AA","$57.70",2,"luctus lobortis. Class aptent taciti sociosqu ad litora torquent per"),
    ("1-697-204-7283","Quemby Bates","28537","AU","Spain","nulla.tincidunt@vestibulummauris.com","334-9248 Tortor. Avenue","17","MXR17FHK8ML","$93.17",5,"malesuada vel, convallis in, cursus et, eros. Proin ultrices. Duis"),
    ("(690) 814-7830","Yoshi Adkins","95272","BC","Poland","pede.nonummy@convallisin.edu","Ap #630-5374 Eget Av.","19","JPC22DPV2QK","$55.49",3,"sed pede nec ante blandit viverra. Donec tempus, lorem fringilla"),
    ("(304) 174-1505","Arden Holder","09386","CH","Poland","lorem.fringilla.ornare@lacus.com","Ap #674-8609 Nunc Ave","1","GFD55YPO7YM","$30.82",9,"erat volutpat. Nulla facilisis. Suspendisse commodo tincidunt nibh. Phasellus nulla."),
    ("(689) 232-7805","Halla James","61986","PA","Netherlands","libero@donectincidunt.org","Ap #124-433 Pede, St.","17","JWO67VRN8HS","$57.72",7,"cursus luctus, ipsum leo elementum sem, vitae aliquam eros turpis"),
    ("1-673-264-3215","Selma Buck","43004","NT","Mexico","curabitur.vel@eratvolutpat.com","Ap #231-9701 Nam St.","3","IVE51LNZ0FH","$58.51",6,"quam vel sapien imperdiet ornare. In faucibus. Morbi vehicula. Pellentesque"),
    ("(438) 552-6542","Timothy Russo","72631","PE","New Zealand","aliquet@loremvitae.ca","6381 Porttitor Rd.","1","TED55GCV6AE","$72.59",4,"dolor. Donec fringilla. Donec feugiat metus sit amet ante. Vivamus"),
    ("(742) 485-3912","Halee Howe","24614","HA","Russian Federation","semper.erat.in@eueros.org","6611 Cras Avenue","13","ODN34WKD3YM","$50.24",5,"dolor dolor, tempus non, lacinia at, iaculis quis, pede. Praesent"),
    ("(867) 154-7314","Hilary Burns","82118","NU","Australia","fringilla.euismod.enim@egestas.edu","P.O. Box 613, 5916 Sollicitudin Rd.","15","DSM35JFG7HR","$2.42",2,"Quisque porttitor eros nec tellus. Nunc lectus pede, ultrices a,");
INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-405-937-9684","Chaney Velasquez","26377","PI","Canada","diam.nunc.ullamcorper@infaucibus.ca","Ap #613-7075 Sed Ave","9","GHU72LHU7QF","$84.43",4,"dapibus gravida. Aliquam tincidunt, nunc ac mattis ornare, lectus ante"),
    ("1-336-213-1758","Raven Mccarty","55336","IL","Russian Federation","nunc.laoreet@orcilacusvestibulum.com","Ap #791-6788 Sagittis. Ave","11","CQY23OUL3RO","$33.16",3,"sit amet ultricies sem magna nec quam. Curabitur vel lectus."),
    ("1-266-119-5611","Jasmine Watts","94473","BO","Nigeria","quisque.nonummy@nibhvulputatemauris.ca","Ap #798-227 Donec Avenue","1","UEZ34GXW3BJ","$96.57",6,"amet massa. Quisque porttitor eros nec tellus. Nunc lectus pede,"),
    ("(168) 759-5105","Bernard Ellison","46340","NT","Poland","mi.aliquam.gravida@donecfelisorci.com","178-6040 Diam. Rd.","5","JGO11EPL5DY","$55.29",6,"consectetuer euismod est arcu ac orci. Ut semper pretium neque."),
    ("1-483-121-8257","Akeem Moreno","35134","BO","Brazil","mauris@adlitora.net","Ap #200-6520 Cras St.","11","FXT12PLU8CB","$40.57",3,"lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies"),
    ("1-601-569-7102","Uriel Wyatt","58848","MI","Turkey","augue@donecdignissimmagna.org","P.O. Box 277, 1187 Leo. Ave","13","IPJ95YJN9OL","$11.64",6,"lobortis risus. In mi pede, nonummy ut, molestie in, tempus"),
    ("(551) 500-5138","Oleg Wooten","87609","YT","Italy","libero@conubia.edu","5115 Lacinia Avenue","11","UKD12ZKI8FP","$92.31",7,"molestie dapibus ligula. Aliquam erat volutpat. Nulla dignissim. Maecenas ornare"),
    ("1-536-316-1166","Zeph Romero","06365","NT","Spain","parturient.montes@nuncestmollis.org","P.O. Box 637, 3217 Elit. Rd.","5","SBX22LKI8RA","$15.60",2,"nisi. Mauris nulla. Integer urna. Vivamus molestie dapibus ligula. Aliquam"),
    ("(398) 544-1141","Neville Rosales","50994","PA","United States","ligula.aenean.euismod@diameu.com","679-1893 Ultrices Av.","5","MUU02BWI9XV","$84.83",6,"eu nulla at sem molestie sodales. Mauris blandit enim consequat"),
    ("1-558-894-6254","Colton Castillo","25663","SK","India","felis@gravidaaliquam.ca","Ap #237-5235 Id, Road","9","VYT60KNV4UI","$51.99",6,"ullamcorper eu, euismod ac, fermentum vel, mauris. Integer sem elit,");
INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-291-568-5881","Madison Camacho","94823","LO","Belgium","orci@sodales.edu","Ap #785-6991 Augue Rd.","19","EPO29BDR3QU","$71.50",5,"viverra. Maecenas iaculis aliquet diam. Sed diam lorem, auctor quis,"),
    ("1-417-772-7376","Samuel Suarez","27113","NL","Peru","facilisis@gravidasagittis.net","807-2746 Malesuada Road","3","YTK97IIN8QM","$13.02",7,"feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam"),
    ("(428) 374-3851","Germane Howell","41456","AQ","Austria","est@aliquet.ca","427-4332 Ullamcorper, Road","9","PTU63MLG8GG","$40.83",5,"facilisis eget, ipsum. Donec sollicitudin adipiscing ligula. Aenean gravida nunc"),
    ("1-851-697-1205","Christen Ryan","96710","AB","Indonesia","nunc.nulla@luctusipsumleo.net","Ap #901-5225 Mi Rd.","13","NRL15JLH3OJ","$33.42",5,"Pellentesque tincidunt tempus risus. Donec egestas. Duis ac arcu. Nunc"),
    ("(996) 887-3817","Eagan Clemons","94854","AU","Chile","vel.arcu@nullamvitae.net","Ap #644-6044 Magnis Road","13","JFJ15TOF0WV","$58.03",8,"lobortis tellus justo sit amet nulla. Donec non justo. Proin"),
    ("1-267-356-7348","Alexandra Kim","31449","NS","Chile","molestie.in@lobortisquis.org","Ap #612-1441 Malesuada Street","15","EFB13QFZ9PH","$99.40",2,"et, euismod et, commodo at, libero. Morbi accumsan laoreet ipsum."),
    ("(572) 815-3802","Sandra Andrews","58684","AB","Peru","eu.erat@proin.org","P.O. Box 739, 9780 Mi St.","9","AKU21YLE9GR","$74.74",0,"enim. Etiam imperdiet dictum magna. Ut tincidunt orci quis lectus."),
    ("(826) 272-3859","Octavius Burch","30407","NB","South Korea","a.sollicitudin@enimsit.com","247-5408 Nam Road","15","DUO78PXE8CF","$7.75",7,"semper pretium neque. Morbi quis urna. Nunc quis arcu vel"),
    ("1-806-762-3066","Garrison Moss","82336","NB","Germany","dui.lectus@aodio.edu","Ap #653-2503 Odio. Av.","19","YWK53UOX3FP","$44.54",1,"tincidunt aliquam arcu. Aliquam ultrices iaculis odio. Nam interdum enim"),
    ("1-312-246-9822","Valentine Beach","49444","NU","Netherlands","sed@urna.co.uk","458-1813 Fringilla, Rd.","1","PPC75EUZ0MF","$0.31",8,"augue porttitor interdum. Sed auctor odio a purus. Duis elementum,");
INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-574-331-3713","Ira Ray","63938","AB","Italy","dui.augue.eu@ultricesposuere.org","Ap #828-2202 Fusce Rd.","1","ZWR96KIH8DA","$78.98",3,"nunc sed pede. Cum sociis natoque penatibus et magnis dis"),
    ("1-825-773-5868","Hall Hatfield","81372","BR","Peru","sollicitudin.a.malesuada@sapienaenean.org","913-4383 Interdum. Rd.","7","LTY68WQQ7PH","$14.29",1,"dolor. Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing"),
    ("(662) 789-6553","Alexander Fleming","30435","NT","Germany","ligula.nullam@et.edu","645-3791 Bibendum. Rd.","19","NGX12CMR0YO","$25.70",8,"Aliquam auctor, velit eget laoreet posuere, enim nisl elementum purus,"),
    ("1-320-227-4679","David Goodman","66874","PE","Austria","eu.nulla@mauris.org","820 Ante Rd.","3","NVV67PPS5RF","$73.38",1,"nunc nulla vulputate dui, nec tempus mauris erat eget ipsum."),
    ("(436) 326-1112","Karly Williamson","65618","LI","France","sollicitudin@integer.edu","3177 Odio Rd.","15","JYT84XPO8SI","$23.60",1,"ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem"),
    ("1-310-280-5185","Yuli Cooley","17565","BC","Italy","fames.ac@antenunc.net","Ap #438-8257 Donec Rd.","11","BUI15TYD2HI","$24.15",6,"placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet,"),
    ("(154) 336-2663","May Sawyer","96386","BC","Austria","tempor.augue@posuere.co.uk","Ap #423-9994 Fermentum Ave","13","INY59KBH5TA","$10.27",9,"nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus"),
    ("1-168-450-7361","Jesse Higgins","76418","NU","Peru","at@ultricessit.edu","Ap #910-7768 Dolor. Rd.","15","ULH79UWF6HH","$90.12",0,"mollis vitae, posuere at, velit. Cras lorem lorem, luctus ut,"),
    ("(580) 424-2503","Micah Michael","73559","LI","Vietnam","ipsum.dolor@portaelita.co.uk","111-6824 Nisi Avenue","15","QRH76MCI3SY","$0.43",8,"arcu iaculis enim, sit amet ornare lectus justo eu arcu."),
    ("1-468-227-0908","Rana Peterson","67785","AB","South Korea","vitae.nibh@ametdiameu.ca","5420 Quisque Rd.","9","JCA70YPB8KZ","$68.77",3,"aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare sagittis");
INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-882-586-4104","Kasimir Shelton","94681","NU","Peru","ac.metus@conguea.edu","5743 Sed Ave","3","RSE31KKJ5RI","$82.21",9,"non arcu. Vivamus sit amet risus. Donec egestas. Aliquam nec"),
    ("1-564-478-2514","Ahmed Lawrence","54217","MB","Netherlands","a.nunc@sagittisplacerat.co.uk","Ap #366-2709 Eu Av.","13","MGF01MVU5MT","$59.44",3,"posuere cubilia Curae Donec tincidunt. Donec vitae erat vel pede"),
    ("1-677-589-3420","Wayne White","74073","ON","Austria","quisque.ac@arcuvel.net","7635 Dui. St.","17","AJE64UKE2XD","$94.09",10,"Donec vitae erat vel pede blandit congue. In scelerisque scelerisque"),
    ("(453) 987-9206","Bernard Norris","57828","IL","United States","donec.tempus@infaucibusorci.org","P.O. Box 163, 209 Vivamus St.","7","VFO37ESM3PR","$99.66",6,"semper et, lacinia vitae, sodales at, velit. Pellentesque ultricies dignissim"),
    ("1-868-264-4706","Jemima Talley","92145","AL","Australia","ut.ipsum@donecluctusaliquet.org","Ap #973-3092 Ipsum. Rd.","13","GTM81CQB1QN","$31.75",5,"ut dolor dapibus gravida. Aliquam tincidunt, nunc ac mattis ornare,"),
    ("(459) 721-5001","Upton Knight","45665","NL","United States","vulputate@nonante.net","Ap #407-426 Lectus. Street","19","TOR02CYW5DN","$90.31",3,"fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat"),
    ("(183) 346-2805","Keith Valenzuela","53419","AB","Peru","proin@aenimsuspendisse.ca","9956 Vulputate Ave","3","QVT30CCE6GF","$3.28",3,"purus gravida sagittis. Duis gravida. Praesent eu nulla at sem"),
    ("1-882-235-1819","Dante Hurley","85947","LO","Russian Federation","vestibulum.neque.sed@faucibusorci.com","Ap #321-7271 Luctus Road","13","HPI12BVH5HB","$16.51",7,"Ut tincidunt vehicula risus. Nulla eget metus eu erat semper"),
    ("(371) 284-3495","Alfreda Haley","22612","NB","Pakistan","in.aliquet@nuncac.net","P.O. Box 477, 839 Ac Street","3","PSQ56XVM1SW","$79.39",6,"amet ultricies sem magna nec quam. Curabitur vel lectus. Cum"),
    ("(115) 641-8285","Emma Moody","76782","SK","United Kingdom","eu.ligula.aenean@donectempuslorem.com","Ap #405-3895 Sed Rd.","11","SUD47WDC4BU","$3.82",7,"dolor. Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing");
INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("(857) 529-7052","Lamar Spears","36277","AU","Germany","dui.cum@cursusluctus.edu","408-8075 Amet Av.","7","TKG27SIQ7EB","$76.18",4,"nibh. Donec est mauris, rhoncus id, mollis nec, cursus a,"),
    ("1-571-503-9741","Cathleen Fry","89180","NT","Turkey","sit@euismodet.org","586-7306 Quisque Road","17","UVO54HLW8CW","$19.68",9,"orci lacus vestibulum lorem, sit amet ultricies sem magna nec"),
    ("(615) 457-5338","Garrett Maynard","66765","ON","Colombia","non.quam.pellentesque@faucibuslectus.org","669-5225 At Street","13","YWK72WSP7GF","$9.49",8,"Donec dignissim magna a tortor. Nunc commodo auctor velit. Aliquam"),
    ("(130) 576-3855","Irma Delaney","34122","CE","Vietnam","varius@orciadipiscing.edu","699-7068 Vulputate Road","11","NXE76EZL3MY","$98.22",6,"Proin non massa non ante bibendum ullamcorper. Duis cursus, diam"),
    ("1-503-144-6488","Harding Baldwin","46566","NS","Austria","blandit@crasdolor.com","Ap #834-384 Sociis Avenue","19","IMR21JLL2XM","$80.52",1,"nulla at sem molestie sodales. Mauris blandit enim consequat purus."),
    ("1-107-954-7256","Maryam Campbell","56508","CH","Austria","mollis.lectus@lacusnulla.ca","546-3828 Nulla St.","17","ZDT88OXZ1ZJ","$6.58",0,"non justo. Proin non massa non ante bibendum ullamcorper. Duis"),
    ("(895) 632-2791","Ross Roberson","14895","LO","Australia","aenean.egestas@nullacras.co.uk","891-1290 Montes, St.","3","NJU27FIM9OI","$3.80",3,"non, feugiat nec, diam. Duis mi enim, condimentum eget, volutpat"),
    ("(223) 223-9668","Lavinia Dejesus","72562","AQ","Ireland","auctor.nunc@nisicum.ca","P.O. Box 488, 1416 Dolor Ave","15","EOS54SMF3NX","$57.77",5,"odio. Aliquam vulputate ullamcorper magna. Sed eu eros. Nam consequat"),
    ("1-784-948-8852","Cade Rogers","65364","MB","South Korea","lectus.rutrum@aeneaneget.co.uk","Ap #856-7180 Enim Street","19","PVG45TIP1BE","$42.44",5,"non, dapibus rutrum, justo. Praesent luctus. Curabitur egestas nunc sed"),
    ("(881) 558-3138","Dane Tran","79494","SK","New Zealand","diam@vitae.co.uk","967-8684 Donec Street","5","AIW34UPU8GX","$69.23",1,"in consectetuer ipsum nunc id enim. Curabitur massa. Vestibulum accumsan");
INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-853-345-4341","Francesca Gamble","21826","NU","Colombia","dolor.dapibus@duisat.net","Ap #388-4747 Proin St.","13","QPL78XNW9UC","$63.17",10,"erat. Etiam vestibulum massa rutrum magna. Cras convallis convallis dolor."),
    ("1-584-468-8851","Plato Gray","89878","PE","Sweden","nec@sem.net","Ap #943-9936 Dui St.","9","MQK54SXL4LK","$82.30",8,"Pellentesque habitant morbi tristique senectus et netus et malesuada fames"),
    ("1-221-648-2749","Plato Carter","88387","ON","Mexico","justo.proin.non@morbinonsapien.ca","287-9737 Proin St.","15","LYF66HZH6XM","$47.46",8,"ultrices. Duis volutpat nunc sit amet metus. Aliquam erat volutpat."),
    ("1-687-746-4437","Ethan Crosby","48354","AL","United Kingdom","ipsum.primis@utlacus.com","134-8238 Nunc Street","15","DQA30QVK8XB","$61.28",4,"Morbi quis urna. Nunc quis arcu vel quam dignissim pharetra."),
    ("1-195-390-9218","Lydia Houston","27218","HA","Vietnam","fermentum.convallis@risusaultricies.net","Ap #874-7258 Ultricies St.","7","DXS18VMO1RO","$39.74",8,"parturient montes, nascetur ridiculus mus. Donec dignissim magna a tortor."),
    ("1-768-304-1752","Mollie Bray","86585","YT","France","ac.orci@praesentluctus.co.uk","222-2677 Neque. Ave","3","JOI29UGF5EY","$57.27",7,"a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque"),
    ("1-831-170-8252","Violet Kerr","47312","SK","Indonesia","tincidunt.vehicula@idenim.com","Ap #155-5558 Ipsum. Rd.","3","XLJ17IRR2FU","$62.84",4,"convallis est, vitae sodales nisi magna sed dui. Fusce aliquam,"),
    ("1-507-134-5125","Emily Avery","69965","FC","Belgium","est@magna.net","279-4081 Convallis, Street","11","TRS38CJJ1LV","$88.01",6,"Nam tempor diam dictum sapien. Aenean massa. Integer vitae nibh."),
    ("(355) 424-7134","Burton Mcgee","15313","MI","Sweden","varius.orci@aliquam.edu","185-2082 Euismod St.","15","CLX73SIS0PW","$73.68",5,"nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae"),
    ("(171) 434-8462","Mona Burnett","44816","NT","Belgium","nibh.sit.amet@ametrisus.com","Ap #289-358 Ultricies St.","17","SYD18TVN6PY","$20.74",5,"sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus");
INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("(457) 395-7158","Brooke Norman","78773","NT","Spain","sed.dictum.eleifend@dolordolortempus.co.uk","Ap #899-9406 At Road","3","PUA22PEJ1FE","$17.84",2,"Nunc mauris. Morbi non sapien molestie orci tincidunt adipiscing. Mauris"),
    ("1-326-642-7031","Kasper Cole","79496","NL","Sweden","erat.vel@velnislquisque.net","Ap #506-4041 Fermentum Av.","17","MKL79WJO3HM","$69.51",2,"Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit"),
    ("1-672-420-7629","Knox Santana","55485","MI","France","nunc.sit@pellentesque.edu","Ap #683-633 Libero. Rd.","17","XDI24YPO1RX","$16.95",3,"risus. Duis a mi fringilla mi lacinia mattis. Integer eu"),
    ("(953) 374-2975","Carlos Bernard","76689","NL","Australia","ullamcorper.magna@aduicras.co.uk","3887 Donec St.","13","MER43OAL9DH","$99.14",1,"luctus ut, pellentesque eget, dictum placerat, augue. Sed molestie. Sed"),
    ("(857) 245-5118","Chaim Santiago","70854","NU","France","pharetra@proin.com","983-2990 Nulla. St.","3","PJX42HTD4VQ","$34.44",5,"Nullam feugiat placerat velit. Quisque varius. Nam porttitor scelerisque neque."),
    ("(221) 468-2541","Kevin Hanson","74272","BC","Nigeria","quis.massa.mauris@tristiquesenectus.com","541-5732 Inceptos Rd.","15","RGU03RGU4NE","$18.57",3,"ipsum nunc id enim. Curabitur massa. Vestibulum accumsan neque et"),
    ("(483) 636-4803","Sade Moss","11805","QC","Poland","aliquam.rutrum@crasvehicula.co.uk","Ap #536-6425 Lobortis Av.","19","JUT85WZV3UP","$4.59",1,"Nullam lobortis quam a felis ullamcorper viverra. Maecenas iaculis aliquet"),
    ("1-459-888-3473","Vance Quinn","41638","NT","Netherlands","a@massanon.ca","Ap #995-9355 Luctus Av.","13","TLX65WIJ8TB","$34.14",2,"dictum mi, ac mattis velit justo nec ante. Maecenas mi"),
    ("1-204-271-5780","Heather Tran","24608","ON","Poland","habitant.morbi.tristique@nullainterdum.edu","657-448 Nec St.","13","XDI44QMJ3JV","$62.40",3,"enim, condimentum eget, volutpat ornare, facilisis eget, ipsum. Donec sollicitudin"),
    ("1-686-434-1967","Heidi Matthews","82594","CO","New Zealand","eros.nec@loremsitamet.edu","614-7986 Velit St.","17","FUF15WSS6UY","$45.50",2,"eu, odio. Phasellus at augue id ante dictum cursus. Nunc");
INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-397-497-1624","Ryder Blake","61850","AU","Australia","eget.lacus@velconvallis.co.uk","860-3694 Aenean Av.","9","DED83KLX1NV","$53.59",3,"ipsum nunc id enim. Curabitur massa. Vestibulum accumsan neque et"),
    ("1-216-923-8426","Maite Hunt","62484","NU","Spain","ultricies.adipiscing@arcusedeu.net","366-4923 Imperdiet Ave","17","GDG57RGY7JJ","$58.47",3,"dictum magna. Ut tincidunt orci quis lectus. Nullam suscipit, est"),
    ("1-508-644-8363","Tanya Foley","50154","NS","Germany","orci.luctus@et.co.uk","302-7943 Ipsum. Rd.","15","VEB48CBF4CB","$77.18",3,"Nam porttitor scelerisque neque. Nullam nisl. Maecenas malesuada fringilla est."),
    ("(231) 334-6480","Stella Cervantes","03450","IL","Nigeria","sodales.elit.erat@urnanullamlobortis.edu","812-6958 Porttitor St.","3","KJE36CIL7HC","$29.74",5,"Sed dictum. Proin eget odio. Aliquam vulputate ullamcorper magna. Sed"),
    ("1-794-322-1538","Micah Dorsey","56126","ON","India","magna@quisqueornare.com","7009 Morbi Ave","15","HBV53BBX6OS","$94.61",9,"Proin mi. Aliquam gravida mauris ut mi. Duis risus odio,"),
    ("(983) 625-5708","Ori Little","52376","PA","Brazil","dolor.sit@tellusid.ca","432-6941 Nulla St.","19","RMN74CPT2GW","$57.26",1,"accumsan sed, facilisis vitae, orci. Phasellus dapibus quam quis diam."),
    ("(670) 260-6380","Dora Stewart","10384","BO","Mexico","magnis.dis@euismodestarcu.co.uk","P.O. Box 864, 2240 Lorem Street","5","TTM42IWI7EX","$10.57",3,"tincidunt. Donec vitae erat vel pede blandit congue. In scelerisque"),
    ("(268) 310-7042","Patience Gilliam","54986","ON","Spain","in.consectetuer.ipsum@morbinonsapien.net","Ap #521-5170 Vitae St.","13","DLV78UUR3JL","$74.80",4,"Etiam bibendum fermentum metus. Aenean sed pede nec ante blandit"),
    ("(608) 559-8724","Jeremy Davenport","76317","FC","Austria","felis.ullamcorper@turpisnecmauris.org","Ap #343-1654 Nunc Rd.","15","LAY72SFT5TV","$4.89",8,"sodales purus, in molestie tortor nibh sit amet orci. Ut"),
    ("(336) 429-9113","Jana Barnes","35509","MB","Mexico","massa.mauris@duifusce.co.uk","453-8652 Tincidunt Rd.","19","UTR49ZEW1OB","$69.93",8,"id sapien. Cras dolor dolor, tempus non, lacinia at, iaculis");
INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-930-445-9489","Selma Buckner","02374","ON","Brazil","dolor.fusce@habitantmorbitristique.net","Ap #361-3491 Proin St.","3","FUR96FVI1PO","$41.17",8,"Vivamus euismod urna. Nullam lobortis quam a felis ullamcorper viverra."),
    ("(415) 329-7821","Tiger Wagner","26276","NT","Mexico","molestie.arcu@gravida.edu","669-7959 Massa. Avenue","3","NOV17ELQ3WG","$68.53",5,"tortor. Nunc commodo auctor velit. Aliquam nisl. Nulla eu neque"),
    ("1-832-241-7868","Indigo Gibbs","54316","BO","Sweden","molestie@tempor.edu","Ap #817-7352 Nisi. Rd.","3","ZTW20LMH4QU","$14.46",7,"pellentesque a, facilisis non, bibendum sed, est. Nunc laoreet lectus"),
    ("(841) 879-2136","Brenda Johnson","61138","NL","Sweden","velit.sed@eros.net","P.O. Box 240, 1652 Quis Avenue","11","CUB73FEQ0EM","$85.24",2,"ultricies adipiscing, enim mi tempor lorem, eget mollis lectus pede"),
    ("1-571-344-1383","Berk Wallace","71486","NO","Turkey","quis.lectus.nullam@magnisdisparturient.com","Ap #990-602 Amet St.","17","SLR33CWU1ST","$22.41",9,"fringilla ornare placerat, orci lacus vestibulum lorem, sit amet ultricies"),
    ("1-122-212-5273","Jescie Rivers","23658","LI","Chile","amet.consectetuer.adipiscing@donec.ca","Ap #901-1271 Dictum Av.","13","BYE32IUM9CC","$10.19",8,"ac, feugiat non, lobortis quis, pede. Suspendisse dui. Fusce diam"),
    ("(870) 443-3402","Carlos Hayes","25279","NT","United Kingdom","nunc.ac@etnetus.edu","Ap #463-6838 Dui, Av.","17","IXA29EXQ5WB","$31.64",2,"mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet,"),
    ("(785) 652-4904","James Berry","68268","NO","Belgium","vivamus.nisi@nuncpulvinararcu.org","7163 Etiam Rd.","1","ROO51NCL2YA","$10.47",4,"suscipit, est ac facilisis facilisis, magna tellus faucibus leo, in"),
    ("1-301-237-7826","Kane Park","75401","FC","Italy","aliquet.nec@eget.net","237-1942 Aliquet Av.","3","BTM92XEG0CR","$56.84",5,"scelerisque neque. Nullam nisl. Maecenas malesuada fringilla est. Mauris eu"),
    ("1-967-385-8565","Hayes Bridges","84618","NL","Vietnam","gravida.mauris.ut@accumsaninterdum.edu","258-9894 Mi Rd.","5","GAP66DHQ9VB","$25.60",8,"sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus");
INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("(122) 482-3963","Dylan Hardin","62735","QC","Pakistan","cursus@donecdignissim.com","6659 Malesuada Avenue","9","GZF71XKJ2XQ","$89.41",9,"accumsan convallis, ante lectus convallis est, vitae sodales nisi magna"),
    ("1-421-148-7765","Odessa Vega","71200","YT","Canada","molestie.dapibus@tellusnon.ca","Ap #155-6379 Blandit Street","17","KUG57DOI8CY","$2.49",6,"eu arcu. Morbi sit amet massa. Quisque porttitor eros nec"),
    ("1-825-666-0123","Benedict Hutchinson","93676","NT","South Korea","dui.lectus@hendreritidante.edu","6929 Ut Ave","5","COE30WDA3GH","$76.83",5,"justo nec ante. Maecenas mi felis, adipiscing fringilla, porttitor vulputate,"),
    ("1-585-566-1467","Tatyana Barr","76148","AQ","Mexico","vel.convallis.in@estcongue.ca","175-5733 Felis. Av.","5","DOA29BON8QT","$86.01",3,"rhoncus. Proin nisl sem, consequat nec, mollis vitae, posuere at,"),
    ("1-478-231-7142","Jakeem Mcguire","66486","YT","Netherlands","iaculis.aliquet@rutrumfusce.org","Ap #537-3187 Ultrices. Road","1","EFZ12DHL2XX","$79.04",8,"metus. In lorem. Donec elementum, lorem ut aliquam iaculis, lacus"),
    ("(549) 781-4113","Nerea Short","32244","AU","United Kingdom","quis.turpis@posuerecubilia.co.uk","135-9311 Hymenaeos. Rd.","5","CNO99QJT7FH","$61.77",3,"orci luctus et ultrices posuere cubilia Curae Phasellus ornare. Fusce"),
    ("1-662-775-5657","Oscar Justice","11853","NL","India","praesent@ultriciessem.com","P.O. Box 877, 6685 Nunc Rd.","3","JGB55FKW5WF","$8.92",8,"Cras interdum. Nunc sollicitudin commodo ipsum. Suspendisse non leo. Vivamus"),
    ("1-793-480-3067","Ria Gardner","56634","CO","New Zealand","interdum@elitfermentum.org","9150 Neque St.","11","YMI64JND3BY","$62.16",1,"tristique pellentesque, tellus sem mollis dui, in sodales elit erat"),
    ("(447) 835-6951","Kyla Jarvis","54675","PE","Nigeria","blandit.nam.nulla@ligulaeu.co.uk","P.O. Box 200, 5832 Porta Rd.","5","DOJ81JTR0JV","$87.64",6,"malesuada augue ut lacus. Nulla tincidunt, neque vitae semper egestas,"),
    ("1-284-464-1190","Keane Mccray","88737","BR","Vietnam","molestie@ornarefusce.edu","Ap #354-8044 Mi Rd.","3","MDV19YSG9XV","$84.71",1,"Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy");
INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("(224) 589-4637","Preston Mcintyre","32712","LI","Italy","integer.mollis.integer@ante.ca","584-5096 Ut St.","5","GTK39BOB4IL","$67.70",1,"erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor."),
    ("1-438-712-4070","Quynn Head","29227","YT","Nigeria","facilisis@acrisus.net","2207 Ut Avenue","3","PID08ZAC4ZE","$20.02",6,"dui nec urna suscipit nonummy. Fusce fermentum fermentum arcu. Vestibulum"),
    ("1-556-663-5459","Jacqueline Walls","34576","LA","Canada","convallis.dolor@etultrices.edu","600-8958 Nec Street","11","KNT67WLE4TH","$61.66",9,"arcu. Vestibulum ante ipsum primis in faucibus orci luctus et"),
    ("(536) 782-3032","Jerry Estes","14197","PO","Indonesia","pulvinar@maurisut.edu","Ap #605-3496 Semper Ave","9","VCH11JEL6CQ","$39.93",7,"Fusce aliquam, enim nec tempus scelerisque, lorem ipsum sodales purus,"),
    ("1-183-686-3321","Darryl Thomas","85332","ON","Peru","vulputate.ullamcorper@turpisin.edu","1630 Nunc Rd.","3","VLQ43QQB1HO","$17.50",7,"ac tellus. Suspendisse sed dolor. Fusce mi lorem, vehicula et,"),
    ("1-359-654-4206","Hiram Swanson","53351","NU","Germany","elit@consectetueradipiscing.org","Ap #987-6908 Sagittis. St.","19","NVZ79LQW9CP","$70.91",9,"urna, nec luctus felis purus ac tellus. Suspendisse sed dolor."),
    ("(842) 394-2158","Ferris Knapp","84018","NS","South Korea","urna.justo@nec.ca","P.O. Box 362, 4623 Eleifend. Avenue","11","IWD46CQY8PY","$14.41",9,"diam at pretium aliquet, metus urna convallis erat, eget tincidunt"),
    ("1-245-667-7436","Armando Payne","32251","AQ","Colombia","nisi.dictum.augue@telluseu.ca","Ap #853-7836 Commodo St.","5","CNW65VXQ5FF","$87.97",6,"lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada id,"),
    ("(628) 423-5698","Erin Houston","75062","CH","Brazil","id@quisque.ca","950-2047 Arcu St.","5","OYI71BVZ1DY","$74.40",4,"placerat velit. Quisque varius. Nam porttitor scelerisque neque. Nullam nisl."),
    ("1-276-438-3878","James Nash","50288","BC","Spain","eu.enim@turpisegestas.edu","Ap #538-9533 Aliquam Rd.","7","OUJ42UCG3YS","$64.92",4,"ornare placerat, orci lacus vestibulum lorem, sit amet ultricies sem");
INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("(654) 474-7764","Cole Mathis","14049","NS","Turkey","pellentesque.a@parturientmontes.edu","Ap #116-6951 Nec, Rd.","7","GUJ62VCP9FH","$96.06",3,"Nam ac nulla. In tincidunt congue turpis. In condimentum. Donec"),
    ("1-269-625-9282","Quinlan Mcdaniel","98891","BC","Russian Federation","ac@diam.com","Ap #240-8355 Pellentesque Rd.","17","JSE14LQS2DE","$55.22",7,"risus. Donec egestas. Duis ac arcu. Nunc mauris. Morbi non"),
    ("(245) 311-0481","Genevieve Ramirez","12527","QC","Brazil","aenean.eget@interdumsed.ca","Ap #547-9921 Dui Road","13","WLR45DVC6KP","$92.18",9,"eu tellus eu augue porttitor interdum. Sed auctor odio a"),
    ("1-129-863-4766","Colette Poole","68715","CE","France","enim.etiam@et.co.uk","598-4419 Integer Avenue","5","RUL26VWY7YD","$51.47",10,"Nullam lobortis quam a felis ullamcorper viverra. Maecenas iaculis aliquet"),
    ("1-371-272-8966","Chanda Johns","41375","SK","Belgium","ac@laoreetipsum.org","107-4587 Ut Av.","15","JEE17SYY2KF","$8.88",1,"In nec orci. Donec nibh. Quisque nonummy ipsum non arcu."),
    ("(771) 699-4951","Salvador Dickson","26792","AL","United States","porttitor.vulputate.posuere@estcongue.com","Ap #143-337 In St.","7","IEG77XJS8CS","$64.64",1,"lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum"),
    ("1-915-418-7855","Nelle Smith","26514","NU","South Korea","et@nulla.net","518-4148 Dui, Avenue","13","BEZ08WNJ2DP","$37.62",3,"tempus scelerisque, lorem ipsum sodales purus, in molestie tortor nibh"),
    ("1-548-841-7974","Ava Mcdowell","64191","CE","Mexico","dui.lectus@vitaeeratvivamus.net","344-9799 Nec Av.","13","HYN13JQZ2RN","$35.56",5,"mauris, aliquam eu, accumsan sed, facilisis vitae, orci. Phasellus dapibus"),
    ("1-225-636-5515","Chelsea Mcmahon","32206","PA","Nigeria","volutpat.nulla@pellentesquehabitant.org","193-9581 Vulputate Rd.","3","CAW88MBK5FI","$29.02",4,"imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem"),
    ("(805) 516-0844","Elton Beach","44535","PE","Ireland","lectus.convallis.est@nullafacilisi.ca","Ap #656-2399 Auctor Avenue","15","AHV95GGA1TS","$12.61",4,"ante dictum cursus. Nunc mauris elit, dictum eu, eleifend nec,");
INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-921-124-7175","Riley Kramer","46674","HA","Peru","vehicula@dui.net","Ap #287-6213 Fusce Rd.","7","RMD76JBZ1UC","$44.34",9,"ante dictum cursus. Nunc mauris elit, dictum eu, eleifend nec,"),
    ("1-128-425-9313","Laura Macdonald","72879","QC","Costa Rica","id.nunc@sed.org","Ap #743-7923 Mauris Ave","13","RLT51FUT3CP","$45.06",2,"ut odio vel est tempor bibendum. Donec felis orci, adipiscing"),
    ("1-395-344-4805","Dante Bright","31406","BA","Sweden","mauris.rhoncus@anunc.ca","Ap #513-6106 Integer St.","15","ARQ38VJI2JY","$3.41",5,"sodales purus, in molestie tortor nibh sit amet orci. Ut"),
    ("(424) 718-6118","Jaden Horton","48850","YT","Italy","nulla.integer@metusaliquamerat.com","Ap #858-5876 Convallis Ave","17","NBP58QIT9CW","$99.13",10,"amet massa. Quisque porttitor eros nec tellus. Nunc lectus pede,"),
    ("1-747-714-2412","Leslie Curtis","71289","AB","Russian Federation","sagittis.nullam@pellentesquetincidunt.ca","Ap #494-933 Lobortis Av.","19","TMJ33DOE9WT","$48.06",3,"Cras sed leo. Cras vehicula aliquet libero. Integer in magna."),
    ("1-427-868-7898","Frances Ferguson","96616","MB","Russian Federation","velit.pellentesque.ultricies@risusvarius.net","5069 Tellus, Ave","7","ITB98YAF0IB","$20.92",5,"nec, eleifend non, dapibus rutrum, justo. Praesent luctus. Curabitur egestas"),
    ("1-115-358-7586","Sybil Puckett","72536","NO","Peru","est.mauris.eu@vivamus.co.uk","Ap #364-4133 Gravida Ave","9","FMR88NBO8CW","$80.48",1,"nisl. Maecenas malesuada fringilla est. Mauris eu turpis. Nulla aliquet."),
    ("(845) 533-1117","Herman Ellis","54610","NB","New Zealand","luctus@utsemperpretium.net","798-9181 Penatibus St.","1","TMB94NUZ7KO","$26.83",8,"habitant morbi tristique senectus et netus et malesuada fames ac"),
    ("(547) 325-6227","Mary Stephenson","57224","NB","Sweden","quis.massa@ipsumcurabitur.com","P.O. Box 569, 1749 Morbi Ave","17","TRQ99IFD1GJ","$61.14",7,"lorem, vehicula et, rutrum eu, ultrices sit amet, risus. Donec"),
    ("1-716-448-5135","Basia Buck","16557","NB","Costa Rica","ipsum@dapibusrutrum.com","863-9179 Metus. Ave","11","VJE21DZT6LE","$64.58",1,"lacus vestibulum lorem, sit amet ultricies sem magna nec quam.");
INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-884-422-6242","Colton Morton","76340","MB","Russian Federation","quis@suspendisse.org","Ap #851-9119 Nec, Street","1","PWU66FJM2XM","$6.60",7,"nulla at sem molestie sodales. Mauris blandit enim consequat purus."),
    ("1-970-311-7577","Reese Marks","58538","MI","France","curabitur.sed@velvenenatis.org","P.O. Box 379, 899 Nascetur Road","7","QGA62KPS8OV","$4.02",9,"ullamcorper. Duis cursus, diam at pretium aliquet, metus urna convallis"),
    ("1-583-255-4316","Ezekiel Crawford","71577","NB","Peru","in@vestibulumaccumsan.ca","Ap #998-2714 Augue Rd.","15","GIY82CXQ2WO","$55.32",6,"vehicula et, rutrum eu, ultrices sit amet, risus. Donec nibh"),
    ("1-458-625-8542","Brent Stanley","72644","FC","Spain","accumsan@molestiesodales.com","Ap #843-6556 Pellentesque Avenue","13","OMV56UVL4BW","$87.53",9,"Class aptent taciti sociosqu ad litora torquent per conubia nostra,"),
    ("(507) 192-8214","Christopher Macias","97546","CE","Germany","tempus@eunulla.ca","467-9552 Per Avenue","7","LOB15JUW0VC","$24.17",2,"sagittis placerat. Cras dictum ultricies ligula. Nullam enim. Sed nulla"),
    ("1-366-238-4324","Alyssa Gillespie","74558","FC","Austria","augue.eu@duinec.org","8518 Vitae St.","1","CKT17CUV3EK","$77.41",9,"tristique pellentesque, tellus sem mollis dui, in sodales elit erat"),
    ("(424) 181-6264","Harrison Frazier","22875","BC","India","nulla.facilisi@volutpatornare.ca","Ap #391-7016 Feugiat Street","17","JTY47YJG9RV","$64.12",8,"In mi pede, nonummy ut, molestie in, tempus eu, ligula."),
    ("1-366-605-0484","Mary Pena","49535","ON","Sweden","adipiscing.elit@leocrasvehicula.edu","680-9865 Cursus St.","17","MUU44GFO3UV","$12.14",6,"sem molestie sodales. Mauris blandit enim consequat purus. Maecenas libero"),
    ("1-814-523-3868","Moses Patterson","79082","MI","Mexico","nulla.at@nulla.com","406-9684 Nunc Rd.","13","PQQ80PSB2KI","$63.12",6,"nascetur ridiculus mus. Donec dignissim magna a tortor. Nunc commodo"),
    ("1-866-588-5846","Valentine Gillespie","26105","BC","Sweden","sodales.mauris@magnaduis.co.uk","8164 Dui. St.","19","FVX49GUJ5OJ","$35.18",4,"mauris. Morbi non sapien molestie orci tincidunt adipiscing. Mauris molestie");
INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-512-882-5425","Yuli Marsh","48720","BO","Mexico","nibh.aliquam@conubia.edu","496-113 Et Street","13","CYD61OLQ6CS","$78.80",7,"fringilla purus mauris a nunc. In at pede. Cras vulputate"),
    ("(289) 297-4655","Hayes Hamilton","16880","LI","Pakistan","molestie@egestassedpharetra.org","Ap #674-1872 Consectetuer Street","7","TEI66FRL9GK","$77.20",3,"nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula."),
    ("1-877-422-0991","Simon Erickson","21764","YT","Brazil","malesuada.id.erat@sodales.com","238-4288 Suspendisse Street","15","WQU75KEV5LL","$15.89",5,"ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin"),
    ("1-334-564-1321","Chiquita Perkins","36017","AU","Mexico","ultricies.adipiscing.enim@magnaetipsum.org","P.O. Box 599, 6351 Scelerisque, Rd.","9","QBM50DJL4FH","$1.40",4,"tincidunt aliquam arcu. Aliquam ultrices iaculis odio. Nam interdum enim"),
    ("(227) 761-2485","Hu Stephenson","90278","LA","Ireland","pede.malesuada@in.com","Ap #645-4112 Ut Rd.","9","MUC51BTB2NF","$72.29",7,"leo, in lobortis tellus justo sit amet nulla. Donec non"),
    ("1-711-871-5522","Wade Sykes","46895","NB","Canada","eros.non@conguea.edu","Ap #504-6083 Vehicula. Ave","11","WYV53MKJ1NJ","$64.28",3,"Nam ligula elit, pretium et, rutrum non, hendrerit id, ante."),
    ("(374) 765-1442","Rhiannon Whitley","58185","NS","France","interdum.sed.auctor@variusorci.com","Ap #474-1546 Erat Rd.","7","UWE97UXE8TP","$47.18",10,"sed, est. Nunc laoreet lectus quis massa. Mauris vestibulum, neque"),
    ("(756) 965-2713","Flavia Robles","81153","MB","Russian Federation","eu.sem.pellentesque@pellentesqueutipsum.com","Ap #302-4248 Nunc Ave","9","LSH43QVX3MD","$61.42",1,"massa. Mauris vestibulum, neque sed dictum eleifend, nunc risus varius"),
    ("(354) 650-8611","Rhoda Harding","65422","BR","Australia","purus.maecenas@maurisutmi.net","P.O. Box 282, 223 Eget Street","3","WRO84WPJ6RT","$79.30",5,"rutrum urna, nec luctus felis purus ac tellus. Suspendisse sed"),
    ("(455) 332-1995","Emily Butler","61152","PR","Belgium","sociis.natoque.penatibus@aliquetodio.ca","8151 Phasellus Avenue","7","EKI31OSK5SE","$37.75",3,"aliquam eros turpis non enim. Mauris quis turpis vitae purus");
INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-804-607-1400","Joelle England","96929","CH","Peru","mus@donecegestas.edu","P.O. Box 373, 8672 Ultricies Rd.","3","GST87FKF6CI","$53.85",0,"mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor"),
    ("(847) 281-5607","Carl Reeves","73765","QC","United Kingdom","vel.mauris.integer@pellentesqueultricies.net","191-8291 Malesuada Road","11","RVL25MSU7RQ","$54.60",8,"nascetur ridiculus mus. Proin vel arcu eu odio tristique pharetra."),
    ("(379) 556-6332","Gavin Moran","60422","MI","Spain","arcu.et@integeraliquam.com","Ap #352-5170 Dolor St.","11","SMG67UBI6AW","$45.58",3,"a felis ullamcorper viverra. Maecenas iaculis aliquet diam. Sed diam"),
    ("(748) 786-3721","Alan Torres","37241","LA","Brazil","convallis.convallis.dolor@tristiquesenectus.ca","775-2040 Vehicula Avenue","5","UCW13KJC3WO","$17.48",4,"natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus."),
    ("(881) 857-6115","Urielle Mcgee","37563","AQ","United Kingdom","orci.tincidunt@dui.net","7857 Vestibulum Road","17","MZL61YOX2YN","$13.86",7,"sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus"),
    ("1-458-424-7737","Shelby Knowles","01803","PI","India","iaculis.enim@orci.com","P.O. Box 683, 7767 Vulputate, Rd.","17","FGM41XHR1EC","$34.04",2,"lacus. Mauris non dui nec urna suscipit nonummy. Fusce fermentum"),
    ("(157) 977-0484","Oleg Bryan","71887","NL","Italy","placerat.cras@eratvelpede.co.uk","P.O. Box 903, 6485 Ultricies St.","13","UXT65ENU2FX","$64.74",1,"ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat"),
    ("1-314-608-7765","Tate Hebert","35935","BA","Indonesia","arcu.iaculis@pedesuspendisse.ca","Ap #251-626 Nisi. Rd.","9","FWY75CKA7CD","$99.77",7,"a tortor. Nunc commodo auctor velit. Aliquam nisl. Nulla eu"),
    ("1-748-865-9111","Jason Weaver","44054","NU","Chile","dignissim.magna@semnulla.net","489 Mauris Ave","11","YQC85PCG5VQ","$70.67",0,"vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor"),
    ("(221) 531-3986","Cody Morton","06930","NU","Ireland","porttitor@congueaaliquet.com","Ap #892-1525 Erat Rd.","9","VTQ17HTS3GS","$29.08",0,"a ultricies adipiscing, enim mi tempor lorem, eget mollis lectus");
INSERT INTO `Table-A` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("(730) 441-8378","Iris Mayer","44382","BC","Mexico","dapibus.gravida@turpisin.co.uk","2369 Gravida St.","7","WNZ19PEB2OZ","$22.68",2,"nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque"),
    ("(541) 801-8078","Sonya Phillips","95556","ON","Germany","metus.vivamus.euismod@maurisid.org","Ap #836-7756 Ipsum Road","1","DMU45LZV1JN","$20.72",1,"adipiscing non, luctus sit amet, faucibus ut, nulla. Cras eu"),
    ("(353) 777-7095","Vielka Meyer","95386","AU","Sweden","pede@lobortistellus.co.uk","7742 Sed Ave","9","TGQ84EWW7KH","$57.85",5,"luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget,"),
    ("(265) 242-7885","Isabelle Dejesus","57811","NT","India","erat.volutpat@pellentesque.co.uk","647-4552 Dis Ave","3","TLP26PKL5HW","$63.06",9,"Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam auctor,"),
    ("(717) 512-1469","Darrel Melton","04484","YT","Austria","dui.quis@facilisis.co.uk","925-386 Non Road","5","BPP83JKN1FB","$34.47",8,"pede et risus. Quisque libero lacus, varius et, euismod et,"),
    ("(244) 874-6246","Rahim Stokes","23311","AB","Poland","eu@adipiscinglobortis.org","Ap #153-7356 Gravida. Rd.","1","QJE88RCR2VD","$57.42",9,"vel nisl. Quisque fringilla euismod enim. Etiam gravida molestie arcu."),
    ("1-686-241-8713","Maris Mueller","16463","NS","Poland","sed@utsemperpretium.com","194-3811 At Rd.","13","ZFW12HDW5EF","$29.80",7,"sit amet nulla. Donec non justo. Proin non massa non"),
    ("1-278-403-2504","Scott Gray","15030","LO","Poland","porttitor.vulputate@donecatarcu.org","559-2604 Lorem. Av.","17","XTN45DYS5EX","$88.93",6,"tellus eu augue porttitor interdum. Sed auctor odio a purus."),
    ("(845) 231-5227","Adrian Tucker","44685","MB","India","mauris.vestibulum@adipiscingelit.edu","Ap #582-2124 Congue Street","1","UGJ44BUO0WQ","$85.37",8,"ipsum sodales purus, in molestie tortor nibh sit amet orci."),
    ("(723) 335-2798","Martina Nolan","59110","NB","Peru","erat.vel.pede@necimperdietnec.edu","P.O. Box 819, 6135 Aliquet Street","19","MIM08EAX5WX","$19.18",1,"pretium neque. Morbi quis urna. Nunc quis arcu vel quam");