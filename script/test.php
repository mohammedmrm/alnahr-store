<?php
$arr = [
    'size'  => [ 'XS', 'S', 'M' ],
    'color' => [ 'yellow', 'brown', 'white' ],
    'weight'=> ['light','normal','heavy']
];
echo "<pre>";
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

print_r(variations($arr));
echo "</pre>";
?>