<?php

namespace App\Helpers;

use App\Models\Menu;
use Hashids\Hashids;

class Main
{
    public static function getMenus()
    {
        return Menu::where('parent_id', null)->with('children.children')->orderBy('order_number', 'ASC')->get();
    }

    public static function hashIdsEncode($id)
    {
        $hashids = new Hashids('CharlieAlphaBravo', 20);
        return $hashids->encode($id);
    }
    public static function hashIdsDecode($data)
    {
        $hashids = new Hashids('CharlieAlphaBravo', 20);
        $decodedIds = $hashids->decode($data);
        $originalId = $decodedIds[0] ?? null;

        return $originalId;
    }

    public static function formatRupiah($number)
    {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
}
