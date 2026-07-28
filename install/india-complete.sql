-- ═══════════════════════════════════════════════════════════════════
--  NetsDial – COMPLETE INDIA Coverage SQL
--  ALL states, ALL districts, key mandals/tehsils/taluks
--  Target: 5,000+ areas × 19 keywords = 95,000+ service pages
-- ═══════════════════════════════════════════════════════════════════

-- ════════════════════════════════════════════════════════════════
--  TELANGANA – ALL 33 Districts + Mandals (Primary Market)
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Wanaparthy',        'wanaparthy',         'Telangana',1),
('Narayanpet',        'narayanpet',         'Telangana',1),
('Mahabubabad',       'mahabubabad',        'Telangana',1),
('Mulugu',            'mulugu',             'Telangana',1),
('Bhadradri Kothagudem','bhadradri-kothagudem','Telangana',1),
('Suryapet',          'suryapet',           'Telangana',1),
('Jangaon',           'jangaon',            'Telangana',1),
('Hanamkonda',        'hanamkonda',         'Telangana',1),
('Jayashankar Bhupalpally','jayashankar-bhupalpally','Telangana',1),
('Kumuram Bheem Asifabad','kumuram-bheem-asifabad','Telangana',1),
('Mancherial',        'mancherial',         'Telangana',1),
('Nirmal',            'nirmal',             'Telangana',1),
('Jagtial',           'jagtial',            'Telangana',1);

SET @wanaparthy=(SELECT id FROM districts WHERE slug='wanaparthy');
SET @narayanpet=(SELECT id FROM districts WHERE slug='narayanpet');
SET @mahabubabad=(SELECT id FROM districts WHERE slug='mahabubabad');
SET @mulugu=(SELECT id FROM districts WHERE slug='mulugu');
SET @bhadradri=(SELECT id FROM districts WHERE slug='bhadradri-kothagudem');
SET @suryapet=(SELECT id FROM districts WHERE slug='suryapet');
SET @jangaon=(SELECT id FROM districts WHERE slug='jangaon');
SET @hanamkonda=(SELECT id FROM districts WHERE slug='hanamkonda');
SET @jayashankar=(SELECT id FROM districts WHERE slug='jayashankar-bhupalpally');
SET @kumuram=(SELECT id FROM districts WHERE slug='kumuram-bheem-asifabad');
SET @mancherial=(SELECT id FROM districts WHERE slug='mancherial');
SET @nirmal=(SELECT id FROM districts WHERE slug='nirmal');
SET @jagtial=(SELECT id FROM districts WHERE slug='jagtial');

-- Existing Telangana districts – add more mandals
SET @hyd=(SELECT id FROM districts WHERE slug='hyderabad');
SET @warangal=(SELECT id FROM districts WHERE slug='warangal');
SET @karimnagar=(SELECT id FROM districts WHERE slug='karimnagar');
SET @nizamabad=(SELECT id FROM districts WHERE slug='nizamabad');
SET @khammam=(SELECT id FROM districts WHERE slug='khammam');
SET @nalgonda=(SELECT id FROM districts WHERE slug='nalgonda');
SET @mahbubnagar=(SELECT id FROM districts WHERE slug='mahabubnagar');
SET @adilabad=(SELECT id FROM districts WHERE slug='adilabad');
SET @siddipet=(SELECT id FROM districts WHERE slug='siddipet');
SET @peddapalli=(SELECT id FROM districts WHERE slug='peddapalli');
SET @sircilla=(SELECT id FROM districts WHERE slug='rajanna-sircilla');
SET @kamareddy=(SELECT id FROM districts WHERE slug='kamareddy');
SET @medak=(SELECT id FROM districts WHERE slug='medak');
SET @yadadri=(SELECT id FROM districts WHERE slug='yadadri-bhuvanagiri');
SET @nagarkurnool=(SELECT id FROM districts WHERE slug='nagarkurnool');
SET @gadwal=(SELECT id FROM districts WHERE slug='jogulamba-gadwal');
SET @vikarabad=(SELECT id FROM districts WHERE slug='vikarabad');
SET @sangareddy=(SELECT id FROM districts WHERE slug='sangareddy');
SET @rangareddy=(SELECT id FROM districts WHERE slug='ranga-reddy');
SET @medchal=(SELECT id FROM districts WHERE slug='medchal-malkajgiri');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
-- Hyderabad extra mandals
(@hyd,'Quthbullapur','quthbullapur',1),(@hyd,'Kapra','kapra',1),(@hyd,'Serilingampally','serilingampally',1),(@hyd,'Balanagar','balanagar',1),(@hyd,'Musheerabad','musheerabad',1),
(@hyd,'Malkajgiri','malkajgiri',1),(@hyd,'LB Nagar','lb-nagar',1),(@hyd,'Rajendranagar','rajendranagar',1),(@hyd,'Shamshabad','shamshabad',1),(@hyd,'Hayathnagar','hayathnagar',1),
-- Warangal mandals
(@warangal,'Warangal Urban','warangal-urban',1),(@warangal,'Warangal Rural','warangal-rural',1),(@warangal,'Hasanparthy','hasanparthy',1),(@warangal,'Narsampet','narsampet',1),(@warangal,'Geesugonda','geesugonda',1),(@warangal,'Dornakal','dornakal',1),(@warangal,'Eturnagaram','eturnagaram',1),(@warangal,'Ghanpur Station','ghanpur-station',1),
-- Karimnagar mandals
(@karimnagar,'Karimnagar Urban','karimnagar-urban',1),(@karimnagar,'Huzurabad','huzurabad',1),(@karimnagar,'Veenavanka','veenavanka',1),(@karimnagar,'Sircilla Karimnagar','sircilla-karimnagar',1),(@karimnagar,'Gangadhara','gangadhara',1),(@karimnagar,'Konaraopet','konaraopet',1),(@karimnagar,'Manakondur','manakondur',1),(@karimnagar,'Husnabad','husnabad',1),
-- Nizamabad mandals
(@nizamabad,'Nizamabad Urban','nizamabad-urban',1),(@nizamabad,'Bodhan Mandal','bodhan-mandal',1),(@nizamabad,'Armoor Mandal','armoor-mandal',1),(@nizamabad,'Banswada Mandal','banswada-mandal',1),(@nizamabad,'Balkonda','balkonda',1),(@nizamabad,'Dichpally','dichpally',1),(@nizamabad,'Nizam Sagar','nizam-sagar',1),
-- Khammam mandals
(@khammam,'Khammam Urban','khammam-urban',1),(@khammam,'Kothagudem Mandal','kothagudem-mandal',1),(@khammam,'Bhadrachalam Mandal','bhadrachalam-mandal',1),(@khammam,'Sathupally Mandal','sathupally-mandal',1),(@khammam,'Madhira Mandal','madhira-mandal',1),(@khammam,'Yellandu','yellandu',1),(@khammam,'Ashwaraopet','ashwaraopet',1),
-- Nalgonda mandals
(@nalgonda,'Nalgonda Urban','nalgonda-urban',1),(@nalgonda,'Miryalaguda Mandal','miryalaguda-mandal',1),(@nalgonda,'Suryapet Mandal','suryapet-mandal',1),(@nalgonda,'Huzurnagar Mandal','huzurnagar-mandal',1),(@nalgonda,'Devarakonda Mandal','devarakonda-mandal',1),(@nalgonda,'Nagarjunasagar Mandal','nagarjunasagar-mandal',1),(@nalgonda,'Munugode','munugode',1),
-- Mahabubnagar mandals
(@mahbubnagar,'Mahabubnagar Urban','mahabubnagar-urban',1),(@mahbubnagar,'Jadcherla Mandal','jadcherla-mandal',1),(@mahbubnagar,'Shadnagar','shadnagar',1),(@mahbubnagar,'Narayanpet Mandal','narayanpet-mandal',1),(@mahbubnagar,'Achampet','achampet',1),(@mahbubnagar,'Amangal','amangal',1),(@mahbubnagar,'Kalwakurthy','kalwakurthy',1),
-- Adilabad mandals
(@adilabad,'Adilabad Urban','adilabad-urban',1),(@adilabad,'Nirmal Mandal','nirmal-mandal',1),(@adilabad,'Bellampally','bellampally',1),(@adilabad,'Bhainsa','bhainsa',1),(@adilabad,'Jainath','jainath',1),(@adilabad,'Talamadugu','talamadugu',1),
-- Siddipet mandals
(@siddipet,'Siddipet Urban','siddipet-urban',1),(@siddipet,'Gajwel Mandal','gajwel-mandal',1),(@siddipet,'Dubbak Mandal','dubbak-mandal',1),(@siddipet,'Husnabad Mandal','husnabad-mandal',1),(@siddipet,'Thoguta','thoguta',1),(@siddipet,'Kondapak','kondapak',1),
-- Peddapalli mandals
(@peddapalli,'Peddapalli Urban','peddapalli-urban',1),(@peddapalli,'Ramagundam Mandal','ramagundam-mandal',1),(@peddapalli,'Sultanabad Mandal','sultanabad-mandal',1),(@peddapalli,'Godavarikhani Mandal','godavarikhani-mandal',1),(@peddapalli,'Manthani Mandal','manthani-mandal',1),
-- Rajanna Sircilla mandals
(@sircilla,'Sircilla Urban','sircilla-urban',1),(@sircilla,'Vemulawada Mandal','vemulawada-mandal',1),(@sircilla,'Gambhiraopet Mandal','gambhiraopet-mandal',1),(@sircilla,'Konaraopet Mandal','konaraopet-mandal',1),
-- Kamareddy mandals
(@kamareddy,'Kamareddy Urban','kamareddy-urban',1),(@kamareddy,'Banswada Mandal2','banswada-mandal2',1),(@kamareddy,'Yellareddy Mandal','yellareddy-mandal',1),(@kamareddy,'Domakonda','domakonda',1),(@kamareddy,'Gandhari','gandhari',1),
-- Medak mandals
(@medak,'Medak Urban','medak-urban',1),(@medak,'Ramayampet','ramayampet',1),(@medak,'Toopran','toopran',1),(@medak,'Andole','andole',1),(@medak,'Narsapur Medak','narsapur-medak',1),
-- Yadadri mandals
(@yadadri,'Yadadri Urban','yadadri-urban',1),(@yadadri,'Bhongir Mandal','bhongir-mandal',1),(@yadadri,'Aler Mandal','aler-mandal',1),(@yadadri,'Choutuppal Mandal','choutuppal-mandal',1),(@yadadri,'Mothkur','mothkur',1),
-- Nagarkurnool mandals
(@nagarkurnool,'Nagarkurnool Urban','nagarkurnool-urban',1),(@nagarkurnool,'Kalwakurthy Mandal','kalwakurthy-mandal',1),(@nagarkurnool,'Achampet Mandal','achampet-mandal',1),(@nagarkurnool,'Kollapur','kollapur',1),(@nagarkurnool,'Wanaparthy Mandal2','wanaparthy-mandal2',1),
-- Jogulamba Gadwal mandals
(@gadwal,'Gadwal Urban','gadwal-urban',1),(@gadwal,'Alampur Mandal','alampur-mandal',1),(@gadwal,'Ieeja Mandal','ieeja-mandal',1),(@gadwal,'Ghattu','ghattu',1),
-- Vikarabad mandals
(@vikarabad,'Vikarabad Urban','vikarabad-urban',1),(@vikarabad,'Tandur Mandal','tandur-mandal',1),(@vikarabad,'Pargi Mandal','pargi-mandal',1),(@vikarabad,'Pudur','pudur',1),
-- Sangareddy mandals
(@sangareddy,'Sangareddy Urban','sangareddy-urban',1),(@sangareddy,'Patancheru Mandal','patancheru-mandal',1),(@sangareddy,'Zaheerabad Mandal','zaheerabad-mandal',1),(@sangareddy,'Sadasivpet Mandal','sadasivpet-mandal',1),(@sangareddy,'Rudraram Mandal','rudraram-mandal',1),(@sangareddy,'Narsapur Sangareddy','narsapur-sangareddy',1),
-- Ranga Reddy mandals
(@rangareddy,'Ibrahimpatnam Mandal','ibrahimpatnam-mandal',1),(@rangareddy,'Maheshwaram Mandal','maheshwaram-mandal',1),(@rangareddy,'Kandukur Mandal','kandukur-mandal',1),(@rangareddy,'Shamshabad Mandal','shamshabad-mandal',1),(@rangareddy,'Chevella','chevella',1),(@rangareddy,'Farooqnagar','farooqnagar',1),
-- Medchal-Malkajgiri mandals
(@medchal,'Medchal Mandal','medchal-mandal',1),(@medchal,'Shamirpet Mandal','shamirpet-mandal',1),(@medchal,'Ghatkesar Mandal','ghatkesar-mandal',1),(@medchal,'Keesara','keesara',1),(@medchal,'Dundigal','dundigal',1),
-- New Telangana districts
(@wanaparthy,'Wanaparthy Urban','wanaparthy-urban',1),(@wanaparthy,'Gopalpet','gopalpet',1),(@wanaparthy,'Atmakur Telangana','atmakur-telangana',1),
(@narayanpet,'Narayanpet Urban','narayanpet-urban',1),(@narayanpet,'Makthal','makthal',1),(@narayanpet,'Narva','narva',1),
(@mahabubabad,'Mahabubabad Urban','mahabubabad-urban',1),(@mahabubabad,'Thorrur','thorrur',1),(@mahabubabad,'Dornakal Mandal','dornakal-mandal',1),
(@mulugu,'Mulugu Urban','mulugu-urban',1),(@mulugu,'Eturnagaram Mandal','eturnagaram-mandal',1),(@mulugu,'Venkatapuram','venkatapuram',1),
(@bhadradri,'Kothagudem Urban','kothagudem-urban',1),(@bhadradri,'Palwancha Mandal','palwancha-mandal',1),(@bhadradri,'Manuguru Mandal','manuguru-mandal',1),(@bhadradri,'Bhadrachalam Urban','bhadrachalam-urban',1),
(@suryapet,'Suryapet Urban','suryapet-urban',1),(@suryapet,'Kodad Mandal','kodad-mandal',1),(@suryapet,'Huzurnagar Urban','huzurnagar-urban',1),(@suryapet,'Mellacheruvu','mellacheruvu',1),
(@jangaon,'Jangaon Urban','jangaon-urban',1),(@jangaon,'Ghanpur Mandal','ghanpur-mandal',1),(@jangaon,'Palakurthi','palakurthi',1),
(@hanamkonda,'Hanamkonda Urban','hanamkonda-urban',1),(@hanamkonda,'Kazipet Mandal','kazipet-mandal',1),(@hanamkonda,'Parkal Mandal','parkal-mandal',1),(@hanamkonda,'Dharmasagar','dharmasagar',1),
(@jayashankar,'Bhupalpally Urban','bhupalpally-urban',1),(@jayashankar,'Mahadevpur','mahadevpur',1),(@jayashankar,'Kataram','kataram',1),
(@kumuram,'Asifabad Urban','asifabad-urban',1),(@kumuram,'Kaghaznagar Mandal','kaghaznagar-mandal',1),(@kumuram,'Utnoor Mandal','utnoor-mandal',1),(@kumuram,'Sirpur Kagaznagar','sirpur-kagaznagar',1),
(@mancherial,'Mancherial Urban','mancherial-urban',1),(@mancherial,'Bellampally Mandal','bellampally-mandal',1),(@mancherial,'Chennur Mandal','chennur-mandal',1),(@mancherial,'Mandamarri Mandal','mandamarri-mandal',1),(@mancherial,'Luxettipet','luxettipet',1),
(@nirmal,'Nirmal Urban','nirmal-urban',1),(@nirmal,'Bhainsa Mandal','bhainsa-mandal',1),(@nirmal,'Khanapur','khanapur',1),
(@jagtial,'Jagtial Urban','jagtial-urban',1),(@jagtial,'Korutla Mandal','korutla-mandal',1),(@jagtial,'Metpally Mandal','metpally-mandal',1),(@jagtial,'Dharmapuri','dharmapuri',1);

-- ════════════════════════════════════════════════════════════════
--  ANDHRA PRADESH – ALL 26 Districts + Mandals
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Srikakulam',       'srikakulam',        'Andhra Pradesh',1),
('Vizianagaram',     'vizianagaram',      'Andhra Pradesh',1),
('Alluri Sitarama Raju','alluri-sitarama-raju','Andhra Pradesh',1),
('Parvathipuram Manyam','parvathipuram-manyam','Andhra Pradesh',1),
('Anakapalli',       'anakapalli',        'Andhra Pradesh',1),
('Kakinada',         'kakinada',          'Andhra Pradesh',1),
('Konaseema',        'konaseema',         'Andhra Pradesh',1),
('East Godavari',    'east-godavari',     'Andhra Pradesh',1),
('West Godavari',    'west-godavari',     'Andhra Pradesh',1),
('NTR District',     'ntr-district',      'Andhra Pradesh',1),
('Krishna',          'krishna',           'Andhra Pradesh',1),
('Bapatla',          'bapatla',           'Andhra Pradesh',1),
('Palnadu',          'palnadu',           'Andhra Pradesh',1),
('Nandyal',          'nandyal',           'Andhra Pradesh',1),
('Sri Sathya Sai',   'sri-sathya-sai',    'Andhra Pradesh',1),
('YSR Kadapa',       'ysr-kadapa',        'Andhra Pradesh',1);

