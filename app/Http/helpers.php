<?php


function sp_input($label, $name, $class, $value)
{
    $content = '';
    $classp = ' element-div';
    if ($class != '') {
        $classp = ' element-div ' . $class;
    }
    if (strpos($class, 'readonly') === false) {
        $readonly = '';
    } else {
        $readonly = ' readonly="readonly"';
    }
    $content .= '
			<div class="' . $name . $classp . '" id="d-' . $name . '">
				<label class="top">' . $label . '</label>
				<input class="element"' . $readonly . ' type="text" id="' . $name . '" name="' . $name . '" value="' . $value . '" />
			</div>';
    return $content;
}

function sp_text($label, $name, $class, $value)
{
    $content = '';
    $classp = ' element-div';
    if ($class != '') {
        $classp = ' element-div ' . $class;
    }
    $content .= '
			<div class="' . $name . $classp . '" id="d-' . $name . '">
			<label class="top">' . $label . '</label>
			<span class="textfield" id="' . $name . '">' . $value . '</span>
		</div>';
    return $content;
}

function sp_textarea($label, $name, $class, $value)
{
    $content = '';
    $classp = ' element-div';
    if ($class != '') {
        $classp = ' element-div ' . $class;
    }
    $content .= '
			<div class="' . $name . $classp . '" id="d-' . $name . '">
				<label class="top">' . $label . '</label>
				<textarea class="element" type="text" id="' . $name . '" name="' . $name . '">' . $value . '</textarea>
			</div>';
    return $content;
}

function sp_select($label, $name, $optionslist, $class, $value)
{
    $content = '';
    $options = explode(';', $optionslist);
    $classp = ' element-div';
    if ($class != '') {
        $classp = ' element-div ' . $class;
    }
    $content .= '
			<div class="' . $name . $classp . '" id="d-' . $name . '">
				<label class="top">' . $label . '</label>
				<select class="element" id="' . $name . '" name="' . $name . '">';
    for ($i = 0; $i < count($options); $i++) {
        $content .= '
					<option value="' . $options[$i] . '"' . ($options[$i] == $value ? ' selected' : '') . '>' . $options[$i] . '</option>';
    }
    $content .= '
				</select>
			</div>';
    return $content;
}

function sp_select_other($label, $name, $optionslist, $class, $value)
{
    $content = '';
    $options = explode(';', $optionslist);
    $classp = ' element-div';
    if ($class != '') {
        $classp = ' element-div ' . $class;
    }
    $content .= '
			<div class="' . $name . $classp . '" id="d-' . $name . '">
			<label class="top">' . $label . '</label>
			<select class="selectOrOther" data-id="' . $name . '">';
    $other = false;
    if ($value != '' && $value != 'Please Select') {
        $other = true;
    }
    for ($i = 0; $i < count($options); $i++) {
        $selected = '';
        if ($options[$i] == $value) {
            $selected = ' selected';
            $other = false;
        }
        $content .= '
				<option value="' . $options[$i] . '"' . $selected . '>' . $options[$i] . '</option>';
    }
    $content .= '
					<option value="Other"' . ($other ? ' selected' : '') . '>Other – please provide details</option>
				</select>
				<div id="' . $name . 'other" class="' . ($other ? '' : 'hidden') . '">
					<label class="otherLabel">Please specify</label>
					<input type="text" class="other" value="' . ($other ? $value : '') . '" data-id="' . $name . '" />
				</div>
				<input type="hidden" id="' . $name . '" name="' . $name . '" class="element" value="' . $value . '" />
			</div>';
    return $content;
}

function sp_select_other_custom($label, $name, $optionslist, $other_optionslist, $class, $value, $other_value)
{
    $content = '';
    $options = explode(';', $optionslist);
    $other_options = explode(';', $other_optionslist);
    $classp = ' element-div';
    if ($class != '') {
        $classp = ' element-div ' . $class;
    }
    $content .= '
			<div class="' . $name . $classp . '" id="d-' . $name . '">
			<label class="top">' . $label . '</label>
			<select class="selectOrOtherCustom element ' . $name . $classp . '" name="' . $name . '">';
    $other = false;
    if ($value != '' && $value != 'Please Select') {
        $other = true;
    }
    for ($i = 0; $i < count($options); $i++) {
        $selected = '';
        if ($options[$i] == $value) {
            $selected = ' selected';
            $other = false;
        }
        $content .= '
				<option value="' . $options[$i] . '"' . $selected . '>' . $options[$i] . '</option>';
    }
    for ($i = 0; $i < count($other_options); $i++) {
        $selected = '';
        if ($other_options[$i] == $value) {
            $selected = ' selected';
        }
        $content .= '
				<option data-other="1" value="' . $other_options[$i] . '"' . $selected . '>' . $other_options[$i] . '</option>';
    }
    $content .= '
				</select>
				<div id="' . $name . 'other" class="' . ($other ? '' : 'hidden') . '">
					<label class="otherLabel">Please specify</label>
					<input type="text" class="element" name="' . $name . '_other" value="' . $other_value . '" />
				</div>
			</div>';
    return $content;
}

