DROP TABLE IF EXISTS `Table-B`;

CREATE TABLE `Table-B` (
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

INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-655-184-1605","Quon O'donnell","16867","QC","Spain","ipsum.leo@tincidunt.org","Ap #108-584 Orci Street","9","MII97GDL5SM","$5.64",7,"libero est, congue a, aliquet vel, vulputate eu, odio. Phasellus"),
    ("1-542-687-7473","Adam Rivera","56275","FC","Indonesia","metus.vivamus@bibendumullamcorperduis.edu","939-3299 Aliquam St.","17","BYC56LIJ9YY","$77.14",5,"auctor, velit eget laoreet posuere, enim nisl elementum purus, accumsan"),
    ("1-614-710-2736","Brian Castro","88358","AQ","Mexico","cursus.non@congueturpisin.com","867-9250 Montes, St.","3","QCD09UES2QK","$32.71",2,"nunc sit amet metus. Aliquam erat volutpat. Nulla facilisis. Suspendisse"),
    ("(103) 333-8471","Pandora Perez","36731","LO","Indonesia","faucibus.id@velitin.org","Ap #673-954 At Road","1","NUE01YLK2IP","$98.58",7,"In lorem. Donec elementum, lorem ut aliquam iaculis, lacus pede"),
    ("1-824-272-2249","Clayton Blankenship","87759","PR","Nigeria","volutpat.nunc@euismodacfermentum.org","P.O. Box 124, 4561 Eu Road","5","NUZ05AID5NV","$52.14",6,"eget nisi dictum augue malesuada malesuada. Integer id magna et"),
    ("1-751-335-3335","Derek Soto","23098","AL","United Kingdom","purus@nequesedsem.co.uk","2221 Pede, St.","9","AWQ59NVJ1GR","$69.04",0,"penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin"),
    ("(953) 378-6516","Demetrius O'donnell","72655","CH","Nigeria","tincidunt.pede.ac@tinciduntcongue.ca","261-1718 Placerat. Rd.","9","UWI39JCT3GT","$86.52",3,"ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero"),
    ("(423) 234-6545","Ivana Hebert","04622","BO","Vietnam","nam.tempor@cumsociisnatoque.edu","Ap #584-2181 Lorem Rd.","3","YEL85NXI5KQ","$9.38",1,"quis diam luctus lobortis. Class aptent taciti sociosqu ad litora"),
    ("(941) 484-0625","Grant Hays","59146","QC","Mexico","facilisis.eget.ipsum@dolorsit.co.uk","Ap #939-8164 Nulla Street","19","SOY58VWL4XS","$73.75",6,"sapien. Aenean massa. Integer vitae nibh. Donec est mauris, rhoncus"),
    ("1-372-248-5444","Hammett Bauer","17428","BR","Vietnam","augue.scelerisque@nulla.ca","Ap #520-4900 Montes, Ave","5","ZOL14FTH5UI","$27.86",0,"metus. In lorem. Donec elementum, lorem ut aliquam iaculis, lacus");
INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-313-338-7580","Daquan Keller","77112","MB","Canada","dignissim@elitpharetraut.co.uk","P.O. Box 205, 6231 Phasellus St.","9","MUE17KMJ7UH","$73.74",0,"tellus justo sit amet nulla. Donec non justo. Proin non"),
    ("1-548-681-1637","Winifred Collins","88535","AB","Costa Rica","dolor.nonummy@utdolor.ca","P.O. Box 702, 5462 Dictum St.","19","CBQ10GKZ6IY","$39.80",9,"auctor ullamcorper, nisl arcu iaculis enim, sit amet ornare lectus"),
    ("1-526-495-8775","Karina Castillo","63885","MB","South Korea","nullam.scelerisque.neque@fringilladonec.edu","105-2927 Sagittis. St.","13","JUJ38XNU5UU","$31.82",1,"per conubia nostra, per inceptos hymenaeos. Mauris ut quam vel"),
    ("1-841-462-8121","Echo Wheeler","60407","AB","Brazil","nunc.ut@feugiatloremipsum.net","860-6265 Sapien. Avenue","9","KEI04UBW1ST","$34.51",1,"auctor odio a purus. Duis elementum, dui quis accumsan convallis,"),
    ("1-257-831-5494","Barrett Harper","66960","MI","Vietnam","aptent.taciti@gravida.org","5822 Consectetuer, Av.","9","JFE76SHA2PF","$84.58",4,"felis eget varius ultrices, mauris ipsum porta elit, a feugiat"),
    ("1-549-506-7565","Damon Wyatt","34825","PE","Netherlands","velit.eu@tellusaeneanegestas.net","812-1333 Dolor Rd.","3","IFE69QFU3SY","$62.56",8,"metus eu erat semper rutrum. Fusce dolor quam, elementum at,"),
    ("1-198-857-8258","Rudyard Ryan","58104","PI","Pakistan","sapien.gravida@consectetueripsum.edu","Ap #401-2111 Et Av.","1","JVD07OCW3XS","$2.19",2,"mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin"),
    ("1-461-464-1977","Chava Mendoza","29899","MB","Spain","pharetra.ut@risusvarius.ca","Ap #344-5888 Magna Road","9","LHE37TDQ0NC","$95.76",2,"quam, elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar"),
    ("(288) 271-1511","Leah Hooper","28566","AB","Chile","euismod@aliquamerat.edu","Ap #252-8171 Senectus Ave","13","RCF20QBG3MR","$73.77",4,"ut cursus luctus, ipsum leo elementum sem, vitae aliquam eros"),
    ("(813) 738-8751","Noble Caldwell","84829","QC","Colombia","per.conubia@maurisut.com","771-8657 Egestas. Rd.","13","LYC02YCM5LF","$69.28",9,"ultricies dignissim lacus. Aliquam rutrum lorem ac risus. Morbi metus.");
INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-210-986-2102","Tanya King","56412","BC","France","lacus.cras@aliquetnec.co.uk","P.O. Box 763, 1418 Cursus Av.","9","KPC37DKI5JE","$39.61",9,"sit amet, faucibus ut, nulla. Cras eu tellus eu augue"),
    ("1-762-238-3521","Xenos Jimenez","78722","PE","India","proin.vel.arcu@diam.net","2941 Amet Rd.","1","LFN82WKJ5GR","$88.35",9,"commodo tincidunt nibh. Phasellus nulla. Integer vulputate, risus a ultricies"),
    ("1-175-395-3737","Zeus Payne","75527","NT","Belgium","purus.mauris@turpisvitae.com","477-3368 Amet Av.","1","IFM64DWM8KH","$57.12",8,"congue, elit sed consequat auctor, nunc nulla vulputate dui, nec"),
    ("(591) 931-4916","Carol Nolan","45382","PA","United States","penatibus.et@vivamusnisi.ca","Ap #639-7707 Scelerisque, St.","19","EBM15NIH5IH","$89.84",10,"vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce"),
    ("(150) 723-7897","Wilma Beasley","07430","QC","Russian Federation","nulla.in@quamquis.org","Ap #319-8576 Nec Street","11","JDQ45XTQ1YO","$58.76",6,"arcu ac orci. Ut semper pretium neque. Morbi quis urna."),
    ("(481) 858-4374","Kelly Ochoa","27181","CO","France","lorem.luctus@utmolestie.net","7020 Phasellus Ave","17","CWW65DYS7QN","$71.78",8,"tellus. Phasellus elit pede, malesuada vel, venenatis vel, faucibus id,"),
    ("(218) 389-9554","Rae Nunez","66948","QC","Pakistan","et@lacus.edu","531-4705 Imperdiet, St.","1","OMK57YJS7CB","$72.10",3,"diam eu dolor egestas rhoncus. Proin nisl sem, consequat nec,"),
    ("1-691-120-7347","Julie Thompson","33644","BC","United States","vehicula.aliquet@commodotincidunt.ca","Ap #867-3135 Nunc Ave","15","LCS21AFP2KC","$79.05",6,"In ornare sagittis felis. Donec tempor, est ac mattis semper,"),
    ("(963) 141-2982","Ryder Everett","84253","AQ","United States","donec.tempus@ipsum.edu","Ap #204-3822 Elit, Road","17","VYY52AWE3QG","$52.47",5,"augue scelerisque mollis. Phasellus libero mauris, aliquam eu, accumsan sed,"),
    ("(868) 765-9451","Simon Soto","38966","SK","United Kingdom","posuere.at@neque.org","P.O. Box 330, 1761 Ut, Rd.","7","QYE09FIW2PC","$16.52",7,"dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam");
INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("(878) 527-9124","Reese Jarvis","43368","SK","Germany","eu.nibh@torquent.edu","P.O. Box 248, 2119 Vel Avenue","1","YTK33YXD7LM","$36.76",5,"Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet,"),
    ("(675) 807-2467","Simon Powers","08482","AQ","Peru","arcu.sed@nunclectus.edu","P.O. Box 820, 1399 Nulla. Ave","7","TVV88EVT0FW","$32.20",6,"est, vitae sodales nisi magna sed dui. Fusce aliquam, enim"),
    ("(817) 801-1830","Mercedes Finley","42261","NL","Nigeria","litora.torquent@sodalesat.ca","Ap #944-8518 Nam Av.","19","XCG81DNV5RN","$3.94",7,"Morbi accumsan laoreet ipsum. Curabitur consequat, lectus sit amet luctus"),
    ("1-954-388-8259","Amanda Bennett","00524","BO","Chile","amet.massa@velpede.ca","704-6578 Dui, St.","11","QUG34XTM5PD","$89.74",9,"Nunc mauris elit, dictum eu, eleifend nec, malesuada ut, sem."),
    ("1-694-753-8233","Audrey Reid","56844","PE","Belgium","praesent.interdum.ligula@tincidunt.co.uk","P.O. Box 903, 8333 Sed St.","11","UOP12HOL7MB","$42.07",8,"pede blandit congue. In scelerisque scelerisque dui. Suspendisse ac metus"),
    ("1-865-591-6417","Reuben Holden","79478","MB","Vietnam","suspendisse.ac@velitsed.com","Ap #395-3523 Proin Rd.","13","DDF58HWY8BR","$89.84",10,"risus. Morbi metus. Vivamus euismod urna. Nullam lobortis quam a"),
    ("(468) 978-4806","Kieran Noble","45429","AB","Brazil","bibendum@eliterat.com","229-3290 Consequat Avenue","1","KTE65BRX8EC","$0.18",6,"Nunc ut erat. Sed nunc est, mollis non, cursus non,"),
    ("1-946-730-5574","Leigh Daugherty","78051","PA","Colombia","turpis.nulla@aliquamrutrum.net","540-1666 Mollis. Street","9","CTY16NZC6JW","$85.07",3,"blandit at, nisi. Cum sociis natoque penatibus et magnis dis"),
    ("1-385-375-2834","Solomon Warner","65455","FC","United States","a.odio.semper@mauriselit.com","277-9584 Elementum Av.","19","PCV66ZVF5GN","$29.95",7,"elit fermentum risus, at fringilla purus mauris a nunc. In"),
    ("1-147-292-3814","Lawrence Heath","21446","MI","Austria","eu@tempor.edu","4955 In Av.","3","HXH85MOC2CH","$15.03",4,"et libero. Proin mi. Aliquam gravida mauris ut mi. Duis");
INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("(795) 748-1813","Kessie Serrano","83701","AU","Vietnam","est.ac@magna.edu","1713 Parturient Rd.","17","EPP84FTQ6QN","$20.58",8,"eget, dictum placerat, augue. Sed molestie. Sed id risus quis"),
    ("(218) 716-5665","Galena Carter","73451","AB","Turkey","blandit@enimnuncut.edu","Ap #840-6072 Metus. Road","5","VCQ92SZG6SK","$36.85",1,"nulla. Donec non justo. Proin non massa non ante bibendum"),
    ("(743) 914-8784","Camille Munoz","48811","LO","Italy","enim.nec.tempus@eu.ca","Ap #382-7945 Ac St.","17","XXI87WEQ1KU","$54.16",6,"magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam"),
    ("(716) 294-8442","Rebecca Austin","07427","NS","Costa Rica","egestas.aliquam@duisemper.org","Ap #906-2770 Faucibus Rd.","15","GSB57NNX3GX","$9.70",4,"id risus quis diam luctus lobortis. Class aptent taciti sociosqu"),
    ("1-471-659-8473","Tasha Compton","62722","FC","Canada","parturient.montes@nullaante.ca","P.O. Box 757, 610 Bibendum St.","19","FYU35BNN2VH","$80.39",3,"ornare, elit elit fermentum risus, at fringilla purus mauris a"),
    ("1-723-887-6179","Zelda Potter","58533","SK","Chile","nibh.lacinia@ornarelectusante.co.uk","P.O. Box 174, 3900 Proin Ave","9","PDI36WNB4OV","$26.01",7,"velit. Sed malesuada augue ut lacus. Nulla tincidunt, neque vitae"),
    ("1-472-773-6829","Illiana Bartlett","47527","NT","Australia","non.lobortis@pretium.com","249-8702 Curabitur St.","7","BLC90TQT3FG","$89.35",3,"diam at pretium aliquet, metus urna convallis erat, eget tincidunt"),
    ("(712) 190-9512","Venus Mayer","51726","ON","Italy","lacinia@curabitur.edu","P.O. Box 633, 379 Nunc Rd.","19","LCL66QXC1LV","$38.29",5,"nisl. Nulla eu neque pellentesque massa lobortis ultrices. Vivamus rhoncus."),
    ("1-209-522-3287","Drew Dunn","81988","CH","United States","diam.at@netusetmalesuada.org","Ap #319-4073 Aenean Av.","19","QBL77CCQ0ET","$53.15",1,"natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus."),
    ("(783) 680-6838","Wilma Keller","71504","NS","Mexico","aliquam.adipiscing.lacus@luctuset.edu","Ap #145-375 Integer Rd.","3","JOQ73FYJ6KG","$93.23",8,"orci luctus et ultrices posuere cubilia Curae Phasellus ornare. Fusce");
INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("(329) 553-2189","Bevis Santana","86346","LA","Indonesia","dui.nec.urna@ornarelectusante.org","565-9991 Laoreet St.","13","TMY77NPM5FC","$35.95",8,"in, dolor. Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer"),
    ("(374) 877-5422","Kirby Hanson","64323","AL","Italy","ornare.lectus@magnacras.ca","5777 Ornare Rd.","5","YWV87MFV7YE","$32.82",3,"Integer vulputate, risus a ultricies adipiscing, enim mi tempor lorem,"),
    ("(661) 351-0670","Preston Stark","04181","PA","Brazil","nibh.donec@feugiatplacerat.ca","Ap #927-2004 Dictum Ave","5","EBG01PLD5CC","$42.10",3,"Cum sociis natoque penatibus et magnis dis parturient montes, nascetur"),
    ("1-648-511-1572","Britanney Mcgee","98115","FC","Colombia","fringilla.donec.feugiat@uteros.co.uk","Ap #821-9272 Amet Rd.","19","IXH32LWW0TM","$46.33",2,"ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin"),
    ("(893) 587-8644","Natalie Keller","01372","ON","Brazil","sagittis.lobortis.mauris@vehiculaaliquet.ca","7260 Diam St.","19","BHF21NKQ3SM","$93.42",8,"sed orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam"),
    ("(577) 425-0273","Emi Kinney","36277","MI","Pakistan","libero.morbi.accumsan@proinvel.ca","9438 Auctor, Rd.","11","DPY48MSM1AR","$94.69",4,"pellentesque, tellus sem mollis dui, in sodales elit erat vitae"),
    ("1-347-365-5008","Ria Vargas","18878","NB","Canada","sagittis.placerat@estarcuac.org","Ap #267-776 Ut, St.","19","CLL67PQD7YU","$28.77",8,"vel, faucibus id, libero. Donec consectetuer mauris id sapien. Cras"),
    ("(254) 388-4773","Tanek Fuller","75271","PA","Italy","tristique.pellentesque.tellus@maurisvestibulumneque.com","Ap #579-4208 Turpis Street","3","KRA61GUN4SU","$92.06",3,"lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate"),
    ("1-463-275-7668","Jason Burks","17925","CO","Mexico","ante.nunc@nuncacmattis.edu","P.O. Box 613, 9478 Arcu. Avenue","9","NUE64QZY7CU","$1.49",6,"ultricies adipiscing, enim mi tempor lorem, eget mollis lectus pede"),
    ("(691) 586-4461","Jackson Miller","57848","BA","United Kingdom","dapibus.gravida@vulputaterisusa.net","327-7617 Semper St.","9","YDT46JNU2NT","$22.30",4,"eros nec tellus. Nunc lectus pede, ultrices a, auctor non,");
INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-741-153-5343","Hakeem Mccullough","32326","MI","Colombia","nisi@consectetuer.co.uk","Ap #721-1709 Consequat Rd.","13","LJG54BWM1DB","$66.06",3,"enim. Nunc ut erat. Sed nunc est, mollis non, cursus"),
    ("1-379-581-2391","Elvis Michael","18721","NS","Netherlands","ut.semper@idlibero.edu","Ap #620-5871 Quis Rd.","13","NFW01THB4XC","$90.87",4,"congue a, aliquet vel, vulputate eu, odio. Phasellus at augue"),
    ("1-222-369-3613","Ann Harding","45707","LA","Ireland","purus@risusa.co.uk","P.O. Box 707, 114 Risus. Ave","3","TCQ72IWW6SJ","$51.37",8,"parturient montes, nascetur ridiculus mus. Donec dignissim magna a tortor."),
    ("1-628-633-4115","Thaddeus Bush","58432","CO","Italy","maecenas.iaculis@hendreritneque.ca","P.O. Box 551, 9548 Integer Street","19","WHF62RXM5MP","$63.56",6,"ac turpis egestas. Fusce aliquet magna a neque. Nullam ut"),
    ("(537) 346-0527","Xyla Beck","03187","BC","United Kingdom","ipsum@ipsumac.co.uk","Ap #811-3569 Libero. Rd.","17","LTY78WLJ7MQ","$10.16",0,"sodales. Mauris blandit enim consequat purus. Maecenas libero est, congue"),
    ("(135) 314-4217","Sandra Good","65085","NO","Italy","diam.sed@ipsumdolorsit.ca","P.O. Box 946, 4346 Phasellus Ave","19","CMU69VZW1EF","$84.30",10,"Nulla tincidunt, neque vitae semper egestas, urna justo faucibus lectus,"),
    ("1-277-786-8206","Lacy Conner","71515","QC","Nigeria","at.fringilla@quisqueornaretortor.net","Ap #198-1355 Est Av.","1","QYK94USL4CI","$16.77",8,"tellus. Nunc lectus pede, ultrices a, auctor non, feugiat nec,"),
    ("1-665-571-2263","Dean Castaneda","62385","NT","Colombia","magna@leoelementum.ca","Ap #762-1886 Id Ave","15","ERL33CQS5KC","$50.48",4,"libero et tristique pellentesque, tellus sem mollis dui, in sodales"),
    ("(650) 450-8578","Rebecca Buchanan","04206","AQ","Brazil","ac@fringillapurus.net","Ap #412-1336 Fames St.","11","MSF87TTS2OE","$22.42",7,"enim, sit amet ornare lectus justo eu arcu. Morbi sit"),
    ("1-381-709-7368","Ronan Booker","13126","AU","Netherlands","rhoncus.proin@mollisphasellus.com","Ap #809-1532 Sociosqu Rd.","11","NSK73VFS1BG","$19.59",6,"vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros");
INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-616-222-3973","Melinda Foreman","55825","NL","India","molestie.tellus.aenean@etiamgravidamolestie.org","Ap #102-2832 Morbi Ave","15","JLT85DPE5VJ","$85.02",10,"morbi tristique senectus et netus et malesuada fames ac turpis"),
    ("(529) 448-3875","Coby Fitzpatrick","47826","NL","India","mi.aliquam@donecfelis.edu","Ap #809-3764 Mauris Ave","9","UQU69XSU9PY","$6.94",1,"sit amet, dapibus id, blandit at, nisi. Cum sociis natoque"),
    ("(838) 494-6651","Renee Dixon","41664","YT","Peru","vel.vulputate@vivamussit.co.uk","510-7590 Vestibulum Ave","17","HKN24PYS7JX","$92.06",8,"hendrerit a, arcu. Sed et libero. Proin mi. Aliquam gravida"),
    ("1-579-845-9214","Pascale Small","59268","AU","Vietnam","est.nunc@tellusnunc.com","P.O. Box 421, 6651 Felis, Av.","5","GCC28BQO2BK","$87.67",5,"scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia."),
    ("1-803-434-4759","Eric Santiago","56089","PR","Germany","ullamcorper.velit@lacusquisque.org","6915 Nonummy. St.","5","CFM66MLM2VE","$11.97",8,"dolor vitae dolor. Donec fringilla. Donec feugiat metus sit amet"),
    ("1-857-410-1196","Herrod Meyers","47573","HA","Peru","diam.dictum@sociisnatoque.com","Ap #975-4321 Phasellus St.","5","GFV14LYD3RK","$99.00",8,"eros non enim commodo hendrerit. Donec porttitor tellus non magna."),
    ("(319) 583-8349","Christine Nixon","02901","NU","Turkey","fringilla.mi@estvitaesodales.co.uk","705-5263 Nunc Street","1","DGB18XSI4RZ","$61.61",5,"Integer sem elit, pharetra ut, pharetra sed, hendrerit a, arcu."),
    ("(537) 288-0627","Quinn Booker","08607","NU","Belgium","vehicula@sociisnatoquepenatibus.net","635-5687 Dui Av.","7","ZVY47QEC4HT","$50.04",5,"elit. Aliquam auctor, velit eget laoreet posuere, enim nisl elementum"),
    ("1-132-701-3633","Florence Rojas","71124","BO","Germany","ridiculus@odio.co.uk","764-9869 Quam. St.","3","IDH57WCO8XI","$58.36",1,"blandit at, nisi. Cum sociis natoque penatibus et magnis dis"),
    ("1-214-461-6206","Samson Navarro","68615","IL","Sweden","sagittis.duis@nonlacinia.co.uk","4033 Sed Rd.","9","QKY81FTF3NO","$86.70",1,"interdum ligula eu enim. Etiam imperdiet dictum magna. Ut tincidunt");
INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("(252) 544-6156","Brooke Wallace","41814","YT","Turkey","amet.luctus@duisgravidapraesent.org","Ap #934-8016 Ipsum St.","11","NOB48SEP5OX","$50.66",5,"Suspendisse aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare"),
    ("1-555-204-7382","Ryan Herman","33665","PR","United States","lorem@ultricies.com","Ap #277-6576 Sed Rd.","3","UBF92IRG4YX","$51.98",1,"enim. Nunc ut erat. Sed nunc est, mollis non, cursus"),
    ("(114) 661-6670","Barrett Larsen","57713","BC","India","luctus.lobortis@eleifendvitae.co.uk","861-5877 Magna Street","1","SOR28SRW8VQ","$13.38",6,"Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed"),
    ("(906) 138-3639","Colin Arnold","82815","MI","South Korea","amet@ametfaucibus.com","P.O. Box 931, 4314 Convallis Ave","17","UDB61GNF7GW","$20.35",3,"In faucibus. Morbi vehicula. Pellentesque tincidunt tempus risus. Donec egestas."),
    ("(779) 524-5433","Alea Bryant","65631","LI","Italy","enim.mauris.quis@lacus.co.uk","P.O. Box 544, 6529 Nascetur Avenue","17","DLN75WVR3QY","$56.71",5,"Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae,"),
    ("1-413-210-8664","Shay Terrell","82075","CH","Mexico","donec.felis@nonummyfusce.ca","P.O. Box 815, 5025 Consequat Road","11","JWL52UTP7VP","$75.11",2,"habitant morbi tristique senectus et netus et malesuada fames ac"),
    ("(272) 731-1230","Fatima Finch","78631","PR","Costa Rica","a.mi.fringilla@nonummyfusce.co.uk","Ap #452-1311 Commodo Avenue","7","ILO27LUR1MI","$71.04",6,"feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum"),
    ("(548) 684-4079","Blythe Petty","77188","NT","Italy","justo.sit@velitsed.co.uk","935-9810 Sit St.","5","QUC74OMU5UJ","$40.52",9,"a neque. Nullam ut nisi a odio semper cursus. Integer"),
    ("(368) 333-1816","Sonia Atkinson","84122","NT","Mexico","lacus.mauris@feugiatnec.com","P.O. Box 800, 4976 Quisque Rd.","7","CGV43IDA8XD","$48.07",2,"ac metus vitae velit egestas lacinia. Sed congue, elit sed"),
    ("(425) 382-7373","Emerson Acosta","42871","ON","United Kingdom","consectetuer@dignissimlacus.com","855-6584 In Rd.","17","HRV50ZXR8MD","$23.46",8,"lacus. Nulla tincidunt, neque vitae semper egestas, urna justo faucibus");
INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("(442) 537-1964","Prescott Marks","77808","BA","Sweden","etiam.gravida@egetlaoreet.ca","Ap #520-390 Vehicula Rd.","15","JJE98QHY2WS","$20.57",5,"id sapien. Cras dolor dolor, tempus non, lacinia at, iaculis"),
    ("(898) 485-4897","Guy Petersen","34161","MB","Colombia","tempor.arcu@fuscefermentum.edu","Ap #425-4715 Pede. Rd.","13","WFE34UYU7LZ","$17.84",8,"arcu. Morbi sit amet massa. Quisque porttitor eros nec tellus."),
    ("1-374-667-8188","Erica Humphrey","76163","NO","New Zealand","feugiat.metus@sodalesnisimagna.co.uk","596-8276 Donec St.","3","RUR14FKH3PL","$57.33",4,"cursus. Integer mollis. Integer tincidunt aliquam arcu. Aliquam ultrices iaculis"),
    ("(434) 232-9164","Brent Rollins","89726","HA","Turkey","nam.interdum@maurisquisturpis.edu","P.O. Box 180, 2636 Donec Street","19","NJQ43HIN7MY","$42.30",9,"magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim"),
    ("(342) 758-1147","Silas George","54561","YT","Colombia","vel.vulputate.eu@acsem.org","Ap #112-2137 Nulla Road","9","UVV16FDV5EC","$38.72",8,"tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec"),
    ("1-965-727-5587","Julie Tyler","12637","NB","South Korea","molestie.arcu@arcueuodio.com","1018 Dapibus Avenue","7","KLK82YCM5XC","$4.95",2,"odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque"),
    ("(283) 288-9858","Robert Garrett","92271","PR","Mexico","sed@etmagnis.org","153-9915 Cum Rd.","9","QMS57RKN6LJ","$0.55",3,"ac nulla. In tincidunt congue turpis. In condimentum. Donec at"),
    ("(219) 514-2492","James Walls","35565","AB","Vietnam","facilisi@risusaultricies.edu","Ap #578-4673 Metus. Street","13","UXM08FUX0GU","$22.59",7,"at arcu. Vestibulum ante ipsum primis in faucibus orci luctus"),
    ("1-451-586-0244","Keane Dorsey","60768","ON","United Kingdom","vel.turpis@auctornon.edu","4172 Nulla Rd.","9","PZB39YKX2RN","$76.23",2,"nisi magna sed dui. Fusce aliquam, enim nec tempus scelerisque,"),
    ("1-163-518-7459","Minerva Nichols","24993","YT","Chile","ligula.aliquam@tristique.ca","5677 Vulputate, Ave","19","KPL74MQY3II","$15.18",7,"Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet,");
INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("(902) 118-2755","Bryar Barber","05364","ON","Australia","quam.pellentesque.habitant@purussapien.net","434-5138 Quisque Av.","13","ETM05LCG1GD","$80.67",6,"cursus, diam at pretium aliquet, metus urna convallis erat, eget"),
    ("(836) 475-2368","Camden Beach","70696","PE","Belgium","tellus.id.nunc@semmolestie.ca","9235 Quisque Street","19","SYH18SIC6UV","$40.12",5,"adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis"),
    ("1-565-937-9062","Montana Crosby","24362","PE","Canada","placerat@cras.edu","862-3354 Ligula Ave","11","NTC61GZQ2FS","$87.99",2,"sit amet nulla. Donec non justo. Proin non massa non"),
    ("1-456-350-3051","Cecilia Horn","47703","NT","Poland","ipsum.nunc@risusa.co.uk","893-8336 Cursus. Street","19","JWJ27OGW1QW","$65.14",7,"neque. Sed eget lacus. Mauris non dui nec urna suscipit"),
    ("1-730-702-6785","Buffy Keller","80329","LI","Poland","proin.dolor.nulla@nislquisque.net","5400 Malesuada Avenue","3","XML37QEO6XH","$10.75",6,"ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque."),
    ("(425) 357-5515","Hayden Ellison","16917","BO","Poland","diam.eu.dolor@antelectusconvallis.co.uk","Ap #330-4443 Mi St.","11","XFW72LXM1GC","$32.41",8,"scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia."),
    ("1-547-643-1634","Buckminster Wolfe","86763","MB","Colombia","nunc.lectus@nectempus.net","Ap #284-956 Nec, Rd.","7","PLG81LNR1GX","$29.95",8,"urna suscipit nonummy. Fusce fermentum fermentum arcu. Vestibulum ante ipsum"),
    ("1-139-853-8831","Austin Kirkland","03443","LO","Sweden","cursus.vestibulum@nislmaecenas.ca","703-897 Sed Road","17","EIO35MNJ6FH","$6.93",4,"nec, malesuada ut, sem. Nulla interdum. Curabitur dictum. Phasellus in"),
    ("1-499-358-5652","Quemby Glass","51519","AU","Netherlands","ligula.donec@at.org","Ap #494-5641 Nec, Street","1","INX37NFG0HB","$30.59",0,"erat volutpat. Nulla dignissim. Maecenas ornare egestas ligula. Nullam feugiat"),
    ("1-736-584-1637","Flynn Travis","77224","AL","South Korea","amet@feugiatsednec.edu","Ap #931-6208 Elit. Street","3","LJV15JXT7OH","$50.30",2,"bibendum sed, est. Nunc laoreet lectus quis massa. Mauris vestibulum,");
INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-652-215-5925","Jonah Church","77948","IL","Sweden","integer.tincidunt@ornarefusce.co.uk","P.O. Box 867, 5564 Arcu. Av.","9","JET47BSI5CA","$86.31",7,"ac mi eleifend egestas. Sed pharetra, felis eget varius ultrices,"),
    ("(815) 562-5534","Rylee Goodwin","27147","NT","Turkey","ullamcorper.duis.cursus@sedduifusce.net","Ap #691-5994 A Road","1","IHL42OUG3BG","$36.25",7,"feugiat non, lobortis quis, pede. Suspendisse dui. Fusce diam nunc,"),
    ("(579) 939-6420","Kyra Huffman","23282","NT","New Zealand","bibendum@nequemorbi.edu","136-6778 Donec St.","7","OGX58UXD2XB","$46.01",2,"arcu. Nunc mauris. Morbi non sapien molestie orci tincidunt adipiscing."),
    ("(475) 873-7914","Brittany Larsen","78423","CE","Mexico","a.nunc.in@primis.org","821-8531 Ante Rd.","3","QET46QPB9CP","$49.03",8,"commodo ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac,"),
    ("1-881-472-5507","Basia Mason","25279","IL","Australia","ligula.nullam@seddolorfusce.edu","Ap #129-6147 Et St.","7","UQR72NDD8EC","$34.17",5,"dictum. Proin eget odio. Aliquam vulputate ullamcorper magna. Sed eu"),
    ("1-853-682-8786","Lillith Gross","68931","AU","Mexico","quisque@semperauctor.ca","Ap #880-1170 Nunc Rd.","13","YWW91IEV3BS","$27.15",5,"Sed et libero. Proin mi. Aliquam gravida mauris ut mi."),
    ("(422) 526-0388","Elton Lancaster","03571","NS","Netherlands","eu.dolor.egestas@rhoncusnullamvelit.edu","P.O. Box 817, 2050 Vel Rd.","17","TBV31DTT1SO","$53.39",6,"arcu. Vestibulum ante ipsum primis in faucibus orci luctus et"),
    ("1-842-565-4014","Naida Christensen","11315","PR","Belgium","aliquam.vulputate@diamdictum.net","3480 Fringilla Rd.","3","CMO38RII2QS","$35.25",8,"Aliquam vulputate ullamcorper magna. Sed eu eros. Nam consequat dolor"),
    ("(728) 468-6107","Brenda Chandler","75371","MB","Peru","auctor@nibhsitamet.com","6413 Rhoncus. Ave","7","KND26TPK7ZX","$30.14",7,"Nunc mauris. Morbi non sapien molestie orci tincidunt adipiscing. Mauris"),
    ("1-926-244-9324","Libby Hamilton","26162","NL","Nigeria","tincidunt.vehicula@fringillaornare.net","798-9430 Suspendisse Av.","13","XKD50KWY5ZS","$95.20",5,"ornare placerat, orci lacus vestibulum lorem, sit amet ultricies sem");
INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("(670) 631-9552","Caldwell Lyons","88227","NS","Nigeria","nec.ante@nasceturridiculus.com","113-9510 Lacus. St.","9","OAU82RWF9KS","$89.17",9,"quis diam luctus lobortis. Class aptent taciti sociosqu ad litora"),
    ("1-688-315-6623","Britanney Sellers","65429","BO","United States","interdum.feugiat@nuncsedlibero.ca","Ap #734-586 Cras St.","17","YUW60DCV1ND","$59.27",6,"est ac facilisis facilisis, magna tellus faucibus leo, in lobortis"),
    ("1-677-625-6363","Oren Baird","08883","BC","Austria","urna.nunc.quis@semvitaealiquam.net","Ap #689-5403 Risus. Rd.","13","UOR49ZGV3RP","$85.45",2,"Sed molestie. Sed id risus quis diam luctus lobortis. Class"),
    ("1-558-575-5534","Charlotte Gillespie","65965","AL","Spain","aliquam@vehiculaet.ca","4034 Feugiat Ave","3","QBH03GYA3JR","$87.85",1,"cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut"),
    ("1-279-940-0138","Mason Wilkinson","61133","CO","Sweden","mauris.blandit.enim@tristiquealiquet.org","3636 Mus. Street","7","MXR24LJT8YF","$73.79",4,"tellus id nunc interdum feugiat. Sed nec metus facilisis lorem"),
    ("(943) 317-3385","Quail Dorsey","41772","HA","United States","dictum@turpis.net","P.O. Box 305, 4362 Nulla St.","13","UFO93GYP6RY","$92.16",5,"Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue."),
    ("(761) 526-0108","Alvin Lynn","27369","PE","Costa Rica","nullam.vitae.diam@mollis.co.uk","P.O. Box 307, 4698 Lacinia Av.","5","RWX19YWQ8GR","$38.92",2,"vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros"),
    ("(689) 279-1176","Xanthus Abbott","81209","NB","New Zealand","blandit.enim@sed.co.uk","Ap #471-7390 Nibh St.","5","PBD81LAL2YB","$22.10",10,"auctor velit. Aliquam nisl. Nulla eu neque pellentesque massa lobortis"),
    ("(210) 739-2292","Thaddeus Burks","60878","QC","New Zealand","luctus@elit.net","Ap #910-4137 Urna. Road","11","BEJ98JBL0XQ","$80.33",3,"Class aptent taciti sociosqu ad litora torquent per conubia nostra,"),
    ("(527) 356-6903","Kasper Sellers","36205","MB","France","netus@etiam.edu","Ap #418-1810 In, Street","3","RMS88KRW8OJ","$37.81",4,"erat, in consectetuer ipsum nunc id enim. Curabitur massa. Vestibulum");
INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-393-346-6581","Richard Estrada","44684","AQ","Vietnam","dignissim.maecenas@nullavulputate.net","114-3461 Luctus Ave","19","TEM82GAK9JU","$68.84",0,"Vestibulum ante ipsum primis in faucibus orci luctus et ultrices"),
    ("1-532-683-2788","Danielle Crawford","04169","SK","Turkey","fusce.fermentum@interdumcurabitur.com","6286 Aenean Road","13","YUH67YYF4GM","$92.76",3,"fermentum arcu. Vestibulum ante ipsum primis in faucibus orci luctus"),
    ("(592) 661-1254","Dai Knapp","75487","NS","France","urna.nunc.quis@placerataugue.edu","Ap #477-2391 Hendrerit. St.","11","MHS38GXE1RP","$88.66",4,"Phasellus vitae mauris sit amet lorem semper auctor. Mauris vel"),
    ("1-795-232-6124","Roth Roberts","47970","PE","Russian Federation","tellus.non@accumsanconvallis.org","656 Orci, St.","19","TPU43KET5QS","$36.22",7,"condimentum eget, volutpat ornare, facilisis eget, ipsum. Donec sollicitudin adipiscing"),
    ("(432) 319-2458","Jessica George","55556","NU","Turkey","tortor.at@luctuslobortisclass.org","247-3880 Elit Rd.","1","JKI30RCC7AW","$5.40",5,"eu odio tristique pharetra. Quisque ac libero nec ligula consectetuer"),
    ("1-488-711-3198","Lionel Molina","56558","NB","Turkey","varius.et.euismod@magnaatortor.net","119-6614 Eget, St.","7","TMH57DOI2DO","$99.58",2,"neque pellentesque massa lobortis ultrices. Vivamus rhoncus. Donec est. Nunc"),
    ("(545) 854-4276","David Larson","78642","BR","Nigeria","quisque.libero.lacus@mattisornare.net","644-1303 Aliquet. St.","7","OPM28VUG3FN","$45.11",5,"sem mollis dui, in sodales elit erat vitae risus. Duis"),
    ("1-103-870-1743","Maxine Trujillo","27731","AU","India","ante.dictum.cursus@maurismolestie.ca","P.O. Box 387, 6909 Augue, Avenue","9","XBL85PJQ1IJ","$89.94",7,"pharetra nibh. Aliquam ornare, libero at auctor ullamcorper, nisl arcu"),
    ("1-858-750-4649","Amethyst Beard","88175","MI","Indonesia","fusce@nonenimcommodo.edu","Ap #853-4732 Parturient Avenue","17","HWO77KGE6EB","$36.45",9,"mauris blandit mattis. Cras eget nisi dictum augue malesuada malesuada."),
    ("1-577-665-2634","Tasha Little","28614","LO","Chile","fermentum.fermentum@sapiennunc.edu","Ap #768-397 Magna. St.","11","TWO73NYX4SY","$50.57",8,"ullamcorper magna. Sed eu eros. Nam consequat dolor vitae dolor.");
INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("(299) 587-9187","Ruth Potter","31618","PA","Sweden","nisi.aenean@maurisnon.co.uk","228-5329 Molestie Av.","3","YTI17BGN9IT","$55.55",4,"malesuada malesuada. Integer id magna et ipsum cursus vestibulum. Mauris"),
    ("1-596-132-2828","Barry Richard","88233","AB","India","in@montesnasceturridiculus.co.uk","336-7475 Ac Ave","13","LIC62IDN3SG","$72.72",8,"Suspendisse aliquet molestie tellus. Aenean egestas hendrerit neque. In ornare"),
    ("1-244-255-6813","Paki Webb","28410","FC","Brazil","quis.diam@innec.net","5412 Mollis St.","19","TXB21KPG6MR","$4.94",6,"quam. Curabitur vel lectus. Cum sociis natoque penatibus et magnis"),
    ("1-721-126-6760","Anika Salinas","70522","AL","Pakistan","laoreet.posuere.enim@utmi.co.uk","Ap #640-3826 Pede. Ave","3","YIQ22FGR3RC","$38.03",7,"lobortis risus. In mi pede, nonummy ut, molestie in, tempus"),
    ("1-845-656-1195","Raphael Suarez","18455","PI","Spain","adipiscing.lacus@egestashendreritneque.net","P.O. Box 542, 5121 Nunc Street","13","IJM58XES7FY","$78.59",1,"orci luctus et ultrices posuere cubilia Curae Donec tincidunt. Donec"),
    ("(271) 863-7306","Genevieve Davenport","78812","CH","Turkey","ultrices@eutellusphasellus.co.uk","605-6327 Id, Avenue","1","UKV20MJT9MJ","$23.91",7,"mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy"),
    ("(523) 474-8172","Willa Barber","51863","AB","Vietnam","mauris.blandit@magnaseddui.edu","7603 Mauris. Ave","7","ELX92RPF6QY","$91.95",0,"non, lacinia at, iaculis quis, pede. Praesent eu dui. Cum"),
    ("(711) 186-8364","Naida Mueller","83536","QC","Australia","orci.quis@nisi.net","Ap #579-9293 Purus Ave","19","UNN54PNO3JJ","$24.86",3,"dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit."),
    ("(416) 278-8558","Seth Vargas","39836","NT","Australia","ridiculus.mus@loremeu.net","480-9605 Praesent Av.","13","DBY10KJI2GD","$15.86",7,"odio vel est tempor bibendum. Donec felis orci, adipiscing non,"),
    ("1-437-511-7154","Peter Harvey","53447","MI","Colombia","elementum.sem@amalesuada.co.uk","9865 Aliquam Avenue","1","DJY97AJV1YQ","$1.66",4,"Duis mi enim, condimentum eget, volutpat ornare, facilisis eget, ipsum.");
INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-431-335-7351","Bree Valencia","84370","PE","Turkey","amet.consectetuer.adipiscing@sollicitudinadipiscing.ca","Ap #646-534 Dapibus Rd.","1","YVH15HVW0TY","$55.05",9,"ut, nulla. Cras eu tellus eu augue porttitor interdum. Sed"),
    ("(324) 211-7709","Felix Wolfe","56745","PO","Italy","tristique@duisa.org","Ap #824-8285 Mauris Rd.","17","VBQ86YHW7QD","$88.74",0,"Sed nulla ante, iaculis nec, eleifend non, dapibus rutrum, justo."),
    ("(875) 684-3351","Lamar Conley","43541","IL","Peru","lorem.ipsum.dolor@tinciduntorciquis.org","Ap #118-8323 Amet Rd.","19","XTL16LVE1YJ","$45.48",1,"ullamcorper magna. Sed eu eros. Nam consequat dolor vitae dolor."),
    ("(122) 874-2204","Inez Buchanan","67241","ON","Mexico","nisi.sem@ac.net","Ap #871-601 At Avenue","17","WBT85LPO8LE","$72.23",2,"eu, accumsan sed, facilisis vitae, orci. Phasellus dapibus quam quis"),
    ("1-559-506-4886","Amery Gilbert","77538","PE","Brazil","cursus.et@nequevitaesemper.edu","123-3776 Eget Street","5","LUY55MJF4CI","$92.08",4,"leo, in lobortis tellus justo sit amet nulla. Donec non"),
    ("1-302-867-6513","Maisie Pruitt","15264","NT","Peru","et.eros@nonsollicitudin.net","Ap #155-4506 Rutrum Street","11","CWQ35DGI0KS","$2.72",6,"eu erat semper rutrum. Fusce dolor quam, elementum at, egestas"),
    ("1-837-625-9354","Timothy Anthony","38583","QC","South Korea","posuere.enim@cubiliacurae.co.uk","336-404 Fermentum Street","5","NKG06NNT2EV","$29.49",10,"elit. Curabitur sed tortor. Integer aliquam adipiscing lacus. Ut nec"),
    ("1-673-339-3548","Grady Fleming","63466","BC","South Korea","a.neque@elitpharetra.org","Ap #382-5527 Sodales Street","15","WIX54CWN8HY","$97.37",8,"auctor velit. Aliquam nisl. Nulla eu neque pellentesque massa lobortis"),
    ("1-695-310-7625","Amir Lowery","16874","BC","United States","ultrices.posuere@vitaenibh.edu","791-2393 Ac Rd.","17","CVD73TUQ5RE","$51.56",3,"nunc est, mollis non, cursus non, egestas a, dui. Cras"),
    ("(372) 920-7450","Kylynn Case","54567","NL","Turkey","augue@ataugueid.ca","P.O. Box 417, 1077 Eu Rd.","11","UDO35VSB1DE","$18.35",8,"Donec tempus, lorem fringilla ornare placerat, orci lacus vestibulum lorem,");
INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("(821) 553-3986","Reuben Foley","85736","BR","Turkey","ut.nisi@enimconsequat.com","P.O. Box 815, 5960 Sagittis Rd.","5","JKU41WCO8JY","$43.01",2,"et ipsum cursus vestibulum. Mauris magna. Duis dignissim tempor arcu."),
    ("(606) 402-8428","Xenos Holt","15500","HA","South Korea","phasellus@sedhendrerita.com","Ap #216-3807 Diam Avenue","11","PYJ39RNV1XL","$4.74",0,"eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet"),
    ("1-472-443-2842","Selma Garza","46185","FC","South Korea","est.arcu@vitae.org","560-5402 Ut St.","13","HMV01KMJ0SH","$27.90",8,"consectetuer adipiscing elit. Aliquam auctor, velit eget laoreet posuere, enim"),
    ("(885) 986-0838","Erin Bartlett","32473","SK","Poland","aliquam@eratvitae.ca","Ap #750-1441 Sollicitudin Rd.","15","ETU84FFR3FH","$69.59",4,"tincidunt dui augue eu tellus. Phasellus elit pede, malesuada vel,"),
    ("(581) 608-8151","Inez Goodman","66564","NB","Mexico","sit.amet@donec.ca","Ap #751-6955 Volutpat. Ave","19","CGY88CDY5VC","$80.07",5,"purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam"),
    ("1-872-521-6504","Alan Woodward","63119","LA","United States","etiam.imperdiet@estmollis.net","9571 Dictum Avenue","19","UDQ20RNE6AC","$86.02",6,"Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit."),
    ("1-242-172-8718","Jordan Ortega","02865","AB","Russian Federation","odio.tristique.pharetra@convallisligula.ca","699-571 Nullam St.","13","YUF62NDN6CG","$99.66",2,"et magnis dis parturient montes, nascetur ridiculus mus. Donec dignissim"),
    ("(177) 527-0581","Haviva Pruitt","08482","IL","Colombia","cursus.non@craslorem.co.uk","P.O. Box 804, 1052 Magna Rd.","13","VER99KVD6YG","$1.06",5,"dui. Cras pellentesque. Sed dictum. Proin eget odio. Aliquam vulputate"),
    ("1-806-774-4513","May Carey","58828","NT","Sweden","magna.tellus@id.org","Ap #282-7028 Metus Road","15","DHS77PMC9HK","$35.41",9,"Nunc ut erat. Sed nunc est, mollis non, cursus non,"),
    ("1-706-234-7954","Holmes Whitfield","97624","BO","Nigeria","ut.ipsum@semperpretium.ca","P.O. Box 139, 4777 Congue Ave","5","QKP39FKU2WU","$82.96",0,"mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare,");
INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("1-689-488-3731","Hayley Avery","97589","SK","Belgium","lectus.quis.massa@quamvel.org","996-8787 Commodo Road","7","BQP13DFF4OE","$17.37",5,"arcu. Nunc mauris. Morbi non sapien molestie orci tincidunt adipiscing."),
    ("1-335-351-6422","Roanna Robbins","35711","PA","Brazil","non@massa.com","152 Magnis Rd.","19","SYF20VOD4YJ","$6.18",2,"ligula. Nullam enim. Sed nulla ante, iaculis nec, eleifend non,"),
    ("1-998-832-5123","Murphy Monroe","91647","QC","Sweden","pede.ultrices@elitsed.com","886 Non, Avenue","15","HEQ80WOF0EP","$53.68",3,"tincidunt dui augue eu tellus. Phasellus elit pede, malesuada vel,"),
    ("(449) 865-7130","Moana Olsen","78717","AB","Chile","a.facilisis.non@elitaliquam.net","4082 Sed Avenue","5","QNX35GKF2YY","$49.06",2,"molestie. Sed id risus quis diam luctus lobortis. Class aptent"),
    ("(546) 711-6622","Sydnee Carroll","77912","NT","France","mi.ac@rhoncusproinnisl.ca","Ap #574-6053 Consectetuer Street","3","KQB64RKG1BW","$95.89",5,"Quisque ornare tortor at risus. Nunc ac sem ut dolor"),
    ("1-532-236-4903","Hilel Nichols","66573","ON","Australia","fusce.dolor.quam@odiosemper.net","6423 Felis. Rd.","3","BFR58BOF8KV","$49.30",4,"at, libero. Morbi accumsan laoreet ipsum. Curabitur consequat, lectus sit"),
    ("(781) 732-4618","Kalia King","35196","PO","United Kingdom","urna.nullam.lobortis@posuereatvelit.org","P.O. Box 329, 6067 Eu St.","11","HYI65APE1ZL","$44.35",10,"nisi a odio semper cursus. Integer mollis. Integer tincidunt aliquam"),
    ("1-472-845-5897","Harlan Porter","09164","CO","Germany","magna.phasellus.dolor@turpisin.ca","230-4347 Egestas. Road","11","GGY47QIN7TK","$91.81",4,"eu sem. Pellentesque ut ipsum ac mi eleifend egestas. Sed"),
    ("(506) 788-8097","Lynn Hartman","75854","MB","Belgium","in.tempus.eu@eratnonummyultricies.org","467-356 Lorem, St.","3","YZC69VRK2VM","$72.92",3,"Vivamus rhoncus. Donec est. Nunc ullamcorper, velit in aliquet lobortis,"),
    ("(701) 380-8486","Minerva Mack","75885","LI","France","justo.eu@aliquamenimnec.org","P.O. Box 377, 328 Ornare St.","19","SNY24DHN6SQ","$7.27",3,"quam quis diam. Pellentesque habitant morbi tristique senectus et netus");
INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("(437) 864-3381","Jasper Talley","51024","QC","New Zealand","enim@commodoauctor.co.uk","1716 Arcu Ave","19","SQG71KIV5QS","$63.38",4,"gravida sit amet, dapibus id, blandit at, nisi. Cum sociis"),
    ("1-707-222-6460","Cyrus Chapman","17541","SK","Chile","amet.risus@augueut.co.uk","Ap #239-3227 Feugiat Rd.","15","IFQ22VUC3LE","$51.87",7,"Mauris quis turpis vitae purus gravida sagittis. Duis gravida. Praesent"),
    ("(513) 608-2248","Yeo Pitts","11156","NL","Indonesia","elit.pharetra.ut@quisqueornare.co.uk","Ap #680-8425 Maecenas Avenue","7","WAW34EDP3SN","$58.16",1,"Sed eu eros. Nam consequat dolor vitae dolor. Donec fringilla."),
    ("(336) 672-1877","Lionel Baker","50934","QC","Mexico","enim@nullaat.co.uk","P.O. Box 697, 391 Cursus Avenue","9","LXF53TIC2EN","$50.50",5,"Praesent luctus. Curabitur egestas nunc sed libero. Proin sed turpis"),
    ("(425) 424-1392","Olympia Heath","66362","NT","Ireland","nulla.ante@cumsociis.co.uk","P.O. Box 630, 1838 Quis Street","5","LSN75MKV8FK","$50.11",9,"Duis a mi fringilla mi lacinia mattis. Integer eu lacus."),
    ("1-833-556-2735","Jana Randolph","96723","AQ","Costa Rica","non@etiam.edu","P.O. Box 880, 7232 Et Av.","11","YLM63PGT3PS","$1.60",1,"tellus. Phasellus elit pede, malesuada vel, venenatis vel, faucibus id,"),
    ("1-274-188-4004","Victor Love","41485","MB","Colombia","neque.sed@ipsumcurabitur.ca","465-2561 Magnis Ave","13","QIY55MWG2DX","$25.90",7,"Aenean massa. Integer vitae nibh. Donec est mauris, rhoncus id,"),
    ("1-624-264-5512","Francis Mejia","17562","ON","Austria","aliquet@donecvitae.ca","Ap #340-1563 Nec, Rd.","3","ESH66EGJ0DI","$23.05",1,"vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet"),
    ("1-656-900-2462","Kaseem Alford","15983","LO","Pakistan","tortor.at.risus@nonmassa.com","Ap #946-5771 Sem Rd.","13","BOE75GPR8TD","$90.73",6,"neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce"),
    ("1-685-274-6826","Ezra Jacobson","34435","NB","Peru","pede.cum@eusem.org","992-411 Purus, St.","19","QWE85SPJ2OH","$27.17",8,"lacus. Etiam bibendum fermentum metus. Aenean sed pede nec ante");
INSERT INTO `Table-B` (`phone`,`name`,`postalZip`,`region`,`country`,`email`,`address`,`list`,`alphanumeric`,`currency`,`numberrange`,`text`)
VALUES
    ("(645) 113-8447","Ignatius Watson","03422","NL","Chile","nec.diam@malesuadamalesuadainteger.edu","P.O. Box 917, 3470 Augue Rd.","15","VSZ84OVE9PK","$87.06",4,"vulputate eu, odio. Phasellus at augue id ante dictum cursus."),
    ("(113) 351-5564","Grant Waller","82896","MB","Netherlands","elit.a.feugiat@iaculisodio.ca","357-7479 Semper Street","9","NKZ48ROM8CH","$31.84",6,"nisi sem semper erat, in consectetuer ipsum nunc id enim."),
    ("1-448-219-8983","Acton Johns","13667","ON","Ireland","ullamcorper@tinciduntorci.co.uk","P.O. Box 605, 6769 Laoreet Ave","19","ZYO29GFQ6XW","$95.89",6,"magna, malesuada vel, convallis in, cursus et, eros. Proin ultrices."),
    ("1-874-554-7187","Tamara Campbell","98247","LO","South Korea","congue@odio.com","605-6721 Ullamcorper. St.","15","IFY43NMZ6QB","$62.40",4,"ante dictum mi, ac mattis velit justo nec ante. Maecenas"),
    ("1-475-858-1138","Zachery Rivas","46576","ON","Pakistan","in.lobortis@urnavivamus.co.uk","132-6484 Dapibus St.","7","HPU74TOT6RQ","$53.96",5,"luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget,"),
    ("1-284-360-1307","Octavia Shannon","68493","BA","France","at.auctor.ullamcorper@arcualiquamultrices.edu","452-6661 Conubia Ave","19","JGY20RTU5MI","$41.81",3,"semper, dui lectus rutrum urna, nec luctus felis purus ac"),
    ("1-442-542-7458","Geraldine Mcintosh","31112","BC","Brazil","donec.consectetuer.mauris@vitaediamproin.net","Ap #362-2445 Gravida Av.","7","BRR17SNX1PM","$36.40",7,"Ut semper pretium neque. Morbi quis urna. Nunc quis arcu"),
    ("(376) 730-0177","Adrian Livingston","38362","LO","Netherlands","feugiat@acmattis.co.uk","P.O. Box 150, 7389 Mauris Avenue","11","OWV48XRM6FB","$37.05",4,"sit amet, dapibus id, blandit at, nisi. Cum sociis natoque"),
    ("(346) 862-7784","Anjolie Yates","47158","CE","New Zealand","cum.sociis@auctornunc.co.uk","8834 Massa Rd.","9","UBE32BZR0UC","$67.96",4,"non, dapibus rutrum, justo. Praesent luctus. Curabitur egestas nunc sed"),
    ("1-646-358-1384","Dylan Becker","01337","AQ","Italy","urna.suscipit@nullamagnamalesuada.com","267-4769 Nullam Avenue","13","YLS04LCC8KI","$30.72",5,"Mauris molestie pharetra nibh. Aliquam ornare, libero at auctor ullamcorper,");