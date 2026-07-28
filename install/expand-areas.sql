-- ═══════════════════════════════════════════════════════════════════
--  NetsDial – PAN India Areas Expansion (MariaDB compatible)
-- ═══════════════════════════════════════════════════════════════════

-- ── ANDHRA PRADESH ADDITIONAL ────────────────────────────────────────
SET @kurnool    = (SELECT id FROM districts WHERE slug='kurnool');
SET @nellore    = (SELECT id FROM districts WHERE slug='nellore');
SET @kadapa     = (SELECT id FROM districts WHERE slug='kadapa');
SET @anantapur  = (SELECT id FROM districts WHERE slug='anantapur');
SET @chittoor   = (SELECT id FROM districts WHERE slug='chittoor');
SET @eluru      = (SELECT id FROM districts WHERE slug='eluru');
SET @kakinada   = (SELECT id FROM districts WHERE slug='kakinada');
SET @ongole     = (SELECT id FROM districts WHERE slug='ongole');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@kurnool,'Kurnool City','kurnool-city',1),(@kurnool,'Nandyal','nandyal',1),(@kurnool,'Adoni','adoni',1),(@kurnool,'Dhone','dhone',1),(@kurnool,'Yemmiganur','yemmiganur',1),
(@nellore,'Nellore City','nellore-city',1),(@nellore,'Kavali','kavali',1),(@nellore,'Gudur','gudur',1),(@nellore,'Sullurpeta','sullurpeta',1),(@nellore,'Atmakur','atmakur',1),
(@kadapa,'Kadapa City','kadapa-city',1),(@kadapa,'Proddatur','proddatur',1),(@kadapa,'Rajampet','rajampet',1),(@kadapa,'Pulivendla','pulivendla',1),
(@anantapur,'Anantapur City','anantapur-city',1),(@anantapur,'Guntakal','guntakal',1),(@anantapur,'Hindupur','hindupur',1),(@anantapur,'Tadipatri','tadipatri',1),
(@chittoor,'Chittoor City','chittoor-city',1),(@chittoor,'Madanapalle','madanapalle',1),(@chittoor,'Srikalahasti','srikalahasti',1),
(@eluru,'Eluru City','eluru-city',1),(@eluru,'Bhimavaram','bhimavaram',1),(@eluru,'Tadepalligudem','tadepalligudem',1),
(@kakinada,'Kakinada City','kakinada-city',1),(@kakinada,'Pithapuram','pithapuram',1),(@kakinada,'Amalapuram','amalapuram',1),
(@ongole,'Ongole City','ongole-city',1),(@ongole,'Chirala','chirala',1),(@ongole,'Kandukur','kandukur',1);

