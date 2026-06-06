<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('send_wa')) {
    /**
     * Helper to send WhatsApp messages using Fonnte API
     *
     * @param string $target WhatsApp target number (e.g., 0812xxxxxxxx or 62812xxxxxxxx)
     * @param string $message The message content
     * @return array Array with 'status' (boolean) and 'message' (string/error reason)
     */
    function send_wa($target, $message)
    {
        if (!defined('FONNTE_TOKEN') || empty($target) || empty($message)) {
            return [
                'status' => false,
                'message' => 'Token Fonnte tidak terdefinisi atau parameter target/pesan kosong.'
            ];
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $target,
                'message' => $message,
                'countryCode' => '62',
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . FONNTE_TOKEN
            ),
        ));

        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if ($error) {
            return [
                'status' => false,
                'message' => 'cURL Error: ' . $error
            ];
        }

        $res = json_decode($response, true);
        if (isset($res['status']) && $res['status'] == true) {
            return [
                'status' => true,
                'message' => 'WhatsApp berhasil dikirim.'
            ];
        } else {
            $reason = isset($res['reason']) ? $res['reason'] : 'Gagal mengirim (Alasan tidak diketahui)';
            return [
                'status' => false,
                'message' => $reason
            ];
        }
    }
}