function sp_radio_yn($label, $name, $class, $value)
{
    $content = '';
    $classp = ' element-div';
    if ($class != '') {
        $classp = ' element-div ' . $class;
    }
    if ((stripos($class, 'no') !== false) && ($value == '')) {
        $value = 'no';
    }
    if ((stripos($class, 'yes') !== false) && ($value == '')) {
        $value = 'yes';
    }
    $content .= '
			<div class="' . $name . $classp . '" id="d-' . $name . '">
				<label class="top">' . $label . '</label>
				<label class="radio_yn">
				<input class="radio_y radioYn" data-id="' . $name . '" type="radio" id="' . $name . '_yes" name="yn' . $name . '" value="yes"' . ($value == 'yes' ? ' checked' : '') . '/>Yes</label>
			<label class="radio_yn">
			<input class="radio_n radioYn" data-id="' . $name . '" type="radio" id="' . $name . '_no" name="yn' . $name . '" value="no"' . ($value == 'no' ? ' checked' : '') . '/>No</label>
			<input type="hidden" class="element" id="' . $name . '" name="' . $name . '" value="' . $value . '" />
			</div>';
    return $content;
}

function sp_radio_ppd($label, $name, $class, $value)
{
    $content = '';
    if ($class != '') {
        $class = ' ' . $class;
    }
    $hidden = '';
    if (($value == '') || ($value == 'No')) {
        $hidden = ' hidden';
        $value = 'No';
    } else {
        $hidden = 'mandatory';
    }
    $content .= '
			<div class="' . $name . $class . '" id="d-' . $name . '">
				<label class="top">' . $label . '</label>
				<label class="radio_yn"><input class="radio_y radioYnPpd" type="radio" data-name="' . $name . '" id="' . $name . '_yes" name="yn' . $name . '" value="yes" ' . (($value != '') && ($value != 'No') ? 'checked ' : '') . '/>Yes</label>
				<label class="radio_yn"><input class="radio_n radioYnPpd" type="radio" data-name="' . $name . '" id="' . $name . '_no" name="yn' . $name . '" value="no" ' . (($value == '') || ($value == 'No') ? 'checked ' : '') . '/>No</label>
				<div class="' . $hidden . '">
					<label>Please provide details:</label>
					<textarea class="element" id="' . $name . '" name="' . $name . '">' . $value . '</textarea>
				</div>
			</div>';
    return $content;
}

function sp_checkbox($label, $name, $class, $value)
{
    $content = '';
    $classp = ' element-div';
    if ($class != '') {
        $classp = ' element-div ' . $class;
    }
    if ((stripos($class, 'yes') !== false) && ($value == '')) {
        $value = 'yes';
    }
    $checked = '';
    if ($value == 'yes') {
        $checked = ' checked';
    }
    $content .= '
			<div class="' . $name . $classp . '" id="d-' . $name . '">
				<label class="top">' . $label . '</label>
				<input style="width:20px;height:20px;" class="element" type="checkbox"' . $checked . ' id="' . $name . '" name="' . $name . '" value="yes" />
			</div>';
    return $content;
}


function easyMail ($mailData) {



        foreach ($mailData['address'] as $address) {

            \Mail::send([], [], function ($message) use($mailData, $address) {
                $message->to($address)
                ->from('colonialstrata@support.colonialinsurance.com.au')
                ->subject($mailData['subject'])
                    ->setBody($mailData['message'], 'text/html');
            });

//            $from = 'colonialstrata@support.colonialinsurance.com.au';
//            $from_name = 'Colonial Strata Support Team';
//            $mail = new PHPMailer;
//            $mail->CharSet = 'UTF-8';
//            $mail->DKIM_domain = 'support.colonialinsurance.com.au';
//            $mail->DKIM_private = '/home/ubuntu/www/vendor/phpmailer/phpmailer/dkim.private';
//            $mail->DKIM_selector = 'dkim';
//            $mail->DKIM_passphrase = '';
//            //$mail->DKIM_identity = $from;
//            $mail->setFrom($from, $from_name);
//            $mail->addReplyTo($from, $from_name);
//            $mail->isHTML(true);
//            $mail->Subject = $mailData['subject'];
//            $mail->Body = $mailData['message'];
//            $mail->AltBody = strip_tags($mailData['message']);
//            if (!empty($mailData['attachment'])) {
//                foreach ($mailData['attachment'] as $attachment) {
//                    $mail->addAttachment($attachment);
//                }
//            }
//            $mail->addAddress($address);
//            $mail->send();
        }
}
