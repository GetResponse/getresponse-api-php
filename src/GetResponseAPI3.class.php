<?php

/**
 * GetResponse API v3 client library
 *
 * @author Pawel Maslak <pawel.maslak@getresponse.com>
 * @author Grzegorz Struczynski <grzegorz.struczynski@implix.com>
 *
 * @see http://apidocs.getresponse.com/en/v3/resources
 * @see https://github.com/GetResponse/getresponse-api-php
 */
class GetResponse
{

    private $api_key;
    private $api_url = 'https://api.getresponse.com/v3';
    private $timeout = 8;
    public $http_status;

    /**
     * X-Domain header value if empty header will be not provided
     * @var string|null
     */
    private $enterprise_domain = null;

    /**
     * X-APP-ID header value if empty header will be not provided
     * @var string|null
     */
    private $app_id = null;

    /**
     * Set api key and optionally API endpoint
     * @param      $api_key
     * @param null $api_url
     */
    public function __construct($api_key, $api_url = null)
    {
        $this->api_key = $api_key;

        if (!empty($api_url)) {
            $this->api_url = $api_url;
        }
    }

    /**
     * We can modify internal settings
     * @param $key
     * @param $value
     */
    function __set($key, $value)
    {
        $this->{$key} = $value;
    }

    /**
     * get account details
     *
     * @return mixed
     */
    public function accounts()
    {
        return $this->call('accounts');
    }

    /**
     * @return mixed
     */
    public function ping()
    {
        return $this->accounts();
    }

    /**
     * Return all campaigns
     * @return mixed
     */
    public function getCampaigns()
    {
        return $this->call('campaigns');
    }

    /**
     * get single campaign
     * @param string $campaign_id retrieved using API
     * @return mixed
     */
    public function getCampaign($campaign_id)
    {
        return $this->call('campaigns/' . $campaign_id);
    }

    /**
     * adding campaign
     * @param $params
     * @return mixed
     */
    public function createCampaign($params)
    {
        return $this->call('campaigns', 'POST', $params);
    }

    /**
     * list all RSS newsletters
     * @return mixed
     */
    public function getRSSNewsletters()
    {
        $this->call('rss-newsletters', 'GET', null);
    }