SET @srikakulam=(SELECT id FROM districts WHERE slug='srikakulam');
SET @vizianagaram=(SELECT id FROM districts WHERE slug='vizianagaram');
SET @alluri=(SELECT id FROM districts WHERE slug='alluri-sitarama-raju');
SET @parvathipuram=(SELECT id FROM districts WHERE slug='parvathipuram-manyam');
SET @anakapalli=(SELECT id FROM districts WHERE slug='anakapalli');
SET @kakinada_d=(SELECT id FROM districts WHERE slug='kakinada');
SET @konaseema=(SELECT id FROM districts WHERE slug='konaseema');
SET @eastgodavari=(SELECT id FROM districts WHERE slug='east-godavari');
SET @westgodavari=(SELECT id FROM districts WHERE slug='west-godavari');
SET @ntr=(SELECT id FROM districts WHERE slug='ntr-district');
SET @krishna=(SELECT id FROM districts WHERE slug='krishna');
SET @bapatla=(SELECT id FROM districts WHERE slug='bapatla');
SET @palnadu=(SELECT id FROM districts WHERE slug='palnadu');
SET @nandyal_d=(SELECT id FROM districts WHERE slug='nandyal');
SET @srisathyasai=(SELECT id FROM districts WHERE slug='sri-sathya-sai');
SET @ysrkadapa=(SELECT id FROM districts WHERE slug='ysr-kadapa');

-- Existing AP districts – load variable
SET @vizag_d=(SELECT id FROM districts WHERE slug='visakhapatnam');
SET @vijayawada_d=(SELECT id FROM districts WHERE slug='vijayawada');
SET @tirupati_d=(SELECT id FROM districts WHERE slug='tirupati');
SET @guntur_d=(SELECT id FROM districts WHERE slug='guntur');
SET @raj_d=(SELECT id FROM districts WHERE slug='rajahmundry');
SET @kurnool_d=(SELECT id FROM districts WHERE slug='kurnool');
SET @nellore_d=(SELECT id FROM districts WHERE slug='nellore');
SET @kadapa_d=(SELECT id FROM districts WHERE slug='kadapa');
SET @anantapur_d=(SELECT id FROM districts WHERE slug='anantapur');
SET @eluru_d=(SELECT id FROM districts WHERE slug='eluru');
SET @kakinada2=(SELECT id FROM districts WHERE slug='kakinada');
SET @ongole_d=(SELECT id FROM districts WHERE slug='ongole');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
-- Visakhapatnam extra mandals
(@vizag_d,'Gajuwaka','gajuwaka',1),(@vizag_d,'Bheemunipatnam','bheemunipatnam',1),(@vizag_d,'Anakapalli Mandal','anakapalli-mandal',1),(@vizag_d,'Pendurthi','pendurthi',1),(@vizag_d,'Bhimili','bhimili',1),(@vizag_d,'Sabbavaram','sabbavaram',1),(@vizag_d,'Parawada','parawada',1),(@vizag_d,'Nakkapalle','nakkapalle',1),(@vizag_d,'Yellamanchili','yellamanchili',1),(@vizag_d,'Chodavaram','chodavaram',1),
-- Vijayawada extra mandals
(@vijayawada_d,'Vijayawada Rural','vijayawada-rural',1),(@vijayawada_d,'Gannavaram','gannavaram',1),(@vijayawada_d,'Penamaluru','penamaluru',1),(@vijayawada_d,'Ibrahimpatnam AP','ibrahimpatnam-ap',1),(@vijayawada_d,'Tiruvuru','tiruvuru',1),(@vijayawada_d,'Nandigama','nandigama',1),(@vijayawada_d,'Jaggayyapeta','jaggayyapeta',1),
-- Tirupati mandals
(@tirupati_d,'Tirupati Urban','tirupati-urban',1),(@tirupati_d,'Chandragiri','chandragiri',1),(@tirupati_d,'Renigunta','renigunta',1),(@tirupati_d,'Pakala','pakala',1),(@tirupati_d,'Puttur AP','puttur-ap',1),(@tirupati_d,'Srikalahasti Mandal','srikalahasti-mandal',1),
-- Guntur mandals
(@guntur_d,'Guntur Urban','guntur-urban',1),(@guntur_d,'Narasaraopet','narasaraopet',1),(@guntur_d,'Tenali','tenali',1),(@guntur_d,'Ponnuru','ponnuru',1),(@guntur_d,'Piduguralla','piduguralla',1),(@guntur_d,'Sattenapalle','sattenapalle',1),(@guntur_d,'Vinukonda','vinukonda',1),
-- Kurnool mandals
(@kurnool_d,'Kurnool Urban','kurnool-urban',1),(@kurnool_d,'Nandyal Mandal','nandyal-mandal',1),(@kurnool_d,'Adoni Mandal','adoni-mandal',1),(@kurnool_d,'Alur','alur',1),(@kurnool_d,'Banaganapalle','banaganapalle',1),(@kurnool_d,'Pattikonda','pattikonda',1),(@kurnool_d,'Kodumuru','kodumuru',1),
-- Nellore mandals
(@nellore_d,'Nellore Urban','nellore-urban',1),(@nellore_d,'Kavali Mandal','kavali-mandal',1),(@nellore_d,'Gudur Mandal','gudur-mandal',1),(@nellore_d,'Atmakur Nellore','atmakur-nellore',1),(@nellore_d,'Venkatagiri','venkatagiri',1),(@nellore_d,'Allur','allur',1),(@nellore_d,'Podalakur','podalakur',1),
-- Kadapa mandals
(@kadapa_d,'Kadapa Urban','kadapa-urban',1),(@kadapa_d,'Proddatur Mandal','proddatur-mandal',1),(@kadapa_d,'Rajampet Mandal','rajampet-mandal',1),(@kadapa_d,'Jammalamadugu','jammalamadugu',1),(@kadapa_d,'Badvel','badvel',1),(@kadapa_d,'Vempalli','vempalli',1),
-- Anantapur mandals
(@anantapur_d,'Anantapur Urban','anantapur-urban',1),(@anantapur_d,'Guntakal Mandal','guntakal-mandal',1),(@anantapur_d,'Hindupur Mandal','hindupur-mandal',1),(@anantapur_d,'Dharmavaram','dharmavaram',1),(@anantapur_d,'Kadiri','kadiri',1),(@anantapur_d,'Rayadurgam','rayadurgam',1),(@anantapur_d,'Penukonda','penukonda',1),
-- New AP districts
(@srikakulam,'Srikakulam Urban','srikakulam-urban',1),(@srikakulam,'Narasannapeta','narasannapeta',1),(@srikakulam,'Palakonda','palakonda',1),(@srikakulam,'Rajam','rajam',1),(@srikakulam,'Etcherla','etcherla',1),(@srikakulam,'Amadalavalasa','amadalavalasa',1),(@srikakulam,'Ichchapuram','ichchapuram',1),
(@vizianagaram,'Vizianagaram Urban','vizianagaram-urban',1),(@vizianagaram,'Bobbili','bobbili',1),(@vizianagaram,'Parvathipuram','parvathipuram',1),(@vizianagaram,'Gajapathinagaram','gajapathinagaram',1),(@vizianagaram,'Salur','salur',1),(@vizianagaram,'Cheepurupalli','cheepurupalli',1),
(@anakapalli,'Anakapalli Urban','anakapalli-urban',1),(@anakapalli,'Payakaraopeta','payakaraopeta',1),(@anakapalli,'Tuni','tuni',1),(@anakapalli,'Narsipatnam','narsipatnam',1),
(@kakinada_d,'Kakinada Urban','kakinada-urban',1),(@kakinada_d,'Peddapuram','peddapuram',1),(@kakinada_d,'Samalkot','samalkot',1),(@kakinada_d,'Gollaprolu','gollaprolu',1),(@kakinada_d,'Prathipadu','prathipadu',1),
(@eastgodavari,'Rajamahendravaram','rajamahendravaram',1),(@eastgodavari,'Ramachandrapuram','ramachandrapuram',1),(@eastgodavari,'Mandapeta','mandapeta',1),(@eastgodavari,'Kovvur','kovvur',1),(@eastgodavari,'Mummidivaram','mummidivaram',1),
(@konaseema,'Amalapuram Mandal','amalapuram-mandal',1),(@konaseema,'Razole','razole',1),(@konaseema,'Nidadavolu','nidadavolu',1),(@konaseema,'Ramachandrapuram Konaseema','ramachandrapuram-konaseema',1),
(@westgodavari,'Eluru Mandal','eluru-mandal',1),(@westgodavari,'Bhimavaram Mandal','bhimavaram-mandal',1),(@westgodavari,'Narasapuram','narasapuram',1),(@westgodavari,'Tadepalligudem Mandal','tadepalligudem-mandal',1),(@westgodavari,'Palakol','palakol',1),(@westgodavari,'Tanuku','tanuku',1),(@westgodavari,'Jangareddygudem','jangareddygudem',1),
(@ntr,'NTR Urban','ntr-urban',1),(@ntr,'Nandigama Mandal','nandigama-mandal',1),(@ntr,'Jaggayyapeta Mandal','jaggayyapeta-mandal',1),(@ntr,'Vuyyuru','vuyyuru',1),
(@krishna,'Machilipatnam','machilipatnam',1),(@krishna,'Gudivada','gudivada',1),(@krishna,'Bantumilli','bantumilli',1),(@krishna,'Avanigadda','avanigadda',1),
(@bapatla,'Bapatla Urban','bapatla-urban',1),(@bapatla,'Chirala Mandal','chirala-mandal',1),(@bapatla,'Repalle','repalle',1),(@bapatla,'Addanki','addanki',1),
(@palnadu,'Narasaraopet Mandal','narasaraopet-mandal',1),(@palnadu,'Sattenapalle Mandal','sattenapalle-mandal',1),(@palnadu,'Macherla','macherla',1),(@palnadu,'Miryalaguda AP','miryalaguda-ap',1),
(@nandyal_d,'Nandyal Urban','nandyal-urban',1),(@nandyal_d,'Allagadda','allagadda',1),(@nandyal_d,'Srisailam','srisailam',1),(@nandyal_d,'Nandikottur','nandikottur',1),
(@srisathyasai,'Puttaparthi','puttaparthi',1),(@srisathyasai,'Hindupur Mandal','hindupur-mandal',1),(@srisathyasai,'Dharmavaram Mandal','dharmavaram-mandal',1),
(@ysrkadapa,'YSR Urban','ysr-urban',1),(@ysrkadapa,'Proddatur Urban','proddatur-urban',1),(@ysrkadapa,'Yerraguntla','yerraguntla',1),(@ysrkadapa,'Pulivendla Mandal','pulivendla-mandal',1),
(@alluri,'Paderu','paderu',1),(@alluri,'Elamanchili','elamanchili',1),(@alluri,'Chintapalle','chintapalle',1),
(@parvathipuram,'Parvathipuram Urban','parvathipuram-urban',1),(@parvathipuram,'Seethampeta','seethampeta',1),(@parvathipuram,'Makkuva','makkuva',1);

-- ════════════════════════════════════════════════════════════════
--  KARNATAKA – ALL 31 Districts + Key Taluks
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Bagalkot',      'bagalkot',      'Karnataka',1),('Ballari',        'ballari',        'Karnataka',1),
('Bidar',         'bidar',         'Karnataka',1),('Chamarajanagar', 'chamarajanagar', 'Karnataka',1),
('Chikkaballapur','chikkaballapur','Karnataka',1),('Chikkamagaluru', 'chikkamagaluru', 'Karnataka',1),
('Chitradurga',   'chitradurga',   'Karnataka',1),('Dakshina Kannada','dakshina-kannada','Karnataka',1),
('Davanagere',    'davanagere',    'Karnataka',1),('Dharwad',        'dharwad',        'Karnataka',1),
('Gadag',         'gadag',         'Karnataka',1),('Hassan',         'hassan',         'Karnataka',1),
('Haveri',        'haveri',        'Karnataka',1),('Kodagu',         'kodagu',         'Karnataka',1),
('Kolar',         'kolar',         'Karnataka',1),('Koppal',         'koppal',         'Karnataka',1),
('Mandya',        'mandya',        'Karnataka',1),('Raichur',        'raichur',        'Karnataka',1),
('Ramanagara',    'ramanagara',    'Karnataka',1),('Shivamogga',     'shivamogga',     'Karnataka',1),
('Udupi',         'udupi',         'Karnataka',1),('Uttara Kannada', 'uttara-kannada', 'Karnataka',1),
('Vijayapura',    'vijayapura',    'Karnataka',1),('Yadgir',         'yadgir',         'Karnataka',1);

SET @bagalkot=(SELECT id FROM districts WHERE slug='bagalkot');SET @ballari=(SELECT id FROM districts WHERE slug='ballari');
SET @bidar=(SELECT id FROM districts WHERE slug='bidar');SET @chamarajanagar=(SELECT id FROM districts WHERE slug='chamarajanagar');
SET @chikkaballapur=(SELECT id FROM districts WHERE slug='chikkaballapur');SET @chikkamagaluru=(SELECT id FROM districts WHERE slug='chikkamagaluru');
SET @chitradurga=(SELECT id FROM districts WHERE slug='chitradurga');SET @dakshinakannada=(SELECT id FROM districts WHERE slug='dakshina-kannada');
SET @davanagere=(SELECT id FROM districts WHERE slug='davanagere');SET @dharwad=(SELECT id FROM districts WHERE slug='dharwad');
SET @gadag=(SELECT id FROM districts WHERE slug='gadag');SET @hassan=(SELECT id FROM districts WHERE slug='hassan');
SET @haveri=(SELECT id FROM districts WHERE slug='haveri');SET @kodagu=(SELECT id FROM districts WHERE slug='kodagu');
SET @kolar=(SELECT id FROM districts WHERE slug='kolar');SET @koppal=(SELECT id FROM districts WHERE slug='koppal');
SET @mandya=(SELECT id FROM districts WHERE slug='mandya');SET @raichur=(SELECT id FROM districts WHERE slug='raichur');
SET @ramanagara=(SELECT id FROM districts WHERE slug='ramanagara');SET @udupi=(SELECT id FROM districts WHERE slug='udupi');
SET @uttarakannada=(SELECT id FROM districts WHERE slug='uttara-kannada');SET @vijayapura=(SELECT id FROM districts WHERE slug='vijayapura');
SET @yadgir=(SELECT id FROM districts WHERE slug='yadgir');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@bagalkot,'Bagalkot Urban','bagalkot-urban',1),(@bagalkot,'Badami','badami',1),(@bagalkot,'Guledagudda','guledagudda',1),(@bagalkot,'Mudhol','mudhol',1),(@bagalkot,'Jamkhandi','jamkhandi',1),
(@ballari,'Ballari Urban','ballari-urban',1),(@ballari,'Hospet','hospet',1),(@ballari,'Siruguppa','siruguppa',1),(@ballari,'Hadagali','hadagali',1),(@ballari,'Harapanahalli','harapanahalli',1),
(@bidar,'Bidar Urban','bidar-urban',1),(@bidar,'Bhalki','bhalki',1),(@bidar,'Humnabad','humnabad',1),(@bidar,'Basavakalyan','basavakalyan',1),(@bidar,'Aurad','aurad',1),
(@chamarajanagar,'Chamarajanagar Urban','chamarajanagar-urban',1),(@chamarajanagar,'Gundlupet','gundlupet',1),(@chamarajanagar,'Kollegal','kollegal',1),(@chamarajanagar,'Yelandur','yelandur',1),
(@chikkaballapur,'Chikkaballapur Urban','chikkaballapur-urban',1),(@chikkaballapur,'Gauribidanur','gauribidanur',1),(@chikkaballapur,'Bagepalli','bagepalli',1),(@chikkaballapur,'Gudibanda','gudibanda',1),
(@chikkamagaluru,'Chikkamagaluru Urban','chikkamagaluru-urban',1),(@chikkamagaluru,'Mudigere','mudigere',1),(@chikkamagaluru,'Kadur','kadur',1),(@chikkamagaluru,'Tarikere','tarikere',1),
(@chitradurga,'Chitradurga Urban','chitradurga-urban',1),(@chitradurga,'Hosadurga','hosadurga',1),(@chitradurga,'Holalkere','holalkere',1),(@chitradurga,'Challakere','challakere',1),
(@dakshinakannada,'Mangaluru Mandal','mangaluru-mandal',1),(@dakshinakannada,'Puttur DK','puttur-dk',1),(@dakshinakannada,'Sullia','sullia',1),(@dakshinakannada,'Belthangady','belthangady',1),(@dakshinakannada,'Bantwal','bantwal',1),
(@davanagere,'Davanagere Urban','davanagere-urban',1),(@davanagere,'Harihara','harihara',1),(@davanagere,'Honnali','honnali',1),(@davanagere,'Channagiri','channagiri',1),
(@dharwad,'Dharwad Urban','dharwad-urban',1),(@dharwad,'Hubli Mandal','hubli-mandal',1),(@dharwad,'Navalgund','navalgund',1),(@dharwad,'Kundgol','kundgol',1),
(@gadag,'Gadag Urban','gadag-urban',1),(@gadag,'Nargund','nargund',1),(@gadag,'Ron','ron-gadag',1),(@gadag,'Shirahatti','shirahatti',1),
(@hassan,'Hassan Urban','hassan-urban',1),(@hassan,'Belur','belur',1),(@hassan,'Alur Hassan','alur-hassan',1),(@hassan,'Sakleshpur','sakleshpur',1),(@hassan,'Arsikere','arsikere',1),
(@haveri,'Haveri Urban','haveri-urban',1),(@haveri,'Hanagal','hanagal',1),(@haveri,'Savanur','savanur',1),(@haveri,'Ranebennur','ranebennur',1),
(@kodagu,'Madikeri','madikeri',1),(@kodagu,'Virajpet','virajpet',1),(@kodagu,'Somwarpet','somwarpet',1),
(@kolar,'Kolar Urban','kolar-urban',1),(@kolar,'Kolar Gold Fields','kolar-gold-fields',1),(@kolar,'Robertsonpet','robertsonpet',1),(@kolar,'Bangarpet','bangarpet',1),
(@koppal,'Koppal Urban','koppal-urban',1),(@koppal,'Gangavathi','gangavathi',1),(@koppal,'Kushtagi','kushtagi',1),(@koppal,'Yelburga','yelburga',1),
(@mandya,'Mandya Urban','mandya-urban',1),(@mandya,'Maddur','maddur',1),(@mandya,'Malavalli','malavalli',1),(@mandya,'Nagamangala','nagamangala',1),(@mandya,'Srirangapatna','srirangapatna',1),
(@raichur,'Raichur Urban','raichur-urban',1),(@raichur,'Lingasugur','lingasugur',1),(@raichur,'Manvi','manvi',1),(@raichur,'Sindhanur','sindhanur',1),(@raichur,'Devadurga','devadurga',1),
(@ramanagara,'Ramanagara Urban','ramanagara-urban',1),(@ramanagara,'Channapatna','channapatna',1),(@ramanagara,'Kanakapura','kanakapura',1),(@ramanagara,'Magadi','magadi',1),
(@udupi,'Udupi Urban','udupi-urban',1),(@udupi,'Kundapur','kundapur',1),(@udupi,'Karkala','karkala',1),(@udupi,'Byndoor','byndoor',1),
(@uttarakannada,'Karwar','karwar',1),(@uttarakannada,'Sirsi','sirsi',1),(@uttarakannada,'Kumta','kumta',1),(@uttarakannada,'Dandeli','dandeli',1),(@uttarakannada,'Ankola','ankola',1),
(@vijayapura,'Vijayapura Urban','vijayapura-urban',1),(@vijayapura,'Muddebihal','muddebihal',1),(@vijayapura,'Indi','indi',1),(@vijayapura,'Bagewadi','bagewadi',1),
(@yadgir,'Yadgir Urban','yadgir-urban',1),(@yadgir,'Shorapur','shorapur',1),(@yadgir,'Gurmatkal','gurmatkal',1),(@yadgir,'Shahapur','shahapur',1);

