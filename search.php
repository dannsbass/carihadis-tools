<?php
/**
 * script untuk mencari hadis melalui CLI dari file "database_hadis" yang di-generate dengan script db_generator.php
 */
$kata_kunci = readline("Masukkan kata yang mau dicari: ");
$awal = microtime(true);
$konten = file('database_hadis');
// echo count($konten); die;
$harokat = array("َ", "ِ", "ُ", "ً", "ٍ", "ٌ", "ْ", "ّ");
$kata_kunci = str_replace($harokat, "", $kata_kunci);
$hasil = [];
foreach ($konten as $key => $value) {
    if(strpos(str_replace($harokat,'',$value),$kata_kunci)){
        $hasil[] = $value;
    }
}
$hasil = array_map('newLine',$hasil);
function newLine($string){
    return str_replace('|',"\n",trim($string));
}
print_r($hasil);
$akhir = microtime(true);
echo "\nwaktu: " . ($akhir - $awal) . "\n";
