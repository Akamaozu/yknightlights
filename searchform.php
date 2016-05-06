<?php 

/*   Search Form Template    */

?>


<form id="searchform" class="center" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" >
<input id="s" type="text" name="s" value="Search Nightlights"  onclick="this.value='';" onfocus="this.select()" onblur="this.value=!this.value?'Search Nightlights':this.value;"/>
<input type="submit" id="searchsubmit" value="Search" />
</form>