-- ── KARNATAKA ────────────────────────────────────────────────────────
SET @bengaluru  = (SELECT id FROM districts WHERE slug='bengaluru');
SET @mysuru     = (SELECT id FROM districts WHERE slug='mysuru');
SET @hubli      = (SELECT id FROM districts WHERE slug='hubli-dharwad');
SET @mangaluru  = (SELECT id FROM districts WHERE slug='mangaluru');
SET @belagavi   = (SELECT id FROM districts WHERE slug='belagavi');
SET @kalaburagi = (SELECT id FROM districts WHERE slug='kalaburagi');
SET @tumakuru   = (SELECT id FROM districts WHERE slug='tumakuru');
SET @shivamogga = (SELECT id FROM districts WHERE slug='shivamogga');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@bengaluru,'Whitefield','whitefield',1),(@bengaluru,'Koramangala','koramangala',1),(@bengaluru,'Indiranagar','indiranagar',1),
(@bengaluru,'Jayanagar','jayanagar',1),(@bengaluru,'JP Nagar','jp-nagar',1),(@bengaluru,'Marathahalli','marathahalli',1),
(@bengaluru,'Electronic City','electronic-city',1),(@bengaluru,'HSR Layout','hsr-layout',1),(@bengaluru,'BTM Layout','btm-layout',1),
(@bengaluru,'Bannerghatta Road','bannerghatta-road',1),(@bengaluru,'Sarjapur Road','sarjapur-road',1),(@bengaluru,'Yelahanka','yelahanka',1),
(@bengaluru,'Rajajinagar','rajajinagar',1),(@bengaluru,'Malleswaram','malleswaram',1),(@bengaluru,'Hebbal','hebbal',1),
(@bengaluru,'Hennur','hennur',1),(@bengaluru,'KR Puram','kr-puram',1),(@bengaluru,'Bommanahalli','bommanahalli',1),
(@bengaluru,'Bellandur','bellandur',1),(@bengaluru,'Kengeri','kengeri',1),(@bengaluru,'Vijayanagar Bangalore','vijayanagar-bangalore',1),
(@bengaluru,'Basavanagudi','basavanagudi',1),(@bengaluru,'Wilson Garden','wilson-garden',1),(@bengaluru,'Frazer Town','frazer-town',1),
(@bengaluru,'RT Nagar','rt-nagar',1),(@bengaluru,'Sahakara Nagar','sahakara-nagar',1),(@bengaluru,'Banaswadi','banaswadi',1),
(@bengaluru,'CV Raman Nagar','cv-raman-nagar',1),(@bengaluru,'Devanahalli','devanahalli',1),(@bengaluru,'Nelamangala','nelamangala',1),
(@bengaluru,'Peenya','peenya',1),(@bengaluru,'Yeshwanthpur','yeshwanthpur',1),(@bengaluru,'Nagarbhavi','nagarbhavi',1),
(@bengaluru,'Banashankari','banashankari',1),(@bengaluru,'Uttarahalli','uttarahalli',1),
(@mysuru,'Mysuru City','mysuru-city',1),(@mysuru,'Vijayanagar Mysuru','vijayanagar-mysuru',1),(@mysuru,'Kuvempunagar','kuvempunagar',1),
(@mysuru,'Hebbal Mysuru','hebbal-mysuru',1),(@mysuru,'Nazarbad','nazarbad',1),(@mysuru,'Gokulam','gokulam',1),
(@mysuru,'Saraswathipuram','saraswathipuram',1),(@mysuru,'Bogadi','bogadi',1),(@mysuru,'Rajiv Nagar Mysuru','rajiv-nagar-mysuru',1),(@mysuru,'Chamundipuram','chamundipuram',1),
(@hubli,'Hubli','hubli',1),(@hubli,'Dharwad','dharwad',1),(@hubli,'Gokul Road','gokul-road',1),(@hubli,'Vidyanagar Karnataka','vidyanagar-karnataka',1),
(@mangaluru,'Mangaluru City','mangaluru-city',1),(@mangaluru,'Kadri','kadri',1),(@mangaluru,'Hampankatta','hampankatta',1),(@mangaluru,'Bejai','bejai',1),(@mangaluru,'Deralakatte','deralakatte',1),
(@belagavi,'Belagavi City','belagavi-city',1),(@belagavi,'Tilakwadi','tilakwadi',1),(@belagavi,'Nehru Nagar Belagavi','nehru-nagar-belagavi',1),
(@kalaburagi,'Kalaburagi City','kalaburagi-city',1),(@kalaburagi,'Aland Road','aland-road',1),
(@tumakuru,'Tumakuru City','tumakuru-city',1),(@tumakuru,'SS Puram','ss-puram',1),
(@shivamogga,'Shivamogga City','shivamogga-city',1),(@shivamogga,'Bhadravathi','bhadravathi',1);

