<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://www.madebymatty.com
 * @since      1.0.0
 *
 * @package    Mw_Details_Form
 * @subpackage Mw_Details_Form/public/partials
 */
?>
<form method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" accept-charset="UTF-8" class="details-form" novalidate>

    <?php if (isset($submit['success'])): ?>
    <div class="details-form__success">
        <p>You've successfully updated your details</p>
    </div>
    <?php endif; ?>

    <?php if (isset($submit['errors'])): ?>
    <div class="details-form__errors">
        <h2>Error(s)</h2>
        <ul>
            <?php foreach ( $submit['errors'] as &$value ): ?>
            <li><?php echo $value;?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <fieldset class="details-form__fields">
        <ul>
            <li class="details-form__fields--input details-form__fields--readonly">
                <label for="first-name">Username</label>
                <input type="text" id="first-name" name="cf-username" value="<?php echo isset( $username ) ? esc_attr( $username ) : ''; ?>" readonly disabled>
            </li>
            <li class="details-form__fields--input details-form__fields--half-left">
                <label for="first-name">First Name</label>
                <input type="text" id="first-name" name="cf-firstname" pattern="[a-zA-Z0-9 ]+" placeholder="e.g. John" value="<?php echo isset( $first_name ) ? esc_attr( $first_name ) : ''; ?>" required="">
            </li>
            <li class="details-form__fields--input details-form__fields--half-right">
                <label for="first-name">Last Name</label>
                <input type="text" id="first-name" name="cf-lastname" placeholder="e.g. Smith" value="<?php echo isset( $last_name ) ? esc_attr( $last_name ) : ''; ?>" required="">
            </li>
            <li class="details-form__fields--input">
                <label for="first-name">Email Address</label>
                <input type="text" id="first-name" name="cf-email" placeholder="e.g. john.smith@gmail.com" value="<?php echo isset( $user_email ) ? esc_attr( $user_email ) : ''; ?>" required="">
            </li>
            <li class="details-form__fields--input details-form__fields--optional">
                <label for="first-name">Twitter Username <span>(optional)</span></label>
                <input type="text" id="first-name" name="cf-twitter" placeholder="e.g. @JohnSmith" value="<?php echo isset( $user_twitter ) ? esc_attr( $user_twitter ) : ''; ?>">
            </li>
            <li class="details-form__fields--select details-form__fields--optional">
                <label for="first-name">Birthday Month <span>(optional)</span></label>
                <select name="cf-birthdaymonth" id="interest">
                    <option value="">Select Month...</option>
                    <?php foreach ( $months as $num => $name ): ?>
                    <option value="<?php echo $num;?>" <?php selected( $birthday_month, $num); ?>><?php echo $name;?></option>
                    <?php endforeach; ?>
                </select>
            </li>
            <li class="details-form__fields--submit">
                <button type="submit" name="mw-submitted" class="btn btn--default btn--border-radius">Update details</button>
            </li>
        </ul>
    </fieldset>
</form>
