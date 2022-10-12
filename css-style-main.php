<?php
// style aspects of the admin area css admin
add_action('admin_head', 'css_admin_area');
function css_admin_area()
{
  ?><style type="text/css">
			/* zapier bugged symbol */
			#misc-publishing-actions > div.misc-pub-section.yoast.yoast-zapier-text > svg > path { display: none; }
			#misc-publishing-actions > div.misc-pub-section.yoast.yoast-zapier-text > svg { display: none; }
			._EBkeeponhold { max-width: 120px; }
			._saved_shipping { color: #858f8e; }
			/* hide annoying facebook notice */
			#wpbody-content > div.wrap > div.notice.js-wc-plugin-framework-admin-notice.notice-info { display: none; }
			#wpbody-content > div.wrap > div.notice.woo-feed-ctx-startup-notice.is-dismissible { display: none; }
			#wpbody-content > div.wrap.wapk-admin > div > div.notice.is-dismissible { display: none; }
			#message > p > small { background-color: #ffffff; }
			
			#wpbody-content > div.wrap > div.woo-feed-notice.notice.notice-info { display: none; }
	
			#toplevel_page_ccr-admin-menu-ccr-admin-menu > a > div.wp-menu-image.dashicons-before > img { margin-top: -5px !important; }
			
			a.order-view { visibility: none; display: none; }
			a.order-preview { visibility: none; display: none; }
			td.order_status.column-order_status > mark > span { display: block flex !important; flex-wrap: wrap !important; overflow: wrap !important; }
			
			.fixinfodisplay, .notedandisplay { width: 130px; font-weight:bold; font-size:12px; }
			
			.nameinputBEdiv, .businputBEdiv, .addressinputst2BEdiv, .addressinput2adddiv, .addTypeInputBEdiv, .forkDockInputBEdiv, .dApptInputBEdiv, .shipTypeInputBEdiv, .found_byBEdiv, .pallet_feeBEdiv, .CCR_ship_costBEdiv, .billonlycheckdiv, .shiponlycheckdiv, .terminalBEdiv, .terminal_zipBEdiv, .inputQBOtotalBEdiv, .inputQBOcountBEdiv { width: 50%; float: left; }
			.samade, .sasigned { width: 50%; float: left; }
			.length_inputBEdiv, .width_inputBEdiv, .height_inputBEdiv { width: 32%; float: left; }
			._pallet_feeBE::placeholder, ._CCR_ship_costBE::placeholder, .terminal_zipBE::placeholder, .terminalBEdiv optgroup { font-size: 12px; !important}
			.Oweight_inputBEdiv, .Opallet_feeBEdiv, .OCCR_ship_costBEdiv, .OterminalBEdiv, .Oterminal_zipBEdiv { width: 33%; float: left; }
			.OterminalBE, div.OterminalBEdiv > p > label { min-width: 170px; }
			
			.inputQBOtotal::placeholder, inputQBOcount::placeholder { font-size: 10px; }
			
			.shipqltable.td, .shipqltable.th { border: 1px solid #dddddd; text-align: left; padding: 8px; }
			.shipqltable.th { background-color: #dddddd; }
			
			#wpbody-content > div.wrap > ul > li.wc-pending > a { 
				color: #ffffff !important; background-color: #378bbc; 
				-webkit-border-radius: 5px;
				border-radius: 5px; }
			#wpbody-content > div.wrap > ul > li.wc-pending > a > span { color: #ffffff !important; }
			#wpbody-content > div.wrap > ul > li.wc-on-hold > a { 
				color: #a1794d !important; background-color: #f7dca5; 
				-webkit-border-radius: 5px;
				border-radius: 5px; }
			#wpbody-content > div.wrap > ul > li.wc-on-hold > a > span { color: #a1794d !important; }
			#wpbody-content > div.wrap > ul > li.wc-processing > a { 
				color: #434d43 !important; background-color: #c6e1c6; 
				-webkit-border-radius: 5px;
				border-radius: 5px; }
			#wpbody-content > div.wrap > ul > li.wc-processing > a > span { color: #434d43 !important; }
			#wpbody-content > div.wrap > ul > li.wc-completed > a { 
				color: #ffffff !important; background-color: #c40403; 
				-webkit-border-radius: 5px;
				border-radius: 5px; }
			#wpbody-content > div.wrap > ul > li.wc-completed > a > span { color: #ffffff !important; }
			
			/* icons */
			td.order_status.column-order_status > div.order-onhold > i::before { color: #f7dca5 !important; }
			td.order_status.column-order_status > div.order-completed > i::before { color: #c40403 !important; }
			td.order_status.column-order_status > div.order-pending > i::before { color: #378bbc !important; }
			td.order_status.column-order_status > p.order-processing > i::before { color: #c41a02 !important; position: relative; top: 15px; }
			td.order_status.column-order_status > p.order-processing-invoice > i::before { color: #378bbc !important; position: relative; top: 15px; }
			td.order_status.column-order_status > p.order-processing-sign > i::before { color: #f7dca5 !important; position: relative; top: 15px; }
			td.order_status.column-order_status > div.order-refunded > i::before { color: #00f7ff !important; }
			td.order_status.column-order_status > div.order-cancelled > i::before { color: #e5e5e5 !important; }
			td.order_billship.column-order_billship > p.ccicon > i::before { background: #ffffff !important; color: #2ca01c !important; padding-left: 1px; padding-right: 1px; -webkit-border-radius: 5px; border-radius: 5px; position: relative; top: 15px; }
			td.order_billship.column-order_billship > p.ppicon > i::before { background: #ffffff !important; color: #213170 !important; padding-left: 1px; padding-right: 1px; -webkit-border-radius: 5px; border-radius: 5px; position: relative; top: 15px; }
			td.order_billship.column-order_billship > p.cashicon > i::before { background: #ffffff !important; color: #89b383 !important; padding-left: 1px; padding-right: 1px; -webkit-border-radius: 5px; border-radius: 5px; position: relative; top: 15px;}
			td.order_billship.column-order_billship > p.checkicon > i::before { background: #ffffff !important; color: #a0895c !important; padding-left: 1px; padding-right: 1px; -webkit-border-radius: 5px; border-radius: 5px; position: relative; top: 15px;}
			td.order_billship.column-order_billship > p.wireicon > i::before { background: #ffffff !important; color: #696254 !important; padding-left: 1px; padding-right: 1px; -webkit-border-radius: 5px; border-radius: 5px; position: relative; top: 15px;}
			td.order_billship.column-order_billship > p.lpicon > i::before { color: #c40403 !important; position: relative; top: 15px; }
			td.order_billship.column-order_billship > p.thirdicon > i::before { color: #92b5d1 !important; position: relative; top: 15px; }
			td.order_billship.column-order_billship > p.freighticonterm > i::before { color: #9fc0c0 !important; position: relative; top: 15px; }
			td.order_billship.column-order_billship > p.freighticon > i::before { color: #f8dda7 !important; position: relative; top: 15px; }
	
			td.order_billship.column-order_billship > p.upsicon > i::before { color: #ffbe03 !important; position: relative; top: 15px; }
			td.order_billship.column-order_billship > p.uspsicon > i::before { color: #333366 !important; background-color: #ffffff; -webkit-border-radius: 10px; border-radius: 10px; position: relative; top: 15px;}
			
			div.order-processing-text { border-style: solid; border-width: 3px; border-color: #ffffff; -webkit-border-radius: 5px; border-radius: 5px; }
			div.order-processing-textMADE { border-style: solid; border-width: 3px; border-color: #ffffff; color: #ffffff; background-color: #378bbc; -webkit-border-radius: 5px; border-radius: 5px; text-align: center; font-size: 24px; margin-bottom: 10px; }
			div.order-processing-textSIGN { border-style: solid; border-width: 3px; border-color: #a1794d; color: #a1794d; background-color: #f7dca5; -webkit-border-radius: 5px; border-radius: 5px; text-align: center; font-size: 24px; margin-bottom: 10px; }
			div.order-processing-textTRACK { border-style: solid; border-width: 3px; border-color: #c41a02; color: #c41a02; background-color: #ffffff; -webkit-border-radius: 5px; border-radius: 5px; text-align: center; font-size: 22px; margin-bottom: 10px; }

			td.order_inputtrack.column-order_inputtrack > p > i::before, td.order_billship.column-order_billship > div._saved_billing > p > i::before, td.order_billship.column-order_billship > div._saved_shipping > p > i::before, td.order_inputtrack.column-order_inputtrack > div > p > i::before, td.order_inputship.column-order_inputship > p > i::before, td.order_email.column-order_email > form > p > i::before, td.order_inputship.column-order_inputship > div > p > i::before, td.order_email.column-order_email > form > div > p > i::before { color: #ffffff !important; }
			td.order_inputtrack.column-order_inputtrack > p > i::before { position:relative; top: -3px; }
		
			/*td.order_billship.column-order_billship > div._saved_shipping::before { 
				content: "\f48b";
				position: relative;
				font: var(--fa-font-solid);
				font-family: "Font Awesome 6 Free";
				font-size: 100px;
				top: 100px;
				display: flex;
				zoom: inherit;
   				text-rendering: auto;
    			-webkit-font-smoothing: antialiased;
				opacity: 0.1;
			}*/
			
			td.order_status.column-order_status > mark { display: flex; align-items: center; justify-content: center; font-size: 12px; }
			
  			.postqty {
				display: inline-block;
				width: 100%;
				color:#ffffff; 
				background-color:#af4f5e !important; 
				text-align:center; 
				padding: 5px; 
				/*-webkit-border-radius: 5px;
				border-radius: 5px;*/
				overflow:hidden;
				margin-left: auto ;
  				margin-right: auto ;
				margin-top: 5px;
				margin-bottom: 5px;
				outline: none;
				border: #af4f5e;
				max-width: 110px;
				box-shadow: 0 0 0 1px #af4f5e;
				border: 0px solid transparent;
	 		}
			#_sdcp {
				min-height: 400px !important;
			}
			
			.postqty.publish { background-color:#82d363 !important; 
				box-shadow: 0 0 0 1px #82d363;
				border: 0px solid transparent; }
			.postqty.private { background-color:#af4f5e !important; 
				box-shadow: 0 0 0 1px #af4f5e;
				border: 0px solid transparent; }
			.postqty.pending { background-color:#ffbc02 !important; 
				box-shadow: 0 0 0 1px #ffbc02;
				border: 0px solid transparent; }
			.postqty.draft { background-color:#3eb7ce !important; 
				box-shadow: 0 0 0 1px #3eb7ce;
				border: 0px solid transparent;}
			
			.postqty::placeholder {
				text-align: center;
				color: #ffffff;
				font-weight: bold;
				background-color: #af4f5e;
	 		}
			
			.postqty.publish::placeholder { background-color: #82d363 !important; 
				box-shadow: 0 0 0 1px #82d363 !important;
				border: 0px solid transparent; }
			.postqty.private::placeholder { background-color: #af4f5e !important; 
				box-shadow: 0 0 0 1px #af4f5e !important;
				border: 0px solid transparent; }
			.postqty.pending::placeholder { background-color: #ffbc02 !important; 
				box-shadow: 0 0 0 1px #ffbc02 !important;
				border: 0px solid transparent; }
			.postqty.draft::placeholder { background-color: #3eb7ce !important; 
				box-shadow: 0 0 0 1px #3eb7ce !important;
				border: 0px solid transparent; }
			
			.postqty::focus, .postqty.publish::focus, .postqty.private::focus, .postqty.pending::focus, .postqty.draft::focus  {
				outline: none;
	  		}
			
			.updateme { display: inline-block; background-color:#ffffff; color: #c40403; text-align: center; border-radius: 5px; font-family: Black Ops One; font-weight: bold; padding: 5px; }
			
			.poststatus {
				display: inline-block; 
				width: 100%;
				margin-left: auto ;
  				margin-right: auto ;
				color:#ffffff; 
				background-color:#af4f5e; 
				text-align:center; 
				padding: 5px; 
				/*-webkit-border-radius: 5px;
				border-radius: 5px;*/
				resize: none;
				outline: none;
				border: #af4f5e;
				margin-top: 5px;
				max-width: 110px;
				overflow: hidden;
			}
			
			.poststatus.publish { background-color:#82d363 !important; 
				box-shadow: 0 0 0 1px #82d363 !important;
				border: 0px solid transparent; }
			.poststatus.private { background-color:#af4f5e !important; 
				box-shadow: 0 0 0 1px #af4f5e !important;
				border: 0px solid transparent; }
			.poststatus.pending { background-color:#ffbc02 !important; 
				box-shadow: 0 0 0 1px #ffbc02 !important;
				border: 0px solid transparent; }
			.poststatus.draft { background-color:#3eb7ce !important; 
				box-shadow: 0 0 0 1px #3eb7ce !important;
				border: 0px solid transparent; }
			
			.poststatus::placeholder {
				text-align: center;
				color: #ffffff;
				font-weight: bold;
				background-color: #af4f5e !important;
	 		}
			
			.poststatus.publish::placeholder { background-color: #82d363 !important }
			.poststatus.private::placeholder { background-color: #af4f5e !important }
			.poststatus.pending::placeholder { background-color: #ffbc02 !important }
			.poststatus.draft::placeholder { background-color: #3eb7ce !important }
			
			.poststatus::focus  {
				outline: none;
	  		}
	 
  			.pricearea, .costarea {
				max-width: 90%;
				min-width: 100px;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				border: 2px solid #4E7E3B;
				background-color: #dce5d8;
				text-align: center;
				margin-left: auto ;
  				margin-right: auto ;
	 		}
			.priceudpateform {
				padding: 0px !important;
			}
			.costarea {
				border: 2px solid #af4f5e;
				background: #efdcdf;
	 		}
			.brandinput, .mpninput {
				width: 100px;	
			}
	  		.brandinput, .mpninput, .brandmpn, .shipclassinput, .customshipinput, .freightclassinput, .aucinput, .aucddiv, .aucdinput, .postlocupdate, .cfeeinput, .deminputlempty, .deminputwempty, .deminputhempty, .deminputwgtempty, .deminputcfeeempty, .aucinpute, .aucdinpute, .condinput, .testinput, .addinfodisplay,  .postsalepricee, .postcoste {
				text-align:center;
	 			margin-left: auto ;
  				margin-right: auto ;
				border: none !important;
				background: transparent !important;
	  		}
	.deminputl, .deminputw, .deminputh, .wgtinput {
		text-align:left;
				border: none !important;
				background: transparent !important;
	}
			[class*="addinfodisplay"] {
				text-align:center;
	 			margin-left: auto ;
  				margin-right: auto ;
				border: none !important;
				background: transparent !important;
			}
			.fixinfodisplay, .notedandisplay { 
				margin-left: auto ;
  				margin-right: auto ;
			}
			.aucdinput, .aucinput, .aucinpute, .aucdinpute, .newaucdinput {
				width: 120px;
	  		}
			.newaucdinput::-webkit-calendar-picker-indicator {
				opacity: 1;
	 		}
			.shipclassinput, .customshipinput, .freightclassinput {
				width: 100px;
	  		}
			.condinput, .testinput, .addinfodisplay, [class*="addinfodisplay"] {
				width: 110px;
	  		}
			.deminputl, .deminputw, .deminputh, .deminputlempty, .deminputwempty, .deminputhempty, .deminputwgtempty {
				min-width: 40px;
				max-width: 40px;
				margin-bottom: 2px;
				text-align: center;
				display: inline-block;
	  		}
			.wgtinput, .deminputwgtempty, .cfeeinput, .demiputcfeeempty {
				min-width: 80px;
				max-width: 120px;
				text-align: center;
	  		}
			.ccrindtotalprice { color: #4E7E3B !important; border: 2px solid #4E7E3B !important; background-color: #dce5d8 !important; -webkit-border-radius: 5px;
				border-radius: 5px; display: inline-table ; vertical-align: middle; position: relative; margin-bottom: -12px; font-size: 18px; padding: 2px; }
			.ccrindtotalcost { color: #af4f5e !important; border: 2px solid #af4f5e !important; background-color: #efdcdf !important; -webkit-border-radius: 5px;
				border-radius: 5px; display: inline-table; vertical-align: middle; position: relative; margin-bottom: -12px; font-size: 18px; padding: 2px; }
			.filterwarning { color: #0081fc !important; border: 2px solid #0081fc !important; background-color: #fcfc00 !important; -webkit-border-radius: 5px;
				border-radius: 5px; display: inline-table; vertical-align: middle; position: relative; margin-bottom: -12px; font-size: 18px; padding: 2px;
				left: 4em; margin-right: -6em; }
			@supports selector(:nth-child(1 of x)) {
				.ccrindtotalprice { margin-left: 54px; }
				#post-query-submit { margin-top: -18px; }
			}
			.postregprice[type="text"], .postregpricestrike[type="text"], .postsaleprice[type="text"], .postcost[type="text"] {
				min-width: 120px;
				width: 100%;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				border: 2px solid #4E7E3B !important;
				background-color: #dce5d8 !important;
				text-align: center;
				margin-left: auto ;
  				margin-right: auto ;
	 		}
			
			.postregprice::placeholder, .postregpricestrike::placeholder, .postsaleprice::placeholder {
				text-align: center;
				color: #4E7E3B !important;
				font-weight: bold;
				font-size: 15px;
				background-color: #dce5d8 !important;
	 		}
			.postcost[type="text"] {
				border: 2px solid #af4f5e  !important;
				background: #efdcdf  !important;
				margin-top: 5px;
	  		}
			.postcost::placeholder {
				text-align: center;
				color: #af4f5e  !important;
				font-weight: bold;
				font-size: 15px;
				background-color: #efdcdf  !important;
	  		}
			.postregpricestrike::placeholder {
				text-decoration: line-through;
			}
			.postregprice::focus, .postregpricestrike:focus, .postsaleprice::focus, .postcost::focus  {
				outline: none;
	  		}
			.brandinput:focus, .mpninput:focus, .brandmpn:focus, .shipclassinput:focus, .customshipinput:focus, .freightclassinput:focus, .aucinput:focus, .aucddiv:focus, .aucdinput:focus, 
			.postlocupdate:focus, .deminputl:focus,  .deminputw:focus, .deminputh:focus, .wgtinput:focus, .cfeeinput:foucs, .deminputlempty:focus, .deminputwempty:focus, .deminputhempty:focus, 
			.deminputwgtempty:focus, .deminputcfeeempty:focus, .aucinpute:focus, .aucdinpute:focus, .condinput:focus, .testinput:focus, .changedesc:focus, .addinfodispaly:focus, .fixinfodisplay:focus,
			.notedandisplay:focus, .postsalepricee:focus, .postcoste:focus, [class*="addinfodisplay"]:focus {
				-webkit-box-shadow: 0 0 0 2px #4E7E3B !important;
				color: #9c9c9c !important;
	  		}
				
			.brandinput::placeholder, .mpninput::placeholder, .postlocupdate::placeholder, .shipclassinput::placeholder , .customshipinput::placeholder, .freightclassinput::placeholder, 
			.aucinput::placeholder, .aucinpute::placeholder, .aucdinput::placeholder, .aucdinpute::placeholder, .aucddiv, , .condinput::placeholder, .testinput::placeholder, .addinfodisplay::placeholder, [class*="addinfodisplay"]::placeholder {
				text-align:center;
	 			color: #9c9c9c;
				font-weight: bold;
				outline: none;
	  		}
	.deminputl::placeholder, .deminputw::placeholder, .deminputh::placeholder, 
	.wgtinput::placeholder {
		text-align:left;
	 			color: #9c9c9c;
				font-weight: bold;
				outline: none;
	}
			.cfeeinput::placeholder {
				text-align:center;
	 			color: #c40403;
				font-weight: bold;
				outline: none;
			}
			.fixinfodisplay::placeholder, .notedandisplay::placeholder {
				color: #9c9c9c !important;
				font-weight: bold;
				outline: none;
			}
			.testinput::placeholder, .addinfodisplay::placeholder, .fixinfodisplay::placeholder, .notedandisplay::placeholder, [class*="addinfodisplay"]::placeholder {
				opacity: .4;
			}
			.deminputlempty::placeholder, .deminputwempty::placeholder, .deminputhempty::placeholder, .deminputwgtempty::placeholder, .deminputcfeeempty::placeholder, .aucinpute::placeholder, .aucdinpute::placeholder, .postsalepricee::placeholder, .postcoste::placeholder {
				opacity: 0.4;
	  		}
			
			.costarea {
				margin-top: 2px;
	  		}
			.ship_type, .ship_type_field, .address_type, .address_type_field, .unload_type, .unload_type_field, .d_appointment, .d_appointment_field, ._saved_status, ._saved_status_field, ._EBkeeponhold_input.short, ._EBkeeponhold, ._saved_ebay_transaction_id_input, ._sent_invoice, ._sent_invoice_field, ._sent_followup, ._sent_followup_field, ._found_by, ._found_by_field, ._sent_wireinv, ._sent_wireinv_field, ._sent_wireinfo, ._sent_wireinfo_field, ._sent_ebaymsg, ._sent_ebaymsg_field, ._ccr_ship_cost, ._ccr_ship_cost_field, ._pay_date, ._pay_date_field, ._ccr_ship_date, ._ccr_ship_date_field, ._saved_pay, ._saved_pay_field, ._saved_pay_tid, ._saved_pay_tid_field, ._ebayID, ._ebayID_field { display: inline-block; max-width: 19%; min-width: 120px; }
			._saved_shippingO, ._saved_billingO { display: inline-block; max-width: 50%; min-width: 50%; }
			._clear_line { clear: both; }
			.order_add_info { display: auto; }
			._saved_ebay_transaction_id_input, div._saved_ebay_transaction_id > p, ._saved_ebay_transaction_id_input_field { display: inline-block; max-width: 175px; min-width: 175px; }
			
			.saDatediv, .sasDatediv { width: 50%; float: left; }
	 		
  			.clearlinks, .restorelinks, .priceupdate, .locupdate, .marksold, .markoos, .brand_mpn_update, .stats_update, .shipclassbutton, .aucbutton, .condupdate, .linksinput, .postall, .postallorder, .cancelorderb, .deleteshipqlb, .ebaymsgbutton, .followupbutton, .specialinvoicebtn, .oNumbutton, .EBoNumbutton, .catbutton, .order_search_link, .order_log_link, .ship_quote_log_link, .shipnamebutton, .billnamebutton, .shipreadybutton, .cancelreadybutton, .copyallskubutton, .pc_log_link {
 				transition: 0.5s;
  				font-size: 9px;
				font-weight: bold;
				padding: 8px;
				text-align:center; 
				-webkit-border-radius: 5px;
				border-radius: 5px;
	        	box-shadow: 0 8px 6px -6px #444444;
	 		}
			.pc_log_label { overflow: visible; }
			.generateSA {
				transition: 0.5s !important;
  				font-size: 9px !important;
				font-weight: bold !important;
				padding: 8px !important;
				text-align:center !important; 
				-webkit-border-radius: 5px !important;
				border-radius: 5px !important;
	        	box-shadow: 0 8px 6px -6px #444444 !important;
			}
			.clearlinks:hover, .restorelinks:hover, .brand_mpn_update:hover, .stats_update:hover, .shipclassbutton:hover, .aucbutton:hover, .condupdate:hover, .linksinput:hover {
				box-shadow: 0 8px 6px -6px #444444, inset 0 -3.25em 0 0 #8d8d8d;
    			color: #ffffff;
			}
			.clearlinks, .restorelinks, .brand_mpn_update, .stats_update, .shipclassbutton, .aucbutton, .condupdate, .linksinput {
				width: 74px;
  				color: #8d8d8d;
	  			background: #ffffff;
  				border: 2px solid #9c8e7a;
	 		}
			.clearlinks:active, .restorelinks:active, .priceupdate:active, .marksold:active, .locupdate:active, .brand_mpn_update:active, .stats_update:active , .shipclassbutton:active, .aucbutton:active, .condupdate:active, .linksinput:active, .postall:active, .postallorder:active, .cancelorderb:active, .deleteshipqlb:active, .ebaymsgbutton:active, .followupbutton:active, .specialinvoicebtn:active, .oNumbutton:active, .EBoNumbutton:active, .order_search_link:active, .order_log_link:active, .pc_log_link:active, .ship_quote_log_link:active, .catbutton:active, .shipnamebutton:active, .billnamebutton:active, .shipreadybutton:active, .cancelreadybutton:active, .copyallskubutton:active {
				transform: translateY(6px);
			}
			 .generateSA:active {
				transform: translateY(6px) !important;
			}
			.clearlinks, .restorelinks {
				margin-top: 15px;
	 		}
			
			.clearlinksl, .restorelinksl, .mybulkeditl, .newbulkeditl[] {
				color: #8d8d8d !important;
				font-weight: bold;
			}
			.mybulkeditl, .newbulkeditl[]{
				font-size: 10px;	
			}
			
			.postall:before {
				content: "\e038";
				position:relative;
				font-family: 'ETmodules';
				font-size: 35px;
				top: -1px;
				display: flex;
    			justify-content: center;
    			align-items: center;
				color: #8d8d8d !important;
				zoom: inherit;
	  		}
			.postallorder:before {
				content: "\f2f1";
				position:relative;
				font: var(--fa-font-solid);
				font-family: "Font Awesome 6 Free";
				font-size: 24px;
				top: -5px;
				left: -5px;
    			justify-content: center;
    			align-items: center;
				color: #9c7349 !important;
				zoom: inherit;
				display: inline-block;
   				text-rendering: auto;
    			-webkit-font-smoothing: antialiased;
			}
			.ebaymsgbutton:before {
				content: "\f075";
				position:relative;
				font: var(--fa-font-solid);
				font-family: "Font Awesome 6 Free";
				font-size: 16px;
				top: -6px;
				left: -6px;
    			justify-content: center;
    			align-items: center;
				color: #9c7349 !important;
				zoom: inherit;
				display: inline-block;
   				text-rendering: auto;
    			-webkit-font-smoothing: antialiased;
			}
			.ebaymsgbutton:hover:after {
				content: "Copy eBay Message";
				font-family: Arial;
				font-size: 12px;
				color: white;
				background-color: #23282d;
				display: inline-block;
				padding: 3px;
				border: 2px solid #ffffff;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				position: relative;
				z-index: 10 !important;
				left: -30px; /* shift left */
				bottom: -5px; /* shift down */
			}
			.oNumbutton:before {
				content: "\23";
				position:relative;
				font: var(--fa-font-solid);
				font-family: "Font Awesome 6 Free";
				font-size: 17px;
				top: -5px;
				left: -5px;
    			justify-content: center;
    			align-items: center;
				color: #9c7349 !important;
				zoom: inherit;
				display: inline-block;
   				text-rendering: auto;
    			-webkit-font-smoothing: antialiased;
			}
			.oNumbutton:hover:after {
				content: "Copy Order #";
				font-family: Arial;
				font-size: 12px;
				color: white;
				background-color: #23282d;
				display: inline-block;
				padding: 3px;
				border: 2px solid #ffffff;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				position: relative;
				z-index: 10 !important;
				left: -10px; /* shift left */
				bottom: -5px; /* shift down */
			}
			.catbutton:before {
				content: "\f00b";
				position:relative;
				font: var(--fa-font-solid);
				font-family: "Font Awesome 6 Free";
				font-size: 16px;
				top: -5px;
				left: -6px;
    			justify-content: center;
    			align-items: center;
				color: #9c7349 !important;
				zoom: inherit;
				display: inline-block;
   				text-rendering: auto;
    			-webkit-font-smoothing: antialiased;
			}
			.catbutton:hover:after {
				content: "Copy Category";
				font-family: Arial;
				font-size: 12px;
				color: white;
				background-color: #23282d;
				display: inline-block;
				padding: 3px;
				border: 2px solid #ffffff;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				position: relative;
				z-index: 10 !important;
				left: -26px; /* shift left */
				top: -66px; /* shift up */
			}
			.shipreadybutton:before {
				content: "\f472";
				position:relative;
				font: var(--fa-font-solid);
				font-family: "Font Awesome 6 Free";
				font-size: 16px;
				top: 0px;
				left: -6px;
    			justify-content: center;
    			align-items: center;
				color: #9c7349 !important;
				zoom: inherit;
				display: inline-block;
   				text-rendering: auto;
    			-webkit-font-smoothing: antialiased;
			}
			.shipreadybutton:hover:after {
				content: "Copy Ship Ready Message";
				font-family: Arial;
				font-size: 12px;
				color: white;
				background-color: #23282d;
				display: inline-block;
				padding: 3px;
				border: 2px solid #ffffff;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				position: relative;
				z-index: 10 !important;
				left: -20px; /* shift left */
				bottom: -20px; /* shift down */
			}
			.cancelreadybutton:before {
				content: "\f057";
				position:relative;
				font: var(--fa-font-solid);
				font-family: "Font Awesome 6 Free";
				font-size: 16px;
				top: 0px;
				left: -6px;
    			justify-content: center;
    			align-items: center;
				color: #c40403 !important;
				zoom: inherit;
				display: inline-block;
   				text-rendering: auto;
    			-webkit-font-smoothing: antialiased;
			}
			.cancelreadybutton:hover:after {
				content: "Copy Cancel Ready Message";
				font-family: Arial;
				font-size: 12px;
				color: white;
				background-color: #23282d;
				display: inline-block;
				padding: 3px;
				border: 2px solid #ffffff;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				position: relative;
				z-index: 10 !important;
				left: -20px; /* shift left */
				bottom: -20px; /* shift down */
			}
			.shipnamebutton:before {
				content: "\f48b";
				position:relative;
				font: var(--fa-font-solid);
				font-family: "Font Awesome 6 Free";
				font-size: 16px;
				top: -5px;
				left: -8px;
    			justify-content: center;
    			align-items: center;
				color: #9c7349 !important;
				zoom: inherit;
				display: inline-block;
   				text-rendering: auto;
    			-webkit-font-smoothing: antialiased;
			}
			.shipnamebutton:hover:after {
				content: "Copy Ship Name";
				font-family: Arial;
				font-size: 12px;
				color: white;
				background-color: #23282d;
				display: inline-block;
				padding: 3px;
				border: 2px solid #ffffff;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				position: relative;
				z-index: 10 !important;
				left: -20px; /* shift left */
				top: -80px; /* shift up */
			}
			.copyallskubutton:before {
				content: "\f0cb";
				position:relative;
				font: var(--fa-font-solid);
				font-family: "Font Awesome 6 Free";
				font-size: 16px;
				top: -5px;
				left: -6px;
    			justify-content: center;
    			align-items: center;
				color: #585858 !important;
				zoom: inherit;
				display: inline-block;
   				text-rendering: auto;
    			-webkit-font-smoothing: antialiased;
			}
			.copyallskubutton:hover:after {
				content: "Copy All SKUs";
				font-family: Arial;
				font-size: 12px;
				color: white;
				background-color: #23282d;
				display: inline-block;
				padding: 3px;
				border: 2px solid #ffffff;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				position: relative;
				z-index: 10 !important;
				left: -20px; /* shift left */
				top: -80px; /* shift up */
			}
			.billnamebutton:before {
				content: "\f571";
				position:relative;
				font: var(--fa-font-solid);
				font-family: "Font Awesome 6 Free";
				font-size: 16px;
				top: -5px;
				left: -4px;
    			justify-content: center;
    			align-items: center;
				color: #9c7349 !important;
				zoom: inherit;
				display: inline-block;
   				text-rendering: auto;
    			-webkit-font-smoothing: antialiased;
			}
			.billnamebutton:hover:after {
				content: "Copy Bill Name";
				font-family: Arial;
				font-size: 12px;
				color: white;
				background-color: #23282d;
				display: inline-block;
				padding: 3px;
				border: 2px solid #ffffff;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				position: relative;
				z-index: 10 !important;
				left: -20px; /* shift left */
				top: -80px; /* shift up */
			}
			.followupbutton:before {
				content: "\f086";
				position:relative;
				font: var(--fa-font-solid);
				font-family: "Font Awesome 6 Free";
				font-size: 16px;
				top: -5px;
				left: -7px;
    			justify-content: center;
    			align-items: center;
				color: #9c7349 !important;
				zoom: inherit;
				display: inline-block;
   				text-rendering: auto;
    			-webkit-font-smoothing: antialiased;
			}
			.followupbutton:hover:after {
				content: "Copy Follow Up Message";
				font-family: Arial;
				font-size: 12px;
				color: white;
				background-color: #23282d;
				display: inline-block;
				padding: 3px;
				border: 2px solid #ffffff;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				position: relative;
				z-index: 10 !important;
				left: -30px; /* shift left */
				bottom: -5px; /* shift down */
			}
			.specialinvoicebtn:before {
				content: "\f658";
				position:relative;
				font: var(--fa-font-solid);
				font-family: "Font Awesome 6 Free";
				font-size: 30px;
				top: -5px;
				left: -5px;
    			justify-content: center;
    			align-items: center;
				color: #9c7349 !important;
				zoom: inherit;
				display: inline-block;
   				text-rendering: auto;
    			-webkit-font-smoothing: antialiased;
			}
			.specialinvoicebtn:hover:after {
				content: "Copy Special Invoice Email";
				font-family: Arial;
				font-size: 12px;
				color: white;
				background-color: #23282d;
				display: inline-block;
				padding: 3px;
				border: 2px solid #ffffff;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				position: relative;
				z-index: 10 !important;
				left: -30px; /* shift left */
				bottom: -5px; /* shift down */
			}
			.EBoNumbutton:before {
				content: "\f4f4";
				position:relative;
				font: var(--fa-brands);
				font-family: "Font Awesome 6 Brands";
				font-size: 22px;
				top: -7px;
				left: -7px;
    			justify-content: center;
    			align-items: center;
				color: #f4ae02 !important;
				zoom: inherit;
				display: inline-block;
   				text-rendering: auto;
    			-webkit-font-smoothing: antialiased;
			}
			.EBoNumbutton:hover:after {
				content: "Copy eBay Order #";
				font-family: Arial;
				font-size: 12px;
				color: white;
				background-color: #23282d;
				display: inline-block;
				padding: 3px;
				border: 2px solid #ffffff;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				position: relative;
				z-index: 10 !important;
				left: -10px; /* shift left */
				bottom: 0px; /* shift down */
			}
			.order_search_link:before {
				content: "\f65e";
				position:relative;
				font: var(--fa-font-solid);
				font-family: "Font Awesome 6 Free";
				font-size: 16px;
				top: -5px;
				left: -6px;
    			justify-content: center;
    			align-items: center;
				color: #9c7349 !important;
				zoom: inherit;
				display: inline-block;
   				text-rendering: auto;
    			-webkit-font-smoothing: antialiased;
			}
			.order_search_link:hover:after {
				content: "Isolate Order Alone";
				font-family: Arial;
				font-size: 12px;
				color: white;
				background-color: #23282d;
				display: inline-block;
				padding: 3px;
				border: 2px solid #ffffff;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				position: relative;
				z-index: 10 !important;
				right: -3ch; /* shift left */
				top: -7ch; /* shift up */
			}
			.order_log_link:before {
				content: "\f46d";
				position:relative;
				font: var(--fa-font-solid);
				font-family: "Font Awesome 6 Free";
				font-size: 16px;
				top: -5px;
				left: -4px;
    			justify-content: center;
    			align-items: center;
				color: #585858 !important;
				zoom: inherit;
				display: inline-block;
   				text-rendering: auto;
    			-webkit-font-smoothing: antialiased;
			}
			.order_log_link:hover:after {
				content: "Open Order Log";
				font-family: Arial;
				font-size: 12px;
				color: white;
				background-color: #23282d;
				display: inline-block;
				padding: 3px;
				border: 2px solid #ffffff;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				position: relative;
				z-index: 10 !important;
				left: -10px; /* shift left */
				bottom: -5px; /* shift down */
			}
			.pc_log_link:before {
				content: "\f46d";
				position:relative;
				font: var(--fa-font-solid);
				font-family: "Font Awesome 6 Free";
				font-size: 24px;
				top: -5px;
				left: -2px;
    			justify-content: center;
    			align-items: center;
				color: #585858 !important;
				zoom: inherit;
				display: inline-block;
   				text-rendering: auto;
    			-webkit-font-smoothing: antialiased;
			}
			.pc_log_link:hover:after {
				content: "Open Product Change Log";
				font-family: Arial;
				font-size: 12px;
				color: white;
				background-color: #23282d;
				display: inline-block;
				padding: 3px;
				border: 2px solid #ffffff;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				position: relative;
				z-index: 10 !important;
				left: -10px; /* shift left */
				bottom: -5px; /* shift down */
			}
			.ship_quote_log_link:before {
				content: "\24\f48b";
				position:relative;
				font: var(--fa-font-solid);
				font-family: "Font Awesome 6 Free";
				font-size: 16px;
				top: -5px;
				left: -4px;
    			justify-content: center;
    			align-items: center;
				color: #585858 !important;
				zoom: inherit;
				display: inline-block;
   				text-rendering: auto;
    			-webkit-font-smoothing: antialiased;
			}
			.ship_quote_log_link:hover:after {
				content: "Open Ship Quote Log";
				font-family: Arial;
				font-size: 12px;
				color: white;
				background-color: #23282d;
				display: inline-block;
				padding: 3px;
				border: 2px solid #ffffff;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				position: relative;
				z-index: 10 !important;
				right: -5ch; /* shift left */
				top: -7ch; /* shift up */
			}
			.cancelorderb:before{
				content: "\f057";
				position:relative;
				font: var(--fa-font-solid);
				font-family: "Font Awesome 6 Free";
				font-size: 24px;
				top: -7px;
				left: -7px;
    			justify-content: center;
    			align-items: center;
				display: inline-block;
   				text-rendering: auto;
    			-webkit-font-smoothing: antialiased;
				color: #c40403 !important;
				zoom: inherit;
			}
			.cancelorderb:hover:after {
				content: "Cancel Order";
				font-family: Arial;
				font-size: 12px;
				color: white;
				background-color: #23282d;
				display: inline-block;
				padding: 3px;
				border: 2px solid #ffffff;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				position: relative;
				z-index: 10 !important;
				left: -10px; /* shift left */
				bottom: -5px; /* shift down */
			}
			.deleteshipqlb:before{
				content: "\f057\24\f48b";
				position:relative;
				font: var(--fa-font-solid);
				font-family: "Font Awesome 6 Free";
				font-size: 24px;
				top: -7px;
				left: -7px;
    			justify-content: center;
    			align-items: center;
				display: inline-block;
   				text-rendering: auto;
    			-webkit-font-smoothing: antialiased;
				color: #c40403 !important;
				zoom: inherit;
			}
			.deleteshipqlb:hover:after {
				content: "Delete Ship Quote Log";
				font-family: Arial;
				font-size: 12px;
				color: white;
				background-color: #23282d;
				display: inline-block;
				padding: 3px;
				border: 2px solid #ffffff;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				position: relative;
				z-index: 10 !important;
				right: 0ch; /* shift left */
				top: -15ch; /* shift up */
			}
			.generateSA:before{
				content: "\f570" !important;
				position:relative !important;
				font: var(--fa-font-solid) !important;
				font-family: "Font Awesome 6 Free" !important;
				font-size: 20px !important;
				top: -5px !important;
				left: -2px !important;
    			justify-content: center !important;
    			align-items: center !important;
				color: #9c7349 !important;
				zoom: inherit !important;
				display: inline-block !important;
   				text-rendering: auto !important;
    			-webkit-font-smoothing: antialiased !important;
			}
			.generateSA:hover:after {
				content: "Generate SA PDF" !important;
				font-family: Arial !important;
				font-size: 12px !important;
				color: white !important;
				background-color: #23282d !important;
				display: inline-block !important;
				padding: 3px !important;
				border: 2px solid #ffffff !important;
				-webkit-border-radius: 5px !important;
				border-radius: 5px !important;
				position: relative !important;
				z-index: 10 !important;
				left: -18px !important; /* shift left */
				bottom: 0px !important; /* shift down */
			}
			.priceupdate, .locupdate, .postsaleprice, .brand_mpn_update, .stats_update, .shipclassbutton, .aucbutton, .condupdate, .linksinput {
				margin-top: 5px;
	 		}
			.priceupdate, .locupdate {
				background:#ffffff;
				color:#4E7E3B;
				border: 2px solid #4E7E3B;
	 		}
			
			.postlocupdate {
				width: 92px;
				text-align:center;
	  		}
			.locupdate {
				width: 42px;
				font-size: 14px;
				font-weight: bold;
				text-align:center; 
	  		}
			.priceupdate:hover, .locupdate:hover {
				color:#ffffff;
				border: 2px solid #9c9c9c;
				box-shadow: 0 8px 6px -6px #444444, inset 0 -3.25em 0 0 #82d363;
			}
    		.marksold {
				width: 68px;
				margin-top: 5px auto;
				background-color:#ffffff;
				color:#af4f5e;
				border: 2px solid #a08100;
	 		}
			.postall {
				/*margin-top: 5px auto;*/
				color:#32373b;
				border: 2px solid #4E7E3B;
				/*margin-top: 20px;*/
				height: 50px;
				width: 50px;
			}
			.postallorder {
				color:#f8dda7;
				border: 2px solid #9c7349;
				background:#f7dca5;
				height: 35px;
				width: 35px;
			}
			.ebaymsgbutton, .followupbutton, .oNumbutton, .catbutton, .order_search_link, .shipnamebutton, .billnamebutton {
				margin-bottom: 15px;
				margin-left: 5px;
				color:#f8dda7;
				border: 2px solid #9c7349;
				background:#f7dca5;
				height: 25px !important;
				width: 25px !important;
				display: inline-block;
			}
			.order_log_link, .copyallskubutton {
				margin-bottom: 15px;
				margin-left: 5px;
				color:#c8c8c8;
				border: 2px solid #585858;
				background:#c8c8c8;
				height: 25px !important;
				width: 25px !important;
				display: inline-block;
			}
			.pc_log_link {
				margin-bottom: 15px;
				margin-left: 5px;
				color:#c8c8c8;
				border: 2px solid #585858;
				background:#c8c8c8;
				height: 35px !important;
				width: 35px !important;
				display: inline-block;
			}
			.ship_quote_log_link {
				margin-bottom: 15px;
				margin-left: 5px;
				color:#c8c8c8;
				border: 2px solid #585858;
				background:#c8c8c8;
				height: 25px !important;
				width: 40px !important;
				display: inline-block;
			}
			.generateSA {
				margin-top: 10px !important;
				margin-bottom: 15px !important;
				margin-left: 5px !important;
				bottom: -10px !important;
				color:#f8dda7 !important;
				border: 2px solid #9c7349 !important;
				background:#f7dca5 !important;
				max-height: 10px !important;
				max-width: 10px !important;
				min-height: 10px !important;
				min-width: 10px !important;
				display: inline-block !important;
			}
			.EBoNumbutton {
				/*margin-bottom: 15px;*/
				margin-left: 5px;
				color:#ffffff;
				border: 2px solid #f4ae02;
				background:#ffffff;
				height: 25px;
				width: 35px;
				display: inline-block;
				position: relative;
				top: 6px;
			}
			.specialinvoicebtn {
				margin-bottom: 15px;
				margin-left: 5px;
				color:#f8dda7;
				border: 2px solid #9c7349;
				background:#f7dca5;
				height: 40px;
				width: 40px;
				display: inline-block;
			}
			.shipreadybutton {
				margin-bottom: 5px;
				margin-left: 5px;
				color:#f8dda7;
				border: 2px solid #9c7349;
				background:#f7dca5;
				display: inline-block;
			}
			.cancelreadybutton {
				margin-bottom: 5px;
				margin-left: 5px;
				color:#aaaaaa;
				border: 2px solid #c40403;
				background:#aaaaaa;
				display: inline-block;
			}
			.postallorder {
				margin-bottom: 20px;
			}
			.cancelorderb, .deleteshipqlb {
				color:#aaaaaa;
				border: 2px solid #c40403;
				background:#aaaaaa;
				height: 30px;
				width: 30px;
			}
			.deleteshipqlb { width: 80px; }
			
			.marksold:hover  {
				color:#ffffff;
				box-shadow: 0 8px 6px -6px #444444, inset 0 -68px 0 0 #af4f5e;
			}
			.postall:hover {
				color:#4E7E3B;
				border: 2px solid #82d363;
				box-shadow: 0 8px 6px -6px #444444, inset 50px 0 0 0 #32373b;
			}
			.postallorder:hover, .ebaymsgbutton:hover, .followupbutton:hover, .specialinvoicebtn:hover, .oNumbutton:hover, .EBoNumbutton:hover, .order_search_link:hover, .catbutton:hover,  .shipnamebutton:hover, .billnamebutton:hover {
				color:#f7dca5 !important;
				border: 2px solid #f7dca5 !important;
				box-shadow: 0 8px 6px -6px #444444, inset 45px 0 0 0 #32373b !important;
			}
			.order_log_link:hover, .copyallskubutton:hover{
				color:#f7dca5 !important;
				border: 2px solid #c8c8c8 !important;
				box-shadow: 0 8px 6px -6px #444444, inset 45px 0 0 0 #32373b !important;
			}
			.ship_quote_log_link:hover, .pc_log_link:hover {
				color:#f7dca5 !important;
				border: 2px solid #c8c8c8 !important;
				box-shadow: 0 8px 6px -6px #444444, inset 65px 0 0 0 #32373b !important;
			}
			.generateSA:hover {
				color:#f7dca5 !important;
				border: 2px solid #f7dca5 !important;
				box-shadow: 0 8px 6px -6px #444444, inset 45px 0 0 0 #32373b !important;
			}
			.shipreadybutton:hover {
				color:#f7dca5;
				border: 2px solid #f7dca5;
				box-shadow: 0 8px 6px -6px #444444, inset 120px 0 0 0 #32373b;
			}
			.cancelreadybutton:hover {
				color:#aaaaaa;
				border: 2px solid #aaaaaa;
				box-shadow: 0 8px 6px -6px #444444, inset 120px 0 0 0 #32373b;
			}
			.cancelorderb:hover, .deleteshipqlb:hover {
				color:#aaaaaa;
				border: 2px solid #aaaaaa;
				box-shadow: 0 8px 6px -6px #444444, inset 35px 0 0 0 #32373b;
			}
			.deleteshipqlb:hover {
				box-shadow: 0 8px 6px -6px #444444, inset 85px 0 0 0 #32373b; }
			
			.admin_link_fb2 span[id="onhover"], .admin_link_yt span[id="onhover"], .admin_link_360 span[id="onhover"], .loglinknew span[id="onhover"] {
  				display: none;
				-webkit-border-radius: 15px !important;
				border-radius: 15px !important;
			}
	  		.admin_link_fb2:hover span[id="initial"], .admin_link_yt:hover span[id="initial"], .admin_link_360:hover span[id="initial"], .loglinknew:hover span[id="initial"] {
 				 display: none;
				 -webkit-border-radius: 15px !important;
				 border-radius: 15px !important;
			}
			.admin_link_fb2:hover span[id="onhover"], .admin_link_yt:hover span[id="onhover"], .admin_link_360:hover span[id="onhover"], .loglinknew:hover span[id="onhover"] {
 				 display: block;
				 -webkit-border-radius: 15px !important;
				 border-radius: 15px !important;
			}
			
			.admin_lsn_logo {
				display: inline-block;
				font-weight: bold;
				color:#ffffff;
				background-color:#e36917;
				text-align:center; 
				-webkit-border-radius: 5px;
				border-radius: 5px;
				transition: 0.5s;
				padding: 5px;
				/*border: 2px solid #ffffff;*/
			}
			.admin_lsn_logo:hover {
				background-color:#ffffff;
				color:#e36917;
				/*border: 2px solid #e36917;*/
	  		}
			.admin_lsn_link {
				color: #ffffff;
				margin-left: auto ;
  				margin-right: auto ;
			}
			.admin_lsn_link:hover {
				color: #e36917;
			}
			
			.ebayo, .wso, .qboo, .auco, .keep, .fix, .scrap {
				display: inline-block;
				font-size: 12px;
				font-weight: bold;
				color:#ffffff; 
				text-align:center; 
				padding: 10px; 
				-webkit-border-radius: 5px;
				border-radius: 5px;
				margin-bottom: 5px;
				margin-left: auto;
  				margin-right: auto;
	  		}
			.ebayo { background: #0364c4; }
			.wso { background: #c40403; }
			.qboo { background: #2ca01c; }
	  		.auco { background: #6769b6; }
			.keep { background: #969696; }
			.fix { background: #a08100; }
			.scrap { background: #969696; }
			
			.admin_link_sku {
	  			display: inline-block;
				font-size: 18px;
				font-weight: bold;
				color:#ffffff; 
				background-color:#969696; 
				text-align:center; 
				padding: 10px; 
				-webkit-border-radius: 5px;
				border-radius: 5px;
				transition: 0.5s;
				border: 2px solid #ffffff;
				margin-bottom: 5px;
				margin-left: auto ;
  				margin-right: auto ;
			}
			.admin_link_sku:hover  {
				background-color:#ffffff; 
				color: #969696;
				border: 2px solid #969696;
			}
			.admin_link_skulink {
				color: #ffffff;
				margin-left: auto ;
  				margin-right: auto ;
	  		}
			.admin_link_skulink:hover {
				color: #969696;
			}
			
			.slide {  
	  			width: 64px;
  				color: #8d8d8d;
 				transition: 0.5s;
	  			background: #ffffff;
  				border: 2px solid #9c8e7a;
  				font-size: 9px;
				font-weight: bold;
				padding: 8px;
				text-align:center; 
				-webkit-border-radius: 5px;
				border-radius: 5px;
  			}
	  		.slide:hover, .slide:focus {
  				box-shadow: inset 64px 0 0 0 #8d8d8d;
  				border-color: #8d8d8d;
    			color: #ffffff;
			}
			
			.listerdiv, .branddiv, .modeldiv {
				padding:2px;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				text-align:center; 
	  		}
			.listerdiv, .modeldiv {
				margin-top: 5px;
	  		}
			
	  		.shipcolumn {
				color: #4167b2 !important;
				font-weight:bold;
				font-size: 14px !important;
	  		}
			
	  		.vlinkinput, .lsninput, .threesixtylink {
				min-width: 50px;
				max-width: 100px;
				text-align:center;
	 			margin-left: auto ;
  				margin-right: auto ;
				border: 1px solid #8d8d8d !important;
				background: transparent !important;
				font-size: 9px;
				color: #c8c8c8 !important;
	  		}
			.lsninput { font-size: 12px; }
			.lsnlinput, .lsncinput, .fblinput, .fbcinput, .cllinput, .clcinput, .ebclinput, .ebccinput {
				min-width: 55px;
				max-width: 55px;
				text-align:center;
	 			margin-left: auto ;
  				margin-right: auto ;
				border: 1px solid #8d8d8d !important;
				background: transparent !important;
				font-size: 9px;
				color: #c8c8c8 !important;
	  		}
	.lsnaccdate { min-width: 50px;
				max-width: 100px;
				text-align:center;
	 			margin-left: auto ;
  				margin-right: auto ;
				background: transparent !important;
				border: 1px solid #ffffff !important;
				font-size: 9px;
				color: #c8c8c8 !important; }
	.lsndaterenew { min-width: 55px;
				max-width: 55px;
				text-align:center;
	 			margin-left: auto ;
  				margin-right: auto ;
				background: transparent !important;
				border: 1px solid #ffffff !important;
				font-size: 9px;
				color: #c8c8c8 !important; }
			.vlinkinput::placeholder, .lsninput::placeholder, .threesixtylink::placeholder,
			.lsnlinput::placeholder, .lsncinput::placeholder, .fblinput::placeholder, .fbcinput::placeholder, .cllinput::placeholder, .clcinput::placeholder {
				color: #8d8d8d;
				font-weight: bold;
				font-size: 9px;
	  		}
	.lsndaterenew::placeholder, .lsnaccdate::placeholder {
		color: #ffffff !important;
		font-weight: bold;
		font-size: 12px;
		opacity: .5;
	}
			.linkinputdiv {
				display:flex; 
				flex-direction: row; 
				justify-content: center; 
				align-items: center;
				font-size:9px;
	  		}
			.formaction, .soldbyform3, .clearlinksbox, .restorelinksbox, .dnlbox, .mybulkeditbox, .newbulkeditbox[] , .upscheckbox, .ThirdPcheckbox, .lpcheckbox, .post[], .mybulkedit {
				background-color: #c8c8c8 !important;
			}
			.dnlbox[type="checkbox"]:checked:before {
				color: #c40403 !important;
			}
			.newFBbox[type="checkbox"]:checked:before {
				color: #1777f2 !important;
			}
			.mybulkeditbox[type="checkbox"], .post[type="checkbox"], .clearlinksbox[type="checkbox"], .restorelinksbox[type="checkbox"], body:not(.gutenberg-editor-page) input[type=checkbox] {
				background: #c8c8c8 !important;
			}
			
			#_manage_stock[type="checkbox"], #_manage_stock[type="checkbox"]:checked:before, #_sold_individually[type="checkbox"], #_sold_individually[type="checkbox"]:checked:before, #_dnl_eBay[type="checkbox"], #_dnl_eBay[type="checkbox"]:checked:before { color: #000000 !important; }
			#upscheck, .upscheckl, #ThirdPcheck, .ThirdPcheckl, #lpcheck, #cashcheck[type="checkbox"], .cashcheckl, #checkcheck[type="checkbox"], .checkcheckl, #wirecheck[type="checkbox"], .wirecheckl, #taxexempt, #addebaymsg, .addebaymsgl, input[id*='cb-select'] { color: #a1a8ab !important; }
			
			.admin_auc_sold, .admin_ws_sold, .admin_ebay_sold {
				background-color: #ffffff;
			}
			.shipcostinput[type="text"] {
				min-width: 80px;
				width: 100%;
				-webkit-border-radius: 5px;
				border-radius: 5px;
				/*border: 4px solid #c40403 !important;*/
				background-color: #c8c8c8 !important;
				text-align: center;
				margin-left: auto ;
  				margin-right: auto ;
				color:#000000 !important;
			}
			
			.date_alert { color: #c40403; background-color: #ffffff; -webkit-border-radius: 5px; border-radius: 5px; padding: 3px; border: 3px solid #c40403; }
			.date_normal { -webkit-border-radius: 5px; border-radius: 5px; padding: 3px; border: 3px solid #bbc8d4; }
			
			.addressinput, .addressinputst, .addressinput2, .addressinputst2, .addressinput2add, .nameinput, .businput, .trackNumInput, .shipCostInput, .shipDateInput, .feedbackInput, .setEmailInput, .addEmailInput, .setPhoneInput, .setPhoneInput2 , .carrierInput2, .terminal_zipBE, ._length_inputBE, ._width_inputBE, ._height_inputBE, ._weight_inputBE, ._pallet_feeBE, ._CCR_ship_costBE {
				-webkit-border-radius: 5px;
				border-radius: 5px;
				border: 2px solid #444444 !important;
				background-color: #c8c8c8 !important;
				text-align: center;
				margin-left: auto ;
  				margin-right: auto ;
				color:#000000 !important;
			}
			.carrierInput, .addTypeInputBE, .forkDockInputBE, .dApptInputBE, .shipTypeInputBE, ._found_byBE, .terminalBE {
				-webkit-border-radius: 5px;
				border-radius: 5px;
				border: 2px solid #444444 !important;
				background-color: #c8c8c8 !important;
				text-align: center;
				margin-left: auto ;
  				margin-right: auto ;
				color: #969696 !important;
			}
			.carrierInput { width: 162px; resize:none; }
			.addressinput::placeholder, .shipcostinput::placeholder, .addressinputst::placeholder, .addressinput2::placeholder, .addressinputst2::placeholder, .addressinput2add::placeholder, .nameinput::placeholder, .businput::placeholder, .trackNumInput::placeholder, .shipCostInput::placeholder, .carrierInput::placeholder, .shipDateInput::placeholder, .feedbackInput::placeholder, .setEmailInput::placeholder, .addEmailInput::placeholder, .setPhoneInput::placeholder, .setPhoneInput2::placeholder, .carrierInput2::placeholder, .terminal_zipBE::placeholder, ._length_inputBE::placeholder, ._width_inputBE::placeholder, ._height_inputBE::placeholder, ._weight_inputBE::placeholder, ._pallet_feeBE::placeholder, ._CCR_ship_costBE::placeholder {
				color: #969696;
			}
			.carrierInput2::placeholder, .nameinput::placeholder, .businput::placeholder, .addEmailInput::placeholder, .shipDateInput::placeholder, .feedbackInput::placeholder, .terminalBE::placeholder { font-size: 10px; }
			
			.orderPhone { margin-top: 10px; color: #ffffff; }
			
			.orderqty { font-weight: bold !important; background-color: #ffffff !important; color: #000000 !important; font-size: 20px !important; -webkit-border-radius: 10px;
				border-radius: 10px; }
			.order_tax, .order_subtotal, .order_total, .order_totalccr, .order_notes, .ebay_msg {
				vertical-align: top !important;	
			}
			.order_totalccr { text-align: right; }
			.addebaymsgl { font-size: 10px; }
			.noteinput { color: #ffffff; margin-bottom: 5px; margin-top: 5px; resize: none !important; background-color: rgba(0, 0, 0, 0) !important; width: 200px; border-style: solid; border-width: 2px !important; border-color: #ffffff !important; }
			td.order_notes.column-order_notes > span > label { color: #ffffff !important; }
			
			/* remove annoying WP Markdown Editor Sale Notice */
			#wpbody-content > div.wrap > div.notice.notice-info.is-dismissible.christmas_notice {
				display: none;
			}
			/* outline Exempt label */
			.taxexemptl, .shipConflict { color: #cccccc !important;
				font-weight: bold;
				font-size: 12px;
				text-shadow: -1px 1px 0 #c40403,
				  1px 1px 0 #c40403,
				 1px -1px 0 #c40403,
				-1px -1px 0 #c40403 !important; }
			.sendinvcheckl { color: #cccccc !important;
				font-weight: bold;
				text-shadow: -1px 1px 0 #c40403,
				  1px 1px 0 #c40403,
				 1px -1px 0 #c40403,
				-1px -1px 0 #c40403 !important; }
			.sendinvwirel { color: #696254 !important;
				font-weight: bold;
				text-shadow: -1px 1px 0 #ffffff,
				  1px 1px 0 #ffffff,
				 1px -1px 0 #ffffff,
				-1px -1px 0 #ffffff !important; }
			.sendwireinfol { color: #cccccc !important;
				font-weight: bold;
				text-shadow: -1px 1px 0 #008bff,
				  1px 1px 0 #008bff,
				 1px -1px 0 #008bff,
				-1px -1px 0 #008bff !important; }
			.sendfollowupl { color: #cccccc !important;
				font-weight: bold;
				text-shadow: -1px 1px 0 #9c7349,
				  1px 1px 0 #9c7349,
				 1px -1px 0 #9c7349,
				-1px -1px 0 #9c7349 !important; }
			.cratefee { color: #cccccc !important;
				font-weight: bold;
				text-shadow: -1px 1px 0 #c40403 ,
				  1px 1px 0 #c40403,
				 1px -1px 0 #c40403,
				-1px -1px 0 #c40403 !important; }
			.costorder { color: #cccccc !important;
				font-weight: bold;
				text-shadow: -1px 1px 0 #c40403,
				  1px 1px 0 #c40403,
				 1px -1px 0 #c40403,
				-1px -1px 0 #c40403 !important; }
			
			/* change checkbox colors when checked */
			.taxexempt[type=checkbox]:checked:before { color: #c40403 !important; }
			.taxexemptx[type=checkbox]:checked:before { color: #a2b899 !important; }
			.cashcheck[type=checkbox]:checked:before { color: #70995d !important; }
			.checkcheck[type=checkbox]:checked:before { color: #9c8e7a !important; }
			.wirecheck[type=checkbox]:checked:before { color: #008bff !important; }
			.upscheckbox[type=checkbox]:checked:before { color: #ffbe03 !important; }
			.ThirdPcheckbox[type=checkbox]:checked:before { color: #92b5d1 !important; }
			.lpcheckbox[type=checkbox]:checked:before { color: #d19c9c !important; }
			.clearshipcheckbox[type=checkbox]:checked:before { color: #ffffff !important; }
			.sendinvcheck[type=checkbox]:checked:before { color: #c40403 !important; }
			.sendinvwire[type=checkbox]:checked:before { color: #f8dda7 !important; }
			.sendwireinfo[type=checkbox]:checked:before { color: #008bff !important; }
			.sendfollowup[type=checkbox]:checked:before { color: #9c7349 !important; }
			.billaddonly[type=checkbox]:checked:before { color: #82d363 !important; }
			.shipaddonly[type=checkbox]:checked:before { color: #f8dda7 !important; }
			
			.cashradio[type=radio]:checked:before { background-color: #b2fc95 !important; }
			.checkradio[type=radio]:checked:before { background-color: #f8dda7 !important; }
			.wireradio[type=radio]:checked:before { background-color: #c8c8c8 !important; }
			.texemptradio[type=radio]:checked:before { background-color: #c40403 !important; }
			.texemptxradio[type=radio]:checked:before { background-color: #a2b899 !important; }
			.upsradio[type=radio]:checked:before { background-color: #ffbe03 !important; }
			.tpfradio[type=radio]:checked:before { background-color: #92b5d1 !important; }
			.termdradio[type=radio]:checked:before { background-color: #9fc0c0 !important; }
			.lpradio[type=radio]:checked:before { background-color: #d19c9c !important; }
			.clearallradio[type=radio]:checked:before { background-color: #ffffff !important; }
			.noneradio[type=radio]:checked:before { background-color: #303030 !important; }
			
			
			/** SECTION 1 divi checkboxes **/

/* Hide / change the OS/Browser checkboxes / radio buttons check marks checkmarks */
input[type=checkbox] {
  visibility: hidden!important;
  margin: 0!important;
  width: 0!important;
}

/* Set Elegant Icont font, size, & positioning for the checkboxes/radio buttons plus the cursor on hover */
input[type=checkbox]:before,
input[type=checkbox]:before {
  visibility: visible;  
  font-family: "ETmodules";
  font-size: 20px;
  display: inline-block !important;
  position: relative;
  top: 6px;
}
input[type=checkbox]:checked:before { top: 9px; left: 3px; }
input[type=checkbox]:hover,
input[type=checkbox]:hover { 
  cursor: pointer; 
}

/** SECTION 2 **/

/* Set checkbox to ET icons: normal, hover, checked, & checked hover */
input[type=checkbox]:before,
input[type=checkbox]:before { 
  content: '\56'; 
}
input[type=checkbox]:hover:before,
input[type=checkbox]:hover:before {
  content: '\56'; 
  filter: alpha(opacity=20); 
  opacity: 0.2;
}
input[type=checkbox]:checked:before,
input[type=checkbox]:checked:before {
  content: '\5a';
}
input[type=checkbox]:checked:hover:before,
input[type=checkbox]:checked:hover:before { 
  filter: alpha(opacity=100); opacity: 1; 
}
input[type=checkbox]:checked:before {  }
label { padding-left: 4px !important; }

/* Set radio buttons Divi icons: normal, hover, checked, & checked hover 
input[type=radio] + label:before { 
  content: '\5b';
}
input[type=radio] + label:hover:before { 
  content: '\5c'; 
  filter: alpha(opacity=20); 
  opacity: 0.2; 
}
input[type=radio]:checked + label:before { 
  content: '\5c'; 
}
input[type=radio]:checked + label:hover:before { 
  filter: alpha(opacity=100); opacity: 1; 
}*/
				
			
			.notice-accent-color { color: #00a0d2; }
			/* warning color for wp-lister changed items */
			#the-list > tr > td > small { color: #cc9696 !important; }
			/* highlight important boxes for products */
			select#product_shipping_class, input#_customship, input#_ccrind_brand, input#_ccrind_mpn { background-color: #c40403; }
			::placeholder { color: #b6b6b6; }
			/* hide boxes created by using display none with woocommerce header */
			body:not(.gutenberg-editor-page) #wpbody #screen-options-link-wrap, body:not(.gutenberg-editor-page) #wpbody #contextual-help-link-wrap { background-color: #22272d00; }
			/* move the whole body of the page up to account for header display none */
			#wpbody { position: relative; top: -23px; }
			
	  		.woocommerce-layout__header, .woocommerce-layout__activity-panel-tabs, .woocommerce-layout__header-breadcrumbs, .woocommerce-layout__primary { visibility: none; display: none; }
	  
	  /*#show-settings-link, #contextual-help-link, #screen-options-wrap{
		margin-top: -50px;  
	  }*/
			
	  .formaction, .soldbyform3, .qtyupdate {
		  width: 100%;
		  max-width: 100%;
		  margin-bottom:16px;
	  }
			
		h1.product_title.entry-title {
	-webkit-animation: slide-in-blurred-top 1.2s cubic-bezier(0.230, 1.000, 0.320, 1.000) both !important;
	        animation: slide-in-blurred-top 1.2s cubic-bezier(0.230, 1.000, 0.320, 1.000) both !important;
			color: #ffffff !important;
}
/**
 * ----------------------------------------
 * animation slide-in-blurred-top
 * ----------------------------------------
 */
@-webkit-keyframes slide-in-blurred-top {
  0% {
    -webkit-transform: translateY(-1000px) scaleY(2.5) scaleX(0.2);
            transform: translateY(-1000px) scaleY(2.5) scaleX(0.2);
    -webkit-transform-origin: 50% 0%;
            transform-origin: 50% 0%;
    -webkit-filter: blur(40px);
            filter: blur(40px);
    opacity: 0;
  }
  100% {
    -webkit-transform: translateY(0) scaleY(1) scaleX(1);
            transform: translateY(0) scaleY(1) scaleX(1);
    -webkit-transform-origin: 50% 50%;
            transform-origin: 50% 50%;
    -webkit-filter: blur(0);
            filter: blur(0);
    opacity: 1;
  }
}
@keyframes slide-in-blurred-top {
  0% {
    -webkit-transform: translateY(-1000px) scaleY(2.5) scaleX(0.2);
            transform: translateY(-1000px) scaleY(2.5) scaleX(0.2);
    -webkit-transform-origin: 50% 0%;
            transform-origin: 50% 0%;
    -webkit-filter: blur(40px);
            filter: blur(40px);
    opacity: 0;
  }
  100% {
    -webkit-transform: translateY(0) scaleY(1) scaleX(1);
            transform: translateY(0) scaleY(1) scaleX(1);
    -webkit-transform-origin: 50% 50%;
            transform-origin: 50% 50%;
    -webkit-filter: blur(0);
            filter: blur(0);
    opacity: 1;
  }
}
	</style>;

<?php
	global $current_user;
    wp_get_current_user();
	$email = $current_user->user_email;
	/* change only for Jedidiah jed css */
	if ($email == "jedidiah@ccrind.com")
	{
		?>
        <style type="text/css">
			#wpbody-content > div.wrap > a { color: #ffffff; }
			/* link color admin pages */
			body:not(.gutenberg-editor-page) a, body:not(.gutenberg-editor-page) .button-link, #wpadminbar .ab-icon, #wpadminbar .ab-icon:before, #wpadminbar .ab-item:after, #wpadminbar .ab-item:before {
				color: #8d9bda !important; }
			/* link color admin pages on hover */
			body:not(.gutenberg-editor-page) a:hover { color: #c6cded !important; }
			/* background for menus and header admin area */
			#adminmenu, #adminmenuback, #adminmenuwrap, #wpadminbar {background: #404663 !important;	}
			/* wordpress side menu link color */
			div.wp-menu-name { color: #ffffff; }
			/* background of highlighted current menu (sub menu) */
			ul { background: #5c5c5c !important; }
			/* button links at top of page colors and update button on product edit page*/
			#wpbody-content > div.wrap > a, a.button.button-primary.wpl_job_button, input#publish.button {
				/*color: #ffffff !important;*/
				background: #fffa8d !important; }
			/* button links at top of page colors and update button on product edit page (on hover) */
			#wpbody-content > div.wrap > a:hover, a.button.button-primary.wpl_job_button:hover, input#publish.button:hover, input#publish.button.disabled {
				color: #fffa8d !important;
				background-color: #bcbcbc !important; 
				text-shadow: 0 -1px 1px #363636, 1px 0 1px #363636, 0 1px 1px #363636, -1px 0 1px #363636; !important}
			/* current menu header background color and menu link hover color, add new import export top buttons background */
			#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, #adminmenu a:hover {
				background: #fffa8d !important; 
				/* outline the text */
				text-shadow: 0 -1px 1px #363636, 1px 0 1px #363636, 0 1px 1px #363636, -1px 0 1px #363636; }
			/* notice accent colors top of admin pages woocommerce */
			.notice-accent-color { color: #fffa8d !important; }
			.notice-info { border-left-color: #fffa8d !important; }
			div.updated { border-left-color: #b8ce50 !important; }
			/* numbers in menus background color */
			#adminmenu li.current a .awaiting-mod { background: #8d9bda !important; }
			/* arrow of current menu color */
			.woocommerce-page .wp-has-current-submenu:after { border-right-color: #22272d; }
			/* order note colors */
			div.note_content > p { background-color: #ffffff; color: #444444 !important; }
			/* change plugins update count circle color and text outline */
			#menu-plugins > a > div.wp-menu-name > span { background: #fffa8d; text-shadow: 0 -1px 1px #363636, 1px 0 1px #363636, 0 1px 1px #363636, -1px 0 1px #363636; !important}
			/* change the filter menu links to blend in with base background color */
			#wpbody-content > div.wrap > ul > li, ul.subsubsub { background-color: #22272d !important; }
			/* change hover and focus color for filter select boxes and search box */
			input[type=checkbox]:focus, input[type=color]:focus, input[type=date]:focus, input[type=datetime-local]:focus, input[type=datetime]:focus, input[type=email]:focus, input[type=month]:focus, input[type=number]:focus, input[type=password]:focus, input[type=radio]:focus, input[type=search]:focus, input[type=tel]:focus, input[type=text]:focus, input[type=time]:focus, input[type=url]:focus, input[type=week]:focus, select:focus, textarea:focus, .wp-core-ui select:hover, #posts-filter > div.tablenav.top > div > span > span.selection > span, { 
				border-color: #fffa8d;
    			/*color: #fffa8d;*/
				box-shadow: 0 0 0 1px #fffa8d; }
			#search-submit { 
				color: #fffa8d;
				border-color: #fffa8d; 
				background: #707070; }
			#search-submit:hover { 
				color: #707070;
				border-color: #707070; 
				background: #fffa8d; }
			/*#changedesc { background: #ffffff !important }*/
			/* admin order pages buttons background colors */
			body:not(.gutenberg-editor-page).wp-core-ui .button-primary { background: #fffa8d; }
			body:not(.gutenberg-editor-page).wp-core-ui .button-primary:hover { background: #bcbcbc; color: #fffa8d; }
			/* admin order page input text color */
			#woocommerce-order-items .woocommerce_order_items_wrapper table.woocommerce_order_items td input { color: #ffffff; }
			/* admin order inside order page input text color */
			#woocommerce-order-items .woocommerce_order_items_wrapper table.woocommerce_order_items td textarea { color: #ffffff; }
			/* order edit page dark mode */
			#woocommerce-order-data > div.inside > div, #order_data > div.order_data_column_container > div > h3,
			#wpo_wcpdf-data-input-box > div.inside, #woocommerce-order-items > div.inside > div,
			#woocommerce-order-items > div.inside > div.woocommerce_order_items_wrapper.wc-order-items-editable > table,
			#wpo_wcpdf-data-input-box > div.inside > div, #wooccm-order-files > div.inside > div > table > tbody { background: #444444; color: #ffffff; }
			#wpbody-content > div.wrap > a { color: #ffffff !important; }
			/* dark mode for product and order lists 
			#wpbody-content > div.wrap, #wpcontent { background: #444444 }
			#posts-filter > table > thead > tr, #posts-filter > table > tfoot { background: #707070 }
			#the-list { background: #333333 }
			#posts-filter > table > tbody > tr:nth-child(odd) { background: #2c2c2c }
			#wpbody-content > div.wrap > div.notice.notice-info { background: #2c2c2c }
			#wpbody-content > div.wrap > div.notice.notice-info > p { color: #cacaca }
			/* dark mode for product add pages 
			#post-body-content, #content, #excerpt, #general_product_data, #inventory_product_data, #shipping_product_data, 
			#wpseo_meta > div.inside, #linked_product_data, #product_attributes, #advanced_product_data, #woocommerce-product-data > div.inside > div,
			#wplister-ebay-details.postbox, #wplister-ebay-details > div.inside, #wplister-ebay-gtins.postbox, #wplister-ebay-advanced.postbox, #woocommerce-product-data > div.inside,
			#yoast_seo, #marketplace_suggestions, #woocommerce-product-data, #woocommerce-product-data > div.inside, #wplister-ebay-details,
			#wplister-ebay-categories.postbox, #wplister-ebay-shipping.postbox, #woocommerce-gpf-product-fields.postbox,
			#wpbody, #submitdiv.postbox, #postimagediv.postbox, #product_catdiv.postbox, #tagsdiv-product_tag.postbox,
			#woocommerce-product-images.postbox, #yoast_internal_linking.postbox, #product_catchecklist { background: #444444; color: #ffffff; }
			#wp-content-editor-tools, #ed_toolbar { background: #6b6b6b; color: #ffffff; }
			/* recolor side postbox headers 
			div.postbox-header, #wplister-ebay-details > div.postbox-header, #wplister-ebay-details.postbox-header { background: #6b6b6b; color: #ffffff; }
			#submitdiv > div.postbox-header, #postimagediv > div.postbox-header, #product_catdiv > div.postbox-header, 
			#tagsdiv-product_tag > div.postbox-header, #woocommerce-product-images > div.postbox-header, 
			#yoast_internal_linking > div.postbox-header { background: #6b6b6b; color: #ffffff; } */
			#toplevel_page_limit-login-attempts > a > div.wp-menu-name > span > span.plugin-count, #toplevel_page_limit-login-attempts > a > div.wp-menu-name > span { display: none; }
		</style>;
		<?php		
	}
	/*if ($email == "adam@ccrind.com")
	{
		?>
        <style type="text/css">
			/* dark mode for product and order lists */
			#wpbody-content > div.wrap, #wpcontent { background: #444444 }
			#posts-filter > table > thead > tr, #posts-filter > table > tfoot { background: #707070 }
			#the-list { background: #333333 }
			#posts-filter > table > tbody > tr:nth-child(odd) { background: #2c2c2c }
			#wpbody-content > div.wrap > div.notice.notice-info { background: #2c2c2c }
			#wpbody-content > div.wrap > div.notice.notice-info > p { color: #cacaca }
			/* dark mode for product add pages */
			#post-body-content, #content, #excerpt, #general_product_data, #inventory_product_data, #shipping_product_data, 
			#wpseo_meta > div.inside, #linked_product_data, #product_attributes, #advanced_product_data, #woocommerce-product-data > div.inside > div,
			#wplister-ebay-details.postbox, #wplister-ebay-details > div.inside, #wplister-ebay-gtins.postbox, #wplister-ebay-advanced.postbox, #woocommerce-product-data > div.inside,
			#yoast_seo, #marketplace_suggestions, #woocommerce-product-data, #woocommerce-product-data > div.inside, #wplister-ebay-details,
			#wplister-ebay-categories.postbox, #wplister-ebay-shipping.postbox, #woocommerce-gpf-product-fields.postbox,
			#wpbody, #submitdiv.postbox, #postimagediv.postbox, #product_catdiv.postbox, #tagsdiv-product_tag.postbox,
			#woocommerce-product-images.postbox, #yoast_internal_linking.postbox, #product_catchecklist { background: #444444; color: #ffffff; }
			#wp-content-editor-tools, #ed_toolbar { background: #6b6b6b; color: #ffffff; }
			/* recolor side postbox headers 
			div.postbox-header, #wplister-ebay-details > div.postbox-header, #wplister-ebay-details.postbox-header { background: #6b6b6b; color: #ffffff; }
			#submitdiv > div.postbox-header, #postimagediv > div.postbox-header, #product_catdiv > div.postbox-header, 
			#tagsdiv-product_tag > div.postbox-header, #woocommerce-product-images > div.postbox-header, 
			#yoast_internal_linking > div.postbox-header { background: #6b6b6b; color: #ffffff; }
		</style>;
		<?php	
	}*/
	if ($email == "sharon@ccrind.com" || $email == "dan@ccrind.com")
	{
		?>
        <style type="text/css">
			/* link color admin pages 
			body:not(.gutenberg-editor-page) a, body:not(.gutenberg-editor-page) .button-link, #wpadminbar .ab-icon, #wpadminbar .ab-icon:before, #wpadminbar .ab-item:after, #wpadminbar .ab-item:before {
				color: #8d9bda !important; }
			/* link color admin pages on hover 
			body:not(.gutenberg-editor-page) a:hover { color: #c6cded !important; } */
			/* admin order page input text color */
			#woocommerce-order-items .woocommerce_order_items_wrapper table.woocommerce_order_items td input { color: #ffffff; }
			div.note_content > p { background-color: #ffffff; color: #444444 !important; }
			/* admin order inside order page input text color */
			#woocommerce-order-items .woocommerce_order_items_wrapper table.woocommerce_order_items td textarea { color: #ffffff; }
		</style>;
		<?php
	}
	?>
        <style type="text/css">
			
		</style>;
		<?php
}
?>