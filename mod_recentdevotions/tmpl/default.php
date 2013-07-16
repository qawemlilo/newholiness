<?php 
defined('_JEXEC') or die('Restricted access'); // no direct access 

function listDevotios($_devotions) {

    $lists = '';
    
    if (is_array($_devotions) && count($_devotions) > 0) {
        foreach($_devotions as $devotion) {
            $li = '<li>';
            $li .= '<a href="index.php?option=com_devotions&view=devotion&Itemid=6&dId=' . $devotion->id . '">';
            $li .= $devotion->theme;
            $li .= '</a></li>';
            
            $lists .= $li;
        }
        
        echo $lists;
    }    
}

?>

<ul class="mod_devotions">
<?php 
    listDevotios($devotions);       
?>  
</ul>