-- ════════════════════════════════════════════════════════════════
--  TAMIL NADU – ALL 38 Districts + Key Taluks
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Ariyalur',      'ariyalur',      'Tamil Nadu',1),('Chengalpattu',  'chengalpattu',  'Tamil Nadu',1),
('Cuddalore',     'cuddalore',     'Tamil Nadu',1),('Dharmapuri',    'dharmapuri',    'Tamil Nadu',1),
('Dindigul',      'dindigul',      'Tamil Nadu',1),('Kallakurichi',  'kallakurichi',  'Tamil Nadu',1),
('Kanchipuram',   'kanchipuram',   'Tamil Nadu',1),('Kanniyakumari', 'kanniyakumari', 'Tamil Nadu',1),
('Karur',         'karur',         'Tamil Nadu',1),('Krishnagiri',   'krishnagiri',   'Tamil Nadu',1),
('Mayiladuthurai','mayiladuthurai','Tamil Nadu',1),('Nagapattinam',  'nagapattinam',  'Tamil Nadu',1),
('Namakkal',      'namakkal',      'Tamil Nadu',1),('Nilgiris',      'nilgiris',      'Tamil Nadu',1),
('Perambalur',    'perambalur',    'Tamil Nadu',1),('Pudukkottai',   'pudukkottai',   'Tamil Nadu',1),
('Ranipet',       'ranipet',       'Tamil Nadu',1),('Ramanathapuram','ramanathapuram','Tamil Nadu',1),
('Sivaganga',     'sivaganga',     'Tamil Nadu',1),('Tenkasi',       'tenkasi',       'Tamil Nadu',1),
('Thanjavur',     'thanjavur',     'Tamil Nadu',1),('Theni',         'theni',         'Tamil Nadu',1),
('Tiruchirappalli District','tiruchirappalli-district','Tamil Nadu',1),
('Tirupathur',    'tirupathur',    'Tamil Nadu',1),('Tiruppur',      'tiruppur',      'Tamil Nadu',1),
('Tiruvallur',    'tiruvallur',    'Tamil Nadu',1),('Tiruvannamalai','tiruvannamalai','Tamil Nadu',1),
('Tiruvarur',     'tiruvarur',     'Tamil Nadu',1),('Thoothukudi District','thoothukudi-district','Tamil Nadu',1),
('Villupuram',    'villupuram',    'Tamil Nadu',1),('Virudhunagar',  'virudhunagar',  'Tamil Nadu',1);

SET @ariyalur=(SELECT id FROM districts WHERE slug='ariyalur');SET @chengalpattu=(SELECT id FROM districts WHERE slug='chengalpattu');
SET @cuddalore=(SELECT id FROM districts WHERE slug='cuddalore');SET @dharmapuri=(SELECT id FROM districts WHERE slug='dharmapuri');
SET @dindigul=(SELECT id FROM districts WHERE slug='dindigul');SET @kallakurichi=(SELECT id FROM districts WHERE slug='kallakurichi');
SET @kanchipuram=(SELECT id FROM districts WHERE slug='kanchipuram');SET @kanniyakumari=(SELECT id FROM districts WHERE slug='kanniyakumari');
SET @karur=(SELECT id FROM districts WHERE slug='karur');SET @krishnagiri=(SELECT id FROM districts WHERE slug='krishnagiri');
SET @mayiladuthurai=(SELECT id FROM districts WHERE slug='mayiladuthurai');SET @nagapattinam=(SELECT id FROM districts WHERE slug='nagapattinam');
SET @namakkal=(SELECT id FROM districts WHERE slug='namakkal');SET @nilgiris=(SELECT id FROM districts WHERE slug='nilgiris');
SET @perambalur=(SELECT id FROM districts WHERE slug='perambalur');SET @pudukkottai=(SELECT id FROM districts WHERE slug='pudukkottai');
SET @ranipet=(SELECT id FROM districts WHERE slug='ranipet');SET @ramanathapuram=(SELECT id FROM districts WHERE slug='ramanathapuram');
SET @sivaganga=(SELECT id FROM districts WHERE slug='sivaganga');SET @tenkasi=(SELECT id FROM districts WHERE slug='tenkasi');
SET @thanjavur=(SELECT id FROM districts WHERE slug='thanjavur');SET @theni=(SELECT id FROM districts WHERE slug='theni');
SET @trichy_d=(SELECT id FROM districts WHERE slug='tiruchirappalli-district');
SET @tirupathur=(SELECT id FROM districts WHERE slug='tirupathur');SET @tiruppur=(SELECT id FROM districts WHERE slug='tiruppur');
SET @tiruvallur=(SELECT id FROM districts WHERE slug='tiruvallur');SET @tiruvannamalai=(SELECT id FROM districts WHERE slug='tiruvannamalai');
SET @tiruvarur=(SELECT id FROM districts WHERE slug='tiruvarur');SET @thoothukudi_d=(SELECT id FROM districts WHERE slug='thoothukudi-district');
SET @villupuram=(SELECT id FROM districts WHERE slug='villupuram');SET @virudhunagar=(SELECT id FROM districts WHERE slug='virudhunagar');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@ariyalur,'Ariyalur Urban','ariyalur-urban',1),(@ariyalur,'Perambalur Taluk','perambalur-taluk',1),(@ariyalur,'Sendurai','sendurai',1),
(@chengalpattu,'Chengalpattu Urban','chengalpattu-urban',1),(@chengalpattu,'Maraimalai Nagar','maraimalai-nagar',1),(@chengalpattu,'Vandalur','vandalur',1),(@chengalpattu,'Guduvanchery','guduvanchery',1),(@chengalpattu,'Uthiramerur','uthiramerur',1),
(@cuddalore,'Cuddalore Urban','cuddalore-urban',1),(@cuddalore,'Panruti','panruti',1),(@cuddalore,'Chidambaram','chidambaram',1),(@cuddalore,'Neyveli','neyveli',1),(@cuddalore,'Virudhachalam','virudhachalam',1),
(@dharmapuri,'Dharmapuri Urban','dharmapuri-urban',1),(@dharmapuri,'Palacode','palacode',1),(@dharmapuri,'Harur','harur',1),(@dharmapuri,'Pennagaram','pennagaram',1),
(@dindigul,'Dindigul Urban','dindigul-urban',1),(@dindigul,'Kodaikanal','kodaikanal',1),(@dindigul,'Palani','palani',1),(@dindigul,'Natham','natham',1),(@dindigul,'Vedasandur','vedasandur',1),
(@kallakurichi,'Kallakurichi Urban','kallakurichi-urban',1),(@kallakurichi,'Sankarapuram','sankarapuram',1),(@kallakurichi,'Ulundurpet','ulundurpet',1),
(@kanchipuram,'Kanchipuram Urban','kanchipuram-urban',1),(@kanchipuram,'Sriperumbudur','sriperumbudur',1),(@kanchipuram,'Alandur TN','alandur-tn',1),(@kanchipuram,'Tambaram Kanchipuram','tambaram-kanchipuram',1),
(@kanniyakumari,'Nagercoil','nagercoil',1),(@kanniyakumari,'Thuckalay','thuckalay',1),(@kanniyakumari,'Padmanabhapuram','padmanabhapuram',1),(@kanniyakumari,'Colachel','colachel',1),
(@karur,'Karur Urban','karur-urban',1),(@karur,'Kulithalai','kulithalai',1),(@karur,'Krishnarayapuram','krishnarayapuram',1),
(@krishnagiri,'Krishnagiri Urban','krishnagiri-urban',1),(@krishnagiri,'Hosur','hosur',1),(@krishnagiri,'Bargur','bargur',1),(@krishnagiri,'Denkanikottai','denkanikottai',1),
(@mayiladuthurai,'Mayiladuthurai Urban','mayiladuthurai-urban',1),(@mayiladuthurai,'Sirkali','sirkali',1),(@mayiladuthurai,'Poompuhar','poompuhar',1),
(@nagapattinam,'Nagapattinam Urban','nagapattinam-urban',1),(@nagapattinam,'Vedaranyam','vedaranyam',1),(@nagapattinam,'Thillaisthanam','thillaisthanam',1),(@nagapattinam,'Kilvelur','kilvelur',1),
(@namakkal,'Namakkal Urban','namakkal-urban',1),(@namakkal,'Rasipuram','rasipuram',1),(@namakkal,'Tiruchengode','tiruchengode',1),(@namakkal,'Senthamangalam','senthamangalam',1),
(@nilgiris,'Ooty','ooty',1),(@nilgiris,'Coonoor','coonoor',1),(@nilgiris,'Gudalur','gudalur',1),(@nilgiris,'Kotagiri','kotagiri',1),
(@perambalur,'Perambalur Urban','perambalur-urban',1),(@perambalur,'Veppanthattai','veppanthattai',1),
(@pudukkottai,'Pudukkottai Urban','pudukkottai-urban',1),(@pudukkottai,'Karambakudi','karambakudi',1),(@pudukkottai,'Alangudi','alangudi',1),(@pudukkottai,'Aranthangi','aranthangi',1),
(@ranipet,'Ranipet Urban','ranipet-urban',1),(@ranipet,'Arcot','arcot',1),(@ranipet,'Sholinghur','sholinghur',1),(@ranipet,'Walajah','walajah',1),
(@ramanathapuram,'Ramanathapuram Urban','ramanathapuram-urban',1),(@ramanathapuram,'Rameswaram','rameswaram',1),(@ramanathapuram,'Paramakudi','paramakudi',1),(@ramanathapuram,'Keelakarai','keelakarai',1),
(@sivaganga,'Sivaganga Urban','sivaganga-urban',1),(@sivaganga,'Karaikudi','karaikudi',1),(@sivaganga,'Devakottai','devakottai',1),(@sivaganga,'Tiruppattur TN','tiruppattur-tn',1),
(@tenkasi,'Tenkasi Urban','tenkasi-urban',1),(@tenkasi,'Shenkottai','shenkottai',1),(@tenkasi,'Ambasamudram','ambasamudram',1),(@tenkasi,'Kadayanallur','kadayanallur',1),
(@thanjavur,'Thanjavur Urban','thanjavur-urban',1),(@thanjavur,'Kumbakonam','kumbakonam',1),(@thanjavur,'Papanasam','papanasam',1),(@thanjavur,'Pattukottai','pattukottai',1),(@thanjavur,'Orathanadu','orathanadu',1),
(@theni,'Theni Urban','theni-urban',1),(@theni,'Uthamapalayam','uthamapalayam',1),(@theni,'Periyakulam','periyakulam',1),(@theni,'Bodinayakanur','bodinayakanur',1),
(@trichy_d,'Srirangam Mandal','srirangam-mandal',1),(@trichy_d,'Lalgudi','lalgudi',1),(@trichy_d,'Musiri','musiri',1),(@trichy_d,'Manapparai','manapparai',1),
(@tirupathur,'Tirupathur Urban','tirupathur-urban',1),(@tirupathur,'Vaniyambadi','vaniyambadi',1),(@tirupathur,'Ambur','ambur',1),
(@tiruppur,'Tiruppur Urban','tiruppur-urban',1),(@tiruppur,'Udumalaipettai','udumalaipettai',1),(@tiruppur,'Palladam','palladam',1),(@tiruppur,'Dharapuram','dharapuram',1),(@tiruppur,'Avinashi','avinashi',1),
(@tiruvallur,'Tiruvallur Urban','tiruvallur-urban',1),(@tiruvallur,'Ponneri','ponneri',1),(@tiruvallur,'Gummidipoondi','gummidipoondi',1),(@tiruvallur,'Tiruttani','tiruttani',1),
(@tiruvannamalai,'Tiruvannamalai Urban','tiruvannamalai-urban',1),(@tiruvannamalai,'Polur','polur',1),(@tiruvannamalai,'Arani TN','arani-tn',1),(@tiruvannamalai,'Cheyyar','cheyyar',1),
(@tiruvarur,'Tiruvarur Urban','tiruvarur-urban',1),(@tiruvarur,'Mannargudi','mannargudi',1),(@tiruvarur,'Papanasam TN','papanasam-tn',1),
(@thoothukudi_d,'Thoothukudi Mandal','thoothukudi-mandal',1),(@thoothukudi_d,'Kovilpatti','kovilpatti',1),(@thoothukudi_d,'Sattur','sattur',1),
(@villupuram,'Villupuram Urban','villupuram-urban',1),(@villupuram,'Gingee','gingee',1),(@villupuram,'Tindivanam','tindivanam',1),(@villupuram,'Vanur','vanur',1),
(@virudhunagar,'Virudhunagar Urban','virudhunagar-urban',1),(@virudhunagar,'Rajapalayam','rajapalayam',1),(@virudhunagar,'Sivakasi','sivakasi',1),(@virudhunagar,'Aruppukkottai','aruppukkottai',1);

-- ════════════════════════════════════════════════════════════════
--  MAHARASHTRA – ALL 36 Districts + Key Taluks
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Ahmednagar',    'ahmednagar',    'Maharashtra',1),('Akola',         'akola',         'Maharashtra',1),
('Amravati',      'amravati',      'Maharashtra',1),('Beed',          'beed',          'Maharashtra',1),
('Bhandara',      'bhandara',      'Maharashtra',1),('Buldhana',      'buldhana',      'Maharashtra',1),
('Chandrapur',    'chandrapur',    'Maharashtra',1),('Dhule',         'dhule',         'Maharashtra',1),
('Gadchiroli',    'gadchiroli',    'Maharashtra',1),('Gondia',        'gondia',        'Maharashtra',1),
('Hingoli',       'hingoli',       'Maharashtra',1),('Jalgaon',       'jalgaon',       'Maharashtra',1),
('Jalna',         'jalna',         'Maharashtra',1),('Latur',         'latur',         'Maharashtra',1),
('Nanded',        'nanded',        'Maharashtra',1),('Nandurbar',     'nandurbar',     'Maharashtra',1),
('Osmanabad',     'osmanabad',     'Maharashtra',1),('Palghar',       'palghar',       'Maharashtra',1),
('Parbhani',      'parbhani',      'Maharashtra',1),('Raigad',        'raigad',        'Maharashtra',1),
('Ratnagiri',     'ratnagiri',     'Maharashtra',1),('Sangli',        'sangli',        'Maharashtra',1),
('Satara',        'satara',        'Maharashtra',1),('Sindhudurg',    'sindhudurg',    'Maharashtra',1),
('Wardha',        'wardha',        'Maharashtra',1),('Washim',        'washim',        'Maharashtra',1),
('Yavatmal',      'yavatmal',      'Maharashtra',1);

