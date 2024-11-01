<?php
function sas_options_sec() {
	echo '<p class="description">Configure your ads display options here.</p>';
}
function sas_adcodes_sec() {
	echo '<p class="description">Configure your Ads Codes here.</p>';
}

function sas_pos_field() {
	global $sasops, $sasdefault;
?>
	<fieldset>
		<p>
			<input onchange="_ck_info('#begnpselect', this )" type="checkbox" name="sas_op[begnp]" id="begnp" value="1" <?php checked( 1, $sasops['begnp'], true ); ?>>
			<span>Show</span>
			<select name="sas_op[begnpselect]" id="begnpselect">
				<?php
				for( $i = 1; $i <= $sasdefault['maxadcodes']; $i++ ) {
					echo '<option value="'.$i.'"'.selected( $i, $sasops['begnpselect'], true ).'>Ad '.$i.'</option>';
				}
				?>
			</select>
			<span>at the beginning of the post.</span>
		</p>
		<p>
			<input onchange="_ck_info('#midpselect', this )" type="checkbox" name="sas_op[midp]" id="midp" value="1" <?php checked( 1, $sasops['midp'], true ); ?>>
			<span>Show</span>
			<select name="sas_op[midpselect]" id="midpselect">
				<?php
				for( $i = 1; $i <= $sasdefault['maxadcodes']; $i++ ) {
					echo '<option value="'.$i.'"'.selected( $i, $sasops['midpselect'], true ).'>Ad '.$i.'</option>';
				}
				?>
			</select>
			<span>in the middle of the post.</span>
		</p>
		<p>
			<input onchange="_ck_info('#endpselect', this )" type="checkbox" name="sas_op[endp]" id="endp" value="1" <?php checked( 1, $sasops['endp'], true ); ?>>
			<span>Show</span>
			<select name="sas_op[endpselect]" id="endpselect">
				<?php
				for( $i = 1; $i <= $sasdefault['maxadcodes']; $i++ ) {
					echo '<option value="'.$i.'"'.selected( $i, $sasops['endpselect'], true ).'>Ad '.$i.'</option>';
				}
				?>
			</select>
			<span>at the end of the post.</span>
		</p>
	</fieldset>
<?php
}

function sas_codes_field() {
	global $sasops, $sasdefault;

	for( $i = 1; $i <= $sasdefault['maxadcodes']; $i++ ) {
		echo '<div style="background:#EEEEEE; padding:3px;margin-bottom:5px;max-width:520px;border-top:1px solid #F7F7F7;box-shadow:0px 1px 0px 1px #DFDFDF">';
		echo '<p style="font-weight:bold">Ad Code '.$i.':</p>';
		echo '<textarea style="width:100%" cols="50" rows="3" class="adcodes" id="adcodes'.$i.'" name="sas_op[ad'.$i.']">'.$sasops['ad'.$i].'</textarea>';
?>
	<br>
	<label for="sas_op[ad<?php echo $i; ?>pos]">Align</label>
	<select id="sas_op[ad<?php echo $i; ?>pos]" name="sas_op[ad<?php echo $i; ?>pos]">
		<option value="left" <?php selected( "left", $sasops['ad'.$i.'pos'], true ); ?>>Left</option>
		<option value="center" <?php selected( "center", $sasops['ad'.$i.'pos'], true ); ?>>Center</option>
		<option value="right" <?php selected( "right", $sasops['ad'.$i.'pos'], true ); ?>>Right</option>
		<option value="none" <?php selected( "none", $sasops['ad'.$i.'pos'], true ); ?>>None</option>
	</select>
	<label for="sas_op[ad<?php echo $i; ?>margin]">Margin</label>
	<input type="text" id="sas_op[ad<?php echo $i; ?>margin]" name="sas_op[ad<?php echo $i; ?>margin]" value="<?php echo $sasops['ad'.$i.'margin'] ?>">
	<span class="description">Example: 10px 10px 10px 10px</span>
<?php
		echo '</div>';
	}
}

//Function to show ads on the post body
function showadsonpost( $content ) {
	global $sasops;

	if( $sasops['midp'] ) {
		$adnumber 	=	$sasops['midpselect'];
		$adcode		=	$sasops['ad'.$adnumber];
		$f			=	$sasops['ad'.$adnumber.'pos'];
		$m			=	$sasops['ad'.$adnumber.'margin'];
		$adcode		=	showadcode( $f, $m, $adcode );
		$ex_cont	=	explode( '</p>', $content );
		$exc		=	count( $ex_cont ) - 1;
		$exc2		=	floor( $exc/2 ) - 1;
		$content	=	'';

		for($i = 0; $i <= $exc; $i++) {
			if($i != $exc) {
				$content .= $ex_cont[$i].'</p>';
				if($i == $exc2) {
					$content .= $adcode;
				}
			}
		}
	}
	if( $sasops['begnp'] ) {
		$adnumber 	=	$sasops['begnpselect'];
		$adcode		=	$sasops['ad'.$adnumber];
		$f			=	$sasops['ad'.$adnumber.'pos'];
		$m			=	$sasops['ad'.$adnumber.'margin'];
		$adcode		=	showadcode( $f, $m, $adcode );
		$content	=	$adcode.$content;
	}
	if( $sasops['endp'] ) {
		$adnumber 	=	$sasops['endpselect'];
		$adcode		=	$sasops['ad'.$adnumber];
		$f			=	$sasops['ad'.$adnumber.'pos'];
		$m			=	$sasops['ad'.$adnumber.'margin'];
		$adcode		=	showadcode( $f, $m, $adcode );
		$content	=	$content.$adcode;
	}

	return $content;
}
add_filter( 'the_content', 'showadsonpost' );

function showadcode( $f, $m, $adcode ) {
	$textalign		=	( $f == "center" ) ? 'text-align:center' : '';
	$new_adcode		=	'<!-- Simple Ads -->';
	$new_adcode		.=	'<div style="float:'.$f.';margin:'.$m.';'.$textalign.'">'.$adcode.'</div>';
	return $new_adcode;
}