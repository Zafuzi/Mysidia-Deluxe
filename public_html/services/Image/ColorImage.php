<?php
/*
 * TODO rewrite this file so it's cleaner.
 */
namespace services\Image;

use Resource\Native\Object;

class ColorImage extends Object {
    // The chances of randomly generated pets getting the gene.
    // Higher = rarer.
    private $chances = ['markings'=>5,'extras'=>5,'mane'=>5,'no_feesh_mane'=>10,'innerEarsNotPink'=>2];
    private $errorMsgs = [
    'species' => 'This species does not exist.',
    'colors' =>
    ['not_numeric'=>'Colors must be a number.',
    'species' => 'You have to include the species being colorized.',
    'base'=>'Base color must be set.',
    'eyes' => 'Eye color must be set.']
    ];
    private $filestore = "/picuploads/breeding/";
    private $savepath = '/picuploads/pets';
    private $partsOrder = ['egg','cracked egg','bodies','noses','markings','scars','tails','manes','eyes','outfits','ears','antennae','extras','fins'];
    // Antennae behind because of skulls
    public $species;
    public $owner = 'Ittermat';
    public $gender;
    public $age = 2;
    private $lines = [];
    private $config;
    public $genetics = [];
    public $image;
    public $errors;
    public $colors;
    private $bodyLines = null;
    private $showTails = true;
    private $showEars = true;

    public function __construct()
    {
        $speciesArray = ['Catari','Hounda','Feesh'];
        $this->setSpecies($speciesArray[array_rand($speciesArray)]);
        $genders = ['m','f'];
        $this->gender = $genders[array_rand($genders)];
    }

    public function setGender($gender) {
        $this->gender = $gender;
        $this->genetics['gender'] = $gender;
    }

    public function setSpecies($species) {
        $this->species = $species;
        $this->filestore = $_SERVER['DOCUMENT_ROOT'].'/picuploads/breeding/'.$species.'/';
        $this->genetics['species'] = $species;
    }

    public function setOwner($owner) {
        $this->owner = $owner;
    }

    public function random($config = null) {
        if ($config == null) {
            $config = $this->generateConfig();
        }
        
        // A chance for the ears to not be pink inside
        if (mt_rand(0,$this->chances['innerEarsNotPink']) == 0) { $colors[0] = $this->randomColor(rand(0,1));
        }else{ $colors[0] = $this->randomShade('pink',rand(0,1));}
        if (mt_rand(0,$this->chances['innerEarsNotPink']) == 0) { $colors[1] = $this->randomColor(rand(0,1));
        }else{ $colors[1] = $this->randomShade('pink',rand(0,1));}
        
        for($i=2;$i<35;$i++) {
            $colors[$i] = $this->randomColor(rand(0,1));
        }

        $genetics = [];
        $overrides = [];
        foreach ($config as $part=>$values) {
            if ($part == 'markings') {
                for($i=0;$i<3;$i++){
                    // Set the mt_rand value higher for rarer
                    if (mt_rand(0,$this->chances['markings']) != 0){
                        continue;
                    }
                    $genetics[$part][$i] = $this->setGenetics($values);
                    // Determine if any existing marking's extras like tail/ears will override other genetic parts
                    $overrides = getOverride($this->filestore, $genetics[$part][$i], $overrides);
                }
                continue;
            }
            if ($part == 'extras') {
                for($i=0;$i<3;$i++){
                    if (mt_rand(0,$this->chances['extras']) == 0){
                        $genetics[$part][] = $this->setGenetics($values);
                    }
                }
                continue;
            }
            // Chance for a mane (basically if Hounda or Feesh, Catari manes are in extras)
            if ($part == 'manes') {
                if ($this->species == 'Feesh') {
                     if (mt_rand(0,$this->chances['no_feesh_mane']) == 0) {continue;}
                 $genetics['manes'] = $this->setGenetics($values);
                }
                if (mt_rand(0,$this->chances['mane'])==0 && $this->species != 'Feesh') {
                    $genetics['manes'] = $this->setGenetics($values);
                }
                continue;
            }
            // Chance for other extra bits
            if ($part == 'scars' OR $part == 'outfits') {
                if (mt_rand(0,$this->chances['extras'])==0) {
                    $genetics[$part] = $this->setGenetics($values);
                }
                continue;
            }
            $genetics[$part] = $this->setGenetics($values);
        }
        $genes = ['species'=>$this->species,'colors'=>$colors, 'genes'=>$genetics, 'overrides'=>$overrides];
        $this->genetics = $genes;
        return $this->create($genes);
    }

