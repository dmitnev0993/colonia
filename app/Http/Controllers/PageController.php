<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PageController extends Controller
{
    public function queryResidential(Request  $request) {
        $arr = false;
        if (!empty($request->quote)) {

            $arr = DB::table('sp_strata', 'n')
                ->select('n')
                ->where('n.quote', $request->quote)
                ->first();
            $arr = (array) $arr;
//            $arr = db_select('sp_strata', 'n')
//                ->fields('n')
//                ->condition('n.quote', $post['quote'])
//                ->execute()
//                ->fetchAssoc();
        } else if (isset($_COOKIE['spUser'])) {
            $arr = DB::table('sp_strata', 'n')
                ->select('*')
                ->where('n.quote', $_COOKIE['spUser'])
                ->first();
            $arr = (array) $arr;
//            $arr = db_select('sp_strata', 'n')
//                ->fields('n')
//                ->condition('n.quote', $_COOKIE['spUser'])
//                ->execute()
//                ->fetchAssoc();

            if (!$arr || empty($arr['quote'])) {
                setcookie('spUser', '1', time() - 10, '/');
            }
        }

        if (!$arr) {


            $id = DB::table('sp_strata')->insertGetId(['s01' => '']);
//            $id = db_insert('sp_strata')
//                ->fields(array("s01" => ''))
//                ->execute();

            $quote = $this->bizsure_rand() . $id;
            DB::table('sp_strata', 'n')
                ->where('id', $id)
                ->update([
                'quote' => $quote
            ]);



//            db_update('sp_strata')
//                ->fields(array("quote" => $quote))
//                ->condition('id', $id)
//                ->execute();


            $arr = DB::table('sp_strata', 'n')
                ->select('*')
                ->where('n.quote', $quote)
                ->first();
            $arr = (array) $arr;

//            $arr = db_select('sp_strata', 'n')
//                ->fields('n')
//                ->condition('n.quote', $quote)
//                ->execute()
//                ->fetchAssoc();

            setcookie('spUser', $quote, time() + 604800, '/');
        }

        $content = '';

        $db_fields = array('s01', 's02', 's03', 's04', 's05', 's06', 's07', 's011', 's012', 's013', 's11', 's12', 's13', 's14', 's21', 's22', 's22state', 's23', 's24', 's25', 's24_type', 's25_type', 's26', 's27', 's28', 's28u', 's28ulink', 's29', 's29_other', 's29_1', 's29_2', 's29_3', 's210', 's211', 's212', 's213', 's214', 's215', 's216', 's217', 's217_1', 's217_2', 's217_3', 's217_4', 's217a', 's218', 's218_yes', 's219', 's2191', 's220', 's221', 's222', 's223', 's224', 's31', 's32', 's331', 's332', 's333', 's33', 's334', 's34', 's35', 's36', 's37', 's38', 's39', 's310', 's311', 'volunteer', 'proman');

        $fields = array();

        foreach ($request->all() as $key => $value) {
            if (in_array($key, $db_fields)) {
                $fields[$key] = $value;
                $arr[$key] = $value;
            }
        }




        if($request->block == 'block0'){
            $fields['li0'] = 1;
        }else if($request->block == 'block1'){
            $fields['li1'] = 1;
            $claims = array();
            for ($i = 1; $i <= intval($request->s11); $i ++) {
                $claims['s13' . $i . '1'] = $request->{'s13' . $i . '1'};
                $claims['s13' . $i . '2'] = $request->{'s13' . $i . '2'};
                $claims['s13' . $i . '3'] = $request->{'s13' . $i . '3'};
            }

            $fields['s13'] = json_encode($claims);
        }else if($request->block == 'block2'){
            $fields['li2'] = 1;
        }else if($request->block == 'block3'){
            $fields['li3'] = 1;
        };

        if (!empty($fields) && !empty($arr['quote'])) {
            DB::table('sp_strata')
                ->where('quote', $arr['quote'])
                ->update($fields);

//            db_update('sp_strata')
//                ->fields($fields)
//                ->condition('quote', $arr['quote'])
//                ->execute();
        }



        $lastblock = intval($arr['li0'])+intval($arr['li1'])+intval($arr['li2'])+intval($arr['li3']);

        if (($request->id=='li0')||(($request->id=='prev')&&($request->block=='block1'))) {
            $content .= '
				<h2 class="h2" id="block0">Colonial strata insurance</h2>
				<fieldset class="top_level"><legend id="legend1">Policy details</legend>
					<div>
						<div class="mandatory inline">
							<label class="top">Policy period</label>
							<input type="text" name="s01" id="s01" class="calendar element short" value="'.$arr['s01'].'" readonly="readonly" /><span class="to">to</span>
						</div>
						<div class="inline">
							<input type="text" name="s02" id="s02" class="element short" value="'.$arr['s02'].'" readonly="readonly" />
						</div>
					</div>';
            $content .= sp_select_other('Who are you insured with', $name='s03', 'Please Select;AMP;Allianz;CHU;Calliden;Chubb;Lumley;None - previosly uninsured;QBE;SUU;Vero;Zurich', 'mandatory', $arr['s03'], $arr['s03_other']);
            $content .= sp_radio_yn('Is this insurance required for Common Property only?', $name='s0', 'no', 'no');
            $content .= '
				</fieldset>
				<fieldset class="top_level"><legend id="legend1">Insured details</legend>
					<div class="mandatory">
						<label class="top">SP or CTS or OC number</label>
						<input type="text" name="s04" id="s04" value="'.$arr['s04'].'" class="element" />
					</div>
					<div class="mandatory">
						<label class="top">Email</label>
						<input type="text" name="s05" id="s05" value="'.$arr['s05'].'" class="element" />
					</div>
					<div class="mandatory">
						<label class="top">Contact number</label>
						<input type="text" name="s06" id="s06" value="'.$arr['s06'].'" class="element" />
					</div>
					<div class="mandatory">
						<label class="top">Contact name</label>
						<input type="text" name="s07" id="s07" value="'.$arr['s07'].'" class="element" />
					</div>
				</fieldset>
				<input type="hidden" class="lastblock" id="" value="'.$lastblock.'" />';
        }

        if ($request->s0 == 'yes') {
            $content .= '<h2 class="h2" id="block10">Unfortunately we are not offering Common Property Stand alone cover.</h2>';
        } else if (($request->id=='li1')||(($request->id=='prev')&&($request->block=='block2'))||(($request->id=='next')&&($request->block=='block0'))) {
            $content .= '
		<h2 class="h2" id="block1">Claims history</h2>
		<fieldset class="top_level"><legend>Claims details (within past 5 years)</legend>
			<div class="mandatory">
				<label class="top">Number of claims</label>
				<input type="text" name="s11" id="s11" value="'.$arr['s11'].'" class="element" />
			</div>
			<div class="currency">
				<label class="top">Total incurred cost of claims</label>
				<input type="text" name="s12" id="s12" value="'.$arr['s12'].'" class="element" readonly="readonly" />
			</div>
			<div id="claimsdetails"></div>
			<div class="hidden" id="s13_total">'.$arr['s13'].'</div>
			<input type="hidden" class="element" id="s14" name="s14" value="'.$arr['s14'].'" />
		</fieldset>
		<input type="hidden" class="lastblock" id="" value="'.$lastblock.'" />';
        }

        if (($request->id=='li2')||(($request->id=='prev')&&($request->id=='block3'))||(($request->id=='next')&&($request->block=='block1'))) {
            $content .= '
		<h2 class="h2" id="block2">Situation</h2>
		<fieldset class="top_level"><legend>Situation address</legend>
			<div class="finder relative';
            if($arr['s21']=='') $content .= ' mandatory';
            $content .= '
			" id="d-finder">
				<label for="finder" class="top">Please enter Postcode or Suburb:</label>
				<input name="finder" id="finder" value="" class="element waitno" />
				<div id="postcode"></div>
			</div>
			<div class="s22state element-div';
            if($arr['s21']=='') $content .= ' hidden';
            $content .= '
			" id="d-s22state">
				<label class="top" for="s22state">State:</label>
				<input name="s22state" id="s22state" value="'.$arr['s22state'].'" class="element" readonly="readonly" />
			</div>
			<div class="s21 element-div';
            if($arr['s21']=='') $content .= ' hidden';
            $content .= '
			" id="d-s21">
				<label class="top" for="s21">Postcode:</label>
				<input name="s21" id="s21" value="'.$arr['s21'].'" class="element" readonly="readonly" />
			</div>
			<div class="s22 element-div';
            if($arr['s21']=='') $content .= ' hidden';
            $content .= '
			" id="d-s22">
				<label class="top" for="s22">Suburb:</label>
				<input name="s22" id="s22" value="'.$arr['s22'].'" class="element" readonly="readonly" />
			</div>
			<div class="s23 element-div">
				<label class="top">Building name</label>
				<input type="text" name="s23" id="s23" value="'.$arr['s23'].'" class="element" />
			</div>';
            $content .= sp_select('Street Number Type', $name='s24_type', 'Please Select;LOT;NO;RMB;RMS', 'mandatory', $arr['s24_type']);
            $content .= sp_input('Street Number', $name='s24', 'mandatory digit', $arr['s24']);
            $content .= sp_input('Street Name', $name='s25', 'mandatory', $arr['s25']);
            $content .= sp_select('Street Type', $name='s25_type', 'Please Select;STREET;ROAD;AVENU;CLOSE;PLACE;TERRACE;WATERS;WYND;WAKLWAY;WALK;WAY;VIEW;VISTA;UNDERPASS;TOLLWAY;TURN;TRAIL;TRACK;TOR;TARN;TERRACE;SERVICEWAY;STREETS;STRIP;STATION;SUITE;STREET;SQUARE;SIDING;STRAND;RUN;RIGHTOFWAY;ROUTE;RETREAT;REST;ROW;ROUND;RISE;RIDGEWAY;RESERVE;ROADWAY;ROADS;RIDGE;ROAD;REACH;RAMBLE;QUAY;QUADRANGLE;QUADRANT;PARKWAY;PATH;PORT;PASS;PROMENADE;POINT;PLAZA;PLACE;POCKET;PARK;PATHWAY;PARADE;BLANKS;ALLEY;APPROACH;ARCADE;AVENUE;BOULEVARD;BEND;BYPASS;BRACE;BRAE;BROOK;BROADWAY;CIRCUIT;CHASE;CIRCLE;CREEK;CLOSE;COMMON;CONCOURSE;CORNER;COPSE;CIRCUS;CRESCENT;CROSS;CROSSING;CORSO;CREST;COURT;CUTTING;CENTRE;COVE;CAUSEWAY;COURTYARD;DALE;DRIVE;DRIVEWAY;EDGE;ELBOW;END;ENTRANCE;ESPLANADE;ESTATE;EXPRESSWAY;FAIRWAY;FALLOW;FRONTAGE;FREEWAY;GARDEN;GLADE;GLEN;GRANGE;GROUND;GREEN;GATE;GROVE;HILL;HEIGHTS;HIGHWAY;JUNCTIONKEY;LANE;LINK;LOOP;MEANDER;MALL;MOUNT;MEWS;MOTORWAY;NOOK;OUTLOOK', 'mandatory', $arr['s25_type']);
            $content .= '
		</fieldset>
		<fieldset class="top_level"><legend>Building information</legend>';
            $content .= sp_select('Type of title', $name='s26', 'Please Select;Awaiting registration;Registered Strata Title;Company Title', 'mandatory', $arr['s26']);
            $content .= sp_select('Type of building', $name='s27', 'Please Select;Single building;Townhouse/Duplex/Villa', 'mandatory', $arr['s27']);
            $content .= sp_input('Year built', $name='s28', 'mandatory', $arr['s28']);
            $u28hidden = (intval($arr['s28']) > 0 && intval($arr['s28']) <= 1985) ? '' : ' hidden';
            $content .= '
		<div class="s28ulink' . $u28hidden . '" style="margin-bottom:20px;">
			<input class="hidden" type="file" id="s28ulinkFile">';
            if ($arr['s28ulink']) {
                $content .= '<label class="top">Please upload your strata claims history on underwriters papers for the last 5 years</label><button type="button" style="margin-right:20px;">Upload another document</button>';
                $content .= '<a target="_blank" href="' . $arr['s28ulink'] . '">Uploaded file</a>';
            } else {
                $content .= '<label class="top">Please upload your strata claims history on underwriters papers for the last 5 years</label><button type="button" style="margin-right:20px;">Upload document</button>';
            }
            $content .= '
			<input type="hidden" class="element" type="file" id="s28ulink" name="s28ulink" value="' . $arr['s28ulink'] . '">
		</div>
		';
            $content .= sp_select_other_custom('Walls', $name='s29', 'Please Select;Concrete;Brick;Double Brick;Rendered Brick;Besser Block;Iron Sheet on Steel Frame;Timber;Fibro;Asbestos Sheeting', 'Mixed Constructions – less than 50% brick, clock or concrete ( please provide details);Mixed Constructions – greater than 50% brick, clock or concrete ( please provide details);Other – please provide details', 'mandatory', $arr['s29'], $arr['s29_other']);
            $content .= '<div style="font-size: 16px;padding: 20px 0 0;">Does the construction material use any of the following to an amount greater than 25% of the external wall:</div>';
            $content .= sp_checkbox('EPS', $name='s29_1', '', $arr['s29_1']);
            $content .= sp_checkbox('Composite cladding/facade', $name='s29_2', '', $arr['s29_2']);
            $content .= sp_checkbox('Light weight rendered cladding', $name='s29_3', '', $arr['s29_3']);
            $content .= '<div style="margin-top:15px"></div>';
            $content .= sp_select_other('Roof', $name='s210', 'Please Select;Concrete;Fibro;Tile;Timber;Colour Bond;Steel/Metal/Iron;Asbestos Sheeting', 'mandatory', $arr['s210'], $arr['s210_other']);
            $content .= sp_select_other('Floor', $name='s211', 'Please Select;Concrete;Timber;Concrete ground floor, timber upper floor', 'mandatory', $arr['s211'], $arr['s211_other']);
            $content .= sp_radio_ppd('Does the building contain any asbestos?', $name='s222', 'mandatory', $arr['s222']);
            $content .= sp_radio_ppd('Has there been any Expanded Polystyrene (EPS), Aluminium Composite Panelling (ACP) or like materials used in the construction of the property?', $name='s223', 'mandatory', $arr['s223']);
            $content .= sp_radio_ppd('Are there any building defects?', $name='s224', 'mandatory', $arr['s224']);
            $content .= '
			<fieldset class="second_level"><legend>Please enter the number of:</legend>';
            $content .= sp_input('Units', $name='s212', 'mandatory digit', $arr['s212']);
            $content .= sp_input('Lifts', $name='s213', 'mandatory digit', $arr['s213']);
            $content .= sp_input('Gyms', $name='s214', 'mandatory digit', $arr['s214']);
            $content .= sp_input('Pools', $name='s215', 'mandatory digit', $arr['s215']);
            $content .= sp_input('Tennis courts', $name='s216', 'mandatory digit', $arr['s216']);
            $content .= sp_input('Storeys', $name='s217', 'mandatory digit', $arr['s217']);

            $content .= sp_input('Number of Floors above ground', $name='s217_1', 'mandatory digit', $arr['s217_1']);
            $content .= sp_input('Number of Basement Levels', $name='s217_2', 'mandatory digit', $arr['s217_2']);
            $content .= sp_input('Number of car stackers', $name='s217_3', 'mandatory digit', $arr['s217_3']);
            $content .= sp_radio_yn('Is the property located directly adjacent to, or does the property contain: a lake, pond, river, canal, ocean or waterway?', $name='s217_4', 'mandatory', $arr['s217_4']);


            $content .= sp_radio_yn('Do you require cover for floating floors? ', $name='s217a', 'no', $arr['s217a']);
            $content .='
			</fieldset>';
            $content .= sp_radio_ppd('Does the property have any of the following: jetties, marinas, pontoons, lakes, water features, playgrounds etc?', $name='s218', 'mandatory', $arr['s218']);
            $content .='
		</fieldset>
		<fieldset class="top_level"><legend>Building usage</legend>';
            $content .= sp_select('What percentage of total floor space does the property contain business activities?', $name='s219', 'Please Select;0%;1-15%;Greater than 15%', 'mandatory', $arr['s219']);
            $hidden_2191 = $arr['s219'] == '0%' ? 'hidden' : 'mandatory';
            $content .= sp_textarea('Please provide details', $name='s2191', $hidden_2191, $arr['s2191']);
            $content .= sp_select('What percentage of the property is occupied as Holiday Letting?', $name='s220', 'Please Select;0%;1-30%;Greater than 30%', 'mandatory', $arr['s220']);
            $content .= sp_radio_yn('Does the property have a full time on site manager/care taker?', $name='s221', 'mandatory', $arr['s221']);
            $content .= '
		<input type="hidden" class="lastblock" id="" value="'.$lastblock.'" />';
        }

        if (($request->id=='li3')||(($request->id=='next')&&($request->block=='block2'))) {
            $content .= '
		<h2 class="h2" id="block3">Risks</h2>
		<fieldset class="top_level"><legend>Coverage details</legend>
			<div class="currency mandatory">
				<label class="top">Building sum insured</label>
				<input type="text" id="s31" name="s31" value="'.$arr['s31'].'" class="element" />
			</div>
			<div class="currency">
				<label class="top">Common contents</label>
				<input type="text" id="s32" name="s32" value="'.$arr['s32'].'" class="element" />
			</div>';
            $content .= sp_radio_yn('Loss of rent / temp. accommodation required', $name='s331', 'mandatory', $arr['s331']);
            $content .= sp_radio_yn('Loss of market value required', $name='s332', 'mandatory', $arr['s332']);
            $content .= sp_radio_yn('Floating floorboards cover required', $name='s333', 'mandatory', $arr['s333']);
            $content .= sp_radio_yn('Catastrophe cover', $name='s33', 'mandatory', $arr['s33']);
            $content .= sp_radio_yn('Flood Cover required', $name='s334', 'mandatory', $arr['s334']);
            $content .= sp_select('Legal liability', $name='s34', '10,000,000;15,000,000;20,000,000', 'mandatory currency', $arr['s34']);
            $content .= sp_select('Office bearers liability', $name='s35', 'Please Select;100,000;250,000;500,000;1,000,000;2,000,000;5,000,000;7,500,000;10,000,000;20,000,000', 'currency', $arr['s35']);
            $content .= sp_select('Fidelity guarantee', $name='s36', 'Please Select;50,000;100,000', 'currency', $arr['s36']);
            //$content .= sp_input('Weekly', $name='s38', 'hidden currency', $arr['s38']);
            //$content .= sp_select('Body corporate entity liability', $name='s39', 'Not insured;100,000', 'currency', $arr['s39']);
            $content .= sp_select('Machinery breakdown', $name='s310', 'Please Select;Not insured;100,000', 'currency', $arr['s310']);
            $content .= sp_select('Your Current Excess', $name='s311', 'Please Select;0;100;200;300;500;750;1,000;2,500', 'currency mandatory', $arr['s311']);
            $content .= sp_radio_yn('Do you require cover for Personal Accident for Volunteer Workers?', $name='volunteer', '', $arr['volunteer']);
            if($arr['volunteer'] == 'yes'){
                $weekly_hidden = '';
            }else{
                $weekly_hidden = 'hidden ';
            }
            $content .= sp_input('Weekly/Capital Benefit', 'weekly', $weekly_hidden.'readonly', '$2000/200000');
            $content .= sp_radio_yn('Professionally managed', $name='proman', '', $arr['proman']);
            $content .= '
		<input type="hidden" class="lastblock" id="" value="'.$lastblock.'" />';
        }


        if($request->id=='submit'){
            $content .= '
		<h2 class="h2" id="block4"></h2>
		<p>Thank you for submitting your Quote Request.</p>
		<p>Your Quote number is ' . $arr['quote'] . '</p>
		<p>Our staff will contact with our best quote shortly.</p>';
            $mail = array();
            $mail['address'] = array('support@colonialinsurance.com.au');
            $mail['subject'] = 'New Strata Form submission. Quote number ' . $arr['quote'];
            $message = '
		<h2>New submission data</h2>
		Policy period - ' . $arr['s01'] . ' to  - ' . $arr['s02'] . '<br />
		Who are you insured with - ' . $arr['s03'] . '<br />
		SP or CTS or OC number - ' . $arr['s04'] . '<br />
		Email - ' . $arr['s05'] . '<br />
		Contact number - ' . $arr['s06'] . '<br />
		Contact name - ' . $arr['s07'] . '<br />
		<h3>Claims history</h3>
		Number of claims - ' . $arr['s11'] . '<br />
		Total incurred cost of claims - ' . number_format($arr['s12'], 2, '.', ' ') . '<br />';
            if($arr['s11']>0){
                $json = json_decode($arr['s13']);
                $sum = 0;
                for($i=1; $i <= $arr['s11']; $i ++){
                    $sum += floatval($json->{'s13' . $i . '3'});
                    $message .= $json->{'s13' . $i . '1'} . ' -  - ' . $json->{'s13' . $i . '2'} . ' - $ - ' . $json->{'s13' . $i . '3'} . '<br />';
                }
                $message .= 'Total calculated - ' . number_format($sum, 2, '.', ' ');
            }
            $message .= '
		<h3>Situation</h3>
		Postcode - ' . $arr['s21'] . '<br />
		State - ' . $arr['s22state'] . '<br />
		Suburb - ' . $arr['s22'] . '<br />
		Building name - ' . $arr['s23'] . '<br />
		Street No Type - ' . $arr['s24_type'] . '<br />
		Street No - ' . $arr['s24'] . '<br />
		Street name - ' . $arr['s25'] . '<br />
		Street Type - ' . $arr['s25_type'] . '<br />
		Type of title - ' . $arr['s26'] . '<br />
		Type of building - ' . $arr['s27'] . '<br />
		Year built - ' . $arr['s28'] . '<br />';
            if ($arr['s28ulink']) {
                $mail['attachment'] = array(DRUPAL_ROOT . $arr['s28ulink']);
            }

            $message .= '
		Walls - ' . $arr['s29'] . '<br />';
            if ($arr['s29_other']) {
                $message .= 'Details - ' . $arr['s29_other'] . '<br />';
            }

            $message .= '
		Construction material use any of the following to an amount greater than 25% of the external wall:<br />
		EPS - ' . ($arr['s29_1'] == 'yes' ? 'Yes' : 'No') . '<br />
		Composite cladding/facade - ' . ($arr['s29_2'] == 'yes' ? 'Yes' : 'No') . '<br />
		Light weight rendered cladding - ' . ($arr['s29_3'] == 'yes' ? 'Yes' : 'No') . '<br />
		Roof - ' . $arr['s210'] . '<br />
		Floor - ' . $arr['s211'] . '<br />
		Does the building contain any asbestos? - ' . $arr['s222'] . '<br />
		Has there been any EPS, ACP or like materials? - ' . $arr['s223'] . '<br />
		Are there any building defects? - ' . $arr['s224'] . '<br />
		Number of:<br />
		Units - ' . $arr['s212'] . '<br />
		Lifts - ' . $arr['s213'] . '<br />
		Gyms - ' . $arr['s214'] . '<br />
		Pools - ' . $arr['s215'] . '<br />
		Tennis courts - ' . $arr['s216'] . '<br />
		Storeys - ' . $arr['s217'] . '<br />

		Number of Floors above ground - ' . $arr['s217_1'] . '<br />
		Number of Basement Levels - ' . $arr['s217_2'] . '<br />
		Number of car stackers - ' . $arr['s217_3'] . '<br />
		Is the property located directly adjacent to, or does the property contain: a lake, pond, river, canal, ocean or waterway? - ' . $arr['s217_4'] . '<br />
		Do you require cover for floating floors? - ' . $arr['s217a'] . '<br />

		Does the property have any of the following: jetties, marinas, pontoons, lakes, water features, playgrounds etc? - ' . $arr['s218'] . '<br />
		Please describe - ' . $arr['s218_yes'] . '<br />
		What percentage of total floor space does the property contain business activities? - ' . $arr['s219'] . '<br />';
            if (!empty($arr['s2191'])) {
                $message .= 'Business activities details - ' . $arr['s2191'] . '<br />';
            }
            $message .= '
		What percentage of the property is occupied as Holiday Letting? - ' . $arr['s220'] . '<br />
		<h3>Risks</h3>
		Building sum insured - ' . $arr['s31'] . '<br />
		Common contents - ' . $arr['s32'] . '<br />
		Loss of rent / temp. accommodation required - ' . $arr['s331'] . '<br />
		Loss of market value required - ' . $arr['s332'] . '<br />
		Floating floorboards cover required - ' . $arr['s333'] . '<br />
		Catastrophe cover - ' . $arr['s33'] . '<br />
		Flood Cover required - ' . $arr['s334'] . '<br />
		Legal liability - ' . $arr['s34'] . '<br />
		Office bearers liability - ' . $arr['s35'] . '<br />
		Fidelity guarantee - ' . $arr['s36'] . '<br />';
//		Weekly - ' . $arr['s38'] . '<br />
//		Body corporate entity liability - ' . $arr['s39'] . '<br />
            $message .= '
		Machinery breakdown - ' . $arr['s310'] . '<br />
		Excess - ' . $arr['s311'] . '<br />
		Do you require cover for Personal Accident for Volunteer Workers? - ' . $arr['volunteer'];
            if($arr['volunteer'] == 'yes'){
                $message .= '<br />Weekly/Capital Benefit - $2000/200000';
            }
            $message .= '<br />Professionally managed - ' . $arr['proman'];
            $mail['message'] = $message;
            easyMail($mail);
        } else {
            $content .= '<input type="hidden" id="quote" name="quote" value="' . $arr['quote'] . '" />';
        }

        return $content;
    }

    public function bizsure_rand () {
        $return = '';
        for ($i = 1; $i <= 8; $i ++) {
            $return .= base_convert(mt_rand(0, 35), 10, 36);
        }
        return strtoupper($return);
    }


    public function fileupload(Request  $request) {

        if (!empty($_FILES['file'])) {
            if ($_FILES['file']['size']>10000000){
                echo "error";
            }
            else if ($_FILES['file']['error']==0 && $_FILES['file']['size'] >0) {
                $path = "/sites/default/files/" . md5(microtime()) . '_' . $_FILES["file"]["name"];
                if (move_uploaded_file($_FILES["file"]["tmp_name"], public_path() . $path)) {
                    echo $path;
                } else {
                    echo "error";
                }
            }
        }
        if (!empty($_FILES['file_history'])) {
            if ($_FILES['file_history']['size']>10000000){
                echo "error";
            }
            else if ($_FILES['file_history']['error']==0 && $_FILES['file_history']['size'] >0) {
                $path = "/sites/default/files/" . md5(microtime()) . '_' . $_FILES["file_history"]["name"];
                if (move_uploaded_file($_FILES["file_history"]["tmp_name"], public_path() . $path)) {
                    echo $path;
                } else {
                    echo "error";
                }
            }
        }
    }

    public function searchSuburb(Request  $request) {
        $data = new \stdClass();
        $data->data = array();

        if (!empty($request->suburb)) {
            $occ = $request->suburb;
            $result = DB::table('sp_postcodes', 'n')
                ->select('*')
                ->where('suburb', 'LIKE',  '%' . intval($occ) . '%')
                ->orWhere('postcode', 'LIKE', intval($occ) . '%')
                ->orderBy('postcode')
                ->orderBy('suburb')->get();
//            $result = db_select('sp_postcodes', 'n')
//                ->fields('n', array('postcode', 'suburb', 'state'))
//                ->condition(db_or()
//                    ->condition('suburb', '%' . db_like($occ) . '%', 'LIKE')
//                    ->condition('postcode', db_like(intval($occ)) . '%', 'LIKE')
//                )
//                ->orderBy('postcode')
//                ->orderBy('suburb')
//                ->execute()
//                ->fetchAll();

            foreach ($result as $row) {
                $data->data[] = $row;
            }
        }

        return json_encode($data);
    }

    public function queryCommercial(Request  $request) {
        $arr = false;
        if (!empty($post['quote'])) {
            $arr = DB::table('sp_strata', 'n')
                ->select('n')
                ->where('n.quote', $request->quote)
                ->first();
        } else if (isset($_COOKIE['spUser'])) {
            $arr = DB::table('sp_strata', 'n')
                ->select('*')
                ->where('n.quote', $_COOKIE['spUser'])
                ->first();
            $arr = (array) $arr;
            if (!$arr || empty($arr['quote'])) {
                setcookie('spUser', '1', time() - 10, '/');
            }
        }

        if (!$arr) {
            $id = DB::table('sp_strata')->insertGetId(['s01' => '']);
//            $id = db_insert('sp_strata')
//                ->fields(array("s01" => ''))
//                ->execute();

            $quote = $this->bizsure_rand() . $id;
            DB::table('sp_strata', 'n')
                ->where('id', $id)
                ->update([
                    'quote' => $quote
                ]);

            $arr = DB::table('sp_strata', 'n')
                ->select('*')
                ->where('n.quote', $quote)
                ->first();
            $arr = (array) $arr;

            setcookie('spUser', $quote, time() + 604800, '/');
        }

        $content = '';

        $db_fields = array('s01', 's02', 's03', 's04', 's05', 's06', 's07', 's011', 's012', 's013', 'sc39', 'sc40', 'sc41', 'sc1', 'sc4', 'sc5', 'sc6', 'sc7', 'sc8', 'sc2', 'sc3', 'sc12', 'sc13', 'sc14', 'sc15', 'sc16', 'sc17', 'sc17ulink', 'sc_street', 'sc_number', 'sc_street_type', 'sc_number_type', 'sc18', 'sc19', 'sc19_1', 'sc19_2', 'sc19_3', 'sc19_4', 'sc20', 'sc21', 'sc22', 'sc23', 'sc24', 'sc25', 'sc26', 'sc27', 'sc28', 'sc29', 'sc31', 'sc32', 'sc33', 'sc34', 'sc35', 'sc36', 'sc37', 'sc38', 'sc42', 'sc43', 'sc44', 'sc45', 'sc46', 'sc47', 'sc48', 'sc49', 'sc50', 'sc51', 'sc52', 'sc53', 'sc54', 'sc55', 'sc56', 'sc57', 'sc58', 'sc59');

        $fields = array();

        foreach ($request->all() as $key => $value) {
            if (in_array($key, $db_fields)) {
                $fields[$key] = $value;
                $arr[$key] = $value;
            }
        }

        $post = $request->all();

        if($post['block'] == 'block0'){
            $fields['ci0'] = 1;
        }else if($post['block'] == 'block1'){
            $fields['ci1'] = 1;
        }else if($post['block'] == 'block2'){
            $fields['ci2'] = 1;
        }else if($post['block'] == 'block3'){
            $fields['ci3'] = 1;
        };

        if (!empty($fields) && !empty($arr['quote'])) {
            DB::table('sp_strata')
                ->where('quote', $arr['quote'])
                ->update($fields);
        }

        $lastblock = intval($arr['ci0'])+intval($arr['ci1'])+intval($arr['ci2'])+intval($arr['ci3']);

        if (($post['id']=='li0')||(($post['id']=='prev')&&($post['block']=='block1'))) {
            $content .= '
				<h2 class="h2" id="block0">Colonial strata insurance</h2>
				<fieldset class="top_level"><legend id="legend1">Policy details</legend>
					<div>
						<div class="mandatory inline">
							<label class="top">Policy period</label>
							<input type="text" name="s01" id="s01" class="calendar element short" value="' . $arr['s01'] . '" readonly="readonly" /><span class="to">to</span>
						</div>
						<div class="inline">
							<input type="text" name="s02" id="s02" class="element short" value="' . $arr['s02'] . '" readonly="readonly" />
						</div>
					</div>';
            $content .= sp_select_other('Who are you insured with', $name='s03', 'Please Select;AMP;Allianz;CHU;Calliden;Chubb;Lumley;None - New Cover;None - previosly uninsured;QBE;SUU;Vero;Zurich', 'mandatory', $arr['s03']);
            $content .= '
				</fieldset>
				<fieldset class="top_level"><legend id="legend1">Insured details</legend>
					<div class="mandatory">
						<label class="top">Insured name</label>
						<input type="text" name="s04" id="s04" value="' . $arr['s04'] . '" class="element" />
					</div>
					<div class="mandatory">
						<label class="top">Email</label>
						<input type="text" name="s05" id="s05" value="' . $arr['s05'] . '" class="element" />
					</div>
					<div class="mandatory">
						<label class="top">Contact number</label>
						<input type="text" name="s06" id="s06" value="' . $arr['s06'] . '" class="element" />
					</div>
					<div class="mandatory">
						<label class="top">Contact name</label>
						<input type="text" name="s07" id="s07" value="' . $arr['s07'] . '" class="element" />
					</div>
						<div class="finder relative';
            if($arr['s011']=='') $content .= ' mandatory';
            $content .= '
						" id="d-finder">
							<label for="finder" class="top">Please enter Postcode or Suburb:</label>
							<input name="finder" id="finder" value="" class="element waitno" />
							<div id="postcode"></div>
						</div>
						<div class="s012 element-div';
            if($arr['s011']=='') $content .= ' hidden';
            $content .= '
						" id="d-s012">
							<label class="top" for="s012">State:</label>
							<input name="s012" id="s012" value="' . $arr['s012'] . '" class="element" readonly="readonly" />
						</div>
						<div class="s011 element-div';
            if($arr['s011']=='') $content .= ' hidden';
            $content .= '
						" id="d-s011">
							<label class="top" for="s011">Postcode:</label>
							<input name="s011" id="s011" value="' . $arr['s011'] . '" class="element" readonly="readonly" />
						</div>
						<div class="s013 element-div';
            if($arr['s011']=='') $content .= ' hidden';
            $content .= '
						" id="d-s013">
							<label class="top" for="s013">Suburb:</label>
							<input name="s013" id="s013" value="' . $arr['s013'] . '" class="element" readonly="readonly" />
						</div>
				</fieldset>
				<input type="hidden" class="lastblock" id="" value="'.$lastblock.'" />
		';
        }

        if (($post['id']=='li1')||(($post['id']=='prev')&&($post['block']=='block2'))||(($post['id']=='next')&&($post['block']=='block0'))) {
            $content .= '
		<h2 class="h2" id="block1">Claims history</h2>
		<fieldset class="top_level"><legend>Claims details (within past 5 years)</legend>';
            $content .= sp_radio_ppd('Have you during the past 5 years had any insurance declined or any underwriting conditions or excesses imposed?',$name='sc39','',$arr[$name]);
            $content .= sp_radio_yn('Have you had any claims in the past 5 years?',$name='sc40','mandatory',$arr[$name]);
            if($arr['sc40']!='yes'){
                $thisclass='hidden ';
            }else{
                $thisclass='mandatory ';
            }
            $content .= '
		<div id="claimsdetails" class="'.$thisclass.'sc41">
				<table class="dd">
					<tr>
						<th>No</th>
						<th>Date<input type="hidden" class="ddquant" value="1" /></th>
						<th>Description</th>
						<th>Amount</th>
					</tr>';
            if($arr['sc41']!=''){
                $sc41=explode('(:)', $arr['sc41']);
                for($i=1;$i<=intval($sc41[0]);$i++){
                    $prered = array('','','');
                    if($sc41[3*$i-2] == ''){
                        $prered[0] = ' prered';
                    }
                    if($sc41[3*$i-1] == ''){
                        $prered[1] = ' prered';
                    }
                    if($sc41[3*$i] == ''){
                        $prered[2] = ' prered';
                    }
                    $content .= '
							<tr class="tr'.$i.'">
								<td>'.$i.'</td>
								<td><input type="text" class="subelement'.$prered[0] . '" id="dd'.$i.'2" value="'.$sc41[3*$i-2] . '" /></td>
								<td><input type="text" class="subelement'.$prered[1] . '" id="dd'.$i.'3" value="'.$sc41[3*$i-1] . '" /></td>
								<td><span>$</span><input type="text" class="subelement'.$prered[2] . '" id="dd'.$i.'5" value="'.$sc41[3*$i] . '" /></td>
							</tr>';
                }
            }else{
                $content .= '
						<tr class="tr1">
							<td>1</td>
							<td><input type="text" class="subelement prered" id="dd12" value="" /></td>
							<td><input type="text" class="subelement prered" id="dd13" value="" /></td>
							<td><span>$</span><input type="text" class="subelement prered" id="dd14" value="" /></td>
						</tr>';
            }
            $content .= '
				</table>
				<div class="adddd"><a id="adddd" href="#">Add string</a></div>
				<input type="hidden" id="sc41" value="' . $arr['sc41'] . '" class="element" name="sc41" />
			<input type="hidden" class="lastblock" id="" value="'.$lastblock.'" />
		</div>';
        }

        if (($post['id']=='li2')||(($post['id']=='prev')&&($post['block']=='block3'))||(($post['id']=='next')&&($post['block']=='block1'))) {
            $content .= '
		<h2 class="h2" id="block2">Policy cover</h2>
		<fieldset class="top_level"><legend>Sum insured</legend>';
            $content .= sp_input('Building(s) at the above Situation', $name='sc1', 'mandatory currency digital', $arr[$name]);
            $content .= sp_text('Loss of rent / temp. accommodation', 'st8', '', '15% of Building Sum Insured');
            $content .= sp_text('Common area contents', 'st9', '', '1% of Building Sum Insured');
            $content .= sp_input('Legal liability', $name='sc4', 'mandatory currency digital', $arr[$name]);
            $content .= sp_text('Voluntary workers','st1','','$ 200,000 / 2,000');
            $content .= sp_text('Workers compensation', 'st2', '', 'As per Act');
            $content .= sp_radio_yn('Do you want to cover employees?',$name='sc5','',$arr[$name]);
            $content .= sp_text('Fidelity guarantee', 'st3', '', '$ 100,000');
            $content .= sp_input('Office bearers liability', $name='sc6', 'currency digital', $arr[$name]);
            $content .= sp_input('Machinery breakdown', $name='sc7', 'currency digital', $arr[$name]);
            $content .= sp_input('Building catastrophe', $name='sc8', 'currency digital', $arr[$name]);
            $content .= sp_text('Extended cover – rent / temp. accommodation', 'st10', '', '15% of Building catastrophe Sum Insured');
            $content .= sp_text('Escalation in cost of temp. accommodation', 'st11', '', '5% of Building catastrophe Sum Insured');
            $content .= sp_text('Storage / evacuation', 'st12', '', '5% of Building catastrophe Sum Insured');
            $content .= sp_text('Government audit costs', 'st4', '', '$ 25,000');
            $content .= sp_text('Appeal expenses – common property health and safety breache', 'st5', '', '$ 100,000');
            $content .= sp_text('Legal defence expenses', 'st6', '', '$ 50,000');
            $content .= sp_text('Lot owners', 'st7', '', '$ 250,000');
            $content .= '
		</fieldset>
		<input type="hidden" class="lastblock" id="" value="'.$lastblock.'" />
		';
        }

        if (($post['id']=='li3')||(($post['id']=='next')&&($post['block']=='block2'))) {
            $content .= '
		<h2 class="h2" id="block3">Questionnaire</h2>
		<fieldset class="top_level"><legend>Building</legend>';
            $content .= sp_select_other('Internal Walls (between units)',$name='sc12','Please Select;Brick/Conc;Wood;Fibro','mandatory',$arr[$name]);
            $content .= sp_select_other('External Walls',$name='sc13','Please Select;Brick/Conc;Wood;Fibro','mandatory',$arr[$name]);
            $content .= sp_select('Floors',$name='sc14','Please Select;Concrete;Wood','mandatory',$arr[$name]);
            $content .= sp_select_other('Roof',$name='sc15','Please Select;Concrete;Metal;Tile;Slate;Fibro','mandatory',$arr[$name]);
            $content .= sp_select_other('Fences built of',$name='sc16','Please Select;Brick/Conc;Wood;Iron;Hardiflex;Fibro','mandatory',$arr[$name]);
            $content .= sp_input('Year built', $name='sc17', 'mandatory digital', $arr[$name]);
            $u28hidden = (intval($arr['sc17']) > 0 && intval($arr['sc17']) <= 1985) ? '' : ' hidden';
            $content .= '
		<div class="sc17ulink' . $u28hidden . '" style="margin-bottom:20px;">
			<input class="hidden" type="file" id="sc17ulinkFile">';
            if ($arr['sc17ulink']) {
                $content .= '<label class="top">Please upload your strata claims history on underwriters papers for the last 5 years</label><button type="button" style="margin-right:20px;">Upload another document</button>';
                $content .= '<a target="_blank" href="' . $arr['sc17ulink'] . '">Uploaded file</a>';
            } else {
                $content .= '<label class="top">Please upload your strata claims history on underwriters papers for the last 5 years</label><button type="button" style="margin-right:20px;">Upload document</button>';
            }
            $content .= '
			<input type="hidden" class="element" type="file" id="sc17ulink" name="sc17ulink" value="' . $arr['sc17ulink'] . '">
		</div>
		';
            $content .= sp_select('Street Number Type', $name='sc_number_type', 'Please Select;LOT;NO;RMB;RMS', 'mandatory', $arr['sc_number_type']);
            $content .= sp_input('Street Number', $name='sc_number', 'mandatory digit', $arr['sc_number']);
            $content .= sp_input('Street Name', $name='sc_street', 'mandatory', $arr['sc_street']);
            $content .= sp_select('Street Type', $name='sc_street_type', 'Please Select;STREET;ROAD;AVENU;CLOSE;PLACE;TERRACE;WATERS;WYND;WAKLWAY;WALK;WAY;VIEW;VISTA;UNDERPASS;TOLLWAY;TURN;TRAIL;TRACK;TOR;TARN;TERRACE;SERVICEWAY;STREETS;STRIP;STATION;SUITE;STREET;SQUARE;SIDING;STRAND;RUN;RIGHTOFWAY;ROUTE;RETREAT;REST;ROW;ROUND;RISE;RIDGEWAY;RESERVE;ROADWAY;ROADS;RIDGE;ROAD;REACH;RAMBLE;QUAY;QUADRANGLE;QUADRANT;PARKWAY;PATH;PORT;PASS;PROMENADE;POINT;PLAZA;PLACE;POCKET;PARK;PATHWAY;PARADE;BLANKS;ALLEY;APPROACH;ARCADE;AVENUE;BOULEVARD;BEND;BYPASS;BRACE;BRAE;BROOK;BROADWAY;CIRCUIT;CHASE;CIRCLE;CREEK;CLOSE;COMMON;CONCOURSE;CORNER;COPSE;CIRCUS;CRESCENT;CROSS;CROSSING;CORSO;CREST;COURT;CUTTING;CENTRE;COVE;CAUSEWAY;COURTYARD;DALE;DRIVE;DRIVEWAY;EDGE;ELBOW;END;ENTRANCE;ESPLANADE;ESTATE;EXPRESSWAY;FAIRWAY;FALLOW;FRONTAGE;FREEWAY;GARDEN;GLADE;GLEN;GRANGE;GROUND;GREEN;GATE;GROVE;HILL;HEIGHTS;HIGHWAY;JUNCTIONKEY;LANE;LINK;LOOP;MEANDER;MALL;MOUNT;MEWS;MOTORWAY;NOOK;OUTLOOK', 'mandatory', $arr['sc_street_type']);
            $content .= sp_input('No. of units', $name='sc18', 'mandatory digital', $arr[$name]);
            $content .= sp_input('No. of storeys', $name='sc19', 'mandatory digital', $arr[$name]);
            $content .= sp_textarea('Fire protection – please list all the measures in place',$name='sc19_1','mandatory',$arr[$name]);
            $content .= sp_textarea('Security – please list all the measures in place',$name='sc19_2','mandatory',$arr[$name]);
            $content .= sp_input('Excess', $name='sc19_3', 'mandatory digital currency', $arr[$name]);
            $content .= sp_radio_yn('Heritage listed?',$name='sc20','',$arr[$name]);
            $content .= '
		<div id="heritageupload"></div>
		<input id="sc2" name="sc2" type="hidden" class="element" value="' . $arr['sc2'] . '" />';
            $content .= sp_radio_ppd('Is the Building maintained to a good standard of repair?',$name='sc21','',$arr[$name]);
            $content .= sp_select('Is the Building occupied?',$name='sc22','Yes;No;Partially','',$arr[$name]);
            $content .= sp_input('Please provide the percentage occupied', $name='sc23', 'mandatory percent', $arr[$name]);
            $content .= sp_radio_yn('Is any part of the Building used for domestic purposes?',$name='sc24','',$arr[$name]);
            $content .= sp_input('Please provide percentage used for domestic purposes', $name='sc25', 'mandatory percent', $arr[$name]);
            $content .= sp_radio_yn('Do any of the Building’s occupants have commercial cooking facilities?',$name='sc26','',$arr[$name]);
            $content .= '
			<fieldset class="second_level"><legend>Please select occupancy type(s)</legend>';
            $content .= sp_checkbox('Offices',$name='sc27','',$arr[$name]);
            $content .= sp_checkbox('Retail shops',$name='sc28','',$arr[$name]);
            $content .= sp_checkbox('Industrial',$name='sc29','',$arr[$name]);
            $content .= sp_textarea('Please describe business activities of each unit',$name='sc19_4','mandatory',$arr[$name]);
            if($arr['sc3']!='yes'){
                $hidden='hidden ';
            }
            $content .= '
			<div id="stateocc" class="'.$hidden.'sc3">
				<table class="ddoc">
					<tr>
						<th>Unit</th>
						<th>State Occupancy<input type="hidden" class="ddocquant" value="1" /></th>
					</tr>';
            if($arr['sc3']!=''){
                $sc3=explode('(:)', $arr['sc3']);
                for($i=1;$i<=intval($sc3[0]);$i++){
                    $content .= '
							<tr class="tr'.$i.'">
								<td>'.$i.'</td>
								<td><input type="text" class="subelement" id="ddoc'.$i.'2" value="'.$sc3[$i] . '" /></td>
							</tr>';
                }
            }else{
                $content .= '
						<tr class="tr1">
							<td>1</td>
							<td><input type="text" class="subelement prered" id="ddoc12" value="" /></td>
						</tr>';
            }
            $content .= '
				</table>
				<div class="addddoc"><a id="addddoc" href="#">Add Unit</a></div>
				<input type="hidden" id="sc3" value="' . $arr['sc3'] . '" class="element" name="sc3" />
			</div>';
            $content .= '
			</fieldset>
			<p>Note: It is your duty to advise us of any change in the occupations carried on at the risk location.</p>';
            $content .= sp_radio_yn('Are there any air-conditioners or electric motors in excess of 5kw?',$name='sc31','',$arr[$name]);
            $content .= sp_radio_ppd('Do you want cover against breakdown?',$name='sc32','',$arr[$name]);
            $content .= '
			<fieldset class="second_level"><legend>Please indicate the facilities provided by your Strata:</legend>';
            $content .= sp_checkbox('Lifts',$name='sc33','',$arr[$name]);
            $content .= sp_checkbox('Spas',$name='sc34','',$arr[$name]);
            $content .= sp_checkbox('Pools',$name='sc35','',$arr[$name]);
            $content .= sp_checkbox('Tennis Courts',$name='sc36','',$arr[$name]);
            $content .= sp_checkbox('Other',$name='sc37','',$arr[$name]);
            $content .= sp_textarea('Please provide details',$name='sc38','hidden',$arr[$name]);
            $content .= '
			</fieldset>';
            $content .= sp_radio_yn('Do you have a strata manager?',$name='sc42','',$arr[$name]);
            $content .= sp_textarea('Provide name and address details',$name='sc43','hidden',$arr[$name]);
            $content .= sp_radio_yn('Is the insured registered for GST?',$name='sc44','',$arr[$name]);
            $content .= sp_input('To what extent is the insured entitled to claim input tax credits?', $name='sc45', 'mandatory percent', $arr[$name]);
            $content .= sp_input('Please write the Australian Business Number (ABN) here', $name='sc46', 'mandatory', $arr[$name]);
            if(($arr['s012']=='NSW')||($arr['s012']=='VIC')){
                $content .= sp_radio_yn('Is the Building new/refurbished?',$name='sc47','',$arr[$name]); // NSW/VIC only
            }
            if($arr['s012']=='NSW'){
                $content .= sp_radio_yn('Has a Certificate of Compliance/Occupancy been issued?',$name='sc48','',$arr[$name]); // NSW/VIC only
                $content .= sp_radio_yn('Is the Body Corporate part of a Strata Management Statement (SMS)?',$name='sc49','',$arr[$name]); // NSW only
                $content .= sp_textarea('Provide full details including SMS, plans etc.',$name='sc50','hidden',$arr[$name]); // NSW only
                $content .= sp_radio_yn('Has the insured had an Occupational Health & Safety Survey?',$name='sc51','',$arr[$name]); // NSW only
                $content .= '
				<div class="mandatory">
					<label class="top">Policy period</label>
					<input type="text" name="sc52" id="sc52" class="calendar element short" value="' . $arr['sc52'] . '" readonly="readonly" />
				</div>';// NSW only
            }
            if($arr['s012']=='QLD'){
                $content .= sp_radio_yn('Is the body corporate part of a Building Management Statement (BMS)?',$name='sc53','',$arr[$name]); // QLD only
                $content .= sp_textarea('Provide full details including BMS, plans etc.',$name='sc54','hidden',$arr[$name]); // QLD only
                $content .= sp_radio_yn('Is the Body Corporate part of a Layered Scheme?',$name='sc55','',$arr[$name]); // QLD only
                $content .= sp_textarea('Provide full details including plans.',$name='sc56','hidden',$arr[$name]); // QLD only
            }
            if(($arr['s012']=='NSW')||($arr['s012']=='WA')||($arr['s012']=='TAS')||($arr['s012']=='ACT')){
                $content .= '
				<fieldset id="wcd" class="second_level"><legend>Workers compensation declaration</legend>';// NSW, WA, TAS & ACT only
                $content .= sp_input('Employees estimated number:', $name='sc57', 'mandatory', $arr[$name]);// NSW, WA, TAS & ACT only
                $content .= sp_input('Employees estimated wages:', $name='sc58', 'mandatory', $arr[$name]);// NSW, WA, TAS & ACT only
                $content .= sp_input('To cover your liability for employees of contractors and persons deemed to be workers within the meaning of your Act please
		estimate cost of work/services to be carried out under contract:', $name='sc59', 'mandatory', $arr[$name]); // NSW & WA
                $content .= '
				</fieldset>';
            }
            $content .= '
		</fieldset>
		<input type="hidden" class="lastblock" id="" value="'.$lastblock.'" />
		';
        }

        if($post['id']=='submit'){
            $content .= '
		<h2 class="h2" id="block4"></h2>
		<p>Thank you for submitting your Quote Request.</p>
		<p>Your Quote number is ' . $arr['quote'] . '</p>
		<p>Our staff will contact with our best quote shortly.</p>';
            $mail = array();
            $mail['address'] = array('support@colonialinsurance.com.au');
            $mail['subject'] = 'New Strata Form submission. Quote number ' . $arr['quote'];
            $message = '
		<h2>New submission data</h2>
		Policy period - ' . $arr['s01'] . ' to  - ' . $arr['s02'] . '<br />
		Who are you insured with - ' . $arr['s03'] . '<br />
		Insured name - ' . $arr['s04'] . '<br />
		Email - ' . $arr['s05'] . '<br />
		Contact number - ' . $arr['s06'] . '<br />
		Contact name - ' . $arr['s07'] . '<br />
		Postcode - ' . $arr['s011'] . '<br />
		State - ' . $arr['s012'] . '<br />
		Suburb - ' . $arr['s013'] . '<br />
		<h3>Claims history</h3>
		Claims details (within past 5 years)</legend> - ' . $arr['sc39'] . '<br />
		Have you had any claims in the past 5 years? - ' . $arr['sc40'] . '<br />';
            if($arr['sc41']!=''){
                if(!isset($thisclass)) {
                    $thisclass = '';
                }

                $message .= '
		<div id="claimsdetails" class="'.$thisclass.'sc41">
			<table class="dd">
				<tr>
					<th>No</th>
					<th>Date<input type="hidden" class="ddquant" value="1" /></th>
					<th>Description</th>
					<th>Amount</th>
				</tr>';
                $sc41=explode('(:)', $arr['sc41']);
                for($i=1;$i<=intval($sc41[0]);$i++){
                    $prered = array('','','');
                    if($sc41[3*$i-2] == ''){
                        $prered[0] = ' prered';
                    }
                    if($sc41[3*$i-1] == ''){
                        $prered[1] = ' prered';
                    }
                    if($sc41[3*$i] == ''){
                        $prered[2] = ' prered';
                    }
                    $message .= '
				<tr class="tr'.$i.'">
					<td>'.$i.'</td>
					<td>'.$sc41[3*$i-2] . '</td>
					<td>'.$sc41[3*$i-1] . '</td>
					<td><span>$ </span>' . number_format(intval($sc41[3*$i]), 2, '.', ' ') . '</td>
				</tr>';
                }
                $message .= '
			</table>
		</div>';
            }
            $message .= '
		<h3>Policy cover</h3>
		Building(s) at the above Situation - ' . $arr['sc1'] . '<br />
		Loss of rent / temp. accommodation - '.($arr['sc1'] * 0.15).'<br />
		Common area contents - '.($arr['sc1'] * 0.01).'<br />
		Legal liability - ' . $arr['sc4'] . '<br />
		Voluntary workers - $ 200,000 / 2,000<br />
		Workers compensation - As per Act<br />
		Do you want to cover employees? - ' . $arr['sc5'] . '<br />
		Fidelity guarantee - $ 100,000<br />
		Office bearers liability - ' . $arr['sc6'] . '<br />
		Machinery breakdown - ' . $arr['sc7'] . '<br />
		Building catastrophe - ' . $arr['sc8'] . '<br />
		Extended cover – rent / temp. accommodation - '.($arr['sc8'] * 0.15).'<br />
		Escalation in cost of temp. accommodation - '.($arr['sc8'] * 0.05).'<br />
		Storage / evacuation - '.($arr['sc8'] * 0.05).'<br />
		Government audit costs - $ 25,000<br />
		Appeal expenses – common property health and safety breache - $ 100,000<br />
		Legal defence expenses - $ 50,000<br />
		Lot owners - $ 250,000<br />
		<h3>Questionnaire</h3>
		Internal Walls (between units) - ' . $arr['sc12'] . '<br />
		External Walls - ' . $arr['sc13'] . '<br />
		Floors - ' . $arr['sc14'] . '<br />
		Roof - ' . $arr['sc15'] . '<br />
		Fences built of - ' . $arr['sc16'] . '<br />
		Year built - ' . $arr['sc17'] . '<br />';
            if ($arr['sc17ulink']) {
                $mail['attachment'] = array(DRUPAL_ROOT . $arr['sc17ulink']);
            }
            $message .= '
		Street Number Type - ' . $arr['sc_number_type'] . '<br />
		Street Number - ' . $arr['sc_number'] . '<br />
		Street Name - ' . $arr['sc_street'] . '<br />
		Street Type - ' . $arr['sc_street_type'] . '<br />
		No. of units - ' . $arr['sc18'] . '<br />
		No. of storeys - ' . $arr['sc19'] . '<br />
		Fire protection – please list all the measures in place - ' . $arr['sc19_1'] . '<br />
		Security – please list all the measures in place - ' . $arr['sc19_2'] . '<br />
		Excess - ' . $arr['sc19_3'] . '<br />
		Heritage listed? - ' . $arr['sc20'] . '<br />
		Is the Building maintained to a good standard of repair? - ' . $arr['sc21'] . '<br />
		Is the Building occupied? - ' . $arr['sc22'] . '<br />
		Please provide the percentage occupied - ' . $arr['sc23'] . '<br />
		Is any part of the Building used for domestic purposes? - ' . $arr['sc24'] . '<br />
		Please provide percentage used for domestic purposes - ' . $arr['sc25'] . '<br />
		Do any of the Building’s occupants have commercial cooking facilities? - ' . $arr['sc26'] . '<br />
		Offices - ' . $arr['sc27'] . '<br />
		Retail shops - ' . $arr['sc28'] . '<br />
		Industrial - ' . $arr['sc29'] . '<br />
		Business activities of each unit - ' . $arr['sc19_4'] . '<br />
		Are there any air-conditioners or electric motors in excess of 5kw? - ' . $arr['sc31'] . '<br />
		Do you want cover against breakdown? - ' . $arr['sc32'] . '<br />
		Lifts - ' . $arr['sc33'] . '<br />
		Spas - ' . $arr['sc34'] . '<br />
		Pools - ' . $arr['sc35'] . '<br />
		Tennis Courts - ' . $arr['sc36'] . '<br />
		Other - ' . $arr['sc37'] . '<br />
		Please provide details - ' . $arr['sc38'] . '<br />
		Do you have a strata manager? - ' . $arr['sc42'] . '<br />
		Provide name and address details - ' . $arr['sc43'] . '<br />
		Is the insured registered for GST? - ' . $arr['sc44'] . '<br />
		To what extent is the insured entitled to claim input tax credits? - ' . $arr['sc45'] . '<br />
		Please write the Australian Business Number (ABN) here - ' . $arr['sc46'] . '<br />
		Is the Building new/refurbished? - ' . $arr['sc47'] . '<br />
		Has a Certificate of Compliance/Occupancy been issued? - ' . $arr['sc48'] . '<br />
		Is the Body Corporate part of a Strata Management Statement (SMS)? - ' . $arr['sc49'] . '<br />
		Provide full details including SMS, plans etc. - ' . $arr['sc50'] . '<br />
		Has the insured had an Occupational Health & Safety Survey? - ' . $arr['sc51'] . '<br />
		Is the body corporate part of a Building Management Statement (BMS)? - ' . $arr['sc53'] . '<br />
		Provide full details including BMS, plans etc. - ' . $arr['sc54'] . '<br />
		Is the Body Corporate part of a Layered Scheme? - ' . $arr['sc55'] . '<br />
		Provide full details including plans. - ' . $arr['sc56'] . '<br />
		Employees estimated number: - ' . $arr['sc57'] . '<br />
		Employees estimated wages: - ' . $arr['sc58'] . '<br />
		To cover your liability - ' . $arr['sc59'] . '<br />';
            $mail['message'] = $message;
            easyMail($mail);
        } else {
            $content .= '<input type="hidden" id="quote" name="quote" value="' . $arr['quote'] . '" />';
        }

        return $content;
    }

}