SET @ahmednagar=(SELECT id FROM districts WHERE slug='ahmednagar');SET @akola=(SELECT id FROM districts WHERE slug='akola');
SET @amravati=(SELECT id FROM districts WHERE slug='amravati');SET @beed=(SELECT id FROM districts WHERE slug='beed');
SET @bhandara=(SELECT id FROM districts WHERE slug='bhandara');SET @buldhana=(SELECT id FROM districts WHERE slug='buldhana');
SET @chandrapur=(SELECT id FROM districts WHERE slug='chandrapur');SET @dhule=(SELECT id FROM districts WHERE slug='dhule');
SET @gadchiroli=(SELECT id FROM districts WHERE slug='gadchiroli');SET @gondia=(SELECT id FROM districts WHERE slug='gondia');
SET @hingoli=(SELECT id FROM districts WHERE slug='hingoli');SET @jalgaon=(SELECT id FROM districts WHERE slug='jalgaon');
SET @jalna=(SELECT id FROM districts WHERE slug='jalna');SET @latur=(SELECT id FROM districts WHERE slug='latur');
SET @nanded=(SELECT id FROM districts WHERE slug='nanded');SET @nandurbar=(SELECT id FROM districts WHERE slug='nandurbar');
SET @osmanabad=(SELECT id FROM districts WHERE slug='osmanabad');SET @palghar=(SELECT id FROM districts WHERE slug='palghar');
SET @parbhani=(SELECT id FROM districts WHERE slug='parbhani');SET @raigad=(SELECT id FROM districts WHERE slug='raigad');
SET @ratnagiri=(SELECT id FROM districts WHERE slug='ratnagiri');SET @sangli=(SELECT id FROM districts WHERE slug='sangli');
SET @satara=(SELECT id FROM districts WHERE slug='satara');SET @sindhudurg=(SELECT id FROM districts WHERE slug='sindhudurg');
SET @wardha=(SELECT id FROM districts WHERE slug='wardha');SET @washim=(SELECT id FROM districts WHERE slug='washim');
SET @yavatmal=(SELECT id FROM districts WHERE slug='yavatmal');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@ahmednagar,'Ahmednagar Urban','ahmednagar-urban',1),(@ahmednagar,'Sangamner','sangamner',1),(@ahmednagar,'Kopargaon','kopargaon',1),(@ahmednagar,'Shrirampur','shrirampur',1),(@ahmednagar,'Rahuri','rahuri',1),
(@akola,'Akola Urban','akola-urban',1),(@akola,'Akot','akot',1),(@akola,'Balapur','balapur',1),(@akola,'Murtizapur','murtizapur',1),
(@amravati,'Amravati Urban','amravati-urban',1),(@amravati,'Achalpur','achalpur',1),(@amravati,'Daryapur','daryapur',1),(@amravati,'Morshi','morshi',1),
(@beed,'Beed Urban','beed-urban',1),(@beed,'Ambajogai','ambajogai',1),(@beed,'Parli','parli',1),(@beed,'Georai','georai',1),
(@bhandara,'Bhandara Urban','bhandara-urban',1),(@bhandara,'Tumsar','tumsar',1),(@bhandara,'Sakoli','sakoli',1),
(@buldhana,'Buldhana Urban','buldhana-urban',1),(@buldhana,'Malkapur','malkapur',1),(@buldhana,'Khamgaon','khamgaon',1),(@buldhana,'Chikhli','chikhli',1),
(@chandrapur,'Chandrapur Urban','chandrapur-urban',1),(@chandrapur,'Ballarpur','ballarpur',1),(@chandrapur,'Warora','warora',1),(@chandrapur,'Mul','mul-chandrapur',1),
(@dhule,'Dhule Urban','dhule-urban',1),(@dhule,'Shirpur','shirpur',1),(@dhule,'Sakri','sakri',1),
(@gadchiroli,'Gadchiroli Urban','gadchiroli-urban',1),(@gadchiroli,'Aheri','aheri',1),(@gadchiroli,'Sironcha','sironcha',1),
(@gondia,'Gondia Urban','gondia-urban',1),(@gondia,'Arjuni','arjuni',1),(@gondia,'Tirora','tirora',1),(@gondia,'Deori','deori-gondia',1),
(@hingoli,'Hingoli Urban','hingoli-urban',1),(@hingoli,'Sengaon','sengaon',1),(@hingoli,'Aundha Nagnath','aundha-nagnath',1),
(@jalgaon,'Jalgaon Urban','jalgaon-urban',1),(@jalgaon,'Bhusawal','bhusawal',1),(@jalgaon,'Amalner','amalner',1),(@jalgaon,'Pachora','pachora',1),(@jalgaon,'Jamner','jamner',1),
(@jalna,'Jalna Urban','jalna-urban',1),(@jalna,'Ambad','ambad-jalna',1),(@jalna,'Partur','partur',1),(@jalna,'Bhokardan','bhokardan',1),
(@latur,'Latur Urban','latur-urban',1),(@latur,'Udgir','udgir',1),(@latur,'Nilanga','nilanga',1),(@latur,'Ausa','ausa',1),
(@nanded,'Nanded Urban','nanded-urban',1),(@nanded,'Deglur','deglur',1),(@nanded,'Hadgaon','hadgaon',1),(@nanded,'Kinwat','kinwat',1),(@nanded,'Biloli','biloli',1),
(@nandurbar,'Nandurbar Urban','nandurbar-urban',1),(@nandurbar,'Shahada','shahada',1),(@nandurbar,'Taloda','taloda',1),(@nandurbar,'Navapur','navapur',1),
(@osmanabad,'Osmanabad Urban','osmanabad-urban',1),(@osmanabad,'Tuljapur','tuljapur',1),(@osmanabad,'Omerga','omerga',1),
(@palghar,'Palghar Urban','palghar-urban',1),(@palghar,'Boisar','boisar',1),(@palghar,'Dahanu','dahanu',1),(@palghar,'Wada','wada-palghar',1),(@palghar,'Manor','manor',1),
(@parbhani,'Parbhani Urban','parbhani-urban',1),(@parbhani,'Jintur','jintur',1),(@parbhani,'Gangakhed','gangakhed',1),
(@raigad,'Alibag','alibag',1),(@raigad,'Panvel','panvel',1),(@raigad,'Pen','pen-raigad',1),(@raigad,'Uran','uran',1),(@raigad,'Roha','roha',1),
(@ratnagiri,'Ratnagiri Urban','ratnagiri-urban',1),(@ratnagiri,'Chiplun','chiplun',1),(@ratnagiri,'Khed','khed-ratnagiri',1),(@ratnagiri,'Guhagar','guhagar',1),
(@sangli,'Sangli Urban','sangli-urban',1),(@sangli,'Miraj','miraj',1),(@sangli,'Kupwad','kupwad',1),(@sangli,'Islampur','islampur',1),(@sangli,'Shirala','shirala',1),
(@satara,'Satara Urban','satara-urban',1),(@satara,'Karad','karad',1),(@satara,'Panchgani','panchgani',1),(@satara,'Wai','wai-satara',1),(@satara,'Mahabaleshwar','mahabaleshwar',1),
(@sindhudurg,'Sindhudurg Urban','sindhudurg-urban',1),(@sindhudurg,'Sawantwadi','sawantwadi',1),(@sindhudurg,'Kudal','kudal',1),(@sindhudurg,'Malvan','malvan',1),
(@wardha,'Wardha Urban','wardha-urban',1),(@wardha,'Hinganghat','hinganghat',1),(@wardha,'Arvi','arvi',1),(@wardha,'Deoli','deoli-wardha',1),
(@washim,'Washim Urban','washim-urban',1),(@washim,'Risod','risod',1),(@washim,'Karanja','karanja',1),
(@yavatmal,'Yavatmal Urban','yavatmal-urban',1),(@yavatmal,'Wani','wani',1),(@yavatmal,'Pusad','pusad',1),(@yavatmal,'Hingoli Yavatmal','hingoli-yavatmal',1);

-- ════════════════════════════════════════════════════════════════
--  UTTAR PRADESH – ALL 75 Districts
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Agra','agra','Uttar Pradesh',1),('Aligarh','aligarh','Uttar Pradesh',1),('Ambedkar Nagar','ambedkar-nagar','Uttar Pradesh',1),
('Amethi','amethi','Uttar Pradesh',1),('Amroha','amroha','Uttar Pradesh',1),('Auraiya','auraiya','Uttar Pradesh',1),
('Ayodhya','ayodhya','Uttar Pradesh',1),('Azamgarh','azamgarh','Uttar Pradesh',1),('Baghpat','baghpat','Uttar Pradesh',1),
('Bahraich','bahraich','Uttar Pradesh',1),('Ballia','ballia','Uttar Pradesh',1),('Balrampur','balrampur','Uttar Pradesh',1),
('Banda','banda','Uttar Pradesh',1),('Barabanki','barabanki','Uttar Pradesh',1),('Basti','basti','Uttar Pradesh',1),
('Bijnor','bijnor','Uttar Pradesh',1),('Budaun','budaun','Uttar Pradesh',1),('Bulandshahr','bulandshahr','Uttar Pradesh',1),
('Chandauli','chandauli','Uttar Pradesh',1),('Chitrakoot','chitrakoot','Uttar Pradesh',1),('Deoria','deoria','Uttar Pradesh',1),
('Etah','etah','Uttar Pradesh',1),('Etawah','etawah','Uttar Pradesh',1),('Farrukhabad','farrukhabad','Uttar Pradesh',1),
('Fatehpur','fatehpur','Uttar Pradesh',1),('Firozabad','firozabad','Uttar Pradesh',1),('Gautam Buddha Nagar','gautam-buddha-nagar','Uttar Pradesh',1),
('Ghazipur','ghazipur','Uttar Pradesh',1),('Gonda','gonda','Uttar Pradesh',1),('Gorakhpur','gorakhpur','Uttar Pradesh',1),
('Hamirpur','hamirpur-up','Uttar Pradesh',1),('Hapur','hapur','Uttar Pradesh',1),('Hardoi','hardoi','Uttar Pradesh',1),
('Hathras','hathras','Uttar Pradesh',1),('Jalaun','jalaun','Uttar Pradesh',1),('Jaunpur','jaunpur','Uttar Pradesh',1),
('Jhansi','jhansi','Uttar Pradesh',1),('Kannauj','kannauj','Uttar Pradesh',1),('Kanpur Dehat','kanpur-dehat','Uttar Pradesh',1),
('Kasganj','kasganj','Uttar Pradesh',1),('Kaushambi','kaushambi','Uttar Pradesh',1),('Kheri','kheri','Uttar Pradesh',1),
('Kushinagar','kushinagar','Uttar Pradesh',1),('Lalitpur','lalitpur','Uttar Pradesh',1),('Mahoba','mahoba','Uttar Pradesh',1),
('Mahrajganj','mahrajganj','Uttar Pradesh',1),('Mainpuri','mainpuri','Uttar Pradesh',1),('Mathura','mathura','Uttar Pradesh',1),
('Mau','mau-up','Uttar Pradesh',1),('Mirzapur','mirzapur','Uttar Pradesh',1),('Moradabad','moradabad','Uttar Pradesh',1),
('Muzaffarnagar','muzaffarnagar','Uttar Pradesh',1),('Pilibhit','pilibhit','Uttar Pradesh',1),('Pratapgarh','pratapgarh','Uttar Pradesh',1),
('Prayagraj','prayagraj','Uttar Pradesh',1),('Raebareli','raebareli','Uttar Pradesh',1),('Rampur','rampur','Uttar Pradesh',1),
('Saharanpur','saharanpur','Uttar Pradesh',1),('Sambhal','sambhal','Uttar Pradesh',1),('Sant Kabir Nagar','sant-kabir-nagar','Uttar Pradesh',1),
('Shahjahanpur','shahjahanpur','Uttar Pradesh',1),('Shamli','shamli','Uttar Pradesh',1),('Shravasti','shravasti','Uttar Pradesh',1),
('Siddharthnagar','siddharthnagar','Uttar Pradesh',1),('Sitapur','sitapur','Uttar Pradesh',1),('Sonbhadra','sonbhadra','Uttar Pradesh',1),
('Sultanpur','sultanpur','Uttar Pradesh',1),('Unnao','unnao','Uttar Pradesh',1);

-- Add key tehsils for UP districts
SET @aligarh=(SELECT id FROM districts WHERE slug='aligarh');
SET @gorakhpur=(SELECT id FROM districts WHERE slug='gorakhpur');
SET @jhansi=(SELECT id FROM districts WHERE slug='jhansi');
SET @mathura=(SELECT id FROM districts WHERE slug='mathura');
SET @moradabad=(SELECT id FROM districts WHERE slug='moradabad');
SET @prayagraj=(SELECT id FROM districts WHERE slug='prayagraj');
SET @muzaffarnagar=(SELECT id FROM districts WHERE slug='muzaffarnagar');
SET @saharanpur=(SELECT id FROM districts WHERE slug='saharanpur');
SET @ghaziabad_up=(SELECT id FROM districts WHERE slug='ghaziabad');
SET @firozabad=(SELECT id FROM districts WHERE slug='firozabad');
SET @ayodhya=(SELECT id FROM districts WHERE slug='ayodhya');
SET @azamgarh=(SELECT id FROM districts WHERE slug='azamgarh');
SET @jaunpur=(SELECT id FROM districts WHERE slug='jaunpur');
SET @ballia=(SELECT id FROM districts WHERE slug='ballia');
SET @basti=(SELECT id FROM districts WHERE slug='basti');
SET @deoria=(SELECT id FROM districts WHERE slug='deoria');
SET @kushinagar=(SELECT id FROM districts WHERE slug='kushinagar');
SET @mirzapur=(SELECT id FROM districts WHERE slug='mirzapur');
SET @sonbhadra=(SELECT id FROM districts WHERE slug='sonbhadra');
SET @sitapur=(SELECT id FROM districts WHERE slug='sitapur');
SET @hardoi=(SELECT id FROM districts WHERE slug='hardoi');
SET @unnao=(SELECT id FROM districts WHERE slug='unnao');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@aligarh,'Aligarh City','aligarh-city',1),(@aligarh,'Hathras Mandal','hathras-mandal',1),(@aligarh,'Koil','koil',1),
(@gorakhpur,'Gorakhpur City','gorakhpur-city',1),(@gorakhpur,'Deoria Mandal','deoria-mandal',1),(@gorakhpur,'Sahjanwa','sahjanwa',1),(@gorakhpur,'Gola Gokarannath','gola-gokarannath',1),
(@jhansi,'Jhansi City','jhansi-city',1),(@jhansi,'Lalitpur Mandal','lalitpur-mandal',1),(@jhansi,'Moth','moth',1),
(@mathura,'Mathura City','mathura-city',1),(@mathura,'Vrindavan','vrindavan',1),(@mathura,'Govardhan','govardhan',1),(@mathura,'Mahaban','mahaban',1),
(@moradabad,'Moradabad City','moradabad-city',1),(@moradabad,'Rampur Mandal','rampur-mandal',1),(@moradabad,'Sambhal Mandal','sambhal-mandal',1),(@moradabad,'Amroha Mandal','amroha-mandal',1),
(@prayagraj,'Prayagraj City','prayagraj-city',1),(@prayagraj,'Phulpur','phulpur',1),(@prayagraj,'Karchana','karchana',1),(@prayagraj,'Soraon','soraon',1),
(@muzaffarnagar,'Muzaffarnagar City','muzaffarnagar-city',1),(@muzaffarnagar,'Shamli Mandal','shamli-mandal',1),(@muzaffarnagar,'Khatauli','khatauli',1),
(@saharanpur,'Saharanpur City','saharanpur-city',1),(@saharanpur,'Deoband','deoband',1),(@saharanpur,'Nakur','nakur',1),
(@firozabad,'Firozabad City','firozabad-city',1),(@firozabad,'Sirsaganj','sirsaganj',1),(@firozabad,'Shikohabad','shikohabad',1),
(@ayodhya,'Ayodhya City','ayodhya-city',1),(@ayodhya,'Faizabad','faizabad',1),(@ayodhya,'Rudauli','rudauli',1),
(@azamgarh,'Azamgarh City','azamgarh-city',1),(@azamgarh,'Lalganj','lalganj',1),(@azamgarh,'Mau Mandal','mau-mandal',1),
(@jaunpur,'Jaunpur City','jaunpur-city',1),(@jaunpur,'Shahganj','shahganj',1),(@jaunpur,'Mariahu','mariahu',1),
(@ballia,'Ballia City','ballia-city',1),(@ballia,'Bairia','bairia',1),(@ballia,'Rasra','rasra',1),
(@basti,'Basti City','basti-city',1),(@basti,'Khalilabad','khalilabad',1),(@basti,'Harraiya','harraiya',1),
(@deoria,'Deoria City','deoria-city',1),(@deoria,'Bhatpar Rani','bhatpar-rani',1),(@deoria,'Rudrapur UP','rudrapur-up',1),
(@kushinagar,'Kushinagar City','kushinagar-city',1),(@kushinagar,'Padrauna','padrauna',1),(@kushinagar,'Hata','hata',1),
(@mirzapur,'Mirzapur City','mirzapur-city',1),(@mirzapur,'Chunar','chunar',1),(@mirzapur,'Lalganj Mirzapur','lalganj-mirzapur',1),
(@sonbhadra,'Sonbhadra City','sonbhadra-city',1),(@sonbhadra,'Robertsganj','robertsganj',1),(@sonbhadra,'Renukoot','renukoot',1),
(@sitapur,'Sitapur City','sitapur-city',1),(@sitapur,'Laharpur','laharpur',1),(@sitapur,'Biswan','biswan',1),
(@hardoi,'Hardoi City','hardoi-city',1),(@hardoi,'Shahabad UP','shahabad-up',1),(@hardoi,'Sandila','sandila',1),
(@unnao,'Unnao City','unnao-city',1),(@unnao,'Purwa','purwa',1),(@unnao,'Safipur','safipur',1);

