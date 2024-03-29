<?php
function evr_get_open_seats($event_id,$reg_limit ){
        global $wpdb,$evr_date_format;
        $num = 0;                              
        $sql2= "SELECT SUM(quantity) FROM " . get_option('evr_attendee') . " WHERE event_id='$event_id'";
        $attendee_count  = $wpdb->get_var($sql2);
        If ($attendee_count >= 1) {$num = $attendee_count;}
        $open_seats = $reg_limit - $num;
        return $open_seats;
}
#Function to generate default form questions
function evr_generate_frm_defaults($field,$tag){
?>
<li>
    <label for="<?php echo $field;?>"><?php echo $tag; ?></label>
	<span class="fieldbox"><input type="text" id="<?php echo $field; ?>" name="<?php echo $field;?>" value="" /></span>
</li>
<?php
}
/** This function, evr_regform_new($event_id){} generates a registration form
 *  base on settings defined in the event with the id that is passed as $event_id 
 *  to this function.  This form will only show defined fields and costs assigned 
 *  to this event.
 *
 */ 
function evr_regform_new($event_id){
    global $wpdb,$evr_date_format;
    $curdate = date ( "Y-m-j" );
    $company_options = get_option('evr_company_settings');
    $sql = "SELECT * FROM ". get_option('evr_event') ." WHERE id = $event_id";
    $rows = $wpdb->get_results( $sql );
    if ($rows){
        foreach ($rows as $event){
            include "evr_event_array2string.php"; 
        }
    $cap_url = EVR_PLUGINFULLURL . "cimg/";
    $md5_url = EVR_PLUGINFULLURL . "md5.js";
#Begin Page Content    
    echo '<h2>'.strtoupper($event_name).'</h2>';
?>        
<?php
if ($display_desc =="Y"){ echo "<blockquote>".html_entity_decode($event_desc)."</blockquote>"; }
#Registration form content begins here
?>
<div style="margin:0; padding:0; height:1px;">
<script type="text/javascript" src="<?php echo $md5_url; ?>"></script>
<?php if ($company_options['captcha'] == 'Y') { ?>
<script type="text/javascript"> var imgdir = "<?php echo $cap_url; ?>"; </script>
<script type="text/javascript" src="<?php echo EVR_PLUGINFULLURL;?>public/captcha.js.php"></script>
<?php } 
if ($company_options['captcha'] == 'Y') {$captcha = "Y";} else {$captcha="N";}
?>
<script type="text/javascript" src="<?php echo EVR_PLUGINFULLURL;?>public/validate.js.php?captcha=<?php echo $captcha;?>"></script> 
<?php
    $tax_rate = .0;
    if ($company_options['use_sales_tax'] == "Y"){ 
        $tax_rate = .0875;
        if ($company_options['sales_tax_rate'] != "") { 
            $tax_rate = $company_options['sales_tax_rate'];
echo '<script type="text/javascript" src="'. EVR_PLUGINFULLURL.'public/calculator.js.php?tax='.$tax_rate.'"></script>';
        }
    } 
    else {
echo '<script type="text/javascript" src="'. EVR_PLUGINFULLURL.'public/calculator.js.php?tax='.$tax_rate.'"></script>';
        } 
?>
<style>
<?php echo   $company_options['form_css'];?>
</style>
</div>
<div id="evrRegForm">
<strong>*Please complete the Registration Form below.</strong>
<?php
$current_dt= date('Y-m-d H:i',current_time('timestamp',0));
if ($event_close == "start"){$close_dt = $start_date." ".$start_time;}
else if ($event_close == "end"){$close_dt = $end_date." ".$end_time;}
else if ($event_close == ""){$close_dt = $start_date." ".$start_time;}
$stp = DATE("Y-m-d H:i", STRTOTIME($close_dt));
$expiration_date = strtotime($stp);
$today = strtotime($current_dt);                         
if ($expiration_date <= $today){
    echo '<br/><font color="red">';
    _e('Registration is closed for this event.','evr_language');
    echo '<br/>';
    _e('For more information or questions, please email: ','evr_language');
    echo '</font><a href="mailto:'.$company_options['company_email'].'">'.$company_options['company_email'].'</a>';
    } 
    else {?> 
    <form  name="regform"  class="evr_regform" method="post" action="<?php echo evr_permalink($company_options['evr_page_id']);?>" onSubmit="mySubmit.disabled=true;return validateForm(this)">
    <ul>
<?php
evr_generate_frm_defaults('fname',__('First Name','evr_language'));
evr_generate_frm_defaults('lname',__('Last Name','evr_language'));
evr_generate_frm_defaults('email',__('Parents Email Address','evr_language'));
        if ($inc_phone == "Y") { 
            evr_generate_frm_defaults('phone',__('Parents Cell Number','evr_language'));
        }
        if ($inc_address == "Y") {
            evr_generate_frm_defaults('address',__('Street/PO Address','evr_language'));
        } 
        if ($inc_city == "Y") { 
            evr_generate_frm_defaults('city',__('City','evr_language'));
        }  
        if ($inc_state == "Y") { 
            evr_generate_frm_defaults('state',__('State','evr_language'));
        }
        if ($inc_zip == "Y") { 
            evr_generate_frm_defaults('zip',__('Postal/Zip Code','evr_language'));
        } 
        if ($inc_comp == "Y") {
            evr_generate_frm_defaults('company',__('Company Name','evr_language'));
        }
        if ($inc_coadd == "Y") { 
            evr_generate_frm_defaults('co_address',__('Company Address','evr_language'));
        }
        if ($inc_cocity == "Y") { 
            evr_generate_frm_defaults('co_city',__('Company City','evr_language'));
        }
        if ($inc_costate == "Y") { 
            evr_generate_frm_defaults('co_state',__('Company State/Province','evr_language'));
        }
        if ($inc_copostal == "Y") { 
            evr_generate_frm_defaults('co_zip',__('Company Postal Code','evr_language'));
        }
        if ($inc_cophone == "Y") { 
            evr_generate_frm_defaults('co_phone',__('Company Phone','evr_language'));
        }
?>
<?php        
        //Additional Questions
            $questions = $wpdb->get_results("SELECT * from ".get_option('evr_question')." where event_id = '$event_id' order by sequence");
            if ($questions) {
                foreach ($questions as $question) {
                    $title = '';
                     if ($question->remark) { $title =  $question->remark;}
?>
<li title="<?php echo $title;?>">
    <label for="question-<?php echo $question->id;?>" ><?php echo $question->question;?></label>
	<?php echo evr_form_build($question);?>
</li>
<?php
                    }
            }
?>
<?php
        if ($use_coupon == "Y") { 
            evr_generate_frm_defaults('coupon',__('Enter coupon code for discount','evr_language'));
        }
        ?>
    </ul>
    <br />   
<?php #See how many seats are left available
        $available = evr_get_open_seats($event->id,$event->reg_limit );
        #If there is at least one seat available then begin display of event pricing and allow registration, else no fees notice.                               
        if ($available >= "1"){ 
            $sql = "SELECT * FROM " . get_option('evr_cost') . " WHERE event_id = " . $event_id. " ORDER BY sequence ASC";
            $rows = $wpdb->get_results( $sql );
            if ($rows){
                $open_seats = $available;
                $curdate = date("Y-m-d");
                $fee_count = 0;
                $isfees = "N";
                #Display Section Header
                ?>
<hr />
<h2 ><?php _e('REGISTRATION FEES','evr_language');?></h2>
<br />
<p><font color="red"><?php _e('You must select at least one item!','evr_language');?></font></p>
<?php  foreach ($rows as $fee){
#check fee dates and if date range is valid, display fee
    if((evr_greaterDate($curdate,$fee->item_available_start_date))&& (evr_greaterDate($fee->item_available_end_date,$curdate))){
    $req = '';
    $isfees="Y";
    #Set hidden value for registration type to RGLR vs. WAIT
    ?>
<input type="hidden" name="reg_type" value="RGLR"/>
<div align="left">
<label for="cost" title ="<?php echo $fee->item_description;?>" >
<select style="width: 60px" name = "PROD_<?php echo $fee->event_id;?>-<?php echo $fee->id;?>_<?php echo  $fee->item_price;?>" id = "PROD_<?php echo $fee->event_id;?>-<?php echo $fee->id;?>_<?php echo  $fee->item_price;?>" onChange="<?php if ($company_options['use_sales_tax'] == "Y"){echo 'CalculateTotalTax(this.form)';} else { echo 'CalculateTotal(this.form)';}?>">
<option value="0">0</option>
<?php
                        #Begin generation of DropDown Box - Options
                        #Check to see if the item is a REG type.  If REG, set options count based on seating availability/ ticke limits
                        if ($fee->item_cat == "REG"){
                            if ($fee->item_limit != ""){
                                if ($available >= $fee->item_limit){$units_available = $fee->item_limit;} 
                                else {$units_available = $available;}
                                }
                            for($i=1; $i<=$units_available; $i++) { 
?>
<option value="<?php echo ($i);?>"><?php echo ($i);?></option>
<?php } 
                        }
                        #If item is not REG type, and no limit was set, limit options to 10
                        if ($fee->item_cat != "REG"){
                            $num_select = "10";    
                            if ($fee->item_limit != ""){
                                $num_select = $fee->item_limit;
                            }
                            for($i=1; $i<$num_select+1; $i++) { ?> 
<option value="<?php echo ($i);?>"><?php echo ($i);?></option>
<?php } 
} 
?></select>   <?php
                        #Display Fee description and cost.
                        if ($fee->item_custom_cur == "GBP"){$item_custom_cur = "&pound;";}
                        if ($fee->item_custom_cur == "USD"){$item_custom_cur = "$";}
echo $fee->item_title . "    " . $item_custom_cur . " " . $fee->item_price; ?></label>
</div>
<?php 
                        } 
                    }
            #No fees are within todays date range.
            if ($isfees == "N"){
                ?>
                <br /><hr /><font color='red'>
                <?php _e('No Fees/Items available for todays date!','evr_language');?>
                <br />
                <?php  _e('Please update fee dates!','evr_language');?>
                </font><br />
                <?php #if no fees set hidden reg type to WAIT ?>
                <input type="hidden" name="reg_type" value="WAIT" />
                <?php
                }?>
<br />
<?php
            #Display the Total Boxes with Tax
            if ($company_options['use_sales_tax'] == "Y"){ ?>
<table>
<tr><td><b><?php _e('Registration Fees','evr_language');?></b></td><td><input style="width: 100px" type="text" name="fees" id="fees" size="10" value="0.00" onFocus="this.form.elements[0].focus()"/></td></tr>
<tr><td><b><?php _e('Sales Tax','evr_language');?></b></td><td><input style="width: 100px" type="text" name="tax" id="tax" size="10" value="0.00" onFocus="this.form.elements[0].focus()"/></td></tr>
<tr><td><b><?php _e('Total','evr_language');?></b></td><td><input style="width: 100px" type="text" name="total" id="total" size="10" value="0.00" onFocus="this.form.elements[0].focus()"/></td></tr>
</table>
<?php } else {  #Dsipaly Total Boxes without Tax 
?>
<b><?php _e('Total   ','evr_language');?><input style="width: 100px" type="text" name="total" id="total" size="10" value="0.00" onFocus="this.form.elements[0].focus()"/></b>
<?php } ?>
<br />
<br />
<?php
            } else {
?>
                <br />
                <hr />
                <font color='red'>
                <?php _e('No Fees Have Been Setup For This Event!','evr_language');?>
                <br />
                <?php  _e('Registration for this event can not be taken at this time.','evr_language');?>
                <br /></font>
<?php
            }
        } else {
?>
            <hr />
            <br />
            <b><font color="red"><?php _e('This event has reached registration capacity.','evr_language');?>
            <br>
            <?php _e('Please provide your information to be placed on the waiting list.','evr_language');?>
            </font></b>
            <br />
            <input type="checkbox" onclick="mySubmit.disabled=false" name="request" value="Waitlist" /> 
            <?php _e('Put me on the waitlist.','evr_language');?>
            <input type="hidden" name="reg_type" value="WAIT" />
<?php   
        }
?>
        <hr />
        <br />
<?php if ($company_options['captcha'] == 'Y') { ?>
        <p><?php  _e('Enter the security code as it is shown (required)','evr_language'); ?></p>
        <script type="text/javascript">sjcap("altTextField");</script>
        <noscript><p>[<?php _e('This resource requires a Javascript enabled browser.','evr_language');?>]</p></noscript>
<?php
        }
?>
        <input type="hidden" name="action" value="confirm"/>
        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>" />
        <div style="margin-left: 150px;">
            <input style="float:left; margin-right:10px; background:#2984e7; border:1px solid #1264a0; font-weight:bold; color:#FFFFFF;" type="submit" name="mySubmit" id="mySubmit" disabled="true" value="<?php _e('Submit','evr_language');?>" /><input style="float:left;" type="reset" value="<?php _e('Reset','evr_language');?>" />
        </div>
    </form>
</div>
<?php
   } 
}
}
?>