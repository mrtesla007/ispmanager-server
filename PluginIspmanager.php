<?php

// Please send all bugreports to support@ispsystem.com
// with "ClientExec integration plugin" mark.

require_once 'plugins/server/ispmanager/helper.ispmanager.php';
require_once 'modules/admin/models/ServerPlugin.php';
/**
* @package Plugins
*/
class PluginISPManager extends ServerPlugin
{
    public $features = array(
        'packageName' => true,
        'testConnection' => false,
        'showNameservers' => true
    );

    /*****************************************************************/
    // function getVariables - required function
    /*****************************************************************/

    function getVariables(){
        /* Specification
              itemkey     - used to identify variable in your other functions
              type        - text,textarea,yesno,password
              description - description of the variable, displayed in ClientExec
              encryptable - used to indicate the variable's value must be encrypted in the database
        */


        $variables = array (
                /*T*/"Name"/*/T*/ => array (
                                    "type"=>"hidden",
                                    "description"=>/*T*/"Used By CE to show plugin - must match how you call the action function names"/*/T*/,
                                    "value"=>"ISPmanager"
                                   ),
                /*T*/"Description"/*/T*/ => array (
                                    "type"=>"hidden",
                                    "description"=>/*T*/"Description viewable by admin in server settings"/*/T*/,
                                    "value"=>/*T*/"ISPmanager Panel Integration"/*/T*/
                                   ),
                /*T*/"Username"/*/T*/ => array (
                                    "type"=>"text",
                                    "description"=>/*T*/"Username used to connect to server"/*/T*/,
                                    "value"=>""
                                   ),
                /*T*/"Password"/*/T*/ => array (
                                    "type"=>"password",
                                    "description"=>/*T*/"Password used to connect to server"/*/T*/,
                                    "value"=>"",
                                    "encryptable"=>true
                                   ),
                /*T*/"Actions"/*/T*/ => array (
                                    "type"=>"hidden",
                                    "description"=>/*T*/"Current actions that are active for this plugin per server"/*/T*/,
                                    "value"=>"Create,Delete,Suspend,UnSuspend"
                                   ),
                /*T*/'package_vars'/*/T*/  => array(
                                    'type'          => 'hidden',
                                    'description'   => /*T*/'Whether package settings are set'/*/T*/,
                                    'value'         => '0',
                                   ),
                /*T*/'package_vars_values'/*/T*/ => array(
                                    'type'          => 'hidden',
                                    'description'   => /*T*/'Hosting account parameters'/*/T*/,
                                    'value'         => array(
                                                            'ftplimit'       => array(
                                                                                   'type'           => 'text',
                                                                                   'description'    => /*T*/'Maximum number of ftp-users'/*/T*/,
                                                                                   'value'          => '',
                                                                                ),
                                                            'maillimit'           => array(
                                                                                   'type'           => 'text',
                                                                                   'description'    => /*T*/'Maximum number of mail boxes'/*/T*/,
                                                                                   'value'          => '1',
                                                                                ),
                                                            'domainlimit'    => array(
                                                                                   'type'           => 'text',
                                                                                   'description'    => /*T*/'Maximum number of domain name zones'/*/T*/,
                                                                                   'value'          => '',
                                                                                ),
                                                            'disklimit'    => array(
                                                                                   'type'           => 'text',
                                                                                   'description'    => /*T*/'Disk space (in bytes, leave empty for unlimited)'/*/T*/,
                                                                                   'value'          => '',
                                                                                ),
                                                            'webdomainlimit'   => array(
                                                                                   'type'           => 'text',
                                                                                   'description'    => /*T*/'Maximum number of web sites'/*/T*/,
                                                                                   'value'          => '',
                                                                                ),
                                                            'maildomainlimit'        => array(
                                                                                   'type'           => 'text',
                                                                                   'description'    => /*T*/'Maximum number of mail domains'/*/T*/,
                                                                                   'value'          => '',
                                                                                ),
                                                            'baselimit'        => array(
                                                                                   'type'           => 'text',
                                                                                   'description'    => /*T*/'Maximum number of databases'/*/T*/,
                                                                                   'value'          => '',
                                                                                ),
                                                            'baseuserlimit'       => array(
                                                                                   'type'           => 'text',
                                                                                   'description'    => /*T*/'Maximum number of database users'/*/T*/,
                                                                                   'value'          => '',
                                                                                ),
                                                            'bandwidthlimit'    => array(
                                                                                   'type'           => 'text',
                                                                                   'description'    => /*T*/'Traffic quota (in kbytes)'/*/T*/,
                                                                                   'value'          => '',
                                                                                ),
                                                            'ssl'           => array(
                                                                                    'type'          => 'yesno',
                                                                                    'description'   => /*T*/'SSL support'/*/T*/,
                                                                                    'value'         => '0',
                                                                                ),
                                                            'shell'         => array(
                                                                                    'type'          => 'yesno',
                                                                                    'description'   => /*T*/'System shell'/*/T*/,
                                                                                    'value'         => '',
                                                                                ),
                                                            'phpmod'           => array(
                                                                                    'type'          => 'yesno',
                                                                                    'description'   => /*T*/'PHP as Apache Module support'/*/T*/,
                                                                                    'value'         => '0',
                                                                                ),
                                                            'phpcgi'           => array(
                                                                                    'type'          => 'yesno',
                                                                                    'description'   => /*T*/'PHP as CGI support'/*/T*/,
                                                                                    'value'         => '0',
                                                                                ),
                                                            'phpfcgi'           => array(
                                                                                    'type'          => 'yesno',
                                                                                    'description'   => /*T*/'PHP as FastCGI support'/*/T*/,
                                                                                    'value'         => '0',
                                                                                ),
                                                            'ssi'           => array(
                                                                                    'type'          => 'yesno',
                                                                                    'description'   => /*T*/'SSI support'/*/T*/,
                                                                                    'value'         => '0',
                                                                                ),
                                                            'cgi'           => array(
                                                                                    'type'          => 'yesno',
                                                                                    'description'   => /*T*/'CGI support'/*/T*/,
                                                                                    'value'         => '0',
                                                                                ),
                                        ),
                    ),
                /*T*/'package_addons'/*/T*/ => array(
                    'type'          => 'hidden',
                    'description'   => /*T*/'Supported signup addons variables'/*/T*/,
                    'value'         => array(
                        'DISKSPACE', 'BANDWIDTH', 'SSH_ACCESS', 'SSL'
                    ),
                )

        );
        return $variables;
    }

