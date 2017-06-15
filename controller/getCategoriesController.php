<?php
$cat = new Instucom("master_sub_cat_rel");
$temp = $cat->get_model()->get_categories();
$categories = array();
$inner = array();
$outer = array();
$promotion = array();
for($i = 0; $i < sizeof($temp); $i++){
    if($temp[$i]['master_cat'] == 'inner'){
        $inner[] = $temp[$i]['sub_cat'];
    }
    else if($temp[$i]['master_cat'] == 'outer'){
        $outer[] = $temp[$i]['sub_cat'];
    }
    else if($temp[$i]['master_cat'] == 'promotion'){
        $promotion[] = $temp[$i]['sub_cat'];
    }
}
$categories['Campus'] = $inner;
$categories['Campus Externo'] = $outer;
$categories['Promoción'] = $promotion;

echo json_encode($categories);
// print_r($temp);



?>