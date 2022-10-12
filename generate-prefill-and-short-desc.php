<?php
// auto generate and set the product short description whenever the item is updated or saved 
// added by Jedidiah Fowler 10-15-19
// use: allows easy generation of short descriptions for use with FBMP and LSN
add_action('save_post_product', 'sd_on_product_save', 10, 3);
function sd_on_product_save( $post_id, $post, $update ) 
{
	// prefill description based on the category, products only
	if ( $post->post_status == 'draft' ) {
		remove_action('save_post', 'sd_on_product_save', 10, 3 );
		$type = get_post_type( $post );
		if ( $type == 'product' ) {
			// get the product id
    		$product = wc_get_product( $post_id );
    		// construct the short description for each product (get variables to do it)
			$content = $product->post->post_content;
			$short_desc = $content;
			$prefill = "";
			if( has_term( 'forklifts', 'product_cat', $post_id ) ) {
				if ( $short_desc == "" ) {
					$prefill = "Brand: 
Model:
Serial Number:
Hours:
Fuel Type:
Tire Size (Front):
Tire Size (Rear):
Max Lift Height: inches
Appox. Truck Weight: lbs
Rated Capacity: lbs
Side Shift: 

Engine Make: 
Model: 
Family: 
Displacement:  Liters
";
					$product->set_description( $prefill );
					$product->save();
				} 
			}
		}
		return $post_id;
	}
	// generate the short description and excerpt based on the description, products only
	remove_action('save_post', 'sd_on_product_save', 10, 3 ); // unhook the main function
	$type = get_post_type( $post ); // get post type
	// if post type is product
	if ( $type == 'product' ) {
		// get the product id
    	$product = wc_get_product( $post_id );
    	// construct the short description for each product (get variables to do it)
		$content = $product->post->post_content;
		$short_desc = $content;
		$contentchange = $content;
		$title = $product->get_title();
		$link = "
		
Link to item on our web store:
" . get_permalink( $post_id );
		$condition = 0;
		$condition = $condition + get_post_meta( $post_id, '_ebay_condition_id', true );
		// add a category tag to the product if necessary depending on its current categories
		$customship = 0;
		$customship = $customship + get_post_meta( $post_id, '_customship', true );
		$furnitureTag = "";
		if( has_term( 'furniture', 'product_cat', $post_id )) {
			$furnitureTag = $link . $furnitureTag . "
			
CASH PAYMENT ONLY FOR THIS ITEM

";
			if ($customship == 2) {
				$furnitureTag = $furnitureTag . "LOCAL PICKUP ONLY
NO SHIPPING FOR THIS ITEM";
			}
		}
		//$cattag = "";
		//$clothtag= "";
		/*if( has_term( 'air-compressors', 'product_cat', $post_id )) {
			$cattag = $cattag . "Alternate terms: air airbrush auto bd blow body bubble cable california campbell centrifugal clean compressed compressor compressors construction consumer dewalt diaphragm garage gas grade gun guns hausfeld industrial inflator ingersoll ionic kaishan kongslide liquid machine makita mechanics nail nat’l natl ohio piping piston pneumatic porter powered pressure professional psi pumps quincy rand reciprocating rolling rotary sandblasting sanders screw scroll senco shop single snow speedaire spray stage stanley-bostitch system tank tire tools treatment tyre vacuum vane washer "; }
		if( has_term( 'atvutv', 'product_cat', $post_id )) {
			$cattag = $cattag . "Alternate terms: 1000 1000cc 1000xp 125 150 250 250cc 300cc 4 400ex 450 450cc 4wheeler 4x4 500 500cc 570 600cc 700cc 750 800 800cc 850 900 accessories ace add-ons adult affordable all am arctic atv atv's atvs audio automatic automobile autos awd bar big bigred bike bikes bms bog boss buggie buggies buggy buggys bullet busa buy buyherepayhere by can can-am canam car cars cart carts cat cbr cf chainsaws chevrolet chevy clutch coolers coolster crawler crf cups cycle davidson dct deere defender differential dirt dirtbike dirtbikes dodge down drive dumpbed dune dynamix easy eps exmark farm fast finance financing for ford foreman forsale four fourwheeler fox fun fwd gator gear general gillis gillispowersports gloves go gocart gocarts goggles gokart gold goldwing golf gsxr harley hauler havoc hd helmets here high highlifter hisun honda horsepower hp husqvarna i-4wd jeep john kart karts kawasaki kawi kioti ktm kubota led lift lifted light lightbars locking loud massimo maverick midsize mini moto motocross motorcycle motorcycles mud muddy mule new nissan northstar offroad outlander output parts pay payment pioneer pit pitbike pitbikes polaris polaris pony power pre-owned pressure pro-star probox prostar quad r!xds!!!4x4!extreme race racing ramp ranch rancher ranchpony ranger razor red renli reverse rgr rhino rincon roadster rock rotax rpm rubicon rv rzr sale sales sand savannah scooter shadow side sidebyside sidexside skeeter snap-on snorkeled snowmobile sound sportsman sportster spyder strike supercharged suzuki sxs talon tao taotao tennessee terrain teryx three tires tocoma toyhauler toyota toys track tractor trail trailer trike truck trucks trx turbo tyrex used utility utv utv’s utvs v-twin vehicle vehicles viking vtwin vulcan washer wetsounds wheel wheeler wheelers wildcat winch wing wolverine wrangler x3 xp yahama yama yamaha yeti youth yzf "; }
		if( has_term( 'baler', 'product_cat', $post_id )) {
			$cattag = $cattag . "Alternate terms: aluminium automatic bailing baler balers baling bind brothers cardboard closed compact compactor compress container convenience corrugated cram-a-lot cube cubic deconstruction department document door downstroke duty end engineering hamm heavy high horizontal hospital hotel ids inch king load machine manual new nexgen office pak-a-can paper philadelphia piqua plastic press ram rectangular recycle recycling refurbished restaurant scrap scraps selco smart square stationary stockroom store system tensile tie tramrail two used v-6030 v-6030hd v5-hd v6030 vertical warehouse wire yard "; }
		if( has_term( 'boats', 'product_cat', $post_id )) {
			$cattag = $cattag . "Alternate terms: aggresor allied aluma-weld alumacraft alumacraft alweld aluminum aluminum rogue ark axis bait banana bass bayliner bayou beneteau bennington bluewater boat boats boats koffler boats larson boatworks boston bote bow bowrider box cabin campion carver cat catamaran caymas centre chaser coast coastline cobalt cobia comp company company lund concept console craft crestliner crevalle cruiser cuddy deck dinghy duckworth eagle ebtide edgewater fishing flote fresh fx g3 galaxy game glasstream grizzly harbor harris hewes houseboat hydra hydrostream invincible jeanneau jet king koffler lake larson legend life live lowe lund mako malibu marine mastercraft mirrocraft misty monark monterey lowe motor nautical nitro northwest ocean pathfinder personal phoenix pond pontoon power princecraft ranger reef regal river rod rogue runabout runner sailfish salt sea searay skeeter skiff smoker sportfishing sports sportsman stanley starcraft stealthcraft stingray stingray carolina stratos striper sun supra sweetwater sylvan sylvan thresher tackle thunder toy tracker trawler triton vee ventura war water watercraft weldcraft wellcraft whaler world worms xpress yacht "; }
		// clothing disclaimer and category tag
		if( has_term( 'clothing', 'product_cat', $post_id )) {
			// add clothing only notice for pickup
			$clothtag = $clothtag . "
Curbside pickup available
";
			$cattag = $cattag . "Alternate terms: affordable apparel aramark big bill bottoms building button cargo carhartt carpenter cat cheap code collard comfortable construction cotton coverall crew denim dickies dress duck dungarees durable electrician flame fluorescent garage good green grip high hrc industrial inexpensive jacket jeans job kap labor laborer lime long loose manufacturing mens mopar national near new orange outerwear overall pant pit ppe price protective quality red redkap reflective relaxed resistant roadside rugged safety sale service shirt short shorts site sleeve steel strength sturdy summer top tough uniform used vis visibility warehouse winter work work-pant worker workrite workwear wrecker yellow"; } 
		if( has_term( 'forklifts', 'product_cat', $post_id ) || has_term( 'forklift-attachments', 'product_cat', $post_id ) ) {
			$cattag = $cattag . "Alternate terms: & 10000 11000 12000 13000 14000 15000 15500 3000 4000 5 5000 6000 7000 8000 9000 a accessories adjustable aerial aisle aisle-master all allis allis-chalmers articulating artison athey atlet attachments ausa autolift ax baker baoli barrett battery battioni baumann behind belotti bendi best big blue bobcat bonser boom boom-lift boomlift boss bpi brands bright bristol brouwer bt bucket buy by capacity carelift cart case cat caterpillar cds cesab chalmers champ cheap cherry chery chevy chrysler claas clark climax cobra combilift commander companies construction container cost counterbalance covers craft crown cummins cushion custom cvs daewoo dantruck datsun dealer dealers dealerships deere desta detas deutz dieci diesel diesels directional docker dockstocker donkey doosan double down drexel drive dual duram duramax duranti duty dynalift eagle eaves electri electric elwell entwistle equipment erickson euroyen extensions f150 f250 fahr fantuzzi faresin feeler fenwick ferrari fiat flexi floor for forano fork forklift forklifts forks fuel g941 games gas gehl genie giant global goodsense gradall gregory halla hamech hand handler handling hangcha harlo haulott haulotte hc heavy heden heli henley hi high hoist holland hubtex hydraulic hyster hytrak hyundai icem industrial industries ingersoll-rand international iron jac jack jacked jacks jcb jet jlg joe jumbo jungheinrich k kalmar kd kesmac kg king koehring komatsu konecranes kramer-allrad lafis lancer landoll lansing lb lease lees lewis-shepard liebherr lift lift-it lift-rite liftall lifted lifter lifting lifts linde lion liugong lo load loader loadmac loed lonking low lowry lp lpg ltd lugli lull luna machine magni mainline maintenance man manitou manlift manliftused manual manufacturers martini massey-ferguson mast master matbro material max maximal maxlift mdb me mechanic merlo mfg miag mic mightylift miller mini mitsubishi mobile models moffett motor motorised motorized mounted mover multi multi-directional multiton mustang myler-apache narrow navigator near neuson new nichiyu nissan noble nuova nyk o of off om omega omg on one opane operated order orion oto owner p pagani palfinger pallet parker parts pettibone picher picker pickers piggyback pimespo platform pneumatic portable positioner power powerlift ppm pramac price prices prime-mover princeton profile propane pump ramp raymond rc reach refurbished rental repair rhino rico ride riding road rocla rol-lift rondebult rough royal safety sale sales samag sambron samsung sanderson scale scales schaeff scissor scissorlift second seegrid sellick sennebogen service serviced services shift side single sisu sit sizes sky skyjack skytrack skytrak small smartlift smv specifications spyder sroka stacker stainless stand starke steel steinbock stihl still stone stop stopper straddle sumitomo suppliers suv svetruck table tahoe tailift taylor tci tcm technology telehander telehandler telehandlers telescopic terex terrain tines tires titan ton tovel tow towable towmotor toyota trader training trak traverse trolley truck trucks turret tusk tynes types un unicarrier unicarriers up uro uromac used usnr ustc utilev vallee valmar valmet versa-lift viking viper vkp wacker waldon walk walkie warehouse warner-swasey wecan weidemann wheel wheels white wiggins windham with works xcmg xtreme yale yang "; }
		if( has_term( 'furniture', 'product_cat', $post_id )) {
			$cattag = $cattag . "Alternate terms: bed bed-frame bedframe bedroom cal cedar cresent dark darkwood dovetailed drawer drawers dresser english frame furniture hampton hudson king light lightwood lined matress mattress mirror night nightstand oak panel plinth queen rail real set solid stain stand storage suite venners wood "; }
		if( has_term( 'generators', 'product_cat', $post_id )) {
			$cattag = $cattag . "Alternate terms: #caterpillar #crushing #cummins #datacenter #diesel #drilling #emergency #generator #hospital #industrialengines #kw #naturalgas #new #power #powersystems #rental #standby #stationary #tiercompliant #used #waukesha aggreko amps ats attenuated automatic auxiliary axle backup baldor bank base breaker buys can cat caterpillar centers circuit commercial compliant construction continuous crushing cummins data day deere detroit diesel drilling emergency emissions enclosure engines for ford fuel gas genends generac generator generators gensets grade greenhouse hospital industrial ingersoll-rand john katolight kohler load lpg magnamax magnaplus maintenance marathon marine mining mitsubishi mobile module mq mtu multiquip municipality my natural new newage offshore oilfield olympian perkins petroleum phase portable power prime proof propane propulsion radiator rental sale sell service single solutions sound stamford standby stationary surplus switch systems tandem tank tested three tier trailer-mounted transfer turnkey unused used volvo waukesha weather-proof weather "; }
		if( has_term( 'granulators-pelletizers-shredders', 'product_cat', $post_id ))
		{
			$cattag = $cattag . "Alternate terms: acme aggregate andritz ash asr assembly auger ball batteries beside blow bluerock bottles cable cake carpet cement central clinkers coal cocoa coke colortronic conair cramer crates cresswood crusher cryogenic cumberland decking dry duty engineered equipment extrusion fabrication feed ferrous fertilizer fibers film flakes fluff foremost frewitt glass gloucester grains granules granutec grinding gypsum heavy herbold hot hsm injection insulation iqf jewel kobra lime machining material maverick medical melt merrill metalworking mill mitts molding msw nelmor non pallman paper particle pe pellets pet petroleum pharmaceutical phosphate pipe plastic plastics powdery pp press profile ps pu pulverizing pvc rapid recycling reduction refeed regrinds rotogran rubber salt scrap screw security segregation sheet shredders shredding size sorter sprout support tablets textiles the thermoforming tires uniform vecoplan waste weima wet whitman wire wood zorba ";
		}
		if( has_term( 'hoists', 'product_cat', $post_id ))
		{
			$cattag = $cattag . "Alternate terms: acco aerospace agri agricultural  air amba american anver apex assembly automotive bipico black bosch budget bull capacity cardinal carryor caterpillar chain chemicals chester coffing columbus commercial construction crane distribution docks dunlop eastman electric electro ezo farming flt gorbel hand handyman harrington heavy hitachi hoist hydraulic iko ina ingersoll jcb jet jk jug kbc kg kinex kito konecranes lift lifting line load loading logging makita manual manufacturing marine material mckinnon mining miranda mitutoyo molysulf nirlon nmb nrb ntn overhead paper pendant phase pig pneumatic powered prima pulley rand red rooster rope samrat single sissco site skf spider spitman steel supply tadano taparia thnk tilt timberland ton tools totem tvs unloading urb vertical vestile warehouse wire work yale ";
		}
		if( has_term( 'light-towers', 'product_cat', $post_id ))
		{
			$cattag = $cattag . "Alternate terms: a/c acme activities activity aggreko allmand amida amps and area ats attenuated automatic auxiliary axle back backup baldor bank base basketball battery beacon big blackout breaker bridge bridges bros buys can cat caterpillar cement centers circuit coleman commercial compliant concrete construction continuous court crushing cummins data day deere demolition detroit diesel doosan down drilling electricity emergency emissions enclosure engines equipment events field firefighting flood floodlights football for ford free fuel fun gas genends generac generator generators genie gensets golights grade greenhouse high-mast highway hospital hydrogen industrial ingersoll ingersoll-rand job john katolight kohler kubota lay led light lighting lights load lot lots lpg magnamax magnaplus magnum maintenance marathon marine megatower military mining mitsubishi mobile module moonlight motion move moveable mq mtu multiquip municipality my natural neuson new newage night offshore oil oilfield olympian onan outage outside parking party perkins petroleum phase picture plant play playing playtime portable power powered powerful powerfull prime pro production propane propulsion radiator rand refining rental rescue road sale searchlights sell service services side single site sites soccer solar solutions sound sport sports spotlights stamford standby stationary storm summer summertime surplus switch systems tall tandem tank telescope terex tested the three tier time towable tower tower/generator towers trailer-mounted transfer travel tunnels turbine turbines turnkey unused up used volvo wacker wanco waukesha weather-proof where whisperwatt who wind winter work ";
		}
		if( has_term( 'metal-working', 'product_cat', $post_id ) || has_term( 'saws', 'product_cat', $post_id ) )
		{
			$cattag = $cattag . "Alternate terms: arm blades cable central circular city compact coping craftman cross curved cut dake dayton delta drill general grizzly hacksaw hook horizontal hp international jet jigsaw jwsb lumber machinery master mband milwaukee palmgren portable porter powermatic press radial reciprocating regular resawing rikon ripping router saw scroll sears shop skip steel table vertical wood workshop ";
		}
		if( has_term( 'mowers', 'product_cat', $post_id ) )
		{
			$cattag = $cattag . "Alternate terms: 2wd 4wd 4x4 along arborist ariens back backhoe bad battery behind big black blades blueberries blueberry boy bull bulldozer bush cadet camp case cat cattle chopper clearing commercial compact craftsman crop cub cwp dairy decker deer deere diesel dixie dozer dr ego engine equipment excavator exmark farming ferguson fergusson food ford gas generator generators grasshopper gravely harrow hoe hog holland honda horse hunting husqvarna hustler implements john jon kubota landscape landscaping lawn loader machine mahindra masport massey mini monster mower mowers mowing new parts pigs play plot power pulsar rear ride riders riding row ryobi scag service simplicity skid snapper spartan steer stihl tex toro track tractor tractors trailer tree troy-bilt turn tym volvo walk wen work yard zero zmaster zturn ";
		}
		if( has_term( 'pallet-jacks', 'product_cat', $post_id ) )
		{
			$cattag = $cattag . "Alternate terms: accessories action adjustable all allis amarite apollolift back baker bendi big boom bucket buy cage capacity carbo cart case cat caterpillar chalmers checklist chevy chock clark construction counterbalance craft crown cushion custom dealers diesel dog dolly doosan dry duramax duty electric elift eliftruck eoslift ergonomic extensions f250 faced flexscreen floor flybold for fork forkl forklift forklifts forks genie global goplus hand heavy heli high hire hydraulic hyster hyundai i-liftequip industrial jack jcb jet jigger joe jungheinrich kelley komatsu large lift liftall lifted lifter lifting lifts loader loadhog loading long low manitou manual me mighty mitsubishi motor mover moving mule narrow near nissan of on pake pallet pallets parts platform pneumatic power powerstroke price prime profile propelled pump reach rental riding room roughneck rytec sale sales sandusky scale scales scissor scooter seat self serco service short side silverado single sit-down sitdown skid stand standard stopper storage strongway suv taylor tcm telehandlers telescopic terrain test tire titan toy toyota tractor training truck trucks uline unloading used valley van vergo vestil video walkie warehouse weight wesco wheel with work yale zoomlion ";
		}
		if( has_term( 'personnel-lifts', 'product_cat', $post_id ))
		{
			$cattag = $cattag . "Alternate terms: & 10000 11000 12000 13000 14000 15000 15500 1930 2030 3000 3219 4000 5000 6000 7000 7127 7127rt 7135 7135rt 8000 9000 aisle-master allis-chalmers artison athey atlet atv atvs ausa autolift awp20 backhoe backhoes baker baoli barrett battioni baumann belotti bendi big blade blue bobcat bonser boom boom-lift boomlift boss box bpi bradco bright bristol brouwer brush bt bucket buckets bulldozer bulldozers bushhog carelift case caseih cat caterpillar cds cesab champ cherry chery chrysler claas clam clark climax cobra combilift combo commander compact construction craft crown cushion cutter cvs daewoo dantruck datsun deal deere desta detas deutz dieci diesel directional docker dockstocker donkey doosan dozer dozers drexel drive dual duranti dynalift e300 e340 e400 eagle eaves electric elwell entwistle equipment erickson euroyen excavator excavators fae fahr fantuzzi faresin farm fecon feeler fenwick ferrari fiat flexi forano ford fork forklift forklifts fuel g941 gas gehl genie giant global goodsense gr gr-12 gr-15 gr-20 gr12 gr15 gr20 gradall grapple gregory gs-1930 halla hamech handler handling hangcha harlo haulott haulotte hc heden heli henley hi hoe hoes hog hoist holland hubtex hyster hytrak hyundai icem implements industries ingersoll-rand international iron jac jack jacks jcb jlg joe john jumbo jungheinrich kalmar kd kesmac kg king koehring komatsu konecranes kramer-allrad kubota kx lafis lancer landoll landscape lansing lb lees lewis-shepard liebherr lift lift-it lift-rite liftall lifter lifts linde lion liugong lo load loader loaders loadmac loed lonking lowry lpg lugli lull luna magni mahindra mainline man manitou manlift manliftused martini massey-ferguson master matbro material maximal maxlift mdb mec merlo mfg miag mic mightylift miller mitsubishi mobile moffett multiton mustang myler-apache navigator neuson new nichiyu nissan noble nuova nyk om omega omg orion oto pagani palfinger parker pettibone picher pimespo pneumatic power powerlift ppm pramac prime-mover princeton raymond rhino rico rocla rol-lift rondebult royal samag sambron samsung sanderson schaeff scissor seegrid sellick sennebogen sisu sky skyjack skytrak smartlift smv spyder sroka starke steinbock stihl still stone sumitomo svetruck tailift taylor tci tcm technology telehander telehandler terex titan tovel tow towmotor toyota trak traverse tusk un unicarrier unicarriers uro uromac usnr ustc utilev vallee valmar valmet versa-lift viking viper vkp wacker waldon warner-swasey wecan weidemann wheel white wiggins windham works white wiggins windham works xcmg xtreme yale yang ";
		}
		if( has_term( 'pumps', 'product_cat', $post_id ))
		{
			$cattag = $cattag . "Alternate terms: aeration air anderson aod aquarium axial barmesa basement berkeley black booster bore borehole cavity centrifugal chain channel chemicals closed coal conditioning construction continuous contra-block cooling cutter dayton detroit dewatering diaphragm direct disk displacement dosing double drum dynamic ebara emerson energy filtering fire flexible floods flow flowserve food foodstuffs force fuel gas gear goulds gravity grey grinder grundfos head heavy-duty high hollow hydrant hydraulic impeller impulse industrial industry injection irrigation itt ksb liberty lift lion lobe low mechanical medical mines mining mixed multi multi-stage natural oil patterson peristaltic petroleum piston plunger ponds pools positive progressive pumps radial rainwater reciprocating red rope rotary ruthman schlumberger screw semi-axial septic sewage single sludge slurries slurry stage steam stormwater submersible subsoil sulzer tank tanks thompson trade tsurumi tutill udor underground valveless velocity vortex waste wastewater water well wells work xylem yeomans ";
		}
		if( has_term( 'roll-offs', 'product_cat', $post_id ))
		{
			$cattag = $cattag . "Alternate terms: big clean closed construction container debris demolition disposal disposed dumpster duty heavy job large management material new off open recovered remodeling renovating residential roll site sludge steel top trash truck up used warehouse waste work yard ";
		}
		if( has_term( 'shipping-containers', 'product_cat', $post_id ))
		{
			$cattag = $cattag . "Alternate terms: 1-trip 1-tripper 10’ 10ft 20’ 20ft 40’ 40ft 45’ 45’hc 45ft 45hc above access affordable airtight aluminum athletic atv auction backyard bar barn barns big blind booth box boxes bug build building buildings bulk bunk bunker burn cabin camp can cans cargo cargo-worthy cargoworthy carport cave cellar cheap coffee commercial common condition conex conexes conexs connex connexes connexs construction contain container container-trailer containers containor convert converted corrugated cost crate cube custom cwc deal delivery demolition diy document door doors double dry durable easy economical effective emergency ended equipment estate excess export extra farm farming farms fast feed feet file flea fold food foot fork free freezer freight furniture garage general grade green ground guard h-c h-q handling hard harley hauling hay high high-cube high-qube home homes house housing hunting industrial instant intermediate intermodal inventory ios iso job jobox joboxes kiosk land landscape laundry lawn level lift loading lock lockable lockbox low maintenance man market material materials metal mini mining mobile mod mode modifications modified motorcycle moving near new ocean office oilfield on-site one onsite open out outdoor outside overseas oversized pallet panels parts permanent personal playhouse pod pods pools pop portable prepper prepping proof props protect purpose qube railroad ranch real recreational refurbish remodeling rent residential restaurant retail reusable rodent rodent-free room sale scrap sea sea-container seacan seacans seasonal secure security self-storage semi shack shacks she shed sheds shelter shipping shop short simulator site space spacious sports stackable standard steel storage storm supplies survival tack temporary term tight tin tiny tire tool tools tornado trailer trailers training transport transportation transporting trip tripper underground unit units unloading use used uses vandal versatile walk ware warehouse water waterproof weather weather-proof weatherproof wheeler wind work workshop worthy wwt xtra ";
		}
		if( has_term( 'skid-steer-attachments', 'product_cat', $post_id ) || has_term( 'skid-steers', 'product_cat', $post_id ) )
		{
			$cattag = $cattag . "Alternate terms: 4x4 accumulators aerial ag aggregate all allis allison asphalt asv atlas attach attachment attachments atv atvs auction auger back backhoe backhoes bale bandit basket belarus bell belt big blade blower bobcat bomag boom boxer breaker brooms brush bucket buckets bulldozer bulldozers bumper capacity carry case cat caterpilar caterpillar cattle cdl chalmers champion chippers chips clam clamping clark clean cleanout clearing compact compactor concrete conditioner construction coyote crane crawler crushed crusher cummings cutters cutting daewoo daewood datson davis debris deere demo detroit diesel diggers digging dirt dirtbox ditch ditching doosan dozer dozers dresser drexel dually duals dump dumptruck dynapac edge equipment ex excavating excavation excavator excavators extendable farm farmall feed ferguson fertilizer fiat flatbed fmc ford forestry fork forklift forklifts forks frost galion gehl general generator generators genie gooseneck gradall grade grader grading grain grapple grapples gravel grinder grove hammer handle handler handling haul haulotte hay heavy high highlift hitachi hoe hoes hole holland hydraulic hydro-ax hyster hyundai ih ihi implements industrial ingersoll international jcb jlg john kawasaki kentworth kenworth kioti kobelco komatsu kubota land landscape leveler levelers leveling lift lifting lifts light link litter loader loaders loegering logs long lull machine machinery mack mahindra man manitou massey massy material materials materila mini mitsubishi motor move mover moving mower mulch mulchers multiquip mustang neuson new nissan pallet paver pavers paving payloader pete peterbilt peterbuilt pettibone plane plant plants plow post pouring powerful prime pull puller pullers pump purpose pusher pushing quick quick-plate ramrod ranch rand raymond removal rental rentals road rock rocks roller rollers root sand scattrak scissor scraper screen seed sellick semi shear shears shell skeleton skid skidder skidsteer skip-loader skyjack skytrak snorkel snow soil spear spreading steel steer steers sterling stone strength stump sweep sweeper takeuchi taylor tcm tele teledyne telelect tennant terex tex thomas tiger tiller tillers tomahawk ton tons toolcat tooth toro tough towmotor toyota track trackhoe trackhoes tractor tractors trade trailer transport tree treepuller trees trencher trenchers tri-axle triaxle truck trucks turf uick undercarriage upright utility vermeer versahandler vestil volvo wacker way welder wheel witch with wood work wtb yanmar yard ";
		}
		if( has_term( 'snowmobiles', 'product_cat', $post_id ))
		{
			$cattag = $cattag . "Alternate terms: 4-cylinder aktiebolaget aktiv alaskan albar alko allied allouealsport alpina am amf amrec amuret apex apollo aprilia arbe arctic argo ariens arlberg attex auto autoboggan bajaj bear big birdie blade blue boa-ski boatel bob-o-link boganna bolens bonanza bonham bosak boss broncco brut buran buzz car caribou cat chains champion chaparral chimo chrysler clinton clipper cmx coleco coleman columbia cruiser culloch cycle dauphin deere design diplomat dynamics eaton's eliason es-kee-mo eskimo eskimobile eskimotor evinrude ferguson fiberez finncat flake foremost fox fram frederick-willys frontier galaxy genesis gilson glarco go goose gorski grand harley-davidson herters hiawatha homelite honda horse hu-skee hunting hurricane husqvarna hustler ice ingham intrepid invader iso jac-trac jcpenney jet job john johnson kaiser kalamazoo kawasaki kebec king kometik ktm lark larson laska-ski leisure lohnerwerke lorch luger lynx mallard man manhandler manta marshall massey master mavrik maxi-ski mc mercury moleba-ski montagnais moto-jet moto-kometik moto-loo moto-ski muscaro muscateer nanuk neige new northway ockelbo omc ookpit otter outdoor owl pente phantom play pocket-rocket polar polaris polecat poloron pow-r-sled power prix pro raider ranger rascal redline rm roamer rolba roll-o-flex roy rupp rustler sabre safari scanton scoot scorpion shark sherpa silverline skeeter ski ski-bec ski-bee ski-condor ski-daddler ski-doo ski-jet ski-kat ski-king ski-lark ski-pony ski-ram ski-rec ski-star ski-zoom skidoo skiing skimobile skipper skiroule smith-roles sno sno-bird sno-blazer sno-boss sno-chief sno-clipper sno-commander sno-craft sno-cub sno-dart sno-flite sno-fury sno-ghia sno-glide sno-hawk sno-jet sno-king sno-pac sno-phantom sno-pony sno-prince sno-rover sno-shoo sno-skat sno-skoot sno-sport sno-squire sno-star sno-trac sno-trek sno-tric sno-wolf snow snow-cat snow-mite snow-sprite snowbug snowplay spartan speedway sports star starcraft stroke superstar suzuki swinger t-bird tajga tamer thunderbolt timbersleed tour-a-sport toy trac tract tracted trade trail-a-sled trail-blazer trail-king trailmaker trans-ski travel tundra uto-ski valmet varg vehicle vehicles viking voyageur wee wee-ski wells wheel whip-it wildcat winds witch-craft wolverine yamaha yukon ";
		}
		if( has_term( 'tractors', 'product_cat', $post_id ))
		{
			$cattag = $cattag . "Alternate terms: air all allis atlas auction backhoe bandit belarus bell belt bobcat bomag boom boy branson breaker bucket bulldozer bumper case cat caterpillar cattle chalmers champion clark compactor compressor concrete construction copco crane crawler crusher daewood davis deere dir dirt ditch dozer dresser dump dynapac equipment excavation excavator farm farmall ferguson fiat ford forestry forklift frost galion gehl generator genie gooseneck gradall grade grader grove hamm hammer hitachi hoe holland hydro-ax hyster hyundai ihi ingersoll international jcb jlg john kawasaki kioti kobelco komatsu kubota laymor lee lift link linkbelt loader long ls lull machinery mahindra man massey massy mini mitsubishi morbark morooka motor mustang neuson new pettibone pickup pump ranch rand rayco reach rental rentals rock roller scissor scraper screen semi skid skidder skip-loader skyjack skytrak snorkel steer takeuchi telehandler telelect terex thomas tiger track trackhoe tractor trade trailer trencher truck undercarriage vermeer volvo wacker water welder wheel witch wtb yanmar ";
		}
		if( has_term( 'trailers', 'product_cat', $post_id ))
		{
			$cattag = $cattag . "Alternate terms: & 1000 380 adapter adapters aluminum american and arizona atv aubrey axle axles ball bed big bike bikes bobcat box boxes bragg brake brakes bumper bumpers business c&m campers car cargo cargomate carhauler carrier carry cars cody construction continental controller controllers corn coupler couplers covered cummins dealer deck deckover deere diamond dirt double dove dovetail dual dump duramax edge enclosed equipment farm featherlite fender fenders fix fixed fixing flat flatbed flex float for freight garden gater gator goose gooseneck gravel guy's h&h harness hat hauler haulers hauling haulmark hay heavy hitch hitches honda horse hot i-35 i35 interstate john keywords:flat kubota lamar landscape landscaping lark lids light lights livestock load loader lock locks lsc made mansteel max maxey motorcycle mount mover movers moving neck north oklahoma open over pace parker part parts passport performance phil's pin pins pintal pintle pj polaris power pride prime pro pull race racks ranger razor receiver receivers red rental river rock rocks roofing rzr sacramento sale salecar sales service services shot side single skid sparks specialist spring steel steer stock stroke tail takeuchi tandem tex texas texoma tiger tile tilt tire tires tnt tonneau tool top torsion tote tow towing toy tractor tractors trade trail trailer trailernut trailers trailor trailr transport ttr tugger uhaul un-laden used utility waco weight weld welded welding wells wheel wheels wire wires wiring world ww wyatt xp yamaha ";
		}
		if( has_term( 'trench-digger', 'product_cat', $post_id ))
		{
			$cattag = $cattag . "Alternate terms: 2wd 4wd 4wheeler 4x4 ag all allis artic atv backhoe bad bandit bass behind belarus bell belt big blade blower boat bobcat bomag boom boring box boy breaker bucket bulldozer burying bush by cable camp cart case cat caterpillar cattle chainsaw chalmers champion charles chevy chopper clark compact concrete crane cutter daewood deere dig digger directional dirt ditch dixie dodge dozer dresser drilling eater edger equipment excavation excavator exmark farmall farming ferguson fiat finish food ford forklift forks four frost gator gehl genie go golf gradall grade grader grapple grasshopper gravley grove hedge herrenknecht hitachi hoe hog hole holland honda horse hunting hustler hydro-ax hyster hyundai implements ingersoll international jcb jlg john jon kart kawasaki kioti kobelco komatsu kubota landscape lawn laying lift link loader long lull machine machinery mahindra man massey massy mitsubishi motor mower mowing mule mustang new nissan pigs pipe piping plot plow polaris pole prime rake rand ranger rock rotary rtv saw scag scissor side skid skidder skip snorkel steer stihl takeuchi terex tex tiger tiller toro toyota track tractor trade trailer trencher trimmer truck turn underground utility utv vermeer volvo walk weed wheel wheeler witch works xcmg xtv zero ";
		}
		if( has_term( 'wood-chippers', 'product_cat', $post_id ))
		{
			$cattag = $cattag . "Alternate terms: 1390 1590 15xp 1890 18xp 1990 1990xp 19xp 2090 2090xp 21xp 2400 247 250 254 255 257 259 262 277 279 280 289 299 730 a300 a770 agrifab altec backyard bandit barreto bc1000 bc1000xl bc1400 bc1500 bc1800 bc2000 bear billy bluebird bobcat bosski brush cadet carlton case cat caterpillar cci champion chipper clean cleanup cub deere dosko earthquake earthwise eco enm erskine felled flowtron generac goat grinder holland hurricane husqvarna hydraulic joe john king kubota land m15r m15rx m18r mac machine maskissic master merry mighty morbark new ox patriot power powertek pride products rayco rg50 s175 s185 s205 s250 s300 s570 s590 s650 s750 s770 s850 salsco sc30tx sc852 shredder skid smart southland steer stump sun t190 t250 t300 t320 t590 t650 t770 t870 takeuchi tazz tornado toro track tree troy-bilt twister up vermmer wallenstein winch wood woodchipper woodchuck woodmaxx woodsman yard yardbeast yardmax";
		}
		// inject keywords specifically for sku 14113 product id 103162
		if ( $post_id == 103162 ) {
			$cattag = $cattag . "Alternate terms: ac accept adjustable applications around avionics broad configurations conversion converters development duplication export found frequencies frequency fully import inputs military multiple offer output permits power product range shipboard sources test utility voltage voltages world worldwide";
		}
		if ( $post_id == 100225 ) {
			$cattag = $cattag . "Alternate terms: 100 50 8 amp ampdummy amplifierdummy antenna50 bank bank100 bankac bankbattery bankdc bankelectrical bankgenerator bankload bankloadtec bankmosebach bankportable bankradiator bankresistor banksimplex banksinductive banksuitcase bankuniversal bankused cantennatube dl2kdummy dummy failed for has kw load load100 load100w loadamplifier loadbird loadcb loaddiy loaddummy loadham loadhf loadmfj loadpalstar loadvariable mode mounted ohm ohmdummy phase power radio rentalsavast resistorrf sale3 saleasco salereactive speakerheathkit supply testavtron testingaudio testingload testingsalt testresistive to water watt";
		}*/
		
		$translate = "";
    
    if ( $condition === 3000 )
    {
        $translate = "Used";
    }
    if ( $condition === 7000 )
    {
        $translate = "Item untested, working condition unknown.  Selling as For Parts or Not Working.  May or may not work.";
    }
    if ( $condition === 1500 )
    {
        $translate = "New other";
    }
    if ( $condition === 2500 )
    {
        $translate = "Seller refurbished";
    }
    if ( $condition === 1000 )
    {
        $translate = "New";
    }
    if ( $translate != "" )
    {
        $translate = "
Item Condition:  " . $translate . "
";
    }
		
		// reform the contentchange content description for ebay
		// from all variables for building content
		$vid = get_post_meta( $post_id, '_video', true );
		
		if ($vid != "") {
		$vid_id = substr($vid, 17);
		$sku = get_post_meta( $post_id, '_sku', true );
		$part01 = 'Video of item available here:
<a href="';
		$part02 = '" rel="noopener" target="_blank">';
		$part03 = '</a>

';
		$part1 = '<!-- BEGIN LINKED VIDEO --> <div class="ft_vid"> <a target="youtube" href="https://www.youtube.com/embed/';
		$part2='?rel=0" rel="noopener noreferrer"> <img src="https://img.youtube.com/vi/';
		$part3='/0.jpg"></a><p class="ft_vid_head">CCR';
		$part4='</p> <p class="ft_vid_foot">Video will open in a new window</p> </div> <div class="ft_lnk_div">Using the mobile app? Copy this link into your browser:<br> <input class="ft_lnk" type="text" value="https://www.youtube.com/watch?v=';
		$part5='"></div> <style>.ft_vid { margin:.5em .5em 0 .5em; max-width:480px; font-family:arial; text-align:center; position:relative; min-height:120px; overflow:hidden; background-color:#555; }.ft_vid p { position:absolute; margin:0; color:white; background-color:rgba(0, 0, 0, .5); }.ft_vid .ft_vid_head { font-size:16px; width:100%; height:28px; line-height:28px; text-align:left; top:0; left:0; padding-left:10px; overflow:hidden; }.ft_vid .ft_vid_foot { font-size:11px; width:100%; bottom:22; left:0; }.ft_vid img { display:block; max-width:100%; border:0; }.ft_vid a:after { content:">"; position:absolute; width:60px; height:50px; left:0; top:0; right:0; bottom:0; margin:auto; border:0; border-radius:10px; color:white; background:rgba(0, 0, 0, .6); font-size:24px; line-height:50px; cursor:pointer; }.ft_vid a:hover:after { background:#CC181E; }.ft_lnk_div { margin:-10px 0.5em 0.5em 0.5em; padding-top:5px; max-width:480px; font-family:arial; font-size:12px; text-align:center; position:relative; color:black; background:whitesmoke; }.ft_lnk { /* position:absolute; */ top:100%; left:0; width:100%; text-align:center; padding:.5em .2em; border:0; background:whitesmoke; }</style>
<!-- END LINKED VIDEO -->';
		}
		
		// check to see if content contains a sphere shortcode
		// if yes then cut it out
		if (strpos($contentchange, "[sphere") !== false) {
			$cut = substr($contentchange, strpos($contentchange, ']')+1);
			$contentchange = $cut;
		}
		
		// check to see if content contains a header tag h3
		// if yes then do old style
		if (strpos($content, "<h3>") !== false) {
			$first_part = strstr($contentchange, '<!-- Tag 1 -->', true);
			$second_part = strstr($contentchange, '<!-- Tag 2 -->');
			if ($first_part != "")
			{	
				$contentchange = $first_part . "
" . $part01 . $vid . $part02 . $vid . $part03 . $part1 . $vid_id . $part2 . $vid_id . $part3 . $sku . $part4 . $vid_id . $part5 . "
" . $second_part;
			}
		}
		// if no then do new style
		else {
			$contentchange = '
' . $part01 . $vid . $part02 . $vid . $part03 . $part1 . $vid_id . $part2 . $vid_id . $part3 . $sku . $part4 . $vid_id . $part5 . '
' . $contentchange;
		}
		
		// reform the short description if it contains video embed code
		// check to see if content contains a sphere shortcode
		// if yes then cut it out
		if (strpos($short_desc, "[sphere") !== false) {
			$cut = substr($short_desc, strpos($short_desc, ']')+1);
			$short_desc = $cut;
		}
		$ts = get_post_meta( $post_id, '_threesixty', true );
		$first_part = strstr($short_desc, '<!-- Tag 1 -->', true);
		$second_part = strstr($short_desc, '<!-- Tag 2 -->');
		if ($first_part == "") {
			$first_part2 = strstr($short_desc, '<!--', true);
			$second_part2 = strstr($short_desc, '<!-- END LINKED VIDEO -->');
		}
		
		$part1 = "Video of item available here:
";
		$part2 = "Click here to view item in 360 degrees:
";
		// if tag 1 code is present do this
		if ($first_part != "")
		{	
			// if vid is set and ts is set execute
			if ($vid != "" && $ts != ""){
			$short_desc = $first_part . "

" . $part1 . $vid . "

" . $part2 . $ts . "

" . $second_part;
			}
			// otherwise if only vid is set do this
			else if ($vid != ""){
				$short_desc = $first_part . "

" . $part1 . $vid . "

" . $second_part;
			}
			// otherwise if only ts is set do this
			else if ($ts != ""){
				$short_desc = $first_part . "

" . $part2 . $ts . "

" . $second_part;
			}
			// fall back if vid and ts are both unset
			else {
				$short_desc = $first_part . "
" . $second_part;
			}
		}
		// if old style video code is added do this
		if ($first_part2 != "")
		{
			// if vid is set and ts is set execute
			if ($vid != "" && $ts != ""){
			$short_desc = $first_part2 . "

" . $part2 . $ts . "

" . $second_part2;
			}
			// otherwise if only vid is set do this
			else if ($vid != ""){
				$short_desc = $first_part2 . "

" . $second_part2;
			}
			// otherwise if only ts is set do this
			else if ($ts != ""){
				$short_desc = $first_part2 . "

" . $part2 . $ts . "

" . $second_part2;
			}
			// fall back if vid and ts are both unset
			else {
				$short_desc = $first_part2 . "
" . $second_part2;
			}
		}
		// if the tag 1 or old style video tag are not present
		else
		{
			// if vid is set and ts is set execute
			if ($vid != "" && $ts != ""){
				$short_desc = "
" . $part1 . $vid . "

" . $part2 . $ts . "

" . $short_desc;
			}
			// otherwise if only vid is set do this
			else if ($vid != ""){
				$short_desc = " 
" . $part1 . $vid . "

" . $short_desc;
			}
			// otherwise if only ts is set do this
			else if ($ts != ""){
				$short_desc = "
" . $part2 . $ts . "

" . $short_desc;
			}
		}
		
		// strip out html tags
		$short_desc = strip_tags($short_desc);
		// prepend the permalink and append the tag disclaimer
		// remove the first line ( title ) of the short description (commented out for now) 
		//$short_desc = preg_replace('/^.+\n/', '', $short_desc);
		// copy short description with changes
		$copySD = $short_desc;
		
		$phoneNum = "

931***563
***4704";
		$fbdisclaimer = "
		
Please do not comment on posts.  If you require more information, contact us directly through messenger, phone, or email.
";
		$disclaimer = "
		
See all our ads by searching: ccrind
		
There is a 3% surcharge for all credit / debit card transactions.
Taxes are applicable to all prices.
Local Pickup is available for most items.  
** Local Pickup does not include a 3rd party freight carrier pickup, individual only **
For full terms of services visit our website at ccrind.com";
		
		// take out all business info for "furniture" category
		if( has_term( 'furniture', 'product_cat', $post_id )) 
		{ 
			// kill link and disclaimer
			$link = ""; $disclaimer = "";
			// alter phone to Dan's
			$phoneNum = "
		
931***581
***2318";
			// remove final line of short description containing the CCR number
			$short_desc = substr($short_desc, 0, strrpos($short_desc, "\n"));
		} 
		
		// form the rest of the short description
		if ($translate == "")
		{
			$short_desc = $title . $link . $phoneNum . $furnitureTag . $fbdisclaimer . $clothtag . "
" . $short_desc . $disclaimer;
			
			$product->set_short_description( $short_desc ); // Add/Set the new short description
			if ($cattag != ""){
				$cattag = "
				
				
				
" . $cattag;
			}
			$short_desc = $short_desc . $cattag;
			
			// set sdcp short description with keywords category tag
			update_post_meta( $post_id, '_sdcp', esc_attr( $short_desc ) );
			update_post_meta( $post_id, '_ebaydescription', esc_attr( $contentchange ) );
			update_post_meta( $post_id, 'old_content', esc_attr( $content ) );
			 
		}
		else
		{
			$short_desc = $title . $link . $phoneNum . $furnitureTag . $fbdisclaimer . $clothtag . "
" . $short_desc . $disclaimer;
			
			//unhook this function
			remove_action('save_post_product', 'sd_on_product_save', 10, 3);
			$product->set_short_description( $short_desc ); // Add/Set the new short description
			//wp_update_post( array('ID' => $post_id, 'post_excerpt' => $short_desc ) );
			if ($cattag != ""){
			$short_desc = $short_desc . "
			
			
			
			
" . $cattag;}
			
			// set sdcp short description with keywords category tag
			update_post_meta( $post_id, '_sdcp', esc_attr( $short_desc ) );
			update_post_meta( $post_id, '_ebaydescription', esc_attr( $contentchange ) );
			update_post_meta( $post_id, 'old_content', esc_attr( $content ) );
		}
		// save short description changes
		remove_action('save_post_product', 'sd_on_product_save', 10, 3);
		$product->save();
		
			// start creation of text log changes
			global $current_user;
    		wp_get_current_user();
			$email = $current_user->user_email; 
			$lastuser = $current_user->user_firstname;
			$tableupdate = array();
			
			$msg = $lastuser . " saved item data.  
Saved in PRODUCT PAGE.
";	
			// begin building the rest of $msg using comparisons
			$sku = trim(esc_attr( $_REQUEST['_sku'] )); if ($sku =="") { /* do nothing */ } else {
			$osku = get_post_meta( $post_id, '_sku', true );
			if ($osku != $sku) { $msg = $msg . "
SKU:				 CHANGED: " . $osku . " ==> " . $sku; array_push( $tableupdate, array("SKU", $osku, $sku) ); }
			else { $msg = $msg . "
SKU:				" . $sku; } }
		
			$price = trim(esc_attr( $_REQUEST['_regular_price'] )); if ($price =="") { /* do nothing */ } else {
			$oprice = $product->get_regular_price();
			if ($oprice != $price) { $msg = $msg . "
PRICE:				 CHANGED: " . $oprice . " ==> " . $price; array_push( $tableupdate, array("PRICE", $oprice, $price) );
			} }
		
			$qty = trim(esc_attr( $_REQUEST['_stock'] )); if ($qty =="") { /* do nothing */ } else {
			$oqty = $product->get_stock_quantity();
			if ($oqty != $qty && $oqty != "" && $qty != "") { $msg = $msg . "
QTY:				 CHANGED: " . $oqty . " ==> " . $qty; array_push( $tableupdate, array("QUANTITY", $oqty, $qty) );
				if ($qty == 0){
					$to = "jedidiah@ccrind.com";
					$subject = "CCR Item Forced to OUT OF STOCK, SKU:" . $product->get_sku();
					$message = "SKU:  " . $product->get_sku() . " stock level set to 0 by " . $email . "\n
In Product Page.\n
Item: " . $product->get_name();
		
					wp_mail( $to, $subject, $message );
				}
				if ($qty > 0){
					$to = "jedidiah@ccrind.com";
					$subject = "CCR Item QTY changed, SKU:" . $product->get_sku();
					$message = "SKU:  " . $product->get_sku() . " stock level set to ". $qty . " by " . $email . "\n";
		
					wp_mail( $to, $subject, $message );
				}
			} }
		
			$cost = trim(esc_attr( $_REQUEST['_cost'] )); if ($cost =="") { /* do nothing */ } else {
			$ocost = trim(get_post_meta( $post_id, '_cost', true ));
			if ($ocost != $cost) { $msg = $msg . "
COST:				 CHANGED: " . $ocost . " ==> " . $cost; array_push( $tableupdate, array("COST", $ocost, $cost) ); } }
		
			$wl = trim(esc_attr( $_REQUEST['_warehouse_loc'] )); if ($wl =="") { /* do nothing */ } else {
			$owl = trim(get_post_meta( $post_id, '_warehouse_loc', true ));
			$wl = strtoupper($wl);
			if ($owl != $wl) { $msg = $msg . "
WH LOC:				 CHANGED: " . $owl . " ==> " . $wl; array_push( $tableupdate, array("WAREHOUSE LOCATION", $owl, $wl) ); } }
		
			$tested = trim(esc_attr( $_REQUEST['_tested'] )); if ($tested =="") { /* do nothing */ } else {
			$otested = trim(get_post_meta( $post_id, '_tested', true ));
			if ($otested != $tested) { $msg = $msg . "
TESTED?:			 CHANGED: " . $otested . " ==> " . $tested; array_push( $tableupdate, array("TESTED?", $otested, $tested) ); } }
		
			$lister = trim(esc_attr( $_REQUEST['_preparers_initials'] )); if ($lister =="") { /* do nothing */ } else {
			$olister = trim(get_post_meta( $post_id, '_preparers_initials', true ));
			$lister = strtoupper($lister);
			if ($olister != $lister) { $msg = $msg . "
LISTER:				 CHANGED: " . $olister . " ==> " . $lister; array_push( $tableupdate, array("LISTER", $olister, $lister) ); } }
		
    		$brand = trim(esc_attr( $_REQUEST['_ccrind_brand'] )); if ($brand =="") { /* do nothing */ } else {
			$obrand = trim(get_post_meta( $post_id, '_ccrind_brand', true ));
			if ($obrand != $brand) { $msg = $msg . "
BRAND:				 CHANGED: " . $obrand . " ==> " . $brand; array_push( $tableupdate, array("BRAND", $obrand, $brand) ); } }
		
    		$mpn = trim(esc_attr( $_REQUEST['_ccrind_mpn'] )); if ($mpn =="") { /* do nothing */ } else {
			$ompn = trim(get_post_meta( $post_id, '_ccrind_mpn', true ));
			if ($ompn != $mpn) { $msg = $msg . "
MODEL:				 CHANGED: " . $ompn . " ==> " . $mpn; array_push( $tableupdate, array("MODEL", $ompn, $mpn) ); } }
		
			$vid = trim(esc_attr( $_REQUEST['_video'] )); if ($vid =="") { /* do nothing */ } else {
			$ovid = get_post_meta( $post_id, '_video', true );
			if ($ovid != $vid) { $msg = $msg . "
VIDEO:				 CHANGED: " . $ovid . " ==> " . $vid; array_push( $tableupdate, array("VIDEO", $ovid, $vid) ); } }
		
			$auc = trim(esc_attr( $_REQUEST['_auction'] )); if ($auc =="") { /* do nothing */ } else {
			$oauc = get_post_meta( $post_id, '_auction', true );
			if ($oauc != $auc) { $msg = $msg . "
AUCTION:			 CHANGED: " . $oauc . " ==> " . $auc; array_push( $tableupdate, array("AUCTION", $oauc, $auc) ); } }
		
			$aucdate = trim(esc_attr( $_REQUEST['_auction_date'] )); if ($aucdate =="") { /* do nothing */ } else {
			$oaucdate = get_post_meta( $post_id, '_auction_date', true );
			if ($oaucdate != $aucdate) { $msg = $msg . "
AUC DATE:			 CHANGED: " . $oaucdate . " ==> " . $aucdate; array_push( $tableupdate, array("AUCTION DATE", $oaucdate, $aucdate) ); } }
		
			$lsn = trim(esc_attr( $_REQUEST['_lsn'] )); if ($lsn =="") { /* do nothing */ } else {
			$olsn = get_post_meta( $post_id, '_lsn', true );
			if ($olsn != $lsn) { $msg = $msg . "
LSN:				 CHANGED: " . $olsn . " ==> " . $lsn;  array_push( $tableupdate, array("LSN", $olsn, $lsn) ); } }
		
			$lsnlink = trim(esc_attr( $_REQUEST['_lsnlink'] )); if ($lsnlink =="") { /* do nothing */ } else {
			$olsnlink = get_post_meta( $post_id, '_lsnlink', true );
			if ($olsnlink != $lsnlink) { $msg = $msg . "
LSN LINK:			 CHANGED: " . $olsnlink . " ==> " . $lsnlink; array_push( $tableupdate, array("LSN LINK", $olsnlink, $lsnlink) ); } }
			
			$fbmp = trim(esc_attr( $_REQUEST['_fbmp'] )); if ($fbmp =="") { /* do nothing */ } else {
			$ofbmp = get_post_meta( $post_id, '_fbmp', true );
			if ($ofbmp != $fbmp) { $msg = $msg . "
FB:					 CHANGED: " . $ofbmp . " ==> " . $fbmp; array_push( $tableupdate, array("FB", $ofbmp, $fbmp) ); } }
		
			$ei = trim(esc_attr( $_REQUEST['_extra_info'] )); if ($ei =="") { /* do nothing */ } else {
			$oei = get_post_meta( $post_id, '_extra_info', true );
			if ($oei != $ei) { $msg = $msg . "
EXTRA INFO:			 CHANGED: " . $oei . " ==> " . $ei; array_push( $tableupdate, array("EXTRA INFO", $oei, $ei) ); } }
		
			$soldby = trim(esc_attr( $_REQUEST['_soldby'] )); if ($soldby =="") { /* do nothing */ } else {
			$osoldby = get_post_meta( $post_id, '_soldby', true );
			if ($osoldby != $soldby) { $msg = $msg . "
SOLD BY:			 CHANGED: " . $osoldby . " ==> " . $soldby; array_push( $tableupdate, array("SOLD BY", $osoldby, $soldby) ); } }
		
		$updatedesc = $msg;
		$changeloc = "Product Page Edit";
		// create text log of change
		make_product_change_logs($product, $salesrecord, $updatedesc, $tableupdate, $email, $lastuser, $changeloc);
		/*$skul = strlen($sku);
		if ($skul > 4) { $sku_2 = substr($sku, 0, 2); $sku_3 = substr($sku, 2, 1); }
		else if ($skul == 4) { $sku_2 = substr($sku, 0, 1); $sku_3 = substr($sku, 1, 1); }
		else { $sku_2 = $sku; $sku_3 = $sku; }
		
		if ( !file_exists("../library/product-change-logs/$sku_2/$sku_3/") ) { 
			mkdir("../library/product-change-logs/$sku_2/$sku_3/", 0744, true);
		}
		$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.txt","a");
		echo fwrite($file, "\n" . date('Y-m-d h:i:s', current_time( 'timestamp', 0 ) ) . " --- " . $lastuser . $msg. "
		
");
		fclose($file);
		
		// create update log table from existing array
		$tabledatarows = "";
		for ( $i=0; $i < count($tableupdate); $i++ ) {
			$tabledatarows = $tabledatarows ."
	<tr>
		";
			for ( $j=0; $j < 3; $j++ ) {
				$tabledatarows = $tabledatarows ."
		<td>". $tableupdate[$i][$j] ."</td>
		";
			}
	$tabledatarows = $tabledatarows ."
	</tr>
";
		}
		
		// html table product change log
		// if the file doesnt exist, format html with page title and table header cells
		if ( !file_exists("../library/product-change-logs/$sku_2/$sku_3/$sku.html") ) {
			$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.html","a");
			echo fwrite($file, "
<!DOCTYPE html>
<html>
<head>
<style>
td, th { border: 1px solid #dddddd; text-align: left; padding: 8px; }
th { background-color: #dddddd; }
.pl_table_title { font-size: 20px; font-weight: heavy; }
.pl_userJedidiah { color: #ffffff; background-color: #535f9b; border-radius: 10px; padding: 2px; }
.pl_userSharon { color: #002eff; background-color: #b3c0ff; border-radius: 10px; padding: 2px; }
.pl_userDan { color: #ffffff; background-color: #000000; border-radius: 10px; padding: 2px; }
.pl_userKelsey { color: #ffffff; background-color: #4ea33c; border-radius: 10px; padding: 2px; }
.pl_userRyan { color: #ffffff; background-color: #33718f; border-radius: 10px; padding: 2px; }
.pl_userAdam{ color: #ffffff; background-color: #3ca39f; border-radius: 10px; padding: 2px; }
</style>
<body>
<h2>SKU: $sku UPDATE LOG </h2>
<table>
	<tr>
		<th align='center' colspan='3'>". date('Y-m-d h:i:s', current_time( 'timestamp', 0 ) ) ." --- ". $email ." / ". $lastuser ." --- Product Page Edit</th>
	</tr>
	<tr>
		<th>Attribute Changed:</th>
		<th>Old Value:</th>
		<th>Updated Value:</th>
	</tr>
	$tabledatarows
</table>

");
		fclose($file);
		}
		// if the file exists, only add another table of product change updates
		else {
			// open the file
			$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.html","c+");
			$found = false; // flag to verify if string is found
			$find = "</h1>";  // string to find
			$filecontents = "";
			// read through the file until $find is found
			while ( ($line = fgets($file))  != false ) {
				// once $find is found, read all the lines into the $filecontents variable
				if ($found) {
					$filecontents = $filecontents . $line;
					continue;
				}
				if ( strpos( $line, $find) !== false ) {
					$found = true;
				}
			}
			fclose($file); // close the reading of file
			// open the file and create it fresh to rebuild the file entirely
			$file = fopen("../library/product-change-logs/$sku_2/$sku_3/$sku.html","w");
			echo fwrite($file, "
<!DOCTYPE html>
<html>
<head>
<style>
td, th { border: 1px solid #dddddd; text-align: left; padding: 8px; }
th { background-color: #dddddd; }
.pl_table_title { font-size: 20px; font-weight: heavy; }
.pl_userJedidiah { color: #ffffff; background-color: #535f9b; border-radius: 10px; padding: 2px; }
.pl_userSharon { color: #002eff; background-color: #b3c0ff; border-radius: 10px; padding: 2px; }
.pl_userDan { color: #ffffff; background-color: #000000; border-radius: 10px; padding: 2px; }
.pl_userKelsey { color: #ffffff; background-color: #4ea33c; border-radius: 10px; padding: 2px; }
.pl_userRyan { color: #ffffff; background-color: #33718f; border-radius: 10px; padding: 2px; }
.pl_userAdam{ color: #ffffff; background-color: #3ca39f; border-radius: 10px; padding: 2px; }
</style>
<body>
<h1>SKU: $sku UPDATE LOG </h1>
<div class='pl_table_title'>". date('Y-m-d    h:i:s', current_time( 'timestamp', 0 ) ) ." --- ". $email ." / <text class='pl_user$lastuser'>&nbsp;". $lastuser ."&nbsp;</text> --- Product Page Edit</div>
<table>
	<tr>
		<th>Attribute Changed:</th>
		<th>Old Value:</th>
		<th>Updated Value:</th>
	</tr>
	$tabledatarows
</table>
<br>
$filecontents
");
		fclose($file);
		}*/
	} /* if ( $type */
	
	$lastuser = $current_user->user_firstname;
	update_post_meta( $post_id, '_last_user', wc_clean( $lastuser ) );
	update_post_meta( $post_id, '_last_changed_field', wc_clean( $msg ) );
	update_post_meta( $post_id, '_last_change_desc', wc_clean( "" ) );
	
	// re-hook this function
    //add_action('save_post', 'sd_on_product_save', 10, 3 );
}
/* end of auto generation of product short description */
?>