<?php

/**
 * @file
 * Definition of Drupal\dolebas_uploader\Plugin\views\field\CloudinaryViewsField.
 */

namespace Drupal\dolebas_uploader\Plugin\views\field;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * Field handler to display upload widget.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("cloudinary_views_field")
 */
class CloudinaryViewsField extends FieldPluginBase {

  /**
   * @{inheritdoc}
   */
  public function query() {
    // Leave empty to avoid a query on this field.
  }

  /**
   * @{inheritdoc}
   */
  public function render(ResultRow $values) {

    $viewnid = strip_tags($this->view->field['nid']->original_value);

    if ($viewnid) {
      $nid = $viewnid;
    }
    else {
      $nid = NULL;
    }

    $config = \Drupal::config('dolebas_uploader.settings');
    $cloud_name = $config->get('cloudinary_cloud_name');
    $upload_preset = $config->get('cloudinary_upload_preset');

    $element['cloudinary_upload_widget']  = [
      // '#type' => 'inline_template',
      '#theme' => 'cloudinary_views_field',
      '#attached' => array(
        'library' => array(
          'dolebas_uploader/cloudinary-views-field'
         ),
         'drupalSettings' => array(
           'cloud_name' => $cloud_name,
           'upload_preset' => $upload_preset,
           'nid' => $nid,
        )        
      )
    ];
    $element['#cache']['max-age'] = 0;

    return $element;

  }
}
