<?php
/*
Plugin Name: LiteSpeed Cache Purge
Plugin URI: http://wordpress.org/extend/plugins/lscache-purge/
Description: Sends HTTP PURGE requests to URLs of changed posts/pages when they are modified. Works with LSWS 4.2.2-ent and up.
Version: 1.0.0
Author: LiteSpeed
Author URI: http://www.litespeedtech.com/
*/

    /* Runs when plugin is activated */
    register_activation_hook(__FILE__,'lscache_purge_install');

    /* Runs on plugin deactivation*/
    register_deactivation_hook( __FILE__, 'lscache_purge_remove' );

    function lscache_purge_install() {
    /* Creates new database field */
        add_option("lscache_purge_data", 'PURGE', '', 'yes');
    }

    function lscache_purge_remove() {
    /* Deletes the database field */
        delete_option('lscache_purge_data');
    }   

    if ( is_admin() ){
        add_action('admin_menu', 'lscache_purge_admin_menu');

        function lscache_purge_admin_menu() {
            add_options_page('LSCache Purge', 'LSCache Purge', 'administrator',
                'lscache-purge', 'lscache_purge_html_page');
        }
    }

    function lscache_purge_html_page() {
    ?>
            <div class="wrap">
            <?php screen_icon(); ?>
            <h2>LScache Purge Options</h2>

            <form method="post" action="options.php">
            <?php wp_nonce_field('update-options'); ?>

            <table width="510">
            <tr valign="top">
            <th width="92" scope="row"><?php echo 'Purge Method:'; ?> </th>
            <td width="406">
                    <select name="lscache_purge_data">
                    <option value="PURGE" <?php $opt_val=get_option('lscache_purge_data'); if (!$opt_val or $opt_val == "PURGE") echo 'selected '; ?>/>PURGE</option>
                    <option value="REFRESH" <?php $opt_val=get_option('lscache_purge_data'); if ($opt_val == "REFRESH") echo 'selected '; ?>/>REFRESH</option>
                    </select>
            </td>
            </tr>
            </table>

            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="lscache_purge_data" />

            <p>
            <input type="submit" value="<?php esc_attr_e('Save Changes') ?>" />
            </p>

            </form>
            </div>
    <?php
    }

class LScachePurge
{
    protected $purgeUrls = array();

    function __construct()
    {
        foreach ($this->getRegisterEvents() as $event)
        {
            add_action($event, array($this, 'purgePost'));
        }


        add_action('shutdown', array($this, 'executePurge'));
    }

    protected function getRegisterEvents()
    {
        return array(
            'publish_post',
            'edit_post',
            'deleted_post',
        );
    }

    function executePurge()
    {
        $purgeUrls = array_unique($this->purgeUrls);

        foreach($purgeUrls as $url)
        {
            $this->purgeUrl($url);
        }

        if (!empty($purgeUrls))
        {
            $this->purgeUrl(home_url());
        }
    }

    protected function purgeUrl($url)
    {
        $c = curl_init($url);
        $m = get_option( 'lscache_purge_data' );
        curl_setopt($c, CURLOPT_CUSTOMREQUEST, $m);
        curl_exec($c);
        curl_close($c);
    }

    function purgePost($postId)
    {
        array_push($this->purgeUrls, get_permalink($postId));
    }

}

    $purger = new LScachePurge();

?>

