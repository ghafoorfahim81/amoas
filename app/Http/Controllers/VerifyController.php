<?php

namespace App\Http\Controllers;

// import fecades

use App\Booking;
use Illuminate\Support\Facades;

class VerifyController extends Controller
{
    public function verifyQrCode($hashSerialNo)
    {
        $isMd5Hash = preg_match('/^[a-f0-9]{32}$/', $hashSerialNo);

        if ($isMd5Hash) {
            // decrypt the hashSerialNo to get the original serial number
            return $this->getMd5Hash($hashSerialNo);
        } else {
            return "Invalid QR Code";
        }

        // try catch block
        try {
            // decrypt the hashSerialNo to get the original serial number
            $serialNo = \Crypt::decryptString($hashSerialNo);
            return $serialNo;

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    private function getMd5Hash($hashSerialNo)
    {
        // get the serial number from the hashSerialNo
        $hashListString = '{"CMUNI112496001":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22497001":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22497002":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22498001":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22498003":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22498004":"d41d8cd98f00b204e9800998ecf8427e","CMUNI12498005":"d41d8cd98f00b204e9800998ecf8427e","CMUNI112498006":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22498007":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22498008":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22498009":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22498010":"d41d8cd98f00b204e9800998ecf8427e","CMUNI42498012":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22498013":"d41d8cd98f00b204e9800998ecf8427e","CMUNI152499001":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22499002":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22499003":"d41d8cd98f00b204e9800998ecf8427e","CMUNI112499004":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22499005":"d41d8cd98f00b204e9800998ecf8427e","CMUNI112499006":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22499008":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22499009":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22499010":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22499011":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22499012":"d41d8cd98f00b204e9800998ecf8427e","CMUNI32499013":"d41d8cd98f00b204e9800998ecf8427e","CMUNI112499014":"d41d8cd98f00b204e9800998ecf8427e","CMUNI112499015":"d41d8cd98f00b204e9800998ecf8427e","CMUNI112499016":"d41d8cd98f00b204e9800998ecf8427e","CMUNI62499016":"d41d8cd98f00b204e9800998ecf8427e","CMUNI112499017":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22499018":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22499019":"d41d8cd98f00b204e9800998ecf8427e","CMUNI112499020":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22499021":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22499022":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22499023":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22499024":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22499025":"d41d8cd98f00b204e9800998ecf8427e","CMUNI132499026":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22499027":"d41d8cd98f00b204e9800998ecf8427e","CMUNI112499028":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22499029":"d41d8cd98f00b204e9800998ecf8427e","CMUNI22499030":"d41d8cd98f00b204e9800998ecf8427e","CMUNI52499031":"d41d8cd98f00b204e9800998ecf8427e","CMUNI1124910001":"d41d8cd98f00b204e9800998ecf8427e","CMUNI224910002":"d41d8cd98f00b204e9800998ecf8427e","CMUNI1124910003":"d41d8cd98f00b204e9800998ecf8427e","CMUNI1124910004":"d41d8cd98f00b204e9800998ecf8427e","CMUNI1124910005":"d41d8cd98f00b204e9800998ecf8427e","CMUNI224910006":"d41d8cd98f00b204e9800998ecf8427e","CMUNI1124910007":"d41d8cd98f00b204e9800998ecf8427e","CMUNI1124910008":"d41d8cd98f00b204e9800998ecf8427e","CMUNI224910009":"d41d8cd98f00b204e9800998ecf8427e","CMUNI224910010":"d41d8cd98f00b204e9800998ecf8427e","CMUNI224910011":"d41d8cd98f00b204e9800998ecf8427e","CMUNI324910012":"d41d8cd98f00b204e9800998ecf8427e"}';

        // convert the string to json to array
        $hashList = json_decode($hashListString, true);

        // get the hash key from the array
        $serialNo = array_search($hashSerialNo, $hashList);
        return $serialNo;
    }

    private function getMd5HashFromDB($serialNo)
    {
        // get the booking before created_at 2024-09-10 12:15:00
        $booking = Booking::whereBetween('created_at', ['2024-09-01 00:00:00', '2024-09-10 12:15:00'])
            ->get();

            // dd($booking);

        $hashList = [];

        foreach($booking as $book) {
            $hashSerialNo = md5($book->serialNo);
            
            // array of ['md5Hash' => 'serialNo']
            $hashList[$hashSerialNo] = $book->serialNo;
        }

        return $hashList;
    }
}
