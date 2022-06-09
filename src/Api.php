<?php

/**
 * @package	vudeo.net - vudeo.io API Wrapper
 * @author	Olsion Bakiaj
 * @copyright   2022 Albdroid.AL (http://albdroid.al/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://github.com/SxtBox/Vudeo_API_Wrapper
 * @since	Version 1.0.0
 */

namespace Vudeo\Streaming;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Api
{
    private const BASE_URL = "https://vudeo.net/api";
    //private const BASE_URL = "https://vudeo.io/api";

    /**
     * @var Client $client
     */
    private $client;

    /**
     * @var string $api_key Your own api key from https://vudeo.io/?op=my_account
     */
    private $api_key;
   //private $api_key = "ENTER_API_KEY";

    /**
     * Api constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $api_key
     * @return Api
     */
    public function set_api_key(string $api_key): self
    {
        $this->api_key = $api_key;
        return $this;
    }

    /**
     * @param string $scope
     * @param array $additonnalQueryParams
     * @return mixed
     * @throws Exception
     */
    private function callApi(string $scope, array $additonnalQueryParams = [])
    {
        $queryParameters = array_merge([
            'key' => $this->api_key,
        ], $additonnalQueryParams);

        $uri = self::BASE_URL . $scope . '' . http_build_query($queryParameters);
       //$uri = self::BASE_URL . $scope . '?' . http_build_query($queryParameters); // WITH AUTO QUERY

        try {
            $response = $this->client->request('GET', $uri);
        } catch (GuzzleException $e) {
            throw new Exception(sprintf(
                'Exception thrown by client: %s',
                $e->getMessage()
            ), $e);
        }

        if (200 !== $response->getStatusCode()) {
            throw new Exception(sprintf(
                'Bad status code %d returned when called uri %s', $response->getStatusCode(), $uri
            ));
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get json data
     *
     * @param string $id Example: aqgypxct9pmq
     * @return mixed
     */
    //public function get_direct_link(string $id)

	 public function get_direct_link($id)
    {
	return $this->callApi("/file/direct_link?" . "file_code=" . $id ."&");
    }

    /*
    Group Account
    My Account Functions
    Account Info [GET /api/account/info?key={key}]

    + Parameters
    + key: 123456 (string) - API key
    */
	 public function get_account_info()
    {
	return $this->callApi("/account/info?");
    }

    /*
    Account Stats [/api/account/stats?key={key}]
    Example: https://vudeo.net/api/account/stats?key={API_KEY}
    Account Stats [GET /api/account/stats?key={key}&last={last}]

    + Parameters
    + key: 123456 (string) - API key
    + last (number,optional) - show stats for last X days
    + Default: `7`
    */
	 public function get_account_stats()
    {
	return $this->callApi("/account/stats?");
    }

	 public function get_account_stats_last($day)
    {
	return $this->callApi("/account/stats?" . "&last="  . $day ."&");
    }

    /*
    Group Upload
    Upload by URL [/api/upload/url]
    Add URL to upload queue GET /api/upload/url?key={key}&url={url}

    + Parameters
    + key: 123456 (string) - API key
    + url: http://site.com/v.mkv (url) - URL to video file
    */
	 public function upload($url)
    {
	return $this->callApi("/upload/url?" . "&url="  . $url ."&");
    }

    /*
    Get next Upload Server URL [GET /api/upload/server?key={key}]
    + Parameters
    + key: 123456 (string) - API key
    */
	 public function get_uploading_server()
    {
	return $this->callApi("/upload/server?");
    }

	 public function get_file_info($file_code)
    {
	return $this->callApi("/file/info?" . "&file_code="  . $file_code ."&");
    }

    /*
    GET ALL JSON DATA
    File List [/api/file/list]
    Get files list [GET /api/file/list{?key,page,per_page,fld_id,public,created,title}]

    + Parameters
    + key: 123456 (string) - API key
    + page: 2 (optional,number) - page number
    + per_page: 20 (optional,number) - number of results per page
    + fld_id: 15 (optional,number) - folder id
    + public: 1 (optional,number) - show public (1) or private (0) files only
    + created: `2018-06-21 05:07:10` (optional,string) - show only files uploaded after timestamp. Specify number to show only files uploaded X minutes ago.
    + title: `Iron man` (optional,string) - filter video titles
    */

	public function get_file_list()
    {
	return $this->callApi("/file/list?");
    }

    /*
    Group Folders
    Folder List [/api/folder/list]
    Get folder/file list [GET /api/folder/list?key={key}&fld_id={fld_id}]

    + Parameters
    + key: 123456 (string) - API key
    + fld_id: 15 (optional,number) - folder id
    + Get it from https://vudeo.io/?op=my_files&fld_id=XXX
    + XXX is folder id
    */
	public function get_folder_list($folder_id)
    {
	return $this->callApi("/folder/list?" . "&fld_id="  . $folder_id . "&");
    }

}