    private function setGenetics($values){
        if (isset($values['recessive'])) {
            // Set the mt_rand values higher for rarer
            if (mt_rand(0,1) == 0) {
                if (mt_rand(0,1) == 0) {
                        // Recessive Trait Get
                    $genetics['recessive'][] = array_rand($values['recessive']);
                    $genetics['recessive'][] = array_rand($values['recessive']);
                    return $genetics;
                }

                    // Domininat Carrying Recessive Trait
                $genetics['dominant'][] = array_rand($values['dominant']);
                $genetics['recessive'][] = array_rand($values['recessive']);
                return $genetics;
            }
        }

        // Dominant Trait Get
        $genetics['dominant'][] = array_rand($values['dominant']);
        $genetics['dominant'][] = array_rand($values['dominant']);
        return $genetics;
    }

    public function generateConfig(){
        $config = [];
        $filestore = $this->filestore;
        foreach ($this->partsOrder as $order) {
            if (file_exists($filestore.$order.'/') === false) {continue;}
            $config[$order] = dirToArray($filestore.$order.'/');
        }
        $this->config = $config;
        return $config;
    }

    public function create($colors,$age=null) {
        if ($age == null) {$age = $this->age;}
        $this->genetics = array_merge($this->genetics,$colors);
        $this->species = $this->genetics['species'];
        $config = $this->config;
        $partsOrder = $this->partsOrder;
        $filestore = $this->filestore;
        $baseColor = $colors['colors'][3];
        $this->baseColor = $baseColor;
        $this->colorIterator = 4;
        $this->earsIterator = 0;
        $filesArray = [];
        if ($age == 0) {
            $this->colorIterator = 6;
            $this->ApplyPart('egg', $colors['genes']['egg'], $colors);
            $this->watermark();
            $this->addName($this->owner);
            return;
        }
        if ($age == 1) {
            $this->colorIterator = 6;
            $this->ApplyPart('cracked egg', $colors['genes']['cracked egg'], $colors);
            $this->watermark();
            $this->addName($this->owner);
            return;
        }
        unset($colors['genes']['egg']);
        unset($colors['genes']['cracked egg']);

        foreach ($partsOrder as $part){ 
            if (!isset($colors['genes'][$part])) continue;
            $genes = $colors['genes'][$part];
        
            $lines = false;
        //    if ($part == 'antennae') {continue;}
            if ($part == 'markings'){
                foreach ($genes as $gene) {
                    $this->ApplyPart($part,$gene,$colors);
                }
                continue;
            }
            if ($part == 'extras'){continue;}
            $this->ApplyPart($part, $genes,$colors);
        }

        if (isset($this->addOnLast)) {
            $previous = $this->colorIterator;
            foreach ($this->addOnLast as $addOn) {
                foreach ($addOn as $key=>$array){
                    $this->colorIterator = $array['colorIterator'];
                    $var = 'show'.ucfirst($key);
                    $this->$var = true;
                    $this->ApplyPart($key, $array['genes'], $colors, $array['path']);
                    $this->$var = false;
                }
            }
            $this->colorIterator = $previous;
        }

        /*
        if (isset($colors['genes']['antennae'])){
            $this->ApplyPart('antennae', $colors['genes']['antennae'], $colors);
        }
        */

        if(isset($colors['genes']['extras'])){
            foreach($colors['genes']['extras'] as $genes){
                $this->ApplyPart('extras', $genes, $colors);
            }
        }


        $this->addGenderIcon($this->gender);
        $this->watermark();
        $this->addName($this->owner);
        return;
    }