-- ════════════════════════════════════════════════════════════════
--  RAJASTHAN – ALL 50 Districts
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Alwar','alwar','Rajasthan',1),('Banswara','banswara','Rajasthan',1),('Baran','baran','Rajasthan',1),
('Barmer','barmer','Rajasthan',1),('Bharatpur','bharatpur','Rajasthan',1),('Bhilwara','bhilwara','Rajasthan',1),
('Bikaner','bikaner','Rajasthan',1),('Bundi','bundi','Rajasthan',1),('Chittorgarh','chittorgarh','Rajasthan',1),
('Churu','churu','Rajasthan',1),('Dausa','dausa','Rajasthan',1),('Dholpur','dholpur','Rajasthan',1),
('Dungarpur','dungarpur','Rajasthan',1),('Hanumangarh','hanumangarh','Rajasthan',1),('Jaisalmer','jaisalmer','Rajasthan',1),
('Jalore','jalore','Rajasthan',1),('Jhalawar','jhalawar','Rajasthan',1),('Jhunjhunu','jhunjhunu','Rajasthan',1),
('Karauli','karauli','Rajasthan',1),('Nagaur','nagaur','Rajasthan',1),('Pali','pali','Rajasthan',1),
('Pratapgarh Rajasthan','pratapgarh-rajasthan','Rajasthan',1),('Rajsamand','rajsamand','Rajasthan',1),('Sawai Madhopur','sawai-madhopur','Rajasthan',1),
('Sikar','sikar','Rajasthan',1),('Sirohi','sirohi','Rajasthan',1),('Sri Ganganagar','sri-ganganagar','Rajasthan',1),
('Tonk','tonk','Rajasthan',1),('Swai Madhopur','swai-madhopur','Rajasthan',1);

SET @alwar=(SELECT id FROM districts WHERE slug='alwar');
SET @bikaner=(SELECT id FROM districts WHERE slug='bikaner');
SET @bharatpur=(SELECT id FROM districts WHERE slug='bharatpur');
SET @sikar=(SELECT id FROM districts WHERE slug='sikar');
SET @sriganganagar=(SELECT id FROM districts WHERE slug='sri-ganganagar');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@alwar,'Alwar City','alwar-city',1),(@alwar,'Behror','behror',1),(@alwar,'Tijara','tijara',1),(@alwar,'Kishangarh Bas','kishangarh-bas',1),
(@bikaner,'Bikaner City','bikaner-city',1),(@bikaner,'Nokha','nokha',1),(@bikaner,'Dungargarh','dungargarh',1),(@bikaner,'Kolayat','kolayat',1),
(@bharatpur,'Bharatpur City','bharatpur-city',1),(@bharatpur,'Deeg','deeg',1),(@bharatpur,'Kumher','kumher',1),
(@sikar,'Sikar City','sikar-city',1),(@sikar,'Fatehpur Shekhawati','fatehpur-shekhawati',1),(@sikar,'Lachhmangarh','lachhmangarh',1),(@sikar,'Neem Ka Thana','neem-ka-thana',1),
(@sriganganagar,'Sri Ganganagar City','sri-ganganagar-city',1),(@sriganganagar,'Suratgarh','suratgarh',1),(@sriganganagar,'Anupgarh','anupgarh',1);

-- ════════════════════════════════════════════════════════════════
--  GUJARAT – ALL 33 Districts + Key Taluks
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Amreli','amreli','Gujarat',1),('Anand','anand','Gujarat',1),('Aravalli','aravalli','Gujarat',1),
('Banaskantha','banaskantha','Gujarat',1),('Bharuch','bharuch','Gujarat',1),('Botad','botad','Gujarat',1),
('Chhota Udaipur','chhota-udaipur','Gujarat',1),('Dahod','dahod','Gujarat',1),('Dang','dang','Gujarat',1),
('Devbhoomi Dwarka','devbhoomi-dwarka','Gujarat',1),('Gir Somnath','gir-somnath','Gujarat',1),('Jamnagar','jamnagar','Gujarat',1),
('Junagadh','junagadh','Gujarat',1),('Kheda','kheda','Gujarat',1),('Kutch','kutch','Gujarat',1),
('Mahisagar','mahisagar','Gujarat',1),('Mehsana','mehsana','Gujarat',1),('Morbi','morbi','Gujarat',1),
('Narmada','narmada','Gujarat',1),('Navsari','navsari','Gujarat',1),('Panchmahal','panchmahal','Gujarat',1),
('Patan','patan','Gujarat',1),('Porbandar','porbandar','Gujarat',1),('Sabarkantha','sabarkantha','Gujarat',1),
('Surat District','surat-district','Gujarat',1),('Surendranagar','surendranagar','Gujarat',1),('Tapi','tapi','Gujarat',1),
('Valsad','valsad','Gujarat',1);

SET @jamnagar=(SELECT id FROM districts WHERE slug='jamnagar');
SET @junagadh=(SELECT id FROM districts WHERE slug='junagadh');
SET @mehsana=(SELECT id FROM districts WHERE slug='mehsana');
SET @anand=(SELECT id FROM districts WHERE slug='anand');
SET @kheda=(SELECT id FROM districts WHERE slug='kheda');
SET @valsad=(SELECT id FROM districts WHERE slug='valsad');
SET @navsari=(SELECT id FROM districts WHERE slug='navsari');
SET @bharuch=(SELECT id FROM districts WHERE slug='bharuch');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@jamnagar,'Jamnagar City','jamnagar-city',1),(@jamnagar,'Dwarka','dwarka-gujarat',1),(@jamnagar,'Jam Jodhpur','jam-jodhpur',1),
(@junagadh,'Junagadh City','junagadh-city',1),(@junagadh,'Veraval','veraval',1),(@junagadh,'Somnath','somnath',1),(@junagadh,'Porbandar Mandal','porbandar-mandal',1),
(@mehsana,'Mehsana City','mehsana-city',1),(@mehsana,'Patan Mandal','patan-mandal',1),(@mehsana,'Unjha','unjha',1),(@mehsana,'Visnagar','visnagar',1),
(@anand,'Anand City','anand-city',1),(@anand,'Vallabh Vidyanagar','vallabh-vidyanagar',1),(@anand,'Anklav','anklav',1),
(@kheda,'Kheda City','kheda-city',1),(@kheda,'Nadiad','nadiad',1),(@kheda,'Mahemdabad','mahemdabad',1),
(@valsad,'Valsad City','valsad-city',1),(@valsad,'Vapi','vapi',1),(@valsad,'Bulsar','bulsar',1),
(@navsari,'Navsari City','navsari-city',1),(@navsari,'Gandevi','gandevi',1),(@navsari,'Jalalpore','jalalpore',1),
(@bharuch,'Bharuch City','bharuch-city',1),(@bharuch,'Ankleshwar','ankleshwar',1),(@bharuch,'Jhagadia','jhagadia',1);

-- ════════════════════════════════════════════════════════════════
--  MADHYA PRADESH – ALL 52 Districts
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Agar Malwa','agar-malwa','Madhya Pradesh',1),('Alirajpur','alirajpur','Madhya Pradesh',1),('Anuppur','anuppur','Madhya Pradesh',1),
('Ashoknagar','ashoknagar','Madhya Pradesh',1),('Balaghat','balaghat','Madhya Pradesh',1),('Barwani','barwani','Madhya Pradesh',1),
('Betul','betul','Madhya Pradesh',1),('Bhind','bhind','Madhya Pradesh',1),('Burhanpur','burhanpur','Madhya Pradesh',1),
('Chhatarpur','chhatarpur','Madhya Pradesh',1),('Chhindwara','chhindwara','Madhya Pradesh',1),('Damoh','damoh','Madhya Pradesh',1),
('Datia','datia','Madhya Pradesh',1),('Dewas','dewas','Madhya Pradesh',1),('Dhar','dhar','Madhya Pradesh',1),
('Dindori','dindori','Madhya Pradesh',1),('Guna','guna','Madhya Pradesh',1),('Harda','harda','Madhya Pradesh',1),
('Hoshangabad','hoshangabad','Madhya Pradesh',1),('Katni','katni','Madhya Pradesh',1),('Khandwa','khandwa','Madhya Pradesh',1),
('Khargone','khargone','Madhya Pradesh',1),('Mandla','mandla','Madhya Pradesh',1),('Mandsaur','mandsaur','Madhya Pradesh',1),
('Morena','morena','Madhya Pradesh',1),('Narsinghpur','narsinghpur','Madhya Pradesh',1),('Neemuch','neemuch','Madhya Pradesh',1),
('Niwari','niwari','Madhya Pradesh',1),('Panna','panna','Madhya Pradesh',1),('Raisen','raisen','Madhya Pradesh',1),
('Rajgarh','rajgarh-mp','Madhya Pradesh',1),('Ratlam','ratlam','Madhya Pradesh',1),('Rewa','rewa','Madhya Pradesh',1),
('Sagar','sagar','Madhya Pradesh',1),('Satna','satna','Madhya Pradesh',1),('Sehore','sehore','Madhya Pradesh',1),
('Seoni','seoni','Madhya Pradesh',1),('Shahdol','shahdol','Madhya Pradesh',1),('Shajapur','shajapur','Madhya Pradesh',1),
('Sheopur','sheopur','Madhya Pradesh',1),('Shivpuri','shivpuri','Madhya Pradesh',1),('Sidhi','sidhi','Madhya Pradesh',1),
('Singrauli','singrauli','Madhya Pradesh',1),('Tikamgarh','tikamgarh','Madhya Pradesh',1),('Umariya','umariya','Madhya Pradesh',1),
('Vidisha','vidisha','Madhya Pradesh',1),('Vijaypur','vijaypur-mp','Madhya Pradesh',1);

SET @rewa=(SELECT id FROM districts WHERE slug='rewa');SET @sagar=(SELECT id FROM districts WHERE slug='sagar');
SET @satna=(SELECT id FROM districts WHERE slug='satna');SET @chhindwara=(SELECT id FROM districts WHERE slug='chhindwara');
SET @ratlam=(SELECT id FROM districts WHERE slug='ratlam');SET @dewas=(SELECT id FROM districts WHERE slug='dewas');
SET @vidisha=(SELECT id FROM districts WHERE slug='vidisha');SET @hoshangabad=(SELECT id FROM districts WHERE slug='hoshangabad');
SET @morena=(SELECT id FROM districts WHERE slug='morena');SET @khandwa=(SELECT id FROM districts WHERE slug='khandwa');
SET @katni=(SELECT id FROM districts WHERE slug='katni');SET @shahdol=(SELECT id FROM districts WHERE slug='shahdol');
SET @singrauli=(SELECT id FROM districts WHERE slug='singrauli');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@rewa,'Rewa City','rewa-city',1),(@rewa,'Satna Mandal','satna-mandal',1),(@rewa,'Sirmour','sirmour',1),
(@sagar,'Sagar City','sagar-city',1),(@sagar,'Banda MP','banda-mp',1),(@sagar,'Khurai','khurai',1),
(@satna,'Satna City','satna-city',1),(@satna,'Maihar','maihar',1),(@satna,'Amarpatan','amarpatan',1),
(@chhindwara,'Chhindwara City','chhindwara-city',1),(@chhindwara,'Pandhurna','pandhurna',1),(@chhindwara,'Sausar','sausar',1),
(@ratlam,'Ratlam City','ratlam-city',1),(@ratlam,'Jaora','jaora',1),(@ratlam,'Alot','alot',1),
(@dewas,'Dewas City','dewas-city',1),(@dewas,'Kannod','kannod',1),(@dewas,'Sonkatch','sonkatch',1),
(@vidisha,'Vidisha City','vidisha-city',1),(@vidisha,'Sanchi','sanchi',1),(@vidisha,'Gyaraspur','gyaraspur',1),
(@hoshangabad,'Hoshangabad City','hoshangabad-city',1),(@hoshangabad,'Itarsi','itarsi',1),(@hoshangabad,'Pipariya','pipariya',1),
(@morena,'Morena City','morena-city',1),(@morena,'Ambah','ambah',1),(@morena,'Porsa','porsa',1),
(@khandwa,'Khandwa City','khandwa-city',1),(@khandwa,'Burhanpur Mandal','burhanpur-mandal',1),(@khandwa,'Khalwa','khalwa',1),
(@katni,'Katni City','katni-city',1),(@katni,'Vijayraghavgarh','vijayraghavgarh',1),(@katni,'Bahoriband','bahoriband',1),
(@shahdol,'Shahdol City','shahdol-city',1),(@shahdol,'Umaria Mandal','umaria-mandal',1),(@shahdol,'Anuppur Mandal','anuppur-mandal',1),
(@singrauli,'Singrauli City','singrauli-city',1),(@singrauli,'Waidhan','waidhan',1),(@singrauli,'Chitrangi','chitrangi',1);

-- ════════════════════════════════════════════════════════════════
--  BIHAR – ALL 38 Districts + Key Blocks
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Araria','araria','Bihar',1),('Arwal','arwal','Bihar',1),('Aurangabad Bihar','aurangabad-bihar','Bihar',1),
('Banka','banka','Bihar',1),('Begusarai','begusarai','Bihar',1),('Bhagalpur','bhagalpur','Bihar',1),
('Bhojpur','bhojpur','Bihar',1),('Buxar','buxar','Bihar',1),('Darbhanga','darbhanga','Bihar',1),
('East Champaran','east-champaran','Bihar',1),('Gaya','gaya','Bihar',1),('Gopalganj','gopalganj','Bihar',1),
('Jamui','jamui','Bihar',1),('Jehanabad','jehanabad','Bihar',1),('Kaimur','kaimur','Bihar',1),
('Katihar','katihar','Bihar',1),('Khagaria','khagaria','Bihar',1),('Kishanganj','kishanganj','Bihar',1),
('Lakhisarai','lakhisarai','Bihar',1),('Madhepura','madhepura','Bihar',1),('Madhubani','madhubani','Bihar',1),
('Munger','munger','Bihar',1),('Muzaffarpur','muzaffarpur','Bihar',1),('Nalanda','nalanda','Bihar',1),
('Nawada','nawada','Bihar',1),('Purnia','purnia','Bihar',1),('Rohtas','rohtas','Bihar',1),
('Saharsa','saharsa','Bihar',1),('Samastipur','samastipur','Bihar',1),('Saran','saran','Bihar',1),
('Sheikhpura','sheikhpura','Bihar',1),('Sheohar','sheohar','Bihar',1),('Sitamarhi','sitamarhi','Bihar',1),
('Siwan','siwan','Bihar',1),('Supaul','supaul','Bihar',1),('Vaishali','vaishali-bihar','Bihar',1),
('West Champaran','west-champaran','Bihar',1);

