<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Api\V2010\Account\Call;

use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;

class RecordingList extends ListResource {
    /**
     * Construct the RecordingList
     * 
     * @param Version $version Version that contains the resource
     * @param string $accountSid The SID of the Account that created the resource
     * @param string $callSid The SID of the Call the resource is associated with
     * @return \Twilio\Rest\Api\V2010\Account\Call\RecordingList 
     */
    public function __construct(Version $version, $accountSid, $callSid) {
        parent::__construct($version);

        // Path Solution
        $this->solution = array('accountSid' => $accountSid, 'callSid' => $callSid, );

        $this->uri = '/Accounts/' . rawurlencode($accountSid) . '/Calls/' . rawurlencode($callSid) . '/Recordings.json';
    }

    /**
     * Create a new RecordingInstance
     * 
     * @param array|Options $options Optional Arguments
     * @return RecordingInstance Newly created RecordingInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function create($options = array()) {
        $options = new Values($options);

        $data = Values::of(array(
            'RecordingStatusCallbackEvent' => Serialize::map($options['recordingStatusCallbackEvent'], function($e) { return $e; }),
            'RecordingStatusCallback' => $options['recordingStatusCallback'],
            'RecordingStatusCallbackMethod' => $options['recordingStatusCallbackMethod'],
            'Trim' => $options['trim'],
            'RecordingChannels' => $options['recordingChannels'],
        ));

        $payload = $this->version->create(
            'POST',
            $this->uri,
            array(),
            $data
        );

        return new RecordingInstance(
            $this->version,
            $payload,
            $this->solution['accountSid'],
            $this->solution['callSid']
        );
    }

    /**
     * Streams RecordingInstance records from the API as a generator stream.
     * This operation lazily loads records as efficiently as possible until the
     * limit
     * is reached.
     * The results are returned as a generator, so this operation is memory
     * efficient.
     * 
     * @param array|Options $options Optional Arguments
     * @param int $limit Upper limit for the number of records to return. stream()
     *                   guarantees to never return more than limit.  Default is no
     *                   limit
     * @param mixed $pageSize Number of records to fetch per request, when not set
     *                        will use the default value of 50 records.  If no
     *                        page_size is defined but a limit is defined, stream()
     *                        will attempt to read the limit with the most
     *                        efficient page size, i.e. min(limit, 1000)
     * @return \Twilio\Stream stream of results
     */
    public function stream($options = array(), $limit = null, $pageSize = null) {
        $limits = $this->version->readLimits($limit, $pageSize);

        $page = $this->page($options, $limits['pageSize']);

        return $this->version->stream($page, $limits['limit'], $limits['pageLimit']);
    }

    /**
     * Reads RecordingInstance records from the API as a list.
     * Unlike stream(), this operation is eager and will load `limit` records into
     * memory before returning.
     * 
     * @param array|Options $options Optional Arguments
     * @param int $limit Upper limit for the number of records to return. read()
     *                   guarantees to never return more than limit.  Default is no
     *                   limit
     * @param mixed $pageSize Number of records to fetch per request, when not set
     *                        will use the default value of 50 records.  If no
     *                        page_size is defined but a limit is defined, read()
     *                        will attempt to read the limit with the most
     *                        efficient page size, i.e. min(limit, 1000)
     * @return RecordingInstance[] Array of results
     */
    public function read($options = array(), $limit = null, $pageSize = null) {
        return iterator_to_array($this->stream($options, $limit, $pageSize), false);
    }

    /**
     * Retrieve a single page of RecordingInstance records from the API.
     * Request is executed immediately
     * 
     * @param array|Options $options Optional Arguments
     * @param mixed $pageSize Number of records to return, defaults to 50
     * @param string $pageToken PageToken provided by the API
     * @param mixed $pageNumber Page Number, this value is simply for client state
     * @return \Twilio\Page Page of RecordingInstance
     */
    public function page($options = array(), $pageSize = Values::NONE, $pageToken = Values::NONE, $pageNumber = Values::NONE) {
        $options = new Values($options);
        $params = Values::of(array(
            'DateCreated<' => Serialize::iso8601Date($options['dateCreatedBefore']),
            'DateCreated' => Serialize::iso8601Date($options['dateCreated']),
            'DateCreated>' => Serialize::iso8601Date($options['dateCreatedAfter']),
            'PageToken' => $pageToken,
            'Page' => $pageNumber,
            'PageSize' => $pageSize,
        ));

        $response = $this->version->page(
            'GET',
            $this->uri,
            $params
        );

        return new RecordingPage($this->version, $response, $this->solution);
    }

    /**
     * Retrieve a specific page of RecordingInstance records from the API.
     * Request is executed immediately
     * 
     * @param string $targetUrl API-generated URL for the requested results page
     * @return \Twilio\Page Page of RecordingInstance
     */
    public function getPage($targetUrl) {
        $response = $this->version->getDomain()->getClient()->request(
            'GET',
            $targetUrl
        );

        return new RecordingPage($this->version, $response, $this->solution);
    }

    /**
     * Constructs a RecordingContext
     * 
     * @param string $sid The unique string that identifies the resource
     * @return \Twilio\Rest\Api\V2010\Account\Call\RecordingContext 
     */
    public function getContext($sid) {
        return new RecordingContext(
            $this->version,
            $this->solution['accountSid'],
            $this->solution['callSid'],
            $sid
        );
    }

    /**
     * Provide a friendly representation
     * 
     * @return string Machine friendly representation
     */
    public function __toString() {
        return '[Twilio.Api.V2010.RecordingList]';
    }
}