    function _ISPRequest($args, $req, $outtype = 'xml')
    {
        require_once 'library/CE/NE_Network.php';

        $ret = "";
        $url = "https://".$args['server']['variables']['ServerHostName']."/manager/ispmgr?authinfo=".$args['server']['variables']['plugin_ispmanager_Username'].":".$args['server']['variables']['plugin_ispmanager_Password']."&out=".$outtype."&".$req;
        $ret = NE_Network::curlRequest($this->settings, $url, '', '', true, false);
        return $ret;
    }

    function _ISPRestart($args) {
        $res = false;
        $result = $this->_ISPRequest($args, "func=restart", "text");
        if ($result == "OK ")
            $res = true;
        return $res;
    }

    function _ISPCheckPreset($args, $preset) {
        $preset_found = false;
        $ret = $this->_ISPRequest($args, "func=preset", "xml");
        $objXML = new xml2Array();
        $arrOutput = $objXML->parse($ret);
        if (isset($arrOutput[0]['children'])) {
            foreach ($arrOutput[0]['children'] as $el) {
                if (!isset($el['children'])) continue;
    	        foreach ($el['children'] as $elem) {
                    if ($elem['name'] == "NAME" && $elem['tagData'] == $preset) $preset_found = true;
        //        echo print_r($elem);
                }
            }
        }
        // Making Preset if not exists
        if (!$preset_found) $preset_found = $this->_ISPCreatePreset($args, $preset);

        return $preset_found;
    }

    function _ISPCreatePreset($args, $name) {
        $ssi = "off"; $ssl = "off"; $shell = "off"; $cgi = "off";
        $phpmod = "off"; $phpcgi="off"; $phpfcgi="off"; $ptype = "user";
        $pv = $args['package']['variables'];
        $res = false;
        if (isset($pv['ssi']) && $pv['ssi'] == 1) $ssi = "on";
        if (isset($pv['ssl']) && $pv['ssl'] == 1) $ssl = "on";
        if (isset($pv['cgi']) && $pv['cgi'] == 1) $cgi = "on";
        if (isset($pv['shell']) && $pv['shell'] == 1) $shell = "on";
        if (isset($pv['phpcgi']) && $pv['phpcgi'] == 1) $phpcgi = "on";
        if (isset($pv['phpmod']) && $pv['phpmod'] == 1) $phpmod = "on";
        if (isset($pv['phpfcgi']) && $pv['phpfcgi'] == 1) $phpfcgi = "on";
        $q = "name=".$name."&ptype=".$ptype."&disklimit=".$pv['disklimit']."&ftplimit=".$pv['ftplimit']."&maillimit=".$pv['maillimit']."&domainlimit=".$pv['domainlimit']."&webdomainlimit=".$pv['webdomainlimit']."&maildomainlimit=".$pv['maildomainlimit']."&baselimit=".$pv['baselimit']."&baseuserlimit=".$pv['baseuserlimit']."&bandwidthlimit=".$pv['bandwidthlimit']."&ssi=".$ssi."&ssl=".$ssl."&shell=".$shell."&cgi=".$cgi."&phpfcgi=".$phpfcgi."&phpcgi=".$phpcgi."&phpmod=".$phpmod."&func=preset.edit&elid=&sok=ok&suok=++++Ok++++";
        $result = $this->_ISPRequest($args, $q, "text");
        if ($result == "OK ") {
            $res = true;
        } else {
            throw new CE_Exception("ISPmanager can't create Preset");
        }
        return $res;
    }

