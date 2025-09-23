<?php
class ItemOwners {
    static function groupByOwners($itemsArr) {

        $owners = [];

        foreach ($itemsArr as $item => $owner) {
            $owners[$owner][] = $item;
        }

        return $owners;
    }
}

$itemsArr = array(
    "Baseball Bat" => "John",
    "Golf ball" => "Stan",
    "Tennis Racket" => "John"
);

echo json_encode(ItemOwners::groupByOwners($itemsArr));