-- ── TAMIL NADU ───────────────────────────────────────────────────────
SET @chennai    = (SELECT id FROM districts WHERE slug='chennai');
SET @coimbatore = (SELECT id FROM districts WHERE slug='coimbatore');
SET @madurai    = (SELECT id FROM districts WHERE slug='madurai');
SET @trichy     = (SELECT id FROM districts WHERE slug='tiruchirappalli');
SET @salem      = (SELECT id FROM districts WHERE slug='salem');
SET @tirunelveli= (SELECT id FROM districts WHERE slug='tirunelveli');
SET @erode      = (SELECT id FROM districts WHERE slug='erode');
SET @vellore    = (SELECT id FROM districts WHERE slug='vellore');
SET @thoothukudi= (SELECT id FROM districts WHERE slug='thoothukudi');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@chennai,'Anna Nagar','anna-nagar',1),(@chennai,'Adyar','adyar',1),(@chennai,'Velachery','velachery',1),
(@chennai,'OMR','omr',1),(@chennai,'Porur','porur',1),(@chennai,'Tambaram','tambaram',1),
(@chennai,'Perambur','perambur',1),(@chennai,'Guindy','guindy',1),(@chennai,'T Nagar','t-nagar',1),
(@chennai,'Mylapore','mylapore',1),(@chennai,'Nungambakkam','nungambakkam',1),(@chennai,'Egmore','egmore',1),
(@chennai,'Poonamallee','poonamallee',1),(@chennai,'Ambattur','ambattur',1),(@chennai,'Avadi','avadi',1),
(@chennai,'Chromepet','chromepet',1),(@chennai,'Pallavaram','pallavaram',1),(@chennai,'Sholinganallur','sholinganallur',1),
(@chennai,'Perungudi','perungudi',1),(@chennai,'Thoraipakkam','thoraipakkam',1),(@chennai,'Pallikaranai','pallikaranai',1),
(@chennai,'Medavakkam','medavakkam',1),(@chennai,'Nanganallur','nanganallur',1),(@chennai,'Alandur','alandur',1),
(@chennai,'Saidapet','saidapet',1),(@chennai,'Kodambakkam','kodambakkam',1),(@chennai,'Vadapalani','vadapalani',1),
(@chennai,'Koyambedu','koyambedu',1),(@chennai,'Nerkundram','nerkundram',1),(@chennai,'Maduravoyal','maduravoyal',1),
(@coimbatore,'RS Puram','rs-puram',1),(@coimbatore,'Gandhipuram','gandhipuram',1),(@coimbatore,'Peelamedu','peelamedu',1),
(@coimbatore,'Saibaba Colony','saibaba-colony',1),(@coimbatore,'Singanallur','singanallur',1),
(@coimbatore,'Uppilipalayam','uppilipalayam',1),(@coimbatore,'Hopes College','hopes-college',1),(@coimbatore,'Podanur','podanur',1),
(@coimbatore,'Ganapathy','ganapathy',1),(@coimbatore,'Ondipudur','ondipudur',1),
(@madurai,'Mattuthavani','mattuthavani',1),(@madurai,'Bypass Road Madurai','bypass-road-madurai',1),(@madurai,'Anna Nagar Madurai','anna-nagar-madurai',1),
(@madurai,'Thirunagar','thirunagar',1),(@madurai,'Tallakulam','tallakulam',1),(@madurai,'Alagar Kovil Road','alagar-kovil-road',1),
(@madurai,'Kochadai','kochadai',1),(@madurai,'Vilangudi','vilangudi',1),
(@trichy,'Srirangam','srirangam',1),(@trichy,'Thillai Nagar','thillai-nagar',1),(@trichy,'Ariyamangalam','ariyamangalam',1),(@trichy,'KK Nagar Trichy','kk-nagar-trichy',1),(@trichy,'Thiruvanaikaval','thiruvanaikaval',1),
(@salem,'Fairlands','fairlands',1),(@salem,'Hasthampatti','hasthampatti',1),(@salem,'Omalur Road','omalur-road',1),
(@tirunelveli,'Tirunelveli City','tirunelveli-city',1),(@tirunelveli,'Palayamkottai','palayamkottai',1),(@tirunelveli,'Nanguneri','nanguneri',1),
(@erode,'Erode City','erode-city',1),(@erode,'Perundurai','perundurai',1),(@erode,'Bhavani','bhavani',1),
(@vellore,'Vellore City','vellore-city',1),(@vellore,'Sathuvachari','sathuvachari',1),(@vellore,'Katpadi','katpadi',1),
(@thoothukudi,'Thoothukudi City','thoothukudi-city',1),(@thoothukudi,'Tirunelveli Road','tirunelveli-road-thoothukudi',1);

-- ── KERALA ───────────────────────────────────────────────────────────
SET @kochi      = (SELECT id FROM districts WHERE slug='kochi');
SET @tvm        = (SELECT id FROM districts WHERE slug='thiruvananthapuram');
SET @kozhikode  = (SELECT id FROM districts WHERE slug='kozhikode');
SET @thrissur   = (SELECT id FROM districts WHERE slug='thrissur');
SET @kollam     = (SELECT id FROM districts WHERE slug='kollam');
SET @malappuram = (SELECT id FROM districts WHERE slug='malappuram');
SET @kannur     = (SELECT id FROM districts WHERE slug='kannur');
SET @palakkad   = (SELECT id FROM districts WHERE slug='palakkad');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@kochi,'Kakkanad','kakkanad',1),(@kochi,'Edappally','edappally',1),(@kochi,'Aluva','aluva',1),(@kochi,'Tripunithura','tripunithura',1),
(@kochi,'Vyttila','vyttila',1),(@kochi,'Palarivattom','palarivattom',1),(@kochi,'Kaloor','kaloor',1),(@kochi,'Fort Kochi','fort-kochi',1),
(@kochi,'Maradu','maradu',1),(@kochi,'Thevara','thevara',1),
(@tvm,'Kowdiar','kowdiar',1),(@tvm,'Pattom','pattom',1),(@tvm,'Kazhakkoottam','kazhakkoottam',1),(@tvm,'Technopark','technopark',1),
(@tvm,'Vanchiyoor','vanchiyoor',1),(@tvm,'Kesavadasapuram','kesavadasapuram',1),(@tvm,'Sreekaryam','sreekaryam',1),(@tvm,'Nalanchira','nalanchira',1),
(@kozhikode,'Calicut City','calicut-city',1),(@kozhikode,'Mavoor Road','mavoor-road',1),(@kozhikode,'Nadakkavu','nadakkavu',1),(@kozhikode,'Westhill','westhill',1),(@kozhikode,'Palayam Kozhikode','palayam-kozhikode',1),
(@thrissur,'Thrissur City','thrissur-city',1),(@thrissur,'Poothole','poothole',1),(@thrissur,'Ayyanthole','ayyanthole',1),(@thrissur,'Viyyur','viyyur',1),
(@kollam,'Kollam City','kollam-city',1),(@kollam,'Kadappakada','kadappakada',1),(@kollam,'Kottiyam','kottiyam',1),
(@malappuram,'Malappuram City','malappuram-city',1),(@malappuram,'Manjeri','manjeri',1),(@malappuram,'Tirur','tirur',1),
(@kannur,'Kannur City','kannur-city',1),(@kannur,'Thaliparamba','thaliparamba',1),
(@palakkad,'Palakkad City','palakkad-city',1),(@palakkad,'Shoranur','shoranur',1),(@palakkad,'Mannarkkad','mannarkkad',1);

