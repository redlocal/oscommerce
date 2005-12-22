<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2005 osCommerce

  Released under the GNU General Public License
*/

  class osC_Boxes_whats_new extends osC_Modules {
    var $_title = 'What\'s New',
        $_code = 'whats_new',
        $_author_name = 'osCommerce',
        $_author_www = 'http://www.oscommerce.com',
        $_group = 'boxes';

    function osC_Boxes_whats_new() {
//      $this->_title = BOX_HEADING_WHATS_NEW;
      $this->_title_link = tep_href_link(FILENAME_PRODUCTS, 'new');
    }

    function initialize() {
      global $osC_Cache, $osC_Database, $osC_Services, $osC_Currencies, $osC_Specials;

      if ((BOX_WHATS_NEW_CACHE > 0) && $osC_Cache->read('box-whats_new-' . $_SESSION['language'], BOX_WHATS_NEW_CACHE)) {
        $data = $osC_Cache->getCache();
      } else {
        $Qnew = $osC_Database->query('select p.products_id, p.products_image, p.products_tax_class_id, p.products_price, pd.products_name, pd.products_keyword from :table_products p, :table_products_description pd where p.products_status = 1 and p.products_id = pd.products_id and pd.language_id = :language_id order by p.products_date_added desc limit :max_random_select_new');
        $Qnew->bindTable(':table_products', TABLE_PRODUCTS);
        $Qnew->bindTable(':table_products_description', TABLE_PRODUCTS_DESCRIPTION);
        $Qnew->bindInt(':language_id', $_SESSION['languages_id']);
        $Qnew->bindInt(':max_random_select_new', BOX_WHATS_NEW_RANDOM_SELECT);
        $Qnew->executeRandomMulti();

        $data = array();

        if ($Qnew->numberOfRows()) {
          $data = $Qnew->toArray();

          $products_price = $osC_Currencies->displayPrice($Qnew->valueDecimal('products_price'), $Qnew->valueInt('products_tax_class_id'));

          if ($osC_Services->isStarted('specials') && $osC_Specials->isActive($Qnew->valueInt('products_id'))) {
            $products_price = '<s>' . $new_products_price . '</s>&nbsp;<span class="productSpecialPrice">' . $osC_Currencies->displayPrice($osC_Specials->getPrice($Qnew->valueInt('products_id')), $Qnew->valueInt('products_tax_class_id')) . '</span>';
          }

          $data['products_price'] = $products_price;
        }

        $osC_Cache->writeBuffer($data);
      }

      if (empty($data) === false) {
        $this->_content = '<a href="' . tep_href_link(FILENAME_PRODUCTS, $data['products_keyword']) . '">' . tep_image(DIR_WS_IMAGES . $data['products_image'], $data['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br /><a href="' . tep_href_link(FILENAME_PRODUCTS, $data['products_keyword']) . '">' . $data['products_name'] . '</a><br />' . $data['products_price'];
      }
    }

    function install() {
      global $osC_Database;

      parent::install();

      $osC_Database->simpleQuery("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Random New Product Selection', 'BOX_WHATS_NEW_RANDOM_SELECT', '10', 'Select a random new product from this amount of the newest products available', '6', '0', now())");
      $osC_Database->simpleQuery("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Cache Contents', 'BOX_WHATS_NEW_CACHE', '1', 'Number of minutes to keep the contents cached (0 = no cache)', '6', '0', now())");
    }

    function getKeys() {
      if (!isset($this->_keys)) {
        $this->_keys = array('BOX_WHATS_NEW_RANDOM_SELECT', 'BOX_WHATS_NEW_CACHE');
      }

      return $this->_keys;
    }
  }
?>
