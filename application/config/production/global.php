<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//$config['assets_url'] = "http://120.108.113.38/conf/assets/";
$config['version'] = "1.7.20"; // 系統版本號
$config['site_name'] = "亞大研討會系統";
$config['recaptcha_sitekey'] = "6LdJ7BgTAAAAADSWKs_T-3otWVIFu1sSMy5GnZGN";
$config['recaptcha_secretkey'] = "6LdJ7BgTAAAAAOug5BFczQ725wz1v9uUxIerUYR1";
$config['spage']=array("index","news","main","dashboard","submit","topic","reviewer");

$config['subdomain'] = true;

$config['insert_id_expire'] = 30; // minitutes
$config['country_list']['zhtw']=array(
	"RE"=>"Reunion",
	"BT"=>"不丹",
	"CN"=>"中國",
	"CF"=>"中非共和國",
	"DK"=>"丹麥",
	"AM"=>"亞美尼亞",
	"AZ"=>"亞賽拜然",
	"IL"=>"以色列",
	"IQ"=>"伊拉克",
	"IR"=>"伊朗",
	"RU"=>"俄羅斯",
	"BG"=>"保加利亞",
	"HR"=>"克羅埃西亞",
	"IS"=>"冰島",
	"LI"=>"列支敦士登",
	"LY"=>"利比亞",
	"CG"=>"剛果",
	"CD"=>"剛果 - 民主共和國",
	"GA"=>"加彭",
	"CA"=>"加拿大",
	"GZ"=>"加薩走廊",
	"HU"=>"匈牙利",
	"KP"=>"北韓",
	"MP"=>"北馬里亞納群島",
	"TT"=>"千里達與托貝哥共和國",
	"GS"=>"南喬治亞及南三明治群島",
	"AQ"=>"南極洲",
	"ZA"=>"南非",
	"KR"=>"南韓",
	"QA"=>"卡達",
	"ID"=>"印尼",
	"IN"=>"印度",
	"ER"=>"厄利垂亞",
	"EC"=>"厄瓜多",
	"CU"=>"古巴",
	"CC"=>"可可斯群島",
	"TW"=>"台灣",
	"SZ"=>"史瓦濟蘭",
	"DJ"=>"吉布地",
	"KG"=>"吉爾吉斯",
	"KI"=>"吉里巴斯",
	"KZ"=>"哈薩克",
	"CO"=>"哥倫比亞",
	"CR"=>"哥斯達黎加",
	"CM"=>"喀麥隆",
	"GE"=>"喬治亞",
	"TM"=>"土庫曼",
	"TV"=>"土瓦魯",
	"TR"=>"土耳其",
	"IM"=>"地曼島",
	"TZ"=>"坦尚尼亞",
	"EG"=>"埃及",
	"TJ"=>"塔吉克",
	"SN"=>"塞內加爾",
	"SC"=>"塞席爾",
	"CS"=>"塞爾維亞蒙特內哥羅",
	"MX"=>"墨西哥",
	"TG"=>"多哥",
	"DM"=>"多明尼克",
	"DO"=>"多明尼加共和國",
	"NG"=>"奈及利亞",
	"AT"=>"奧地利",
	"VE"=>"委內瑞拉",
	"BD"=>"孟加拉",
	"AO"=>"安哥拉",
	"AG"=>"安地卡及巴布達",
	"AI"=>"安歸拉島",
	"AD"=>"安道爾共和國",
	"HN"=>"宏都拉斯",
	"FM"=>"密可羅尼西亞 - 聯邦",
	"LA"=>"寮國",
	"NI"=>"尼加拉瓜",
	"NE"=>"尼日",
	"NP"=>"尼泊爾",
	"BS"=>"巴哈馬",
	"PK"=>"巴基斯坦",
	"PG"=>"巴布亞紐幾內亞",
	"PY"=>"巴拉圭",
	"PA"=>"巴拿馬",
	"BH"=>"巴林",
	"BR"=>"巴西",
	"BB"=>"巴貝多",
	"BF"=>"布吉納法索",
	"BV"=>"布干維島",
	"GR"=>"希臘",
	"PW"=>"帛琉",
	"GN"=>"幾內亞",
	"GW"=>"幾內亞比索",
	"DE"=>"德國",
	"IT"=>"意大利",
	"EE"=>"愛沙尼亞",
	"IE"=>"愛爾蘭",
	"SB"=>"所羅門群島",
	"TK"=>"托克勞群島",
	"LV"=>"拉脫維亞",
	"NO"=>"挪威",
	"CZ"=>"捷克共和國",
	"MA"=>"摩洛哥",
	"MD"=>"摩爾多瓦",
	"MC"=>"摩納哥",
	"SY"=>"敘利亞",
	"VA"=>"教廷 (梵蒂岡城)",
	"FJ"=>"斐濟",
	"SK"=>"斯洛伐克",
	"SI"=>"斯洛維尼亞",
	"SJ"=>"斯瓦巴德群島",
	"LK"=>"斯里蘭卡",
	"SG"=>"新加坡",
	"NC"=>"新喀里多尼亞",
	"JP"=>"日本",
	"CL"=>"智利",
	"TO"=>"東加",
	"TP"=>"東帝汶",
	"TL"=>"東帝汶",
	"TD"=>"查德",
	"KH"=>"柬埔寨",
	"GG"=>"根西島",
	"GD"=>"格瑞那達",
	"GL"=>"格陵蘭",
	"MU"=>"模里西斯",
	"BE"=>"比利時",
	"BN"=>"汶萊",
	"SA"=>"沙地阿拉伯",
	"FR"=>"法國",
	"TF"=>"法國南方和南極洲",
	"GF"=>"法屬圭亞那",
	"PF"=>"法屬波里尼西亞",
	"FO"=>"法羅群島",
	"PR"=>"波多黎克",
	"BA"=>"波斯尼亞 - 赫塞哥維納",
	"BW"=>"波札那",
	"PL"=>"波蘭",
	"TH"=>"泰國",
	"HT"=>"海地",
	"JE"=>"澤西島",
	"AU"=>"澳洲",
	"MO"=>"澳門特別行政區",
	"UA"=>"烏克蘭",
	"UG"=>"烏干達",
	"UY"=>"烏拉圭",
	"UZ"=>"烏茲別克",
	"JM"=>"牙買加",
	"TC"=>"特克斯和凱科斯群島",
	"SL"=>"獅子山",
	"BO"=>"玻利維亞",
	"SE"=>"瑞典",
	"CH"=>"瑞士",
	"GT"=>"瓜地馬拉",
	"GP"=>"瓜達羅普",
	"WF"=>"瓦利斯群島和富圖納群島",
	"GM"=>"甘比亞",
	"BY"=>"白俄羅斯",
	"BM"=>"百慕達",
	"PN"=>"皮特凱恩群島",
	"RW"=>"盧旺達",
	"LU"=>"盧森堡",
	"GI"=>"直布羅陀",
	"PE"=>"祕魯",
	"FK"=>"福克蘭群島 (馬爾維納斯群島)",
	"CK"=>"科克群島",
	"KW"=>"科威特",
	"KM"=>"科摩洛",
	"TN"=>"突尼西亞",
	"LT"=>"立陶宛",
	"JO"=>"約旦",
	"PS"=>"約旦河西岸",
	"NA"=>"納米比亞",
	"NU"=>"紐埃島",
	"NZ"=>"紐西蘭",
	"SO"=>"索馬利亞",
	"CV"=>"維德角",
	"MM"=>"緬甸",
	"RO"=>"羅馬尼亞",
	"US"=>"美國",
	"UM"=>"美國本土外小島嶼",
	"VI"=>"美屬維爾京群島",
	"AS"=>"美屬薩摩亞",
	"KN"=>"聖克里斯多福",
	"PM"=>"聖匹島",
	"ST"=>"聖多美普林西比",
	"VC"=>"聖文森與格瑞那丁",
	"CX"=>"聖誕島",
	"SH"=>"聖赫勒拿島",
	"LC"=>"聖路西亞",
	"SM"=>"聖馬力諾",
	"KE"=>"肯亞",
	"FI"=>"芬蘭",
	"GB"=>"英國",
	"IO"=>"英屬印度洋領地",
	"VG"=>"英屬維爾京群島",
	"MR"=>"茅利塔尼亞",
	"AN"=>"荷屬安地列斯群島",
	"NL"=>"荷蘭",
	"MZ"=>"莫桑比克",
	"PH"=>"菲律賓",
	"VU"=>"萬那杜",
	"YE"=>"葉門",
	"PT"=>"葡萄牙",
	"MN"=>"蒙古",
	"MS"=>"蒙特色納島",
	"BI"=>"蒲隆地",
	"GY"=>"蓋亞那",
	"WS"=>"薩摩斯島",
	"SV"=>"薩爾瓦多",
	"SD"=>"蘇丹",
	"SR"=>"蘇利南",
	"ET"=>"衣索比亞",
	"EH"=>"西撒哈拉",
	"ES"=>"西班牙",
	"NF"=>"諾福克島",
	"NR"=>"諾魯",
	"CI"=>"象牙海岸",
	"BJ"=>"貝南",
	"BZ"=>"貝里斯",
	"LR"=>"賴比瑞亞",
	"LS"=>"賴索托",
	"CY"=>"賽普勒斯",
	"ZM"=>"贊比亞",
	"GQ"=>"赤道幾內亞",
	"HM"=>"赫德島及麥當勞群島",
	"VN"=>"越南",
	"ZW"=>"辛巴威",
	"GH"=>"迦納",
	"KY"=>"開曼群島",
	"GU"=>"關島",
	"AF"=>"阿富汗",
	"AE"=>"阿拉伯聯合大公國",
	"OM"=>"阿曼",
	"AR"=>"阿根廷",
	"DZ"=>"阿爾及利亞",
	"AL"=>"阿爾巴尼亞",
	"AW"=>"阿魯巴島",
	"HK"=>"香港",
	"MQ"=>"馬丁尼克島",
	"MY"=>"馬來西亞",
	"MK"=>"馬其頓 - 前南斯拉夫共和國",
	"ML"=>"馬利",
	"MW"=>"馬拉威",
	"MH"=>"馬歇爾群島",
	"MT"=>"馬爾他",
	"MV"=>"馬爾地夫",
	"YT"=>"馬約特島",
	"MG"=>"馬達加斯加",
	"LB"=>"黎巴嫩"
);

