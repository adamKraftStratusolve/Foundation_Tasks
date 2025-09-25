<?php
class ItemOwners {
    static function groupByOwners($itemsArr) {

        $ownersMatrix = [];

        foreach ($itemsArr as $item => $owner) {
            $ownersMatrix[$owner][] = $item;
        }

        return $ownersMatrix;
    }
}

$itemsArr = array(
    "Baseball Bat" => "John",
    "Golf ball" => "Stan",
    "Tennis Racket" => "John"
);

echo json_encode(ItemOwners::groupByOwners($itemsArr));