-- ── MAHARASHTRA ──────────────────────────────────────────────────────
SET @mumbai     = (SELECT id FROM districts WHERE slug='mumbai');
SET @pune       = (SELECT id FROM districts WHERE slug='pune');
SET @nagpur     = (SELECT id FROM districts WHERE slug='nagpur');
SET @nashik     = (SELECT id FROM districts WHERE slug='nashik');
SET @aurangabad = (SELECT id FROM districts WHERE slug='aurangabad');
SET @solapur    = (SELECT id FROM districts WHERE slug='solapur');
SET @thane      = (SELECT id FROM districts WHERE slug='thane');
SET @kolhapur   = (SELECT id FROM districts WHERE slug='kolhapur');
SET @navimumbai = (SELECT id FROM districts WHERE slug='navi-mumbai');
SET @vasai      = (SELECT id FROM districts WHERE slug='vasai-virar');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@mumbai,'Andheri','andheri',1),(@mumbai,'Bandra','bandra',1),(@mumbai,'Borivali','borivali',1),(@mumbai,'Malad','malad',1),
(@mumbai,'Goregaon','goregaon',1),(@mumbai,'Kandivali','kandivali',1),(@mumbai,'Dahisar','dahisar',1),(@mumbai,'Powai','powai',1),
(@mumbai,'Chembur','chembur',1),(@mumbai,'Kurla','kurla',1),(@mumbai,'Ghatkopar','ghatkopar',1),(@mumbai,'Vikhroli','vikhroli',1),
(@mumbai,'Mulund','mulund',1),(@mumbai,'Bhandup','bhandup',1),(@mumbai,'Kanjurmarg','kanjurmarg',1),(@mumbai,'Wadala','wadala',1),
(@mumbai,'Worli','worli',1),(@mumbai,'Dadar','dadar',1),(@mumbai,'Lower Parel','lower-parel',1),(@mumbai,'Mahalaxmi','mahalaxmi',1),
(@mumbai,'Dharavi','dharavi',1),(@mumbai,'Sion','sion',1),(@mumbai,'Matunga','matunga',1),(@mumbai,'Parel','parel',1),(@mumbai,'Colaba','colaba',1),
(@pune,'Hinjewadi','hinjewadi',1),(@pune,'Wakad','wakad',1),(@pune,'Baner','baner',1),(@pune,'Aundh','aundh',1),
(@pune,'Kothrud','kothrud',1),(@pune,'Deccan','deccan',1),(@pune,'Shivajinagar Pune','shivajinagar-pune',1),(@pune,'Camp Pune','camp-pune',1),
(@pune,'Koregaon Park','koregaon-park',1),(@pune,'Kalyani Nagar','kalyani-nagar',1),(@pune,'Viman Nagar','viman-nagar',1),(@pune,'Kharadi','kharadi',1),
(@pune,'Hadapsar','hadapsar',1),(@pune,'Kondhwa','kondhwa',1),(@pune,'Undri','undri',1),(@pune,'Katraj','katraj',1),
(@pune,'Bavdhan','bavdhan',1),(@pune,'Pimple Saudagar','pimple-saudagar',1),(@pune,'Sangvi','sangvi',1),(@pune,'Wakad Pune','wakad-pune',1),
(@nagpur,'Civil Lines Nagpur','civil-lines-nagpur',1),(@nagpur,'Dharampeth','dharampeth',1),(@nagpur,'Sitabuldi','sitabuldi',1),(@nagpur,'Sadar','sadar',1),
(@nagpur,'Ramdaspeth','ramdaspeth',1),(@nagpur,'Wardha Road','wardha-road',1),(@nagpur,'Amravati Road','amravati-road',1),(@nagpur,'Kamptee Road','kamptee-road',1),
(@nashik,'Nashik Road','nashik-road',1),(@nashik,'Cidco Nashik','cidco-nashik',1),(@nashik,'Gangapur Road','gangapur-road',1),(@nashik,'Ambad','ambad',1),(@nashik,'Panchavati','panchavati',1),
(@aurangabad,'Aurangabad City','aurangabad-city',1),(@aurangabad,'Cidco Aurangabad','cidco-aurangabad',1),(@aurangabad,'Garkheda','garkheda',1),(@aurangabad,'Waluj','waluj',1),
(@solapur,'Solapur City','solapur-city',1),(@solapur,'Hotgi Road','hotgi-road',1),(@solapur,'Vijapur Road','vijapur-road',1),
(@thane,'Thane West','thane-west',1),(@thane,'Thane East','thane-east',1),(@thane,'Kalwa','kalwa',1),(@thane,'Mumbra','mumbra',1),(@thane,'Dombivli','dombivli',1),
(@kolhapur,'Kolhapur City','kolhapur-city',1),(@kolhapur,'Shahu Nagar','shahu-nagar',1),(@kolhapur,'Rajarampuri','rajarampuri',1),
(@navimumbai,'Vashi','vashi',1),(@navimumbai,'Kharghar','kharghar',1),(@navimumbai,'Belapur','belapur',1),(@navimumbai,'Nerul','nerul',1),(@navimumbai,'Airoli','airoli',1),
(@vasai,'Vasai','vasai',1),(@vasai,'Virar','virar',1),(@vasai,'Nalasopara','nalasopara',1);

