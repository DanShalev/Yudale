<?php /*Panel - guests*/?>
<div data-role="panel" id="main_panel" data-position-fixed="true" data-display="push">
    <ul data-role="listview" data-inset="true" data-divider-theme="a">
        <li data-icon="false"><a id="panel_username" href="#main_panel" data-rel="close">
                <img src="<?php echo $base_href ?>users/pictures/guest.jpg">
                <h2>Guest</h2>
            <p></p></a>
        </li>
    </ul>

    <ul data-role="listview" data-inset="true" data-divider-theme="a">
        <li data-role="list-divider">Account</li>
        <li>
            <a href="<?php echo $base_href ?>login.php" class="ui-btn ui-icon-action ui-btn-icon-left">Log In</a>
        </li>
        <li data-role="list-divider">About</li>
        <li>
            <a href="<?php echo $base_href ?>about.php" class="ui-btn ui-icon-info ui-btn-icon-left">About</a>
        </li>
    </ul>
</div>