$config['country_list']['en']=array(
	"AF"=>"Afghanistan",
	"AL"=>"Albania",
	"DZ"=>"Algeria",
	"AS"=>"American Samoa",
	"AD"=>"Andorra",
	"AO"=>"Angola",
	"AI"=>"Anguilla",
	"AQ"=>"Antarctica",
	"AG"=>"Antigua and Barbuda",
	"AR"=>"Argentina",
	"AM"=>"Armenia",
	"AW"=>"Aruba",
	"AU"=>"Australia",
	"AT"=>"Austria",
	"AZ"=>"Azerbaijan",
	"BS"=>"Bahamas",
	"BH"=>"Bahrain",
	"BD"=>"Bangladesh",
	"BB"=>"Barbados",
	"BY"=>"Belarus",
	"BE"=>"Belgium",
	"BZ"=>"Belize",
	"BJ"=>"Benin",
	"BM"=>"Bermuda",
	"BT"=>"Bhutan",
	"BO"=>"Bolivia",
	"BA"=>"Bosnia and Herzegovina",
	"BW"=>"Botswana",
	"BV"=>"Bouvet Island",
	"BR"=>"Brazil",
	"IO"=>"British Indian Ocean Territory",
	"VG"=>"British Virgin Islands",
	"BN"=>"Brunei",
	"BG"=>"Bulgaria",
	"BF"=>"Burkina Faso",
	"BI"=>"Burundi",
	"KH"=>"Cambodia",
	"CM"=>"Cameroon",
	"CA"=>"Canada",
	"CV"=>"Cape Verde",
	"KY"=>"Cayman Islands",
	"CF"=>"Central African Republic",
	"TD"=>"Chad",
	"CL"=>"Chile",
	"CN"=>"China",
	"CX"=>"Christmas Island",
	"CC"=>"Cocos (Keeling) Islands",
	"CO"=>"Colombia",
	"KM"=>"Comoros",
	"CG"=>"Congo",
	"CD"=>"Congo - Democratic Republic of",
	"CK"=>"Cook Islands",
	"CR"=>"Costa Rica",
	"CI"=>"Cote d'Ivoire",
	"HR"=>"Croatia",
	"CU"=>"Cuba",
	"CY"=>"Cyprus",
	"CZ"=>"Czech Republic",
	"DK"=>"Denmark",
	"DJ"=>"Djibouti",
	"DM"=>"Dominica",
	"DO"=>"Dominican Republic",
	"TP"=>"East Timor",
	"EC"=>"Ecuador",
	"EG"=>"Egypt",
	"SV"=>"El Salvador",
	"GQ"=>"Equitorial Guinea",
	"ER"=>"Eritrea",
	"EE"=>"Estonia",
	"ET"=>"Ethiopia",
	"FK"=>"Falkland Islands (Islas Malvinas)",
	"FO"=>"Faroe Islands",
	"FJ"=>"Fiji",
	"FI"=>"Finland",
	"FR"=>"France",
	"GF"=>"French Guyana",
	"PF"=>"French Polynesia",
	"TF"=>"French Southern and Antarctic Lands",
	"GA"=>"Gabon",
	"GM"=>"Gambia",
	"GZ"=>"Gaza Strip",
	"GE"=>"Georgia",
	"DE"=>"Germany",
	"GH"=>"Ghana",
	"GI"=>"Gibraltar",
	"GR"=>"Greece",
	"GL"=>"Greenland",
	"GD"=>"Grenada",
	"GP"=>"Guadeloupe",
	"GU"=>"Guam",
	"GT"=>"Guatemala",
	"GG"=>"Guernsey",
	"GN"=>"Guinea",
	"GW"=>"Guinea-Bissau",
	"GY"=>"Guyana",
	"HT"=>"Haiti",
	"HM"=>"Heard Island and McDonald Islands",
	"VA"=>"Holy See (Vatican City)",
	"HN"=>"Honduras",
	"HK"=>"Hong Kong",
	"HU"=>"Hungary",
	"IS"=>"Iceland",
	"IN"=>"India",
	"ID"=>"Indonesia",
	"IR"=>"Iran",
	"IQ"=>"Iraq",
	"IE"=>"Ireland",
	"IM"=>"Isle of Man",
	"IL"=>"Israel",
	"IT"=>"Italy",
	"JM"=>"Jamaica",
	"JP"=>"Japan",
	"JE"=>"Jersey",
	"JO"=>"Jordan",
	"KZ"=>"Kazakhstan",
	"KE"=>"Kenya",
	"KI"=>"Kiribati",
	"KW"=>"Kuwait",
	"KG"=>"Kyrgyzstan",
	"LA"=>"Laos",
	"LV"=>"Latvia",
	"LB"=>"Lebanon",
	"LS"=>"Lesotho",
	"LR"=>"Liberia",
	"LY"=>"Libya",
	"LI"=>"Liechtenstein",
	"LT"=>"Lithuania",
	"LU"=>"Luxembourg",
	"MO"=>"Macau",
	"MK"=>"Macedonia - The Former Yugoslav Republic of",
	"MG"=>"Madagascar",
	"MW"=>"Malawi",
	"MY"=>"Malaysia",
	"MV"=>"Maldives",
	"ML"=>"Mali",
	"MT"=>"Malta",
	"MH"=>"Marshall Islands",
	"MQ"=>"Martinique",
	"MR"=>"Mauritania",
	"MU"=>"Mauritius",
	"YT"=>"Mayotte",
	"MX"=>"Mexico",
	"FM"=>"Micronesia - Federated States of",
	"MD"=>"Moldova",
	"MC"=>"Monaco",
	"MN"=>"Mongolia",
	"MS"=>"Montserrat",
	"MA"=>"Morocco",
	"MZ"=>"Mozambique",
	"MM"=>"Myanmar",
	"NA"=>"Namibia",
	"NR"=>"Nauru",
	"NP"=>"Nepal",
	"NL"=>"Netherlands",
	"AN"=>"Netherlands Antilles",
	"NC"=>"New Caledonia",
	"NZ"=>"New Zealand",
	"NI"=>"Nicaragua",
	"NE"=>"Niger",
	"NG"=>"Nigeria",
	"NU"=>"Niue",
	"NF"=>"Norfolk Island",
	"MP"=>"Northern Mariana Islands",
	"KP"=>"North Korea",
	"NO"=>"Norway",
	"OM"=>"Oman",
	"PK"=>"Pakistan",
	"PW"=>"Palau",
	"PA"=>"Panama",
	"PG"=>"Papua New Guinea",
	"PY"=>"Paraguay",
	"PE"=>"Peru",
	"PH"=>"Philippines",
	"PN"=>"Pitcairn Islands",
	"PL"=>"Poland",
	"PT"=>"Portugal",
	"PR"=>"Puerto Rico",
	"QA"=>"Qatar",
	"RE"=>"Reunion",
	"RO"=>"Romania",
	"RU"=>"Russia",
	"RW"=>"Rwanda",
	"KN"=>"Saint Kitts and Nevis",
	"LC"=>"Saint Lucia",
	"VC"=>"Saint Vincent and the Grenadines",
	"WS"=>"Samoa",
	"SM"=>"San Marino",
	"ST"=>"Sao Tome and Principe",
	"SA"=>"Saudi Arabia",
	"SN"=>"Senegal",
	"CS"=>"Serbia and Montenegro",
	"SC"=>"Seychelles",
	"SL"=>"Sierra Leone",
	"SG"=>"Singapore",
	"SK"=>"Slovakia",
	"SI"=>"Slovenia",
	"SB"=>"Solomon Islands",
	"SO"=>"Somalia",
	"ZA"=>"South Africa",
	"GS"=>"South Georgia and the South Sandwich Islands",
	"KR"=>"South Korea",
	"ES"=>"Spain",
	"LK"=>"Sri Lanka",
	"SH"=>"St. Helena",
	"PM"=>"St. Pierre and Miquelon",
	"SD"=>"Sudan",
	"SR"=>"Suriname",
	"SJ"=>"Svalbard",
	"SZ"=>"Swaziland",
	"SE"=>"Sweden",
	"CH"=>"Switzerland",
	"SY"=>"Syria",
	"TW"=>"Taiwan",
	"TJ"=>"Tajikistan",
	"TZ"=>"Tanzania",
	"TH"=>"Thailand",
	"TL"=>"Timor-Leste",
	"TG"=>"Togo",
	"TK"=>"Tokelau",
	"TO"=>"Tonga",
	"TT"=>"Trinidad and Tobago",
	"TN"=>"Tunisia",
	"TR"=>"Turkey",
	"TM"=>"Turkmenistan",
	"TC"=>"Turks and Caicos Islands",
	"TV"=>"Tuvalu",
	"UG"=>"Uganda",
	"UA"=>"Ukraine",
	"AE"=>"United Arab Emirates",
	"GB"=>"United Kingdom",
	"US"=>"United States",
	"UM"=>"United States Minor Outlying Islands",
	"VI"=>"United States Virgin Islands",
	"UY"=>"Uruguay",
	"UZ"=>"Uzbekistan",
	"VU"=>"Vanuatu",
	"VE"=>"Venezuela",
	"VN"=>"Vietnam",
	"WF"=>"Wallis and Futuna",
	"PS"=>"West Bank",
	"EH"=>"Western Sahara",
	"YE"=>"Yemen",
	"ZM"=>"Zambia",
	"ZW"=>"Zimbabwe",
);