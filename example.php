<?php
function ods2array( $file ) {
    $zip = new ZipArchive();
    $zip->open( $file, ZipArchive::CREATE );
    $zip_content = $zip->getStream( 'content.xml' );
    
    $contents = '';
    while( !feof( $zip_content ) ) {
        $contents .= fread( $zip_content, 2 );
    }
    
    fclose( $zip_content );
    $zip->close();

    $xml_document = new DOMDocument();
    $xml_document->loadXML( $contents );
    $xml = $xml_document->getElementsByTagName( 'table-row' );
    $xml_array = array();
    
    foreach ( $xml as $key_rows => $value_rows ) {
        foreach ( $value_rows->childNodes as $key_columns => $value_columns ) {
            $xml_array[ $key_rows ][ $key_columns ] = $value_columns->textContent;
        }
    }

    return $xml_array;
}

var_dump( ods2array( 'example.ods' ) );