<?php
require __DIR__ . '/vendor/autoload.php';

use Carbon\Carbon;

printf("Right now is %s", Carbon::now()->toDateTimeString());
print("<br>");

printf("Right now in Vancouver is %s", Carbon::now('America/Vancouver'));  //implicit __toString()
print("<br>");

$tomorrow = Carbon::now()->addDay();
$lastWeek = Carbon::now()->subWeek();
$nextSummerOlympics = Carbon::createFromDate(2016)->addYears(4);

$officialDate = Carbon::now()->toRfc2822String();

$howOldAmI = Carbon::createFromDate(1975, 5, 21)->age;

$noonTodayLondonTime = Carbon::createFromTime(12, 0, 0, 'Europe/London');

$internetWillBlowUpOn = Carbon::create(2038, 01, 19, 3, 14, 7, 'GMT');

// Don't really want this to happen so mock now
Carbon::setTestNow(Carbon::createFromDate(2000, 1, 1));

// comparisons are always done in UTC
if (Carbon::now()->gte($internetWillBlowUpOn)) {
    die();
}

// Phew! Return to normal behaviour
Carbon::setTestNow();

if (Carbon::now()->isWeekend()) {
    echo 'Party!';
}
// Over 200 languages (and over 500 regional variants) supported:
echo Carbon::now()->subMinutes(2);
print("<br>");
echo Carbon::now()->subMinutes(2)->diffForHumans(); // '2 minutes ago'
print("<br>");

//echo Carbon::now()->subMinutes(2)->locale('zh_CN')->diffForHumans(); // '2分钟前'
//print("<br>");

echo Carbon::parse('2019-07-23 14:51')->isoFormat('LLLL'); // 'Tuesday, July 23, 2019 2:51 PM'
print("<br>");

echo Carbon::parse('2019-07-23 14:51')->locale('fr_FR')->isoFormat('LLLL'); // 'mardi 23 juillet 2019 14:51'
print("<br>");

echo Carbon::parse('2019-07-23 14:51')->locale('nl_NL')->isoFormat('LLLL'); // 'dinsdag 23 juli 2019 14:51'
print("<br>");

// ... but also does 'from now', 'after' and 'before'
// rolling up to seconds, minutes, hours, days, months, years

$daysSinceEpoch = Carbon::createFromTimestamp(0)->diffInDays();
echo $daysSinceEpoch . " dagen sinds 1 januari 1970";
print("<br>");