    private function ApplyPart($part, $genes, $colors, $path = null){
        // Only males can show manes.
        if ($this->gender != 'm' && $part == 'manes' && $this->species != 'Feesh') {return;}
        // Correction for maned Houndas with curled tails.
        if ($part == 'manes' AND $this->species == 'Hounda') {
            $tails = $colors['genes']['tails'];
            if (isset($tails['dominant'])) {
                if ($tails['dominant'][0] == 1) {return;}
            }
            if (isset($tails['recessive'][0]) AND isset($tails['recessive'][1])) {
                if ($tails['recessive'][0] == 2 OR $tails['recessive'][0] == '2-1') {return;}
            }
        }
        if ($this->showTails == false && $part == 'tails') {return;}
        if ($this->showEars == false && $part == 'ears') {return;}
        $i = $this->colorIterator;
        $ears = $this->earsIterator;
        $bodyImg = false;
        if ($this->image != null){
            $bodyImg = $this->image;
        }
        $lines = false;
        $baseColor = $this->baseColor;
        if ($path == null){
            $genefolder = 'recessive';
            if (isset($genes['dominant'])) {
                $genefolder = 'dominant';
                // If pet only has one recessive gene and one non-existant gene (from breeding) don't show this optional part.
            }elseif (count($genes['recessive']) == 1){return;}
            $foldername = $genes[$genefolder][0];
            $path = $this->filestore.$part.DIRECTORY_SEPARATOR.$genefolder.DIRECTORY_SEPARATOR.$foldername.DIRECTORY_SEPARATOR;
        }
        $files = dirToArray($path);
        foreach ($files as $key => $file) {
            // Marking that has matching tail/etc
            if (is_array($file)) {
                $var = 'show'.ucfirst($key);
                // Overwrite tail with matching tail?
                if (($this->$var == true) AND (isset($colors['overrides'][$genefolder][$foldername][$key]))) {
                    $addOnLast = [];
                    $count = 1;
                    foreach($files as $test) {
                        if (is_array($test)){
                            $count++;
                        }
                    }
                    $addOnLast[$key]['colorIterator'] = $i - (count($files)-$count);
                    $addOnLast[$key]['part'] = $part;
                    $addOnLast[$key]['genes'] = $genes;
                    $addOnLast[$key]['path'] = $path.$key.DIRECTORY_SEPARATOR;
                    $this->addOnLast[] = $addOnLast;
                    $this->$var = false;
                }
                continue;
            }
            // Limit manes to males only
            if (strpos($file, 'mane') !== false AND $this->species != 'Feesh' AND $this->gender != 'm'){
                continue;
            }
            if (strpos($file,'lines')!== false){
                $lines = $path.$file;
                continue;
            }

            $image = imagecreatefrompng($path.$file);
            imagesavealpha($image, true);

            if (strpos($file,'base')!== false) {
                imagefilter($image, IMG_FILTER_COLORIZE, $baseColor[0], $baseColor[1], $baseColor[2]);
            }else{
                if ($part == 'ears' AND (strpos($file,'inner') !== false)) {
                    imagefilter($image, IMG_FILTER_COLORIZE, $colors['colors'][$ears][0], $colors['colors'][$ears][1], $colors['colors'][$ears][2]);
                    $ears++;
                    $this->earsIterator = $ears;
                }else{
                    imagefilter($image, IMG_FILTER_COLORIZE, $colors['colors'][$i][0], $colors['colors'][$i][1], $colors['colors'][$i][2]);
                    $i++;
                    $this->colorIterator=$i;
                }
            }
            if ($bodyImg !== false){
                $w = imagesx($image);
                $h = imagesy($image);
                imagecopy($bodyImg, $image, 0, 0, 0, 0, $w, $h);
                imagedestroy($image);
            }else{
                $bodyImg = $image;
            }
            $this->image = $bodyImg;
        }

        if ($lines) {
            if ($part == 'bodies') {
                $this->bodyLines = $lines;
                return;
            }
            $this->ApplyLines($lines);
        }

        // Apply body lines after markings, and nose.
        if ($part == 'markings' OR $part == 'noses' OR ($part == 'eyes' AND $this->species == 'Feesh')) {
            if ($this->bodyLines != null){
                $this->ApplyLines($this->bodyLines);
            }
        }

        $this->image = $bodyImg;
        return;
    }