-- ── DELHI NCR ────────────────────────────────────────────────────────
SET @delhi       = (SELECT id FROM districts WHERE slug='delhi');
SET @noida       = (SELECT id FROM districts WHERE slug='noida');
SET @gurgaon     = (SELECT id FROM districts WHERE slug='gurgaon');
SET @faridabad   = (SELECT id FROM districts WHERE slug='faridabad');
SET @ghaziabad   = (SELECT id FROM districts WHERE slug='ghaziabad');
SET @greaternoida= (SELECT id FROM districts WHERE slug='greater-noida');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@delhi,'Dwarka','dwarka',1),(@delhi,'Janakpuri','janakpuri',1),(@delhi,'Rohini','rohini',1),(@delhi,'Pitampura','pitampura',1),
(@delhi,'Paschim Vihar','paschim-vihar',1),(@delhi,'Rajouri Garden','rajouri-garden',1),(@delhi,'Patel Nagar','patel-nagar',1),(@delhi,'Karol Bagh','karol-bagh',1),
(@delhi,'Lajpat Nagar','lajpat-nagar',1),(@delhi,'Greater Kailash','greater-kailash',1),(@delhi,'Hauz Khas','hauz-khas',1),(@delhi,'Vasant Kunj','vasant-kunj',1),
(@delhi,'Saket','saket',1),(@delhi,'Malviya Nagar Delhi','malviya-nagar-delhi',1),(@delhi,'Kalkaji','kalkaji',1),(@delhi,'Nehru Place','nehru-place',1),
(@delhi,'Laxmi Nagar','laxmi-nagar',1),(@delhi,'Mayur Vihar','mayur-vihar',1),(@delhi,'Preet Vihar','preet-vihar',1),(@delhi,'Dilshad Garden','dilshad-garden',1),
(@noida,'Sector 18 Noida','sector-18-noida',1),(@noida,'Sector 62 Noida','sector-62-noida',1),(@noida,'Sector 76 Noida','sector-76-noida',1),(@noida,'Sector 137 Noida','sector-137-noida',1),(@noida,'Sector 150 Noida','sector-150-noida',1),
(@gurgaon,'DLF Phase 1','dlf-phase-1',1),(@gurgaon,'Sushant Lok','sushant-lok',1),(@gurgaon,'Sector 56 Gurgaon','sector-56-gurgaon',1),(@gurgaon,'Golf Course Road','golf-course-road',1),(@gurgaon,'MG Road Gurgaon','mg-road-gurgaon',1),
(@faridabad,'Sector 14 Faridabad','sector-14-faridabad',1),(@faridabad,'NIT Faridabad','nit-faridabad',1),(@faridabad,'Ballabgarh','ballabgarh',1),
(@ghaziabad,'Vaishali','vaishali',1),(@ghaziabad,'Indirapuram','indirapuram',1),(@ghaziabad,'Raj Nagar','raj-nagar',1),
(@greaternoida,'Greater Noida West','greater-noida-west',1),(@greaternoida,'Phi 2','phi-2',1),(@greaternoida,'Gamma 2','gamma-2',1);

