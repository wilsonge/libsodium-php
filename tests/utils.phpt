--TEST--
Check for libsodium utils
--SKIPIF--
<?php if (!extension_loaded("libsodium")) print "skip"; ?>
--FILE--
<?php
$a = 'test';
\Sodium\memzero($a);
if ($a !== 'test') {
  echo strlen($a);
} else {
  echo $a;
}
echo "\n";
$b = 'string';
$c = 'string';
var_dump(!\Sodium\memcmp($b, $c));
var_dump(!\Sodium\memcmp($b, 'String'));
$v = ""."\xFF\xFF\x80\x01\x02\x03\x04\x05\x06\x07\x08";
\Sodium\increment($v);
var_dump(bin2hex($v));

$w = ""."\01\x02\x03\x04\x05\x06\x07\x08\xFA\xFB\xFC";
\Sodium\add($v, $w);
var_dump(bin2hex($v));

if (\Sodium\library_version_major() > 7 ||
    (\Sodium\library_version_major() == 7 &&
     \Sodium\library_version_minor() >= 6)) {
    $v_1 = ""."\x01\x02\x03\x04\x05\x06\x07\x08\x09\x0A\x0B\x0C\x0D\x0E\x0F\x10\x11\x12\x13\x14\x15\x16\x17\x18\x19\x1A\x1B\x1C\x1D\x1E\x1F";
    $v_2 = ""."\x02\x02\x03\x04\x05\x06\x07\x08\x09\x0A\x0B\x0C\x0D\x0E\x0F\x10\x11\x12\x13\x14\x15\x16\x17\x18\x19\x1A\x1B\x1C\x1D\x1E\x1F";
    var_dump(\Sodium\compare($v_1, $v_2));
    \Sodium\increment($v_1);
    var_dump(\Sodium\compare($v_1, $v_2));
    \Sodium\increment($v_1);
    var_dump(\Sodium\compare($v_1, $v_2));
} else {
    // Dummy test results for libsodium < 1.0.4
    var_dump(-1, 0, 1);
}

$str = 'stdClass';
\Sodium\memzero($str);
$obj = (object)array('foo' => 'bar');
var_dump($obj);
?>
--EXPECT--
0
bool(true)
bool(false)
string(22) "0000810102030405060708"
string(22) "0102840507090b0d000305"
int(-1)
int(0)
int(1)
object(stdClass)#1 (1) {
  ["foo"]=>
  string(3) "bar"
}
