<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/kanafghan
 * @since      1.0.0
 *
 * @package    Simple_User
 * @subpackage Simple_User/admin/partials
 */
?>

<div class="wrap">
    <h1 id="simple-user-manager-title"><?php echo esc_html( get_admin_page_title() ); ?></h1>

    <!-- class="notice notice-success is-dismissable" -->
    <div id="ajax-response"></div>

    <p><?php _e('Create a new user simply by his/her first name, last name and role.', 'simple-user') ?></p>

    <form id="Simple-User--createuser">
        <input type="hidden" name="simple-user-form" id="input-simple-user" class="form-control" value="Testing!">

        <table class="form-table" role="presentation">
            <tbody>
                <!-- First Name -->
                <tr class="form-field">
                    <th scope="row"><label for="first_name"><?php _e('First Name') ?></label></th>
                    <td><input name="first_name" type="text" id="first_name" value=""></td>
                </tr>

                <!-- Last Name -->
                <tr class="form-field">
                    <th scope="row"><label for="last_name"><?php _e('Last Name') ?></label></th>
                    <td><input name="last_name" type="text" id="last_name" value=""></td>
                </tr>

                <!-- Role -->
                <tr class="form-field">
                    <th scope="row"><label for="role"><?php _e('Role') ?></label></th>
                    <td>
                        <select name="role" id="role">
                            <?php wp_dropdown_roles( 'author' ) ?>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>

        <p class="submit">
            <button type="submit" id="Simple-User--createuser-submit" class="button button-primary"><?php _e('Add New User') ?></button>
        </p>
    </form>
</div>
