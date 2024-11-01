<?php
function sas_footer_js() {
?>
	<script type="text/javascript">

		function _ck_info( a, t ) {
			t = _ck(t);
			if(t) {
				jQuery(a).removeAttr("disabled");
			} else {
				jQuery(a).attr("disabled", true );
			}
		}

		function _ck( el ) {
			$el = jQuery(el).attr("checked");
			if($el) { return true; }
		}

		function _sas_default() {
			if(!_ck("#begnp")) {
				jQuery('#begnpselect').attr( "disabled", true );
			}
			if(!_ck("#endp")) {
				jQuery('#endpselect').attr( "disabled", true );
			}
			if(!_ck("#midp")) {
				jQuery('#midpselect').attr( "disabled", true );
			}
		}
		_sas_default();

	</script>
<?php
}
add_action( 'admin_footer', 'sas_footer_js' );


?>