    //plugin function called after new account is activated ( approved )
    function create($args) {
        if ( $this->_ISPCheckPreset($args, $args['package']['name_on_server']) ) {
    	    $ssi = "off"; $ssl = "off"; $shell = "off"; $cgi = "off";
            $phpmod = "off"; $phpcgi="off"; $phpfcgi="off"; $ptype = "user";
            $pv = $args['package_vars'];
            if (isset($args['package']['addons']['DISKSPACE'])) {
    		    $pv['disklimit'] += ((int)$args['package']['addons']['DISKSPACE']);
    	    }
    	    if (isset($args['package']['addons']['BANDWIDTH'])) {
        	    $pv['bandwidthlimit'] += ((int)$args['package']['addons']['BANDWIDTH']);
            }
            if (isset($args['package']['addons']['SSH_ACCESS']) && $args['package']['addons']['SSH_ACCESS'] == 1) {
                $pv['shell'] = 1;
            }
            if (isset($args['package']['addons']['SSL']) && $args['package']['addons']['SSL'] == 1) {
                $pv['ssl'] = 1;
            }
            if (isset($pv['ssi']) && $pv['ssi'] == 1) $ssi = "on";
            if (isset($pv['ssl']) && $pv['ssl'] == 1) $ssl = "on";
            if (isset($pv['cgi']) && $pv['cgi'] == 1) $cgi = "on";
            if (isset($pv['shell']) && $pv['shell'] == 1) $shell = "on";
            if (isset($pv['phpcgi']) && $pv['phpcgi'] == 1) $phpcgi = "on";
            if (isset($pv['phpmod']) && $pv['phpmod'] == 1) $phpmod = "on";
            if (isset($pv['phpfcgi']) && $pv['phpfcgi'] == 1) $phpfcgi = "on";
            $q = "name=".$args['package']['username']."&passwd=".$args['package']['password']."&confirm=".$args['package']['password']."&ptype=".$ptype."&domain=".$args['package']['domain_name']."&ip=".$args['package']['ip']."&preset=".$args['package']['name_on_server']."&disklimit=".$pv['disklimit']."&ftplimit=".$pv['ftplimit']."&maillimit=".$pv['maillimit']."&domainlimit=".$pv['domainlimit']."&webdomainlimit=".$pv['webdomainlimit']."&maildomainlimit=".$pv['maildomainlimit']."&baselimit=".$pv['baselimit']."&baseuserlimit=".$pv['baseuserlimit']."&bandwidthlimit=".$pv['bandwidthlimit']."&ssi=".$ssi."&ssl=".$ssl."&shell=".$shell."&cgi=".$cgi."&phpfcgi=".$phpfcgi."&phpcgi=".$phpcgi."&phpmod=".$phpmod."&func=user.edit&elid=&sok=ok&suok=++++Ok++++";
            $result = $this->_ISPRequest($args, $q, "xml");
            $objXML = new xml2Array();
            $arrOutput = $objXML->parse($result);
            foreach ($arrOutput[0]['children'] as $el) {
                if ($el['name'] == 'ERROR')
                    throw new CE_Exception("ISPManager error #".$el['attrs']['CODE']." in object \"".$el['attrs']['OBJ']."\"");
                if ($el['name'] == 'OK') {
                    if ($el['tagData'] == 'restart') return $this->_ISPRestart($args);
                }
            }
        }
        return false;
    }

    function delete($args){
        $result = $this->_ISPRequest($args, "func=user.delete&elid=".$args['package']['username'], "xml");
        $objXML = new xml2Array();
        $arrOutput = $objXML->parse($result);
        foreach ($arrOutput[0]['children'] as $el) {
            if ($el['name'] == 'OK') {
                if ($el['tagData'] == 'restart') return $this->_ISPRestart($args);
            }
        }
        return false;
    }