SET @bhagalpur=(SELECT id FROM districts WHERE slug='bhagalpur');SET @gaya=(SELECT id FROM districts WHERE slug='gaya');
SET @muzaffarpur=(SELECT id FROM districts WHERE slug='muzaffarpur');SET @darbhanga=(SELECT id FROM districts WHERE slug='darbhanga');
SET @bhojpur=(SELECT id FROM districts WHERE slug='bhojpur');SET @rohtas=(SELECT id FROM districts WHERE slug='rohtas');
SET @saran=(SELECT id FROM districts WHERE slug='saran');SET @eastchamparan=(SELECT id FROM districts WHERE slug='east-champaran');
SET @westchamparan=(SELECT id FROM districts WHERE slug='west-champaran');SET @samastipur=(SELECT id FROM districts WHERE slug='samastipur');
SET @nawada=(SELECT id FROM districts WHERE slug='nawada');SET @purnia=(SELECT id FROM districts WHERE slug='purnia');
SET @katihar=(SELECT id FROM districts WHERE slug='katihar');SET @begusarai=(SELECT id FROM districts WHERE slug='begusarai');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@bhagalpur,'Bhagalpur City','bhagalpur-city',1),(@bhagalpur,'Banka Mandal','banka-mandal',1),(@bhagalpur,'Sultanganj','sultanganj',1),
(@gaya,'Gaya City','gaya-city',1),(@gaya,'Bodh Gaya','bodh-gaya',1),(@gaya,'Sherghati','sherghati',1),(@gaya,'Nawada Mandal','nawada-mandal',1),
(@muzaffarpur,'Muzaffarpur City','muzaffarpur-city',1),(@muzaffarpur,'Sitamarhi Mandal','sitamarhi-mandal',1),(@muzaffarpur,'Hajipur','hajipur',1),(@muzaffarpur,'Motipur','motipur',1),
(@darbhanga,'Darbhanga City','darbhanga-city',1),(@darbhanga,'Madhubani Mandal','madhubani-mandal',1),(@darbhanga,'Samastipur Mandal','samastipur-mandal',1),
(@bhojpur,'Arrah','arrah',1),(@bhojpur,'Buxar Mandal','buxar-mandal',1),(@bhojpur,'Jagdishpur','jagdishpur',1),
(@rohtas,'Sasaram','sasaram',1),(@rohtas,'Dehri','dehri',1),(@rohtas,'Bikramganj','bikramganj',1),
(@saran,'Chhapra','chhapra',1),(@saran,'Siwan Mandal','siwan-mandal',1),(@saran,'Gopalganj Mandal','gopalganj-mandal',1),
(@eastchamparan,'Motihari','motihari',1),(@eastchamparan,'Raxaul','raxaul',1),(@eastchamparan,'Adapur','adapur',1),
(@westchamparan,'Bettiah','bettiah',1),(@westchamparan,'Bagaha','bagaha',1),(@westchamparan,'Narkatiaganj','narkatiaganj',1),
(@samastipur,'Samastipur City','samastipur-city',1),(@samastipur,'Rosera','rosera',1),(@samastipur,'Darbhanga Mandal2','darbhanga-mandal2',1),
(@purnia,'Purnia City','purnia-city',1),(@purnia,'Katihar Mandal','katihar-mandal',1),(@purnia,'Araria Mandal','araria-mandal',1),(@purnia,'Kishanganj Mandal','kishanganj-mandal',1),
(@katihar,'Katihar City','katihar-city',1),(@katihar,'Barari','barari',1),(@katihar,'Manihari','manihari',1),
(@begusarai,'Begusarai City','begusarai-city',1),(@begusarai,'Barauni','barauni',1),(@begusarai,'Teghra','teghra',1),
(@nawada,'Nawada City','nawada-city',1),(@nawada,'Rajauli','rajauli',1),(@nawada,'Warsaliganj','warsaliganj',1);

-- ════════════════════════════════════════════════════════════════
--  JHARKHAND – ALL 24 Districts
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Bokaro','bokaro','Jharkhand',1),('Chatra','chatra','Jharkhand',1),('Deoghar','deoghar','Jharkhand',1),
('Dhanbad','dhanbad','Jharkhand',1),('Dumka','dumka','Jharkhand',1),('East Singhbhum','east-singhbhum','Jharkhand',1),
('Garhwa','garhwa','Jharkhand',1),('Giridih','giridih','Jharkhand',1),('Godda','godda','Jharkhand',1),
('Gumla','gumla','Jharkhand',1),('Hazaribagh','hazaribagh','Jharkhand',1),('Jamtara','jamtara','Jharkhand',1),
('Khunti','khunti','Jharkhand',1),('Koderma','koderma','Jharkhand',1),('Latehar','latehar','Jharkhand',1),
('Lohardaga','lohardaga','Jharkhand',1),('Pakur','pakur','Jharkhand',1),('Palamu','palamu','Jharkhand',1),
('Ramgarh','ramgarh','Jharkhand',1),('Sahibganj','sahibganj','Jharkhand',1),('Seraikela Kharsawan','seraikela-kharsawan','Jharkhand',1),
('Simdega','simdega','Jharkhand',1),('West Singhbhum','west-singhbhum','Jharkhand',1);

SET @dhanbad=(SELECT id FROM districts WHERE slug='dhanbad');SET @bokaro=(SELECT id FROM districts WHERE slug='bokaro');
SET @eastsinghbhum=(SELECT id FROM districts WHERE slug='east-singhbhum');SET @hazaribagh=(SELECT id FROM districts WHERE slug='hazaribagh');
SET @deoghar=(SELECT id FROM districts WHERE slug='deoghar');SET @giridih=(SELECT id FROM districts WHERE slug='giridih');
SET @westsinghbhum=(SELECT id FROM districts WHERE slug='west-singhbhum');SET @palamu=(SELECT id FROM districts WHERE slug='palamu');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@dhanbad,'Dhanbad City','dhanbad-city',1),(@dhanbad,'Jharia','jharia',1),(@dhanbad,'Nirsa','nirsa',1),(@dhanbad,'Topchanchi','topchanchi',1),
(@bokaro,'Bokaro City','bokaro-city',1),(@bokaro,'Chas','chas',1),(@bokaro,'Ramgarh Mandal','ramgarh-mandal',1),
(@eastsinghbhum,'Jamshedpur','jamshedpur',1),(@eastsinghbhum,'Ghatsila','ghatsila',1),(@eastsinghbhum,'Baharagora','baharagora',1),
(@hazaribagh,'Hazaribagh City','hazaribagh-city',1),(@hazaribagh,'Chatra Mandal','chatra-mandal',1),(@hazaribagh,'Koderma Mandal','koderma-mandal',1),
(@deoghar,'Deoghar City','deoghar-city',1),(@deoghar,'Baidyanath Dham','baidyanath-dham',1),(@deoghar,'Jasidih','jasidih',1),
(@giridih,'Giridih City','giridih-city',1),(@giridih,'Dumka Mandal','dumka-mandal',1),(@giridih,'Madhupur','madhupur',1),
(@westsinghbhum,'Chaibasa','chaibasa',1),(@westsinghbhum,'Chakradharpur','chakradharpur',1),(@westsinghbhum,'Khunti Mandal','khunti-mandal',1),
(@palamu,'Daltonganj','daltonganj',1),(@palamu,'Medininagar','medininagar',1),(@palamu,'Garhwa Mandal','garhwa-mandal',1);

-- ════════════════════════════════════════════════════════════════
--  ODISHA – ALL 30 Districts
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Angul','angul','Odisha',1),('Balangir','balangir','Odisha',1),('Balasore','balasore','Odisha',1),
('Bargarh','bargarh','Odisha',1),('Bhadrak','bhadrak','Odisha',1),('Bolangir','bolangir','Odisha',1),
('Debagarh','debagarh','Odisha',1),('Dhenkanal','dhenkanal','Odisha',1),('Gajapati','gajapati','Odisha',1),
('Ganjam','ganjam','Odisha',1),('Jagatsinghpur','jagatsinghpur','Odisha',1),('Jajpur','jajpur','Odisha',1),
('Jharsuguda','jharsuguda','Odisha',1),('Kalahandi','kalahandi','Odisha',1),('Kandhamal','kandhamal','Odisha',1),
('Kendrapara','kendrapara','Odisha',1),('Kendujhar','kendujhar','Odisha',1),('Khordha','khordha','Odisha',1),
('Koraput','koraput','Odisha',1),('Malkangiri','malkangiri','Odisha',1),('Mayurbhanj','mayurbhanj','Odisha',1),
('Nabarangapur','nabarangapur','Odisha',1),('Nayagarh','nayagarh','Odisha',1),('Nuapada','nuapada','Odisha',1),
('Puri','puri','Odisha',1),('Rayagada','rayagada','Odisha',1),('Sambalpur','sambalpur','Odisha',1),
('Subarnapur','subarnapur','Odisha',1),('Sundergarh','sundergarh','Odisha',1);

SET @puri=(SELECT id FROM districts WHERE slug='puri');SET @ganjam=(SELECT id FROM districts WHERE slug='ganjam');
SET @sambalpur=(SELECT id FROM districts WHERE slug='sambalpur');SET @balasore=(SELECT id FROM districts WHERE slug='balasore');
SET @jajpur=(SELECT id FROM districts WHERE slug='jajpur');SET @khordha=(SELECT id FROM districts WHERE slug='khordha');
SET @koraput=(SELECT id FROM districts WHERE slug='koraput');SET @mayurbhanj=(SELECT id FROM districts WHERE slug='mayurbhanj');
SET @sundergarh=(SELECT id FROM districts WHERE slug='sundergarh');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@puri,'Puri City','puri-city',1),(@puri,'Jagannath Puri','jagannath-puri',1),(@puri,'Konark','konark',1),(@puri,'Nimapara','nimapara',1),
(@ganjam,'Berhampur','berhampur',1),(@ganjam,'Chhatrapur','chhatrapur',1),(@ganjam,'Aska','aska',1),(@ganjam,'Bhanjanagar','bhanjanagar',1),
(@sambalpur,'Sambalpur City','sambalpur-city',1),(@sambalpur,'Bargarh Mandal','bargarh-mandal',1),(@sambalpur,'Jharsuguda Mandal','jharsuguda-mandal',1),(@sambalpur,'Rourkela','rourkela',1),
(@balasore,'Balasore City','balasore-city',1),(@balasore,'Bhadrak Mandal','bhadrak-mandal',1),(@balasore,'Jaleswar','jaleswar',1),(@balasore,'Chandbali','chandbali',1),
(@jajpur,'Jajpur City','jajpur-city',1),(@jajpur,'Kalinganagar','kalinganagar',1),(@jajpur,'Dharmasala','dharmasala',1),
(@khordha,'Bhubaneswar Mandal','bhubaneswar-mandal',1),(@khordha,'Khordha City','khordha-city',1),(@khordha,'Jatni','jatni',1),
(@koraput,'Koraput City','koraput-city',1),(@koraput,'Jeypore','jeypore',1),(@koraput,'Rayagada Mandal','rayagada-mandal',1),
(@mayurbhanj,'Baripada','baripada',1),(@mayurbhanj,'Rairangpur','rairangpur',1),(@mayurbhanj,'Karanjia','karanjia',1),
(@sundergarh,'Sundargarh City','sundargarh-city',1),(@sundergarh,'Rourkela Mandal','rourkela-mandal',1),(@sundergarh,'Rajgangpur','rajgangpur',1);

-- ════════════════════════════════════════════════════════════════
--  CHHATTISGARH – ALL 33 Districts
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Balod','balod','Chhattisgarh',1),('Baloda Bazar','baloda-bazar','Chhattisgarh',1),('Balrampur CG','balrampur-cg','Chhattisgarh',1),
('Bemetara','bemetara','Chhattisgarh',1),('Bijapur CG','bijapur-cg','Chhattisgarh',1),('Bilaspur CG','bilaspur-cg','Chhattisgarh',1),
('Dantewada','dantewada','Chhattisgarh',1),('Dhamtari','dhamtari','Chhattisgarh',1),('Durg','durg','Chhattisgarh',1),
('Gariaband','gariaband','Chhattisgarh',1),('Gaurela Pendra Marwahi','gaurela-pendra-marwahi','Chhattisgarh',1),
('Janjgir Champa','janjgir-champa','Chhattisgarh',1),('Jashpur','jashpur','Chhattisgarh',1),('Kanker','kanker','Chhattisgarh',1),
('Kabirdham','kabirdham','Chhattisgarh',1),('Kondagaon','kondagaon','Chhattisgarh',1),('Korba','korba','Chhattisgarh',1),
('Koriya','koriya','Chhattisgarh',1),('Mahasamund','mahasamund','Chhattisgarh',1),('Mungeli','mungeli','Chhattisgarh',1),
('Narayanpur','narayanpur-cg','Chhattisgarh',1),('Raigarh CG','raigarh-cg','Chhattisgarh',1),('Rajnandgaon','rajnandgaon','Chhattisgarh',1),
('Sakti','sakti','Chhattisgarh',1),('Sarangarh Bilaigarh','sarangarh-bilaigarh','Chhattisgarh',1),('Sukma','sukma','Chhattisgarh',1),
('Surajpur','surajpur','Chhattisgarh',1),('Surguja','surguja','Chhattisgarh',1);

SET @bilaspur_cg=(SELECT id FROM districts WHERE slug='bilaspur-cg');SET @durg=(SELECT id FROM districts WHERE slug='durg');
SET @korba=(SELECT id FROM districts WHERE slug='korba');SET @rajnandgaon=(SELECT id FROM districts WHERE slug='rajnandgaon');
SET @raigarh_cg=(SELECT id FROM districts WHERE slug='raigarh-cg');SET @surguja=(SELECT id FROM districts WHERE slug='surguja');
SET @janjgir=(SELECT id FROM districts WHERE slug='janjgir-champa');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@bilaspur_cg,'Bilaspur CG City','bilaspur-cg-city',1),(@bilaspur_cg,'Akaltara','akaltara',1),(@bilaspur_cg,'Takhatpur','takhatpur',1),(@bilaspur_cg,'Mungeli Mandal','mungeli-mandal',1),
(@durg,'Durg City','durg-city',1),(@durg,'Bhilai','bhilai',1),(@durg,'Rajnandgaon Mandal','rajnandgaon-mandal',1),(@durg,'Dhamtari Mandal','dhamtari-mandal',1),
(@korba,'Korba City','korba-city',1),(@korba,'Katghora','katghora',1),(@korba,'Pali CG','pali-cg',1),
(@rajnandgaon,'Rajnandgaon City','rajnandgaon-city',1),(@rajnandgaon,'Dongargarh','dongargarh',1),(@rajnandgaon,'Khairagarh','khairagarh',1),
(@raigarh_cg,'Raigarh City','raigarh-city',1),(@raigarh_cg,'Sarangarh','sarangarh',1),(@raigarh_cg,'Gharghoda','gharghoda',1),
(@surguja,'Ambikapur','ambikapur',1),(@surguja,'Surajpur Mandal','surajpur-mandal',1),(@surguja,'Baikunthpur','baikunthpur',1),
(@janjgir,'Janjgir Urban','janjgir-urban',1),(@janjgir,'Champa','champa',1),(@janjgir,'Sakti Mandal','sakti-mandal',1);

-- ════════════════════════════════════════════════════════════════
--  ASSAM – ALL 35 Districts
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Bajali','bajali','Assam',1),('Baksa','baksa','Assam',1),('Barpeta','barpeta','Assam',1),
('Biswanath','biswanath','Assam',1),('Bongaigaon','bongaigaon','Assam',1),('Cachar','cachar','Assam',1),
('Charaideo','charaideo','Assam',1),('Chirang','chirang','Assam',1),('Darrang','darrang','Assam',1),
('Dhemaji','dhemaji','Assam',1),('Dhubri','dhubri','Assam',1),('Dibrugarh','dibrugarh','Assam',1),
('Dima Hasao','dima-hasao','Assam',1),('Goalpara','goalpara','Assam',1),('Golaghat','golaghat','Assam',1),
('Hailakandi','hailakandi','Assam',1),('Hojai','hojai','Assam',1),('Jorhat','jorhat','Assam',1),
('Kamrup','kamrup','Assam',1),('Kamrup Metropolitan','kamrup-metropolitan','Assam',1),('Karbi Anglong','karbi-anglong','Assam',1),
('Karimganj','karimganj','Assam',1),('Kokrajhar','kokrajhar','Assam',1),('Lakhimpur','lakhimpur-assam','Assam',1),
('Majuli','majuli','Assam',1),('Morigaon','morigaon','Assam',1),('Nagaon','nagaon','Assam',1),
('Nalbari','nalbari','Assam',1),('Sivasagar','sivasagar','Assam',1),('Sonitpur','sonitpur','Assam',1),
('South Salmara','south-salmara','Assam',1),('Tinsukia','tinsukia','Assam',1),('Udalguri','udalguri','Assam',1),
('West Karbi Anglong','west-karbi-anglong','Assam',1);

