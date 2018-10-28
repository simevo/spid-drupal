<?php

namespace Drupal\spid_login\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'SpidLogin' Block.
 *
 * @Block(
 *   id = "spidlogin_block",
 *   admin_label = @Translation("spidlogin"),
 *   category = @Translation("spidlogin"),
 * )
 */
class SpidLoginBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return array(
      '#markup' => $this->t('Spid login button'),
    );
  }

}