    function update($args, $userPackage = null) {
        $package = $args['CHANGE_PACKAGE'];
        if ( $this->_ISPCheckPreset($args, $package) ) {
            $ssi = "off"; $ssl = "off"; $shell = "off"; $cgi = "off";
            $phpmod = "off"; $phpcgi="off"; $phpfcgi="off"; $ptype = "user";
            $pv = $args['package']['variables'];
            if (isset($args['package']['addons']['DISKSPACE'])) {
        	    $pv['disklimit'] += ((int)$args['package']['addons']['DISKSPACE']);
            }
            if (isset($args['package']['addons']['BANDWIDTH'])) {
                $pv['bandwidthlimit'] += ((int)$args['package']['addons']['BANDWIDTH']);
            }
            if (isset($args['package']['addons']['SSH_ACCESS']) && $args['package']['addons']['SSH_ACCESS'] == 1) {
                $pv['shell'] = 1;
            }
            if (isset($args['package']['addons']['SSL']) && $args['package']['addons']['SSL'] == 1) {
                $pv['ssl'] = 1;
            }
            if (isset($pv['ssi']) && $pv['ssi'] == 1) $ssi = "on";
            if (isset($pv['ssl']) && $pv['ssl'] == 1) $ssl = "on";
            if (isset($pv['cgi']) && $pv['cgi'] == 1) $cgi = "on";
            if (isset($pv['shell']) && $pv['shell'] == 1) $shell = "on";
            if (isset($pv['phpcgi']) && $pv['phpcgi'] == 1) $phpcgi = "on";
            if (isset($pv['phpmod']) && $pv['phpmod'] == 1) $phpmod = "on";
            if (isset($pv['phpfcgi']) && $pv['phpfcgi'] == 1) $phpfcgi = "on";
            $q = "name=".$args['package']['username']."&passwd=".$args['changes']['password']."&confirm=".$args['changes']['password']."&ptype=".$ptype."&ip=".$args['package']['ip']."&preset=".$args['package']['name_on_server']."&disklimit=".$pv['disklimit']."&ftplimit=".$pv['ftplimit']."&maillimit=".$pv['maillimit']."&domainlimit=".$pv['domainlimit']."&webdomainlimit=".$pv['webdomainlimit']."&maildomainlimit=".$pv['maildomainlimit']."&baselimit=".$pv['baselimit']."&baseuserlimit=".$pv['baseuserlimit']."&bandwidthlimit=".$pv['bandwidthlimit']."&ssi=".$ssi."&ssl=".$ssl."&shell=".$shell."&cgi=".$cgi."&phpfcgi=".$phpfcgi."&phpcgi=".$phpcgi."&phpmod=".$phpmod."&func=user.edit&elid=".$args['package']['username']."&sok=ok&suok=++++Ok++++";
            $result = $this->_ISPRequest($args, $q, "xml");
            $objXML = new xml2Array();
            $arrOutput = $objXML->parse($result);
            foreach ($arrOutput[0]['children'] as $el) {
                if ($el['name'] == 'ERROR')
            	    throw new CE_Exception("ISPManager error #".$el['attrs']['CODE']." in object \"".$el['attrs']['OBJ']."\"");
                if ($el['name'] == 'OK') {
        	    if (isset($el['tagData']) && $el['tagData'] == 'restart') return $this->_ISPRestart($args);
                }
            }
        }
        return false;
    }

    function suspend($args){
        $result = $this->_ISPRequest($args, "func=user.disable&elid=".$args['package']['username'], "xml");
        $objXML = new xml2Array();
        $arrOutput = $objXML->parse($result);
        foreach ($arrOutput[0]['children'] as $el) {
            if ($el['name'] == 'OK') {
                if ($el['tagData'] == 'restart') return $this->_ISPRestart($args);
            }
        }
        return false;
    }

    function unsuspend($args){
        $result = $this->_ISPRequest($args, "func=user.enable&elid=".$args['package']['username'], "xml");
        $objXML = new xml2Array();
        $arrOutput = $objXML->parse($result);
        foreach ($arrOutput[0]['children'] as $el) {
            if ($el['name'] == 'OK') {
                if ($el['tagData'] == 'restart') return $this->_ISPRestart($args);
            }
        }
        return false;
    }

    function doCreate($args)
    {
        $userPackage = new UserPackage($args['userPackageId']);
        $this->create($this->buildParams($userPackage));
        return $userPackage->getCustomField("Domain Name") .  ' has been created.';
    }

    function doSuspend($args)
    {
        $userPackage = new UserPackage($args['userPackageId']);
        $this->suspend($this->buildParams($userPackage));
        return $userPackage->getCustomField("Domain Name") .  ' has been suspended.';
    }

    function doUnSuspend($args)
    {
        $userPackage = new UserPackage($args['userPackageId']);
        $this->unsuspend($this->buildParams($userPackage));
        return $userPackage->getCustomField("Domain Name") .  ' has been unsuspended.';
    }

    function doDelete($args)
    {
        $userPackage = new UserPackage($args['userPackageId']);
        $this->delete($this->buildParams($userPackage));
        return $userPackage->getCustomField("Domain Name") . ' has been deleted.';
    }
}
?>