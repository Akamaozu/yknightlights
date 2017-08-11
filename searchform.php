<?php 

/*   Search Form Template    */

?>


<form id="searchform" class="center" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" >
<input id="s" type="text" name="s" placeholder="Search ..." onfocus="this.select()" />
<input type="submit" id="searchsubmit" value="GO" />
</form>