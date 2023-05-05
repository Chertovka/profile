<?php

class Translation
{
    const DETECT_YA_URL = 'https://translate.yandex.net/api/v1.5/tr.json/detect';
    const TRANSLATE_YA_URL = 'https://translate.yandex.net/api/v1.5/tr.json/translate';
    public $key = "AIza1yCf2zgmk-nRxdbB4nRxdbB4nRxdbB4";

    public static function translate_text($format="text")
    {
        if (empty($this->key)) {
            throw new InvalidConfigException("Field <b>{$this->key}</b> is required");
        }

        $values = array(
            'key' => $this->key,
            'text' => $_GET['text'],
            'lang' => $_GET['lang'],
            'format' => $format == "text" ? 'plain' : $format,
        );

        $formatData = urlencode(http_build_query($values));

        $ch = curl_init(self::TRANSLATE_YA_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $formatData);

        $json = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($json, true);
        if($data['code']===200)
        {
            return $data['text'][0];
        }
        return $data;
    }
}