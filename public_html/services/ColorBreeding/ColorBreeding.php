<?php

namespace services\ColorBreeding;

use Resource\Native\Object;

class ColorBreeding extends Object {

    private $config = [

    ];
    /**
     * @array of parents
     */
    private $parents;

    private $ci=0;

    /**
     * @param array $parents
     */
    function breed(array $parents, $colorMerge = 'straightColorMerge') {
    	$this->parents = $parents;
        $sire = $parents['sire'];
        $dam = $parents['dam'];

        // Color merging
        $child = [];
        foreach($sire['colors'] as $key=>$scolors) {
        	if (!isset($dam['colors'])) $dam['colors'] = randomColor();
            $child['colors'][$key] = $this->$colorMerge($scolors, $dam['colors'][$key]);
        }

        $child = $this->sortG($dam['genes'], $sire['genes'], $child);
        $child = $this->sortG($sire['genes'], $dam['genes'], $child);

        return $child;
    }

    private function sortG($genes, $otherParentGenes, $child){
    	foreach ($genes as $key=>$gene) {
    		$overrides = [];
    		if ($key=='markings' or $key=='extras') {
    			if (!isset($otherParentGenes[$key])) $otherParentGenes[$key] = [];
    			foreach ($gene as $i=>$g){
    				$result = $this->getGene($g);
    				$child['genes'][$key][$i] = $result;
        		
        			if ($key == 'markings'){
        				$overrides = getOverride($_SERVER['DOCUMENT_ROOT'].'/picuploads/breeding/'.$this->parents['sire']['species'].'/', $result, $overrides);
    					$child['overrides'] = $overrides;
        			}
    			}

    			continue;   			
    		}

        	$dadGene = $this->getGene($gene);
        	if (!isset($otherParentGenes[$key])) {
        		$child['genes'][$key][key($dadGene)] = [$dadGene[key($dadGene)][0]];
        		continue;
        	}
        	$momGene = $this->getGene($otherParentGenes[$key]);

            if (key($dadGene) == key($momGene)) {
                $child['genes'][$key][key($dadGene)] = [$dadGene[key($dadGene)][0],$momGene[key($dadGene)][0]];
                continue;
            }
        	$child['genes'][$key][key($dadGene)] = $dadGene[key($dadGene)];
        	$child['genes'][$key][key($momGene)] = $momGene[key($momGene)];
        }
     //   sd($child, $genes, $otherParentGenes);
        return $child;
    }

    private function getGene($genes) {
    	$num = count($genes);
    	if ($num == 1) {
    		// All dominant/recessive genes
    		if (isset($genes['recessive'])) {$strength='recessive';}
    		if (isset($genes['dominant'])) {$strength='dominant';}
    		return [$strength => [$genes[$strength][array_rand($genes[$strength])]]];
    	}
    	$strength = array_rand($genes);
    	return [$strength => [$genes[$strength][0]]];
    }

    private function straightColorMerge($color1, $color2) {
        $result = [];
        foreach ($color1 as $key=>$c) {
            $result[$key] = round(((int)$c + (int)$color2[$key])/2);
        }
        return $result;
    }

    private function colorMergePlusBlack($color1, $color2) {
    	$result = [];
    	foreach ($color1 as $key=>$c) {
            $result[$key] = round(((int)$c + (int)$color2[$key])/3);
        }
        return $result;
    }

    private function colorMergePlusWhite($color1, $color2) {
    	$result = [];
    	foreach ($color1 as $key=>$c) {
            $result[$key] = round(((int)$c + (int)$color2[$key] + 255)/3);
        }
        return $result;
    }

    private function colorBrighten($color1, $color2) {
    	$result = [];
    	foreach ($color1 as $key=>$c) {
            $result[$key] = round(((int)$c + (int)$color2[$key])/2);
        }
        $saved = $result;
    	$keys = array_keys($result, max($result));
    	$thisKey = $keys[array_rand($keys)];
    	$result[$thisKey] = round(($result[$thisKey] + 255)/2);
    	if ($result[$thisKey] > 255) $result[$thisKey] = 255;
        return $result;
    }

    private function colorDarken($color1, $color2){
        $result = [];
        foreach ($color1 as $key=>$c) {
            $result[$key] = round(((int)$c + (int)$color2[$key])/2);
        }
        $saved = $result;
        $keys = array_keys($result, min($result));
        $thisKey = $keys[array_rand($keys)];
        $result[$thisKey] = round(($result[$thisKey])/2);
        if ($result[$thisKey] < 0) $result[$thisKey] = 0;
        return $result;
    }

    private function favorsPa($color1, $color2) {
    	$result = [];
        foreach ($color1 as $key=>$c) {
            $result[$key] = round((((int)$c * .75) + ((int)$color2[$key] *.25)));
        }
        return $result;
    }

    private function favorsMa($color1, $color2) {
    	$result = [];
        foreach ($color1 as $key=>$c) {
            $result[$key] = round((((int)$c * .25) + ((int)$color2[$key] *.75)));
        }
        return $result;
    }
}