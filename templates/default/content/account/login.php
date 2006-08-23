<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2006 osCommerce

  Released under the GNU General Public License
*/
?>

<?php echo tep_image(DIR_WS_IMAGES . 'table_background_login.gif', $osC_Template->getPageTitle(), null, null, 'id="pageIcon"'); ?>

<h1><?php echo $osC_Template->getPageTitle(); ?></h1>

<?php
  if ($messageStack->size('login') > 0) {
    echo $messageStack->output('login');
  }
?>

<div class="moduleBox" style="width: 49%; float: right;">
  <form name="login" action="<?php echo tep_href_link(FILENAME_ACCOUNT, 'login=process', 'SSL'); ?>" method="post">

  <h6><?php echo $osC_Language->get('login_returning_customer_heading'); ?></h6>

  <div class="content">
    <p><?php echo $osC_Language->get('login_returning_customer_text'); ?></p>

    <ol>
      <li><?php echo osc_draw_label($osC_Language->get('field_customer_email_address'), 'email_address') . osc_draw_input_field('email_address'); ?></li>
      <li><?php echo osc_draw_label($osC_Language->get('field_customer_password'), 'password') . osc_draw_password_field('password'); ?></li>
    </ol>

    <p><?php echo sprintf($osC_Language->get('login_returning_customer_password_forgotten'), tep_href_link(FILENAME_ACCOUNT, 'password_forgotten', 'SSL')); ?></p>

    <p align="right"><?php echo tep_image_submit('button_login.gif', $osC_Language->get('button_sign_in')); ?></p>
  </div>

  </form>
</div>

<div class="moduleBox" style="width: 49%;">
  <div class="outsideHeading">
    <h6><?php echo $osC_Language->get('login_new_customer_heading'); ?></h6>
  </div>

  <div class="content">
    <p><?php echo $osC_Language->get('login_new_customer_text'); ?></p>

    <p align="right"><?php echo osc_link_object(tep_href_link(FILENAME_ACCOUNT, 'create', 'SSL'), tep_image_button('button_continue.gif', $osC_Language->get('button_continue'))); ?></p>
  </div>
</div>
