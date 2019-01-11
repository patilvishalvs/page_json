<?php

namespace Drupal\page_json\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Builds an example page.
 */
class PageJsonController {

  /**
   * Checks access for a specific request.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Run access checks for this account.
   */
  public function access(AccountInterface $account, $siteapikey, NodeInterface $node) {
    // Get site api key from site config
    $apikey = \Drupal::config('system.site')->get('siteapikey');

    // Get content type of node
    $content_type = $node->getType();
    // Check permissions and combine that with any custom access checking needed. Pass forward
    // parameters from the route and/or request as needed.
    return AccessResult::allowedIf($account->hasPermission('access content') && $apikey == $siteapikey && $content_type == 'page');
  }

  /**
   * Get Json response of node of type page
   * @param type $siteapikey
   * @param NodeInterface $node
   * @return JsonResponse
   */
  public function content($siteapikey, NodeInterface $node) {
    // Convert node object to array
    $node_array = $node->toArray();

    // Send Json response of node
    return new JsonResponse($node_array);
  }

}
