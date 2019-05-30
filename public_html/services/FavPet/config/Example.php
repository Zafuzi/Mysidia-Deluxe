<?php
/**
 * This is an example config file.
 * All these settings are optional.
 * Delete unused settings so the default will be used instead.
 * Otherwise an empty sayings array (for example) results in a mute pet.
 */
return [
    /**
     * These are the odds of the pet finding anything or talking
     */
    'chances' => [
        // The chance of anything happening, 100 is always 0 is never
        'effect_chance' => 25,
        // The chance of an item or money being found when something happens
        'gift_chance' => 5,
        // Chance of the found gift being an item, otherwise it's money
        'item_chance' => 50,
        // If money is found, randomize an amount to give. Make these negative if you want the pet to steal money from the player.
        'money_amounts' => ['min'=>100, 'max'=>1000],
    ],

    // If you want this pet type/class to say a specific phrase
    // Use :item and :money to insert the item found and money amount
    // Use :currency to get the name of the site's currency from the site's settings
    'found money' => '',
    'found item' => '',

    /**
     * Random meaningless phrases you'd like the pet to say.
     */
    'sayings' => [
        ''
    ],

    /**
     * Items you'd like the pet to find.
     * You can set a unique phrase that will be said for each item using an array:
     * 'flowers' => 'I picked these just for you!',
     *
     * To set a rarity
     * add an 'odds' to the array.
     * eg: 'items' => [
     *       'Grass' => ['odds'=>10, 'Some common grass I just picked up for you!'],
     *       'Gem'   => ['odds'=>1, 'An uncommon gemstone!'],
     *   ]
     * Items with no odd set have an 'odds' of 1.
     * Meaning they have 1 chance to be selected from the array.
     * Setting higher odds adds more chances of the item being selected.
     * So if you want a rare item, set other more common items to have higher odds.
     */
    'items' => [
        ''
    ],

    /**
     * This array allows you to combine the sayings or items from another config file
     * So if for example you have a set of Dragon pets and want them all to find shed scales
     * then you can create a DragonDrops.php config file (as if "DragonDrops" was a pet)
     * and have this file's array combined with it here:
     * 'combine'=>['items'=>'DragonDrops'],
     * You can combine as many files as you want by using an array:
     * 'combine'=>['items'=>['DragonDrops', 'default']],
     *
     * If the file doesn't exist, or the file doesn't have the array key set the default config will be used.
     */
    'combine' => [
        'sayings' => null,
        'items' => null,
    ]
];

/**
 * Remember that this is a php file. You can do whatever you want.
 */

$configArray = ['sayings' => 'I would kick down the sun for a star valley night.'];

if (time() > strtotime('8PM')) {
    $configArray['sayings'][] = 'Nighttime is the best time.';
    $configArray['items']['Stardust'] = 'Starlight, star-shine. No longer do you shine so bright.';
}

return $configArray;


/**
 * Another example using the rest of the Mysidia framework to dynamically determine the config array.
 */

namespace services\FavPet\config;

use Registry;
use OwnedAdoptable;

$mysidia = Registry::get('mysidia');
$profile = $mysidia->user->getprofile();
$pet = new OwnedAdoptable($profile->getFavpetID());

if ((int)$pet->getCurrentLevel() > 2) {
    return ['sayings' => ['I\'m no baby!', 'Nostalgic nights have got me feelin\' its all gone to rust.']];
}
/**
 * Note: if you wanted to do something like this for ALL your pets, put it in another file and include it.
 * Or edit the FavPet class (getSpecies method) to take into account the current level (or whatever) when selecting config files.
 * Don't Repeat Yourself (too much).
 */