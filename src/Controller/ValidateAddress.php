<?php
/**
 * @file
 * Contains \Drupal\ValidateAddress\Controller\ValidateAddress.
 */
namespace Drupal\ValidateAddress\Controller;

use Drupal\Core\Controller\ControllerBase;
//service use statement
use Drupal\SmartyStreetsAPI\Controller\SmartyStreetsAPIService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ValidateAddress extends ControllerBase {
  /**
 * @var \Drupal\SmartyStreetsAPI\Controller\SmartyStreetsAPIService
 */
  protected $APIService;

  /**
   * {@inheritdoc}
   */
  public function __construct(SmartyStreetsAPIService $APIService) {
    $this->APIService = $APIService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('smartystreetsapi.service')
    );
  }

  public function LookupValidAddress() {

      $street_address = $_SESSION['street_address'];
      $city = $_SESSION['city'];
      $state = $_SESSION['state'];
      $arrLookup = $this->APIService->LookupAddress($street_address,$city,$state);
      if ($arrLookup['valid'] == 1) {
       return [
         '#markup' => 'Valid Address: Yes<br>' .
              'Zip Code: ' .  $arrLookup['zipcode'] . '<br>' .
              'County: ' .  $arrLookup['county'] . '<br>' .
              'Latitude: ' .  $arrLookup['latitude'] . '<br>' .
              'Longitude: ' .  $arrLookup['longitude']
       ];
     }
     else {
       return [
         '#markup' => 'Invalid Address<br>Error: ' . $arrLookup['error']
       ];
     }
      // return [
      //   '#markup' => $this->APIService->LookupAddress($street_address,$city,$state)
      // ];
    }

}