SET @dibrugarh=(SELECT id FROM districts WHERE slug='dibrugarh');SET @jorhat=(SELECT id FROM districts WHERE slug='jorhat');
SET @cachar=(SELECT id FROM districts WHERE slug='cachar');SET @kamrup_m=(SELECT id FROM districts WHERE slug='kamrup-metropolitan');
SET @nagaon=(SELECT id FROM districts WHERE slug='nagaon');SET @sonitpur=(SELECT id FROM districts WHERE slug='sonitpur');
SET @tinsukia=(SELECT id FROM districts WHERE slug='tinsukia');SET @barpeta=(SELECT id FROM districts WHERE slug='barpeta');
SET @sivasagar=(SELECT id FROM districts WHERE slug='sivasagar');SET @karimganj=(SELECT id FROM districts WHERE slug='karimganj');
SET @golaghat=(SELECT id FROM districts WHERE slug='golaghat');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@dibrugarh,'Dibrugarh City','dibrugarh-city',1),(@dibrugarh,'Tinsukia Mandal','tinsukia-mandal',1),(@dibrugarh,'Naharkatia','naharkatia',1),
(@jorhat,'Jorhat City','jorhat-city',1),(@jorhat,'Titabar','titabar',1),(@jorhat,'Golaghat Mandal','golaghat-mandal',1),
(@cachar,'Silchar','silchar',1),(@cachar,'Sonai','sonai',1),(@cachar,'Hailakandi Mandal','hailakandi-mandal',1),
(@kamrup_m,'Guwahati Mandal','guwahati-mandal',1),(@kamrup_m,'Dispur','dispur',1),(@kamrup_m,'Jalukbari','jalukbari',1),
(@nagaon,'Nagaon City','nagaon-city',1),(@nagaon,'Hojai Mandal','hojai-mandal',1),(@nagaon,'Doboka','doboka',1),
(@sonitpur,'Tezpur','tezpur',1),(@sonitpur,'Dhekiajuli','dhekiajuli',1),(@sonitpur,'Biswanath Chariali','biswanath-chariali',1),
(@tinsukia,'Tinsukia City','tinsukia-city',1),(@tinsukia,'Doom Dooma','doom-dooma',1),(@tinsukia,'Margherita','margherita',1),
(@barpeta,'Barpeta City','barpeta-city',1),(@barpeta,'Barpeta Road','barpeta-road',1),(@barpeta,'Sorbhog','sorbhog',1),
(@sivasagar,'Sivasagar City','sivasagar-city',1),(@sivasagar,'Nazira','nazira',1),(@sivasagar,'Charaideo Mandal','charaideo-mandal',1),
(@karimganj,'Karimganj City','karimganj-city',1),(@karimganj,'Badarpur','badarpur',1),(@karimganj,'Ramkrishna Nagar','ramkrishna-nagar',1),
(@golaghat,'Golaghat City','golaghat-city',1),(@golaghat,'Bokajan','bokajan',1),(@golaghat,'Sarupathar','sarupathar',1);

-- ════════════════════════════════════════════════════════════════
--  WEST BENGAL – ALL 23 Districts
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Alipurduar','alipurduar','West Bengal',1),('Bankura','bankura','West Bengal',1),
('Birbhum','birbhum','West Bengal',1),('Cooch Behar','cooch-behar','West Bengal',1),
('Dakshin Dinajpur','dakshin-dinajpur','West Bengal',1),('Darjeeling','darjeeling','West Bengal',1),
('Hooghly','hooghly','West Bengal',1),('Jalpaiguri','jalpaiguri','West Bengal',1),
('Jhargram','jhargram','West Bengal',1),('Kalimpong','kalimpong','West Bengal',1),
('Malda','malda','West Bengal',1),('Murshidabad','murshidabad','West Bengal',1),
('Nadia','nadia','West Bengal',1),('North 24 Parganas','north-24-parganas','West Bengal',1),
('Paschim Bardhaman','paschim-bardhaman','West Bengal',1),('Paschim Medinipur','paschim-medinipur','West Bengal',1),
('Purba Bardhaman','purba-bardhaman','West Bengal',1),('Purba Medinipur','purba-medinipur','West Bengal',1),
('Purulia','purulia','West Bengal',1),('South 24 Parganas','south-24-parganas','West Bengal',1),
('Uttar Dinajpur','uttar-dinajpur','West Bengal',1);

SET @darjeeling=(SELECT id FROM districts WHERE slug='darjeeling');SET @murshidabad=(SELECT id FROM districts WHERE slug='murshidabad');
SET @nadia=(SELECT id FROM districts WHERE slug='nadia');SET @north24=(SELECT id FROM districts WHERE slug='north-24-parganas');
SET @south24=(SELECT id FROM districts WHERE slug='south-24-parganas');SET @hooghly=(SELECT id FROM districts WHERE slug='hooghly');
SET @malda=(SELECT id FROM districts WHERE slug='malda');SET @paschimbardhaman=(SELECT id FROM districts WHERE slug='paschim-bardhaman');
SET @purbamedinipur=(SELECT id FROM districts WHERE slug='purba-medinipur');SET @birbhum=(SELECT id FROM districts WHERE slug='birbhum');
SET @bankura=(SELECT id FROM districts WHERE slug='bankura');SET @jalpaiguri=(SELECT id FROM districts WHERE slug='jalpaiguri');
SET @coochbehar=(SELECT id FROM districts WHERE slug='cooch-behar');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@darjeeling,'Darjeeling Urban','darjeeling-urban',1),(@darjeeling,'Siliguri Mandal','siliguri-mandal',1),(@darjeeling,'Kurseong','kurseong',1),(@darjeeling,'Mirik','mirik',1),
(@murshidabad,'Murshidabad City','murshidabad-city',1),(@murshidabad,'Berhampore','berhampore',1),(@murshidabad,'Jangipur','jangipur',1),(@murshidabad,'Lalbagh','lalbagh',1),
(@nadia,'Krishnanagar','krishnanagar',1),(@nadia,'Ranaghat','ranaghat',1),(@nadia,'Nabadwip','nabadwip',1),(@nadia,'Santipur','santipur',1),
(@north24,'Barasat','barasat',1),(@north24,'Barrackpore','barrackpore',1),(@north24,'Bongaon','bongaon',1),(@north24,'Habra','habra',1),(@north24,'Naihati','naihati',1),
(@south24,'Diamond Harbour','diamond-harbour',1),(@south24,'Budge Budge','budge-budge',1),(@south24,'Baruipur','baruipur',1),(@south24,'Kakdwip','kakdwip',1),
(@hooghly,'Chinsurah','chinsurah',1),(@hooghly,'Chandannagar','chandannagar',1),(@hooghly,'Uttarpara','uttarpara',1),(@hooghly,'Serampore','serampore',1),
(@malda,'Malda City','malda-city',1),(@malda,'English Bazar','english-bazar',1),(@malda,'Old Malda','old-malda',1),(@malda,'Gajole','gajole',1),
(@paschimbardhaman,'Asansol Mandal','asansol-mandal',1),(@paschimbardhaman,'Durgapur Mandal','durgapur-mandal',1),(@paschimbardhaman,'Raniganj','raniganj',1),
(@purbamedinipur,'Tamluk','tamluk',1),(@purbamedinipur,'Haldia','haldia',1),(@purbamedinipur,'Contai','contai',1),
(@birbhum,'Suri','suri',1),(@birbhum,'Bolpur Santiniketan','bolpur-santiniketan',1),(@birbhum,'Rampurhat','rampurhat',1),
(@bankura,'Bankura City','bankura-city',1),(@bankura,'Bishnupur','bishnupur',1),(@bankura,'Sonamukhi','sonamukhi',1),
(@jalpaiguri,'Jalpaiguri City','jalpaiguri-city',1),(@jalpaiguri,'Alipurduar Mandal','alipurduar-mandal',1),(@jalpaiguri,'New Jalpaiguri','new-jalpaiguri',1),
(@coochbehar,'Cooch Behar City','cooch-behar-city',1),(@coochbehar,'Tufanganj','tufanganj',1),(@coochbehar,'Mathabhanga','mathabhanga',1);

-- ════════════════════════════════════════════════════════════════
--  HARYANA – ALL 22 Districts
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Bhiwani','bhiwani','Haryana',1),('Charkhi Dadri','charkhi-dadri','Haryana',1),('Fatehabad','fatehabad-hr','Haryana',1),
('Gurugram','gurugram','Haryana',1),('Jhajjar','jhajjar','Haryana',1),('Jind','jind','Haryana',1),
('Kaithal','kaithal','Haryana',1),('Karnal','karnal','Haryana',1),('Kurukshetra','kurukshetra','Haryana',1),
('Mahendragarh','mahendragarh','Haryana',1),('Mewat','mewat','Haryana',1),('Nuh','nuh','Haryana',1),
('Palwal','palwal','Haryana',1),('Panchkula','panchkula','Haryana',1),('Panipat','panipat','Haryana',1),
('Rewari','rewari','Haryana',1),('Sirsa','sirsa','Haryana',1),('Sonipat','sonipat','Haryana',1),
('Yamunanagar','yamunanagar','Haryana',1);

SET @karnal=(SELECT id FROM districts WHERE slug='karnal');SET @panipat=(SELECT id FROM districts WHERE slug='panipat');
SET @sonipat=(SELECT id FROM districts WHERE slug='sonipat');SET @panchkula=(SELECT id FROM districts WHERE slug='panchkula');
SET @yamunanagar=(SELECT id FROM districts WHERE slug='yamunanagar');SET @kurukshetra=(SELECT id FROM districts WHERE slug='kurukshetra');
SET @sirsa=(SELECT id FROM districts WHERE slug='sirsa');SET @jind=(SELECT id FROM districts WHERE slug='jind');
SET @kaithal=(SELECT id FROM districts WHERE slug='kaithal');SET @gurugram=(SELECT id FROM districts WHERE slug='gurugram');
SET @rewari=(SELECT id FROM districts WHERE slug='rewari');SET @palwal=(SELECT id FROM districts WHERE slug='palwal');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@karnal,'Karnal City','karnal-city',1),(@karnal,'Panipat Mandal','panipat-mandal',1),(@karnal,'Nilokheri','nilokheri',1),(@karnal,'Gharaunda','gharaunda',1),
(@panipat,'Panipat City','panipat-city',1),(@panipat,'Samalkha','samalkha',1),(@panipat,'Israna','israna',1),
(@sonipat,'Sonipat City','sonipat-city',1),(@sonipat,'Gohana','gohana',1),(@sonipat,'Kharkhoda','kharkhoda',1),
(@panchkula,'Panchkula City','panchkula-city',1),(@panchkula,'Kalka','kalka',1),(@panchkula,'Morni Hills','morni-hills',1),
(@yamunanagar,'Yamunanagar City','yamunanagar-city',1),(@yamunanagar,'Jagadhri','jagadhri',1),(@yamunanagar,'Radaur','radaur',1),
(@kurukshetra,'Kurukshetra City','kurukshetra-city',1),(@kurukshetra,'Thanesar','thanesar',1),(@kurukshetra,'Pehowa','pehowa',1),
(@sirsa,'Sirsa City','sirsa-city',1),(@sirsa,'Mandi Dabwali','mandi-dabwali',1),(@sirsa,'Ellenabad','ellenabad',1),
(@jind,'Jind City','jind-city',1),(@jind,'Narwana','narwana',1),(@jind,'Safidon','safidon',1),
(@kaithal,'Kaithal City','kaithal-city',1),(@kaithal,'Kalayat','kalayat',1),(@kaithal,'Pundri','pundri',1),
(@gurugram,'Gurugram City','gurugram-city',1),(@gurugram,'Manesar','manesar',1),(@gurugram,'Pataudi','pataudi',1),
(@rewari,'Rewari City','rewari-city',1),(@rewari,'Bawal','bawal',1),(@rewari,'Kosli','kosli',1),
(@palwal,'Palwal City','palwal-city',1),(@palwal,'Hodal','hodal',1),(@palwal,'Hathin','hathin',1);

-- ════════════════════════════════════════════════════════════════
--  PUNJAB – ALL 23 Districts
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Barnala','barnala','Punjab',1),('Bathinda','bathinda','Punjab',1),('Faridkot','faridkot','Punjab',1),
('Fatehgarh Sahib','fatehgarh-sahib','Punjab',1),('Fazilka','fazilka','Punjab',1),('Ferozepur','ferozepur','Punjab',1),
('Gurdaspur','gurdaspur','Punjab',1),('Hoshiarpur','hoshiarpur','Punjab',1),('Kapurthala','kapurthala','Punjab',1),
('Mansa','mansa','Punjab',1),('Moga','moga','Punjab',1),('Mohali','mohali','Punjab',1),
('Muktsar','muktsar','Punjab',1),('Nawanshahr','nawanshahr','Punjab',1),('Pathankot','pathankot','Punjab',1),
('Rupnagar','rupnagar','Punjab',1),('Sangrur','sangrur','Punjab',1),('Shahid Bhagat Singh Nagar','shahid-bhagat-singh-nagar','Punjab',1),
('Tarn Taran','tarn-taran','Punjab',1);

SET @bathinda=(SELECT id FROM districts WHERE slug='bathinda');SET @pathankot=(SELECT id FROM districts WHERE slug='pathankot');
SET @gurdaspur=(SELECT id FROM districts WHERE slug='gurdaspur');SET @hoshiarpur=(SELECT id FROM districts WHERE slug='hoshiarpur');
SET @mohali=(SELECT id FROM districts WHERE slug='mohali');SET @sangrur=(SELECT id FROM districts WHERE slug='sangrur');
SET @kapurthala=(SELECT id FROM districts WHERE slug='kapurthala');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@bathinda,'Bathinda City','bathinda-city',1),(@bathinda,'Rampura Phul','rampura-phul',1),(@bathinda,'Talwandi Sabo','talwandi-sabo',1),
(@pathankot,'Pathankot City','pathankot-city',1),(@pathankot,'Dhar Kalan','dhar-kalan',1),(@pathankot,'Sujanpur','sujanpur',1),
(@gurdaspur,'Gurdaspur City','gurdaspur-city',1),(@gurdaspur,'Batala','batala',1),(@gurdaspur,'Dhariwal','dhariwal',1),
(@hoshiarpur,'Hoshiarpur City','hoshiarpur-city',1),(@hoshiarpur,'Phagwara','phagwara',1),(@hoshiarpur,'Garhshankar','garhshankar',1),
(@mohali,'Mohali City','mohali-city',1),(@mohali,'Kharar','kharar',1),(@mohali,'Derabassi','derabassi',1),
(@sangrur,'Sangrur City','sangrur-city',1),(@sangrur,'Sunam','sunam',1),(@sangrur,'Barnala Mandal','barnala-mandal',1),
(@kapurthala,'Kapurthala City','kapurthala-city',1),(@kapurthala,'Phagwara Mandal','phagwara-mandal',1),(@kapurthala,'Sultanpur Lodhi','sultanpur-lodhi',1);

-- ════════════════════════════════════════════════════════════════
--  UTTARAKHAND – ALL 13 Districts
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Almora','almora','Uttarakhand',1),('Bageshwar','bageshwar','Uttarakhand',1),('Chamoli','chamoli','Uttarakhand',1),
('Champawat','champawat','Uttarakhand',1),('Haridwar','haridwar','Uttarakhand',1),('Nainital','nainital','Uttarakhand',1),
('Pauri Garhwal','pauri-garhwal','Uttarakhand',1),('Pithoragarh','pithoragarh','Uttarakhand',1),('Rudraprayag','rudraprayag','Uttarakhand',1),
('Tehri Garhwal','tehri-garhwal','Uttarakhand',1),('Udham Singh Nagar','udham-singh-nagar','Uttarakhand',1),
('Uttarkashi','uttarkashi','Uttarakhand',1);

SET @haridwar=(SELECT id FROM districts WHERE slug='haridwar');SET @nainital=(SELECT id FROM districts WHERE slug='nainital');
SET @usnagar=(SELECT id FROM districts WHERE slug='udham-singh-nagar');SET @tehrigarhwal=(SELECT id FROM districts WHERE slug='tehri-garhwal');
SET @almora=(SELECT id FROM districts WHERE slug='almora');SET @pithoragarh=(SELECT id FROM districts WHERE slug='pithoragarh');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@haridwar,'Haridwar City','haridwar-city',1),(@haridwar,'Roorkee','roorkee',1),(@haridwar,'Rishikesh','rishikesh',1),(@haridwar,'Laksar','laksar',1),
(@nainital,'Nainital City','nainital-city',1),(@nainital,'Haldwani','haldwani',1),(@nainital,'Ramnagar Uttarakhand','ramnagar-uttarakhand',1),(@nainital,'Bhimtal','bhimtal',1),
(@usnagar,'Rudrapur','rudrapur',1),(@usnagar,'Kashipur','kashipur',1),(@usnagar,'Kichha','kichha',1),(@usnagar,'Sitarganj','sitarganj',1),
(@tehrigarhwal,'Tehri','tehri',1),(@tehrigarhwal,'Uttarkashi Mandal','uttarkashi-mandal',1),(@tehrigarhwal,'Chamba','chamba-uttarakhand',1),
(@almora,'Almora City','almora-city',1),(@almora,'Bageshwar Mandal','bageshwar-mandal',1),(@almora,'Ranikhet','ranikhet',1),
(@pithoragarh,'Pithoragarh City','pithoragarh-city',1),(@pithoragarh,'Champawat Mandal','champawat-mandal',1),(@pithoragarh,'Didihat','didihat',1);

-- ════════════════════════════════════════════════════════════════
--  HIMACHAL PRADESH – ALL 12 Districts
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Bilaspur HP','bilaspur-hp','Himachal Pradesh',1),('Chamba','chamba-hp','Himachal Pradesh',1),
('Hamirpur HP','hamirpur-hp','Himachal Pradesh',1),('Kangra','kangra','Himachal Pradesh',1),
('Kinnaur','kinnaur','Himachal Pradesh',1),('Kullu','kullu','Himachal Pradesh',1),
('Lahaul Spiti','lahaul-spiti','Himachal Pradesh',1),('Mandi','mandi-hp','Himachal Pradesh',1),
('Sirmaur','sirmaur','Himachal Pradesh',1),('Solan','solan','Himachal Pradesh',1),
('Una HP','una-hp','Himachal Pradesh',1);