    function watermark(){
        $watermark = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'picuploads/watermark.png');
        imagesavealpha($watermark, true);
        $w = imagesx($watermark);
        $h = imagesy($watermark);
        $bodyimage = $this->image;
        $iw = imagesx($bodyimage);
        $ih = imagesy($bodyimage);
        imagecopy($bodyimage, $watermark, $iw-$w,$ih-$h,0,0,$w,$h);
        imagedestroy($watermark);
    }

    function addName($name) {
        if ($name == null) return;
        else $name = $name.'\'s Pet';
        imagesavealpha($this->image, true);
        $white = imagecolorallocatealpha($this->image, 255, 0, 50, 120);
        imagesavealpha($this->image, true);
        imagefilledrectangle($this->image, 0, 185, 150, 200, $white);
        imagesavealpha($this->image, true);
        $black = imagecolorallocate($this->image, 0, 0, 0);
        imagettftext($this->image, 10, 0, 0, 195, $black, __DIR__.DIRECTORY_SEPARATOR.'HillbillyOpteamawDNA.ttf', $name);
    }

    function addGenderIcon($gender='m') {
        $image = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'picuploads'.DIRECTORY_SEPARATOR.$gender.'.png');
        
        imagesavealpha($image, true);
        if ($gender == 'm') {
            $color = [0,0,255];
        }else{
            $color = [255,0,0];
        }
        imagefilter($image, IMG_FILTER_COLORIZE, $color[0],$color[1],$color[2]);
        $w = imagesx($image);
        $h = imagesy($image);
        imagecopy($this->image, $image, 0,0,0,0,$w,$h);
        imagedestroy($image);
    }

    private function ApplyLines($lines) {
        $bodyImg = $this->image;
        $line = imagecreatefrompng($lines);
        imagesavealpha($line, true);
        $w = imagesx($line);
        $h = imagesy($line);
        imagecopy($bodyImg, $line, 0, 0, 1, 0, $w, $h);
        imagedestroy($line);
    }

    public function display($id = null){
        header('Content-Type: image/png');

        imagepng($this->image);
        imagedestroy($this->image);
    }

    public function save($file){
        imagepng($this->image, $file, 9);
    }

    public function base64(){
        ob_start();
        imagepng($this->image);
        $image_data = ob_get_contents();
        ob_end_clean();
        return 'data:image/png;base64,'.base64_encode($image_data);
    }

    /*
    * This is for when the image is alredy created.
    * But we need to add the owner etc like for siggy display.
    */
    public function setImage($file){
        $this->image = imagecreatefrompng($file);
        return $this;
    }


    private function randomColor($mt=false){
        return randomColor($mt);
    }

    private function randomShade($key,$mt=false){
        return randomShade($key,$mt);
    }


    /*
    Refactor to possibly do it this way?
    The idea being to look through the folders for parts (like have all the lines in one foloder, and colored parts in seperately named folder) so that way there's no config file needed and adding new parts is as simple as uploading the lines then the folder of colored parts. BUT this would be slower to process...
    Maybe use this to generate the config file on demand?
    Would still need custom coding if the inside of ears should always be pink etc.
    This also creates duplicate line images for the bicolored parts like the eyes and leg tufts.
    */
    private function getImages($type) {
        return glob($this->filestore.$type.'*.png');
    }
}