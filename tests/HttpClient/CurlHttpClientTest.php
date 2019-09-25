<?php

namespace Ginger\HttpClient {
    function curl_init() {
        return new \stdClass;
    }

    function curl_setopt_array($curl, array $options) {
        $curl->options = $options;
    }

    function curl_exec($curl) {
        if ($curl->options[CURLOPT_URL] == 'https://www.example.com/empty/response') {
            // curl_exec returns true instead of empty string on an empty response
            // https://www.php.net/manual/en/function.curl-exec.php#70123
            return true;
        }

        return json_encode($curl->options);
    }

    function curl_errno($curl) {
        if ($curl->options[CURLOPT_URL] == 'https://www.example.com/error') {
            return CURLE_OUT_OF_MEMORY;
        }

        return CURLE_OK;
    }

    function curl_error($curl) {
        return 'A memory allocation request failed.';
    }

    function curl_close($curl) {
    }
}

namespace Ginger\Tests\HttpClient {

    use Ginger\HttpClient\CurlHttpClient;
    use Ginger\HttpClient\HttpException;

    final class CurlHttpClientTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var CurlHttpClient
         */
        private $client;

        public function setUp()
        {
            $this->client = new CurlHttpClient(
                'https://www.example.com',
                '1a1b2e63c55e'
            );
        }

        public function test_it_sends_a_request()
        {
            $response = $this->client->request(
                'POST',
                '/foo/bar',
                ['Content-Type' => 'text/plain'],
                'request data'
            );

            $this->assertEquals(
                [
                    CURLOPT_URL => 'https://www.example.com/foo/bar',
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => 'request data',
                    CURLOPT_HTTPHEADER => [
                        'Content-Length: 12',
                        'Content-Type: text/plain'
                    ],
                    CURLOPT_USERPWD => '1a1b2e63c55e:'
                ],
                json_decode($response, true)
            );
        }

        public function test_it_omits_the_content_length_header_when_no_request_data()
        {
            $response = $this->client->request(
                'GET',
                '/foo/bar'
            );

            $this->assertEquals(
                [
                    CURLOPT_URL => 'https://www.example.com/foo/bar',
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_USERPWD => '1a1b2e63c55e:'
                ],
                json_decode($response, true)
            );
        }

        public function test_it_sets_default_headers()
        {
            $client = new CurlHttpClient(
                'https://www.example.com',
                '1a1b2e63c55e',
                ['X-Custom-Header' => 'foobar']
            );

            $response = $client->request(
                'GET',
                '/foo/bar'
            );

            $this->assertEquals(
                [
                    CURLOPT_URL => 'https://www.example.com/foo/bar',
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_USERPWD => '1a1b2e63c55e:',
                    CURLOPT_HTTPHEADER => [
                        'X-Custom-Header: foobar'
                    ]
                ],
                json_decode($response, true)
            );
        }

        public function test_it_sets_custom_options()
        {
            $client = new CurlHttpClient(
                'https://www.example.com',
                '1a1b2e63c55e',
                [],
                [CURLOPT_CAINFO => '/my/cabundle.pem']
            );

            $response = $client->request(
                'GET',
                '/foo/bar'
            );

            $this->assertEquals(
                [
                    CURLOPT_URL => 'https://www.example.com/foo/bar',
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_USERPWD => '1a1b2e63c55e:',
                    CURLOPT_CAINFO => '/my/cabundle.pem'
                ],
                json_decode($response, true)
            );
        }

        public function test_it_returns_null_on_empty_response_body()
        {
            $response = $this->client->request(
                'POST',
                '/empty/response'
            );

            $this->assertNull($response);
        }

        public function test_it_throws_an_exception_on_curl_error()
        {
            $this->setExpectedException(
                HttpException::class,
                'cURL error: 27: A memory allocation request failed. (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for /error'
            );

            $this->client->request('GET', '/error');
        }
    }
}