    /**
     * send one newsletter
     *
     * @param $params
     * @return mixed
     */
    public function sendNewsletter($params)
    {
        return $this->call('newsletters', 'POST', $params);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function sendDraftNewsletter($params)
    {
        return $this->call('newsletters/send-draft', 'POST', $params);
    }

    /**
     * add single contact into your campaign
     *
     * @param $params
     * @return mixed
     */
    public function addContact($params)
    {
        return $this->call('contacts', 'POST', $params);
    }

    /**
     * retrieving contact by id
     *
     * @param string $contact_id - contact id obtained by API
     * @return mixed
     */
    public function getContact($contact_id)
    {
        return $this->call('contacts/' . $contact_id);
    }


    /**
     * search contacts
     *
     * @param $params
     * @return mixed
     */
    public function searchContacts($params = null)
    {
        return $this->call('search-contacts?' . $this->setParams($params));
    }

    /**
     * retrieve segment
     *
     * @param $id
     * @return mixed
     */
    public function getContactsSearch($id)
    {
        return $this->call('search-contacts/' . $id);
    }

    /**
     * add contacts search
     *
     * @param $params
     * @return mixed
     */
    public function addContactsSearch($params)
    {
        return $this->call('search-contacts/', 'POST', $params);
    }

    /**
     * add contacts search
     *
     * @param $id
     * @return mixed
     */
    public function deleteContactsSearch($id)
    {
        return $this->call('search-contacts/' . $id, 'DELETE');
    }

    /**
     * get contact activities
     * @param $contact_id
     * @return mixed
     */
    public function getContactActivities($contact_id)
    {
        return $this->call('contacts/' . $contact_id . '/activities');
    }

    /**
     * retrieving contact by params
     * @param array $params
     *
     * @return mixed
     */
    public function getContacts($params = array())
    {
        return $this->call('contacts?' . $this->setParams($params));
    }

    /**
     * updating any fields of your subscriber (without email of course)
     * @param       $contact_id
     * @param array $params
     *
     * @return mixed
     */
    public function updateContact($contact_id, $params = array())
    {
        return $this->call('contacts/' . $contact_id, 'POST', $params);
    }

    /**
     * drop single user by ID
     *
     * @param string $contact_id - obtained by API
     * @return mixed
     */
    public function deleteContact($contact_id)
    {
        return $this->call('contacts/' . $contact_id, 'DELETE');
    }

    /**
     * retrieve account custom fields
     * @param array $params
     *
     * @return mixed
     */
    public function getCustomFields($params = array())
    {
        return $this->call('custom-fields?' . $this->setParams($params));
    }

    /**
     * add custom field
     *
     * @param $params
     * @return mixed
     */
    public function setCustomField($params)
    {
        return $this->call('custom-fields', 'POST', $params);
    }

    /**
     * retrieve single custom field
     *
     * @param string $cs_id obtained by API
     * @return mixed
     */
    public function getCustomField($custom_id)
    {
        return $this->call('custom-fields/' . $custom_id, 'GET');
    }

    /**
     * retrieving billing information
     *
     * @return mixed
     */
    public function getBillingInfo()
    {
        return $this->call('accounts/billing');
    }

    /**
     * get single web form
     *
     * @param int $w_id
     * @return mixed
     */
    public function getWebForm($w_id)
    {
        return $this->call('webforms/' . $w_id);
    }

    /**
     * retrieve all webforms
     * @param array $params
     *
     * @return mixed
     */
    public function getWebForms($params = array())
    {
        return $this->call('webforms?' . $this->setParams($params));
    }

    /**
     * get single form
     *
     * @param int $form_id
     * @return mixed
     */
    public function getForm($form_id)
    {
        return $this->call('forms/' . $form_id);
    }

    /**
     * retrieve all forms
     * @param array $params
     *
     * @return mixed
     */
    public function getForms($params = array())
    {
        return $this->call('forms?' . $this->setParams($params));
    }

    /**
     * Curl run request
     *
     * @param null $api_method
     * @param string $http_method
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    private function call($api_method = null, $http_method = 'GET', $params = array())
    {
        if (empty($api_method)) {
            return (object)array(
                'httpStatus' => '400',
                'code' => '1010',
                'codeDescription' => 'Error in external resources',
                'message' => 'Invalid api method'
            );
        }

        $params = json_encode($params);
        $url = $this->api_url . '/' . $api_method;

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_ENCODING => 'gzip,deflate',
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_HEADER => false,
            CURLOPT_USERAGENT => 'PHP GetResponse client 0.0.2',
            CURLOPT_HTTPHEADER => array('X-Auth-Token: api-key ' . $this->api_key, 'Content-Type: application/json')
        );

        if (!empty($this->enterprise_domain)) {
            $options[CURLOPT_HTTPHEADER][] = 'X-Domain: ' . $this->enterprise_domain;
        }

        if (!empty($this->app_id)) {
            $options[CURLOPT_HTTPHEADER][] = 'X-APP-ID: ' . $this->app_id;
        }

        if ($http_method == 'POST') {
            $options[CURLOPT_POST] = 1;
            $options[CURLOPT_POSTFIELDS] = $params;
        } else if ($http_method == 'DELETE') {
            $options[CURLOPT_CUSTOMREQUEST] = 'DELETE';
        }

        $curl = curl_init();
        curl_setopt_array($curl, $options);

        $response = json_decode(curl_exec($curl));

        $this->http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);
        return (object)$response;
    }

    /**
     * @param array $params
     *
     * @return string
     */
    private function setParams($params = array())
    {
        $result = array();
        if (is_array($params)) {
            foreach ($params as $key => $value) {
                $result[$key] = $value;
            }
        }
        return http_build_query($result);
    }

}