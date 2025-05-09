<?php
namespace Twilio\Rest;

class Client {
    private $sid;
    private $token;

    public function __construct($sid, $token) {
        $this->sid = $sid;
        $this->token = $token;
    }

    public function messages() {
        return new class($this->sid, $this->token) {
            private $sid, $token;
            public function __construct($sid, $token) {
                $this->sid = $sid;
                $this->token = $token;
            }

            public function create($to, $data) {
                $url = "https://api.twilio.com/2010-04-01/Accounts/{$this->sid}/Messages.json";
                $post = http_build_query([
                    'To' => $to,
                    'From' => $data['from'],
                    'Body' => $data['body']
                ]);

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERPWD, "{$this->sid}:{$this->token}");
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                $response = curl_exec($ch);
                if(curl_errno($ch)) {
                    throw new \Exception(curl_error($ch));
                }
                curl_close($ch);
                return json_decode($response);
            }
        };
    }
}