-- ── UTTAR PRADESH ────────────────────────────────────────────────────
SET @lucknow    = (SELECT id FROM districts WHERE slug='lucknow');
SET @kanpur     = (SELECT id FROM districts WHERE slug='kanpur');
SET @agra       = (SELECT id FROM districts WHERE slug='agra');
SET @varanasi   = (SELECT id FROM districts WHERE slug='varanasi');
SET @allahabad  = (SELECT id FROM districts WHERE slug='allahabad');
SET @meerut     = (SELECT id FROM districts WHERE slug='meerut');
SET @bareilly   = (SELECT id FROM districts WHERE slug='bareilly');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@lucknow,'Gomti Nagar','gomti-nagar',1),(@lucknow,'Hazratganj','hazratganj',1),(@lucknow,'Aliganj','aliganj',1),(@lucknow,'Indira Nagar Lucknow','indira-nagar-lucknow',1),(@lucknow,'Alambagh','alambagh',1),
(@lucknow,'Vikas Nagar Lucknow','vikas-nagar-lucknow',1),(@lucknow,'Mahanagar','mahanagar',1),(@lucknow,'Rajajipuram','rajajipuram',1),
(@kanpur,'Civil Lines Kanpur','civil-lines-kanpur',1),(@kanpur,'Kidwai Nagar','kidwai-nagar',1),(@kanpur,'Kakadeo','kakadeo',1),(@kanpur,'Swaroop Nagar','swaroop-nagar',1),(@kanpur,'Govind Nagar','govind-nagar',1),
(@agra,'Taj Ganj','taj-ganj',1),(@agra,'Fatehabad Road','fatehabad-road',1),(@agra,'Sikandra','sikandra',1),(@agra,'Kamla Nagar Agra','kamla-nagar-agra',1),
(@varanasi,'Lanka','lanka',1),(@varanasi,'Sigra','sigra',1),(@varanasi,'Cantonment Varanasi','cantonment-varanasi',1),(@varanasi,'Shivpur','shivpur',1),
(@allahabad,'Civil Lines Allahabad','civil-lines-allahabad',1),(@allahabad,'George Town','george-town',1),(@allahabad,'Naini','naini',1),
(@meerut,'Shastri Nagar Meerut','shastri-nagar-meerut',1),(@meerut,'Pallavpuram','pallavpuram',1),(@meerut,'Garh Road','garh-road',1),
(@bareilly,'Civil Lines Bareilly','civil-lines-bareilly',1),(@bareilly,'Pilibhit Road','pilibhit-road',1);

-- ── RAJASTHAN ────────────────────────────────────────────────────────
SET @jaipur     = (SELECT id FROM districts WHERE slug='jaipur');
SET @jodhpur    = (SELECT id FROM districts WHERE slug='jodhpur');
SET @udaipur    = (SELECT id FROM districts WHERE slug='udaipur');
SET @kota       = (SELECT id FROM districts WHERE slug='kota');
SET @ajmer      = (SELECT id FROM districts WHERE slug='ajmer');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@jaipur,'Vaishali Nagar Jaipur','vaishali-nagar-jaipur',1),(@jaipur,'Malviya Nagar Jaipur','malviya-nagar-jaipur',1),(@jaipur,'C Scheme','c-scheme',1),(@jaipur,'Mansarovar','mansarovar',1),
(@jaipur,'Tonk Road','tonk-road',1),(@jaipur,'Sanganer','sanganer',1),(@jaipur,'Sitapura','sitapura',1),(@jaipur,'Bajaj Nagar','bajaj-nagar',1),
(@jodhpur,'Sardarpura','sardarpura',1),(@jodhpur,'Pratap Nagar Jodhpur','pratap-nagar-jodhpur',1),(@jodhpur,'Ratanada','ratanada',1),(@jodhpur,'Shastri Nagar Jodhpur','shastri-nagar-jodhpur',1),
(@udaipur,'Fatehpura','fatehpura',1),(@udaipur,'Hiran Magri','hiran-magri',1),(@udaipur,'Ambamata','ambamata',1),
(@kota,'Talwandi','talwandi',1),(@kota,'Vigyan Nagar','vigyan-nagar',1),(@kota,'Dadabari','dadabari',1),
(@ajmer,'Vaishali Nagar Ajmer','vaishali-nagar-ajmer',1),(@ajmer,'Madar','madar',1);

