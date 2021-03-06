<?php


/**
 *  This file is part of amfPHP
 *
 * LICENSE
 *
 * This source file is subject to the license that is bundled
 * with this package in the file license.txt.
 * @package Amfphp_Plugins_Discovery
 */

/**
*  includes
*  */
require_once dirname(__FILE__) . '/DiscoveryService.php';
require_once dirname(__FILE__) . '/MethodInfo.php';
require_once dirname(__FILE__) . '/ParameterInfo.php';
require_once dirname(__FILE__) . '/ServiceInfo.php';

/**
 * adds the discovery service, a service that returns information about available services. 
 * Don't use on a production server unless you know what you're doing!
 * @package Amfphp_Plugins_Discovery
 * @author Ariel Sommeria-Klein
 */
class AmfphpDiscovery {
    /**
     * constructor.
     * adds filters to grab config about services and add discovery service. Low priority so that other plugins can add their services first
     * @param array $config optional key/value pairs in an associative array. Used to override default configuration values.
     */
    public function  __construct(array $config = null) {
        $filterManager = Amfphp_Core_FilterManager::getInstance();
        $filterManager->addFilter(Amfphp_Core_Gateway::FILTER_SERVICE_NAMES_2_CLASS_FIND_INFO, $this, 'filterServiceNames2ClassFindInfo', 99);
        $filterManager->addFilter(Amfphp_Core_Gateway::FILTER_SERVICE_FOLDER_PATHS, $this, 'filterServiceFolderPaths', 99);
    }
    
     /**
     * grabs serviceFolderPaths from config
     * @param array serviceFolderPaths array of absolute paths
     */
    public function filterServiceFolderPaths(array $serviceFolderPaths){
        DiscoveryService::$serviceFolderPaths = $serviceFolderPaths;
        return $serviceFolderPaths;
    }
     /**
     * grabs serviceNames2ClassFindInfo from config and add discovery service
     * @param array $serviceNames2ClassFindInfo associative array of key -> class find info
     */
    public function filterServiceNames2ClassFindInfo(array $serviceNames2ClassFindInfo){
        $serviceNames2ClassFindInfo["DiscoveryService"] = new Amfphp_Core_Common_ClassFindInfo( dirname(__FILE__) . '/DiscoveryService.php', 'DiscoveryService');
        DiscoveryService::$serviceNames2ClassFindInfo = $serviceNames2ClassFindInfo;
        return $serviceNames2ClassFindInfo;
    }    
}

?>
