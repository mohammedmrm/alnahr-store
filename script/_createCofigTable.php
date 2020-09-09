<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);
require_once("_access.php");
access([1,2,3,4,5,6,10]);
require_once("dbconnection.php");
$ids = $_REQUEST['attributes'];
$configs = $_REQUEST['config'];
$data=[];
$rows =1;
function traverse( $array, $parent_ind ){
        $r = [];
        $pr = '';
        if( !is_numeric($parent_ind) )
            $pr = $parent_ind . '-';
        foreach( $array as $ind=>$el ) {
            if ( is_array( $el ) ) {
                $r = array_merge( $r, traverse( $el, $pr . ( is_numeric( $ind ) ? '' : $ind ) ) );
            }else
                if ( is_numeric( $ind ) )
                    $r[] = $pr . $el;
                else
                    $r[] = $pr . $ind . '-' . $el;
        }
        return $r;
}
function variations( $array ){
    if( empty( $array ) ) return [];


    //1. Go through entire array and transform elements that are arrays into elements, collect keys
    $keys = [];$size = 1;
    foreach( $array as $key=>$elems ) {
        if ( is_array( $elems ) ) {
            $rr = [];
            foreach ( $elems as $ind=>$elem ) {
                if ( is_array( $elem ) )
                    $rr = array_merge( $rr, traverse( $elem, $ind ) );
                else $rr[] = $elem;
            }
            $array[ $key ] = $rr;
            $size *= count( $rr );
        }
        $keys[] = $key;
    }

    //2. Go through all new elems and make variations
    $rez = [];
    for( $i = 0; $i < $size; $i++ ) {
        $rez[ $i ] = array();
        foreach( $array as $key => $value ){
            $current = current( $array[ $key ] );
            $rez[ $i ][ $key ] = $current;
        }
        foreach( $keys as $key )
            if( !next( $array[ $key ] ) ) reset( $array[ $key ] );
            else break;
    }

    return $rez;

}
try{
  $i=0;
  foreach ($ids as $id){
      $info=[];
      $query1 = "select * from attribute where id=?";
      $data1 = getData($con,$query1,[$id]);
    foreach($configs as $k=>$config){
      $query2 = "select * from attribute_config where attribute_id=? and id = ?";
      $data2 = getData($con,$query2,[$id,$config]);
      if(count($data2) > 0){
        $info[] = $data2[0];
        $allname[$i][]= $data2[0]['value'];
        $allID[$data1[0]['id']][]= $data2[0]['id'];
        unset($configs[$k]);
      }

    }
    $data[] = ['attribute'=>$data1[0],'config'=>$info];
    $success="1";
    $i++;
  }
  foreach($data as $val){
    if(count($val['config']) > 0){
     $rows *= count($val['config']);
     $d[]= count($val['config']);
    }
  }
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}

echo json_encode(["success"=>$success,"data"=>$data,
               "table"=>$allname,'veiw'=>variations($allname),
               "tableID"=>$allID,'veiwID'=>variations($allID),'rows'=>$rows
               ]);
?>