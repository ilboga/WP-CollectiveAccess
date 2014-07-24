<?php
/**
 * Created by PhpStorm.
 * User: gautier
 * Date: 05/07/2014
 * Time: 15:01
 */

add_action('admin_menu','collectiveaccess_add_admin_page');
add_action('admin_init','collectiveaccess_admin_init');

function collectiveaccess_add_admin_page() {
    add_options_page('CollectiveAccess', 'CollectiveAccess','manage_options',
        'collectiveaccess','collectiveaccess_options_page');
}

function collectiveaccess_options_page(){
    ?><div class=""wrap">
    <php screen_icon(); ?>
    <h2>CollectiveAccess WordPress Plugin</h2>
    <form action="options.php" method="post">
        <?php settings_fields('collectiveaccess_options'); ?>
        <?php do_settings_sections('collectiveaccess'); ?>
        <input name="Submit" type="submit" value="Save Changes" />
    </form>
    </div>
    <?php
}

/**
 *
 */
function collectiveaccess_admin_init() {
    register_setting('collectiveaccess_options', 'collectiveaccess_options','collectiveaccess_validate_options');
    add_settings_section('collectiveaccess_main','Identifiers','collectiveaccess_main_text',
        'collectiveaccess');
    add_settings_field('collectiveaccess_url_base','URL Base','collectiveaccess_url_base_input',
        'collectiveaccess','collectiveaccess_main');
    add_settings_field('collectiveaccess_login','Login','collectiveaccess_login_input',
        'collectiveaccess','collectiveaccess_main');
    add_settings_field('collectiveaccess_password','Password','collectiveaccess_password_input',
        'collectiveaccess','collectiveaccess_main');
    add_settings_field('collectiveaccess_cache_duration','Cache duration','collectiveaccess_cache_duration_input',
        'collectiveaccess','collectiveaccess_main');
    add_settings_section('collectiveaccess_templates','Templates','collectiveaccess_templates_text',
        'collectiveaccess');
    add_settings_field('collectiveaccess_object_template','Object details template','collectiveaccess_object_template_input',
        'collectiveaccess','collectiveaccess_templates');
    add_settings_field('collectiveaccess_object_bundles','Object bundles','collectiveaccess_object_bundles_input',
        'collectiveaccess','collectiveaccess_templates');
    add_settings_field('collectiveaccess_entity_template','Entitie details template','collectiveaccess_entity_template_input',
        'collectiveaccess','collectiveaccess_templates');
}

function collectiveaccess_main_text() {
    ?>
    <p>CollectiveAccess Wordpress plugin requires access through Web Services to your CollectiveAccess
        installation.<br/>
        Please provide here login and password to an accound having WebServices authorized in your Providence back
        office.</p>
<?php
}

function collectiveaccess_templates_text() {
    ?>
    <p>You'll define here templates for displaying objects inside Wordpress.</p>
<?php
}

function collectiveaccess_url_base_input() {
    // get option 'login' value from the database
    $options = get_option('collectiveaccess_options');
    $url_base = $options['url_base'];
    //var_dump($url_base);die();
    // echo the field
    echo "<input id='url_base' name='collectiveaccess_options[url_base]' type='text' value='$url_base' />";
}

function collectiveaccess_login_input() {
    // get option 'login' value from the database
    $options = get_option('collectiveaccess_options');
    $login = $options['login'];
    // echo the field
    echo "<input id='login' name='collectiveaccess_options[login]' type='text' value='$login' />";
}

function collectiveaccess_password_input() {
    // get option 'login' value from the database
    $options = get_option('collectiveaccess_options');
    $password = $options['password'];
    // echo the field
    echo "<input id='password' type='password' name='collectiveaccess_options[password]' value='$password' />";
}

function collectiveaccess_cache_duration_input() {
    // get option 'login' value from the database
    $options = get_option('collectiveaccess_options');
    $cache_duration = $options['cache_duration'];
    //var_dump($url_base);die();
    // echo the field
    echo "<input id='cache_duration' name='collectiveaccess_options[cache_duration]' type='text' value='$cache_duration' />";
}

function collectiveaccess_object_template_input() {
    // get option 'login' value from the database
    $options = get_option('collectiveaccess_options');
    $object_template = $options['object_template'];
    // echo the field
    echo "<textarea rows='12' cols='50' id='object_template' name='collectiveaccess_options[object_template]'>";
    echo $object_template;
    echo "</textarea>";
    //var_dump($options);//die();
}

function collectiveaccess_object_bundles_input() {
    // get option 'login' value from the database
    $options = get_option('collectiveaccess_options');
    $object_bundles = $options['object_bundles'];
    // echo the field
    echo "<textarea rows='12' cols='50' id='object_bundles' name='collectiveaccess_options[object_bundles]'>";
    echo $object_bundles;
    echo "</textarea>";
    //var_dump($options);//die();
}

function collectiveaccess_entity_template_input() {
    $options = get_option('collectiveaccess_options');
    $entity_template = $options['entity_template'];
    echo "<textarea rows='12' cols='50' id='entity_template' name='collectiveaccess_options[entity_template]'>";
    echo $entity_template;
    echo "</textarea>";
}

function collectiveaccess_validate_options($input) {

    // TODO : if user, base_url or password is changed, clear the cache.

    $valid = array();
    $valid['login'] = preg_replace('/[^a-zA_Z]/','',$input['login']);
    $valid['password'] = preg_replace('/[^a-zA_Z0-9]/','',$input['password']);
    $valid['url_base'] = preg_replace('/[^a-zA_Z0-9\.\/]/','',$input['url_base']);
    $valid['cache_duration'] = preg_replace('/[^\d]/','',$input['cache_duration']);
    // TODO : sanitize html & javascript for templates !
    $valid['object_template'] = $input['object_template'];
    $valid['object_bundles'] = $input['object_bundles'];
    $valid['entity_template'] = $input['entity_template'];
    return $valid;
}