SET @kangra=(SELECT id FROM districts WHERE slug='kangra');SET @kullu=(SELECT id FROM districts WHERE slug='kullu');
SET @mandi_hp=(SELECT id FROM districts WHERE slug='mandi-hp');SET @solan=(SELECT id FROM districts WHERE slug='solan');
SET @una_hp=(SELECT id FROM districts WHERE slug='una-hp');SET @hamirpur_hp=(SELECT id FROM districts WHERE slug='hamirpur-hp');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@kangra,'Dharamsala','dharamsala',1),(@kangra,'Palampur','palampur',1),(@kangra,'Dehra Gopipur','dehra-gopipur',1),(@kangra,'Nurpur','nurpur',1),
(@kullu,'Kullu City','kullu-city',1),(@kullu,'Manali','manali',1),(@kullu,'Bhuntar','bhuntar',1),
(@mandi_hp,'Mandi City','mandi-city',1),(@mandi_hp,'Sundarnagar','sundarnagar',1),(@mandi_hp,'Jogindernagar','jogindernagar',1),
(@solan,'Solan City','solan-city',1),(@solan,'Baddi','baddi',1),(@solan,'Kasauli','kasauli',1),
(@una_hp,'Una City','una-city',1),(@una_hp,'Bangana','bangana',1),(@una_hp,'Amb','amb',1),
(@hamirpur_hp,'Hamirpur City HP','hamirpur-city-hp',1),(@hamirpur_hp,'Nadaun','nadaun',1),(@hamirpur_hp,'Sujanpur HP','sujanpur-hp',1);

-- ════════════════════════════════════════════════════════════════
--  JAMMU & KASHMIR – ALL 20 Districts
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Anantnag','anantnag','Jammu & Kashmir',1),('Bandipora','bandipora','Jammu & Kashmir',1),
('Baramulla','baramulla','Jammu & Kashmir',1),('Budgam','budgam','Jammu & Kashmir',1),
('Doda','doda','Jammu & Kashmir',1),('Ganderbal','ganderbal','Jammu & Kashmir',1),
('Kathua','kathua','Jammu & Kashmir',1),('Kishtwar','kishtwar','Jammu & Kashmir',1),
('Kulgam','kulgam','Jammu & Kashmir',1),('Kupwara','kupwara','Jammu & Kashmir',1),
('Poonch','poonch','Jammu & Kashmir',1),('Pulwama','pulwama','Jammu & Kashmir',1),
('Rajouri','rajouri','Jammu & Kashmir',1),('Ramban','ramban','Jammu & Kashmir',1),
('Reasi','reasi','Jammu & Kashmir',1),('Shopian','shopian','Jammu & Kashmir',1),
('Udhampur','udhampur','Jammu & Kashmir',1);

SET @baramulla=(SELECT id FROM districts WHERE slug='baramulla');SET @anantnag=(SELECT id FROM districts WHERE slug='anantnag');
SET @kathua=(SELECT id FROM districts WHERE slug='kathua');SET @udhampur=(SELECT id FROM districts WHERE slug='udhampur');
SET @pulwama=(SELECT id FROM districts WHERE slug='pulwama');SET @rajouri=(SELECT id FROM districts WHERE slug='rajouri');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@baramulla,'Baramulla City','baramulla-city',1),(@baramulla,'Sopore','sopore',1),(@baramulla,'Pattan','pattan',1),(@baramulla,'Handwara','handwara',1),
(@anantnag,'Anantnag City','anantnag-city',1),(@anantnag,'Pahalgam','pahalgam',1),(@anantnag,'Bijbehara','bijbehara',1),(@anantnag,'Kokernag','kokernag',1),
(@kathua,'Kathua City','kathua-city',1),(@kathua,'Basohli','basohli',1),(@kathua,'Bani','bani',1),
(@udhampur,'Udhampur City','udhampur-city',1),(@udhampur,'Ramnagar JK','ramnagar-jk',1),(@udhampur,'Chenani','chenani',1),
(@pulwama,'Pulwama City','pulwama-city',1),(@pulwama,'Shopian Mandal','shopian-mandal',1),(@pulwama,'Tral','tral',1),
(@rajouri,'Rajouri City','rajouri-city',1),(@rajouri,'Nowshera','nowshera',1),(@rajouri,'Kalakote','kalakote',1);

-- ════════════════════════════════════════════════════════════════
--  LADAKH – 2 Districts
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('Leh','leh','Ladakh',1),('Kargil','kargil','Ladakh',1);

SET @leh=(SELECT id FROM districts WHERE slug='leh');SET @kargil=(SELECT id FROM districts WHERE slug='kargil');
INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@leh,'Leh City','leh-city',1),(@leh,'Nubra','nubra',1),(@leh,'Zanskar','zanskar',1),
(@kargil,'Kargil City','kargil-city',1),(@kargil,'Drass','drass',1),(@kargil,'Sankoo','sankoo',1);

-- ════════════════════════════════════════════════════════════════
--  GOA – 2 Districts
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
('North Goa','north-goa','Goa',1),('South Goa','south-goa','Goa',1);

SET @northgoa=(SELECT id FROM districts WHERE slug='north-goa');SET @southgoa=(SELECT id FROM districts WHERE slug='south-goa');
INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@northgoa,'Panaji','panaji',1),(@northgoa,'Mapusa','mapusa',1),(@northgoa,'Calangute','calangute',1),(@northgoa,'Vasco da Gama','vasco-da-gama',1),(@northgoa,'Candolim','candolim',1),(@northgoa,'Porvorim','porvorim',1),
(@southgoa,'Margao','margao',1),(@southgoa,'Ponda','ponda',1),(@southgoa,'Verna','verna',1),(@southgoa,'Colva','colva',1);

-- ════════════════════════════════════════════════════════════════
--  NORTHEAST STATES
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
-- Meghalaya
('East Khasi Hills','east-khasi-hills','Meghalaya',1),('West Khasi Hills','west-khasi-hills','Meghalaya',1),
('Ri Bhoi','ri-bhoi','Meghalaya',1),('East Jaintia Hills','east-jaintia-hills','Meghalaya',1),
('West Jaintia Hills','west-jaintia-hills','Meghalaya',1),('East Garo Hills','east-garo-hills','Meghalaya',1),
('West Garo Hills','west-garo-hills','Meghalaya',1),('South Garo Hills','south-garo-hills','Meghalaya',1),
('North Garo Hills','north-garo-hills','Meghalaya',1),('South West Khasi Hills','south-west-khasi-hills','Meghalaya',1),
('Eastern West Khasi Hills','eastern-west-khasi-hills','Meghalaya',1),('Mahendraganj','mahendraganj-meg','Meghalaya',1),
-- Manipur
('Bishnupur','bishnupur-manipur','Manipur',1),('Chandel','chandel','Manipur',1),('Churachandpur','churachandpur','Manipur',1),
('Imphal East','imphal-east','Manipur',1),('Imphal West','imphal-west','Manipur',1),('Jiribam','jiribam','Manipur',1),
('Kakching','kakching','Manipur',1),('Kamjong','kamjong','Manipur',1),('Kangpokpi','kangpokpi','Manipur',1),
('Noney','noney','Manipur',1),('Pherzawl','pherzawl','Manipur',1),('Senapati','senapati','Manipur',1),
('Tamenglong','tamenglong','Manipur',1),('Tengnoupal','tengnoupal','Manipur',1),('Thoubal','thoubal','Manipur',1),('Ukhrul','ukhrul','Manipur',1),
-- Mizoram
('Aizawl','aizawl','Mizoram',1),('Champhai','champhai','Mizoram',1),('Hnahthial','hnahthial','Mizoram',1),
('Khawzawl','khawzawl','Mizoram',1),('Kolasib','kolasib','Mizoram',1),('Lawngtlai','lawngtlai','Mizoram',1),
('Lunglei','lunglei','Mizoram',1),('Mamit','mamit','Mizoram',1),('Saiha','saiha','Mizoram',1),
('Serchhip','serchhip','Mizoram',1),('Saitual','saitual','Mizoram',1),
-- Nagaland
('Dimapur','dimapur','Nagaland',1),('Kiphire','kiphire','Nagaland',1),('Kohima','kohima','Nagaland',1),
('Longleng','longleng','Nagaland',1),('Mokokchung','mokokchung','Nagaland',1),('Mon','mon-nagaland','Nagaland',1),
('Noklak','noklak','Nagaland',1),('Peren','peren','Nagaland',1),('Phek','phek','Nagaland',1),
('Tuensang','tuensang','Nagaland',1),('Wokha','wokha','Nagaland',1),('Zunheboto','zunheboto','Nagaland',1),
-- Tripura
('Dhalai','dhalai','Tripura',1),('Gomati','gomati','Tripura',1),('Khowai','khowai','Tripura',1),
('North Tripura','north-tripura','Tripura',1),('Sepahijala','sepahijala','Tripura',1),
('South Tripura','south-tripura','Tripura',1),('Unakoti','unakoti','Tripura',1),('West Tripura','west-tripura','Tripura',1),
-- Sikkim
('East Sikkim','east-sikkim','Sikkim',1),('North Sikkim','north-sikkim','Sikkim',1),
('South Sikkim','south-sikkim','Sikkim',1),('West Sikkim','west-sikkim','Sikkim',1),
('Gyalshing','gyalshing','Sikkim',1),('Pakyong','pakyong','Sikkim',1),
-- Arunachal Pradesh
('Anjaw','anjaw','Arunachal Pradesh',1),('Changlang','changlang','Arunachal Pradesh',1),
('Dibang Valley','dibang-valley','Arunachal Pradesh',1),('East Kameng','east-kameng','Arunachal Pradesh',1),
('East Siang','east-siang','Arunachal Pradesh',1),('Itanagar Capital','itanagar-capital','Arunachal Pradesh',1),
('Kamle','kamle','Arunachal Pradesh',1),('Kra Daadi','kra-daadi','Arunachal Pradesh',1),
('Kurung Kumey','kurung-kumey','Arunachal Pradesh',1),('Lepa Rada','lepa-rada','Arunachal Pradesh',1),
('Lohit','lohit','Arunachal Pradesh',1),('Longding','longding','Arunachal Pradesh',1),
('Lower Dibang Valley','lower-dibang-valley','Arunachal Pradesh',1),('Lower Siang','lower-siang','Arunachal Pradesh',1),
('Lower Subansiri','lower-subansiri','Arunachal Pradesh',1),('Namsai','namsai','Arunachal Pradesh',1),
('Pakke Kessang','pakke-kessang','Arunachal Pradesh',1),('Papum Pare','papum-pare','Arunachal Pradesh',1),
('Shi Yomi','shi-yomi','Arunachal Pradesh',1),('Siang','siang','Arunachal Pradesh',1),
('Tawang','tawang','Arunachal Pradesh',1),('Tirap','tirap','Arunachal Pradesh',1),
('Upper Dibang Valley','upper-dibang-valley','Arunachal Pradesh',1),('Upper Siang','upper-siang','Arunachal Pradesh',1),
('Upper Subansiri','upper-subansiri','Arunachal Pradesh',1),('West Kameng','west-kameng','Arunachal Pradesh',1),
('West Siang','west-siang','Arunachal Pradesh',1);

-- Add key areas for NE state capitals
SET @imphaleast=(SELECT id FROM districts WHERE slug='imphal-east');
SET @imphalwest=(SELECT id FROM districts WHERE slug='imphal-west');
SET @eastkhasi=(SELECT id FROM districts WHERE slug='east-khasi-hills');
SET @aizawl=(SELECT id FROM districts WHERE slug='aizawl');
SET @kohima=(SELECT id FROM districts WHERE slug='kohima');
SET @dimapur=(SELECT id FROM districts WHERE slug='dimapur');
SET @westtripura=(SELECT id FROM districts WHERE slug='west-tripura');
SET @eastsikkim=(SELECT id FROM districts WHERE slug='east-sikkim');
SET @papumpare=(SELECT id FROM districts WHERE slug='papum-pare');
SET @tawang=(SELECT id FROM districts WHERE slug='tawang');
SET @changlang=(SELECT id FROM districts WHERE slug='changlang');
SET @eastsiang=(SELECT id FROM districts WHERE slug='east-siang');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@imphaleast,'Imphal City','imphal-city',1),(@imphaleast,'Porompat','porompat',1),(@imphaleast,'Kakching Mandal','kakching-mandal',1),
(@imphalwest,'Imphal West City','imphal-west-city',1),(@imphalwest,'Lamphel','lamphel',1),(@imphalwest,'Thangmeiband','thangmeiband',1),
(@eastkhasi,'Shillong','shillong',1),(@eastkhasi,'Mawlai','mawlai',1),(@eastkhasi,'Cherrapunji','cherrapunji',1),(@eastkhasi,'Nongstoin','nongstoin',1),
(@aizawl,'Aizawl City','aizawl-city',1),(@aizawl,'Lunglei Mandal','lunglei-mandal',1),(@aizawl,'Champhai Mandal','champhai-mandal',1),
(@kohima,'Kohima City','kohima-city',1),(@kohima,'Pfutsero','pfutsero',1),(@kohima,'Phek Mandal','phek-mandal',1),
(@dimapur,'Dimapur City','dimapur-city',1),(@dimapur,'Chumukedima','chumukedima',1),(@dimapur,'Medziphema','medziphema',1),
(@westtripura,'Agartala','agartala',1),(@westtripura,'Mohanpur','mohanpur',1),(@westtripura,'Bishalgarh','bishalgarh',1),
(@eastsikkim,'Gangtok','gangtok',1),(@eastsikkim,'Rangpo','rangpo',1),(@eastsikkim,'Singtam','singtam',1),
(@papumpare,'Itanagar','itanagar',1),(@papumpare,'Naharlagun','naharlagun',1),(@papumpare,'Nirjuli','nirjuli',1),
(@tawang,'Tawang City','tawang-city',1),(@tawang,'Zemithang','zemithang',1),
(@changlang,'Changlang City','changlang-city',1),(@changlang,'Margherita AP','margherita-ap',1),
(@eastsiang,'Pasighat','pasighat',1),(@eastsiang,'Mebo','mebo',1);

-- ════════════════════════════════════════════════════════════════
--  UNION TERRITORIES
-- ════════════════════════════════════════════════════════════════
INSERT IGNORE INTO districts (name,slug,state,is_active) VALUES
-- Andaman & Nicobar
('South Andaman','south-andaman','Andaman & Nicobar',1),('North Middle Andaman','north-middle-andaman','Andaman & Nicobar',1),
('Nicobar','nicobar','Andaman & Nicobar',1),
-- Lakshadweep
('Lakshadweep Islands','lakshadweep-islands','Lakshadweep',1),
-- Dadra & Nagar Haveli and Daman & Diu
('Dadra Nagar Haveli','dadra-nagar-haveli','Dadra & NH and DD',1),('Daman','daman','Dadra & NH and DD',1),('Diu','diu','Dadra & NH and DD',1);

SET @southandaman=(SELECT id FROM districts WHERE slug='south-andaman');
SET @dadra=(SELECT id FROM districts WHERE slug='dadra-nagar-haveli');
SET @daman=(SELECT id FROM districts WHERE slug='daman');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@southandaman,'Port Blair','port-blair',1),(@southandaman,'Bambooflat','bambooflat',1),(@southandaman,'Dollygunj','dollygunj',1),
(@dadra,'Silvassa','silvassa',1),(@dadra,'Naroli','naroli',1),(@dadra,'Amli','amli',1),
(@daman,'Daman City','daman-city',1),(@daman,'Nani Daman','nani-daman',1);

-- ════════════════════════════════════════════════════════════════
--  ADDITIONAL DELHI NCR AND KEY METRO AREAS
-- ════════════════════════════════════════════════════════════════
-- Add more Bengaluru areas for depth
SET @bengaluru2=(SELECT id FROM districts WHERE slug='bengaluru');
INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@bengaluru2,'Whitefield Extension','whitefield-extension',1),(@bengaluru2,'Brookefield','brookefield',1),(@bengaluru2,'Kadugodi','kadugodi',1),
(@bengaluru2,'Bommasandra','bommasandra',1),(@bengaluru2,'Chandapura','chandapura',1),(@bengaluru2,'Attibele','attibele',1),
(@bengaluru2,'Hoskote','hoskote',1),(@bengaluru2,'Hoodi','hoodi',1),(@bengaluru2,'Krishnarajapuram','krishnarajapuram',1),
(@bengaluru2,'Jalahalli','jalahalli',1),(@bengaluru2,'Mathikere','mathikere',1),(@bengaluru2,'Dasarahalli','dasarahalli',1);

-- ════════════════════════════════════════════════════════════════
--  FINAL STATS
-- ════════════════════════════════════════════════════════════════
SELECT 'COMPLETE INDIA COVERAGE' as status;
SELECT COUNT(*) as total_districts FROM districts WHERE is_active=1;
SELECT COUNT(*) as total_areas FROM areas WHERE is_active=1;
SELECT COUNT(*)*19 as estimated_service_pages FROM areas WHERE is_active=1;
SELECT state, COUNT(DISTINCT d.id) as districts, COUNT(a.id) as areas
FROM districts d LEFT JOIN areas a ON a.district_id=d.id AND a.is_active=1
WHERE d.is_active=1
GROUP BY d.state ORDER BY areas DESC LIMIT 30;
