<?php
namespace services\FavPet;

use Registry;
use OwnedAdoptable;
use StockItem;

/**
 * Class FavPet
 * @package services\FavPet
 */
class FavPet
{
    /**
     * The output of this class.
     * @var message
     */
    public $message;
    /**
     * The framework link
     * @var Object mysidia
     */
    private $mysidia;
    /**
     * The config, language, item lists, etc.
     * @var array config
     */
    private $config;
    /**
     * The odds/chances of effects happening.
     * An "options" list.
     * @var array opts
     */
    private $opts;
    /**
     * Internal variable for setting
     * item's average chance of being selected
     * @var average
     */
    private $average;
    /**
     * Internal framework link
     * @var OwnedAdoptable pet
     */
    protected $pet;
    /**
     * The item selected to give the user,
     * if one is found
     * @var item
     */
    protected $item;
    /**
     * The amount of cash to give the user,
     * if money is found
     * @var money
     */
    protected $money;

    /**
     * FavPet constructor.
     */
    public function __construct()
    {
        $mysidia = Registry::get("mysidia");
        $this->mysidia = $mysidia;
        $profile = $mysidia->user->getprofile();
        if ($profile == false) return;

        $basicConfig = include 'config/config.php';

        if ((int)$profile->getFavpetID() == 0) {
            $this->message = $basicConfig['No Pet'];
            $this->display();
            return;
        }

        $this->pet = new OwnedAdoptable($profile->getFavpetID());

        $defaultConfig = include 'config/default.php';
        $this->config = array_merge($basicConfig, ['default' => $defaultConfig]);

        // Only allow adults (level 2+) to find stuff/talk.
        if ($this->pet->getCurrentLevel() < 2) {
            $this->display();
            return;
        }

        $species = $this->getSpecies('chances');
        $this->opts = $this->config['default']['chances'];
        if ($species != 'default') {
            $this->opts = array_merge($this->config['default']['chances'], $this->config[$species]['chances']);
        }
        $this->action();
        return;
    }

    /**
     * Try to preform an action ie talk or find gift
     * Updates $this->message if successful.
     * @calls giveGift();
     * @return null|void
     */
    public function action()
    {
        if (mt_rand(0, 100) > $this->opts['effect_chance']) return null;

        if (mt_rand(0, 100) <= $this->opts['gift_chance']) return $this->giveGift();

        $species = $this->getSpecies();

        $messages = $this->getAdditional($this->config[$species], 'sayings');

        $this->message = $messages[mt_rand(0, count($messages) - 1)];
        return null;
    }

    /**
     * Attempts to give money or a species specific gift to the player.
     * Updates $this->message
     * @return null|void
     */
    public function giveGift()
    {
        // Give Money
        if (mt_rand(0, 100) >= $this->opts['item_chance']) {
            $m = $this->opts['money_amounts'];
            $this->money = mt_rand($m['min'], $m['max']);
            $this->message = $this->config[$this->getSpecies('found money')]['found money'];
            $this->mysidia->user->changecash($this->money);
            return null;
        }

        // Give Item
        $species = $this->getSpecies('items');

        $items = $this->getAdditional($this->config[$species], 'items');
        //$itemKey = array_rand($items);

        $itemKey = $this->pick($items);
        $this->item = $items[$itemKey];
        $this->message = $this->config[$this->getSpecies('found item')]['found item'];

        // Check if item has unique message text.
        if (!is_numeric($itemKey)) {
            $this->item = $itemKey;
            if (!is_array($items[$itemKey]))
            {
                $this->message = $items[$itemKey];
            }
            elseif (isset($items[$itemKey][0])) {
                $this->message = $items[$itemKey][0];
            }
        }

        $newitem = new StockItem($this->item);
        $newitem->append(1, $this->mysidia->user->username);
        // Tack on image of item found.
        $this->message .= "<br><img src='{$newitem->imageurl}'>";
        return null;
    }
    
    /**
     * Sets additional array values if the array key 'combine' exists for the $type
     * @calls setConfig() to set config from file to local array
     * @param array $array
     * @param string $type
     * @return array
     */
    public function getAdditional(array $array, $type = 'sayings')
    {
        $messages = $array[$type];
        if (!isset($array['combine'][$type])) return $messages;

        $species = $array['combine'][$type];
        if (!is_array($species)) {
            $this->setConfig($species);
            if (isset($this->config[$species][$type])) {
                return array_merge($array[$type], $this->config[$species][$type]);
            }
            $array['combine'][$type] = 'default';
            return $this->getAdditional($array, $type);
        }

        foreach ($species as $key) {
            $array['combine'][$type] = $key;
            $messages = array_merge($messages, $this->getAdditional($array, $type));
        }

        return $messages;
    }

    /**
     * Format the message, replacing variables with their values.
     * @return string|void
     */
    private function formatMessage()
    {
        if ($this->message == null) return null;
        return strtr("<div class='{$this->config['speech class']}'>" . $this->message . '<br></div>', [':item' => $this->item, ':amount' => $this->money, ':currency' => $this->mysidia->settings->cost]);
    }

    /**
     * Set the config, calling the file into a local array and updating $this->config
     * @param $name
     * @return null
     */
    private function setConfig($name)
    {
        if (!isset($this->config[$name]) && file_exists(__DIR__ . "/config/$name.php")) {
            $this->config = array_merge($this->config, [$name => include("config/$name.php")]);
            return null;
        }
        return null;
    }

    /**
     * Generate an array based on odds/weight to pick a random key from.
     *
     * @param array $items
     * @param string $arrayKey
     * @return string
     */
    private function pick(array $items, $arrayKey = 'odds')
    {
        $numbers = [];
        foreach ($items as $key=>$item)
        {
            $odds = 1;
            if (isset($item[$arrayKey]) AND $item[$arrayKey]>0) $odds = $item[$arrayKey];
            for($i=0;$i<$odds;$i++){
                $numbers[] = $key;
            }
        }

        return $numbers[array_rand($numbers)];
    }

    /**
     * Display the fav pet and message, if any.
     * @return string
     */
    public function display()
    {
        $message = '<div>';
        if ($this->config['div class'] != null) {
            $message = "<div class='{$this->config['div class']}'>";
        }

        if ($this->pet != null) {
            return "$message{$this->config['Pet Header']}
				{$this->formatMessage()}
				<a href='/pet/profile/{$this->mysidia->user->getprofile()->getFavpetID()}'><img src='{$this->pet->getImage()}'></a>
				</div>";
        }
        return $message . $this->message . '</div>';
    }

    /**
     * Return the key/filename for the pet's config
     * Checks first the type, then the class, otherwise returns default
     * @calls setConfig() to set the config from file to local array
     * @param string $config
     * @return string
     */
    public function getSpecies($config = 'sayings')
    {
        $type = trim($this->pet->type);
        $class = trim($this->pet->class);

        $this->setConfig($type);
        if (isset($this->config[$type][$config])) return $type;
        $this->setConfig($class);
        if (isset($this->config[$class][$config])) return $class;
        return 'default';
    }
}