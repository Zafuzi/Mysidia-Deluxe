<?php
namespace services\Image;

use Intervention\Image\ImageManager;
use Intervention\Image\Filters\FilterInterface;

class ApplyParts implements FilterInterface {
    public $errors;
    /**
     * @var
     */
    private $type;
    /**
     * @var
     */
    private $red;
    /**
     * @var
     */
    private $green;
    /**
     * @var
     */
    private $blue;
    /**
     * @var
     */
    private $imageManager;
    /**
     * @var int
     */
    private $variation;
    /**
     * @var
     */
    private $species;
    /**
     * @var array
     */
    private $extraColors;

    /**
     * ApplyEars constructor.
     * @param ImageManager $imageManager
     * @param $red
     * @param $green
     * @param $blue
     * @param $species
     * @param $type
     * @param int $variation
     * @param array $extraColors
     */
    public function __construct(ImageManager $imageManager, $red, $green, $blue, $species, $type, $variation = 1, $extraColors = []){
        $this->imageManager = $imageManager;
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
        $this->species = $species;
        $this->type = $type;
        $this->variation = $variation;
        $this->extraColors = $extraColors;
    }

    public function applyFilter(\Intervention\Image\Image $original_image){
        $manager = $this->imageManager;
        $red = $this->red;
        $blue = $this->blue;
        $green = $this->green;

        $file = $_SERVER['DOCUMENT_ROOT'].'/picuploads/breeding/'.$this->type.'/'.$this->species.'-'.$this->variation.'.png';
        $file2 = $_SERVER['DOCUMENT_ROOT'].'/picuploads/breeding/'.$this->type.'/'.$this->species.'-a'.$this->variation.'.png';
        $file3 = $_SERVER['DOCUMENT_ROOT'].'/picuploads/breeding/'.$this->type.'/'.$this->species.'-lines-'.$this->variation.'.png';
        $file4 = $_SERVER['DOCUMENT_ROOT'].'/picuploads/breeding/'.$this->type.'/markings/'.$this->species.'-'.$this->variation.'.png';

        if (!file_exists($file)) {
            $this->errors = "No image file for {$this->type} of variation {$this->variation}.";
            ddd($file);
            return false;
        }
        $image = $manager->make($file);
        $image->colorize($this->red,$this->green,$this->blue);

        if (file_exists($file2))
        {
            $image2 = $manager->make($file2);
            if ($this->type == 'ears')
            {
                if ($blue > 75 && $red < $blue) $red = $blue;
                if ($red > 75) $red = round($red-($red/3));
                if ($red <= 0) {$red = 1;$blue=1;}
                if ($red > 100) {$red = 100;$blue=100;}
                if ($green > $red) {
                    $green = $red;
                    $red = $this->green;
                }
                $green = round($this->green/2);
                if ($green <= 0) $green = 1;

                $image2->colorize($red,$green,$blue);
                $image->insert($image2);
            }
        }

        if (file_exists($file4))
        {
            $markings = $manager->make($file4);
            if (!empty($this->extraColors))
            {
                $c = $this->extraColors;
                $markings->colorize($c[0],$c[1],$c[2]);
                $image->insert($markings);
            }
        }

        if(file_exists($file3))
        {
            $lines = $manager->make($file3);
            $image->insert($lines);
        }

        return $original_image->insert($image);
    }
}