-- ── GUJARAT ──────────────────────────────────────────────────────────
SET @ahmedabad  = (SELECT id FROM districts WHERE slug='ahmedabad');
SET @surat      = (SELECT id FROM districts WHERE slug='surat');
SET @vadodara   = (SELECT id FROM districts WHERE slug='vadodara');
SET @rajkot     = (SELECT id FROM districts WHERE slug='rajkot');
SET @gandhinagar= (SELECT id FROM districts WHERE slug='gandhinagar');
SET @bhavnagar  = (SELECT id FROM districts WHERE slug='bhavnagar');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@ahmedabad,'Satellite','satellite',1),(@ahmedabad,'Prahladnagar','prahladnagar',1),(@ahmedabad,'Vastrapur','vastrapur',1),(@ahmedabad,'Bopal','bopal',1),
(@ahmedabad,'Gota','gota',1),(@ahmedabad,'Chandkheda','chandkheda',1),(@ahmedabad,'Naroda','naroda',1),(@ahmedabad,'Maninagar','maninagar',1),
(@ahmedabad,'Navrangpura','navrangpura',1),(@ahmedabad,'Thaltej','thaltej',1),
(@surat,'Adajan','adajan',1),(@surat,'Vesu','vesu',1),(@surat,'Pal Surat','pal-surat',1),(@surat,'Dumas Road','dumas-road',1),(@surat,'Katargam','katargam',1),(@surat,'Udhna','udhna',1),
(@vadodara,'Alkapuri','alkapuri',1),(@vadodara,'Vasna','vasna',1),(@vadodara,'Harni Road','harni-road',1),(@vadodara,'Karelibaug','karelibaug',1),
(@rajkot,'Kalavad Road','kalavad-road',1),(@rajkot,'Rajkot City','rajkot-city',1),(@rajkot,'Raiya Road','raiya-road',1),
(@gandhinagar,'Sector 7 Gandhinagar','sector-7-gandhinagar',1),(@gandhinagar,'Sector 21 Gandhinagar','sector-21-gandhinagar',1),
(@bhavnagar,'Bhavnagar City','bhavnagar-city',1),(@bhavnagar,'Waghawadi Road','waghawadi-road',1);

-- ── WEST BENGAL ──────────────────────────────────────────────────────
SET @kolkata    = (SELECT id FROM districts WHERE slug='kolkata');
SET @howrah     = (SELECT id FROM districts WHERE slug='howrah');
SET @durgapur   = (SELECT id FROM districts WHERE slug='durgapur');
SET @siliguri   = (SELECT id FROM districts WHERE slug='siliguri');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@kolkata,'Salt Lake','salt-lake',1),(@kolkata,'New Town Kolkata','new-town-kolkata',1),(@kolkata,'Ballygunge','ballygunge',1),(@kolkata,'Park Street','park-street',1),
(@kolkata,'Jadavpur','jadavpur',1),(@kolkata,'Behala','behala',1),(@kolkata,'Tollygunge','tollygunge',1),(@kolkata,'Gariahat','gariahat',1),
(@kolkata,'Dum Dum','dum-dum',1),(@kolkata,'Baranagar','baranagar',1),
(@howrah,'Howrah City','howrah-city',1),(@howrah,'Santragachi','santragachi',1),(@howrah,'Liluah','liluah',1),
(@durgapur,'City Centre Durgapur','city-centre-durgapur',1),(@durgapur,'Bidhannagar Durgapur','bidhannagar-durgapur',1),
(@siliguri,'Siliguri City','siliguri-city',1),(@siliguri,'Sevoke Road','sevoke-road',1),(@siliguri,'Hill Cart Road','hill-cart-road',1);

-- ── MADHYA PRADESH ───────────────────────────────────────────────────
SET @bhopal     = (SELECT id FROM districts WHERE slug='bhopal');
SET @indore     = (SELECT id FROM districts WHERE slug='indore');
SET @gwalior    = (SELECT id FROM districts WHERE slug='gwalior');
SET @jabalpur   = (SELECT id FROM districts WHERE slug='jabalpur');
SET @ujjain     = (SELECT id FROM districts WHERE slug='ujjain');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@bhopal,'MP Nagar','mp-nagar',1),(@bhopal,'Kolar Road','kolar-road',1),(@bhopal,'Bairagarh','bairagarh',1),(@bhopal,'Arera Colony','arera-colony',1),(@bhopal,'TT Nagar','tt-nagar',1),
(@indore,'Vijay Nagar Indore','vijay-nagar-indore',1),(@indore,'Palasia','palasia',1),(@indore,'Bhawarkua','bhawarkua',1),(@indore,'Rau','rau',1),(@indore,'AB Road','ab-road',1),
(@gwalior,'City Centre Gwalior','city-centre-gwalior',1),(@gwalior,'Lashkar','lashkar',1),(@gwalior,'Morar','morar',1),
(@jabalpur,'Napier Town','napier-town',1),(@jabalpur,'Vijay Nagar Jabalpur','vijay-nagar-jabalpur',1),(@jabalpur,'Gwarighat','gwarighat',1),
(@ujjain,'Freeganj','freeganj',1),(@ujjain,'Madhav Nagar','madhav-nagar',1);

