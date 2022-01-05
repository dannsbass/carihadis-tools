<?php
/**
 * script untuk mengolah file plaintext database berukuran besar menjadi chunk kecil2
 */
$file = 'msgstore.db.crypt14';
$filesize = get_file_size($file);
$fp = @fopen($file, "r");
$chunk_size = (1<<24); // 16MB arbitrary
$position = 0;

// if handle $fp to file was created, go ahead
if ($fp) {
   while(!feof($fp)){
      // move pointer to $position in file
      fseek($fp, $position);

      // take a slice of $chunk_size bytes
      $chunk = fread($fp,$chunk_size);

      // searching the end of last full text line (or get remaining chunk)
      if ( !($last_lf_pos = strrpos($chunk, "\n")) ) $last_lf_pos = mb_strlen($chunk);

      // $buffer will contain full lines of text
      // starting from $position to $last_lf_pos
      $buffer = mb_substr($chunk,0,$last_lf_pos);
      echo strlen($buffer)."\n";
      
      ////////////////////////////////////////////////////
      //// ... DO SOMETHING WITH THIS BUFFER HERE ... ////
      ////////////////////////////////////////////////////

      // Move $position
      $position += $last_lf_pos;

      // if remaining is less than $chunk_size, make $chunk_size equal remaining
      if(($position+$chunk_size) > $filesize) $chunk_size = $filesize-$position;
      $buffer = NULL;
   }
   fclose($fp);
}
function get_file_size ($file) {
   $fp = @fopen($file, "r");
   @fseek($fp,0,SEEK_END);
   $filesize = @ftell($fp);
   fclose($fp);
   return $filesize;
}