-- ── PUNJAB & HARYANA ─────────────────────────────────────────────────
SET @chandigarh = (SELECT id FROM districts WHERE slug='chandigarh');
SET @ludhiana   = (SELECT id FROM districts WHERE slug='ludhiana');
SET @amritsar   = (SELECT id FROM districts WHERE slug='amritsar');
SET @jalandhar  = (SELECT id FROM districts WHERE slug='jalandhar');
SET @patiala    = (SELECT id FROM districts WHERE slug='patiala');
SET @ambala     = (SELECT id FROM districts WHERE slug='ambala');
SET @rohtak     = (SELECT id FROM districts WHERE slug='rohtak');
SET @hisar      = (SELECT id FROM districts WHERE slug='hisar');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@chandigarh,'Sector 17 Chandigarh','sector-17-chandigarh',1),(@chandigarh,'Sector 22 Chandigarh','sector-22-chandigarh',1),(@chandigarh,'Sector 35 Chandigarh','sector-35-chandigarh',1),(@chandigarh,'Manimajra','manimajra',1),
(@ludhiana,'Model Town Ludhiana','model-town-ludhiana',1),(@ludhiana,'Civil Lines Ludhiana','civil-lines-ludhiana',1),(@ludhiana,'Sarabha Nagar','sarabha-nagar',1),
(@amritsar,'Lawrence Road','lawrence-road',1),(@amritsar,'Ranjit Avenue','ranjit-avenue',1),(@amritsar,'GT Road Amritsar','gt-road-amritsar',1),
(@jalandhar,'Model Town Jalandhar','model-town-jalandhar',1),(@jalandhar,'Civil Lines Jalandhar','civil-lines-jalandhar',1),(@jalandhar,'Lajpat Nagar Jalandhar','lajpat-nagar-jalandhar',1),
(@patiala,'Civil Lines Patiala','civil-lines-patiala',1),(@patiala,'Model Town Patiala','model-town-patiala',1),
(@ambala,'Ambala City','ambala-city',1),(@ambala,'Ambala Cantonment','ambala-cantonment',1),
(@rohtak,'Delhi Road Rohtak','delhi-road-rohtak',1),(@rohtak,'Asthal Bohar','asthal-bohar',1),
(@hisar,'Urban Estate Hisar','urban-estate-hisar',1),(@hisar,'Hansi Road','hansi-road',1);

-- ── OTHER MAJOR CITIES ───────────────────────────────────────────────
SET @bhubaneswar= (SELECT id FROM districts WHERE slug='bhubaneswar');
SET @patna      = (SELECT id FROM districts WHERE slug='patna');
SET @ranchi     = (SELECT id FROM districts WHERE slug='ranchi');
SET @raipur     = (SELECT id FROM districts WHERE slug='raipur');
SET @guwahati   = (SELECT id FROM districts WHERE slug='guwahati');
SET @dehradun   = (SELECT id FROM districts WHERE slug='dehradun');
SET @puducherry = (SELECT id FROM districts WHERE slug='puducherry');

INSERT IGNORE INTO areas (district_id,name,slug,is_active) VALUES
(@bhubaneswar,'Saheed Nagar','saheed-nagar',1),(@bhubaneswar,'Patia','patia',1),(@bhubaneswar,'Chandrasekharpur','chandrasekharpur',1),(@bhubaneswar,'Nayapalli','nayapalli',1),(@bhubaneswar,'Bhubaneswar City','bhubaneswar-city',1),
(@patna,'Boring Road','boring-road',1),(@patna,'Bailey Road','bailey-road',1),(@patna,'Patliputra','patliputra',1),(@patna,'Kankarbagh','kankarbagh',1),
(@ranchi,'Doranda','doranda',1),(@ranchi,'Lalpur','lalpur',1),(@ranchi,'Harmu','harmu',1),(@ranchi,'Kanke Road','kanke-road',1),
(@raipur,'Shankar Nagar Raipur','shankar-nagar-raipur',1),(@raipur,'Telibandha','telibandha',1),(@raipur,'Pandri','pandri',1),(@raipur,'Tatibandh','tatibandh',1),
(@guwahati,'Guwahati City','guwahati-city',1),(@guwahati,'Zoo Road','zoo-road',1),(@guwahati,'Six Mile','six-mile',1),(@guwahati,'Beltola','beltola',1),
(@dehradun,'Rajpur Road','rajpur-road',1),(@dehradun,'Patel Nagar Dehradun','patel-nagar-dehradun',1),(@dehradun,'Clement Town','clement-town',1),
(@puducherry,'White Town','white-town',1),(@puducherry,'Anna Nagar Puducherry','anna-nagar-puducherry',1),(@puducherry,'Lawspet','lawspet',1);

-- ── FINAL VERIFICATION ───────────────────────────────────────────────
SELECT 'FINAL COUNTS' as info;
SELECT COUNT(*) as total_districts FROM districts;
SELECT COUNT(*) as total_areas FROM areas;
SELECT COUNT(*)*19 as total_service_pages FROM areas WHERE is_active=1;
SELECT state, COUNT(DISTINCT d.id) as districts, COUNT(a.id) as areas
FROM districts d LEFT JOIN areas a ON a.district_id=d.id AND a.is_active=1
GROUP BY state ORDER BY areas DESC;
